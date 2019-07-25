<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exam;
use Yajra\DataTables\DataTables;
use App\AppSetup;
class ExamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $app_setup = AppSetup::find(1);
        $content = view('exam.show');
        return view('master', compact('content','app_setup'));
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
          'exam_name'       =>  'required', 
          'exam_year'       =>  'required|numeric' 
       ]);
       
       Exam::create($request->all());
       
       return response()->json(array('success'=>'Exam Created Successfully'));
    }
    
    /*
     * Make Exam Datatable
     * @return datatable
     * @author Mithun Halder
     * @date 21/01/2018
     * 
     */
    
    public function get_exam() {
        $exams = Exam::all();
        
       return DataTables::of($exams)
                ->addColumn('action', function($exams){
                                 return '<div class="btn-group pull-right">
                                  
                                   <button class="btn btn-default exam_edit"  onclick="edit_exam('.$exams->exam_id.')" data-toggle="tooltip" title="Edit Exam" dta-id="'.$exams->exam_id.'"><i class="fa fa-edit"></i></button>
                                   <button class="btn btn-danger exam_delete"  onclick="delete_exam('.$exams->exam_id.')" data-toggle="tooltip" title="Delete Exam" data-id="'.$exams->exam_id.'"><i class="fa fa-trash"></i></button>
                              </div>';
                })->make(true);
        
        
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
        $exam = Exam::find($id);
        //return response()->json(array('success'=>'Exam Found'));
        
        return response()->json($exam);
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
        $exam = Exam::find($request->edit_exam_id);
        $request->validate([
            'edit_exam_name'        =>  'required',
            'edit_exam_year'        =>  'required|numeric',
        ]);
        
        $data = [
            'exam_name'         =>  $request->edit_exam_name,
            'exam_year'         =>  $request->edit_exam_year,
        ];
        $exam->update($data);
        
        return response()->json(array('success'=>'Exam Updated Successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $exam = Exam::find($id);
        if($exam){
            Exam::destroy($id);
            return 'Exam Delete';
        }
        
    }
}
