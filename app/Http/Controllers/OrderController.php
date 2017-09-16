<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Mail\replyToCustomer;
use App\Order;
use App\OrderedCake;
use App\OrderedItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{

    public function CheckStoreStatus(Request $request)
    {
        if($request->checkStore == 1){
            $status = 0;
        }else{
            $status = 1;
            Session::put('oldCount', 0);
        }

         DB::table('business_info')->where('id', 1)->update(['open' => $status ]); /*->select('open')*/

        return redirect()->back();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getOrderUpdates()
    {
        $orders = Order::where('complete', 0)->with('orderedItems')->with('orderedCakes')->with('customer')->get();

        return view('admin.incoming_orders', compact('orders'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function emailCustomer(Request $request)
    {
        $order = Order::where('id', $request->get('order_id'))->with('orderedItems')->with('orderedCakes')->first();
        $customer = Customer::find($order->customer_id);
        $order->update(['complete' => 1]);

        $contact = [
            'message' => $request->get('message'),
            'email' => $customer->email
        ];

        Mail::send(new replyToCustomer($contact, $order));

    }


    public function cancelOrder(Request $request)
    {
        $order = Order::where('id', $request->get('order_id'))->with('orderedItems')->with('orderedCakes')->first();
        $customer = Customer::find($order->customer_id);

        $contact = [
          'message' => $request->get('message'),
          'email' => $customer->email
        ];

        Mail::send(new replyToCustomer($contact, $order));

        OrderedItem::where('order_id', $order->id)->delete();
        OrderedCake::where('order_id', $order->id)->delete();
        Order::find($order->id)->delete();

    }

    // when a new order is placed, notification sound will be executed
    public function orderCount($count)
    {
        if(Session::get('oldCount') != $count){
            Session::put('oldCount', $count);
            return response('true');
        }

        if(Session::get('oldCount') > $count){
            Session::put('oldCount', $count);
            return response('false');

        }elseif (Session::get('oldCount') < $count){
            Session::put('oldCount', $count);
            return response('true');
        }

        //return response(['oldCount' => Session::get('oldCount')]);
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
