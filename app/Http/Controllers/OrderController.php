<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\order;
use App\Models\order_items;
use App\Models\Cart;
use App\Models\Address;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Razorpay\Api\Api;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderConfirmation;

class OrderController extends Controller
{
    public function placeOrder(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'address' => 'required|string',
            'city' => 'required|string',
            'country' => 'required|string',
            'zip' => 'required|string',
            'mobile' => 'required|string',
            'payment_method' => 'required|in:COD,Razorpay',
        ]);

        $user = Auth::user();
        
        $cartItems = Cart::where('user_id', $user->id)->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('shop')->with('error', 'Your cart is empty.');
        }

        DB::beginTransaction();

        try {
            $subtotal = 0;
            
            foreach ($cartItems as $item) {
                if ($item->product->quantity < $item->quantity) {
                    return back()->with('error', "Sorry, {$item->product->title} only has {$item->product->quantity}kg left in stock.");
                }
                $subtotal += $item->product->price * $item->quantity;
            }

            $discountValue = 0;
            if (session()->has('coupon')) {
                $cp = session()->get('coupon');
                $discountValue = ($cp['type'] == 'percent') 
                    ? ($subtotal * ($cp['value'] / 100)) 
                    : $cp['value'];
                
                Discount::where('code', $cp['code'])->increment('used');
            }

            $grandTotal = $subtotal - $discountValue;

            if ($request->save_address) {
                Address::updateOrCreate(
                    [
                        'user_id' => $user->id, 
                        'address' => $request->address, 
                        'zip' => $request->zip
                    ],
                    [
                        'address_type' => $request->address_type ?? 'Home',
                        'first_name' => $request->first_name,
                        'last_name' => $request->last_name,
                        'city' => $request->city,
                        'country' => $request->country,
                        'mobile' => $request->mobile,
                        'is_default' => false
                    ]
                );
            }

            $order = order::create([
                'user_id' => $user->id,
                'order_number' => 'VEG-' . strtoupper(Str::random(10)),
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'address' => $request->address,
                'city' => $request->city,
                'country' => $request->country,
                'zip' => $request->zip,
                'mobile' => $request->mobile,
                'notes' => $request->notes,
                'subtotal' => $subtotal,
                'discount' => $discountValue,
                'total' => $grandTotal,
                'payment_method' => $request->payment_method,
                'status' => ($request->payment_method == 'Razorpay') ? 'processing' : 'pending',
                'payment_id' => $request->razorpay_payment_id ?? null,
            ]);

            foreach ($cartItems as $item) {
                order_items::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price, 
                ]);

                $item->product->decrement('quantity', $item->quantity);
            }

            Cart::where('user_id', $user->id)->delete();
            session()->forget('coupon');

            DB::commit();
            
            try {
                Mail::to($user->email)->send(new OrderConfirmation($order));
            } catch (\Exception $e) {
                \Log::error('Order Email Error: ' . $e->getMessage());
            }

            return redirect()->route('order.success', $order->order_number)->with('success', 'Your organic goodness is on the way!');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    public function success($order_number)
    {
        $order = order::where('order_number', $order_number)->firstOrFail();

        return view('pages.order-success', compact('order'));
    }

    public function processRazorpay(Request $request)
    {
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

        
        $razorpayOrder = $api->order->create([
            'receipt'         => 'rcptid_' . time(),
            'amount'          => $request->total * 100, 
            'currency'        => 'INR', 
        ]);

        return response()->json([
            'order_id' => $razorpayOrder['id'],
            'amount'   => $razorpayOrder['amount'],
            'key'      => env('RAZORPAY_KEY'),
        ]);
    }
}