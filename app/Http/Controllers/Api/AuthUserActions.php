<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Http\Resources\WishlistResource;
use App\Product;
use App\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;

class AuthUserActions extends Controller
{
    public function AddToWishlist(Request $request)
    {
            $user = check_api_token($request->header('jwt'));
        if ($user) {

            $rules = [
                'product_id' => ['required', 'exists:products,id',
                    Rule::unique('wishlists')->where(function ($query) use ($user, $request) {
                        return $query->where('product_id', $request->product_id)
                            ->where('user_id', $user->id);
                    }),],

            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return msgdata($request, failed(), $validator->messages()->first(), (object)[]);
            }
            Wishlist::create([
                'product_id' => $request->product_id,
                'user_id' => $user->id,
            ]);
            return msgdata($request, success(), trans('lang.success'), (object)[]);
        } else {
            return msgdata($request, not_authoize(), trans('lang.not_authorize'), (object)[]);
        }
    }

    public function RemoveFromWishlist(Request $request)
    {
        $user = check_api_token($request->header('jwt'));
        if ($user) {

            $rules = [
                'product_id' => ['required', 'exists:products,id',
                    Rule::exists('wishlists')->where(function ($query) use ($user, $request) {
                        return $query->where('product_id', $request->product_id)
                            ->where('user_id', $user->id);
                    }),],

            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return msgdata($request, failed(), $validator->messages()->first(), (object)[]);
            }
            Wishlist::where('user_id', $user->id)->where('product_id', $request->product_id)->delete();
            return msgdata($request, success(), trans('lang.success'), (object)[]);
        } else {
            return msgdata($request, not_authoize(), trans('lang.not_authorize'), (object)[]);
        }
    }

    public function wishlist(Request $request)
    {
        $user = check_api_token($request->header('jwt'));
        if ($user) {
            $wishlist = Wishlist::where('user_id', $user->id)->get();
            $data = WishlistResource::collection($wishlist);
            return response()->json(msgdata($request, success(), trans('lang.success'), $data));
        } else {
            return msgdata($request, not_authoize(), trans('lang.not_authorize'), (object)[]);
        }

    }

}
