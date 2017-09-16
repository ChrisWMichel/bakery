<?php

namespace App\Http\Controllers;

use App\Category;
use App\CategoryCake;
use App\Hour;
use App\Item;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Session;

class PublicController extends Controller
{
    public function index(){
        Cart::destroy();
        Session::forget('email');
        return view('layouts.public_layout');
    }
    protected function getImagePath($desc){
        $paths = strstr($desc, 'src');
        $arrPaths = explode(" ", $paths);
        $path = $arrPaths[0];
        $photo_path = substr($path, 6);
        $photo_path = substr($photo_path, 0, -1);
        return $photo_path;
    }

    public function getPages(Request $request){

        switch ($request->id){
            case 'home':
                $openClose = \DB::table('business_info')->select('open')->first();
                $home = \DB::table('home')->where('id', 1)->first();
                $item = Item::where('id', $home->item_id)->first();
                $path = $this->getImagePath($item->description);

                return view('public.home', compact('item' , 'path', 'home', 'openClose'));
                break;
            case 'about':
                $about = \DB::table('business_info')->where('id', 1)->select('about_page')->first();

                return view('public.about', compact('about'));
                break;
            case 'menu':
                $openClose = \DB::table('business_info')->select('open')->first();
                $cat_id = Category::first();
                $items = Item::where('category_id', $cat_id->id)->get();
                $categories = Category::all();
                $categoryCakes = CategoryCake::all();
                if(count(Cart::content())){
                    $cart_content = true;
                }else{
                    $cart_content = false;
                }
                return view('public.menu', compact('categories', 'categoryCakes', 'items', 'cart_content', 'openClose'));
                break;
            case 'contact':
                $contact = \DB::table('business_info')->where('id', 1)->first();
                return view('public.contact', compact('contact'));
                break;
            case 'checkout':
                $cart = Cart::content();
                $subtotal = Cart::subtotal();
                $tax = Cart::tax();
                $total = Cart::total();

                $email = Session::get('email');

                return view('public.checkout', compact('cart', 'subtotal', 'tax', 'total', 'email'));
                break;
            case 'hours':
                $hours = Hour::all();
                $message = \DB::table('business_info')->select('hours_page')->first();

                return view('public.hours', compact('hours', 'message'));
                break;
            default:
                $item = Item::find($request->id);
                /*Cart::add('item-'. $item->id, $item->item, $request->get('quantity'), $item->price);
        $cart = Cart::content();*/
                $openClose = \DB::table('business_info')->select('open')->first();
                Cart::add('item-' . $item->id, $item->item, 1, $item->price);
                $items = Item::where('category_id', $item->category_id)->get();
                $categories = Category::all();
                $categoryCakes = CategoryCake::all();
                $cart_content = true;

                return view('public.menu', compact('categories', 'categoryCakes', 'items', 'cart_content', 'openClose'));
        }

    }
}
