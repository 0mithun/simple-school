<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use Yajra\DataTables\DataTables;
use App\Teacher;
use App\AppSetup;
class TeacherController extends Controller
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
    {   $app_setup = AppSetup::find(1);
        $content = view('teacher.show');
        return view('master', compact('content','app_setup'));
    }

    public function get_teacher() {
        // $teacher = Teacher::all();
        //->orderBy('teacher_id','DESC');
        $teacher = Teacher::select('*')
                           // ->orderBy('teacher_id','DESC')
                ;
        
        return DataTables::of($teacher)
                        ->orderColumns([''], '-:column $1')
                        ->editColumn('photo',function($teacher){
                            return '<div class="thumb"><img   src="'.asset($teacher->photo).'" alt="" style="height:40px;width:auto" /></div>';
                        })
                        ->addColumn('action', function($teacher){
                                 return '<div class="btn-group pull-right">
                                   <button class="btn btn-success teacher_show " onclick="show_teacher('.$teacher->teacher_id.')" data-toggle="tooltip" title="View Teacher" data-id="'.$teacher->teacher_id.'"><i class="fa fa-eye"></i></button>
                                   <button class="btn btn-default teacher_edit"  onclick="edit_teacher('.$teacher->teacher_id.')" data-toggle="tooltip" title="Edit Teacher" dta-id="'.$teacher->teacher_id.'"><i class="fa fa-edit"></i></button>
                                   <button class="btn btn-danger teacher_delete"  onclick="delete_teacher('.$teacher->teacher_id.')" data-toggle="tooltip" title="Delete Teacher" data-id="'.$teacher->teacher_id.'"><i class="fa fa-trash"></i></button>
                              </div>';
                        })
//        ->column([
//            'photo' => ['orderable' => false, 'searchable' => false]
//        ])
        ->rawColumns(['photo','action'])->make(true);
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
        //return response()->json($request->all());
        $request->validate([
            'name'          =>  'required',
            'date_of_birth' =>  'required',
            'email'         =>  'required|email|unique:teachers,email',
            'age'           =>  'required|numeric',
            'address'       =>  'required',
            'contact'       =>  'required',
            'city'          =>  'required',
            'country'       =>  'required',
            'job_type'      =>  'required|numeric',
            'photo'         =>  'required',
        ]);
        
        
        $data = [
            'name'  =>  $request->name,
            'date_of_birth' =>  date('Y-m-d', strtotime($request->date_of_birth)) ,
            'email' =>  $request->email,
            'age'   =>  $request->age,
            'contact'   =>  $request->contact,
            'address'   =>  $request->address,
            'city'      =>  $request->city,
            'country'   =>  $request->country,
            'job_type'  =>  $request->job_type
            
            
        ];
        
        $photo = $request->file('photo');
        if($photo){
            $file_name = str_random(20). uniqid();
            $ext = strtolower($photo->getClientOriginalExtension());
            $full_name = $file_name.'.'.$ext;
            
            $path = 'public/upload/';
            $url =  $path.$full_name;
            if($photo->move($path,$full_name)){
                $data['photo'] = $url;
                Teacher::create($data);
                return response()->json(array('message'=>'Teacher Added Successfully'));
            }
        }
        //Teacher::create($data);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $teacher = Teacher::find($id);
        return response()->json($teacher);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function edit($teacher_id)
    {
        //return $teacher_id;
        $teacher = Teacher::find($teacher_id);
        
        return response()->json($teacher);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $teacher = Teacher::find($id);
        $request->validate([
            'edit_name'          =>  'required',
            'edit_date_of_birth' =>  'required',
            'edit_email'         =>  ($teacher->email== $request->edit_email) ? 'required|email' : 'required|email|unique:teachers,email',
            'edit_age'           =>  'required|numeric',
            'edit_address'       =>  'required',
            'edit_contact'       =>  'required',
            'edit_city'          =>  'required',
            'edit_country'       =>  'required',
            'edit_job_type'      =>  'required|numeric',
        ]);
        
        $data = [
            'name' => $request->edit_name,
            'date_of_birth' => date('Y-m-d', strtotime($request->edit_date_of_birth)) ,
            'email' => $request->edit_email,
            'age' => $request->edit_age,
            'address' => $request->edit_address,
            'contact' => $request->edit_contact,
            'city' => $request->edit_city,
            'country' => $request->edit_country,
            'job_type' => $request->edit_job_type,
        ];
       
       
       $photo = $request->file('edit_photo');
       if($photo){
           $file_name = str_random(20).uniqid();
           $ext = $photo->getClientOriginalExtension();
           $full_name = $file_name.".".$ext;
           
           $path = 'public/upload/';
           $file_url = $path.$full_name;
           if($photo->move($path,$full_name)){
               unlink($teacher->photo);
               $data['photo'] = $file_url;
               $teacher->update($data);
                return response()->json(array('succees'=>'Teacher Added Successfully'));
           }
       }else{
            $teacher->update($data);
             return response()->json(array('succees'=>'Teacher Added Successfully'));
       }
       
        return response()->json(array('succees'=>'Teacher Added Successfully'));
        //return response()->json($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //return $id;
        $teacher = Teacher::find($id);
        if($teacher){
            unlink($teacher->photo);
            Teacher::destroy($id);
            return 'delete';
        }
       
      
    }
}
