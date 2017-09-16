<?php

namespace App\Http\Controllers;

use App\Hour;
use Illuminate\Http\Request;

class HourController extends Controller
{

    public function index()
    {
        $hours = Hour::all();
        $message = \DB::table('business_info')->select('hours_page')->first();

        return view('admin.cms.hours', compact('hours', 'message'));
    }



    public function updateHoursMsg(Request $request)
    {
         \DB::table('business_info')->where('id', 1)->update(['hours_page' => $request->get('message')]);

    }


    public function updateHours(Request $request)
    {
        $hour = Hour::find($request->get('id'));
        $hour->update(['open' => $request->get('open'), 'close' => $request->get('close')]);

        return response($hour->day);
    }


}
