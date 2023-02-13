<?php

namespace App\Http\Controllers\Admin;

use App\Coupon;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\City;
use App\Area;


class CouponsController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Coupon::OrderBy('id', 'desc')->get();
        return view('admin.coupons.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.coupons.create');
    }


    public function store(Request $request)
    {
        $data = $this->validate(\request(),
            [
                'code' => ['required', 'string', 'max:25'],
                'from_date' => 'required|date|after_or_equal:' . Carbon::now()->format('Y-m-d'),
                'to_date' => 'required|date|after_or_equal:from_date',
                'amount' => 'required|numeric|min:0',
            ]);
        Coupon::create($data);
        session()->flash('success', trans('messages.added_s'));
        return redirect(route('coupons.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $city_id = $id;
        $data = Area::where('city_id', $id)->OrderBy('id', 'desc')->get();
        return view('admin.coupons.areas.index', compact('data', 'city_id'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Coupon::findOrFail($id);
        return view('admin.coupons.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $data = $this->validate(\request(),
            [
                'code' => ['required', 'string', 'max:25'],
                'from_date' => 'required|date|after_or_equal:' . Carbon::now()->format('Y-m-d'),
                'to_date' => 'required|date|after_or_equal:from_date',
                'amount' => 'required|numeric|min:0',
            ]);
        Coupon::findOrFail($id)->update($data);
        session()->flash('success', trans('messages.updated_s'));
        return redirect(route('coupons.index'));
    }

    public function destroy($id)
    {
        Coupon::findOrFail($id)->delete();
        session()->flash('success', trans('messages.deleted_s'));
        return back();
    }

}
