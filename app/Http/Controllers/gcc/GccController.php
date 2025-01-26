<?php

namespace App\Http\Controllers\gcc;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GccController extends Controller
{
    //
    public function all_case(){
        $data['page_title']='মোট মামলা';
        return view('gcc_court.appealCasewiseList')->with($data);
    }

    //appeal edit
    public function appeal_edit(){
        $data['page_title'] = 'সার্টিফিকেট মামলা সংশোধন';
        //dd($data);
        return view('gcc_court.gcoappealEdit')->with($data);
    }
}
