@extends('layouts.app')

@section('title','Shop')

@section('content')

<div class="container-fluid page-header py-5">
    <h1 class="text-center text-white display-6">Shop</h1>
    <ol class="breadcrumb justify-content-center mb-0">
        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
        <li class="breadcrumb-item active text-white">Shop</li>
    </ol>
</div>
<div class="container-fluid fruite py-5">
    <div class="container py-5">
        <h1 class="mb-4">Fresh fruits shop</h1>
        <div class="row g-4">
            <div class="col-lg-12">
                <div class="row g-4">
                    <div class="col-xl-3">
                        <form action="{{ route('shop') }}" method="GET">
                            <div class="input-group w-100 mx-auto d-flex">
                                <input type="search" name="search" value="{{ request('search') }}" 
                                    class="form-control p-3" placeholder="keywords" aria-describedby="search-icon-1">
                                <button type="submit" id="search-icon-1" class="input-group-text p-3">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="col-6"></div>
                </div>

                <div class="row g-4 mt-2">
                    <div class="col-lg-3">
                        <div class="row g-4">
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <h4>Categories</h4>
                                    <ul class="list-unstyled fruite-categorie">
                                        <li>
                                            <div class="d-flex justify-content-between fruite-name">
                                                <a href="{{ route('shop') }}">
                                                    <i class="fas fa-apple-alt me-2 text-primary"></i>All Products
                                                </a>
                                            </div>
                                        </li>
                                        @foreach ($category as $cat)
                                        <li>
                                            <div class="d-flex justify-content-between fruite-name">
                                                <a href="{{ route('shop', ['category' => $cat->category]) }}">
                                                    <i class="fas fa-apple-alt me-2 text-primary"></i>{{ $cat->category }}
                                                </a>
                                            </div>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <form action="{{ route('shop') }}" method="GET">
                                    <div class="mb-3">
                                        <h4 class="mb-2">Price</h4>
                                        <input type="range" class="form-range w-100" id="rangeInput" name="rangeInput" 
                                            min="0" max="500" value="{{ request('rangeInput', 0) }}" 
                                            oninput="amount.value=rangeInput.value" onchange="this.form.submit()">
                                        <output id="amount" name="amount" class="fw-bold text-primary">₹ {{ request('rangeInput', 0) }}</output>
                                    </div>
                                </form>
                            </div>
                            <div class="col-lg-12 d-none d-lg-block">
                                <div class="position-relative">
                                    <img src="{{ asset('theme/img/banner-fruits.jpg')}}" class="img-fluid w-100 rounded" alt="">
                                    <div class="position-absolute" style="top: 50%; right: -5px; transform: translateY(-50%); text-align: right;">
                                        <h3 class="text-secondary fw-bold">Fresh <br> Groceries</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-9">
                        <div class="row g-4 justify-content-center">
                            @forelse ($allproduct as $item)
                            <div class="col-md-6 col-lg-6 col-xl-4">
                                <div class="border border-secondary rounded overflow-hidden h-100 d-flex flex-column bg-white card-fixed">
                                    <div class="position-relative fruite-item">
                                        <div class="fruite-img">
                                            <img src="{{ asset('uploads/products/'.$item->image)}}" 
                                                 class="img-fluid w-100 rounded-top {{ $item->quantity <= 0 ? 'opacity-50 grayscale' : '' }}" 
                                                 style="height: 230px; object-fit: cover;" alt="">
                                        </div>
                                        <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">
                                            {{ $item->category }}
                                        </div>
                                    </div>
                                    
                                    <div class="p-4 d-flex flex-column flex-grow-1">
                                        <h4 style="min-height: 50px;">{{$item->title}}</h4>
                                        <p class="text-muted mb-3" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; min-height: 45px;">
                                            {{$item->description}}
                                        </p>
                                        
                                        <div class="mt-auto">
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                {{-- Dynamic Unit Logic for Milk/Bread --}}
                                                <p class="text-dark fs-5 fw-bold mb-0">
                                                    ₹ {{$item->price}} / {{ in_array($item->category, ['Milks', 'Breads']) ? '1pcs' : '100g' }}
                                                </p>
                                                @if($item->quantity <= 0)
                                                    <span class="text-danger small fw-bold">Out of Stock</span>
                                                @else
                                                    <span class="text-success small fw-bold">In Stock</span>
                                                @endif
                                            </div>

                                            @if($item->quantity > 0)
                                                <form action="{{ route('cart.add') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="product_id" value="{{ $item->id }}">
                                                    <div class="d-flex gap-2">
                                                        <input type="number" name="quantity" class="form-control" value="1" min="1" max="{{ $item->quantity }}" style="width: 70px;">
                                                        <button type="submit" class="btn border border-secondary rounded-pill px-3 text-primary flex-grow-1">
                                                            <i class="fa fa-shopping-bag me-2 text-primary"></i> Add
                                                        </button>
                                                    </div>
                                                </form>
                                            @else
                                                <button class="btn btn-light border border-danger text-danger rounded-pill w-100 disabled" style="opacity: 0.7;">
                                                    Unavailable
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="col-12 text-center py-5">
                                <i class="fa fa-search fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">No products found.</h5>
                            </div>
                            @endforelse

                            <div class="col-12">
                                {{-- Pagination Container --}}
                                <div class="pagination-container d-flex justify-content-center mt-5">
                                    {{ $allproduct->appends(request()->input())->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Fix for vertical pagination */
    .pagination-container nav ul.pagination {
        display: flex !important;
        flex-direction: row !important;
        padding-left: 0;
        list-style: none;
        border-radius: 0.25rem;
    }
    
    .pagination-container nav ul.pagination li {
        margin: 0 5px;
    }

    /* Fixed Card Heights */
    .card-fixed {
        min-height: 480px;
    }

    .grayscale { filter: grayscale(100%); transition: 0.3s; }
    .fruite-categorie li a { transition: 0.3s; color: #45595b; text-decoration: none; }
    .fruite-categorie li a:hover { color: #81c408; padding-left: 5px; }
</style>

@endsection