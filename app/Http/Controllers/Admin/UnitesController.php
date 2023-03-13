<?php

namespace App\Http\Controllers\Admin;

use App\Category_option;
use App\Category_option_value;
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


class UnitesController extends AdminController
{

    // product unites
    public function index($product_id)
    {
        $data = ProductUnit::where('product_id', $product_id)->get();
        return view('admin.products.unites.index', compact('data', 'product_id'));
    }

    // add get
    public function create($product_id)
    {
        return view('admin.products.unites.create', compact('product_id'));
    }

    // add post
    public function store(Request $request)
    {
        $data = $this->validate(\request(),
            [
                'product_id' => 'required|exists:products,id',
                'unit_ar' => 'required',
                'unit_en' => 'required',
                'quantity' => 'required|numeric|min:0',
                'price' => 'required|numeric|min:0',
                'stock' => 'required|numeric|min:0',
                'stock_alert' => 'required|numeric|min:0',
            ]);
        ProductUnit::create($data);
        session()->flash('success', trans('messages.added_s'));
        return redirect()->route('unites.index', $request->product_id);
    }

    // edit get
    public function edit($id)
    {
        $data = ProductUnit::find($id);
        return view("admin.products.unites.edit", compact('data', 'id'));
    }

    // edit post
    public function update(Request $request, $id)
    {
        $data = $this->validate(\request(),
            [
                'unit_ar' => 'required',
                'unit_en' => 'required',
                'quantity' => 'required|numeric|min:0',
                'price' => 'required|numeric|min:0',
                'stock' => 'required|numeric|min:0',
                'stock_alert' => 'required|numeric|min:0',
            ]);
        $prod = ProductUnit::find($id);
        ProductUnit::whereId($id)->update($data);
        session()->flash('success', trans('messages.updated_s'));
        return redirect()->route('unites.index', $prod->product_id);
    }

    // delete product
    public function delete($id)
    {
        try {
            $unit = ProductUnit::whereId($id)->first();
            $product_unites = ProductUnit::where('product_id', $unit->product_id)->get();
            if (count($product_unites) == 1) {
                session()->flash('danger', 'لا يمكن الحذف - يجب ان يكون هناك وحده على الاقل داخل المنتج');
                return redirect()->back();
            }
            ProductUnit::whereId($id)->delete();
            session()->flash('success', trans('messages.deleted_s'));
            return redirect()->back();
        } catch (\Exception $ex) {
            session()->flash('danger', 'لا يمكن حذف الوحده لانها مستخدمة في طلب من قبل');
            return redirect()->back();
        }

    }

}
