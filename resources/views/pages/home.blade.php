@extends('layouts.app')

@section('title','Home')

@section('content')

<div class="container-fluid py-5 mb-5 hero-header">
    <div class="container py-5">
        <div class="row g-5 align-items-center">
            <div class="col-md-12 col-lg-7">
                <h4 class="mb-3 text-secondary">100% Organic Foods</h4>
                <h1 class="mb-5 display-3 text-primary">Organic Veggies & Fruits Foods</h1>
            </div>
            <div class="col-md-12 col-lg-5">
                <div id="carouselId" class="carousel slide position-relative" data-bs-ride="carousel">
                    <div class="carousel-inner" role="listbox">
                        <div class="carousel-item active rounded">
                            <img src="{{ asset('theme/img/hero-img-1.png') }}" class="img-fluid w-100 h-100 bg-secondary rounded" alt="First slide">
                            <a href="#products" class="btn px-4 py-2 text-white rounded">Fruites</a>
                        </div>
                        <div class="carousel-item rounded">
                            <img src="{{ asset('theme/img/hero-img-2.jpg') }}" class="img-fluid w-100 h-100 rounded" alt="Second slide">
                            <a href="#products" class="btn px-4 py-2 text-white rounded">Vegetables</a>
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselId" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselId" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid fruite py-5" id="products">
    <div class="container py-5">
        <div class="tab-class text-center">
            <div class="row g-4">
                <div class="col-lg-4 text-start">
                    <h1>Our Organic Products</h1>
                </div>
                <div class="col-lg-8 text-end">
                    <ul class="nav nav-pills d-inline-flex text-center mb-5">
                        <li class="nav-item">
                            <a class="d-flex m-2 py-2 bg-light rounded-pill active" data-bs-toggle="pill" href="#allproduct">
                                <span class="text-dark" style="width: 130px;">All Products</span>
                            </a>
                        </li>
                        @foreach ($category as $section)
                        <li class="nav-item">
                            <a class="d-flex py-2 m-2 bg-light rounded-pill" data-bs-toggle="pill" href="#{{ Str::slug($section->category) }}">
                                <span class="text-dark" style="width: 130px;">{{$section->category}}</span>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="tab-content">
                {{-- All Products Tab --}}
                <div id="allproduct" class="tab-pane fade show p-0 active">
                    <div class="row g-4">
                        @forelse ($allproduct as $item)
                        <div class="col-md-6 col-lg-4 col-xl-3">
                            <div class="card-custom border border-secondary rounded overflow-hidden h-100 d-flex flex-column bg-white">
                                <div class="position-relative">
                                    <img src="{{ asset('uploads/products/'.$item->image)}}" 
                                         class="img-fluid w-100 {{ $item->quantity <= 0 ? 'opacity-50 grayscale' : '' }}" 
                                         style="height: 230px; object-fit: cover;">
                                    <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">{{ $item->category }}</div>
                                </div>
                                <div class="p-4 d-flex flex-column flex-grow-1">
                                    <h4 class="product-title-fixed">{{$item->title}}</h4>
                                    <p class="product-desc-fixed text-muted">{{$item->description}}</p>
                                    <div class="mt-auto">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <p class="text-dark fs-5 fw-bold mb-0">₹ {{$item->price}} / {{ in_array($item->category, ['Milks', 'Breads']) ? '1pcs' : '100g' }}</p>
                                        </div>
                                        @if($item->quantity > 0)
                                        <form action="{{ route('cart.add') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $item->id }}">
                                            <div class="d-flex gap-2">
                                                <input type="number" name="quantity" class="form-control" value="1" min="1" max="{{ $item->quantity }}" style="width: 70px;">
                                                <button type="submit" class="btn border border-secondary rounded-pill px-3 text-primary flex-grow-1">Add</button>
                                            </div>
                                        </form>
                                        @else
                                        <button class="btn btn-light border-danger text-danger rounded-pill w-100 disabled">Out of Stock</button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-12 text-center py-5"><h5>No products available</h5></div>
                        @endforelse
                    </div>
                </div>

                {{-- Category Specific Tabs --}}
                @foreach ($category as $cat)
                <div id="{{ Str::slug($cat->category) }}" class="tab-pane fade show p-0">
                    <div class="row g-4">
                        @if(isset($products[$cat->category]))
                            @foreach ($products[$cat->category] as $item)
                            <div class="col-md-6 col-lg-4 col-xl-3">
                                <div class="card-custom border border-secondary rounded overflow-hidden h-100 d-flex flex-column bg-white">
                                    <div class="position-relative">
                                        <img src="{{ asset('uploads/products/'.$item->image)}}" 
                                             class="img-fluid w-100 {{ $item->quantity <= 0 ? 'opacity-50 grayscale' : '' }}" 
                                             style="height: 230px; object-fit: cover;">
                                        <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">{{ $item->category }}</div>
                                    </div>
                                    <div class="p-4 d-flex flex-column flex-grow-1">
                                        <h4 class="product-title-fixed">{{$item->title}}</h4>
                                        <p class="product-desc-fixed text-muted">{{$item->description}}</p>
                                        <div class="mt-auto">
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <p class="text-dark fs-5 fw-bold mb-0">₹ {{$item->price}} / {{ in_array($item->category, ['Milks', 'Breads']) ? '1pcs' : '100g' }}</p>
                                            </div>
                                            @if($item->quantity > 0)
                                            <form action="{{ route('cart.add') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $item->id }}">
                                                <div class="d-flex gap-2">
                                                    <input type="number" name="quantity" class="form-control" value="1" min="1" max="{{ $item->quantity }}" style="width: 70px;">
                                                    <button type="submit" class="btn border border-secondary rounded-pill px-3 text-primary flex-grow-1">Add</button>
                                                </div>
                                            </form>
                                            @else
                                            <button class="btn btn-light border-danger text-danger rounded-pill w-100 disabled">Out of Stock</button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @else
                            <div class="col-12 text-center py-5"><h5>No products found in {{ $cat->category }}</h5></div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<div class="container-fluid vesitable py-5">
    <div class="container py-5">
        <h1 class="mb-4">Fresh Organic Vegetables</h1>
        <div class="owl-carousel vegetable-carousel mt-4">
            @foreach ($vegetables as $vegetable)
            <div class="border border-primary rounded d-flex flex-column h-100 overflow-hidden position-relative mx-2 bg-white card-fixed-height">
                <img src="{{ asset('uploads/products/'.$vegetable->image)}}" 
                     class="img-fluid w-100 {{ $vegetable->quantity <= 0 ? 'opacity-50' : '' }}" 
                     style="height: 200px; object-fit: cover;">
                <div class="text-white bg-primary px-3 py-1 rounded position-absolute" style="top: 10px; right: 10px;">Vegetable</div>
                
                <div class="p-4 d-flex flex-column flex-grow-1">
                    <h4 class="product-title-fixed">{{ $vegetable->title }}</h4>
                    <p class="product-desc-fixed text-muted">{{ $vegetable->description }}</p>
                    
                    <div class="mt-auto">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <p class="text-dark fs-5 fw-bold mb-0">₹ {{ $vegetable->price }} / 100g</p>
                        </div>
                        @if($vegetable->quantity > 0)
                        <form action="{{ route('cart.add') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $vegetable->id }}">
                            <div class="d-flex gap-2">
                                <input type="number" name="quantity" class="form-control" value="1" min="1" max="{{ $vegetable->quantity }}" style="width: 70px;">
                                <button type="submit" class="btn border border-secondary rounded-pill px-3 text-primary flex-grow-1">Add</button>
                            </div>
                        </form>
                        @else
                        <button class="btn btn-light border-danger text-danger rounded-pill w-100 disabled">Out of Stock</button>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

@endsection

<style>
    /* 1. Force Carousel items to match heights */
    .vegetable-carousel .owl-stage {
        display: flex !important;
    }
    .vegetable-carousel .owl-item {
        display: flex !important;
        flex: 1 0 auto;
    }

    /* 2. Lock heights of content to prevent "pumping" */
    .product-title-fixed {
        height: 55px;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        margin-bottom: 10px;
    }

    .product-desc-fixed {
        height: 45px;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        margin-bottom: 15px;
    }

    /* 3. Helper Classes */
    .grayscale { filter: grayscale(100%); }
    
    /* Ensure cards in grid also behave */
    .card-custom {
        min-height: 480px;
    }
    
    .card-fixed-height {
        min-height: 450px;
        width: 100%;
    }
</style>