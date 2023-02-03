<?php

namespace App\Http\Controllers\Admin\categories;

use App\Category_option;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;
use JD\Cloudder\Facades\Cloudder;
use Illuminate\Support\Facades\DB;
use App\Category;

class CategoryController extends AdminController
{
    // type : get -> to add new
    public function AddGet()
    {
        return view('admin.categories.create');
    }

    // type : post -> add new category
    public function AddPost(Request $request)
    {
        $category = new Category();
        $category->title_en = $request->title_en;
        $category->title_ar = $request->title_ar;
        $category->image = $request->file('image');
        $category->save();

        session()->flash('success', trans('messages.added_s'));
        return redirect('admin-panel/categories/show');
    }

    // get all categories
    public function show()
    {
        $data['categories'] = Category::where('deleted', 0)->orderBy('id', 'desc')->get();
        return view('admin.categories.index', ['data' => $data]);
    }

    // get edit page
    public function EditGet(Request $request)
    {
        $data['category'] = Category::find($request->id);
        return view('admin.categories.edit', ['data' => $data]);
    }

    // edit category
    public function EditPost(Request $request)
    {
        $category = Category::find($request->id);
        if ($request->file('image')) {
            if (is_file($request->file('image'))) {
                $img_name = 'category_' . time() . rand(0000, 9999) . '.' . $request->file('image')->getClientOriginalExtension();
                $request->file('image')->move(public_path('/uploads/categories/'), $img_name);
                $category->image = $img_name;
            }
        }
        $category->title_en = $request->title_en;
        $category->title_ar = $request->title_ar;
        $category->save();
        return redirect('admin-panel/categories/show');
    }

    // delete category
    public function delete(Request $request)
    {
        $category = Category::find($request->id);
        $category->deleted = 1;
        $category->save();
        return redirect()->back();
    }

    // get category products
    public function category_products(Category $category)
    {
        $data['products'] = $category->products;
        if (app()->getLocale() == 'en') {
            $data['category'] = $category->title_en;
        } else {
            $data['category'] = $category->title_ar;
        }
        return view('admin.products.products', ['data' => $data]);
    }
}
