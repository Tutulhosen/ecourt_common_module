<?php

namespace App\Http\Controllers;

use App\Repositories\OrganizationCaseMappingRepository;
use App\Rules\IsEnglish;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Traits\TokenVerificationTrait;


class OrganizationManagementController extends Controller
{
    use TokenVerificationTrait;

    public function get_organization_change_by_applicant()
    {
        $data['page_title'] = 'প্রাতিষ্ঠানিক প্রতিনিধির প্রতিষ্ঠান পরিবর্তন ফরম';

        $data['division'] = DB::table('division')->get();
        $data['division'] = DB::table('division')->get();
        $data['division'] = DB::table('division')->get();
        return view('organization._change_office_applicant')->with($data);
    }
    public function post_organization_change_by_applicant(Request $request)
    {
        $case_cout = OrganizationCaseMappingRepository::employeeOrgizationCaseMappingOnTrasferValidation();

        // dd($case_cout,globalUserInfo()->office_id);

        if ($case_cout > 1) {
            $trasfer_flag = true;
        } else {
            $trasfer_flag = false;
        }
        if (!$trasfer_flag) {
            return redirect()->back()->with('organization_case_error', 'আপনি আপনার বর্তমান প্রতিষ্ঠানে চলমান মামলা গুলোর জন্য প্রতিনিধি যোগ করলে , আপনি আপনার নতুন প্রতিষ্ঠানে পরিবর্তন করতে পারবেন');
        }
        // dd($trasfer_flag);

        $request->validate(
            [

                'organization_id' => ['required', new IsEnglish()],
                'division_id' => 'required',
                'district_id' => 'required',
                'upazila_id' => 'required',
                'organization_type' => 'required',
                'office_name_bn' => 'required',
                'office_name_en' => ['required', new IsEnglish()],
                'organization_physical_address' => 'required',
                'designation' => 'required',
                'organization_employee_id' => 'required'
            ],
            [
                'organization_id.required' => 'রাউটিং নং দিতে হবে',
                'division_id.required' => 'বিভাগ নির্বাচন করুন',
                'district_id.required' => 'জেলা নির্বাচন করুন',
                'upazila_id.required' => 'উপজেলা নির্বাচন করুন',
                'organization_type.required' => 'প্রতিষ্ঠানের ধরন নির্বাচন করুন',
                'office_name_bn.required' => 'প্রতিষ্ঠানের নাম বাংলাতে দিন',
                'office_name_en.required' => 'প্রতিষ্ঠানের নাম ইংরেজিতে দিন',
                'organization_physical_address.required' => 'প্রতিষ্ঠানের ঠিকানা দিন',
                'designation.required' => 'পদবী দিতে হবে',
                'organization_employee_id.required' => 'প্রতিনিধির EmployeeID দিতে হবে'
            ],
        );
       
        $data = globalUserInfo();

        $url = getapiManagerBaseUrl() . '/api/v1/post/organization/change/applicant';
        $method = 'POST';
        $bodyData = json_encode($data);
        $token = $this->verifySiModuleToken('WEB');

        // dd('setting crpc', $bodyData);
        if ($token) {
            $res = makeCurlRequestWithToken($url, $method, $bodyData, $token);
            // dd('change role', $res->success);
            // exit;
            if($res->success){
                if ($request->office_id == "OTHERS") {
    
                    $office['office_name_bn'] = $request->office_name_bn;
                    $office['office_name_en'] = $request->office_name_en;
                    $office['division_id'] = $request->division_id;
                    $office['district_id'] = $request->district_id;
                    $office['upazila_id'] = $request->upazila_id;
                    $office['organization_type'] = $request->organization_type;
                    $office['organization_physical_address'] = $request->organization_physical_address;
                    $office['organization_routing_id'] = $request->organization_id;
                    $office['is_organization'] = 1;
        
                    $office_id = DB::table('office')->insertGetId($office);
                } else {
                    $office_id = $request->office_id;
                }
                DB::table('users')->where('id', globalUserInfo()->id)->update([
                    'designation' => $request->designation,
                    'office_id' => $office_id
                ]);
                return redirect()->route('dashboard.index')->with('success', 'আপনার প্রোফাইলে প্রতিষ্ঠান সঠিকভাবে আপডেট হয়েছে');
            }else{
                return redirect()->back()->with('organization_case_error', 'Something went wrong!!!');

            }
        }else{
            return redirect()->back()->with('organization_case_error', 'Something went wrong!!!');
        }

        // OrganizationCaseMappingRepository::employeeOrgizationCaseMappingOnTrasfer($office_id);

        return redirect()->route('dashboard')->with('success', 'আপনার প্রোফাইলে প্রতিষ্ঠান সঠিকভাবে আপডেট হয়েছে');
    }
}
