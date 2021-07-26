<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;

class cartController extends Controller
{
    public function list($id){
        return Cart::where('user_id', $id)->get();;
    }

    public function delete(Request $request){

        $request->validate([
            'user_id'=>'required',
            'product_id'=>'required'
        ]);

        $cart = Cart::where('user_id', $request->user_id)->where('product_id', $request->product_id)->delete();


        return response()->json([
            "message"=>'successfully deleted'
        ], 204);
    }
}
