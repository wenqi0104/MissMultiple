@extends('layouts.app')

@section('content')
<div class="container" id="emailme">
    <div class="row justify-content-center">
        <div class="col-sm-11 col-md-9 col-lg-7 mx-auto">
            <div class="card card-signin flex-row my-5">
                <div class="card-body">
                    <h5 class="card-title text-center">Reset Password</h5>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form class="form-signin" method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <div class="form-label-group">
                           
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email Address" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            <label for="email">{{ __('E-Mail Address') }}</label>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-lg btn-warning  text-uppercase">
                                {{ __('Send Password Reset Link') }}
                            </button>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
