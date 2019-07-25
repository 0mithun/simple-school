<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Exam;
use App\Marks;
use App\ClassModel;
use App\Subject;
use App\ResultSetting;
use App\AppSetup;
//use App\Http\Controllers\MarkController;

class ResultSettingController extends Controller
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
       $content = view('result_setting.show',array('exam_years' => $exam_years ));
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
     * Get all class Select Dropdown
     * @return all class select dropdown 
     * @author Mithun Halder
     * @date 25/01/2018
     * 
     */
    public function get_all_class_select() {
        $classes = ClassModel::all();
         $html = '';
        if(is_object($classes) && $classes->count()){
           
             $html .= '<option value="">---- Select Class ----</optoin>';
            foreach($classes as $class){
                $html .= '<option value="'.$class->class_id.'">'.$class->class_name.'</option>';
            }//End Foreach
        }else{
             $html = 'No Class Found';
        }//End if
        
        return $html;
    }
    
    
    /*
     * Get all Subject by Class id
     * @return subject by class id
     * @author Mithun Halder
     * @date 25/01/2018
     * 
     */
    
    public function get_subject_by_class_id($class_id) {
        $subjects = Subject::all()
                             ->where('class_id',$class_id);
        
        
        $html = '';
        $html .= '<div class="form-group"><label class="col-lg-4 control-label" for="class_id">Subject Name: </label> <div class="col-lg-8">';
        if(is_object($subjects) && $subjects->count()){
            $html .= '<div class="list-group">';
        
            foreach($subjects as $subject){
                $html .= '<a href="#" class="list-group-item single_subject" data-subject-id="'.$subject->subject_id.'" >'.$subject->subject_name.'</a>';
            }
            $html .= '</div>';
        }else{
             $html .= '<div class="alert alert-warning"><h3>No Subject Found</h3></div>';
        }
        $html .= '</div></div>';
        
        return $html;
    }

    /*
     * Make result Setting Form
     * @return result setting form with exam name, class name, subject name
     * @author Mithun
     * @date 25/01/2018
     * 
     */
    public function make_result_setting_form(Request $request) {
        $mark = Marks::select('*')
                        ->where('exam_id',$request->exam_id)
                        ->where('class_id',$request->class_id)
                        ->where('subject_id',$request->subject_id)
                        ->first()
                ;
        $html = '';
        if( is_object($mark) && $mark->count()){
             $exam = Exam::find($request->exam_id);
             $class = ClassModel::find($request->class_id);
             $subject = Subject::find($request->subject_id);
             
            $html .= '<div class="col-lg-10"><div class="alert alert-success"><h4>'.$exam->exam_name.','.$class->class_name.', Subject : '.$subject->subject_name.'</h4>';
            $html .= '<h4>Total Mark:'.$mark->total_mark .' Pass Mark: '.$mark->pass_mark.'</h4></div></div>';
            
            
            
            $result_settings = ResultSetting::select('*')
                                            ->where('exam_id',$request->exam_id)
                                            ->where('class_id',$request->class_id)
                                            ->where('subject_id',$request->subject_id)
                                            ->get()
                                            ;
            if(is_object($result_settings) && $result_settings->count()){
                $html .= '<div class="col-lg-2"><button class="btn btn-danger btn-lg class_grade_reset"><span class="fa fa-refresh"></span> Reset Grade</button></div>';
            }
            
             $html .= '<table class="table table-bordered table-striped">';
             $html .=   '<thead>';
             $html .=       '<tr>';
             $html .=         '  <th class="col-lg-4">Mark Greater Than</th>';
             $html .=           '<th class="col-lg-4">Mark Less Than</th>';
             $html .=           '<th class="col-lg-2">Grade</th>';
             $html .=          ' <th class="col-lg-2">Action</th>';
             $html .=      '</tr>';
             $html .=  ' </thead>';
             $html .=   '<tbody>';
            
            if(is_object($result_settings) && $result_settings->count()){
                foreach ($result_settings as $result_setting){
                    $html .=       '<tr>';
                    $html .=           '<td>';
                    $html .=               '<input type="hidden" class="result_setting_id" name="result_setting_id" value="'.$result_setting->result_setting_id.'" />';
                    $html .=               '<input type="hidden" class="exam_id" name="exam_id" value="'.$request->exam_id.'" />';
                    $html .=               '<input type="hidden" class="class_id" name="class_id" value="'.$request->class_id.'" />';
                    $html .=               '<input type="hidden" class="subject_id" name="subject_id" value="'.$request->subject_id.'" />';
                    $html .=               '<input type="text" class="mark_greater_than form-control" name="mark_greater_than" value="'.$result_setting->mark_greater_than.'" disabled /></td>';
                    $html .=           '<td><input type="text" class="mark_less_than form-control" name="mark_less_than" value="'.$result_setting->mark_less_than.'" disabled /></td>';
                    $html .=           '<td><input type="text" class="grade form-control" name="grade" value="'.$result_setting->grade.'" autofocus /></td>';
                    $html .=           '<td><button type="button" class="btn btn-primary result_grade_save">Save</button></td>';
                    $html .=       '</tr>';
                }
            }else{
               $html .= '<tr class="no_grade"><td colspan="4"><h4 class="text-warning">No Grade Found</h4></td></tr>'; 
            }
            
             $html .=   '</tbody>';
             $html .=  '</table>';
             $html .= '<div class="col-lg-2 pull-right"><br><button class="btn btn-default pull-right add_new_grade"><span class="fa fa-plus"></span> Add New Grade</button></div>';
        }else{
            $html .= '<div class="col-lg-10"><div class="alert alert-warning">Exam Mark Not Setting <a href="'.url('mark').'">please setting mark</a><h4></div>';
        }
        
        return $html;
        
    }
    
    
    /*
     * reset_result_setting()
     * @return delete all result setting by exam_id, class_id, subject_id 
     * @author Mithun Halder
     * @date: 26/01/2018
     */
    
    public function reset_result_setting(Request $request) {
         $result_settings = ResultSetting::select('*')
                                            ->where('exam_id',$request->exam_id)
                                            ->where('class_id',$request->class_id)
                                            ->where('subject_id',$request->subject_id)
                                            ->get()
                                            ;
        foreach($result_settings as $result_setting){
          ResultSetting::destroy($result_setting->result_setting_id);  
        }
                                            
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
        $mark = Marks::select('*')
                        ->where('exam_id',$request->exam_id)
                        ->where('class_id',$request->class_id)
                        ->where('subject_id',$request->subject_id)
                        ->first()
                ;
        $mark_greater_than = $mark->total_mark +1;
        $mark_less_than = $mark->pass_mark -1;
        $mark_less = $mark->pass_mark+1;
        
        $result_settings = ResultSetting::select('*')
                                            ->where('exam_id',$request->exam_id)
                                            ->where('class_id',$request->class_id)
                                            ->where('subject_id',$request->subject_id)
                                            ->get()
                                            ;
        if(is_object($result_settings) && $result_settings->count()){
            $max = $result_settings->min('mark_greater_than') +1;
            $min = $result_settings->max('mark_less_than') -1;
            
            $result_setting = ResultSetting::find($request->result_setting_id);
            
            if($result_setting){
                $data = [
                    'grade'     =>  $request->grade
                ];
                $result_setting->update($data);
            }
            
            else{
                $request->validate([
                    'mark_greater_than'      =>  'required|numeric|min:'.$mark_less_than.'|max:'.$max,
                    'mark_less_than'         =>  'required|numeric|max:'.$max.'|min:'.$mark_less,
                    'grade'                  =>  'required',
                ]);

                $data = [
                    'exam_id'                =>  $request->exam_id,
                    'class_id'               =>  $request->class_id,
                    'subject_id'             =>  $request->subject_id,
                    'mark_greater_than'      =>  $request->mark_greater_than,
                    'mark_less_than'         =>  $request->mark_less_than,
                    'grade'                  =>  $request->grade,
                ];
                ResultSetting::create($data);
            }//End if
        }
        else{
            $request->validate([
                'mark_greater_than'      =>  'required|numeric|max:'.$mark_greater_than.'|min:'.$mark_less_than,
                'mark_less_than'         =>  'required|numeric|min:'.$mark_less_than.'|max:'.$mark_greater_than,
                'grade'                  =>  'required',
            ]);
            
            $data = [
                'exam_id'                =>  $request->exam_id,
                'class_id'               =>  $request->class_id,
                'subject_id'             =>  $request->subject_id,
                'mark_greater_than'      =>  $request->mark_greater_than,
                'mark_less_than'         =>  $request->mark_less_than,
                'grade'                  =>  $request->grade,
            ];
            ResultSetting::create($data);
        }//End if
        return 'Success';
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
