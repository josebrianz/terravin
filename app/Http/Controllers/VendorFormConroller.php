namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class VendorFormController extends Controller
{
    public function submit(Request $request)
    {
        $response = Http::post('http://localhost:8080/api/validate-vendor', $request->all());

        if ($response->successful()) {
            return back()->with('status', $response->body());
        }

        return back()->withErrors(['error' => 'Validation server failed.']);
    }
}
