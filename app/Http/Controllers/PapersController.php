<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Paper;
use App\New_Exercise;
use App\Material;


class PapersController extends Controller
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
        $papers = Paper::orderBy('title', 'asc')->paginate(6);
        return view('papers.index')->with('papers', $papers);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $new_exercises = New_Exercise::all();
        $materials_id = Material::all(['id', 'title']);
        return view('papers.create')->with('new_exercises',$new_exercises)->with('materials_id', $materials_id);
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
            'title' => 'required|max:191'

        ]);

        //mcq的形式转换
        $ex_id = json_encode($request->input('new_exercise_id'));
        $new_exid = substr($ex_id, 2, -2);

        $paper = new Paper();
        $paper->title = $request->input('title');
        $paper->material_id = $request->input('material_id');
        $paper->user_id = auth()->user()->id;
        $paper->new_exercise_id = $new_exid;
        $paper->save();
        return redirect('/papers')->with('success', 'New Exercise Book Created Successfully');

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
        $paper = Paper::find($id);
        
        return view('papers.show')->with('paper', $paper);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $paper = Paper::find($id);
        $new_exercises = New_Exercise::all();
        $materials_id = Material::all(['id', 'title']);

        if (auth()->user()->id == $paper->user_id || auth()->user()->type == 'Admin') {
            return view('papers.edit')->with('paper', $paper)->with('materials_id', $materials_id)->with('new_exercises',$new_exercises);
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
            'title' => 'required|max:191'

        ]);

        //mcq的形式转换
        if($request->has('new_exercise_id')){
            $ex_id = json_encode($request->input('new_exercise_id'));
            $new_exid = substr($ex_id, 2, -2);
        }
        

        $paper = Paper::find($id);
        $paper->title = $request->input('title');
        if($request->has('material_id')){
            $paper->material_id = $request->input('material_id');
        }      
        if($request->has('new_exercise_id')){
            $paper->new_exercise_id = $new_exid;
        }
        $paper->user_id = auth()->user()->id;
        $paper->save();
        return redirect('/papers/'.$id)->with('success', 'Exercise Book Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $paper = Paper::find($id);

        //检查用户防止未登录用户
        if (!auth()->guest()) {
            if (auth()->user()->id == $paper->user_id || auth()->user()->type == "Admin") {
                $paper->delete();
                return back()->with('success', 'Exercise Book Removed Successfully');
            } else {
                return back()->with('error', 'Unauthorized Page, you are not allowed to delete this exercise!');
            }
        } 
    }
}
