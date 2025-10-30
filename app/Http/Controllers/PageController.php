<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\product;
use App\Models\category;
use App\Models\user;

class PageController extends Controller
{
    public function home() {
        $category=category::all();
        $products = product::all()->groupBy('category');
        $allproduct=product::all();
        $vegetables=product::where('category','Vegetables')->get();
        return view('pages.home',[
            'allproduct'=> $allproduct,
            'vegetables'=> $vegetables,
            'category'=>$category,
            'products'=>$products
        ]); 
    }
    public function shop() { 
        $allproduct=product::all();
        $category=category::all();
        $fruits=product::where('category','fruit')->get();
        $vegetables=product::where('category','vegetable')->get();
        $bread=product::where('category','bread')->get();
        $meat=product::where('category','meat')->get();
        return view('pages.shop',[
            'allproduct'=> $allproduct,
            'category'=>$category,
            'fruits'=> $fruits,
            'vegetables'=> $vegetables,
            'bread'=> $bread,
            'meat'=> $meat
        ]);  
    }
    public function cart() { return view('pages.cart'); }
    public function checkout() { return view('pages.checkout'); }
    public function contact() { return view('pages.contact'); }
    public function shop_detail() { return view('pages.shop-detail'); }
    public function notfound() { return view('pages.404'); }
    public function testimonial() { return view('pages.testimonial'); }

// Register  
    public function register() 
    { 
        return view('pages.register');  
    }

    public function registerUser(Request $data) {
        
        $newUser = new user();
        $newUser->name=$data->name;
        $newUser->email=$data->email;
        $newUser->password= password_hash($data->password, PASSWORD_DEFAULT);
        $newUser->image=$data->file('image')->getClientOriginalName();
        $data->file('image')->move(public_path('uploads/profile_images'), $newUser->image);
        $newUser->type="Customer"; 
        $newUser->save();
        return redirect(route('login'))->with('success','Account registered');
       
    }
//update user
    public function updateUser($id, Request $data) {
        
        $newUser = user::findOrFail($id);
        $newUser->name=$data->name;
        $newUser->email=$data->email;
        $newUser->location=$data->location;
        $newUser->role=$data->role;
        if($data->hasFile('image')){
        $newUser->image=$data->file('image')->getClientOriginalName();
        $data->file('image')->move(public_path('uploads/profile_images'), $newUser->image);
        }
        $newUser->save();
        return redirect()->back()->with('success','Profile updated successfully');
       
    }
// Login
    public function login() 
    { 

        return view('pages.login');  
    }
//logout
    public function logout() 
    { 
        Session::forget('id');
        Session::forget('type');
        Session::forget('name');
        Session::forget('image');
        return redirect('/login');  
    }


    public function loginUser(Request $data) 
    {
        
       $user=User::where('email',$data->email)->first();

       if($user &&  Hash::check($data->password, $user->password)) 
       {
            if($user->status=='Blocked'){
                 return redirect(route('login'))->with('error','Your account is Blocked');
            }
            Session::put('id',$user->id);
            Session::put('name',$user->name);
            Session::put('type',$user->type);
            Session::put('image',$user->image);
            if($user->type=="Customer")
            {
                return redirect('/');
            }
            elseif($user->type=="Admin")
            {
                return redirect('/dashboard');
            }
            else{
                /* return redirect('/dashboard'); */
            }
       }
       else
        {
            return redirect(route('login'))->with('error','Email/Password is invalid');
        }
        
        
       
    }
    // My Profile
    public function profile() 
    { 
        $user = User::where('id', Session::get('id'))->first();
        return view('pages.profile',['user'=>$user]);  
    }
}
