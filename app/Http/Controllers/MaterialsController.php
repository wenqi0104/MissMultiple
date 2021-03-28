<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Paper;
use App\Exam;
use App\Answer;
use App\Material;
use Illuminate\Support\Facades\File;



class MaterialsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //将所有课件按标题数字先后展示在页面
        $materials = Material::orderBy('title','asc')->paginate(4);
        return view('materials.index')->with('materials', $materials);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('materials.create');
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
            'description' => 'nullable|max:199',
            /* 'images' => 'required', */
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            /* 上传的视频文件 name 为 uploads ，数据库里的属性名为upload_file */
            /* 'uploads' => 'required', */
            'uploads' => 'mimes:mp4,mov,ogg,qt | max:200000'
        ]);

        /* 多图片文件的重命名以及上传 */
    if($request->hasFile('images'))
    {
        foreach($request->file('images') as $image)
        {
            $name = $image->getClientOriginalName();
            $image->move('storage/img/',$name);
            $data[] = $name;
        }
    }else{
        //这里是允许不上传图片时的默认, 若要取消默认就需要在上面验证中改为需要文件
         $data[] = 'noimage.jpg';
    }


//单个视频的重命名以及上传
    if($request->hasFile('uploads')){
            //此段就是想把用户上传的文件重命名加上时间戳
            //获取带有扩展名的文件
            $filenameWithExt = $request->file('uploads')->getClientOriginalName();
            //获取文件名
            $filename = pathinfo($filenameWithExt,PATHINFO_FILENAME);
            //获取扩展
            $extension = $request->file('uploads')->getClientOriginalExtension();
            //文件名+扩展名
            $fileToStore = $filename.'_'.time().'.'.$extension;
            //上传文件
            $path = $request->file('uploads')->move('storage/uploads/',$fileToStore);
        }else{
            $fileToStore = "no video";
        }


        $material = new Material(); 
        $material->title = $request ->input('title');
        $material->description = $request ->input('description');
        //使用auth()和user()方法储存id
        $material->user_id = auth()->user()->id;
        $material->images = json_encode($data);
        $material->uploads = $fileToStore;
        $material->save();

        return redirect('/materials')->with('success','New Course Material Created Successfully');  
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
        $material = Material::find($id);
        return view('materials.show')->with('material',$material);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        /* edit单个课件所以这里传入的是单数 */
        $material = Material::find($id);

        //个人创建material的edit线程保护
        if (auth()->user()->id == $material->user_id || auth()->user()->type == "Admin") {
            return view('materials.edit')->with('material', $material);
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
         $this -> validate($request,[
            'title' => 'required',
            'description' => 'nullable|max:1999',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'uploads' => 'mimes:mp4,mov,ogg,qt | max:200000'
        ]);


    if($request->hasFile('images'))
    {
        foreach($request->file('images') as $image)
        {
            $name = $image->getClientOriginalName();
            $image->move('storage/img/',$name);
            //save as json data
            $data[] = $name;
        }
    }else{
        //default image will be noimage.jpg
         $data[] = 'noimage.jpg';
    }


    //单个视频的重命名以及上传
    if($request->hasFile('uploads')){
            //此段就是想把用户上传的文件重命名加上时间戳
            //获取带有扩展名的文件
            $filenameWithExt = $request->file('uploads')->getClientOriginalName();
            //获取文件名
            $filename = pathinfo($filenameWithExt,PATHINFO_FILENAME);
            //获取扩展
            $extension = $request->file('uploads')->getClientOriginalExtension();
            //文件名+扩展名
            $fileToStore = $filename.'_'.time().'.'.$extension;
            //上传文件 
            $path = $request->file('uploads')->move('storage/uploads',$fileToStore);
        }


        $material = Material::find($id);
        $material->title = request('title');
        $material->description = $request -> input('description');
        if($request->hasFile('images')){
        $material->images = json_encode($data);
         }
        if ($request->hasFile('uploads')) {
            $material->uploads = $fileToStore;
        }
        $material -> save();

        return redirect('/materials/'.$id)->with('success','Course Material Updated Successfully');  
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $material = Material::find($id);
        //去除属性中两头的中括号
        $imageName = substr($material->images, 2, -2);
        //将转义后的双引号更改为空字符
        $imageName = strtr($imageName, "\"", " ");
        //将剩下的内容分隔为当数值然后存入数组中  explod（）方法直接就会变为数组
        $imageName = explode(' , ', trim($imageName));

        $papers = Paper::where('material_id',$id)->get();
        $exams = Exam::where('material_id',$id)->get();

        if (!auth()->guest()) {
            if (auth()->user()->id == $material->user_id || auth()->user()->type == "Admin") {
                $material->delete();

                //防止将默认的noimage.jpg删除,如果不设置默认文件以下内容可以删除
                if ($material->images != '["noimage.jpg"]') {
                    foreach($imageName as $img){
                        File::delete('storage/img/'. $img);
                    }
                }
                if ($material->uploads != 'no video') {
                    File::delete('storage/uploads/'.$material->uploads);
                }
                foreach($papers as $paper){
                    $paper->delete();
                }
                foreach($exams as $exam){
                    $exam->delete();
                    File::delete('storage/exams_file/'.$exam->exams_file);
                    
                    $answers = Answer::where('exam_id',$exam->id)->get();
                    foreach($answers as $answer){
                        $answer->delete();
                        File::delete('storage/answers_file/'.$answer->answers_file);
                    }
                }

                return back()->with('success', 'Course Material Removed Successfully');
            } else {
                return back()->with('error', 'Unauthorized Page, you are not allowed to delete this course material!');
            }
        } 
       

    }
}
