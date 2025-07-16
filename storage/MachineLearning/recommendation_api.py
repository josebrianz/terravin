from fastapi import FastAPI, Query
from typing import List, Optional
import uvicorn
import pandas as pd
import recommendation_engine

app = FastAPI()

# Load data and profiles once at startup
DATA_PATH = "cleaned_wine_catalog.csv"
df = recommendation_engine.load_data(DATA_PATH)
profiles = recommendation_engine.generate_customer_profiles(df)

@app.get("/recommend")
def recommend(
    user_id: str = Query(..., description="Customer ID"),
    month: int = Query(..., ge=1, le=12, description="Current month (1-12)"),
    min_recs: int = Query(10, ge=1, le=100, description="Minimum number of recommendations")
):
    recs = recommendation_engine.recommend_wines(user_id, month, df, profiles, min_recs=min_recs)
    if recs.empty:
        return {"recommendations": []}
    # Ensure recs is a DataFrame
    expected_cols = ["WINE NAME", "CATEGORY", "PRICE PER UNIT"]
    for col in expected_cols:
        if col not in recs.columns:
            recs[col] = None
    import pandas as pd
    recs = pd.DataFrame(recs)
    result = recs[expected_cols].to_dict(orient="records")  # type: ignore
    return {"recommendations": result}

if __name__ == "__main__":
    uvicorn.run(app, host="127.0.0.1", port=5000)