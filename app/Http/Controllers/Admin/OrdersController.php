<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\ProductUnit;
use Illuminate\Http\Request;
use App\Order;
use App\OrderDetail;

class OrdersController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Order::Query();

        if ($request->user_id && $request->user_id != 'all_users') {
            $data = $data->where('user_id', $request->user_id);
        }
        if ($request->status && $request->status != 'all') {
            $data = $data->where('status', $request->status);
        }

        if ($request->from_date && $request->to_date) {
            $data = $data->whereDate('created_at', '>=', $request->from_date)->where('created_at', '<=', $request->to_date);
        }
        $data = $data->orderBy('created_at', 'desc')->get();
        return view('admin.orders.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Order::where('id', $id)->first();
        return view('admin.orders.order_details', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    public function change_status($status, $id)
    {
        $data['status'] = $status;
        $order = Order::findOrFail($id);
        Order::where('id', $id)->update($data);
        if ($status == 'rejected') {
            if (count($order->OrderDetails) > 0) {
                foreach ($order->OrderDetails as $row) {
                    $return_stock = $row->quantity * $row->Unit->quantity;
                    $unit = ProductUnit::where('id', $row->unit_id)->first();
                    $unit->stock = $unit->stock + $return_stock;
                    $unit->save();
                }
            }
        }
        session()->flash('success', trans('messages.status_changed_s'));
        return back();
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
