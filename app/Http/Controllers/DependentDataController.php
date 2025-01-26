<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DependentDataController extends Controller
{
    public function getDependentDistrict($id)
    {
        $subcategories = DB::table("district")->where("division_id",$id)->pluck("district_name_bn","id");
        return json_encode($subcategories);
    }

    public function getDependentUpazila($id)
    {
        $subcategories = DB::table("upazila")->where("district_id",$id)->pluck("upazila_name_bn","id");
        return json_encode($subcategories);
    }

    public function getDependentCourt($id)
    {
        $subcategories = DB::table("court")->where("district_id",$id)->pluck("court_name","id");
        return json_encode($subcategories);
    }
    public function getDependentOrganization(Request $request)
    {
        $office_information = DB::table("office")
        ->where("division_id",$request->division_id)
        ->where("district_id",$request->district_id)
        ->where("upazila_id",$request->upazila_id)
        ->where('organization_type',$request->organization_type)
        ->where('status',1)
        ->where('is_organization',1)
        ->select("office_name_bn","id")
        ->get();
      
        return json_encode($office_information);
    }

    public function getdependentOfficeName($id)
    {
        $office_address_routing_no= DB::table("office")->where("id",$id)->select("office_name_bn","office_name_en","organization_physical_address","organization_routing_id")->first();
        return $office_address_routing_no;
    }
}
