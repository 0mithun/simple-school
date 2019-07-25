<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\ClassModel;
use App\Section;
use App\Student;
use App\AppSetup;
class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $app_setup = AppSetup::find(1);
        $all_class = ClassModel::all();
        $content = view('student.show',array('all_class'=>$all_class));
        return view('master', compact('content','app_setup'));
    }

    public function make_sections_by_class_id($id) {
        $sections = Section::all()->where('class_id',$id);
            
        if($sections->count() > 0){
            $html ='';
            foreach($sections as $section){
                $html .= '<option value="'.$section->section_id.'">'.$section->section_name.'</option>';
            }
         return $html;   
        }else{
            return '';
        }
        return $html;
    }
    
    
    
    public function get_sections_by_class_id($id) {
        $sections = Section::select('*')
                            ->where('class_id',$id)
                            ->get();
        return response()->json($sections);
    }
    
    
    
    public function get_student($id) {
        $students = Student::select('*')
                                ->where('class_id',$id)
                                //->orderBy('student_id','DESC')
                                ;
        
        return DataTables::of($students)
                        ->orderColumns([''], '-:column $1')
                        ->editColumn('student_photo',function($students){
                           return '<div class="thumb"><img   src="'.asset($students->student_photo).'" alt="" style="height:40px;width:auto" /></div>';
                        })
                        ->addColumn('action', function($students){
                                 return '<div class="btn-group pull-right">
                                   <button class="btn btn-success teacher_show " onclick="show_student('.$students->student_id.')" data-toggle="tooltip" title="View Student" data-id="'.$students->student_id.'"><i class="fa fa-eye"></i></button>
                                   <button class="btn btn-default teacher_edit"  onclick="edit_student('.$students->student_id.')" data-toggle="tooltip" title="Edit Student" dta-id="'.$students->student_id.'"><i class="fa fa-edit"></i></button>
                                   <button class="btn btn-danger teacher_delete"  onclick="delete_student('.$students->student_id.')" data-toggle="tooltip" title="Delete Student" data-id="'.$students->student_id.'"><i class="fa fa-trash"></i></button>
                              </div>';
        })->rawColumns(['student_photo','action'])->make(true);
    }
    
    /*
     * Get All Students
     * @param (int) $class_id, (int) $section
     * @Author: Mithun Halder
     * @return all students by class_id & section_id
     * Date 16/01/2018
     */
    public function get_students_by_section($class_id, $section_id) {
        $students = Student::select('*')
                                ->where('class_id',$class_id)
                                ->where('section_id',$section_id)
                                //->orderBy('student_id','DESC')
                                ;
        
        return DataTables::of($students)
                        //->orderColumn('student_id', 'student_id $1')
                        ->orderColumns([''], '-:column $1')
                        ->editColumn('student_photo',function($students){
                           return '<div class="thumb"><img   src="'.asset($students->student_photo).'" alt="" style="height:40px;width:auto" /></div>';
                        })
                        ->addColumn('action', function($students){
                                 return '<div class="btn-group pull-right">
                                   <button class="btn btn-success teacher_show " onclick="show_student('.$students->student_id.')" data-toggle="tooltip" title="View Student" data-id="'.$students->student_id.'"><i class="fa fa-eye"></i></button>
                                   <button class="btn btn-default teacher_edit"  onclick="edit_student('.$students->student_id.')" data-toggle="tooltip" title="Edit Student" dta-id="'.$students->student_id.'"><i class="fa fa-edit"></i></button>
                                   <button class="btn btn-danger teacher_delete"  onclick="delete_student('.$students->student_id.')" data-toggle="tooltip" title="Delete Student" data-id="'.$students->student_id.'"><i class="fa fa-trash"></i></button>
                              </div>';
        })->rawColumns(['student_photo','action'])->make(true);
    }
    
    /*
     * 
     * get_section_by_section_id($id)
     * @param (int) $id
     * @return single section by section id
     * @Author Mithun Halder
     * @date 16/01/2018
     */
    
    public function get_section_by_section_id($id) {
        $section = Section::select('sections.*','tbl_classes.class_name','tbl_classes.class_numaric')                            
                            ->join('tbl_classes','sections.class_id','=','tbl_classes.class_id')
                            ->where('section_id',$id)
                            ->first();
        
        return response()->json($section);
        
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'student_name'               =>  'required',
            'date_of_birth'              =>  'required',
            'age'                        =>  'required|numeric',
            'email'                      =>  'required|email|unique:students,email|',
            'contact'                    =>  'required',
            'address'                    =>  'required',
            'city'                       =>  'required',
            'country'                    =>  'required',
            'date_of_register'           =>  'required',
            'class_id'                   =>  'required|numeric',
            'section_id'                 =>  'required|numeric',
            'student_photo'              =>  'required',
        ]);
        
        $data = [
            'student_name'               =>   $request->student_name,
            'date_of_birth'              =>   date('Y-m-d', strtotime($request->date_of_birth)) ,
            'age'                        =>   $request->age,
            'email'                      =>   $request->email,
            'contact'                    =>   $request->contact,
            'address'                    =>   $request->address,
            'city'                       =>   $request->city,
            'country'                    =>   $request->country,
            'date_of_register'           =>   date('Y-m-d', strtotime($request->date_of_register)),
            'class_id'                   =>   $request->class_id,
            'section_id'                 =>   $request->section_id,
        ];
        
        $student_photo = $request->file('student_photo');
        if($student_photo){
            $file_name = str_random(20). uniqid();
            $ext = strtolower($student_photo->getClientOriginalExtension());
            $full_name = $file_name.'.'.$ext;
            
            $path = 'public/upload/';
            $url =  $path.$full_name;
            if($student_photo->move($path,$url)){
                $data['student_photo'] = $url;
                Student::create($data);
                //return response()->json(array('message'=>'Teacher Added Successfully'));
            }
        }
        
        return response()->json(array('success'=>'Student Add Successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $student = Student::select('students.*','sections.section_name','tbl_classes.class_name')
                            ->join('sections','students.section_id','=','sections.section_id')
                            ->join('tbl_classes','students.class_id','=','tbl_classes.class_id')
                            ->where('student_id',$id)                            
                            ->first();
                                
        return response()->json($student);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $student = Student::find($id);
        return response()->json($student);
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
        $student = Student::find($id);
        $request->validate([
            'edit_student_name'         =>  'required',
            'edit_date_of_birth'        =>  'required',
            'edit_email'                =>  'required',
            'edit_age'                  =>  'required',
            'edit_contact'              =>  'required',
            'edit_address'              =>  'required',
            'edit_city'                 =>  'required',
            'edit_country'              =>  'required',
            'edit_date_of_register'     =>  'required',
            'edit_class_id'             =>  'required',
            'edit_section_id'           =>  'required',
        ]);
        
        $data = [
            'student_name'              =>  $request->edit_student_name,            
            'date_of_birth'             =>  date('Y-m-d', strtotime($request->edit_date_of_birth)),
            'email'                     =>  $request->edit_email,
            'age'                       =>  $request->edit_age,
            'contact'                   =>  $request->edit_contact,
            'address'                   =>  $request->edit_address,
            'city'                      =>  $request->edit_city,
            'country'                   =>  $request->edit_country,
            'date_of_register'          => date('Y-m-d', strtotime($request->edit_date_of_register)),
            'class_id'                  =>  $request->edit_class_id,
            'section_id'                =>  $request->edit_section_id,
        ];
        
        $student_photo = $request->file('edit_student_photo');
        if($student_photo){
            $file_name = str_random(20). uniqid();
            $ext = strtolower($student_photo->getClientOriginalExtension());
            $full_name = $file_name.'.'.$ext;
            
            $path = 'public/upload/';
            $url =  $path.$full_name;
            if($student_photo->move($path,$url)){
                unlink($student->student_photo);
                $data['student_photo'] = $url;
                $student->update($data);
                
                //return response()->json(array('message'=>'Teacher Added Successfully'));
            }
        }else{
            $student->update($data);
        }
        
        
        return response()->json(array('success'=>'Student Information Update Successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       $student =  Student::find($id);
       if($student){
           unlink($student->student_photo);
           Student::destroy($id);
           return response('Student Deleted Successfully');
       }
        
    }
}
