<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LocationController extends Controller
{
    //
    public function division(){

        $data = array();
        $subcategories = DB::table("geo_divisions")->get();
        foreach ($subcategories as $t) {
            $data[] = array('code' => $t->id, 'desc' => $t->division_name_bng);
        }
        return json_encode($data);
    }
    public function zilla($id){
        $data = array();
        $subcategories = DB::table("geo_districts")->where("geo_division_id",$id)->get();
        foreach ($subcategories as $t) {
            $data[] = array('code' => $t->id, 'desc' => $t->district_name_bng);
        }
        return json_encode($data);
    }
    public function upazilla($id){
        $data = array();
        $subcategories = DB::table("geo_upazilas")->where("geo_district_id",$id)->get();

        foreach ($subcategories as $t) {
            $data[] = array('code' => $t->id, 'desc' => $t->upazila_name_bng);
        }
        return json_encode($data);
    }
    public function citycorporation($id){
        $data = array();
        $subcategories = DB::table("geo_city_corporations")->where("geo_district_id",$id)->get();
       
        foreach ($subcategories as $t) {
            $data[] = array('code' => $t->id, 'desc' => $t->city_corporation_name_bng);
        }
        return json_encode($data);

    }
    public function metropolitan($id){

       
        $data = array();
        $subcategories = DB::table("geo_metropolitan")->where("geo_district_id",$id)->get();
        foreach ($subcategories as $t) {
            $data[] = array('code' => $t->geo_district_id, 'desc' => $t->metropolitan_name_bng);
        }
        return json_encode($data);
    }
    public function thana($id){
        
 
        $data = array();
        $subcategories = DB::table("geo_thanas")->where("geo_district_id",$id)->get();
        foreach ($subcategories as $t) {
            $data[] = array('code' => $t->id, 'desc' => $t->thana_name_bng);
        }
        return json_encode($data); 
    }
}
