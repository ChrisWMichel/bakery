<?php

namespace App\Http\Controllers;

use App\CakeItem;
use App\Item;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PublicItemsController extends Controller
{
    public function changeCategory($id){
        $items = Item::where('category_id', $id)->where('show', '=', 1)->get();
        $cake = false;

        return view('public.display_items.display_items', compact('items', 'cake'));
    }

    public function changeCakeCategory($id){

        $items = CakeItem::where('category_cake_id', $id)->where('show', '=', 1)->get();
        $cake = true;

        return view('public.display_items.display_items', compact('items', 'cake'));
    }

    public function getOrderForm(){
        $cart = Cart::content();

        return view('public.display_items.order_form', compact('cart'));
    }

    public function orderForm(Request $request){
        $item = Item::find($request->get('item_id'));
        /*Cart::add(
          ['id' => 'item-'. $item->id, 'name' => $item->item, 'qty' => $request->get('quantity'), 'price' => $item->price]
        );*/
        Cart::add('item-'. $item->id, $item->item, $request->get('quantity'), $item->price);
        $cart = Cart::content();

        return view('public.display_items.order_form', compact('cart'));
    }

    public function orderCakeForm(Request $request){
        $item = CakeItem::find($request->get('item_id'));
        Cart::add(
          ['id' => 'cake-'. $item->id, 'name' => $item->item, 'qty' => $request->get('quantity'), 'price' => $item->price]
        );
        $cart = Cart::content();

        return view('public.display_items.order_form', compact('cart'));
    }

    public function updateOrderForm(Request $request){

        Cart::update($request->get('id'), $request->get('qty'));

        $cart = Cart::get($request->get('id'));

        return response($cart);
    }

    public function deleteItem($id){
        Cart::remove($id);
    }

}
