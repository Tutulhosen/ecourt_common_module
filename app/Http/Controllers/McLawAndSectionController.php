<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Traits\TokenVerificationTrait;

class McLawAndSectionController extends Controller
{
   use TokenVerificationTrait;

   public function index()
   {
      return view('mobile_court.law_and_section.index');
   }
   public function create()
   {
      return view('mobile_court.law_and_section.create');
   }

   public function law_store(Request $request)
   {
       $request->validate([
         'title' => 'required|string|max:255',
         'law_no' => 'required|string|max:255',
         'description' => 'nullable|string',
         'bd_law_link' => 'nullable|url',
      ], [
         'title.required' => 'The title is required.',
         'law_no.required' => 'The law number is required.',
         'bd_law_link.url' => 'The bd law link must be a valid URL.',
      ]);

      $url = getapiManagerBaseUrl() . '/api/mc/law/store';
      $data = $request->all();
      // dd($data);
      // $url = getapiManagerBaseUrl() . '/api/emc/crpc-section/save';
      $method = 'POST';
      $bodyData = json_encode($data);
      $token = $this->verifySiModuleToken('WEB');
      // dd('setting crpc', $bodyData);
      if ($token) {
         $res = makeCurlRequestWithToken($url, $method, $bodyData, $token);

         if ($res->success==true) {
            return redirect()->back()->with('success', $res->message);
         } else {
            return redirect()->back()->with('error', 'সংরক্ষণ হয়নি ');
         }
       
      } else {
         return redirect()->back()->with('error', 'সংরক্ষণ হয়নি ');
      }
   }

   public function section()
   {
      // $laws = DB::table('mc_law')->get();
      $url = getapiManagerBaseUrl() . '/api/mc/law/section/get_law';
      $method = 'POST';
      $bodyData = null;
      $token = $this->verifySiModuleToken('WEB');
      // dd($token);
      // dd('setting crpc', $bodyData);
      if ($token) {
         $res = makeCurlRequestWithToken($url, $method, $bodyData, $token);

         $laws = $res->data;
         $punishment_type = DB::table('punishment_type')->get();

         return view('mobile_court.law_and_section.section', compact('laws', 'punishment_type'));
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
      $url = getapiManagerBaseUrl() . '/api/mc/law/section/store';
      $data = $request->all();
      // dd($data);
      // $url = getapiManagerBaseUrl() . '/api/emc/crpc-section/save';
      $method = 'POST';
      $bodyData = json_encode($data);
      $token = $this->verifySiModuleToken('WEB');
      // dd('setting crpc', $bodyData);
      if ($token) {
         $res = makeCurlRequestWithToken($url, $method, $bodyData, $token);
         // dd($res);
         if ($res->success==true) {
            return back()->with('success', $res->message);
         } else {
            return back()->with('error', 'সংরক্ষণ হয়নি');
         }
         
      } else {
         return back()->with('error', 'সংরক্ষণ হয়নি');
      }
      //  dd($request->all());
      // Fetch punishment type description

      // Check if insert was successful
      if (!$inserted) {
         return redirect()->route('section.create')
            ->withErrors(['error' => 'Failed to create section.'])
            ->withInput();
      }
      //  dd($inserted);
      DB::commit();
      // Success message and redirect
      return redirect()->route('section.index')
         ->with('success', 'Section was created successfully');
   }
}
