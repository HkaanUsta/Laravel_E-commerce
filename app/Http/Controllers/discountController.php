<?php

namespace App\Http\Controllers;

use App\Models\Discount_coupon;
use Illuminate\Http\Request;


Discount_coupon::where('time_of_end',date('Y-m-d'))->delete();


class discountController extends Controller
{
    public function add(Request $request){

        $request->validate([
            'key'=>'required',
            'time_of_end'=>'required',
            'count'=>'required'
        ]);

        $discount = new Discount_coupon;

        $discount->key = $request->key;
        $discount->time_of_end = $request->time_of_end;
        $discount->count = $request->count;

        $discount->save();


        return response()->json($discount, 201);
    }

    public function list(){
        return Discount_coupon::orderBy('id','ASC')->get();
    }

    public function delete($id){
        Discount_coupon::find($id)->delete();
        return "başarı ile silindi";
    }
}

