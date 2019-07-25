<?php

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

Route::get('/', function () {
    if(Auth::check()){
        return redirect('dashboard');
    }else{
         return view('login');
    }
   
});


Auth::routes();


Route::middleware(['auth'])->group(function(){
    //Dashboard 
    Route::resource('dashboard','DashboardController')->only(['index', 'update', 'destroy','store']);
    Route::get('get_all_events','DashboardController@get_all_events');
    
    
    //Profile
    Route::resource('profile','ProfileController')->only(['show', 'update']);
    Route::post('change_password','ProfileController@change_password');
    
    
    //Teacher
    Route::resource('teacher','TeacherController')->except('create');

    Route::get('get_teacher','TeacherController@get_teacher')->name('teacher.get_teacher');
    
    
    //Class
    
    Route::resource('class','ClassController')->except(['create', 'show']);
    Route::get('get_class','ClassController@get_class')->name('class.get_class');
    
    
    
    //Section
    
    Route::resource('section','SectionController')->except(['create', 'show']);
    Route::get('get_section/{id}','SectionController@get_section');
    
    
    
    //Subject
    
    Route::resource('subject','SubjectController')->except(['create','show']);
    Route::get('get_subject/{id}','SubjectController@get_subject')->name('subject.get_class');
    
    
    //Student
    Route::resource('student','StudentController')->except('create');
    Route::get('get_students/{id}','StudentController@get_student')->name('student.get_students');
    Route::get('make_section/{id}','StudentController@make_sections_by_class_id');
    
    Route::get('get_sections_by_class_id/{id}','StudentController@get_sections_by_class_id');
    
    Route::get('get_students_by_section/{class_id}/{section_id}','StudentController@get_students_by_section');
    
    Route::get('get_section_by_section_id/{id}','StudentController@get_section_by_section_id');
    
    //Attendance
    
    Route::resource('attendance','AttendanceController')->only(['index', 'store']);
    
    Route::get('load-teacher-attendance/{date}','AttendanceController@load_teacher_attendance');
    Route::post('load-student-attendance','AttendanceController@load_student_attendance');
    Route::get('get-class-select/{type}','AttendanceController@get_class_select');
    Route::get('get_section_by_class/{id}','AttendanceController@get_section_by_class');
    
    Route::post('get-attendance-report','AttendanceController@get_attendance_report');
    
    //Exam
    Route::resource('exam','ExamController');
    Route::get('get_exam','ExamController@get_exam');
    
    //Marks
    Route::resource('mark','MarkController');
    Route::get('get_exams_by_year/{exam_year}','MarkController@get_exams_by_year');
    Route::get('get_all_class_list/{exam_id}','MarkController@get_all_class_list');
    Route::post('get_subject_by_class','MarkController@get_subject_by_class');
    
    //Result Setting
    Route::resource('result-setting','ResultSettingController')->only(['index', 'store']);
    
    Route::get('get_all_class_select','ResultSettingController@get_all_class_select');
    Route::get('get_subject_by_class_id/{id}','ResultSettingController@get_subject_by_class_id');
    Route::post('result-setting-form','ResultSettingController@make_result_setting_form');
    
    Route::post('reset-result-setting','ResultSettingController@reset_result_setting');
    
    
    
    //Result 
    Route::resource('result','ResultController')->only(['index','store']);
    Route::post('result-entry-form','ResultController@result_entry_form');
    
    Route::get('view-result','ResultController@view_result');
    
    Route::post('get_result_by_class','ResultController@get_result_by_class');
    
    
    
    //app-setup
    Route::resource('app-setup','AppSetupController')->only(['index','show','update']);
    Route::post('app-logo-update','AppSetupController@update_app_logo');
});