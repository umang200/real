<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\property;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\session;
use Illuminate\Support\str;
use Mail;

class landingcontroller extends Controller
{
    public function login(Request $req)
    {

    	$User = new User();
    	
        
        if($req->input('login')){
    		$e =$req->input('email');
    		$p =$req->input('password'); 


    		
    		$check = $User::where('email',$e)->first();
 		
 			if($check){
                if($check->ustatus == 'ENABLE')
                {
     				if(Hash::check($p,$check->password)){
     					if($check->role_id == 1){
     						$req=session()->put('admin',$check);
     						return redirect('admin');
     					}
                        if($check->role_id == 2){
                            $req=session()->put('user',$check);
                            return redirect('/');
                        }
                        if($check->role_id == 3){
                            $req=session()->put('buyer',$check);
                            return redirect('/'); 
                         }             
     				}
                }
                else{

                    return redirect('login')->with('success','Your Email ID has Been Block By Admin');
                    
                }
 			}
    	}
    	else{
         
    	}
    	return view('login');

    }

    function loading(Request $res){

        $fileter = [];
        $fileter = $_GET;

        $property = property::select('properties.id as pid','users.name','cities.city_name','societies.society_name','property_types.property_type_name','resident_types.resident_type_name','property_status','price','propertyimage','size','areas.area_name')
        ->join('users','users.id','properties.user_id')
        ->join('cities','cities.id','properties.city_id')
        ->join('areas','areas.id','properties.area_id')
        ->join('societies','societies.id','properties.society_id')
        ->join('property_types','property_types.id','properties.property_type_id')
        ->join('resident_types','resident_types.id','properties.resident_type_id')
        ->where('properties.status','=','success');
        
        if($fileter['location']) 
        {
        
            $property->where('cities.city_name',$fileter['location']);
        
        }
        if($fileter['property_status'])
        {

            $property->where('property_status',$fileter['property_status']);
            
        }
        if($fileter['property_type_name'])
        {

            $property->where('property_type_name',$fileter['property_type_name']);
            
        }
        

        $data = $property->get();

        return $data;

    }

    
    public function logout(Request $req)
    {
        if($req->session()->get('admin')){
            $req->session()->forget('admin');
            return redirect('/');
        }
        if($req->session()->get('user')){
            $req->session()->forget('user');
            return redirect('/');
        }
        if($req->session()->get('buyer')){
            $req->session()->forget('buyer');
            return redirect('/');
        }
    }
    public function signup(Request $req)
    {
        $User = new User();




         if($req->input('signup')){
        
            $validated = $req->validate([
            'name' => 'required|unique:users',
            'email' => 'required|unique:users',
            'password' => 'required',
            'contact' => 'required',
            'choose_role' =>'required',
            ]);                

            $User->name = $req->input('name');
            $User->email = $req->input('email');
            $User->contact = $req->input('contact');
            $User->password = Hash::make($req->input('password'));
            $User->ustatus = 'ENABLE';
            $User->role_id = $req->input('choose_role');
            $User->save();
            return view('login');
        }
        return view('signup');
    }
    
    public function home(Request $req)
    {
        if($req->ajax()){

            $property = property::select('properties.id as pid','users.name','cities.city_name','societies.society_name','property_types.property_type_name','resident_types.resident_type_name','property_status','price','propertyimage','size','areas.area_name')
        ->join('users','users.id','properties.user_id')
        ->join('cities','cities.id','properties.city_id')
        ->join('areas','areas.id','properties.area_id')
        ->join('societies','societies.id','properties.society_id')
        ->join('property_types','property_types.id','properties.property_type_id')
        ->join('resident_types','resident_types.id','properties.resident_type_id')
        ->where('properties.status','=','success')

        ->get();
        
        return view('cilent/filter_city_view',compact('property'));
        }else{

            $property = property::select('properties.id as pid','users.name','cities.city_name','societies.society_name','property_types.property_type_name','resident_types.resident_type_name','property_status','price','propertyimage','size','areas.area_name')
        ->join('users','users.id','properties.user_id')
        ->join('cities','cities.id','properties.city_id')
        ->join('areas','areas.id','properties.area_id')
        ->join('societies','societies.id','properties.society_id')
        ->join('property_types','property_types.id','properties.property_type_id')
        ->join('resident_types','resident_types.id','properties.resident_type_id')
        ->where('properties.status','=','success')
        ->get();
        
        return view('client/home',compact('property'));
        }
    }

    public function manageprofile(Request $req)
    {

        if($req->session()->get('user')){
                   $a = $req->session()->get('user');
                   $profile = User::find($a->id);
            
            return view('client\manageprofile',compact('profile'));

            }
        if($req->session()->get('buyer')){
                   $a = $req->session()->get('buyer');
                   $profile = User::find($a->id);
            
                   return view('client\manageprofile',compact('profile'));
            }

            return redirect('/');



        
        
        
    }

    public function editprofile(Request $req,$id)
    {
        $data = User::where('id',$id)->first();

        if($req->input('submit'))
        {
            if($req->has('profile')) {
                $file = $req->file('profile');
                $filename = $req->file('profile')->getClientOriginalName();
                $extension = $req->file('profile')->extension();
                $file->move('profilephotos',$filename);
                $data->profile = $filename;
            }

        $data->name = $req->input('name');
        $data->email = $req->input('email');
        $data->contact = $req->input('contact');
        $data->gender = $req->input('gender');
        $data->address = $req->input('address');
        $data->pincode = $req->input('pincode');
        
        $data->save();

        return redirect('manageprofile');
        

        }   
    }

    public function changepassword(Request $req)
    {

        if($req->session()->get('user'))
        {
            $b = $req->session()->get('user');
            $update = User::find($b->id);
            
           return view('client\changepassword',compact('update'));

        }
        
        if($req->session()->get('buyer'))
        {
            $c = $req->session()->get('buyer');
            $update = User::find($c->id);
            
           return view('client\changepassword',compact('update'));            
        }

    }


    public function passwordchange(Request $req,$id)
    {
        
        $validated = $req->validate([
            'currentpassword' => 'required',
            'newpassword' => 'required',
            'confirmnewpassword' => 'same:newpassword'
        ]);

        $data = User::where('id',$id)->first();

        if($data)
        {
            if(Hash::check($req->currentpassword,$data->password))
                {
                    $data->update([
                        'password' => Hash::make($req->newpassword)
                    ]);

                    return redirect('changepassword')->with('success','password successfully Update');
                }
                else
                {
                    echo "no";
                }
                
            
               
        }
            
        
    }

    public function forgotpassword(Request $req){

        if($req->input('forgot'))
        {
            $email =$req->input('email');
            $user =user::where('email',$email)->first();
            $name =$user->name;
            $password = Str::random(10);
            $user->password =Hash::make($password);
            $user->save();
            $data = array('name'=>$name,'password'=>$password);
            Mail::send('client.mail',$data,function($message) use ($user){
                $message->to($user->email,'Hello tc')
                ->subject('this is password reset Example');
                $message->from('xyz@gmail.com','real_estate');
            });
            echo "HTML Email sent. check your inbox.";
        }
    
        return view('client.forgotpassword');
    
    }


    
} 

 