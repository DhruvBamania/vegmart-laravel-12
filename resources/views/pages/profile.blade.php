@extends('layouts.app')

@section('title','My Account')

@section('content')

<!-- Single Page Header start -->
        <div class="container-fluid page-header py-5">
            <h1 class="text-center text-white display-6">My Account</h1>
            <ol class="breadcrumb justify-content-center">
                <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                <li class="breadcrumb-item active text-white">My Account</li> 
            </ol>
        </div>
<!-- Single Page Header End -->

        <!-- Profile Start -->

        <div class="container-fluid contact">
            <div class="container">
                <div class="p-5 bg-light rounded">
                    <div class="row g-4">
                        <div class="container justify-content-center align-items-center col-12 col-md-6 col-lg-4 mb-0" style="min-height: 100vh;">
                            <div class="col-lg-12">
                            @if (Session::has('success'))
                                 <div class="alert alert-success">
                                    <p>{{Session::get('success')}}</p>                               
                                </div>
                            @endif
                            @if (Session::has('error'))
                                 <div class="alert alert-danger">
                                    <p>{{Session::get('error')}}</p>                               
                                </div>                                
                            @endif
                        </div>
                            <div class="card profile-card shadow ">
                                <div class="card-body text-center">
                                <img src="{{ $user->image ? asset('uploads/profile_images/' . $user->image) : asset('uploads/profile_images/default-avatar.jpg') }}" alt="User Profile" style="height: 250px; border-radius:50%; object-fit: cover;">
                                <form action="{{ route('updateUser',$user->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-12">
                                        <input type="text" name="name" placeholder="Enter the Title"
                                            value="{{ $user->name }}" class=" form-control mb-2" id="" >
                                    </div>
                                    <div class="col-lg-12">
                                        <input type="text" name="email" placeholder="Enter the Gmail"
                                            value="{{ $user->email }}" class=" form-control mb-2" id="" readonly>
                                    </div>
                                    
                                    @if ($user->mobile)
                                        <div class="col-lg-12">
                                            <input type="tel" name="mobile" placeholder="Enter the Phone"
                                                value="{{ $user->mobile }}" class=" form-control mb-2" id="" readonly>
                                        </div>
                                    @endif
                                    
                                    <div class="col-lg-12">
                                        <input type="file" name="image" class="form-control mb-2" id="">
                                    </div>
                                    <div class="col-lg-12 justify-content-between">
                                        <input type="submit" name="save" class="btn btn-success mt-2" value="Update">
                                        <a href="{{route('view.orders')}}" class="btn btn-primary mt-2 ms-4">View Orders</a>
                                        
                                    </div>
                                </div>
                            </form>
                                </div>
                            </div>
                        </div>
                                        
                        </div>
                    </div>
                </div>
            </div>
        </div>


    
        <!-- Profile End -->
@endsection