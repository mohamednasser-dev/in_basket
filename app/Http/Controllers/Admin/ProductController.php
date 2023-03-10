<?php

namespace App\Http\Controllers\Admin;

use App\Cart;
use App\Category_option;
use App\Category_option_value;
use App\Http\Controllers\Admin\categories\OptionsValuesController;
use App\Plan;
use App\Area;
use App\Marka;
use App\Color;
use App\ProductUnit;
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


class ProductController extends AdminController
{
    // show
    public function show()
    {
        $data['products'] = Product::where('deleted', 0)->orderBy('id', 'desc')->get();
        return view('admin.products.products', ['data' => $data]);
    }

    // add get
    public function addGet()
    {
        $data['categories'] = Category::orderBy('created_at', 'desc')->get();
        $data['users'] = User::orderBy('created_at', 'desc')->get();
        return view('admin.products.product_form', ['data' => $data]);
    }

    // add post
    public function AddPost(Request $request)
    {
        $data = $this->validate(\request(),
            [
                'category_id' => 'required',
                'sub_category_id' => 'required',
                'title_ar' => 'required',
                'title_en' => 'required',
//                'price' => 'required|numeric|min:0',
                'offer' => 'nullable|min:0|max:100',
                'description_ar' => 'nullable',
                'description_en' => 'nullable',
                'main_image' => 'required',
                'unites' => 'required|array|min:1'
            ]);
        $data['user_id'] = auth()->user()->id;
        $mytime = Carbon::now();
        $today = Carbon::parse($mytime->toDateTimeString())->format('Y-m-d H:i');
        $data['publication_date'] = $today;
        $data['publish'] = 'Y';
        $product = Product::create($data);
        if ($request->images != null) {
            foreach ($request->images as $image) {
                $data_image['product_id'] = $product->id;
                $data_image['image'] = $image;
                ProductImage::create($data_image);
            }
        }
        if (count($request->unites) > 0) {
            foreach ($request->unites as $key => $unit) {
                $unit_data['product_id'] = $product->id;
                $unit_data['unit_ar'] = $unit['unit_ar'];
                $unit_data['unit_en'] = $unit['unit_en'];
                $unit_data['quantity'] = $unit['quantity'];
                $unit_data['price'] = $unit['price'];
                $unit_data['stock'] = $unit['stock'];
                $unit_data['stock_alert'] = $unit['stock_alert'];
                ProductUnit::create($unit_data);
            }
        }
        session()->flash('success', trans('messages.added_s'));
        return redirect()->route('products.index');
    }

    // edit get
    public function edit($id)
    {
        $data = Product::find($id);
        return view("admin.products.product_edit", compact('data'));
    }

    // edit post
    public function EditPost(Request $request, $id)
    {
        $prod = Product::find($id);
        $data = $this->validate(\request(),
            [
                'category_id' => 'required',
                'sub_category_id' => 'required',
                'title_ar' => 'required',
                'title_en' => 'required',
//                'price' => 'required',
                'offer' => 'nullable|numeric|min:0|max:100',
                'description_ar' => 'nullable',
                'description_en' => 'nullable',
                'main_image' => 'nullable'
            ]);
        if ($request->main_image != null) {
            if (is_file($request->main_image)) {
                $img_name = 'product_' . time() . rand(0000, 9999) . '.' . $request->main_image->getClientOriginalExtension();
                $request->main_image->move(public_path('/uploads/products/'), $img_name);
                $data['main_image'] = $img_name;
            }
        }
        Product::where('id', $id)->update($data);
        if ($request->images != null) {
            foreach ($request->images as $image) {
                if (is_file($image)) {
                    $data_image['product_id'] = $id;
                    $data_image['image'] = $image;
                    ProductImage::create($data_image);
                }
            }
        }
        session()->flash('success', trans('messages.updated_s'));
        return redirect()->route('products.index');
    }

    // delete product image
    public function delete_product_image($id)
    {
        ProductImage::where('id', $id)->delete();
        return redirect()->back();
    }

    // product details
    public function details($product_id)
    {
        $data = Product::where('id', $product_id)->first();
        return view('admin.products.product_details', compact('data'));
    }

    // product unites
    public function unites($product_id)
    {
        $data = ProductUnit::where('product_id', $product_id)->get();
        return view('admin.products.product_unites', compact('data'));
    }


    // delete product
    public function delete(Product $product)
    {
//        if (count($product->images) > 0) {
//            foreach ($product->images as $row) {
//                unlink('uploads/products/' . $row->image);
//                $row->delete();
//            }
//        }
//        unlink('uploads/products/' . $product->main_image);
        $product->deleted = 1;
        $product->save();

        Cart::where('product_id', $product->id)->delete();
        session()->flash('success', trans('messages.deleted_s'));
        return redirect()->back();
    }

