<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\residentType;

class residentTypecontroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        if($req->ajax()){
            $resident = residentType::all();
            return view('admin.get_all_resident',compact('resident'));
        }else{

        $resident = residentType::all();
        return view('admin.viewresidentType',compact('resident'));   
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/addresidentType');
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
            'resident_type_name' => 'required|unique:resident_types|max:255',
        ]);
        if($request->input('submit')){
            $resident = $request->input('resident_type_name');
            residentType::create([
                    'resident_type_name'=>$resident
            ]);
             return redirect('residentType');
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
        $resident = residentType::find($id);
        return view('admin\editresidentType',compact('resident'));
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
            'resident_type_name' => 'required|unique:resident_types|max:255',
        ]);

        $resident = residentType::find($id);

        $resident->resident_type_name = $request->input('resident_type_name');
        $resident->save();
 
        return redirect('residentType');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $resident = residentType::find($id);
        $resident->delete();

    }
}
