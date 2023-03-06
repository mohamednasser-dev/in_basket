<?php

namespace App\Http\Controllers\Api;

use App\Ad;
use App\Category;
use App\City;
use App\Http\Controllers\Controller;
use App\Http\Resources\MainCategoryResource;
use App\Http\Resources\ProductResource;
use App\Http\Resources\SliderResource;
use App\Product;
use App\SubCategory;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function sliders(Request $request)
    {
        $sliders = Ad::orderBy('id', 'desc')->with('product')->get();
        $data = SliderResource::collection($sliders);
        return response()->json(msgdata($request, success(), trans('lang.success'), $data));
    }

    public function homeProduct(Request $request)
    {
        $user = check_api_token($request->header('jwt'));
        if ($user) {
            $user_id = $user->id;
        } else {
            $user_id = null;
        }

        $sliders = Product::life()->where('offer', '!=', 0)->orderBy('id', 'desc')->get();
        $data = ProductResource::customCollection($sliders ,$user_id);

        return response()->json(msgdata($request, success(), trans('lang.success'), $data));
    }


    public function mainCategories(Request $request)
    {
        $sliders = Category::orderBy('id', 'desc')->get();
        $data = MainCategoryResource::collection($sliders);
        return response()->json(msgdata($request, success(), trans('lang.success'), $data));
    }

    public function ProductsByCategory($id, Request $request)
    {
        $user = check_api_token($request->header('jwt'));
        if ($user) {
            $user_id = $user->id;
        } else {
            $user_id = null;
        }
        $sliders = Product::life()->where('sub_category_id', $id)->orderBy('id', 'desc')->get();
        $data = ProductResource::customCollection($sliders ,$user_id);

        return response()->json(msgdata($request, success(), trans('lang.success'), $data));
    }


    public function subCategory($id, Request $request)
    {
        $sliders = SubCategory::where('category_id', $id)->orderBy('id', 'desc')->get();
        $data = MainCategoryResource::collection($sliders);
        return response()->json(msgdata($request, success(), trans('lang.success'), $data));
    }

    public function productDetails($id, Request $request)
    {
        $user = check_api_token($request->header('jwt'));
        if ($user) {
            $user_id = $user->id;
        } else {
            $user_id = null;
        }


        $sliders = Product::life()->whereId($id)->with('images')->firstOrFail();
        $data = (new ProductResource($sliders))->user_id($user_id);
        return response()->json(msgdata($request, success(), trans('lang.success'), $data));
    }


    public function cities(Request $request)
    {
        $sliders = City::where('deleted', "0")->get();
        return response()->json(msgdata($request, success(), trans('lang.success'), $sliders));
    }


}
