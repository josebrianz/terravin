<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Vendor;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;

class VendorApplicationController extends Controller
{
    public function create()
    {
        return view('vendor.apply');
    }

    public function submit(Request $request)
    {
        $request->validate([
            'company_name'=>'required|string|max:255',
            'contact_person'=>'required|string|max:255',
            'phone'=>'required|string|max:20',
            'email'=>'required|email',
            'years_in_operation'=>'required|integer|min:0',
            'employees'=>'required|integer|min:1',
            'turnover'=>'required|numeric|min:0',
            'material'=>'required|string',
            'clients'=>'nullable|string',
            'certification_organic'=>'required|in:true,false',
            'certification_iso'=>'required|in:true,false',
            'regulatory_compliance'=>'required|accepted',
            'application_pdf'=>'required|mimes:pdf|max:2048',
        ]);

        $path = $request->file('application_pdf')->store('vendor_pdfs','public');
        $vendor = Vendor::create([
            'user_id'=>Auth::id(),
            'company_name'=>$request->company_name,
            'contact_person'=>$request->contact_person,
            'phone'=>$request->phone,
            'contact_email'=>$request->email,
            'years_in_operation'=>$request->years_in_operation,
            'employees'=>$request->employees,
            'turnover'=>$request->turnover,
            'material'=>$request->material,
            'clients'=>$request->clients,
            'certification_organic'=>$request->certification_organic==='true',
            'certification_iso'=>$request->certification_iso==='true',
            'regulatory_compliance'=>true,
            'validation_status'=>'pending',
            'application_pdf'=>$path,
        ]);

        $client = new Client();
        try {
            $response = $client->post('http://localhost:8082/api/validate', [
                'multipart'=>[
                    ['name'=>'companyName','contents'=>$vendor->company_name],
                    ['name'=>'contactPerson','contents'=>$vendor->contact_person],
                    ['name'=>'phone','contents'=>$vendor->phone],
                    ['name'=>'yearsInOperation','contents'=>$vendor->years_in_operation],
                    ['name'=>'employees','contents'=>$vendor->employees],
                    ['name'=>'turnover','contents'=>$vendor->turnover],
                    ['name'=>'material','contents'=>$vendor->material],
                    ['name'=>'clients','contents'=>$vendor->clients ?? ''],
                    ['name'=>'certificationOrganic','contents'=>$vendor->certification_organic ? 'true' : 'false'],
                    ['name'=>'certificationIso','contents'=>$vendor->certification_iso ? 'true' : 'false'],
                    ['name'=>'regulatoryCompliance','contents'=>'true'],
                    [
                        'name'=>'applicationPdf',
                        'contents'=>fopen(storage_path('app/public/'.$vendor->application_pdf),'r'),
                        'filename'=>basename($vendor->application_pdf),
                        'headers'=>['Content-Type'=>'application/pdf'],
                    ],
                ],
            ]);
            $data=json_decode($response->getBody(),true);

            if($data['status']==='approved'){
                return redirect()->route('vendor.waiting')->with('message','Approved. Visit on ' . ($data['scheduledVisitDate'] ?? 'TBD'));
            }

            return redirect()->back()->withErrors(['Your application was not approved']);

        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['System error: '. $e->getMessage()]);
        }
    }

    public function waiting()
    {
        return view('vendor.waiting');
    }
}
