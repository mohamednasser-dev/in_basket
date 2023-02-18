<?php

namespace App\Http\Controllers\Api;

use App\Cart;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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
                'qty' => ['required', 'numeric'],


            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return msgdata($request, failed(), $validator->messages()->first(), (object)[]);
            }
            $cart = Cart::where('user_id', $user->id)
                ->where('product_id', $request->product_id)
                ->first();
            if ($cart) {

                $cart->qty = $request->qty;

                $cart->save();

            } else {
                Cart::create([
                    'user_id' => $user->id,
                    'product_id' => $request->product_id,
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
                'product_id' => ['required', 'exists:products,id',
                    Rule::exists('carts')->where(function ($query) use ($user, $request) {
                        return $query->where('product_id', $request->product_id)
                            ->where('user_id', $user->id);
                    }),],

            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return msgdata($request, failed(), $validator->messages()->first(), (object)[]);
            }
            Cart::where('user_id', $user->id)->where('product_id', $request->product_id)->delete();
            return msgdata($request, success(), trans('lang.success'), (object)[]);
        } else {
            return msgdata($request, not_authoize(), trans('lang.not_authorize'), (object)[]);
        }
    }
}
