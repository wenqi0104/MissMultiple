@extends('layouts.app')

@section('content')
<div class="container-fluid" id="registerme">
    <div class="row">

        <div class="col-md-10 col-xl-9 mx-auto">
            <div class="card card-signin flex-row my-5">

                {{-- 左边的介绍 --}}
                <div class="card-img-left d-none d-md-flex" style="width: 45%; background: scroll center url('storage/img/portfolio/background/register.jfif');background-size: cover;">
                    
                </div> 
            
                {{-- 右边的注册内容 --}}
                <div class="card-body">
                    <h5 class="card-title text-center">Sign up</h5>
                        
                        <form class="form-signin" method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="form-label-group">                   
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Username" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                <label for="name">Username</label>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                            </div>

                            <div class="form-label-group">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Email" value="{{ old('email') }}" required autocomplete="email">
                                <label for="email">{{ __('E-Mail Address') }}</label>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <hr>

                            <div class="form-label-group">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Password" required autocomplete="new-password">
                                <label for="password">{{ __('Password') }}</label>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-label-group">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password" required autocomplete="new-password">
                                <label for="password-confirm">{{ __('Confirm Password') }}</label>
                            </div>

                            <button type="submit" class="btn btn-lg btn-primary btn-block text-uppercase">
                                {{ __('Register') }}
                            </button>
                            <a class="d-block text-center mt-2 small"  href="/login">Sign In</a>    
                           
                        </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

