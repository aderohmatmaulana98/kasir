@extends('auth.base_auth')
@section('content')

<div class="auth-main v1">
    <div class="bg-overlay bg-white"></div>
    <div class="auth-wrapper">
        <div class="auth-form">
            <a href="{{ url('/') }}" class="d-block mt-5">
                <img src="{{ asset('assets/images/logo-white.svg') }}" alt="img">
            </a>
            <div class="card mb-5 mt-3">
                <div class="card-header bg-dark">
                    <h4 class="text-center text-white f-w-500 mb-0">Login with your email</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('login.post') }}" method="POST">
                        @csrf
                        <div class="form-group mb-3">
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                name="email" value="{{ old('email') }}" placeholder="Email Address">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                name="password" placeholder="Password">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary">Login</button>
                        </div>
                    </form>
                </div>
                <div class="card-footer border-top">
                    <div class="d-flex justify-content-between align-items-end">
                        <a href="{{ url('/') }}">
                            <img src="{{ asset('assets/images/logo-dark-sm.svg') }}" alt="img">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if (session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Sukses!',
        text: "{{ session('success') }}",
        showConfirmButton: false,
        timer: 3000
    });
</script>
@endif

@if (session('error'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: "{{ session('error') }}",
        showConfirmButton: true
    });
</script>
@endif

@endsection
