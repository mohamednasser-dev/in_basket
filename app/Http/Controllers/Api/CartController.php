<?php

namespace App\Http\Controllers\Api;

use App\Cart;
use App\City;
use App\Coupon;
use App\CouponUsage;
use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;
use App\Http\Resources\OrderResource;
use App\Order;
use App\OrderDetail;
use App\Product;
use App\ProductUnit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Validator;

class CartController extends Controller
{
    public function AddToCart(Request $request)
    {
        $user = check_api_token($request->header('jwt'));
        if ($user) {
            $rules = [
                'product_id' => ['required', 'exists:products,id'],
                'unit_id' => ['required', 'exists:product_units,id'],
                'qty' => ['required', 'numeric'],

            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return msgdata($request, failed(), $validator->messages()->first(), (object)[]);
            }
            $unit = ProductUnit::where('id', $request->unit_id)->first();

            $cart = Cart::where('user_id', $user->id)
                ->where('product_id', $request->product_id)
                ->where('unit_id', $request->unit_id)
                ->first();


            if ($cart) {
                $cart->qty += $request->qty;
                if ($unit && $unit->stock < $cart->qty) {
                    return msgdata($request, failed(), trans('lang.stock_error'), (object)[]);
                }

                $cart->save();

            } else {
                if ($unit && $unit->stock < $request->qty) {
                    return msgdata($request, failed(), trans('lang.stock_error'), (object)[]);
                }
                Cart::create([
                    'user_id' => $user->id,
                    'product_id' => $request->product_id,
                    'unit_id' => $request->unit_id,
                    'qty' => $request->qty
                ]);
            }

            return msgdata($request, success(), trans('lang.success'), (object)[]);
        } else {
            return msgdata($request, not_authoize(), trans('lang.not_authorize'), (object)[]);
        }
    }


    public function RemoveFromCart(Request $request)
    {
        $user = check_api_token($request->header('jwt'));
        if ($user) {

            $rules = [
                'cart_id' => ['required', 'exists:carts,id',],

            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return msgdata($request, failed(), $validator->messages()->first(), (object)[]);
            }

            $cart = Cart::whereId($request->cart_id)->delete();

            return msgdata($request, success(), trans('lang.success'), (object)[]);
        } else {
            return msgdata($request, not_authoize(), trans('lang.not_authorize'), (object)[]);
        }
    }

    public function GetCart(Request $request)
    {
        $user = check_api_token($request->header('jwt'));
        if ($user) {

            $cart = Cart::where('user_id', $user->id)->with('product')->get();
            $total = 0;
            foreach ($cart as $item) {
                $total += $item->unit->price * $item->qty;
            }
            $data['cart'] = CartResource::collection($cart);
            $data['total'] = $total;
            return msgdata($request, success(), trans('lang.success'), $data);
        } else {
            return msgdata($request, not_authoize(), trans('lang.not_authorize'), (object)[]);
        }
    }


    public function increaseCart(Request $request, $id)
    {
        $user = check_api_token($request->header('jwt'));
        if ($user) {

            $cart = Cart::whereId($id)->first();
            $unit = ProductUnit::where('id', $cart->unit_id)->first();

            if ($unit && $unit->stock < $cart->qty + 1) {
                return msgdata($request, failed(), trans('lang.stock_error'), (object)[]);
            }
            if (!$cart) {
                return msgdata($request, not_found(), trans('lang.not_found'), (object)[]);
            }
            $cart->qty += 1;
            $cart->save();
            return msgdata($request, success(), trans('lang.success'), (object)[]);
        } else {
            return msgdata($request, not_authoize(), trans('lang.not_authorize'), (object)[]);
        }
    }

    public function decreaseCart(Request $request, $id)
    {
        $user = check_api_token($request->header('jwt'));
        if ($user) {

            $cart = Cart::whereId($id)->first();
            if (!$cart) {
                return msgdata($request, not_found(), trans('lang.not_found'), (object)[]);
            }
            $cart->qty -= 1;
            $cart->save();
            return msgdata($request, success(), trans('lang.success'), (object)[]);
        } else {
            return msgdata($request, not_authoize(), trans('lang.not_authorize'), (object)[]);
        }
    }


