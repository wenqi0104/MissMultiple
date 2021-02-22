<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exam;
use App\Material;
use App\Answer;
use Illuminate\Support\Facades\File;




class ExamsController extends Controller
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
        $exams = Exam::orderBy('title','asc')->paginate(6);
        return view('exams.index')->with('exams',$exams);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $materials_id = Material::all(['id', 'title']);
        return view('exams.create')->with('materials_id', $materials_id);
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
            'title' => 'required',
            'description' => 'nullable|max:191',
            'exams_file' => 'required|mimes:pdf|max:8000',
            /* 'exams_file' => 'required|mimes:docx,doc,doctx,pdf,pptx|max:8000', */
            'marks' => 'required|integer|digits_between:0,200|max:200'

        ]);

            //单个文件的重命名以及上传
        if($request->hasFile('exams_file')){
            //此段就是想把用户上传的文件重命名加上时间戳
            //获取带有扩展名的文件
            $filenameWithExt = $request->file('exams_file')->getClientOriginalName();
            //获取文件名
            $filename = pathinfo($filenameWithExt,PATHINFO_FILENAME);
            //获取扩展
            $extension = $request->file('exams_file')->getClientOriginalExtension();
            //文件名+扩展名
            $fileToStore = $filename.'_'.time().'.'.$extension;
            //上传文件
            $path = $request->file('exams_file')->storeAs('public/exams_file',$fileToStore);
        }

        $exam = new Exam();
        $exam->title = $request->input('title');
        $exam->description = $request->input('description');
        $exam->exams_file = $fileToStore;
        $exam->material_id = $request->input('material_id');
        $exam->marks = $request->input('marks');
        $exam->user_id = auth()->user()->id;
        $exam->save();

        return redirect('/exams')->with('success', 'New Exams Created Successfully'); 


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
        $exam = Exam::find($id);
        $materials_id = Material::all(['id', 'title']);
        $answers = Answer::where('exam_id', '=',$id)->orderBy('created_at','desc')->get();
        return view('exams.show')->with('exam', $exam)->with('materials_id',$materials_id)->with('answers',$answers);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $exam = Exam::find($id);
        $materials_id = Material::all(['id', 'title']);

        if (auth()->user()->id == $exam->user_id || auth()->user()->type == 'Admin') {
            return view('exams.edit')->with('exam', $exam)->with('materials_id', $materials_id);
        }else{
            return back()->with('error', 'Unauthorized Page, you are not allowed to access to that page');
        }



        
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
        $this->validate($request, [
            'title' => 'required',
            'description' => 'nullable|max:191',
            /* 'exams_file' => 'required|mimes:jpeg,png,jpg,gif,svg,docx,doc,doctx,pdf|max:8000', */
            'exams_file' => 'mimes:pdf|max:5000',
            /* 'exams_file.*' => 'required|mimes:docx,doc,doctx,pdf,pptx|max:8000', */
            'marks' => 'required|integer|digits_between:0,200|max:200'

        ]);

        //单个文件的重命名以及上传
        if ($request->hasFile('exams_file')) {
            //此段就是想把用户上传的文件重命名加上时间戳
            //获取带有扩展名的文件
            $filenameWithExt = $request->file('exams_file')->getClientOriginalName();
            //获取文件名
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            //获取扩展
            $extension = $request->file('exams_file')->getClientOriginalExtension();
            //文件名+扩展名
            $fileToStore = $filename . '_' . time() . '.' . $extension;
            //上传文件
            $path = $request->file('exams_file')->storeAs('public/exams_file', $fileToStore);
        }

        $exam = Exam::find($id);
        $exam->title = $request->input('title');
        $exam->description = $request->input('description');
        if ($request->hasFile('exams_file')) {
            $exam->exams_file = $fileToStore;
        }
        if($request->has('material_id')){
            $exam->material_id = $request->input('material_id');
        }
        $exam->marks=$request->input('marks');
        $exam->user_id = auth()->user()->id;
        $exam->save();

        return redirect('/exams/'.$id)->with('success', 'Exams Updated Successfully'); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $exam = Exam::find($id);
        $answers = Answer::where('exam_id',$exam->id)->get();

       
        //检查用户防止未登录用户
        if (!auth()->guest()) {
            if (auth()->user()->id == $exam->user_id || auth()->user()->type == "Admin") {
                $exam->delete();
                foreach ($answers as $answer) {
                    $answer->delete();
                    File::delete('storage/answers_file/'.$answer->answers_file);
                }   
                File::delete('storage/exams_file/'.$exam->exams_file);
                return back()->with('success', 'Exam Removed Successfully');
            }else{
                return back()->with('error', 'Unauthorized Page, you are not allowed to delete this exercise!');
            }
        } 

    }
}
