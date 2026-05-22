@extends('layouts.app')

@section('title', 'Order Success')

@section('content')

<div class="container-fluid page-header py-5">
    <h1 class="text-center text-white display-6">Order Confirmed</h1>
    <ol class="breadcrumb justify-content-center mb-0">
        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
        <li class="breadcrumb-item active text-white">Success</li>
    </ol>
</div>

<div class="container py-5 text-center">
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="mb-4">
                <i class="bi bi-check2-circle display-1 text-primary animate__animated animate__bounceIn"></i>
            </div>
            
            <h2 class="fw-bold display-5 mb-3">Thank You for Your Purchase!</h2>
            <p class="lead text-muted mb-5">
                Your order <span class="text-primary fw-bold">#{{ $order->order_number }}</span> has been placed successfully. 
                We've sent a confirmation email to <span class="fw-bold">{{ auth()->user()->email }}</span>.
            </p>

            <div class="card border-0 shadow-sm mb-5 text-start">
                <div class="card-body p-4">
                    <h5 class="fw-bold border-bottom pb-3 mb-3">Order Details</h5>
                    
                    <div class="row mb-2">
                        <div class="col-6 text-muted">Order Date:</div>
                        <div class="col-6 text-end fw-bold">{{ $order->created_at->format('M d, Y') }}</div>
                    </div>
                    
                    <div class="row mb-2">
                        <div class="col-6 text-muted">Payment Method:</div>
                        <div class="col-6 text-end fw-bold">{{ $order->payment_method == 'COD' ? 'Cash on Delivery' : 'Online Payment' }}</div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-6 text-muted">Shipping Address:</div>
                        <div class="col-6 text-end small">{{ $order->address }}, {{ $order->city }}, {{ $order->zip }}</div>
                    </div>

                    <div class="bg-light p-3 rounded">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal</span>
                            <span class="fw-bold">₹ {{ number_format($order->subtotal, 2) }}</span>
                        </div>
                        @if($order->discount > 0)
                        <div class="d-flex justify-content-between mb-2 text-success">
                            <span>Discount</span>
                            <span class="fw-bold">-₹ {{ number_format($order->discount, 2) }}</span>
                        </div>
                        @endif
                        <div class="d-flex justify-content-between mt-2 pt-2 border-top">
                            <h4 class="fw-bold mb-0">Total Paid</h4>
                            <h4 class="fw-bold text-primary mb-0">₹ {{ number_format($order->total, 2) }}</h4>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex flex-column flex-md-row justify-content-center gap-3">
                <a href="{{ route('home') }}" class="btn btn-outline-primary rounded-pill px-5 py-3 fw-bold">
                    <i class="bi bi-house-door me-2"></i>Back to Home
                </a>
                <a href="{{ route('shop') }}" class="btn btn-primary rounded-pill px-5 py-3 fw-bold shadow-sm text-white">
                    <i class="bi bi-bag me-2"></i>Continue Shopping
                </a>
            </div>
        </div>
    </div>
</div>

@endsection