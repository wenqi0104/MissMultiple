<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Answer;
use App\Exercise;
use App\New_Exercise;
use App\ActivityMark;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class AnswersController extends Controller
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
    public function new_store(Request $request)
    {

        $this -> validate($request,[
            'answers' => 'required|max:191',
            'description' =>'nullable|max:191',
           
        ]);

        //将回答记录中当前的uer_id与填表时的exercise_id数据存入$records中
        /* $records = Answer::where('user_id', '=', auth()->user()->id)
        ->where('exercise_id', '=', $request->input('exercise_id'))->get();
        用count()计数
        $recordCount = $records->count();

        if( $recordCount < 1 ){*/


        $s_answer = json_encode($request->input('answers'));
        $new_answer = substr($s_answer, 2, -2);


        $answer = new Answer();
        $answer->answers = $new_answer;
        $answer->user_id = auth()->user()->id;
        $answer->exercise_id = $request->input('exercise_id');
        $answer->description = $request->input('description');
        $answer->save();

        /*  //ans是当前学生回答的答案（输入的时候就是数字的形式）  单问题上传模式
        $ans =  $request->input('answers'); 
        

        //找出当前exercise的分数那一列的信息然后通过解码json数据将最终的分数数值传入correct_ans里
        $id =  $request->input('exercise_id');
        $correct = Exercise::where('id', '=', $id)->first('correct_answers');
        $correct_ans = substr($correct,19,-1); */


        //多问题上传模式
        $ans = (int)$new_answer ;

        $id =  $request->input('exercise_id');
        $h = New_Exercise::where('id', '=', $id )->first('hide');
        $h = (int)substr($h, 8, -1);
        $product = New_Exercise::where('id', '=', $id)->first('product');
        $product1 = (int)substr($product, 11, -1);
        $multiplicand = New_Exercise::where('id', '=', $id)->first('multiplicand');
        $multiplicand1 = (int)substr($multiplicand, 16, -1);
        $multiplier = New_Exercise::where('id', '=', $id)->first('multiplier');
        $multiplier1 = (int)substr($multiplier, 14, -1);
        $mark = New_Exercise::where('id', '=', $id)->first('marks');
        $Mark = substr($mark, 9, -1); 

        $correctAns = 0;
        if ($h == 1) {
            $correctAns = $product1;
        } elseif ($h == 2) {
            $correctAns = $multiplicand1;
        } else {
            $correctAns = $multiplier1;
        }
         if ($ans == $correctAns) {
            $mark = New_Exercise::where('id', '=', $id)->first('marks');
            $Mark = substr($mark, 9, -1); 
            $mark = new ActivityMark();
            $mark->user_id = auth()->user()->id;
            $mark->exercise_id = $id;
            $mark->activity_marks = $Mark;
            $mark->type ="Question Answer";
            $mark->save();
            return back()->with('success', 'Correct Answer! Well Done (:' . ' Activity mark + ' . $Mark.' !!');
        } else {
             return back()->with('error','Sorry，you didnt make it correct! The correct answer is '.$correctAns ); 
        }

       
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
            'answers' => 'required|max:191',
            'description' =>'nullable|max:191',
           
        ]);

        //将回答记录中当前的uer_id与填表时的exercise_id数据存入$records中
        /* $records = Answer::where('user_id', '=', auth()->user()->id)
        ->where('exercise_id', '=', $request->input('exercise_id'))->get();
        用count()计数
        $recordCount = $records->count();

        if( $recordCount < 1 ){*/



        $s_answer = json_encode($request->input('answers'));
        $new_answer1 = substr($s_answer, 2, -2);

        $answer = new Answer();
        $answer->answers = $new_answer1;
        $answer->user_id = auth()->user()->id;
        $answer->exercise_id = $request->input('exercise_id');
        $answer->description = $request->input('description');
        $answer->save();

        /*  //ans是当前学生回答的答案（输入的时候就是数字的形式）  单问题上传模式
        $ans =  $request->input('answers'); 
        

        //找出当前exercise的分数那一列的信息然后通过解码json数据将最终的分数数值传入correct_ans里
        $id =  $request->input('exercise_id');
        $correct = Exercise::where('id', '=', $id)->first('correct_answers');
        $correct_ans = substr($correct,19,-1); */


        //多问题上传模式
        $ans = explode('","', trim($new_answer1));

        $id =  $request->input('exercise_id');
        $correct = Exercise::where('id', '=', $id)->first('correct_answers');
        $correct_ans = substr($correct, 20, -2);
        $correct_anss = explode('\",\"', trim($correct_ans));


        $i = 0;
        $m = 0;
        foreach($correct_anss as $correct){
            if( $ans[$i] == $correct){
                
                $mark = Exercise::where('id', '=', $id)->first('marks');
                $sub = substr($mark, 10, -2);
                $fullMark = explode('\",\"', trim($sub));
                $intMark = (int)$fullMark[$i];
                $m = $m + $intMark; 

            }
            $i++;
    
        }
        //创建一条新的活动分记录
        $marks = new ActivityMark();
        $marks->user_id = auth()->user()->id;
        $marks->exercise_id = $id;
        $marks->activity_marks = $m;
        $marks->save();
        
        return back()->with('success', 'You have submit the answers! Your mark: '.$m);

        /* 
        //!!!重要将两个数值进行比较，一样则得分，不一样就给出错误
        if($ans == $correct_ans){
            
           //  $mark = Exercise::where('id','=',$id)->first('marks');
           // $fullMark = substr($mark,9,-1); 
            $mark = Exercise::where('id','=',$id)->first('marks');
            $fullMark = explode('","', trim($mark));

            //创建一条新的活动分记录
            $mark = new ActivityMark();
            $mark->user_id = auth()->user()->id;
            $mark->exercise_id = $id;
            $mark->activity_marks = $fullMark;
            $mark->save();

            
            return back()->with('success','Correct Answer! Well Done (:');
        }else{
            // return back()->with('error','Sorry，you didnt make it correct! The correct answer is '.$correct_ans ); 
            return back()->with('error','Sorry，you didnt make it correct! The correct answer is ');
        }
 */

     


        /* }else{
            //如果提交次数(数据库中的记录数)大于一次,就不能提交了
            return back()->with('error','Sorry，you are not allowed to answer this exercise more than once!');
        } */
       
    }



        public function exam_answer(Request $request){
            $this->validate($request, [
            'description' => 'nullable|max:191',
            'answers_file' => 'required|mimes:docx,doc,doctx,pdf,txt|max:5000'

        ]);


        //单个文件的重命名以及上传
        if ($request->hasFile('answers_file')) {
            //此段就是想把用户上传的文件重命名加上时间戳
            //获取带有扩展名的文件
            $filenameWithExt = $request->file('answers_file')->getClientOriginalName();
            //获取文件名
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            //获取扩展
            $extension = $request->file('answers_file')->getClientOriginalExtension();
            //文件名+扩展名
            $fileToStore = $filename .'.'. $extension;
            //上传文件
            $path = $request->file('answers_file')->storeAs('public/answers_file', $fileToStore);
        }



            $answer = new Answer();
            $answer->answers_file = $fileToStore;
            $answer->user_id = auth()->user()->id;
            $answer->description = $request->input('description');
            $answer->exam_id = $request->input('exam_id');
            $answer->save();


            return back()->with('success','We have received your answer!');


            
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
            'description' => 'max:199',
        ]);
        $answer = Answer::find($id);
        $answer->description = request('description');
        $answer->save();

        return back()->with('success','Thankyou for your feedback, we have received your query.');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $answer = Answer::find($id);

        if (!auth()->guest()) {
            if (auth()->user()->type == "Admin") {
            $answer->delete();
            return back()->with('success', 'Student Answer has been removed.');
            File::delete('storage/answers_file/' . $answer->answers_file);
            }else{
                return back()->with('error', 'Unauthorized Page, you are not allowed to delete this Answer!');
            }
        }


    }
}
