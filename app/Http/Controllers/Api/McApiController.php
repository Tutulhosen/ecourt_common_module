<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController as BaseController;
use Illuminate\Support\Facades\DB;

class McApiController extends BaseController
{
   public function mc_law_section(){
    $data = DB::table('mc_law')->get();
    return $this->sendResponse($data, 'সফলভাবে তথ্য পাওয়া গেছে');
   }
}
