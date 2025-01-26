<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FormDownLoadController extends Controller
{
    public function index()
    {
        $data['page_title'] = 'ডাউনলোড';
        $data['downloadable_files'] = [
            [
                'file_name' => 'দায় অস্বীকার',
                'file_location' => url('') . '/download_template/gcc/' . 'defaulter_disagree_format.docx'
            ],
            [
                'file_name' => 'সম্পত্তি নিলামে বিক্রি',
                'file_location' => url('') . '/download_template/gcc/' . 'crock.docx'
            ]
        ];
        return view('form_download.gcc.form_download')->with($data);
    }
}