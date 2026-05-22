@extends('layouts.app')

@section('title','Checkout')

@section('content')

<div class="container-fluid page-header py-5">
    <h1 class="text-center text-white display-6">Cart</h1>
    <ol class="breadcrumb justify-content-center mb-0">
        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
        <li class="breadcrumb-item active text-white">Checkout</li>
    </ol>
</div>

<div class="container py-5">
    <form action="{{route('order.place')}}" method="POST">
        @csrf
        <div class="row gx-lg-5">
            
            {{-- LEFT SIDE: BILLING FORM --}}
            <div class="col-lg-7">
                <div class="card border shadow-sm p-4 mb-4">
                    <h4 class="mb-4 fw-bold border-bottom pb-2">Billing Details</h4>

                    {{-- 1. SAVED ADDRESS SELECTOR --}}
                    @if($addresses->isNotEmpty())
                    <div class="mb-4 p-3 bg-light rounded border border-info-subtle">
                        <label class="fw-semibold mb-2 d-flex align-items-center">
                            <i class="bi bi-geo-alt text-primary me-2"></i> Use a saved address:
                        </label>
                        <select class="form-select form-select-sm w-auto border-info" id="savedAddressSelector">
                            <option value="">-- Start fresh or select saved --</option>
                            @foreach($addresses as $addr)
                                <option value="{{ $addr->id }}" 
                                    data-fname="{{ $addr->first_name }}" data-lname="{{ $addr->last_name }}"
                                    data-addr="{{ $addr->address }}" data-city="{{ $addr->city }}"
                                    data-country="{{ $addr->country }}" data-zip="{{ $addr->zip }}"
                                    data-mobile="{{ $addr->mobile }}">
                                    {{ $addr->address_type }}: {{ $addr->address }}, {{ $addr->city }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @endif

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">First Name*</label>
                            <input type="text" name="first_name" id="fname" class="form-control bg-light border shadow-none" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Last Name*</label>
                            <input type="text" name="last_name" id="lname" class="form-control bg-light border shadow-none" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-bold">Full Address*</label>
                            <input type="text" name="address" id="address_input" class="form-control bg-light border shadow-none" placeholder="house/street/area" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Town/City*</label>
                            <input type="text" name="city" id="city" class="form-control bg-light border shadow-none" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Country*</label>
                            <input type="text" name="country" id="country" class="form-control bg-light border shadow-none" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Postcode/Zip*</label>
                            <input type="text" name="zip" id="zip" class="form-control bg-light border shadow-none" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Mobile*</label>
                            <input type="tel" name="mobile" id="mobile" class="form-control bg-light border shadow-none" required>
                        </div>
                    </div>

                    {{-- SAVE ADDRESS UI --}}
                    <div class="mt-4 p-3 bg-light rounded border-start border-primary border-4">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="save_address" name="save_address" value="1">
                            <label class="form-check-label fw-bold" for="save_address text-primary">Save this address for later?</label>
                        </div>
                        <input type="text" name="address_type" class="form-control form-control-sm mt-2 w-50 border" placeholder="Address Name (Home, Office...)">
                    </div>

                    <div class="mt-4">
                        <label class="form-label small fw-bold">Order Notes (Optional)</label>
                        <textarea name="notes" class="form-control bg-light border shadow-none" rows="3"></textarea>
                    </div>
                </div>
            </div>

            {{-- RIGHT SIDE: ORDER SUMMARY --}}
            <div class="col-lg-5">
                <div class="card border shadow p-4 sticky-top" style="top: 100px; z-index: 10;">
                    <h4 class="mb-4 fw-bold border-bottom pb-2">Order Summary</h4>
                    
                    <div class="table-responsive">
                        <table class="table table-borderless align-middle">
                            @php $subtotal = 0; @endphp
                            @foreach($cartItems as $item)
                                @php 
                                    $itemTotal = $item->product->price * $item->quantity;
                                    $subtotal += $itemTotal;
                                @endphp
                                <tr>
                                    <td width="60">
                                        <img src="{{ asset('uploads/products/'.$item->product->image)}}" class="rounded shadow-sm" style="width: 50px; height: 50px; object-fit: cover;">
                                    </td>
                                    <td>
                                        <div class="fw-bold small text-dark">{{ $item->product->title }}</div>
                                        <div class="text-muted small">Qty: {{ $item->quantity }}</div>
                                    </td>
                                    <td class="text-end fw-bold small text-dark">₹ {{ number_format($itemTotal, 2) }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>

                    @php 
                        $discount = 0;
                        if(session()->has('coupon')) {
                            $cp = session()->get('coupon');
                            $discount = ($cp['type'] == 'percent') ? ($subtotal * $cp['value'] / 100) : $cp['value'];
                        }
                        $grandTotal = $subtotal - $discount;
                    @endphp

                    <div class="border-top pt-3">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Subtotal</span>
                            <span class="fw-bold">₹ {{ number_format($subtotal, 2) }}</span>
                        </div>

                        @if($discount > 0)
                        <div class="d-flex justify-content-between mb-2 text-success">
                            <span>Discount ({{ session()->get('coupon')['code'] }})</span>
                            <span class="fw-bold">-₹ {{ number_format($discount, 2) }}</span>
                        </div>
                        @endif

                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Shipping</span>
                            <span class="text-success fw-bold">Free</span>
                        </div>

                        <div class="d-flex justify-content-between mt-3 pt-3 border-top">
                            <h5 class="fw-bold">Total</h5>
                            <h5 class="fw-bold text-primary">₹ {{ number_format($grandTotal, 2) }}</h5>
                        </div>
                    </div>

                    {{-- PAYMENT METHODS --}}
                    <div class="mt-4 bg-light p-3 rounded">
                        <label class="fw-bold small mb-3 text-uppercase tracking-wider">Payment Method</label>
                        <div class="form-check mb-2">
                            <input type="radio" class="form-check-input" id="COD" name="payment_method" value="COD" checked>
                            <label class="form-check-label" for="COD">Cash On Delivery</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" id="Razorpay" name="payment_method" value="Razorpay">
                            <label class="form-check-label" for="Razorpay">Razorpay Online</label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg w-100 mt-4 rounded-pill shadow-sm">
                        Confirm Order
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

{{-- SCRIPT REMAIN THE SAME --}}
<script>
document.getElementById('savedAddressSelector')?.addEventListener('change', function() {
    const opt = this.options[this.selectedIndex];
    if(opt.value !== "") {
        document.getElementById('fname').value = opt.dataset.fname;
        document.getElementById('lname').value = opt.dataset.lname;
        document.getElementById('address_input').value = opt.dataset.addr;
        document.getElementById('city').value = opt.dataset.city;
        document.getElementById('country').value = opt.dataset.country;
        document.getElementById('zip').value = opt.dataset.zip;
        document.getElementById('mobile').value = opt.dataset.mobile;
    }
});
</script>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<script>
document.querySelector('form').onsubmit = function(e) {
    const method = document.querySelector('input[name="payment_method"]:checked').value;
    
    if (method === 'Razorpay') {
        e.preventDefault(); 
        
        fetch("{{ route('razorpay.prepare') }}", {
            method: "POST",
            headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}", "Content-Type": "application/json" },
            body: JSON.stringify({ total: "{{ $grandTotal }}" })
        })
        .then(res => res.json())
        .then(data => {
        
            var options = {
                "key": data.key,
                "amount": data.amount,
                "currency": "INR",
                "name": "Vegmart",
                "description": "Organic Purchase",
                "order_id": data.order_id,
                "handler": function (response){

                    let input = document.createElement("input");
                    input.type = "hidden";
                    input.name = "razorpay_payment_id";
                    input.value = response.razorpay_payment_id;
                    document.querySelector('form').appendChild(input);
                    document.querySelector('form').submit(); 
                },
                "theme": { "color": "#81c408" } 
            };
            var rzp = new Razorpay(options);
            rzp.open();
        });
    }
};
</script>

@endsection