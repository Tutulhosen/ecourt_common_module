<?php

namespace App\Http\Controllers;

use App\Repositories\AttachmentRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Traits\TokenVerificationTrait;
use Illuminate\Support\Facades\Auth;

use function PHPUnit\Framework\isEmpty;

class McSottoGolpoController extends Controller
{
    use TokenVerificationTrait;

    public function index()
    {
        $golpos = DB::table('sottogolpo')->get();
        // dd($golpos);
        return view('mobile_court.sotto_golpo.index', compact('golpos'));
    }
    public function create()
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
            $laws = $res->data;
            $case_type = DB::table('case_type')->get();
            return  view('mobile_court.sotto_golpo.create', compact('laws', 'case_type'));
            // dd('from mc law and section', $mc_law);
        } else {
            return back()->with('error', 'something went wrong');
        }
    }
    public function store(Request $request)
    {
        $request->validate([
            'attachments.*' => 'file|max:1024',
            'attachments' => 'array|max:2',
        ], [
            'attachments.max' => 'আপনি ২ টি ফাইলের বেশি আপলোড করতে পারবেন না',
            'attachments.*.max' => 'প্রত্যেক ফাইলের সাইজ ১ এমবি অথবা তার কম হতে হবে',
        ]);

        $uploadPath = public_path('mobile_court/uploads/golpo');

        $filenames = [];

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move($uploadPath, $filename);
                $filenames[] = $filename;
            }
        }
        $date = now();
        $validateData = [
            'title' => $request['title'],
            'details' => $request['content'],
            'status' => 1,
            'law_id' => $request['law_id'],
            'case_type_id' => $request['case_type_id'],
            'created_by' => globalUserInfo()['name'],
            'user_id' => globalUserInfo()['id'],
            'update_by' => 'Jafrin',
            'story_pic' => isset($filenames[0]) ? $filenames[0] : null,
            'story_pic_body' => isset($filenames[1]) ? $filenames[1] : null,
            'created_date' => $date->format("Y-m-d H:i:s"),
            'update_date' => $date->format("Y-m-d H:i:s"),
            'location_str' => "test",
        ];
        $inserted = DB::table('sottogolpo')->insert($validateData);
        if ($inserted) {
            return redirect()->route('mc_sottogolpo.index')->with('success', 'সফলভাবে ডাটা যুক্ত হয়েছে');
        } else {
            return back()->with('error', 'ডাটা যুক্ত হয়নি');
        }
    }

    public function edit($id)
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
            $laws = $res->data;
            $case_type = DB::table('case_type')->get();
            $golpo = DB::table('sottogolpo')->where('id', $id)->first();
            return view('mobile_court.sotto_golpo.edit', compact('laws', 'case_type', 'golpo'));
            // dd('from mc law and section', $mc_law);
        } else {
            return back()->with('error', 'something went wrong');
        }
    }
    public function update(Request $request, $id = '')
    {
        $filenames = [];

        // Check if attachments are provided
        if (!empty($request->attachments) && $request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('mobile_court/uploads/golpo'), $filename);  // Save to the specified path
                $filenames[] = $filename;
            }
        }
        // dd($request->status);
        // Prepare data for updating
        $validateData = [
            'title' => $request->title,
            'details' => $request->content,
            'status' => (int) $request->status,
            'law_id' => $request->law_id,
            'case_type_id' => $request->case_type_id,
            'created_by' => globalUserInfo()['name'],
            'user_id' => globalUserInfo()['id'],
            'update_by' => 'Jafrin',
        ];

        // Conditionally add filenames if images are uploaded
        if (isset($filenames[0])) {
            $validateData['story_pic'] = $filenames[0];
        }
        if (isset($filenames[1])) {
            $validateData['story_pic_body'] = $filenames[1];
        }

        $updated = DB::table('sottogolpo')->where('id', $id)->update($validateData);
        if ($updated) {
            return redirect()->route('mc_sottogolpo.index')->with('success', 'সফলভাবে ডাটা সংশোধন হয়েছে');
        } else {
            return redirect()->route('mc_sottogolpo.index')->with('success', 'সফলভাবে ডাটা সংশোধন হয়েছে');
        }
    }
}
