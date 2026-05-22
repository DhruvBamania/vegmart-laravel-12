<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use App\Models\Order;
use App\Models\order_items;
use App\Mail\OrderStatusUpdated;
use Illuminate\Support\Facades\Mail;

use App\Models\product;
use App\Models\category;
use App\Models\user;
use App\Models\contact;

class AdminController extends Controller
{
    public function dashboard()
    {
        /* if(Session::get('type')=='Admin'){
            return view('admin.index');
        } */

        if(Auth::check() && Auth::user()->type == 'Admin'){
            $category=category::all();
            $products = product::all()->groupBy('category');

            return view('admin.products',['category'=>$category,'products'=> $products]);
        }
        
        return redirect()->back();
       
    }

    public function contact()
    {
        if(Auth::check() && Auth::user()->type == 'Admin'){
            $contact=contact::all();

            return view('admin.contact',['contacts'=>$contact]);
        }
        
        return redirect()->back();
       
    }
    
    public function customers()
    {
        if(Auth::check() && Auth::user()->type == 'Admin'){
            $customers=user::where('type','Customer')->get();
            return view('admin.customers',['customers'=>$customers]);
        }
        
        return redirect()->back();
       
    }

    public function orders()
    {
        if(Auth::check() && Auth::user()->type == 'Admin'){

            $orders = Order::with('items.product')->orderBy('created_at', 'desc')->get();
            return view('admin.orders', ['orders'=>$orders]);
            
        }
        
        return redirect()->back();
       
    }

    public function updateOrderStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $oldStatus = $order->status;


        $order->status = $request->status;
        $order->save();

        if ($oldStatus !== $request->status) {
            try {
                $customerEmail = $order->user->email; 
                
                Mail::to($customerEmail)->send(new OrderStatusUpdated($order));
                
            } catch (\Exception $e) {
                \Log::error("Status Update Email Failed: " . $e->getMessage());
            }
        }

        return back()->with('success', 'Order status updated to ' . $request->status);
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
        if(Auth::check() && Auth::user()->type == 'Admin'){
            $user = User::where('id', Auth::id())->first();
            return view('admin.adminProfile',['user'=>$user]);
        }
        
        return redirect()->back();
       
    }

    public function products()
    {   
        if(Auth::check() && Auth::user()->type == 'Admin'){
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
        if(Auth::check() && Auth::user()->type == 'Admin'){
        $category = new category();
        $category->category=$data->category;
        $category->save();
        return redirect()->back()->with('success','Category added');
        }
        return redirect()->back();
    }

    public function deleteCategory($id)
    {
        if(Auth::check() && Auth::user()->type == 'Admin'){
        $category = category::findOrFail($id);
        $category->delete();
        return redirect()->back()->with('deleted','Category deleted');
        }
        return redirect()->back();
    }
//Item
    public function addItem(Request $data)
    {
        if(Auth::check() && Auth::user()->type == 'Admin'){
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
        if(Auth::check() && Auth::user()->type == 'Admin'){
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
        if(Auth::check() && Auth::user()->type == 'Admin'){
        $item = product::findOrFail($id);
        $item->delete();
        return redirect()->back()->with('itemDeleted','Item deleted');
        }
        return redirect()->back();
    }
}
