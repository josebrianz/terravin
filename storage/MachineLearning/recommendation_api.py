from fastapi import FastAPI, Query, HTTPException
from fastapi.middleware.cors import CORSMiddleware
from fastapi.responses import JSONResponse
import pandas as pd
from storage.MachineLearning import recommendation_engine
from fastapi_utils.tasks import repeat_every
import asyncio

app = FastAPI()

app.add_middleware(
    CORSMiddleware,
    allow_origins=["http://127.0.0.1:8000"],  # or ["*"]
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"],
)

# Globals for data
df_live = None
spending_segments = None
preference_segments = None

async def reload_data():
    global df_live, spending_segments, preference_segments
    try:
        df_live = recommendation_engine.load_live_data()
        spending_segments = recommendation_engine.segment_spending_behavior(df_live)
        preference_segments = recommendation_engine.segment_wine_preference(df_live)
        print("✅ Data reload complete.")
    except Exception as e:
        print(f"⚠️ Error during data reload: {e}")
        raise

@app.on_event("startup")
@repeat_every(seconds=600, wait_first=True)  # Every 10 minutes
async def periodic_reload():
    print("🔄 Periodic reload triggered")
    await reload_data()

@app.post("/reload-data")
async def manual_reload():
    try:
        await reload_data()
        return {"message": "Data reload successful"}
    except Exception as e:
        raise HTTPException(status_code=500, detail=f"Reload failed: {str(e)}")

@app.get("/recommend")
def recommend(
    user_id: str = Query(..., description="Customer ID"),
    month: int = Query(..., ge=1, le=12, description="Current month (1-12)"),
    min_recs: int = Query(10, ge=1, le=100, description="Minimum number of recommendations")
):
    if df_live is None:
        return {"recommendations": [], "message": "Data not loaded yet, please try again shortly."}
    recs = recommendation_engine.recommend_wines(user_id, month, df_live, min_recs=min_recs)
    if recs.empty:
        return {"recommendations": []}
    expected_cols = ["item_name", "category", "unit_price", "item_image"]
    for col in expected_cols:
        if col not in recs.columns:
            recs[col] = None
    recs = pd.DataFrame(recs)
    result = recs[expected_cols].to_dict(orient="records")
    return {"recommendations": result}

@app.get("/customer/segment/spending")
def get_spending_segment(customer_id: str = Query(..., description="Customer ID")):
    if spending_segments is None:
        return {"customer_id": customer_id, "spending_segment": None, "message": "Data not loaded yet."}
    customer_data = spending_segments[spending_segments['customer_id'] == customer_id]
    segment = customer_data.iloc[0]['spending_segment_label'] if not customer_data.empty else None
    return {"customer_id": customer_id, "spending_segment": segment}

@app.get("/customer/{customer_id}/wine-preference")
def get_wine_preference(customer_id: str):
    if preference_segments is None:
        return {"customer_id": customer_id, "wine_preference": None, "message": "Data not loaded yet."}
    customer_data = preference_segments[preference_segments['customer_id'] == customer_id]
    preference = customer_data.iloc[0]['preference_segment'] if not customer_data.empty else None
    return {"customer_id": customer_id, "wine_preference": preference}

@app.get("/segments/spending-distribution")
def spending_distribution():
    if spending_segments is None or spending_segments.empty:
        return JSONResponse(content={})
    counts = spending_segments['spending_segment_label'].value_counts().to_dict()
    return JSONResponse(content=counts)

@app.get("/segments/wine-preference-distribution")
def wine_preference_distribution():
    if preference_segments is None or preference_segments.empty:
        return JSONResponse(content={})
    counts = preference_segments['preference_segment_label'].value_counts().to_dict()
    return JSONResponse(content=counts)

@app.get("/segments/spending-aggregate")
def spending_aggregate():
    if spending_segments is None or spending_segments.empty:
        return JSONResponse(content=[])
    agg = spending_segments.groupby('spending_segment_label').agg({
        'total_spent': 'sum',
        'total_quantity': 'sum'
    }).reset_index().rename(columns={'spending_segment_label': 'segment'})
    result = agg.to_dict(orient='records')
    return JSONResponse(content=result)

if __name__ == "__main__":
    import uvicorn
    uvicorn.run(app, host="127.0.0.1", port=5000)
