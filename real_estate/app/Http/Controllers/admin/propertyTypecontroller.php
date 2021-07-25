<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\propertyType;

class propertyTypecontroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        if($req->ajax()){
            $propertyType = propertyType::all();
            return view('admin.get_all_propertyType',compact('propertyType'));
        }else{

        $propertyType = propertyType::all();
        return view('admin.viewpropertyType',compact('propertyType'));   
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        return view('admin/addpropertyType');
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
            'property_type_name' => 'required|unique:property_types|max:255',
        ]);
        if($request->input('submit')){
            $propertyType = $request->input('property_type_name');
            propertyType::create([
                    'property_type_name'=>$propertyType
            ]);
            return redirect('propertyType');
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
        $propertyType = propertyType::find($id);
        return view('admin\editpropertyType',compact('propertyType'));
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
            'property_type_name' => 'required|unique:property_types|max:255',
        ]);

        $propertyType = propertyType::find($id);

        $propertyType->property_type_name = $request->input('property_type_name');
        $propertyType->save();
 
        return redirect('propertyType');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $propertyType = propertyType::find($id);
        $propertyType->delete();

    }
}
