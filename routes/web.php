<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


//默认进入about页面
Route::get('/', function () {
    return view('pages.about');
});

Route::resource('users', 'UsersController')->middleware('auth');
Route::resource('materials', 'MaterialsController');


//注意这里用了comment单数
Route::post('/comment/store', 'CommentsController@store')->name('comment.add');
Route::post('/reply/store', 'CommentsController@replyStore')->name('reply.add');

//新练习系统
Route::resource('new_exercises', 'NewExercisesController');

//旧练习系统
Route::resource('exercises', 'ExercisesController');
Route::get('/mcq', 'ExercisesController@createMcq');

//练习册系统
Route::resource('papers','PapersController');
//考试系统
Route::resource('exams', 'ExamsController');

//回答问题
Route::resource('answers', 'AnswersController');
Route::post('/new_store', 'AnswersController@new_store');
Route::post('/exam_answer', 'AnswersController@exam_answer');

//活动分数系统
Route::resource('activityMarks','ActivityMarksController');
Route::post('/loginMark', 'ActivityMarksController@loginMark');
Route::post('/assignMark', 'ActivityMarksController@assignMark');

Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');


Route::group(['prefix' => 'student', 'middleware' => ['auth', 'student']], function(){
    Route::get('/', function () {
        return view('student.basicInformation');
    });
});
Route::group(['prefix' => 'staff','middleware'=>['auth','staff']], function(){
    Route::get('/', function () {
        return view('staff.basicInformation');
    });
    Route::get('/personalUpload', function(){
        return view('staff.personalUpload');
    });
    Route::get('/userManagement', function () {
        return view('staff.userManagement');
    });
});

//个人活动分数记录
Route::get('/records/{id}', 'UsersController@records');

//问题回答记录
Route::get('/answerRecords/{id}', 'NewExercisesController@answerRecords');

Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'admin']], function(){
    Route::get('/', function () {
        return view('admin.basicInformation');
    });
    Route::get('/personalUpload', function(){
        return view('admin.personalUpload');
    });
    Route::get('/userManagement', function () {
        return view('admin.userManagement');
    });
    Route::get('/createUser', function () {
        return view('users.create');
    });
});

Route::get('/email/{id}','UsersController@email');
Route::post('/sendEmail','EmailController@sendEmail');