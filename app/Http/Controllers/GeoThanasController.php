<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GeoThanasController extends Controller
{
    public function  getthanas(Request $request)
    {

        $childs = array();
        $city_corp = true;

        $metropolitanid = $request->ld;

        $tmp = array();
        if ($metropolitanid) {
            // $tmp = GeoThanas::find("geo_metropolitan_id=" . $metropolitanid);
            $tmp = DB::table('geo_thanas')->where('geo_metropolitan_id', $metropolitanid)->get();
        }

        foreach ($tmp as $t) {
            $childs[] = array('id' => $t->id, 'name' => $t->thana_name_bng, 'title' => "");
        }

        return response()->json($childs);
    }
}
