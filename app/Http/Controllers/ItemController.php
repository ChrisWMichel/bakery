<?php

namespace App\Http\Controllers;

use App\Category;
use App\Item;
use App\OrderedItem;
use Illuminate\Http\Request;


class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        session_start();
        $categories = Category::all();
        $cat_list = Category::where('show_cat', '=', 1)->pluck('name', 'id');

        return view('admin.items', compact('categories', 'cat_list'));
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


    public function store(Request $request)
    {
        $rules =[
          'category_id'=> 'required',
            'item' => 'required',
            'description' => 'required',
            'price' => 'required',
        ];

        $this->validate($request, $rules);

        Item::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //$_SESSION['category_id'] = $id;
        session()->put('category_id', $id);

        $items = Item::where('category_id', $id)->get();

        return view('admin.display_items', compact('items'));
    }

    public function edit($id)
    {
        $show_item = Item::find($id);

        if($show_item->show == 0){
            $show_item->update(['show' => 1]);
        }elseif($show_item->show == 1){
            $show_item->update(['show' => 0]);
        }
    }

   public function updateItem(Request $request){
       $rules =[
         'item' => 'required',
         'description' => 'required',
         'price' => 'required',
       ];

       $item = Item::find($request->get('id'));

       $this->validate($request, $rules);

       $item->update([
         'item' => $request->get('item'),
         'description' => $request->get('description'),
         'price' => $request->get('price'),
         'volume' => $request->get('volume')
       ]);

   }


    public function DeleteItem($id)
    {
        OrderedItem::where('item_id', $id)->delete();

        $item = Item::find($id);
        $item->delete();
    }
}
