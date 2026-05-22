<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\discount;
use App\Models\cart;
use App\Models\product;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    //
    public function addToCart(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to add items to cart.');
        }

        $productId = $request->product_id;
        $userId = Auth::id();

        $existingCart = cart::where('user_id', $userId)->where('product_id', $productId)->first();

        if ($existingCart) {
        
            $existingCart->increment('quantity', $request->quantity ?? 1);
        } else {

            $cart = new cart();
            $cart->user_id = $userId;
            $cart->product_id = $productId;
            $cart->quantity = $request->quantity ?? 1;
            $cart->save();

        }

        return redirect()->back()->with('success', 'Product added to Cart!');
    }

    public function showCart()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $cartItems = cart::where('user_id', Auth::id())->with('product')->get();
        
        return view('pages.cart', ['cartItems' => $cartItems]);
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $cartItem = Cart::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        $cartItem->update([
            'quantity' => $request->quantity
        ]);

        return redirect()->back()->with('success', 'Cart updated successfully!');
    }

    public function remove($id)
    {
        $cartItem = Cart::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        $cartItem->delete();

        return redirect()->back()->with('success', 'Item removed from cart!');
    }

    /* Apply Coupon */
    public function applyCoupon(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required'
        ]);

        $coupon = Discount::where('code', $request->coupon_code)->first();

        if (!$coupon) {
            return back()->withErrors(['coupon_error' => 'Invalid coupon code. Please try again.']);
        }

        if ($coupon->expiry_date && \Carbon\Carbon::parse($coupon->expiry_date)->isPast()) {
            return back()->withErrors(['coupon_error' => 'This coupon ('.$coupon->code.') expired on ' . $coupon->expiry_date]);
        }

        if ($coupon->used >= $coupon->limit) {
            return back()->withErrors(['coupon_error' => 'This coupon is invalid or expired.']);
        }

        session()->put('coupon', [
            'code' => $coupon->code,
            'type' => $coupon->type,
            'value' => $coupon->value,
        ]);

        return back()->with('success', 'Coupon "' . $coupon->code . '" applied!');
    }

    public function removeCoupon()
    {
        session()->forget('coupon');
        return back()->with('success', 'Coupon removed.');
    }
}
