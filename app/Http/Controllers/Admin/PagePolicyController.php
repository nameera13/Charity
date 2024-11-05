<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PagePolicy;

class PagePolicyController extends Controller
{
    public function terms()
    {
        $terms = PagePolicy::where('id',1)->first();
        return view('admin.main.page_policy.terms', compact('terms'));
    }

    public function terms_update(Request $request)
    {
        $terms = PagePolicy::where('id',1)->first();
        $terms->terms_content = $request->terms_content;
        $terms->save();

        return redirect()->back()->with('success','Terms Page Updated Successfully!');
    }

    public function privacy()
    {
        $privacy = PagePolicy::where('id',1)->first();
        return view('admin.main.page_policy.privacy', compact('privacy'));
    }

    public function privacy_update(Request $request)
    {
        $privacy = PagePolicy::where('id',1)->first();

        $privacy->privacy_content = $request->privacy_content;
        $privacy->save();

        return redirect()->back()->with('success','Privacy Page Updated Successfully!');
    }
}
