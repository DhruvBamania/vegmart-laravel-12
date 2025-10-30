<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\product;
use App\Models\category;
use App\Models\user;

class AdminController extends Controller
{
    public function dashboard()
    {
        if(Session::get('type')=='Admin'){
            return view('admin.index');
        }
        
        return redirect()->back();
       
    }
    public function customers()
    {
        if(Session::get('type')=='Admin'){
            $customers=user::where('type','Customer')->get();
            return view('admin.customers',['customers'=>$customers]);
        }
        
        return redirect()->back();
       
    }

    public function changeStatus($status, $id)
    {
        $user=user::findOrFail($id);
        $user->status=$status;
        $user->save();
        
        return redirect()->back()->with('success','User Status changed Successfully');
       
    }
    public function adminProfile()
    {
        if(Session::get('type')=='Admin'){
            $user = User::where('id', Session::get('id'))->first();
            return view('admin.adminProfile',['user'=>$user]);
        }
        
        return redirect()->back();
       
    }

    public function products()
    {   
        if(Session::get('type')=='Admin'){
        $category=category::all();
        $products = product::all()->groupBy('category');
        /* $fruits=product::where('category','fruit')->get();
        $vegetables=product::where('category','vegetable')->get();
        $bread=product::where('category','bread')->get();
        $meat=product::where('category','meat')->get(); */
        return view('admin.products',['category'=>$category,'products'=> $products]);
        }
        return redirect()->back();
    }
//Category
    public function addProduct(Request $data)
    {
        if(Session::get('type')=='Admin'){
        $category = new category();
        $category->category=$data->category;
        $category->save();
        return redirect()->back()->with('success','Category added');
        }
        return redirect()->back();
    }

    public function deleteCategory($id)
    {
        if(Session::get('type')=='Admin'){
        $category = category::findOrFail($id);
        $category->delete();
        return redirect()->back()->with('deleted','Category deleted');
        }
        return redirect()->back();
    }
//Item
    public function addItem(Request $data)
    {
        if(Session::get('type')=='Admin'){
        $item = new product();
        $item->title=$data->title;
        $item->description=$data->description;
        $item->price=$data->price;
        $item->quantity=$data->quantity;
        $item->category=$data->category;
        $item->image=$data->file('image')->getClientOriginalName();
        $data->file('image')->move(public_path('uploads/products'), $item->image);
        $item->save();
        return redirect()->back()->with('itemSuccess','Item added');
        }
        return redirect()->back();
    }
    public function updateItem($id,Request $data)
    {
        if(Session::get('type')=='Admin'){
        $item = product::findOrFail($id);
        $item->title=$data->title;
        $item->description=$data->description;
        $item->price=$data->price;
        $item->quantity=$data->quantity;
        $item->category=$data->category;
        if($data->hasFile('image')){
        $item->image=$data->file('image')->getClientOriginalName();
        $data->file('image')->move(public_path('uploads/products'), $item->image);
        }
        $item->save();
        return redirect()->back()->with('itemUpdated','Item Updated');
        }
        return redirect()->back();
    }

    public function itemDelete($id)
    {
        if(Session::get('type')=='Admin'){
        $item = product::findOrFail($id);
        $item->delete();
        return redirect()->back()->with('itemDeleted','Item deleted');
        }
        return redirect()->back();
    }
}
