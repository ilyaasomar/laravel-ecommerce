<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CheckoutController extends Controller
{
    public function orderPlace(Request $request)
    {
        if(auth('sanctum')->check()){

            $user_id = auth('sanctum')->user()->id;
        $validator = Validator::make($request->all(),[
            'firstname' => 'required|max:191',
            'lastname' => 'required|max:191',
            'phone' => 'required|max:191',
            'email' => 'required|max:191',
            'address' => 'required|max:191',
            'city' => 'required|max:191',
            'state' => 'required|max:191',
            'zipcode' => 'required|max:191',
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ]);
        }
        else{
            $order = new Order();
            $order->firstname = $request->firstname;
            $order->lastname = $request->lastname;
            $order->phone = $request->phone;
            $order->email = $request->email;
            $order->address = $request->address;
            $order->city = $request->city;
            $order->state = $request->state;
            $order->zipcode = $request->zipcode;
            $order->payment_mode = "COD";
            $order->tracking_no = "dhamasecom".rand(1111,9999);
            $order->save();

            $cart = Cart::where('user_id',$user_id)->get();
            $orderItems = [];
            foreach($cart as $item){
                $orderItems[] = [
                    'product_id' => $item->product_id,
                    'qty' => $item->product_qty,
                    'price' => $item->product->selling_price,
                ];
                $item->product->update([
                    'qty' => $item->product->qty - $item->product_qty
                ]);
            }
            $order->orderitems()->createMany($orderItems);
            Cart::destroy($cart);
            return response()->json([
                'status' => 200,
                'message' => 'Order Placed Successfully!'
            ]);
        }
    }
    }
}
