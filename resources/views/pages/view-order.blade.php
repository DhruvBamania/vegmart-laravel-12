@extends('layouts.app')

@section('title','My Account - Your Orders')

@section('content')

<div class="container-fluid page-header py-5">
    <h1 class="text-center text-white display-6">Your Orders</h1>
    <ol class="breadcrumb justify-content-center">
        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{route('profile')}}">My Account</a></li>
        <li class="breadcrumb-item active text-white">Your Orders</li>
    </ol>
</div>

<div class="container-fluid py-5">
    <div class="container">
        {{-- Alert Messages --}}
        <div class="col-lg-12">
            @if (Session::has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{Session::get('success')}}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            @if (Session::has('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{Session::get('error')}}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
        </div>

        @if($orders->isEmpty())
        <div class="text-center py-5">
            <i class="fa fa-shopping-basket fa-4x text-muted mb-4"></i>
            <h2 class="display-6">No orders found</h2>
            <p class="text-muted">Visit our shop to order fresh Groceries!</p>
            <a href="{{ route('shop') }}" class="btn border-secondary rounded-pill px-4 py-3 text-primary text-uppercase mt-4">Go to Shop</a>
        </div>
        @else
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="bg-light">
                    <tr>
                        <th scope="col">Order Detail</th>
                        <th scope="col">Date</th>
                        <th scope="col">Billing Address</th>
                        <th scope="col">Total</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                    <tr>
                        <td>
                            <span class="fw-bold">#{{ $order->order_number }}</span>
                        </td>
                        <td>
                            <small class="text-muted">{{ $order->created_at->format('d M Y') }}</small>
                        </td>
                        <td>
                            <div class="small">
                                {{ $order->first_name }} {{ $order->last_name }}<br>
                                <span class="text-muted">{{ $order->address }}</span>
                            </div>
                        </td>
                        <td>
                            <span class="text-primary fw-bold">₹ {{ number_format($order->total, 2) }}</span>
                        </td>
                        <td>
                            @php
                                $badge = match($order->status) {
                                    'pending'   => 'bg-warning text-dark',
                                    'confirmed' => 'bg-info text-white',
                                    'shipped'   => 'bg-primary text-white',
                                    'delivered' => 'bg-success text-white',
                                    'cancelled' => 'bg-danger text-white',
                                    default     => 'bg-secondary text-white',
                                };
                            @endphp
                            <span class="badge {{ $badge }} rounded-pill px-3 py-2">
                                {{ strtoupper($order->status) }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex gap-2">
                                {{-- View Details Button --}}
                                <a href="{{ route('order.details', $order->id) }}" class="btn btn-sm btn-outline-secondary" title="View Details">
                                    <i class="fa fa-eye"></i>
                                </a>

                                @if(!in_array($order->status, ['shipped', 'delivered', 'cancelled']))
                                <form action="{{ route('order.cancel', $order->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this order?');">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Cancel Order">
                                        <i class="fa fa-times"></i> Cancel
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
</div>
@endsection