    public function get_sub_cat(Request $request, $id)
    {
        $data = SubCategory::where('category_id', $id)->where('deleted', 0)->get();
        return view('admin.products.parts.categories.sub_category', compact('data'));
    }

    public function get_sub_two_cat(Request $request, $id)
    {
        $data = SubTwoCategory::where('sub_category_id', $id)->where('deleted', 0)->get();
        return view('admin.products.parts.categories.sub_two_categories', compact('data'));
    }

    public function get_sub_three_cat(Request $request, $id)
    {
        $data = SubThreeCategory::where('sub_category_id', $id)->where('deleted', 0)->get();
        return view('admin.products.parts.categories.sub_three_categories', compact('data'));
    }

    public function get_sub_four_cat(Request $request, $id)
    {
        $data = SubFourCategory::where('sub_category_id', $id)->where('deleted', 0)->get();
        return view('admin.products.parts.categories.sub_four_categories', compact('data'));
    }

    public function get_sub_five_cat(Request $request, $id)
    {
        $data = SubFiveCategory::where('sub_category_id', $id)->where('deleted', '0')->get();
        return view('admin.products.parts.categories.sub_five_categories', compact('data'));
    }

    public function get_brands(Request $request, $id)
    {
        $cat_option = Category_option::where('cat_id', $id)->where('title_en', 'brand')->first();

        $data = Category_option_value::where('option_id', $cat_option->id)->where('deleted', '0')->get();

        return view('admin.products.parts.options.brands', compact('data'));
    }

    public function get_areas(Request $request, $id)
    {
        $data = Area::where('city_id', $id)->where('deleted', '0')->get();
        return view('admin.products.parts.categories.areas', compact('data'));
    }

    public function get_brand_types(Request $request, $id)
    {
        $cat_option = Category_option::where('cat_id', $id)->where('title_en', 'brand type')->first();
        $data = Category_option_value::where('option_id', $cat_option->id)->where('deleted', '0')->get();
        return view('admin.products.parts.options.brand_types', compact('data'));
    }

    public function get_model_year(Request $request, $id)
    {
        $cat_option = Category_option::where('cat_id', $id)->where('title_en', 'model year')->first();
        $data = Category_option_value::where('option_id', $cat_option->id)->where('deleted', '0')->get();
        return view('admin.products.parts.options.model_years', compact('data'));
    }

    public function get_counter(Request $request, $id)
    {
        $cat_option = Category_option::where('cat_id', $id)->where('title_en', 'speedometer')->first();
        $data = Category_option_value::where('option_id', $cat_option->id)->where('deleted', '0')->get();
        return view('admin.products.parts.options.counter', compact('data'));
    }

    public function get_plan(Request $request, $id)
    {
        $data = Plan::where('status', 'show')
            ->where('cat_id', $id)
            ->orwhere('cat_id', 'all')
            ->get();
        return view('admin.products.parts.plans.plans', compact('data'));
    }

    public function colors()
    {
        $data = Color::where('deleted', '0')->orderBy('created_at', 'desc')->get();
        return view('admin.products.colors.index', compact('data'));
    }

    public function color_delete($id)
    {
        $input['deleted'] = '1';
        Color::where('id', $id)->update($input);
        session()->flash('success', trans('messages.deleted_s'));
        return back();
    }

    public function color_store(Request $request)
    {
        $input['title_ar'] = $request->title_ar;
        Color::create($input);
        session()->flash('success', trans('messages.added_s'));
        return back();
    }

    public function color_update(Request $request)
    {
        $input['title_ar'] = $request->title_ar;
        Color::where('id', $request->id)->update($input);
        session()->flash('success', trans('messages.updated_s'));
        return back();
    }

    public function brands()
    {
        $data = Marka::where('deleted', '0')->orderBy('created_at', 'desc')->get();
        return view('admin.products.brands.index', compact('data'));
    }

    public function brand_delete($id)
    {
        $input['deleted'] = '1';
        Marka::where('id', $id)->update($input);
        session()->flash('success', trans('messages.deleted_s'));
        return back();
    }

    public function brand_store(Request $request)
    {
        $input['title_ar'] = $request->title_ar;
        Marka::create($input);
        session()->flash('success', trans('messages.added_s'));
        return back();
    }

    public function brand_update(Request $request)
    {
        $input['title_ar'] = $request->title_ar;
        Marka::where('id', $request->id)->update($input);
        session()->flash('success', trans('messages.updated_s'));
        return back();
    }


}
