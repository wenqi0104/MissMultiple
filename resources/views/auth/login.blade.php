@extends('layouts.app')
@section('content')


<div class="container-fluid" id="loginme">
    <div class="row">
        <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
            <div class="card card-signin flex-row my-5">
                <div class="card-body">
                    <h5 class="card-title text-center">Sign In</h5>



                   {{--  这是用户block状态登录的提醒，middleware在  app/http/middleware/CheckBlocked.php中 --}}
                    @if (session('message'))     
                        {{ session('message') }}
                    @endif 


                    <form class="form-signin" method="POST" action="{{ route('login') }}">
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

                        <div class="form-label-group">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" name="password" required autocomplete="current-password">
                                <label for="password">{{ __('Password') }}</label>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>

                        <div class="custom-control custom-checkbox mb-3">
                                    <input class="custom-control-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                        </div>

                        

                        <button type="submit" class="btn btn-lg btn-primary btn-block text-uppercase">
                            {{ __('Login') }}
                        </button>


                        {{-- @if (Route::has('password.request'))
                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                {{ __('Forgot Your Password?') }}
                            </a>
                        @endif --}}
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
