<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Exam;
use App\Marks;
use App\ClassModel;
use App\Subject;
use App\Student;
use App\Section;
use App\Result;
use App\ResultSetting;
use App\AppSetup;
class ResultController extends Controller
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
        $content = view('result.show',array('exam_years' => $exam_years ));
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
     * result_entry_form()
     * @return Result Entry Form
     * @author Mithun Halder
     * @date 27/01/2018
     */
    
    public function result_entry_form(Request $request) {
        $exam_id = $request->exam_id;
        $class_id = $request->class_id;
        $subject_id = $request->subject_id;
        
         $students = Student::all()
                                 ->where('class_id',$class_id)
                            ;
         $html = '';
         
        $exam = Exam::find($request->exam_id);
        $class = ClassModel::find($request->class_id);
        $subject = Subject::find($request->subject_id);

        $html .= '<div class="col-lg-12"><div class="alert alert-success"><h3>'.$exam->exam_name.'</h3><h4>'.$class->class_name.' ('.$class->class_numaric.'), Subject : '.$subject->subject_name.'</h4></div></div>';
        
         $html .= '<table class="table table-bordered table-striped">';
         $html .=   '<thead>';
         $html .=       '<tr>';
         $html .=         '  <th class="col-lg-2">#</th>';
         $html .=           '<th class="col-lg-4">Student Name: </th>';
         $html .=           '<th class="col-lg-2">Section Name: </th>';
         $html .=          ' <th class="col-lg-3">Mark</th>';
         $html .=          ' <th class="col-lg-1">Action</th>';
         $html .=      '</tr>';
         $html .=  ' </thead>';
         $html .=   '<tbody>';
         
         if(is_object($students) && $students->count()){
            $i = 0;
            foreach ($students as $student){
               $section  = Section::find($student->section_id);
               $student_mark = Result::select('*')
                                ->where('exam_id',$request->exam_id)
                                ->where('class_id',$student->class_id)
                                ->where('subject_id',$request->subject_id)
                                ->where('student_id',$student->student_id)
                                ->first()
                    ;
               
               $i++;
               $html .= '<tr>';
               $html .= '<td>'.$i ;
               $html .= '<input type="hidden" name="student_id" class="student_id" value="'.$student->student_id.'" />';
               $html .= '<input type="hidden" name="exam_id" class="student_exam_id" value="'.$exam_id.'" />';
               $html .= '<input type="hidden" name="class_id" class="student_class_id" value="'.$class_id.'" />';
               $html .= '<input type="hidden" name="subject_id" class="student_subject_id" value="'.$subject_id.'" />';
               $html .= '</td>';
               $html .= '<td>'.$student->student_name. '</td>';
               $html .= '<td>'.$section->section_name. '</td>';
               if($student_mark){
                  $html .= '<td><input type="text" name="mark" class="form-control student_mark" value="'.$student_mark->mark.'" /></td>'; 
               }else{
                   $html .= '<td><input type="text" name="mark" class="form-control student_mark" /></td>';
               }
               
               $html .= '<td><input type="submit"  class="btn btn-primary student_mark_save" value="save" /></td>';

               $html .= '</tr>';
            }//End foreach
         }else{
             $html .= '<tr>';
             $html .= '<td colspan="5">';
             $html .= '<div class="alert alert-warning"><h4>No Student Found</h4></div>';
             $html .= '</td>';
             $html .= '</tr>';
         }//End if
        $html .=   '</tbody>';
        $html .=  '</table>';
        
        return $html;
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
        $mark = Marks::select('*')
                        ->where('exam_id',$request->exam_id)
                        ->where('class_id',$request->class_id)
                        ->where('subject_id',$request->subject_id)
                        ->first()
                ;
        
        $student_mark = Result::select('*')
                                ->where('exam_id',$request->exam_id)
                                ->where('class_id',$request->class_id)
                                ->where('subject_id',$request->subject_id)
                                ->where('student_id',$request->student_id)
                                ->first()
                    ;
        if($student_mark){
            $request->validate([
                'student_mark'          =>  'required|numeric|min:0|max:'.$mark->total_mark
            ]);

            $data = [
                'mark'  =>  $request->student_mark,
            ];

            $student_mark->update($data);
            
        }else{
            $request->validate([
                'student_mark'          =>  'required|numeric|min:0|max:'.$mark->total_mark
            ]);

            $data = [
                'exam_id'       =>  $request->exam_id,
                'class_id'      =>  $request->class_id,
                'subject_id'    =>  $request->subject_id,
                'exam_id'       =>  $request->exam_id,
                'student_id'    =>  $request->student_id,
                'mark'  =>  $request->student_mark,
            ];

            Result::create($data);
        }
        return response()->json(array('success'=>'Student Mark Added Successfully'));
    }
    
    /*
     * view_result()
     * @return result view page
     * @author Mithun Halder
     * @date 28/01/2018
     * 
     * 
     */
    public function view_result() {
        $app_setup = AppSetup::find(1);
        $all_class = ClassModel::all();
        $exam_years = $this->get_all_exam_year();
        $content = view('result.view_result',array('exam_years' => $exam_years,'all_class'=>$all_class ));
        return view('master', compact('content','app_setup'));
    }
    
    
    /*
     * 
     * get_result_by_class()
     * Get Student Result By Class
     * @return get result by class
     * @author Mithun Halder
     * @date 28/01/2018
     */
    
    public function get_result_by_class(Request $request) {
        $class_id = $request->class_id;
        $exam_id = $request->exam_id;
        
        $exam = Exam::find($exam_id);        
        $class = ClassModel::find($class_id);
        
        $students = Student::all()
                             ->where('class_id',$class_id)
                            ;
        $subjects = Subject::all()
                            ->where('class_id',$class_id)
                            ;
        $html = '';
        $html .= '<div class="col-lg-12"><div class="alert alert-success"><h3>'.$exam->exam_name.'</h3><h4>'.$class->class_name.' ('.$class->class_numaric.')</h4></div></div>';
        
         $html .= '<table class="table table-bordered table-striped student_result_table">';
         $html .=   '<thead>';
         $html .= '<tr>';
         $html  .= '<th>Student Name</th>';
            foreach($subjects as $subject){
                $html .= '<th>'.$subject->subject_name.'</th>';
            }
         $html .= '<th>Status: </th>';
         $html .= '</tr>';
         $html .=  ' </thead>';
         $html .=   '<tbody>';
         if(is_object($students) && $students->count()){
             foreach ($students as $student){
                $count = 0;
                $html .= '<tr>';
                $html .= '<td>'.title_case($student->student_name).'</td>';
                foreach ($subjects as $subject){
                   $student_result = $this->get_result_by_student($exam_id, $class_id, $subject->subject_id, $student->student_id);
                   if($student_result){
                     $grade= $this->result_grade_by_mark($exam_id, $class_id, $subject->subject_id,$student_result->mark);
                     if($grade =='F'){
                         $count++;
                         $html .= '<td>'.$grade.'</td>';
                     }else{
                         $html .= '<td>'.$grade.'</td>';
                     }
                     
                   }else {
                       $html .= '<td>No Mark Entry</td>';
                   }//End If
                }//End Foreach
                if(!$student_result){
                    $html .='<td>No Mark Entry</td>';
                }

                else if($count == 0){
                   $html .='<td>Pass</td>'; 
                } 
                
                else {
                    $html .='<td>Failed In '.$count.' Subject</td>';
                }
                
                
                $html .= '</tr>';
            }//End Foreach
         }//End if
         
        
        $html .=   '</tbody>';
        $html .=  '</table>';
        
        return $html;
    }
    
    public function get_result_by_student($exam_id, $class_id, $subject_id, $student_id) {
        $mark = Result::select()
                        ->where('exam_id',$exam_id)
                        ->where('class_id',$class_id)
                        ->where('subject_id',$subject_id)
                        ->where('student_id',$student_id)
                        ->first()
                        ;
        return $mark;
    }
    
    public function  result_grade_by_mark($exam_id, $class_id, $subject_id,$mark){
        
        $grades = ResultSetting::all()
                                    ->where('exam_id',$exam_id)
                                    ->where('class_id',$class_id)
                                    ->where('subject_id',$subject_id)
                                    ;
        $grade_value = '';
        foreach ($grades as $grade ){
            if($grade->mark_less_than > $mark && $grade->mark_greater_than <$mark){
              $grade_value = $grade->grade;  
              break;
            }else {
                $grade_value = 'F';
            }
        }
        return $grade_value;
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
