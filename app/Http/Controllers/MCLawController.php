<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\TokenVerificationTrait;

class MCLawController extends Controller
{
   use TokenVerificationTrait;

   public function index()
   {
      $url = getapiManagerBaseUrl() . '/api/mc/law/get';
      $method = 'GET';
      $bodyData = null;
      $token = $this->verifySiModuleToken('WEB');
      // dd($token);
      // dd('setting crpc', $bodyData);
      if ($token) {
         $res = makeCurlRequestWithToken($url, $method, $bodyData, $token);
         // dd($res);
         if ($res->success == true) {
            $laws = $res->data;
            return view('mobile_court.law.index', compact('laws'));
         } else {
            return redirect()->back()->with('error', 'Something went wrong.');
         }
      }
   }
   public function create()
   {
      return view('mobile_court.law.create');
   }

   public function store(Request $request)
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
      if ($token) {
         $res = makeCurlRequestWithToken($url, $method, $bodyData, $token);
         if ($res->success == true) {
            return redirect()->route('mc.law.index')->with('success', $res->message);
         } else {
            return redirect()->route('mc.law.index')->with('error', 'সংরক্ষণ হয়নি ');
         }
      } else {
         return redirect()->route('mc.law.index')->with('error', 'সংরক্ষণ হয়নি ');
      }
   }


   public function edit($id = '')
   {
      $url = getapiManagerBaseUrl() . '/api/mc/law/edit/' . $id;
      $method = 'GET';
      $bodyData = null;
      $token = $this->verifySiModuleToken('WEB');
      if ($token) {
         $res = makeCurlRequestWithToken($url, $method, $bodyData, $token);
         if ($res->success == true) {
            $law = $res->data;
            return view('mobile_court.law.edit', compact('law'));
         } else {
            return redirect()->back()->with('error', 'Something went wrong.');
         }
      }
   }



   
   public function update(Request $request, $id='')
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

      $url = getapiManagerBaseUrl() . '/api/mc/law/update/'.$id;
      $data = $request->all();
      // dd($data);
      // $url = getapiManagerBaseUrl() . '/api/emc/crpc-section/save';
      $method = 'POST';
      $bodyData = json_encode($data);
      $token = $this->verifySiModuleToken('WEB');
      if ($token) {
         $res = makeCurlRequestWithToken($url, $method, $bodyData, $token);
         // dd('update response', $res);
         if ($res->success == true) {
            return redirect()->route('mc.law.index')->with('success', $res->message);
         } else {
            return redirect()->route('mc.law.index')->with('error', 'পরিবর্তন হয়নি ');
         }
      } else {
         return redirect()->route('mc.law.index')->with('error', 'পরিবর্তন হয়নি ');
      }
   }

}
