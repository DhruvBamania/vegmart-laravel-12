@extends('admin.layout.app')

@section('title','Orders Dashboard')

@section('content')

<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Customer Orders</h4>
                
                <div class="table-responsive">
                    <table class="table table-striped table-borderless">
                        <thead>
                            <tr>
                                <th>Order #</th>
                                <th>Customer</th>
                                <th>Total</th>
                                <th>Payment</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                            <tr>
                                <td class="font-weight-bold text-primary">{{ $order->order_number }}</td>
                                <td>
                                    {{ $order->first_name }} {{ $order->last_name }}<br>
                                    <small class="text-muted">{{ $order->mobile }}</small>
                                </td>
                                <td>₹ {{ number_format($order->total, 2) }}</td>
                                <td>
                                    <label class="badge {{ $order->payment_method == 'COD' ? 'badge-info' : 'badge-success' }}">
                                        {{ $order->payment_method }}
                                    </label>
                                </td>
                                <td>
                                    {{-- Dynamic Status Badge --}}
                                    @php
                                        $statusClass = [
                                            'pending' => 'badge-warning',
                                            'processing' => 'badge-primary',
                                            'delivered' => 'badge-success',
                                            'cancelled' => 'badge-danger'
                                        ][$order->status] ?? 'badge-secondary';
                                    @endphp
                                    <label class="badge {{ $statusClass }} text-capitalize">{{ $order->status }}</label>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        {{-- View Items Button --}}
                                        <button class="btn btn-dark btn-sm mr-2" data-toggle="collapse" 
                                                data-target="#orderItems{{ $order->id }}">
                                            Items
                                        </button>

                                        {{-- Status Update Dropdown --}}
                                        <form action="{{ route('admin.order.status', $order->id) }}" method="POST">
                                            @csrf
                                            <select name="status" class="form-control form-control-sm w-auto d-inline" onchange="this.form.submit()">
                                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                                <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                                <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                            </select>
                                        </form>
                                    </div>
                                </td>
                            </tr>

                            {{-- Collapsible Order Items Table --}}
                            <tr class="collapse" id="orderItems{{ $order->id }}">
                                <td colspan="6" class="bg-light p-3">
                                    <div class="card card-inner">
                                        <div class="card-body">
                                            <h6 class="font-weight-bold">Items in Order {{ $order->order_number }}</h6>
                                            <table class="table table-sm table-hover mt-3">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th>Product</th>
                                                        <th>Quantity</th>
                                                        <th>Price (at purchase)</th>
                                                        <th>Subtotal</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($order->items as $item)
                                                    <tr>
                                                        <td>
                                                            <img src="{{ asset('uploads/products/'.$item->product->image) }}" width="40" class="mr-2 rounded">
                                                            {{ $item->product->title }}
                                                        </td>
                                                        <td>{{ $item->quantity }}</td>
                                                        <td>₹ {{ number_format($item->price, 2) }}</td>
                                                        <td>₹ {{ number_format($item->price * $item->quantity, 2) }}</td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            <div class="mt-3 text-right">
                                                <p class="mb-0 small text-muted">Shipping Address: {{ $order->address }}, {{ $order->city }}</p>
                                                @if($order->notes) <p class="small text-danger">Note: {{ $order->notes }}</p> @endif
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection