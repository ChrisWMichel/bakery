<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Item;
use App\Order;
use App\OrderedCake;
use App\OrderedItem;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CustomerController extends Controller
{

    public function getEmail($email)
    {
        $customer = Customer::where('email', '=', $email)->first();

        Session::put('email', $email);

        if(empty($customer)){
            return response('empty');
        }else{
            return response(['cust_id' => $customer->id]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $customer = Customer::where('email', '=', Session::get('email'))->first();

        if(empty($customer)) {
            $rules = [
              'firstname' => 'required',
              'lastname' => 'required',
              'phone' => 'required',
              'email' => 'required|string|email|unique:customers',
            ];

            $this->validate($request, $rules);

            $customer = Customer::create(
              [
                'firstname' => $request->get('firstname'),
                'lastname' => $request->get('lastname'),
                'phone' => $request->get('phone'),
                'email' => $request->get('email'),
              ]
            );
        }
        $order = Order::create([
          'customer_id' => $customer->id,
          'notes'  => $request->get('message'),
          'total' => Cart::total()
        ]);

        foreach (Cart::content() as $cart){
            $pieces = explode('-', $cart->id);
            $item = $pieces[0];
            $id = $pieces[1];
            if($item == 'item'){
                OrderedItem::create([
                  'order_id' => $order->id,
                  'item_id' => $id,
                  'quantity' => $cart->qty
                ]);
            }else{
                OrderedCake::create([
                  'order_id' => $order->id,
                  'cake_item_id' => $id,
                  'quantity' => $cart->qty
                ]);
            }
        }

        Cart::destroy();

    }


    public function pastOrders($cust_id)
    {
        $customer = Customer::find($cust_id);
        $orders = Order::where('customer_id', $customer->id)->with('orderedItems')->with('orderedCakes')->get();
        /*->with('orderedItems')->with('orderedCakes')*/


        return view('public.past_orders.order_list', compact('customer', 'orders'));
        //return response($orders);
    }

    public function reorder(Request $request){
        $order = Order::find($request->get('order_id'));
        $count = $order->reordered++;

        $order->update([
          'complete' => 0,
            'reordered' => $count,
            'notes' => $request->get('message')
        ]);

    }

    public function deleteOrder($order_id){

        $order = Order::find($order_id);

        OrderedItem::where('order_id', '=', $order->id)->delete();
        OrderedCake::where('order_id', '=', $order->id)->delete();
        $order->delete();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        //
    }
}
