<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Material;
use App\New_Exercise;
use App\Answer;
use Illuminate\Support\Facades\Auth;

class NewExercisesController extends Controller
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
        $exercises = New_Exercise::orderBy('title','asc')->paginate(10);
        return view('new_exercises.index')->with('exercises', $exercises);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $materials_id = Material::all(['id', 'title']);
        return view('new_exercises.create')->with('materials_id', $materials_id);
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
            'title' => 'required|max:191',
            'multiplier' => 'required|integer|max:100',
            'multiplicand' => 'required|integer|max:100',
            'product' => 'required|integer|max:200',
            'marks' => 'required|integer|max:200',
            'hide' => 'nullable',
            'mcq' => 'nullable|max:191'

        ]);
        //mcq的形式转换
        if($request->has('mcq')){
            $c_mcq = json_encode($request->input('mcq'));
            $new_mcq1 = substr($c_mcq, 2, -2);
        } else {
            $new_mcq1 = 'noMcq';
        }
        

        $newExercise = new New_Exercise();
        $newExercise->title = $request->input('title');
        $newExercise->multiplier = $request->input('multiplier');
        $newExercise->multiplicand = $request->input('multiplicand');
        $newExercise->product = $request->input('product');
        $newExercise->marks = $request->input('marks');
        $newExercise->hide = $request->input('hide');
        $newExercise->user_id = auth()->user()->id;
        //$newExercise->material_id = $request->input('material_id');
      
            $newExercise->mcq = $new_mcq1;
        
        
        $newExercise->save();
        return redirect('/new_exercises')->with('success', 'New Exercises Created Successfully'); 

    }

    public function answerRecords($id){

        $exercise = New_Exercise::find($id);

        if(Auth::check() && auth()->user()->type != 'Student'){
            return view('new_exercises.records')->with('exercise', $exercise);
        }else{
            return redirect('/papers')->with('error', 'Unauthorized Page, you are not allowed to access to that page');
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
        /* 因为是展示detail所以使用单数形式 */
        $exercise = New_Exercise::find($id);
        return view('new_exercises.show')->with('exercise', $exercise);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $exercise = New_Exercise::find($id);
        $materials_id = Material::all(['id', 'title']);

        if (auth()->user()->type == 'Student') {
            return back()->with('error', 'Unauthorized Page, you are not allowed to access to that page');
        }else{
            return view('new_exercises.edit')->with('exercise', $exercise)->with('materials_id', $materials_id);
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
            'title' => 'required|max:191',
            'multiplier' => 'required|integer|max:100',
            'multiplicand' => 'required|integer|max:100',
            'product' => 'required|integer|max:200',
            'marks' => 'required|integer|max:200',
            'hide' => 'nullable',
            'mcq' => 'nullable|max:191'

        ]);
        //mcq的形式转换
        if($request->has('mcq')){
            $d_mcq = json_encode($request->input('mcq'));
            $new_mcq = substr($d_mcq, 2, -2);
        }else{
            $new_mcq= 'noMcq';
        }
        

        $newExercise = New_Exercise::find($id);
        $newExercise->title = $request->input('title');
        $newExercise->multiplier = $request->input('multiplier');
        $newExercise->multiplicand = $request->input('multiplicand');
        $newExercise->product = $request->input('product');
        $newExercise->marks = $request->input('marks');
        $newExercise->hide = $request->input('hide');
        $newExercise->user_id = auth()->user()->id;
        $newExercise->mcq = $new_mcq;
        
        $newExercise->save();
        return redirect('/new_exercises')->with('success', 'Exercise Updated Successfully'); 

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $exercise = New_Exercise::find($id);
        $answers = Answer::where('exercise_id',$id)->get();

        //检查用户防止未登录用户
        if (!auth()->guest()) {
            if (auth()->user()->type !== "Student") {
                $exercise->delete();
                foreach($answers as $answer){
                    $answer->delete();
                }

                return back()->with('success', 'Exercise Removed Successfully');
            } else {
                return back()->with('error', 'Unauthorized Page, you are not allowed to delete this exercise!');
            }
        } 
    }
}
