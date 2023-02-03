<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\City;
use App\Area;


class CityController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = City::where('deleted', '0')->OrderBy('id', 'desc')->get();
        return view('admin.cities.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.cities.create');
    }


    public function store(Request $request)
    {
        $data = $this->validate(\request(),
            [
                'title_ar' => 'required',
                'title_en' => 'required',
                'shipping_cost' => 'required|numeric|min:0',
            ]);
        City::create($data);
        session()->flash('success', trans('messages.added_s'));
        return redirect(route('cities.index'));
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
        $data = Area::where('city_id', $id)->where('deleted', '0')->OrderBy('id', 'desc')->get();
        return view('admin.cities.areas.index', compact('data', 'city_id'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = City::findOrFail($id);
        return view('admin.cities.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $data = $this->validate(\request(),
            [
                'title_ar' => 'required',
                'title_en' => 'required',
                'shipping_cost' => 'required|numeric|min:0',
            ]);
        City::findOrFail($id)->update($data);
        session()->flash('success', trans('messages.updated_s'));
        return redirect(route('cities.index'));
    }

    public function destroy($id)
    {
        $data['deleted'] = '1';
        City::findOrFail($id)->update($data);
        session()->flash('success', trans('messages.deleted_s'));
        return back();
    }

}
