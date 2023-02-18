<?php

namespace App\Http\Controllers\Api;

use App\Ad;
use App\Category;
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
        $sliders = Product::where('offer', '!=', 0)->orderBy('id', 'desc')->get();
        $data = ProductResource::collection($sliders);
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
        $sliders = Product::where('sub_category_id', $id)->orderBy('id', 'desc')->get();
        $data = ProductResource::collection($sliders);
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
        $sliders = Product::whereId($id)->with('images')->firstOrFail();
        $data = new ProductResource($sliders);
        return response()->json(msgdata($request, success(), trans('lang.success'), $data));
    }


}
