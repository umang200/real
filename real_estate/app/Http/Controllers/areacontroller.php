<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\area;
use App\Models\city;

class areacontroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        if($req->ajax())
        {
            $area = area::select('areas.id','areas.city_id','area_name','cities.city_name')
        ->join('cities','cities.id','areas.city_id')
        ->get();
            return view('admin.get_all_area',compact('area'));
        }
        else
        {
            $area = area::select('areas.id','areas.city_id','area_name','cities.city_name')
            ->join('cities','cities.id','areas.city_id')
            ->get();
        return view('admin.viewarea',compact('area'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.addarea');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'city' => 'required',
            'area_name' => 'required|max:255',
        ]);
        if($request->input('submit')){

            $city = $request->input('city');
            $area = $request->input('area_name');
            // area::create([
            //         'city_id' =>$city,
            //         'area_name'=>$area
            // ]);
              $area_model = new area;
              $area_model->city_id=$city;
              $area_model->area_name=$area;
              $area_model->save();

            return redirect()->route('area.create');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $area = area::find($id);
        return view('admin\editarea',compact('area'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validate= $request->validate([
            'city' => 'required',
            'area_name' => 'required|max:255',
        ]);

        $area_name = area::find($id);

        $area_name->city_id = $request->input('city');
        $area_name->area_name = $request->input('area_name');
        $area_name->save();
 
        return redirect()->route('area.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $area = area::find($id);
        $area->delete();
    }
}
