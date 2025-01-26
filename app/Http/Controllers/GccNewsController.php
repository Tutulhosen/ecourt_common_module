<?php

namespace App\Http\Controllers;

use App\Models\Gcc_news;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GccNewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['short_news'] = Gcc_news::orderby('id', 'desc')->where('news_type', 1)->paginate(10);
        $data['big_news'] =Gcc_news::orderby('id', 'desc')->where('news_type', 2)->paginate(10);
        $data['page_title'] = 'জেনারেল সার্টিফিকেট আদালতের জনপ্রিয় সংবাদ ও খবরের তালিকা';
        return view('news.gcc.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['page_title'] = 'জেনারেল সার্টিফিকেট আদালতের জনপ্রিয় সংবাদ ও খবরের তালিকা';
        return view('news.gcc.add')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request;
        $this->validate(
            $request,
            [
                'newsType' => 'required',
                'news_details' => 'required',
                'status' => 'required',
            ],
            [
                'newsType.required' => 'সংবাদের ধরণ দিতে হবে',
                'news_details.required' => 'সংবাদের বিস্তারিত লিখুন ',
                'status.required' => 'সংবাদের অবস্থা দিতে হবে',
            ],
        );
        if($request->newsType == 2){
            $this->validate(
                $request,
                [
                    'news_title' => 'required',
                    'news_writer' => 'required',
                    'news_date' => 'required',
                ],
                [
                    'news_title.required' => 'সংবাদের শিরনাম দিতে হবে',
                    'news_writer.required' => 'সংবাদের লেখকের নাম দিতে হবে',
                    'news_date.required' => 'সংবাদের তারিখ দিতে হবে',
                ],
            );
        }

        $news_date = $request->news_date;
        if ($news_date) {
            $news_date = str_replace('/', '-', $news_date);
            $news_date = date('Y-m-d', strtotime($news_date));
        } else {
            $news_date = null;
        }

        $news_data = [
            'news_type' => $request->newsType,
            'news_details' => $request->news_details,
            'news_title' => $request->news_title,
            'news_writer' => $request->news_writer,
            'status' => $request->status,
            'created_by' => globalUserInfo()->id,
        ];

        if ($news_date) {
            $news_data['news_date'] = $news_date;
        }

        DB::table('gcc_news')->insert($news_data);

        return redirect()->route('gcc.news')->with('success', 'আদালত সফলভাবে সংরক্ষণ করা হয়েছে');
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
        $data['news'] =Gcc_news ::orderby('id', 'desc')->where('id', $id)->first();
        $data['page_title'] = 'জেনারেল সার্টিফিকেট আদালতের জনপ্রিয় সংবাদ ও খবরের তালিকা';
        // return $data;
        return view('news.gcc.edit')->with($data);
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
       // return $request;

        $this->validate(
            $request,
            [
                'newsType' => 'required',
                'news_details' => 'required',
                'status' => 'required',
            ],
            [
                'newsType.required' => 'সংবাদের ধরণ দিতে হবে',
                'news_details.required' => 'সংবাদের বিস্তারিত লিখুন ',
                'status.required' => 'সংবাদের অবস্থা দিতে হবে',
            ],
        );
        if($request->newsType == 2){
            $this->validate(
                $request,
                [
                    'news_title' => 'required',
                    'news_writer' => 'required',
                    'news_date' => 'required',
                ],
                [
                    'news_title.required' => 'সংবাদের শিরনাম দিতে হবে',
                    'news_writer.required' => 'সংবাদের লেখকের নাম দিতে হবে',
                    'news_date.required' => 'সংবাদের তারিখ দিতে হবে',
                ],
            );
        }
      
        $news_date = $request->news_date;
        if ($news_date) {
            $news_date = str_replace('/', '-', $news_date);
            $news_date = date('Y-m-d', strtotime($news_date));
        } else {
            $news_date = null;
        }

        $news_data = [
            'news_type' => $request->newsType,
            'news_details' => $request->news_details,
            'news_title' => $request->news_title,
            'news_writer' => $request->news_writer,
            'status' => $request->status,
            'created_by' => globalUserInfo()->id,
        ];

        if ($news_date) {
            $news_data['news_date'] = $news_date;
        }

        DB::table('gcc_news')->insert($news_data);

        return redirect()->route('gcc.news')->with('success', 'আদালত সফলভাবে সংরক্ষণ করা হয়েছে');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $news =Gcc_news::find($id);
 
        $news->delete();

        return redirect()->back()->with('status_update','Deleted Successfully') ;
    }


    public function status($status,$id)
    {
        // echo "<pre>";
        // echo $id;
        // dd($status);
       Gcc_news::where('id',$id)->update(['status' =>$status]);
        return redirect()->back()->with('status_update','Status updated Successfully') ;
    }

    // public function news_single($id)
    // {
    //     $news=Gcc_news::find($id);
    //     $data['news']=$news;
    //    // dd($news);
    //     return view('singleNews')->with($data);
    // }
}