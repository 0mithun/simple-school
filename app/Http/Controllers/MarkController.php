<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exam;
use App\Marks;
use App\ClassModel;
use App\Subject;
use App\AppSetup;
class MarkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $app_setup = AppSetup::find(1);
        $exam_years = $this->get_all_exam_year();
        $content = view('mark.show',array('exam_years' => $exam_years ));
        
        return view('master', compact('content','app_setup'));
    }

    /*
     * 
     * Get all exam year
     * @return distnict exam year
     * @author Mithun Halder
     * @date 22/01/2018
     * 
     */
    
    
    public function get_all_exam_year() {
        $exam_year = Exam::distinct()
                    ->get(['exam_year'])
                ;
        
       return $exam_year; 
        
    }
    
    
    /*
     * Get All Exams By Exam Years
     * @param string $exam_year
     * @return all exams by $exam_year
     * @author Mithun Halder
     * @date 22/01/2018
     * 
     */
    
    public function get_exams_by_year($exam_year) {
        
        $exams = Exam::select('*')
                       ->where('exam_year',$exam_year)
                       ->get()
                       ;
        $html = '';
        if($exams->count() >0){
            $html .=' <option value="" selected>---- Please Select Exam ----</option>';
        foreach ($exams as $exam){
             $html .= ' <option value="'.$exam->exam_id.'">'.$exam->exam_name.'</option>';
        }
        }else{
           $html .=' <option value="" selected>---- No Exam Found ----</option>'; 
        }
        
        
        return $html;
    }
    
    
    /*
     * 
     * get_all_class_list()
     * @return all class list group
     * @author Mithun Halder
     * @date 22/01/2018
     */
    
    public function get_all_class_list($exam_id) {
        
        $classes = ClassModel::all();
        $html = '';
        $html .= '<div class="form-group"><label class="col-lg-4 control-label" for="class_id">Class Name: </label> <div class="col-lg-8">';
        if(is_object($classes) && $classes->count()){
            $html .='<div class="list-group">';
           foreach($classes as $class){
                $html .= '<a href="#" class="list-group-item" data-class-id="'.$class->class_id.'" data-exam-id="'.$exam_id.'">'.$class->class_name.'</a>';
            } 
            $html .='</div>';
        }else{
            $html .= '<div class="alert alert-success"><h3> No Class Found </h3></div>';
        }
        
        
        
        
        $html .= '</div></div>';
        
        return $html;
    }
    
    /*
     * 
     * get_subject_by_class()
     * @return subject table by class_id
     * @author Mithun Halder
     * @date 22/01/2018
     */
    
    public function get_subject_by_class(Request $request) {
        $subjects = Subject::all()
                            ->where('class_id', $request->class_id)
                    ;
        
        $html = '';
        
        if(is_object($subjects) && $subjects->count() ){
            $class = ClassModel::find($request->class_id);
            
            $html .= '<div class="alert alert-success"><h3>'.$class->class_name.'</h3></div>';
            
            $html .= '<table class="table table-bordered table-striped">';
            $html .= ' <thead><tr>';
            $html .= '<th class="col-lg-4">Subject Name</th><th col-lg-3>Total Mark</th><th col-lg-3>Pass Mark</th><th col-lg-2>Action</th>';
            $html .= '</tr></thead>';
            $html .= '<tbody>';
            $i = 0;
            foreach ($subjects as $subject){
            $i++;
                $exam = Marks::select('*')
                                ->where('exam_id',$request->exam_id)
                                ->where('class_id',$request->class_id)
                                ->where('subject_id',$subject->subject_id)
                                ->first();
                $total_mark = '';
                $pass_mark = '';
                if( is_object($exam) && $exam->count()){
                    $total_mark = $exam->total_mark;
                    $pass_mark = $exam->pass_mark;
                }
                
            $html .= ' <tr>';
            $html .=          '<td>'.$subject->subject_name.'</td>';
            $html .=          '<td><input type="hidden" name="subject_id" class="subject_id" value="'.$subject->subject_id.'" />';
            $html .=          '<input type="hidden" name="exam_id" value="'.$request->exam_id.'" class="exam_id" />';
            $html .=          '<input  type="hidden" name="class_id" value="'.$request->class_id.'" class="class_id" />';
            $html .=          '<input type="text" class="form-control total_mark" name="total_mark_'.$i.'" id="total_mark_'.$i.'" value="'.$total_mark.'" /></td>';
            $html .=          '<td><input type="text" class="form-control pass_mark" name="pass_mark_'.$i.'" id="pass_mark_'.$i.'" value="'.$pass_mark.'" /></td>';
            $html .=          '<td><button class="btn btn-primary mark_subject_save">Save</button></td>';
            $html .= '</tr>';
        }
                
        $html .=  '</tbody></table>';
        }else{
            $html .= '<div class="alert alert-warning"><h3>No Subject Found </h3></div>';
        }
        
       
        return $html;
        //return response()->json($subjects);
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
        
        $total_mark = $request->{'total_mark_'.$request->total_id};
        $pass_mark = $request->{'pass_mark_'.$request->pass_id};
        
        $request->validate([
            'total_mark_'.$request->total_id  => 'required|numeric|min:1',
            'pass_mark_'.$request->pass_id => 'required|numeric|min:1|max:'.$total_mark,
        ],[
            'total_mark_'.$request->total_id.'.required' => 'Total Mark Field is Required',
            'total_mark_'.$request->total_id.'.numeric' => 'Total Mark must be a number',
            'total_mark_'.$request->total_id.'.min' => 'Total Mark must be at least 1',
            
            'pass_mark_'.$request->pass_id.'.required'  => 'Pass Mark Field is Required',
            'pass_mark_'.$request->pass_id.'.numeric'  => 'Pass Mark must be a number',
            'pass_mark_'.$request->pass_id.'.min'  => 'Pass Mark must be at least 1',
            'pass_mark_'.$request->pass_id.'.max'  => 'Pass Mark may not be greater than'.$total_mark,
        ]);
       
       
        
        $exam = Marks::select('*')
                        ->where('exam_id',$request->exam_id)
                        ->where('class_id',$request->class_id)
                        ->where('subject_id',$request->subject_id)
                        ->first();
        if( is_object($exam) && $exam->count()>0){
            $data = [
            'total_mark'    =>      $total_mark,
            'pass_mark'     =>      $pass_mark,
             ];
            $exam->update($data);
            return response()->json(array('success'=>'Mark Updated Successfully'));
        }else{
            $data = [
            'total_mark'    =>      $total_mark,
            'pass_mark'     =>      $pass_mark,
            'class_id'      =>      $request->class_id,
            'exam_id'      =>       $request->exam_id,
            'subject_id'      =>    $request->subject_id,
             ];
        
            Marks::create($data);
            return response()->json(array('success'=>'Mark Added Successfully'));
        }
        
        
        
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
