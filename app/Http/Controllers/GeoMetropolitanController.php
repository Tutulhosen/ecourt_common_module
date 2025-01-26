<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GeoMetropolitanController extends Controller
{
    public function  getmetropolitan(Request $request)
    {

        $childs = array();
        $city_corp = true;

        $zillaid = $request->ld;



        $tmp = array();
        if ($zillaid) {
            // $tmp = GeoMetropolitan::find("district_bbs_code=" . $zillaid);
            $tmp = DB::table('geo_metropolitan')->where('geo_district_id', $zillaid)->get();
        }

        foreach ($tmp as $t) {
            $childs[] = array('id' => $t->id, 'name' => $t->metropolitan_name_bng, 'title' => "");
        }

        return response()->json($childs);
    }
}
