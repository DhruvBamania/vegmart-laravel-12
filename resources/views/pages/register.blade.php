@extends('layouts.app')

@section('title','Register')

@section('content')

<!-- Single Page Header start -->
        <div class="container-fluid page-header py-5">
            <h1 class="text-center text-white display-6">Register</h1>
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                <li class="breadcrumb-item active text-white">Register</li>
            </ol>
        </div>
<!-- Single Page Header End -->

        <!-- Register Start -->

        <div class="container-fluid contact">
            <div class="container">
                <div class="p-5 bg-light rounded">
                    <div class="row g-4">
                         <div class="col-12">
                            <div class="text-center mx-auto" style="max-width: 700px;">
                                <h1 class="text-primary">Create New Account</h1>                                
                            </div>
                        </div>
                        <div class="col-lg-7 mx-auto">
                            <form action="{{ route('registerUser') }}" method="POST" enctype="multipart/form-data" class="">
                                @csrf
                                <input type="text" name='name' class="w-100 form-control border-0 py-3 mb-4" placeholder="Enter your full name" required>
                                <input type="email" name='email' class="w-100 form-control border-0 py-3 mb-4" placeholder="Enter Your Email" required>
                                <input type="file" name='image' class="w-100 form-control border-0 py-3 mb-4" required>
                                <input type="password" name='password' class="w-100 form-control border-0 py-3 mb-4" placeholder="Enter Your Password" required>
                                
                                <button class="w-100 btn form-control border-secondary py-3 bg-white text-primary " name="register" type="submit">Sign Up</button>
                                <p>Already have an account?<a href="{{ route('login') }}"> Login</a></p>
                            </form>
                        </div>
                       
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Register End -->
@endsection