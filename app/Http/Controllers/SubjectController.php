<?php

namespace App\Http\Controllers;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use App\ClassModel;
use App\Teacher;
use App\Subject;
use App\AppSetup;
class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $app_setup = AppSetup::find(1);
        $all_class  = ClassModel::all();
        $all_teacher = Teacher::all();
        $content = view('subject.show', compact('all_class','all_teacher'));
       return view('master', compact('app_setup','content'));
    }

    public function get_subject($id) {
        $subject = Subject::select('subjects.*','teachers.name')
                ->where('class_id',$id)
                ->join('teachers', 'subjects.teacher_id', '=', 'teachers.teacher_id' )
                //->orderBy('subject_id','DESC')
                ;
        return DataTables::of($subject)
                ->orderColumns([''], '-:column $1')
                ->addColumn('action', function($subject){
                                 return '<div class="btn-group pull-right">
                                   <button class="btn btn-default section_edit"  onclick="edit_subject('.$subject->subject_id.')" data-toggle="tooltip" title="Edit Subject" data-id="'.$subject->subject_id.'"><i class="fa fa-edit"></i></button>
                                   <button class="btn btn-danger section_delete"  onclick="delete_subject('.$subject->subject_id.')" data-toggle="tooltip" title="Delete Subject" data-id="'.$subject->subject_id.'"><i class="fa fa-trash"></i></button>
                              </div>';
                })->make(true);
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
        $request->validate([
            'subject_name'          =>  'required',
            'teacher_id'            =>  'required',
            'marks'                 =>  'required|numeric|min:0|max:100'
        ]);
        
        Subject::create($request->all());
        
        return response()->json(array('success','Subject Add Successfully'));
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
        $subject = Subject::find($id);
        return response()->json($subject);
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
        $subject = Subject::find($id);
        $request->validate([
            'edit_subject_name'          =>  'required',
            'edit_teacher_id'            =>  'required',
            'edit_marks'                 =>  'required|numeric|min:0|max:100'
          
        ]);
        
        $data = [
            'subject_name'              =>  $request->edit_subject_name,
            'teacher_id'                =>  $request->edit_teacher_id,
            'marks'                     =>  $request->edit_marks
        ];
        $subject->update($data);
        
        return response()->json(array('success'=>'Subject Update Succesfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Subject::destroy($id);
        return 'Delete';
    }
}
