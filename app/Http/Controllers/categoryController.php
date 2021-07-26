<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class categoryController extends Controller
{
    public function add(Request $request){

        $request->validate([
            'name'=>'required'
        ]);

        $category = new Category;

        $category->name = $request->name;
        $category->slug = str::slug($request->name);

        $category->save();

        return response()->json($category, 201);
    }

    public function list(){
        return Category::orderBy('id','ASC')->get();
    }

    public function delete($id){
        Category::find($id)->delete();
        return response()->json([
            "message"=>'successfully deleted'
        ], 204);
    }

    public function update(Request $request){

        $request->validate([
            'name'=>'required',
            'slug'=>'required'
        ]);

        $category = Category::where('id', $request->category_id)->first();

        $category->name = $request->category_name;
        $category->slug = str::slug($request->category_name);

        $category->save();

        return response()->json($category, 200);
    }
}
