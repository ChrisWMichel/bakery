<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index()
    {
       $about = \DB::table('business_info')->where('id', 1)->select('about_page')->first();

        return view('admin.cms.about', compact('about'));
    }

    public function updateAbout(Request $request){
        \DB::table('business_info')->where('id', 1)->update(['about_page' => $request->get('body')]);
    }
}
