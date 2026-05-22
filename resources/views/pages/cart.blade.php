@extends('layouts.app')

@section('title','Cart')

@section('content')

<div class="container-fluid page-header py-5">
    <h1 class="text-center text-white display-6">Cart</h1>
    <ol class="breadcrumb justify-content-center mb-0">
        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
        <li class="breadcrumb-item active text-white">Cart</li>
    </ol>
</div>
<div class="container-fluid py-5">
    <div class="container py-5">
        @if($cartItems->isEmpty())
            <div class="text-center">
                <h2 class="display-6">Your cart is empty</h2>
                <a href="{{ route('shop') }}" class="btn border-secondary rounded-pill px-4 py-3 text-primary text-uppercase mt-4">Go to Shop</a>
            </div>
        @else
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Products</th>
                            <th scope="col">Name</th>
                            <th scope="col">Price</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Total</th>
                            <th scope="col">Handle</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $subtotal = 0; @endphp
                        @foreach ($cartItems as $item)
                            @php 
                                $totalPrice = $item->product->price * $item->quantity;
                                $subtotal += $totalPrice;
                            @endphp
                            <tr>
                                <th scope="row">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('uploads/products/'.$item->product->image) }}" class="img-fluid me-5 rounded-circle" style="width: 80px; height: 80px;" alt="">
                                    </div>
                                </th>
                                <td>
                                    <p class="mb-0 mt-4">{{ $item->product->title }}</p>
                                </td>
                                <td>
                                    <p class="mb-0 mt-4">₹ {{ number_format($item->product->price, 2) }}</p>
                                </td>
                                <td>
                                    <form action="{{ route('cart.update', $item->id) }}" method="POST" id="update-form-{{ $item->id }}">
                                        @csrf
                                        <div class="input-group quantity mt-4" style="width: 100px;">
                                            <input type="number" name="quantity" class="form-control form-control-sm text-center border-0" 
                                                   value="{{ $item->quantity }}" min="1" onchange="this.form.submit()">
                                        </div>
                                    </form>
                                </td>
                                <td>
                                    <p class="mb-0 mt-4">₹ {{ number_format($totalPrice, 2) }}</p>
                                </td>
                                <td>
                                    <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-md rounded-circle bg-light border mt-4">
                                            <i class="fa fa-times text-danger"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-5">
                {{-- Display Coupon Errors --}}
                @if($errors->has('coupon_error'))
                    <div class="alert alert-danger alert-dismissible fade show mb-3 col-lg-5" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        {{ $errors->first('coupon_error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                {{-- Display Success Message --}}
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show mb-3 col-lg-5" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <form action="{{ route('cart.coupon.apply') }}" method="POST" class="d-flex align-items-center">
                    @csrf
                    <input type="text" name="coupon_code" class="border-0 border-bottom rounded me-3 py-3 mb-4" 
                        placeholder="Enter Coupon Code" value="{{ session()->get('coupon')['code'] ?? '' }}">
                    <button class="btn border-secondary rounded-pill px-4 py-3 text-primary" type="submit">Apply Coupon</button>
                </form>

                {{-- Show Available Coupons --}}
                <div class="mt-3">
                    <h6 class="text-muted">Available Coupons:</h6>
                    @foreach(\App\Models\Discount::where('expiry_date', '>=', now())->orWhereNull('expiry_date')->get() as $available)
                        <span class="badge bg-light text-primary border border-primary me-2 p-2" style="cursor:pointer" 
                            onclick="document.getElementsByName('coupon_code')[0].value='{{ $available->code }}'">
                            {{ $available->code }} ({{ $available->type == 'percent' ? $available->value.'%' : '$'.$available->value }} OFF)
                        </span>
                    @endforeach
                </div>
            </div>

            <div class="row g-4 justify-content-end">
                <div class="col-8"></div>
                <div class="col-sm-8 col-md-7 col-lg-6 col-xl-4">
                    <div class="bg-light rounded">
                        <div class="p-4">
                            <h1 class="display-6 mb-4">Cart <span class="fw-normal">Total</span></h1>
                            <div class="d-flex justify-content-between mb-4">
                                <h5 class="mb-0 me-4">Subtotal:</h5>
                                <p class="mb-0">₹ {{ number_format($subtotal, 2) }}</p>
                            </div>

                            @if(session()->has('coupon'))
                                @php
                                    $coupon = session()->get('coupon');
                                    $discountAmount = ($coupon['type'] == 'percent') 
                                        ? ($subtotal * ($coupon['value'] / 100)) 
                                        : $coupon['value'];
                                    $grandTotal = $subtotal - $discountAmount;
                                @endphp
                                <div class="d-flex justify-content-between mb-4 text-success">
                                    <h5 class="mb-0 me-4">Discount ({{ $coupon['code'] }}):</h5>
                                    <p class="mb-0">-₹ {{ number_format($discountAmount, 2) }} 
                                        <a href="{{ route('cart.coupon.remove') }}" class="text-danger ms-2"><i class="fa fa-times"></i></a>
                                    </p>
                                </div>
                            @else
                                @php $grandTotal = $subtotal; @endphp
                            @endif

                            <div class="d-flex justify-content-between">
                                <h5 class="mb-0 me-4">Shipping</h5>
                                <p class="mb-0">Free Shipping</p>
                            </div>
                        </div>
                        <div class="py-4 mb-4 border-top border-bottom d-flex justify-content-between">
                            <h5 class="mb-0 ps-4 me-4">Total</h5>
                            <p class="mb-0 pe-4">₹ {{ number_format($grandTotal, 2) }}</p>
                        </div>
                        <a href="{{ route('checkout') }}" class="btn border-secondary rounded-pill px-4 py-3 text-primary text-uppercase mb-4 ms-4">
                            Proceed Checkout
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection