<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class McCitizenPublicViewController extends Controller
{

    public function new()
    {
        // Clear any stored session parameters (if applicable)
        session()->forget('parameters');

        // Fetch data using Eloquent ORM
        $divisions = DB::table('division')->get();
        $caseTypes = DB::table('case_type')->get();

        // Prepare empty arrays for other models
        $zilla = [];
        $upazila = [];
        $geoCityCorporations = [];
        $geoMetropolitan = [];
        $geoThanas = [];

        // Pass the data to the view
        return view('mc_citizen_public_view.new', [
            'division' => $divisions,
            'zilla' => $zilla,
            'upazila' => $upazila,
            'GeoCityCorporations' => $geoCityCorporations,
            'GeoMetropolitan' => $geoMetropolitan,
            'GeoThanas' => $geoThanas,
            'CaseType' => $caseTypes
        ]);
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

    public function create(Request $request)
    {

        $url = getapiManagerBaseUrl() . '/api/mc/citizen_public_view/create';
        $data = $request->all();
        // For file upload
        if ($request->has('files')) {
            $request->validate([
                'files.*.someName' => 'mimes:jpeg,png,jpg,pdf,doc,docx|max:5120',
            ]);

            $encodedFiles = [];
            $requestFiles = $request->file('files');

            foreach ($requestFiles as $fileArray) {
                if (isset($fileArray['someName']) && $fileArray['someName']->isValid()) {
                    $base64Encoded = base64_encode(file_get_contents($fileArray['someName']->getRealPath()));
                    $encodedFiles[] = $base64Encoded;
                }
            }
            $data['files'] = $encodedFiles;
        }
        $method = 'POST';
        $bodyData = json_encode($data);
        $res = makeCurlRequestWithToken($url, $method, $bodyData, null);

        if ($res->result) {
            // $res->data->user_idno
            session()->flash('success', $res->data->user_idno);
            return redirect()->route('mc_citizen_public_view.new');  // Retain previous input data
        } else {
            session()->flash('error', 'An error occurred while creating the citizen complain.');
            return redirect()->route('mc_citizen_public_view.new');
        }
    }
    public function search(Request $request)
    {
        $url = getapiManagerBaseUrl() . '/api/mc/citizen_public_view/search';
        $data = $request->all();
        // dd($data);
        // $url = getapiManagerBaseUrl() . '/api/emc/crpc-section/save';
        $method = 'POST';
        $bodyData = json_encode($data);
        $res = makeCurlRequestWithToken($url, $method, $bodyData, null);

        // dd('pulbic search', $res->data);
        return $res;
    }
}
