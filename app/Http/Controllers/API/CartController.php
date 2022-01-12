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
    public function viewcart()
    {
        if(auth('sanctum')->check()){

            $user_id = auth('sanctum')->user()->id;
            $cartItem = Cart::where('user_id',$user_id)->get();
                return response()->json([
                    'status' => 200,
                    'cart' => $cartItem
                ]);
          
        }
        else{
            return response()->json([
                'status' => 401,
                'message' => 'login to view cart'
            ]);
        }
    }
    public function updatequantity($cart_id,$scope)
    {
        if(auth('sanctum')->check()){

            $user_id = auth('sanctum')->user()->id;
            $cartItem = Cart::where('id',$cart_id)->where('user_id',$user_id)->first();
            if($scope == 'inc'){
                $cartItem->product_qty += 1;
            }
            else if($scope == 'dec'){
                $cartItem->product_qty -= 1;
            }
            $cartItem->update();

                return response()->json([
                    'status' => 200,
                    'message' => 'Quantity Updated'
                ]);
        }
        else{
            return response()->json([
                'status' => 402,
                'cart' => 'Login to Continue'
            ]);
        }
    }
    public function deleteCart($cart_id)
    {
        if(auth('sanctum')->check()){

            $user_id = auth('sanctum')->user()->id;
            $cartItem = Cart::where('id',$cart_id)->where('user_id',$user_id)->first();
            if($cartItem){
            $cartItem->delete();
                return response()->json([
                    'status' => 200,
                    'message' => 'Cart Item Deleted'
                ]);
            }
            else {
                return response()->json([
                    'status' => 404,
                    'message' => 'Cart Item Not Found'
                ]);
            }
        }
        else{
            return response()->json([
                'status' => 402,
                'cart' => 'Login to Continue'
            ]);
        }
    }
}
