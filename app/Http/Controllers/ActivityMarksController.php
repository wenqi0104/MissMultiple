<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ActivityMark;


class ActivityMarksController extends Controller
{




    /* public function __construct()
    {
        $this->middleware('auth');
    } */

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $id = $request->input('material_id');
        
        $mark = new ActivityMark();
        $mark->user_id = auth()->user()->id;
        $mark->material_id = $id;
        $mark->activity_marks = $request->input('activity_marks');
        $mark->type = "Material Learning";
        $mark->save();

        return redirect('/materials/'.$id)->with('success', 'Great! 10 points have been added as a reward for courseware learning,keep going!');
    }


    public function loginMark(Request $request)
    {
        
        $mark = new ActivityMark();
        $mark->user_id = auth()->user()->id;
        $mark->activity_marks = $request->input('activity_marks');
        $mark->type = "Login Mark";
        $mark->save();

        return back()->with('success','Finish clocking in, lets cheer up together!');
    }


    public function assignMark(Request $request){

        $this->validate($request, [
            'activity_marks' => 'required|integer|digits_between:0,200|max:200'

        ]);

        $mark = new ActivityMark();
        $mark->user_id = $request->input('user_id');
        $mark->activity_marks = $request->input('activity_marks');
        $mark->exam_id = $request->input('exam_id');
        $mark->type = "Exam Mark";
        $mark->save();

        return back()->with('success', 'You have assign the mark to this user.');
    }









    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
