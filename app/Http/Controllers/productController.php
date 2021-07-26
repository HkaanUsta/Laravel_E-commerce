<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Discount_coupon;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use function GuzzleHttp\Promise\all;

class productController extends Controller
{
    public function add(Request $request){

        $request->validate([
            'name'=>'required',
            'description'=>'required',
            'title_image'=>'required',
            'category_id'=>'required',
            'price'=>'required'
        ]);

        $product = new Product;

        $product->name = $request->name;
        $product->description = $request->description;
        if($request->hasFile('image')){
            $imageName=str::slug($request->name).'.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path('uploads'),$imageName);
            $product->title_image = '/uploads/'.$imageName;
        }
        $product->category_id = $request->category_id;
        $product->price = $request->price;
        $product->slug = str::slug($request->name);

        $product->save();

        return response()->json($product, 201);
    }

    public function list(){
        return Product::all();
    }

    public function delete($id){
        Product::find($id)->delete();
        return response()->json([
            "message"=>'orders successfully deleted'
        ], 204);
    }

    public function update(Request $request){

        $request->validate([
            'product_id'=>'required',
            'product_name'=>'required',
            'product_desc'=>'required',
            'title_image'=>'required',
            'category_id'=>'required',
            'price'=>'required',
            'slug'=>'required'
        ]);


        $product = Product::where('id', $request->product_id)->first();

        $product->name = $request->product_name;
        $product->description = $request->product_desc;
        if($request->hasFile('image')){
            $imageName=str::slug($request->name).'.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path('uploads'),$imageName);
            $product->title_image = '/uploads/'.$imageName;
        }
        //eski fotoğradı sil
        $product->category_id = $request->category_id;
        $product->price = $request->price;
        $product->slug = str::slug($request->name);

        $product->save();

        return response()->json($product, 200);
    }

    public function addcart(Request $request){

        $request->validate([
            'product_id'=>'required',
            'user_id'=>'required'
        ]);

        $productId = Product::where('id', $request->product_id)->first();
        $userId = User::where('id', $request->user_id)->first();


        if(isset($productId) && isset($userId)){
            $count = Cart::where('product_id', $productId->id)->where('user_id', $userId->id)->first();
            if($count){
                $count->count++;
                $count->save();


                return response()->json([
                    "message"=>'successfully added'
                ], 202);
            }else{
                $cart = new Cart;
                $cart->product_id = $productId->id;
                $cart->user_id = $userId->id;

                $cart->save();

                return response()->json($cart, 201);
            }
        }else{
            return response()->json([
                'message'=>'denied'
            ],500);
        }
    }

    public function order(Request $request){
//kart işlemi düzgün cevap verirse

        $request->validate([
            'user_id'=>'required',
            'card_info'=>'required'
        ]);

        $userId = User::where('id', $request->user_id)->first();

        $cart = Cart::where('user_id', $userId->id)->get();

        $price = 0;
        $products = array();
        $order = new Order;
        for($i = 0; $i<$cart->count(); $i++){


            $productInfo = Product::where('id', $cart[$i]->product_id)->first();

            array_push($products,$productInfo->id);

            $price = $price + ($productInfo->price*$cart[$i]->count);
            $order->count = $cart[$i]->count;
        }
        $order->card_info = $request->card_info;

        $order->product_id = json_encode($products);
        $order->user_id = $userId->id;
        $order->price = $price;


        $discount = Discount_coupon::where('key', $request->discount_key)->first();


        if($discount){
            $order->total = ($price*$discount->count)/100;
            $order->save();
            return response(["success"],201);
        }else{
            $order->total = $price;
            $order->save();
            return response(["success"],201);
        }

    }
}
