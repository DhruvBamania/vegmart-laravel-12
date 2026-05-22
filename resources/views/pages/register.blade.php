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

                                <div class="form-item mb-3">
                                    <label class="form-label">Full Name<sup>*</sup></label>
                                    <input type="text" name="name" class="form-control" placeholder="Enter your Name" value="{{ old('name') }}" required>
                                    @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                {{-- Email --}}
                                <div class="form-item mb-3">
                                    <label class="form-label">Email Address<sup>*</sup></label>
                                    <input type="email" name="email" class="form-control" placeholder="example@mail.com" value="{{ old('email') }}" required>
                                    @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                {{-- Mobile (The New Field) --}}
                                <div class="form-item mb-3">
                                    <label class="form-label">Mobile Number<sup>*</sup></label>
                                    <div class="input-group">
                                        <span class="input-group-text">+91</span>
                                        <input type="tel" name="mobile" class="form-control" placeholder="Enter your phone number" value="{{ old('mobile') }}" required>
                                    </div>
                                    @error('mobile') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <div class="form-item mb-3">
                                    <label class="form-label">Password<sup>*</sup></label>
                                    <input type="password" name="password" class="form-control" placeholder="Minimum 6 characters" required>
                                    @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                                
                                <button class="w-100 btn form-control border-secondary py-3 bg-white text-primary " name="register" type="submit">Sign Up</button>
                                <p>Already have an account?<a href="{{ route('login') }}"> Login</a></p>
                            </form>
                            <div class="text-center mt-3">
                                <p>Or</p>
                                <a href="{{ route('google.login') }}" class="btn btn-outline-success w-100 py-3">
                                    <img src="https://developers.google.com/identity/images/g-logo.png" alt="Google Logo" style="width: 30px; margin-right: 8px; border-radius: 50%;">
                                    Sign up with Google
                                </a>
                            </div>
                        </div>
                        
                       
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Register End -->
@endsection