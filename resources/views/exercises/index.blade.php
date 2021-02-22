@extends('layouts.app')
@section('content')




<h2>Exercise page</h2>

<div class="container-fluid materialsme exercisesme" >
    @if (count($exercises)>0)
        @foreach ($exercises as $exercise)

        @php
            $fullmark = 0;
            //先分开为新array 然后遍历每个元素同时做int数据类型转换，然后没遍都把值加到一个int的参数里，最后直接输出那个fullmark
            $ma = explode('","',trim($exercise -> marks));
            foreach ($ma as $m) {
                $m = (int)$m;
                $fullmark = $m + $fullmark;
            }
        @endphp

        <div >
            {{-- 卡片首 --}}
            <div class="start">
                <h4> <a href="/exercises/{{ $exercise -> id }}">{{ $exercise -> title }}</a></h4>
                <small>By: {{ $exercise->user->name }}</small>

                {{-- edit按钮 ,只有在用户登录为staff或是admin才能用--}}
            @if (!Auth::guest())
                @if(Auth::user()->type !== 'Student')
                <a class="edit" href="/exercises/{{ $exercise -> id }}/edit" >edit</a>
                @endif
            @endif
            </div>
            
            {{-- 卡片主体 --}}
            <div class="center">
                <b>This exercise belongs to video {{ $exercise->material_id }} </b>
                
            </div>
            {{-- 卡片尾 --}}
            <div class="end">
                
            <p>Full Marks:  <small>{{ $fullmark }}</small></p>
            </div>
        
        </div>
        @endforeach

    @endif



    {{-- 上传新课件按钮 --}}
    @if (!Auth::guest())
        {{-- @if(Auth::user()->id == $exercise->user_id) --}}
        {{-- 判断用户类型，如果用户的类型是...就显示upload按钮 --}}
        @if(Auth::user()->type !== 'Student')
        <div class="btnme">
        <p><a href="/exercises/create"> <span class="material-icons">control_point</span></a></p>
        <a class="upload" href="/exercises/create">Create</a>
        </div>
        @endif
    @endif
        
    
</div>



@endsection