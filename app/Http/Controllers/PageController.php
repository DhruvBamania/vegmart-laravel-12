<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\product;
use App\Models\category;
use App\Models\user;
use App\Models\contact;
use App\Models\order;
use Twilio\Rest\Client;
use App\Mail\OTPMail;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderCancelledMail;
use Illuminate\Support\Carbon;


class PageController extends Controller
{
    public function home() 
    {
        $category = category::all();
        $allproduct = product::all(); 
        $products = $allproduct->groupBy('category');
        $vegetables = $allproduct->where('category', 'Vegetables');

        return view('pages.home', compact('allproduct', 'vegetables', 'category', 'products'));
    }

    public function shop(Request $request)
    {
        $category = category::all();

        $query = product::query();

        if ($request->has('search') && $request->search != '') {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->has('category') && $request->category != '') {
            $query->where('category', $request->category);
        }

        if ($request->has('rangeInput') && $request->rangeInput > 0) {
            $query->where('price', '<=', $request->rangeInput);
        }

        $allproduct = $query->paginate(9)->appends($request->all());

        return view('pages.shop', ['allproduct' => $allproduct,'category' => $category,]);
    }
    
    public function cart() 
    { 
         if(Auth::check()){
           
            return view('pages.cart');
        }

        return redirect()->route('login');
         
        
    }
    
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

        $data->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'mobile' => 'required|unique:users',
            'password' => 'required|min:6',
        ]);

        $imageName = null;
        if($data->hasFile('image')){
            $imageName = $data->file('image')->getClientOriginalName();
            $data->file('image')->move(public_path('uploads/profile_images'), $imageName);
        }

        $newUser = User::create([
            'name' => $data->name,
            'email' => $data->email,
            'mobile' => $data->mobile, 
            'password' => Hash::make($data->password), 
            'image' => $imageName,
            'type' => 'Customer'
        ]);

        Auth::login($newUser); 
        return redirect('/')->with('success','Account registered');
        
       
    }
//update user
    public function updateUser($id, Request $data) 
    {        
        $newUser = user::findOrFail($id);
        $newUser->name=$data->name;
        $newUser->email=$data->email;
        $newUser->mobile=$data->mobile;
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
    public function logout(Request $request) 
    { 
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');

    }

    public function loginUser(Request $request) 
    {
        $request->validate([
            'login_identity' => 'required',
            'password' => 'required'
        ]);

        $fieldType = filter_var($request->login_identity, FILTER_VALIDATE_EMAIL) ? 'email' : 'mobile';

        $user = user::where($fieldType, $request->login_identity)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Invalid credentials. Please check your identity or password.');
        }
        if ($user->status == 'Blocked') {
            return back()->with('error', 'Your account has been suspended.');
        }
        
        $otp = rand(100000, 999999);

        $user->update([
            'otp' => $otp,
            'otp_expires_at' => now()->addMinutes(10)
        ]);

        try {
            if ($fieldType == 'email') {
                Mail::to($user->email)->send(new OTPMail($otp));
            } else {

                $receiverNumber = $user->mobile;

                if (!str_starts_with($receiverNumber, '+')) {
                    $receiverNumber = '+91' . ltrim($receiverNumber, '0'); 
                }

                $sid = env("TWILIO_SID");
                $token = env("TWILIO_TOKEN");
                $from = env("TWILIO_PHONE");
                
                $twilio = new Client($sid, $token);
                $twilio->messages->create($receiverNumber, [
                    "from" => $from,
                    "body" => "Your Vegmart login OTP is: $otp. Valid for 10 mins."
                ]);
                
            }

            session(['otp_user_id' => $user->id]);
            return redirect()->route('otp.verify')->with('success', 'Credentials verified! Please enter the OTP sent to your ' . $fieldType);

        } catch (\Exception $e) {
            \Log::error("OTP Delivery Failed: " . $e->getMessage());
            return back()->with('error', 'We could not send your OTP. Please try again later.');
        }
    }

    public function verifyOTP(Request $request) 
    {
        $request->validate(['otp' => 'required']);
        
        $userId = session('otp_user_id');
        $user = user::where('id', $userId)
                    ->where('otp', $request->otp)
                    ->where('otp_expires_at', '>', now())
                    ->first();

        if ($user) {

            $user->update(['otp' => null, 'otp_expires_at' => null]);

            Auth::login($user); 
            
            session(['user_id' => $user->id, 'user_type' => $user->type]);
            
            return ($user->type == "Admin") ? redirect('/adminProducts') : redirect('/');
        }

        return back()->with('error', 'Invalid or expired OTP.');
    }

