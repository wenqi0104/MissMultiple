<?php

namespace App\Http\Controllers;

use App\ActivityMark;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\User;
use App\Material;
use App\Comment;
use App\Paper;
use App\New_Exercise;
use App\Exam;
use App\Answer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;



class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /* $users = User::all();
        $students = User::where('type','Student')->get();
        $managers = User::where('type','=','Admin')->orwhere('type','Staff')->orderBy('type','desc')->get();
        return view('users.index')->with('users',$users)->with('students',$students)->with('managers',$managers); */
    }


 






    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()

    {
       /*  //个人创建material的edit线程保护
        if (auth()->user()->type == "Admin") {
            return view('users.create');
            
        }else{
            return redirect('/materials')->with('error', 'Unauthorized Page, you are not allowed to go to that page! ');
        } */
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:25',
            'email' =>'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|max:15',
            'age' => 'integer|min:0|max:80',
            'avatar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'type' => 'required'

        ]);


        if ($request->hasFile('avatar')) {
            //此段就是想把用户上传的文件重命名加上时间戳
            //获取带有扩展名的文件
            $filenameWithExt = $request->file('avatar')->getClientOriginalName();
            //获取文件名
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            //获取扩展
            $extension = $request->file('avatar')->getClientOriginalExtension();
            //文件名+扩展名
            $fileToStore = $filename . '_' . time() . '.' . $extension;
            //上传文件
            $path = $request->file('avatar')->storeAs('public/img', $fileToStore);
        } else {
            $fileToStore = 'noavatar.png';
        }


        $user = new User();
        $user->name = request('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->gender = $request->input('gender');
        $user->type = $request->input('type');
        $user->age = $request->input('age');
        $user->status = $request->input('status');

        if ($request->hasFile('avatar')) {
            $user->avatar = $fileToStore;
        }
        $user->save();



        return back()->with('success', 'New User Created Successfully');


    }

    public function records($id)
    {
        $user = User::find($id);
        return view('users.records')->with('user',$user);
    }

    
    public function email($id)
    {
        if(Auth::check() && auth()->user()->type != 'Student'){
            $user = User::find($id);
            return view('users.email')->with('user', $user);
        }else{
            return back()->with('error','Sorry,you are not be able to access that page');
        }
        
    }




    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        return view('users.show')->with('user',$user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        return view('users.edit')->with('user',$user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this -> validate($request,[
            'name' => 'required|string|max:25',
            'age' => 'integer|min:0|max:80',
            'avatar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'type' => 'required'

        ]);

        if($request->hasFile('avatar')){
            //此段就是想把用户上传的文件重命名加上时间戳
            //获取带有扩展名的文件
            $filenameWithExt = $request->file('avatar')->getClientOriginalName();
            //获取文件名
            $filename = pathinfo($filenameWithExt,PATHINFO_FILENAME);
            //获取扩展
            $extension = $request->file('avatar')->getClientOriginalExtension();
            //文件名+扩展名
            $fileToStore = $filename.'_'.time().'.'.$extension;
            //上传文件
            $path = $request->file('avatar')->storeAs('public/img',$fileToStore);


        }else{
            $fileToStore = 'noavatar.png';
        }


        $user = User::find($id);
        if($request->has('name')){
            $user->name = request('name');
        }
        $user->gender = $request -> input('gender');
        if($request->has('type')){
            $user->type = $request->input('type');
        }
        $user->age = $request->input('age');
        if($request->hasFile('avatar')){
            $user->avatar = $fileToStore;
        }
         
        //这行是用户状态
        $user->status = Input::get("status");
       
        $user->save();
        return back()->with('success','Your information updated Successfully');
    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


   /*  public function destroy($id)
    {
        $user = User::find($id);
        //检查用户防止未登录用户
    

        //防止将默认的avatar.png删除,如果不设置默认文件以下内容可以删除
        if($user -> avatar != 'noavatar.png'){
            Storage ::delete('public/img/'.$user->avatar);
        }

        $user -> delete();
        return redirect('/users') -> with('success','User Removed Successfully');  
    } */


    public function destroy(User $user)
        {
            $materials = Material::where('user_id', $user->id)->pluck('id');
            Comment::whereIn('parent_id', $materials)->delete();   //这行可能有问题
            Material::where('user_id', $user->id)->delete();
            ActivityMark::where('user_id',$user->id)->delete();
            New_Exercise::where('user_id',$user->id)->delete();
            Paper::where('user_id',$user->id)->delete();
            Exam::where('user_id',$user->id)->delete();
            Answer::where('user_id',$user->id)->delete();

            $user->delete();
            return back() -> with('success','User Removed Successfully');  
        }


}
