<?php

namespace App\Http\Controllers;

use App\CategoryCake;
use Illuminate\Http\Request;

class CategoryCakesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }


    public function storeCat(Request $request)
    {
        $category = CategoryCake::create(['name' => $request->get('name')]);

        return response($category);
    }

    public function updateCat(Request $request, $id)
    {
        $category = CategoryCake::find($id); //$request->input('id')

        $category->update(['name' => $request->input('name')]);

        return response($category);
    }

    public function deleteCat($id){
        $cat = CategoryCake::find($id);
        $cat->delete();
    }

    public function hideCat($id){
        $cat = CategoryCake::find($id);

        if($cat->show_cat == 0){
            $cat->update(['show_cat' => 1]);
        }elseif($cat->show_cat == 1){
            $cat->update(['show_cat' => 0]);
        }

        return response($cat);
    }
}
