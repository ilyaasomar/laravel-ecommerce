<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Products;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addtocart(Request $request)
    {
        if(auth('sanctum')->check()){
            $user_id = auth('sanctum')->user()->id;
            $product_id = $request->product_id;
            $product_qty = $request->product_qty;
            $productCheck = Products::where('id',$product_id)->first();
            if($productCheck){
                if(Cart::where('product_id',$product_id)->where('user_id',$user_id)->exists()){
                    return response()->json([
                        'status' => 409,
                        'message' => $productCheck->name . ' Already Exist to Cart'
                    ]);
                }
                else{
                    $cart = new Cart();
                    $cart->user_id = $user_id;
                    $cart->product_id = $product_id;
                    $cart->product_qty = $product_qty;
                    $cart->save();
                    return response()->json([
                        'status' => 201,
                        'message' => 'Added to Cart'
                    ]);
                }
               
            }
            else{
                return response()->json([
                    'status' => 404,
                    'message' => 'product Not Found'
                ]);
            }
           
        }
        else{
            return response()->json([
                'status' => 401,
                'message' => 'Login First'
            ]);
        }
    }
}
