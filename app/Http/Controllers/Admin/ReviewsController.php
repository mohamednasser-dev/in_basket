<?php

namespace App\Http\Controllers\Admin;

use App\Category_option;
use App\Category_option_value;
use App\Plan;
use App\Area;
use App\Marka;
use App\Color;
use App\ProductUnit;
use App\Review;
use App\SubCategory;
use App\SubFiveCategory;
use App\SubFourCategory;
use App\SubThreeCategory;
use App\SubTwoCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Product;
use App\ProductImage;
use App\Category;
use App\User;


class ReviewsController extends AdminController
{

    // product unites
    public function index($product_id)
    {
        $data = Review::where('product_id', $product_id)->get();
        return view('admin.products.reviews.index', compact('data', 'product_id'));
    }
    // delete product
    public function delete($id)
    {
        try {
            Review::whereId($id)->delete();
            session()->flash('success', trans('messages.deleted_s'));
            return redirect()->back();
        } catch (\Exception $ex) {
            session()->flash('danger', 'لا يمكن حذف التقييم لانها مستخدمة في طلب من قبل');
            return redirect()->back();
        }
    }

}