// My Profile
    public function profile() 
    { 
        $user = User::where('id', Auth::id())->first();
        return view('pages.profile',['user'=>$user]);  
    }

// --- GOOGLE AUTH ---
    public function redirectToGoogle() {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback() 
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            $user = User::where('email', $googleUser->getEmail())->first();

            if ($user) {
                if (!$user->google_id) {
                    $user->update(['google_id' => $googleUser->getId()]);
                }
            } else {
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'type' => 'Customer',
                    'password' => Hash::make(Str::random(16)) 
                ]);
            }

            $otp = rand(100000, 999999);
            $user->update([
                'otp' => $otp,
                'otp_expires_at' => now()->addMinutes(10)
            ]);

            Mail::to($user->email)->send(new OTPMail($otp));

            session(['otp_user_id' => $user->id]);

            return redirect()->route('otp.verify')->with('success', 'Google identity verified! Please enter the OTP sent to your email.');
            

        } catch (\Exception $e) {
            \Log::error("Google OTP Error: " . $e->getMessage());
            return redirect('/login')->with('error', 'Google login failed.');
        }
    }

    public function contactForm (Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'message' => 'required'
        ]);

        $contact = new contact();
        $contact->name = $request->name;
        $contact->email = $request->email;
        $contact->message = $request->message;
        $contact->save();

        return redirect()->back()->with('success','Message sent successfully. Will get back to you soon !!'); 
    }

    public function contactStatus(Request $request)
    {
        $contact = contact::find($request->id);

        if(!$contact){
            return back()->with('error','Contact form not found');
        }

        $contact->status = $request->status;
        $contact->save();

        return back()->with('success','Order status updated successfully');
    }

/* Checkout */
    public function checkout() 
    { 
        if(Auth::check()){
            $user = Auth::user();
            $addresses = $user->addresses; 
            $cartItems = \App\Models\Cart::where('user_id', $user->id)->with('product')->get();
            
            if($cartItems->isEmpty()) {
                return redirect()->route('cart')->with('error', 'Your cart is empty');
            }

            return view('pages.checkout',['user'=>$user, 'cartItems'=>$cartItems, 'addresses'=>$addresses]);
        }

        return redirect()->route('login');
        
    }

//View Orders
    public function viewOrders(){
    
        $viewOrders = order::where('user_id', Auth::id())->get();

        return view('pages.view-order',['orders'=>$viewOrders]);
    }

//cancel order
    public function cancelOrder($id) 
    {
        $order = order::with('items')->where('id', $id)
                    ->where('user_id', session('user_id'))
                    ->first();

        if (!$order) {
            return back()->with('error', 'Order not found.');
        }

        $currentStatus = strtolower($order->status);
        $restrictedStatuses = ['shipped', 'delivered', 'cancelled'];
        
        if (in_array($currentStatus, $restrictedStatuses)) {
            return back()->with('error', 'This order cannot be cancelled anymore.');
        }

        DB::beginTransaction();

        try {
            $order->status = 'cancelled';
            $order->save();

            foreach ($order->items as $item) {
                \App\Models\Product::where('id', $item->product_id)
                    ->increment('quantity', $item->quantity);
            }

            DB::commit();

            $userEmail = Auth::user()->email; 
            Mail::to($userEmail)->send(new OrderCancelledMail($order));

            return back()->with('success', 'Order cancelled. A confirmation email has been sent.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to cancel order.');
        }
    }

//view order details
    public function orderDetails($id) 
    {
        $userId = session('user_id'); 
        
        $order = order::with('items.product')
                    ->where('id', $id)
                    ->where('user_id', $userId)
                    ->firstOrFail();

        return view('pages.order-details', compact('order'));
    }

}
