<?php

namespace App\Http\Controllers\emc;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator,Redirect,Response;

class CourtController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roleID = Auth::user()->role_id;
        $officeInfo = user_office_info();
        //
        $data['page_title'] = ' এক্সিকিউটিভ ম্যাজিস্ট্রেট আদালতের তালিকা';
        if ($roleID == 1 || $roleID == 2 || $roleID == 3 || $roleID == 4 || $roleID == 22 || $roleID == 23  || $roleID == 24 || $roleID == 25) {
            $query = DB::table('emc_court')
                ->leftjoin('division', 'emc_court.division_id', '=', 'division.id')
                ->leftjoin('district', 'emc_court.district_id', '=', 'district.id')
                ->leftjoin('upazila', 'emc_court.upazila_id', '=', 'upazila.id')
                ->select('emc_court.*', 'division.division_name_bn', 'district.district_name_bn', 'upazila.upazila_name_bn');
            if (!empty($_GET['division'])) {
                $query->where('emc_court.division_id', '=', $_GET['division']);
            }
            if (!empty($_GET['district'])) {
                $query->where('emc_court.district_id', '=', $_GET['district']);
            }


            $data['courts'] = $query->paginate(10);

            // dd($courts);
            // Dorpdown
            $data['divisions'] = DB::table('division')->select('id', 'division_name_bn')->get();
        } elseif ($roleID == 5 || $roleID == 6 || $roleID == 7 || $roleID == 8 || $roleID == 13) {
            $data['courts'] = DB::table('court')
                ->join('division', 'court.division_id', '=', 'division.id')
                ->join('district', 'court.district_id', '=', 'district.id')
                ->leftjoin('upazila', 'court.upazila_id', '=', 'upazila.id')
                ->select('court.*', 'division.division_name_bn', 'district.district_name_bn', 'upazila.upazila_name_bn')
                ->where('court.district_id', $officeInfo->district_id)
                ->paginate(10);
        }
        return view('emc_court.court.index')
            ->with('i', (request()->input('page', 1) - 1) * 10)
            ->with('court_page', true)
            ->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roleID = Auth::user()->role_id;
        $officeInfo = user_office_info();
        //
        if ($roleID == 1 || $roleID == 2 || $roleID == 3 || $roleID == 4) {
            $data['division'] = DB::table('division')
                ->select('division.*')
                ->get();

            $data['page_title'] = 'নতুন এক্সিকিউটিভ ম্যাজিস্ট্রেট আদালত এন্ট্রি ফরম';
        } elseif ($roleID == 5 || $roleID == 6 || $roleID == 7 || $roleID == 8 || $roleID == 13) {

            $data['district'] = DB::table('district')
                ->select('district.*')
                ->where('id', $officeInfo->district_id)
                ->get();

            $data['page_title'] = 'নতুন এক্সিকিউটিভ ম্যাজিস্ট্রেট আদালত এন্ট্রি ফরম';
        }

        return view('emc_court.court.add')->with($data);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $roleID = Auth::user()->role_id;
        $officeInfo = user_office_info();
        //
        if ($roleID == 1 || $roleID == 2 || $roleID == 3 || $roleID == 4) {
            $validator = $request->validate([
                'division' => 'required',
                'district' => 'required',
                'court_name' => 'required',
                'level' => 'required',
                'status' => 'required'
            ]);
            DB::table('emc_court')->insert([
                'division_id' => $request->division,
                'district_id' => $request->district,
                'court_name' => $request->court_name,
                'level' => $request->level,
                'status' => $request->status,
            ]);
        } elseif ($roleID == 5 || $roleID == 6 || $roleID == 7 || $roleID == 8 || $roleID == 13) {
            $validator = $request->validate([
                'district' => 'required',
                'court_name' => 'required',
                'status' => 'required'
            ]);
            DB::table('emc_court')->insert([
                'division_id' => $officeInfo->division_id,
                'district_id' => $request->district,
                'court_name' => $request->court_name,
                'status' => $request->status,
            ]);
        }
        return redirect()->route('emc.court')
            ->with('success', 'আদালত সফলভাবে সংরক্ষণ করা হয়েছে');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $data['division'] = DB::table('division')
            ->select('division.*')
            ->get();
        $data['districts'] = DB::table('district')
            ->select('district.*')
            ->get();
        $data['courts'] = DB::table('emc_court')
            ->select('emc_court.*')
            ->where('emc_court.id', $id)
            ->first();
        $data['page_title'] = 'এক্সিকিউটিভ ম্যাজিস্ট্রেট আদালত সংশোধন ফরম';
        return view('emc_court.court.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $validator = $request->validate([
            'division' => 'required',
            'district' => 'required',
            'court_name' => 'required',
            'level' => 'required',
            'status' => 'required'
        ]);
        $data = [
            'division_id' => $request->division,
            'district_id' => $request->district,
            'court_name' => $request->court_name,
            'level' => $request->level,
            'status' => $request->status,
        ];
        DB::table('emc_court')
            ->where('id', $id)
            ->update($data);

        return redirect()->route('emc.court')
            ->with('success', 'আদালত সফলভাবে সংশোধন করা হয়েছে');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //


    }

    public function getDependentDistrict($id)
    {
        $subcategories = DB::table("district")->where("division_id", $id)->pluck("district_name_bn", "id");
        return json_encode($subcategories);
    }
    public function getDependentUpazila($id)
    {
        $subcategories = DB::table("upazila")->where("district_id", $id)->pluck("upazila_name_bn", "id");
        return json_encode($subcategories);
    }
}