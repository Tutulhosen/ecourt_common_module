<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GeoCityCorporationsController extends Controller
{
    public function  getCityCorporation(Request $request)
    {



        $childs = array();
        $city_corp = true;

        $zillaid = $request->ld;
        // return $zillaid;
        $tmp = array();
        if ($zillaid) {
            $tmp = DB::table('geo_city_corporations')->where('geo_district_id', $zillaid)->get();
        }


        foreach ($tmp as $t) {
            $childs[] = array('id' => $t->id, 'name' => $t->city_corporation_name_bng, 'title' => "");
        }

        return response()->json($childs);
    }
}
