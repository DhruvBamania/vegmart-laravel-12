<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\discount;
use Illuminate\Support\Facades\Auth;

class DiscountController extends Controller
{
    //
    public function index() {

        if(Auth::check() && Auth::user()->type == 'Admin'){

            $discounts = discount::all();

            return view('admin.discounts', compact('discounts'));
        }

        return redirect()->back();
    }

    public function store(Request $request) {

        if(Auth::check() && Auth::user()->type == 'Admin'){
            $request->validate([
                'code' => 'required|unique:discounts',
                'type' => 'required',
                'value' => 'required|numeric',
                'limit' => 'required|integer',
            ]);

            discount::create($request->all());
            return back()->with('success', 'Discount created successfully!');
        }

        return redirect()->back();
    }

    public function destroy($id) {

        if(Auth::check() && Auth::user()->type == 'Admin'){
            discount::findOrFail($id)->delete();
            return back()->with('deleted', 'Discount removed!');
        }

        return redirect()->back();
    }
}
