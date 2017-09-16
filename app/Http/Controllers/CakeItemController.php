<?php

namespace App\Http\Controllers;

use App\CakeItem;
use App\CategoryCake;
use App\OrderedCake;
use Illuminate\Http\Request;

class CakeItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = CategoryCake::all();
        $cat_list = CategoryCake::where('show_cat', '=', 1)->pluck('name', 'id');

        return view('admin.cake_items', compact('categories', 'cat_list'));
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
        $rules =[
          'category_cake_id'=> 'required',
          'item' => 'required',
          'description' => 'required',
          'price' => 'required',
        ];

        $this->validate($request, $rules);

        CakeItem::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CakeItem  $cakeItem
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $items = CakeItem::where('category_cake_id', $id)->get();

        return view('admin.display_cakeItems', compact('items'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CakeItem  $cakeItem
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $show_item = CakeItem::find($id);

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

        $item = CakeItem::find($request->get('id'));

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
        OrderedCake::where('cake_item_id', $id)->delete();

        $item = CakeItem::find($id);
        $item->delete();

    }
}
