<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Material;
use App\Exercise;


class ExercisesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
       
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $exercises = Exercise::all();
        return view('exercises.index')->with('exercises', $exercises);

        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $materials_id = Material::all(['id','title']);
        return view('exercises.create')->with('materials_id',$materials_id);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createMcq()
    {
        $materials_id = Material::all(['id','title']);
        return view('exercises.mcq.create')->with('materials_id',$materials_id);
        
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    public function storeMcq(Request $request)
    {
        $this -> validate($request,[
            'title' => 'required',
            'marks' => 'required|max:191',
            /* 'tests' => 'required|mimes:jpeg,png,jpg,gif,svg,docx,doc,doctx,pdf|max:8000', */
            'questions' =>'required|max:191',
            'correct_answers' => 'required',
            'mcq' => 'nullable|max:191'
           
        ]);



        //正确答案传入数据库前形式转换，在最后view的使用中解码分类
        $d_correct_answer =  json_encode($request->input('correct_answers'));
        $new_correct_answer = substr($d_correct_answer, 2, -2);
        //问题的形式转换
        $d_question = json_encode($request->input('questions'));
        $new_question = substr($d_question, 2, -2);
        //分数的形式转换
        $d_mark = json_encode($request->input('marks'));
        $new_mark = substr($d_mark, 2, -2);
        //选项的形式转换
        $m_mcq = json_encode($request->input('mcq'));
        $new_mcq = substr($m_mcq, 2, -2);


        $exercise = new Exercise(); 
        $exercise->title = $request ->input('title');

        /* $exercise->questions = $request ->input('questions');
        $exercise->correct_answers = $request ->input('correct_answers'); */
        //将去除中括号的json数据存入属性中
        $exercise->questions = $new_question;
        $exercise->correct_answers = $new_correct_answer;
        $exercise->marks = $new_mark;
        $exercise->mcq = $new_mcq;


        //使用auth()和user()方法储存id，是php的方法
        $exercise->user_id = auth()->user()->id; 
        $exercise->material_id = $request->input('material_id');
        /* $exercise->tests = $fileToStore; */
        $exercise->save();

        return redirect('/exercises')->with('success','New Exercises Created Successfully');  
    }




    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    public function store(Request $request)
    {
        $this -> validate($request,[
            'title' => 'required',
            'marks' => 'required|max:191',
            /* 'tests' => 'required|mimes:jpeg,png,jpg,gif,svg,docx,doc,doctx,pdf|max:8000', */
            'questions' =>'required|max:191',
            'correct_answers' => 'required',
            'mcq' => 'nullable|max:191'
           
        ]);




        /* //单个视频的重命名以及上传
        if($request->hasFile('tests')){
            //此段就是想把用户上传的文件重命名加上时间戳
            //获取带有扩展名的文件
            $filenameWithExt = $request->file('tests')->getClientOriginalName();
            //获取文件名
            $filename = pathinfo($filenameWithExt,PATHINFO_FILENAME);
            //获取扩展
            $extension = $request->file('tests')->getClientOriginalExtension();
            //文件名+扩展名
            $fileToStore = $filename.'_'.time().'.'.$extension;
            //上传文件
            $path = $request->file('tests')->storeAs('public/tests',$fileToStore);
        } */

        //先将数据存为数组
        /* $d_question =  $request ->input('questions'); */
        //将string数据转换为json，然后除去两头的中括号


        //正确答案传入数据库前形式转换，在最后view的使用中解码分类
        $d_correct_answer =  json_encode($request->input('correct_answers'));
        $new_correct_answer = substr($d_correct_answer, 2, -2);
        //问题的形式转换
        $d_question = json_encode($request->input('questions'));
        $new_question = substr($d_question, 2, -2);
        //分数的形式转换
        $d_mark = json_encode($request->input('marks'));
        $new_mark = substr($d_mark, 2, -2);
        //mcq的形式转换
        $c_mcq = json_encode($request->input('mcq'));
        $new_mcq1 = substr($c_mcq, 2, -2);


        $exercise = new Exercise(); 
        $exercise->title = $request ->input('title');

        /* $exercise->questions = $request ->input('questions');
        $exercise->correct_answers = $request ->input('correct_answers'); */
        //将去除中括号的json数据存入属性中
        $exercise->questions = $new_question;
        $exercise->correct_answers = $new_correct_answer;
        $exercise->marks = $new_mark;
        $exercise->mcq = $new_mcq1;


        //使用auth()和user()方法储存id，是php的方法
        $exercise->user_id = auth()->user()->id; 
        $exercise->material_id = $request->input('material_id');
        /* $exercise->tests = $fileToStore; */
        $exercise->save();

        return redirect('/exercises')->with('success','New Exercises Created Successfully');  
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        /* 因为是展示detail所以使用单数形式 */
        $exercise = Exercise::find($id);
        return view('exercises.show')->with('exercise',$exercise);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $exercise = Exercise::find($id);
        $materials_id = Material::all(['id','title']);


        if (auth()->user()->type !== 'Admin') {
            return back()->with('error', 'Unauthorized Page, you are not allowed to access to that page');
        }
        

        return view('exercises.edit')->with('exercise',$exercise)->with('materials_id',$materials_id);
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
            'title' => 'required',
            'marks' => 'required',
            /* 'tests' => 'required|mimes:jpeg,png,jpg,gif,svg,docx,doc,doctx,pdf|max:8000', */
            'questions' => 'required|max:191',
            'correct_answers' => 'required',
            'mcq' => 'nullable|max:191'
            
           
        ]);
            //正确答案传入数据库前形式转换，在最后view的使用中解码分类
        $d_correct_answer =  json_encode($request->input('correct_answers'));
        $new_correct_answer = substr($d_correct_answer, 2, -2);
            //问题的形式转换
        $d_question = json_encode($request->input('questions'));
        $new_question = substr($d_question, 2, -2);
            //分数的形式转换
        $d_mark = json_encode($request->input('marks'));
        $new_mark = substr($d_mark, 2, -2);
            //mcq的形式转换
        $d_mcq = json_encode($request->input('mcq'));
        $new_mcq = substr($d_mcq, 2, -2);


        $exercise = Exercise::find($id);
        $exercise->title = $request->input('title');

        /* $exercise->questions = $request ->input('questions');
        $exercise->correct_answers = $request ->input('correct_answers'); */
        //将去除中括号的json数据存入属性中
        $exercise->questions = $new_question;
        $exercise->correct_answers = $new_correct_answer;
        $exercise->marks = $new_mark;
        $exercise->mcq = $new_mcq;

        //使用auth()和user()方法储存id，是php的方法
        $exercise->user_id = auth()->user()->id;
        $exercise->material_id = $request->input('material_id');
        /* $exercise->tests = $fileToStore; */
        $exercise->save();

        return redirect('/exercises')->with('success','Exercise Updated Successfully'); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $exercise = Exercise::find($id);

        //检查用户防止未登录用户
        if(!auth()->guest()){
            if (auth()->user()->id == $exercise->user_id || auth()->user()->type == "Admin") {
                $exercise->delete();
                return redirect('/exercises')->with('success', 'Exercise Removed Successfully');
            }else{
                return redirect('/exercises')->with('error', 'Unauthorized Page, you are not allowed to delete this exercise!');
            }
        } 

    }
}
