@extends('layouts.app')

@section('title', 'Order Details #' . $order->order_number)

@section('content')
<div class="container-fluid page-header py-5">
    <h1 class="text-center text-white display-6">Order #{{ $order->order_number }}</h1>
</div>

<div class="container py-5">
    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Ordered Items</h5>
                </div>
                <div class="card-body">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th class="text-end">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $item)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('uploads/products/' . $item->product->image) }}" alt="" style="width: 50px; height: 50px; object-fit: cover;" class="rounded me-3">
                                        <span>{{ $item->product->title }}</span>
                                    </div>
                                </td>
                                <td>₹ {{ number_format($item->price, 2) }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td class="text-end fw-bold">₹ {{ number_format($item->price * $item->quantity, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3" class="text-end">Order Total:</th>
                                <th class="text-end text-primary fs-5">₹ {{ number_format($order->total, 2) }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Order Summary</h5>
                </div>
                <div class="card-body">
                    <p><strong>Status:</strong> 
                        <span class="badge bg-primary rounded-pill">{{ $order->status }}</span>
                    </p>
                    <p><strong>Order Date:</strong> {{ $order->created_at->format('d M Y, h:i A') }}</p>
                    <hr>
                    <p><strong>Delivery Address:</strong><br>
                        <span class="text-muted">{{ $order->address }}, {{ $order->city }}</span>
                    </p>
                    <p><strong>Contact:</strong> {{ $order->mobile }}</p>
                    
                    @if($order->status == 'Pending' || $order->status == 'Confirmed')
                        <form action="{{ route('order.cancel', $order->id) }}" method="POST" onsubmit="return confirm('Cancel this order?');">
                            @csrf
                            <button type="submit" class="btn btn-danger w-100 mt-3">Cancel Order</button>
                        </form>
                    @endif
                    
                    <a href="{{ route('view.orders') }}" class="btn btn-outline-secondary w-100 mt-2">Back to Orders</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection