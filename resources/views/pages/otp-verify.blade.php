@extends('layouts.app')
@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card shadow p-4 text-center">
                <h3 class="mb-3">Verification</h3>
                <p class="text-muted small">Enter the 6-digit code sent to your email/phone</p>
                
                <form action="{{ route('otp.verify.post') }}" method="POST">
                    @csrf
                    <input type="text" name="otp" class="form-control form-control-lg text-center mb-3" 
                           placeholder="000000" maxlength="6" style="letter-spacing: 10px; font-weight: bold;" required>
                    
                    <button type="submit" class="btn btn-primary w-100 py-2">Verify & Login</button>
                </form>

                <div class="mt-3">
                    <a href="{{ route('login') }}" class="small text-decoration-none">Back to Login</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection