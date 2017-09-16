<?php

namespace App\Http\Controllers;

use App\Category;
use App\Item;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$home = \DB::select('SELECT * FROM home WHERE id=1')->get();
        $home = \DB::table('home')->where('id', 1)->first();
       $item = Item::where('id', $home->item_id)->first();

        $cat_list = Category::where('show_cat', '=', 1)->pluck('name', 'id');
        $item_list = Item::where('category_id', $item->category_id)->pluck('item', 'id');
        $path = $this->getImagePath($item->description);


        return view('admin.cms.home', compact('home', 'cat_list', 'item', 'item_list', 'path'));
    }

    public function getItems($cat_id){
        //category was changed
        $cat_list = Category::where('show_cat', '=', 1)->pluck('name', 'id');
        $item_list = Item::where('category_id', $cat_id)->pluck('item', 'id');

        return view('admin.cms.home_items', compact('cat_list', 'item_list', 'cat_id'));
    }

    public function itemChanged($item_id){
        // item changed on home page but category didn't change
        $item = Item::where('id', $item_id)->first();
        $item_list = Item::where('category_id', $item->category_id)->pluck('item', 'id');
        $path = $this->getImagePath($item->description);

        return view('admin.cms.home_item_changed', compact('path', 'item_list', 'item_id'));
    }

    public function itemSelected($item_id){
        // item changed after category was changed
        $item = Item::where('id', $item_id)->first();
        $path = $this->getImagePath($item->description);

        return view('admin.cms.home_item_image', compact('path'));
    }

    public function updateItem($item_id){
        \DB::table('home')->where('id', 1)->update(['item_id' => $item_id]);

    }

    public function updateHomeBody(Request $request){
        \DB::table('home')->where('id', 1)->update(['body' => $request->get('body')]);
    }

    protected function getImagePath($desc){
        $paths = strstr($desc, 'src');
        $arrPaths = explode(" ", $paths);
        $path = $arrPaths[0];
        $photo_path = substr($path, 6);
        $photo_path = substr($photo_path, 0, -1);
        return $photo_path;
    }
}
