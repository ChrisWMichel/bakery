<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        //
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //$this->validate($request, ['name' => 'required']);

        $category = Category::create(['name' => $request->get('name')]);

        return response($category);
    }

    public function updateCat(Request $request, $id)
    {
        $category = Category::find($id); //$request->input('id')

        $category->update(['name' => $request->input('name')]);

        return response($category);
    }

    public function deleteCat($id){
        $cat = Category::find($id);
        $cat->delete();
    }

    public function hideCat($id){
        $cat = Category::find($id);

        if($cat->show_cat == 0){
            $cat->update(['show_cat' => 1]);
        }elseif($cat->show_cat == 1){
            $cat->update(['show_cat' => 0]);
        }


        return response($cat);
    }

}
