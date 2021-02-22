@extends('layouts.app')
@section('content')


<div class="page-content page-container" id="page-content">
    <div class="padding">
        <div class="row container d-flex justify-content-center">
            <div class="col-xl-12 col-md-12 col-lg-10">
                <div class="card user-card-full">
                    <div class="row m-l-0 m-r-0">
                        <div class="col-sm-4 bg-c-lite-green user-profile">
                            <div class="card-block text-center text-white">
                            <div class="m-b-25"> <img src="/storage/img/{{ $user['avatar'] }}" class="img-radius" style="width: 70px" alt="User-Profile-Image"> </div>
                                <h6 class="f-w-600">
                                {{ $user['name'] }}
                                </h6>
                            </div>
                        </div>

                        <div class="col-sm-8">
                            <div class="card-block">
                                <h6 class="m-b-20 p-b-5 b-b-default f-w-600">Information</h6>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <p class="m-b-10 f-w-600">Email</p>
                                        <h6 class="text-muted f-w-400">{{ $user['email'] }}</h6>
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="m-b-10 f-w-600">Gender</p>
                                        <h6 class="text-muted f-w-400">{{ $user['gender'] }}</h6>
                                    </div>
                                </div>
                               <br>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <p class="m-b-10 f-w-600">age</p>
                                        <h6 class="text-muted f-w-400">{{ $user['age'] }}</h6>
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="m-b-10 f-w-600">User type</p>
                                        <h6 class="text-muted f-w-400">{{ $user['type'] }}</h6>
                                    </div>
                                </div>
                                @if (Auth::check())
                                    <a href="/users/{{ $user['id']}}/edit" class="btn btn-default"> Edit </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection