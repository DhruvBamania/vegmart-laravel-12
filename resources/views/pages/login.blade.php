@extends('layouts.app')

@section('title','Login')

@section('content')

<!-- Single Page Header start -->
        <div class="container-fluid page-header py-5">
            <h1 class="text-center text-white display-6">Login</h1>
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                <li class="breadcrumb-item active text-white">Login</li>
            </ol>
        </div>
<!-- Single Page Header End -->

        <!-- Login Start -->

        <div class="container-fluid contact">
            <div class="container">
                <div class="p-5 bg-light rounded">
                    <div class="row g-4">
                         <div class="col-12">
                            <div class="text-center mx-auto" style="max-width: 700px;">
                                <h1 class="text-primary">Log In to Account</h1>                                
                            </div>
                        </div>
                        <div class="col-lg-7 mx-auto">
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
                            <form action="{{ route('loginUser') }}" method="POST" enctype="multipart/form-data" class="">
                                @csrf
                                <input type="email" name='email' class="w-100 form-control border-0 py-3 mb-4" placeholder="Enter Your Email" required>
                                <input type="password" name='password' class="w-100 form-control border-0 py-3 mb-4" placeholder="Enter Your Password" required>
                                
                                <button class="w-100 btn form-control border-secondary py-3 bg-white text-primary " name="login" type="submit">Login</button>
                                <p>Don't have an account?<a href="{{ route('register') }}"> Register Now</a></p>
                            </form>
                        </div>
                       
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Login End -->
@endsection