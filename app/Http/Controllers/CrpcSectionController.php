<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CrpcSectionController extends Controller
{

    public function crpcSections()
    {
        $data['crpc_sections'] = DB::table('crpc_sections')->select('*')->get();

        // dd($data);
        $data['page_title'] = 'ফৌজদারি কার্যবিধি আইনের সংশ্লিষ্ট ধারা';
        return view('setting.crpc_section_list')->with($data);
    }

}