<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\booking;
use App\Models\user;
use App\Models\society;
use App\Models\property;
use App\Models\residentType;


class admincontroller extends Controller
{
    public function dashboard(Request $req)
    {
    	if($req->session()->get('admin')){
    		$data = $req->session()->get('admin');
    	}else{
    		return redirect('/');
    	}

        $data = user::select('users.id','name','email','contact','gender','ustatus','users.created_at','db_roles.role_name','role_id')
        ->join('db_roles','db_roles.id','users.role_id')
        ->orderBy('id', 'desc')
        ->whereNotIn('users.id',[1])
        ->get();


    	return view('admin/dashboard',compact('data'));
    }

    public function edituserstatus($id)
    {
        $user = user::where('id',$id)->first();

        if($user->ustatus == 'ENABLE')
        {
            $user->ustatus = 'DISABLE';
            $user->save();

        }
        elseif($user->ustatus == 'DISABLE')
        {
            $user->ustatus = 'ENABLE';
            $user->save();
        }

        return redirect('admin');
    }

    

    function booking(Request $req)
    {
        $booking = booking::select('bookings.id','seller.name as sellername','seller.email','buyer.name as buyername','buyer.email as buyeremail','sc.society_name','bookings.mobile_no','bookings.message','cities.city_name','areas.area_name')
        ->leftjoin('properties as pr','bookings.propety_id','pr.id')
        ->leftjoin('societies as sc','pr.society_id','sc.id')
        ->leftjoin('cities','cities.id','pr.city_id')
        ->leftjoin('areas','areas.id','pr.area_id')
        ->leftjoin('users as seller','bookings.seller_id','seller.id')
        ->leftjoin('users as buyer','bookings.buyer_id','buyer.id')
        ->get();


        return view('admin/viewbooking',compact('booking'));
    }

    function deletebooking($id)
    {
        $booking =booking::find($id);
        $booking->delete();


        return redirect('viewbooking');
    }

    function myrequest(Request $req)
    {
        if($req->session()->get('buyer')){
                   $buyer = $req->session()->get('buyer');
                   $myrequest = User::find($buyer->id);

        }

        $myrequest = booking::select('bookings.id','seller.name as sellername','seller.email','buyer.name as buyername','buyer.email as buyeremail','sc.society_name','bookings.mobile_no','bookings.message','pr.propertyimage','pr.property_status','cities.city_name','areas.area_name','resident_types.resident_type_name')

        ->leftjoin('properties as pr','bookings.propety_id','pr.id')
        ->leftjoin('societies as sc','pr.society_id','sc.id')
        ->leftjoin('cities','cities.id','pr.city_id')
        ->leftjoin('areas','areas.id','pr.area_id')
        ->leftjoin('resident_types','resident_types.id','pr.resident_type_id')
        ->leftjoin('users as seller','bookings.seller_id','seller.id')
        ->leftjoin('users as buyer','bookings.buyer_id','buyer.id')
        ->where('buyer.id',$buyer->id)
        ->get();
        return view('client.myrequest',compact('myrequest'));
    }

    function viewrequest(Request $req)
    {
        $viewrequest = property::select('properties.id as id','users.name','cities.city_name','societies.society_name','property_types.property_type_name','resident_types.resident_type_name','property_status','price','propertyimage','size','status','areas.area_name')
        ->join('users','users.id','properties.user_id')
        ->join('cities','cities.id','properties.city_id')
        ->join('areas','areas.id','properties.area_id')
        ->join('societies','societies.id','properties.society_id')
        ->join('property_types','property_types.id','properties.property_type_id')
        ->join('resident_types','resident_types.id','properties.resident_type_id')
        ->where('status','=','Pending')
        ->get();
        
        return view('admin.viewrequest',compact('viewrequest'));
    }

    function viewimage(Request $req)
    {
        $i = $req->input('img');
        $image = explode('|',$i);

        foreach($image as $l)
        {
            echo $return = '<img src="'.url('propertyimages/'.$l).'" class="table-responsive">';

            echo "<br>";
        }   
    }



    function editpropertystatus($id)
    {
        $pro = property::where('id',$id)->first();
        if ($pro->status == 'Pending') {
               
               $pro->status = 'success';
               $pro->save();
           }   

        return redirect('viewrequest');
    }

    function editpropertystatuss($id)
    {
        $property = property::where('id',$id)->first();
        if ($property->status == 'success') {
               
               $property->status = 'reject';
               $property->save();
           }
        elseif ($property->status == 'reject') {
           
           $property->status = 'success';
           $property->save();
        }   

        return redirect('viewproperty');
    }

    function viewproperty()
    {
        $viewproperty = property::select('properties.id as id','users.name','cities.city_name','societies.society_name','property_types.property_type_name','resident_types.resident_type_name','property_status','price','propertyimage','size','status','areas.area_name','users.contact')
        ->join('users','users.id','properties.user_id')
        ->join('cities','cities.id','properties.city_id')
        ->join('areas','areas.id','properties.area_id')
        ->join('societies','societies.id','properties.society_id')
        ->join('property_types','property_types.id','properties.property_type_id')
        ->join('resident_types','resident_types.id','properties.resident_type_id')
        ->Orwhere('status','=','success')
        ->Orwhere('status','=','reject')
        ->get();
        
        return view('admin.viewproperty',compact('viewproperty'));
    
    }

    function deleteproperty($id)
    {
        $property =property::find($id);
        $property->delete();


        return redirect('viewproperty');
    }



}
