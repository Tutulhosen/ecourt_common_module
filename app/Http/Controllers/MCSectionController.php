<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Traits\TokenVerificationTrait;



class MCSectionController extends Controller
{
   use TokenVerificationTrait;


   public function index()
   {
      $url = getapiManagerBaseUrl() . '/api/mc/section/get';
      $method = 'GET';
      $bodyData = null;
      $token = $this->verifySiModuleToken('WEB');
      // dd($token);
      // dd('setting crpc', $bodyData);
      if ($token) {
         $res = makeCurlRequestWithToken($url, $method, $bodyData, $token);
         if ($res->success == true) {
            $sections = $res->data;
            return view('mobile_court.section.index', compact('sections'));
         } else {
            return redirect()->back()->with('error', 'Something went wrong.');
         }
      }
      return view('mobile_court.section.index');
   }

   public function create()
   {
      // $laws = DB::table('mc_law')->get();
      $url = getapiManagerBaseUrl() . '/api/mc/law/get';
      $method = 'GET';
      $bodyData = null;
      $token = $this->verifySiModuleToken('WEB');
      // dd($token);
      // dd('setting crpc', $bodyData);
      if ($token) {
         $res = makeCurlRequestWithToken($url, $method, $bodyData, $token);
         $laws = $res->data;
         $punishment_type = DB::table('punishment_type')->get();

         return view('mobile_court.section.create', compact('laws', 'punishment_type'));
         // dd('from mc law and section', $mc_law);
      } else {
         return back()->with('error', 'something went wrong');
      }
   }

   public function store(Request $request)
   {

      // Validate the request data (if needed)
      $request->validate([
         'law_id' => 'required',
         'sec_description' => 'required',
         'sec_number' => 'required',
         'punishment_sec_number' => 'required',
         'sec_title' => 'required',
         'punishment_des' => 'required',
         'punishment_type' => 'required',
         'max_jell' => 'nullable',
         'min_jell' => 'nullable',
         'max_fine' => 'nullable',
         'min_fine' => 'nullable',
         'next_jail' => 'nullable',
         'next_fine' => 'nullable',
         'extra_punishment' => 'nullable',
         'comment' => 'nullable',
      ]);
      $url = getapiManagerBaseUrl() . '/api/mc/section/store';
      $data = $request->all();
      // dd($data);
      // $url = getapiManagerBaseUrl() . '/api/emc/crpc-section/save';
      $method = 'POST';
      $bodyData = json_encode($data);
      $token = $this->verifySiModuleToken('WEB');
      // dd('setting crpc', $bodyData);
      if ($token) {
         $res = makeCurlRequestWithToken($url, $method, $bodyData, $token);
         if ($res->success == true) {
            return redirect()->route('mc.section.index')->with('success', $res->message);
         } else {
            return redirect()->route('mc.section.index')->with('error', 'সংরক্ষণ হয়নি ');
         }
      } else {
         return redirect()->route('mc.section.index')->with('error', 'সংরক্ষণ হয়নি ');
      }
   }

   public function edit($id = '')
   {
      $url = getapiManagerBaseUrl() . '/api/mc/section/edit/' . $id;
      $method = 'GET';
      $bodyData = null;


      $url2 = getapiManagerBaseUrl() . '/api/mc/law/get';
      $method2 = 'GET';
      $bodyData2 = null;

      $token = $this->verifySiModuleToken('WEB');
      if ($token) {
         $res = makeCurlRequestWithToken($url, $method, $bodyData, $token);
         $res2 = makeCurlRequestWithToken($url2, $method2, $bodyData2, $token);

         if ($res->success == true) {
            $section = $res->data;
            $laws = $res2->data;
            $punishment_type = DB::table('punishment_type')->get();
            return view('mobile_court.section.edit', compact('section', 'laws', 'punishment_type'));
         } else {
            return redirect()->back()->with('error', 'Something went wrong.');
         }
      }
   }

   public function update(Request $request, $id='')
   {

      // Validate the request data (if needed)
      $request->validate([
         'law_id' => 'required',
         'sec_description' => 'required',
         'sec_number' => 'required',
         'punishment_sec_number' => 'required',
         'sec_title' => 'required',
         'punishment_des' => 'required',
         'punishment_type' => 'required',
         'max_jell' => 'nullable',
         'min_jell' => 'nullable',
         'max_fine' => 'nullable',
         'min_fine' => 'nullable',
         'next_jail' => 'nullable',
         'next_fine' => 'nullable',
         'extra_punishment' => 'nullable',
         'comment' => 'nullable',
      ]);
      $url = getapiManagerBaseUrl() . '/api/mc/section/update/'.$id;
      $data = $request->all();
      // dd($data);
      // $url = getapiManagerBaseUrl() . '/api/emc/crpc-section/save';
      $method = 'POST';
      $bodyData = json_encode($data);
      $token = $this->verifySiModuleToken('WEB');
      // dd('setting crpc', $bodyData);
      if ($token) {
         $res = makeCurlRequestWithToken($url, $method, $bodyData, $token);
         if ($res->success == true) {
            return redirect()->route('mc.section.index')->with('success', $res->message);
         } else {
            return redirect()->route('mc.section.index')->Xwith('error', 'পরিবর্তন হয়নি ');
         }
      } else {
         return redirect()->route('mc.section.index')->Xwith('error', 'পরিবর্তন হয়নি ');
      }
   }
}
