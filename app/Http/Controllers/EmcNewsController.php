<?php

namespace App\Http\Controllers;

use App\Models\Em_news;
 use Illuminate\Http\Request;
use App\Traits\TokenVerificationTrait;
use Illuminate\Support\Facades\DB;

class EmcNewsController extends Controller
{
    use TokenVerificationTrait;
    public function index()
    {


        $data['short_news'] = Em_news::orderby('id', 'desc')->where('news_type', 1)->paginate(10);
        $data['big_news'] = Em_news::orderby('id', 'desc')->where('news_type', 2)->paginate(10);
        $data['page_title'] = 'এক্সিকিউটিভ ম্যাজিস্ট্রেট কোর্টের জনপ্রিয় সংবাদ ও খবরের তালিকা';
        return view('news.emc.index', compact('data'));
        /* $method = 'POST';
        $bodyData = null;

        $token = $this->verifySiModuleToken('WEB');

        $data = json_encode($bodyData);
        if ($token) {
            $res = makeCurlRequestWithToken($url, $method, $data, $token);
            // dd('ecourt module emc, ' , $res);
            if ($res->success) {
                $data = $res->data;
                return view('news.emc.index', compact('data'));
            } else {
                return redirect()->back()->with('তথ্য পাওয়া যায়নি');
            }
        } else {
            return redirect()->back()->with('Internal Server Error');
        }  */
    }


    public function create()
    {
        $page_title = 'এক্সিকিউটিভ ম্যাজিস্ট্রেট কোর্টের জনপ্রিয় সংবাদ ও খবরের তালিকা';
        return view('news.emc.add', compact('page_title'));
    }

    public function store(Request $request)
    {
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

        if ($request->newsType == 2) {
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

        DB::table('em_news')->insert($news_data);

        return redirect()->route('emc.news')->with('success', 'আদালত সফলভাবে সংরক্ষণ করা হয়েছে');
    }

    public function edit($id)
    {
        $data['news'] = Em_news::orderby('id', 'desc')->where('id', $id)->first();
        $data['page_title'] = 'এক্সিকিউটিভ ম্যাজিস্ট্রেট কোর্টের জনপ্রিয় সংবাদ ও খবরের তালিকা';
        // return $data;
        return view('news.emc.edit')->with($data);
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
        if ($request->newsType == 2) {
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

        DB::table('em_news')->insert($news_data);
        return redirect()->route('emc.news')->with('success', 'আদালত সফলভাবে সংরক্ষণ করা হয়েছে');
    }
    public function destroy($id)
    {
        $news = Em_news::find($id);

        $news->delete();

        return redirect()->back()->with('status_update', 'Deleted Successfully');
    }


    public function status($status, $id)
    {
        // echo "<pre>";
        // echo $id;
        // dd($status);
        Em_news::where('id', $id)->update(['status' => $status]);
        return redirect()->back()->with('status_update', 'Status updated Successfully');
    }

    
}