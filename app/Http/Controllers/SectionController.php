<?php

namespace App\Http\Controllers;
use Yajra\DataTables\DataTables;
use App\ClassModel;
use App\Section;
use App\Teacher;
use App\AppSetup;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $app_setup = AppSetup::find(1);
      $class = ClassModel::all();
      $teacher = Teacher::all();
       $content = view('section.show',array('all_class' => $class,'all_teacher'=>$teacher));
       return view('master', compact('content','app_setup'));
    }

    public function get_section($id) {
        $section = Section::select('sections.*','teachers.name')
                ->join('teachers', 'sections.teacher_id', '=', 'teachers.teacher_id' )
                ->where('class_id',$id)
                //->orderBy('section_id','DESC')
                ;
        return DataTables::of($section)
                ->orderColumns([''], '-:column $1')
                ->addColumn('action', function($section){
                                 return '<div class="btn-group pull-right">
                                   <button class="btn btn-default section_edit"  onclick="edit_section('.$section->section_id.')" data-toggle="tooltip" title="Edit Section" dta-id="'.$section->section_id.'"><i class="fa fa-edit"></i></button>
                                   <button class="btn btn-danger section_delete"  onclick="delete_section('.$section->section_id.')" data-toggle="tooltip" title="Delete Section" data-id="'.$section->section_id.'"><i class="fa fa-trash"></i></button>
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
            'class_id'      =>  'required',
            'teacher_id'    =>  'required',
            'section_name'  =>  'required'
        ]);
        
        
        Section::create($request->all());
        return response()->json(array('success'=>'Section Added Successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function show(Section $section)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $section = Section::find($id);
        return response()->json($section);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
       $section = Section::find($id);
       $request->validate([
           'edit_section_name'       =>  'required',
           'edit_teacher_id'         =>  'required'
       ]);
       
       $data = [
           'section_name'       =>  $request->edit_section_name,
           'teacher_id'         =>  $request->edit_teacher_id
       ];
       
       $section->update($data);
       return response()->json(array('success'=>'Section Updated Successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //$section = Section::find($id);
        Section::destroy($id);
        return 'Delete';
        
    }
}
