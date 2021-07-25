<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\society;
use App\Models\city;
use App\Models\area;

class societycontroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        if($req->ajax()){
            $society = society::all();
            return view('admin.get_all_society',compact('society'));
        }else{

        $society = society::all();
        return view('admin.viewsociety',compact('society'));   
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/addsociety');
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
            'area' => 'required',
            'society_name' => 'required|unique:societies|max:255',
        ]);
        if($request->input('submit')){
            $society = $request->input('society_name');
            $area = $request->input('area');
            society::create([
                    'area_id' => $area,
                    'society_name'=>$society
            ]);
            return redirect('society');
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

     function dependent(Request $req)
    {
        if($req->input('city'))
        {
            $city = $req->input('city');
            $area = area::select('areas.id','area_name')
            ->join('cities','cities.id','areas.city_id')
            ->where('areas.city_id',$city)
            ->get();

            return view('admin.dependent_area',compact('area'));
        }
    }
    public function edit($id)
    {
        $society = society::find($id);
        return view('admin\editsociety',compact('society'));
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
            'society_name' => 'required|unique:societies|max:255',
        ]);

        $society_name = society::find($id);

        $society_name->society_name = $request->input('society_name');
        $society_name->save();
 
        return redirect('society');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $society = society::find($id);
        $society->delete();

    }
}