    public function MakeOrder(Request $request)
    {
        $user = check_api_token($request->header('jwt'));
        if ($user) {
            $rules = [
                'coupon' => 'nullable|exists:coupons,code',
                'city_id' => 'required|exists:cities,id',
                'address' => 'required|string|min:10',
                'notes' => 'nullable|string',

            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return msgdata($request, failed(), $validator->messages()->first(), (object)[]);
            }

            $carts = Cart::where('user_id', $user->id)->get();

            if ($carts->count() == 0) {
                return msgdata($request, not_found(), trans('lang.cart_empty'), (object)[]);
            }

            $city = City::whereId($request->city_id)->first();
            $discount = Coupon::where('code', $request->coupon)->first();

            DB::beginTransaction();
            $order = Order::create([
                'name' => $user->name,
                'phone' => $user->phone,
                'address' => $request->address,
                'notes' => $request->notes,
                'status' => "new",
                'user_id' => $user->id,
                'sub_total' => 0,
                'shipping' => $city->shipping_cost,
                'discount' => 0,
                'total' => 0,
            ]);

            $sub_total = 0;
            foreach ($carts as $key => $cart) {

                $product = Product::life()->where('id', $cart->product_id)->first();
                $unit = ProductUnit::where('id', $cart->unit_id)->first();
                if ($unit->stock < $cart->qty) {
                    return msgdata($request, failed(), trans('lang.stock_error') . " " . $unit->titlr, (object)[]);
                    DB::rollback();
                }
                $total_price = $unit->price - $unit->price * ($product->offer / 100);
                $total = $cart->qty * $total_price;

                OrderDetail::create([
                        'product_id' => $cart->product_id,
                        'unit_id' => $cart->unit_id,
                        'order_id' => $order->id,
                        'quantity' => $cart->qty,
                        'price' => $total_price,
                        'total' => $total,
                    ]
                );
                $unit->stock -= $cart->qty;
                $unit->save();
                $sub_total += $total;
            }

            $order->sub_total = $sub_total;
            $discount_amount = 0;
            if ($discount) {
                $discount_usage = CouponUsage::where('coupon_id', $discount->id)
                    ->where('customer_id', $user->id)
                    ->count();
                if ($discount->usage_count < $discount_usage) {
                    if ($discount->active == 1 &&
                        Carbon::now()->format("Y-m-d") > $discount->from_date &&
                        Carbon::now()->format("Y-m-d") < $discount->to_date) {
                        if ($discount->type == "percentage") {

                            $discount_amount = $sub_total * ($discount->amount / 100);
                            $order->discount = $sub_total * ($discount->amount / 100);
                        } else {
                            $discount_amount = $discount->amount;
                            $order->discount = $discount->amount;
                        }

                        $discount->save();
                        CouponUsage::create([
                            'coupon_id' => $discount->id,
                            'customer_id' => $user->id
                        ]);
                    }
                }
            }
            $order->total = $sub_total + $order->shipping - $discount_amount;
            $order->save();

            if ($unit->stock_alert == $unit->stock) {
                //TODO::send Email to owner
                \Mail::raw('?????????? ?????????? ???? ????????????    ' . $unit->title .'???? ?????? ?????? ???????? ???????????? ', function ($message) {
                    $message->subject('Warning Mail');
                    $message->from('info@felbasket.com', 'felbasket');
                    $message->to("wael.abdelhamid1981@gmail.com");
                });
            }
            Cart::where('user_id', $user->id)->delete();

            DB::commit();
            return msgdata($request, success(), trans('lang.success'), (object)[]);
        } else {
            return msgdata($request, not_authoize(), trans('lang.not_authorize'), (object)[]);
        }
    }


    public function GetOrders(Request $request)
    {
        $user = check_api_token($request->header('jwt'));
        if ($user) {

            $cart = Order::where('user_id', $user->id)->with('OrderDetails')->get();
            $data = OrderResource::collection($cart);
            return msgdata($request, success(), trans('lang.success'), $data);
        } else {
            return msgdata($request, not_authoize(), trans('lang.not_authorize'), (object)[]);
        }
    }

}
