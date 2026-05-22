@extends('admin.layout.app')

@section('title','Admin Profile')

@section('content')

{{-- Category --}}
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <p class="card-title mb-0">My Profile</p>
                <div class="container justify-content-center align-items-center" style="min-height: 100vh;">
                    <div class="col-lg-12 text-center">
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
                                    <div class="col-lg-6">
                                        <input type="text" name="name" placeholder="Enter the Title"
                                            value="{{ $user->name }}" class=" form-control mb-2" id="" >
                                    </div>
                                    <div class="col-lg-6">
                                        <input type="text" name="email" placeholder="Enter the Gmail"
                                            value="{{ $user->email }}" class=" form-control mb-2" id="" readonly>
                                    </div>
                                    <div class="col-lg-6">
                                        <input type="text" name="location" placeholder="Enter the Location"
                                            value="{{ $user->location }}" class=" form-control mb-2" id="">
                                    </div>
                                    <div class="col-lg-6">
                                        <input type="text" name="role" placeholder="Enter the Role"
                                            value="{{ $user->role }}" class=" form-control mb-2" id="">
                                    </div>
                                    <div class="col-lg-6">
                                        <input type="file" name="image" class="form-control mb-2" id="">
                                    </div>
                                    <div class="col-lg-12">
                                        <input type="submit" name="save" class="btn btn-info mt-2" value="Update">
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



@endsection