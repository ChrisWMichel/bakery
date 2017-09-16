<?php

namespace App\Http\Controllers;

use App\Mail\ContactMessage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index()
    {
        $info = \DB::table('business_info')->where('id', 1)->first();

        return view('admin.cms.contact', compact('info'));
    }

    public function updateContact(Request $request){
        $rules =[
          'name' => 'required',
          'address' => 'required',
          'city' => 'required',
          'state' => 'required|max:2',
          'zipcode' => 'required',
          'phone' => 'required',
          'email' => 'required',
        ];

        $this->validate($request, $rules);

        \DB::table('business_info')->where('id', 1)->update([
            'name' => $request->get('name'),
            'address' => $request->get('address'),
            'city' => $request->get('city'),
            'state' => $request->get('state'),
            'zipcode' => $request->get('zipcode'),
            'phone' => $request->get('phone'),
            'email' => $request->get('email'),
        ]);
    }

    public function SendMessage(Request $request) {
        $rules = [
          'firstname' => 'required|min:2',
          'email' => 'required|email',
          'message' => 'required|min:8'
        ];

         $this->validate($request, $rules);

        $contact = [
          'firstname' => $request->input('firstname'),
          'email' => $request->input('email'),
          'message' => $request->input('message'),
          'date' => Carbon::now()->toFormattedDateString()
        ];

         Mail::send(new ContactMessage($contact));

        return response()->json(['firstname' => $request->firstname]);

        }
}
