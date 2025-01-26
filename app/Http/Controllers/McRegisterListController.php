<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class McRegisterListController extends Controller
{
    public function getzilla(Request $request)
    {
        $childs = [];

        // Check if the request is a POST and AJAX
        if ($request->isMethod('post') && $request->ajax()) {
            $divId = $request->query('ld'); // Get the query parameter

            $tmp = [];
            if ($divId) {
                $tmp = DB::table('district')->where('division_id', $divId)->get(); // Fetch Zilla records
            }

            foreach ($tmp as $t) {
                $childs[] = [
                    'id' => $t->id,
                    'name' => $t->district_name_bn
                ];
            }
        }

        // Return JSON response
        return response()->json($childs);
    }
    public function  getUpazila(Request $request)
    {

        $childs = [];
        $city_corp = false;

        $zillaid = $request->query('ld', 'string');

        // check for city Corporation
        $zilla = DB::table('district')
            ->join('geo_city_corporations', 'geo_city_corporations.geo_district_id', '=', 'district.id')
            ->where('district.id', $zillaid)
            ->first();

        if (!empty($zilla)) {
            $city_corp = true;
        }

        if ($zillaid) {
            $upazilas = DB::table('upazila')
                ->where('upazila.district_id', $zillaid)->get();
        }

        foreach ($upazilas as $upazila) {
            if (!$city_corp) {
                $childs[] = [
                    'id' => $upazila->id,
                    'name' => $upazila->upazila_name_bn,
                    'title' => ""
                ];
            } else {
                $childs[] = [
                    'id' => $upazila->id,
                    'name' => $upazila->upazila_name_bn,
                    'title' => $upazila->upazila_name_en
                ];
            }
        }

        return response()->json($childs);
    }
}
