<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\property;
use App\Models\booking;
use App\Models\user;
use App\Models\city;
use App\Models\area;
use App\Models\society;


class propertycontroller extends Controller
{
    function addproperty(Request $req)
    {
    	if($req->session()->get('user')){
    		$s = $req->session()->get('user');
    	}

    	$adddata = New property;

    	if ($req->input('addproperty')) {
    		
    		$validated = $req->validate([
    			'city' => 'required',
    			'society' => 'required',
                'area_name' => 'required',
    			'residentType' => 'required',
    			'propertyType' => 'required',
    			'SellorRent' => 'required',
    			'price' => 'required',
    			'size' => 'required',
    			'propertyimage' => 'required',
    		]);


    		if($req->file('propertyimage')) {
    			$file = $req->file('propertyimage');
                foreach($file as $f)
                {
                    $filename = $f->getClientOriginalName();
                    $extension = $f->extension();
                    $f->move('propertyimages',$filename);   

                    $arr[]=$filename; 
                }
                $propertyimage = implode("|",$arr);
    			
    		}

    		$adddata->user_id = $s->id;
    		$adddata->city_id = $req->input('city');
            $adddata->area_id = $req->input('area_name'); 
    		$adddata->society_id = $req->input('society');
    		$adddata->resident_type_id = $req->input('residentType');
    		$adddata->property_type_id = $req->input('propertyType');
    		$adddata->size = $req->input('size');
    		$adddata->price = $req->input('price');
    		$adddata->property_status = $req->input('SellorRent');
    		$adddata->propertyimage = $propertyimage;
    		$adddata->status = 'Pending';
    		$adddata->save();



    	}
    	return view('client/addproperty');

    }

    function addpropertydependent(Request $req)
    {
        if($req->input('city'))
        {
            $city = $req->input('city');
            $area = area::select('areas.id','area_name')
            ->join('cities','cities.id','areas.city_id')
            ->where('areas.city_id',$city)
            ->get();

            return view('client.area_dependent',compact('area'));
        }
    }

    function addpropertydependents(Request $req)
    {
        if($req->input('area'))
        {
            $area = $req->input('area');
            $society= society::select('societies.id','societies.society_name')
            ->join('areas','areas.id','societies.area_id')
            ->where('societies.area_id',$area)
            ->get();

            return view('client.society_dependent',compact('society'));
        }
    }

    
    
    function singleproperty(Request $req,$id)
    {
        if ($req->session()->get('buyer'))
        {
            $b = $req->session()->get('buyer');
        }else
            {
                    return redirect('/');
            }

            $property = property::select('users.id as seller_id','users.profile','properties.id as property_id','users.name','users.email','cities.city_name','societies.society_name','property_types.property_type_name','resident_types.resident_type_name','property_status','price','propertyimage','size','societies.area_id','areas.id','areas.area_name')
            ->join('users','users.id','properties.user_id')
        ->join('cities','cities.id','properties.city_id')
        ->join('areas','areas.id','properties.area_id')
        ->join('societies','societies.id','properties.society_id')
        ->join('property_types','property_types.id','properties.property_type_id')
        ->join('resident_types','resident_types.id','properties.resident_type_id')
        ->where('properties.id',$id)
        ->get();

           
            
            return view('client/singleproperty',compact('property','b'));     
        

    }

    function myproperty(Request $req)
    {
        if($req->session()->get('user')){
                   $a = $req->session()->get('user');
                   $myproperty = User::find($a->id);

        }


        $myproperty = property::select('properties.id as pid','users.name','cities.city_name','societies.society_name','property_types.property_type_name','resident_types.resident_type_name','property_status','price','propertyimage','size','status','areas.area_name')
        ->join('users','users.id','properties.user_id')
        ->join('cities','cities.id','properties.city_id')
        ->join('areas','areas.id','properties.area_id')
        ->join('societies','societies.id','properties.society_id')
        ->join('property_types','property_types.id','properties.property_type_id')
        ->join('resident_types','resident_types.id','properties.resident_type_id')
        ->where('users.id',$a->id)
        ->get();
        
        return view('client.myproperty',compact('myproperty'));
    }

    function booking(Request $req)
    {
        if($req->input('sendmessage')){

            booking::create([

                'seller_id'=>$req->input('seller_id'),
                'buyer_id'=>$req->input('buyer_id'),
                'propety_id'=>$req->input('property_id'),
                'mobile_no'=>$req->input('mobile_no'),
                'message'=>$req->input('message')
            ]);
            return redirect('/');
        }
    }

}