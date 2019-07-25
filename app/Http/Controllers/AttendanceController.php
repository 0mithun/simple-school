<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Teacher;
use App\Student;
use App\Attendance;
use App\ClassModel;
use App\Section;
use App\AppSetup;
class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $app_setup = AppSetup::find(1);
        $content = view('attendance.show');
        
        return view('master', compact('content','app_setup'));
    }

    /*
     * get_class_select($type)
     * make Class Select input
     * @param int $type
     * @return completed select input
     * @author Mithun
     * @date 18/01/2018
     * 
     */
    public function get_class_select($type) {
        $classes = ClassModel::all();
        $date_name = '';
        if($type ==1){
            $date_name = 'date';
        }else if($type ==2){
            $date_name = 'report_date';
        }
        $html = ' <div class="form-group">';
        $html .=        '<label for="date" class="control-label">Date</label>';
        $html .=       '<input name="'.$date_name.'" id="'.$date_name.'" type="text" class="datepicker form-control" />';
        $html .=   '</div>';
        

        $html .=   '<div class="form-group">';
        $html .=       '<label class="control-label" for="class_id">Class</label>';
        $html .=         ' <select class="form-control" id="class_id" name="class_id">';
        $html .=              ' <option value="">-- Please Select Class --</option>';
        foreach ($classes as $class){
             $html .=               '<option value="'.$class->class_id.'">'.$class->class_name.'</option>';
        }
        $html .=         ' </select>';
        $html .=   '</div>';
        $html .=   '<div class="form-group">';
        $html .=       ' <label class="control-label " for="section_id">Section</label>';
        $html .=         '  <select class="form-control" id="section_id" name="section_id" disabled>';
        
        $html .=          ' </select>';
        $html .=   ' </div>';
        $html .=   ' <div class="form-group">';
        $html .=       '<div class=" "><input type="submit" value="Submit" class="btn btn-primary" /></div>';
        $html .=   '</div>';
        
       return $html;
    }
    
    
    /*
     * get_section_by_class($id)
     * @param int $id
     * @return section by class_id
     * @author Mithun Halder
     * @date 17/01/2018
     */
    
    public function get_section_by_class($class_id) {
        $sections = Section::all()
                            ->where('class_id', $class_id);
        $data = array('valid'=>FALSE,'html'=>'');
        
        if($sections->count() > 0){
            $data['valid'] =TRUE;
            
            $data['html'] .='<option value="" selected>---- Please Select Section ----</option>';
            
            foreach ($sections as $section){
                $data['html'] .= '<option value="'.$section->section_id.'">'.$section->section_name.'</option>';
            } 
        }else{
            $data['html']= '<option value="">-- No Section Found --</option>';
        }
        return response()->json($data);
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
        $response = array('valid'=>false);
        
        if($request->attendance_status !=null){
            
           if($request->attendance_type ==1){
                $exists = $this->get_attendance_by_date($request->student_id,date('Y-m-d', strtotime($request->attendance_date)),$request->attendance_type);
                if($exists){
                    $data = [
                       'attendance_status'     =>  $request->attendance_status 
                    ];
                   $exists->update($data);
                }else{
                    $data= [
                    'attendance_type'       =>  $request->attendance_type,
                    'attendance_date'       =>  date('Y-m-d', strtotime($request->attendance_date)),
                    'student_id'            =>  $request->student_id,
                    'class_id'              =>  $request->class_id,
                    'section_id'            =>  $request->section_id,
                    'attendance_status'     =>  $request->attendance_status,
                ];
                    
                 Attendance::create($data);
                }
            }else if($request->attendance_type ==2){
                $exists = $this->get_attendance_by_date($request->teacher_id,date('Y-m-d', strtotime($request->attendance_date)),$request->attendance_type);
                if($exists){
                    $data = [
                       'attendance_status'     =>  $request->attendance_status 
                    ];
                   $exists->update($data);
                }else{
                    $data= [
                    'attendance_type'       =>  $request->attendance_type,
                    'teacher_id'            =>  $request->teacher_id,
                    'attendance_date'       =>  date('Y-m-d', strtotime($request->attendance_date)),
                    'attendance_status'     =>  $request->attendance_status,
                ];
                    
                 Attendance::create($data);
                }
                
            } 
            $response['valid'] = true;
            return response()->json( $response);
        }else{
           return response()->json($response);
        }
    }
    
    /*
     * get_attendance_by_date get Attendance by Date
     * @param string $date ing id
     * @return single attendance list
     */
    public function  get_attendance_by_date($id, $date,$type){
        if($type ==1){
             $attendance = Attendance::select('*')
                                    ->where('attendance_date',$date)
                                    ->where('student_id',$id)
                                   ->first();
             return $attendance;
        }else if($type ==2){
            $attendance = Attendance::select('*')
                                    ->where('attendance_date',$date)
                                    ->where('teacher_id',$id)
                                   ->first();
            return $attendance;
        }
        
    }
    
    /*
     * get_teacher_attendance_status_by_id()
     * @param string $date, int $id
     * @return teacher attendance status
     * @author Mithun Halder
     * @date 17/01/2018
     */
    
    public function get_teacher_attendance_status_by_id($date, $id) {
        $attendance = Attendance::select('*')
                                    ->where('attendance_date',date('Y-m-d', strtotime($date)))
                                    ->where('teacher_id',$id)
                                   ->first();
        return $attendance;
    }
    
    /*
     * 
     * get_student_attendance_status_by_id($date, $student_id)
     * @param string $date, int $student_id
     * @return student attendance status
     * @author Mithun Halder
     * @date 17/01/2018
     * 
     */
    public function get_student_attendance_status_by_id($date, $student_id) {
         $attendance = Attendance::select('*')
                                    ->where('attendance_date',date('Y-m-d', strtotime($date)))
                                    ->where('student_id',$student_id)
                                   ->first();
        return $attendance;
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
    
    /*
     * 
     * load_student_attendance
     * @return student attendance data
     * @author Mithun Halder
     * @date 17/01/2018
     */
    
    public function load_student_attendance(Request $request) {
         $students = Student::all()
                            ->where('class_id',$request->class_id)
                            ->where('section_id',$request->section_id);
        $output = '';
        $date = $request->date;
        if($students->count() >0){
            $section = Section::select('sections.*','tbl_classes.class_name')
                                       ->join('tbl_classes','sections.class_id','=','tbl_classes.class_id')
                                       ->where('section_id',$request->section_id)
                                       ->first();
            
            $output .= '<div class="alert alert-success"><h3>Students Attendance: </h3>';
            $output .= '<h4><span>Class: '.$section->class_name.',</span> <span> '.$section->section_name.'</span></h4></div>';
            
            
            $output .= ' <table id="attendance_table" class="table table-bordered">';
            $output .=  '<thead><tr>';
            $output .=  '<th class="col-lg-8">Student Name</th><th class="col-lg-2">Action</th><th class="col-lg-2">Take Action</th>';
            $output .=  '</tr></thead>';
                                   
            $output .=  '<tbody id="">';
            
            foreach($students as $student){
                $status = $this->get_student_attendance_status_by_id($date, $student->student_id);
               
                $output .= '<tr><td colspan="3">';
                $output .= '<form action="" method="" class="single_attendance_form"><table class="table inner_table" >';
                
                    $output .=  '<tr><td class="col-lg-8 name">'.$student->student_name.'</td><td class="col-lg-2">';
                    $output .= '<input type="hidden" name="attendance_type" class="attendance_type" value="'.$request->attendance_type.'" />';
                    $output .= '<input type="hidden" name="class_id" class="class_id" value="'.$request->class_id.'" />';
                    $output .= '<input type="hidden" name="section_id" class="section_id" value="'.$request->section_id.'" />';
                    $output .= '<input type="hidden" name="student_id" class="student_id" value="'.$student->student_id.'" /><input type="hidden" class="attendance_date" name="attendance_date" value="'.$date.'" />';
                    $output .=  '<select  class="form-control attendance_status" name=" attendance_status" >';
                    $output .= '<option value="">Please Select</option>';
                    if($status){
                        $one = ($status->attendance_status == 1)? "selected" : "";
                        $two = ($status->attendance_status == 2)? "selected" : "";
                        $three = ($status->attendance_status == 3)? "selected" : "";
                        $output .= '<option value="1" '.$one.'>Present</option>';
                        $output .= '<option value="2" '.$two.'>Absent</option>';
                        $output .= '<option value="3" '.$three.'>Late</option></select>';
                    }else{
                        $output .= '<option value="1">Present</option>';
                        $output .= '<option value="2">Absent</option>';
                        $output .= '<option value="3">Late</option></select>';
                    }
                    
                    $output .= '</td><td class="col-lg-2"><button data-action-type="1" type="submit" class="btn btn-default single_student_attendance_submit">Save</button></td></tr>';

                $output .= '</table></form>';
                $output .= '</td></tr>';
            }
            $output .=  '</tbody></table>';
            echo $output;
        }else{
            echo '<div class="alert alert-warning"><h3>No Students Found </h3></div>';
        }
    }
    
     /*
     * 
     * load_teacher_attendance
     * @return teacher attendance data
     * @author Mithun Halder
     * @date 17/01/2018
     */
    
    
    public function load_teacher_attendance($date) {
        $teachers = Teacher::all();
        $output = '';
        if($teachers->count() >0){
            $output .= '<div class="alert alert-success"><h3>Teacher Attendance </h3></div>';
            $output  .= ' <table id="attendance_table" class="table table-bordered">';
            $output .=  '<thead><tr>';
            $output .=  '<th class="col-lg-8">Teacher Name</th><th class="col-lg-2">Action</th><th class="col-lg-2">Take Action</th>';
            $output .=  '</tr></thead>';
                                   
            $output .=  '<tbody id="">';
            
            foreach($teachers as $teacher){
                $status = $this->get_teacher_attendance_status_by_id($date, $teacher->teacher_id);
                
                $output .= '<tr><td colspan="3">';
                
                $output .= '<form action="" method="" class="single_attendance_form"><table class="table inner_table" >';
                
                    $output .=  '<tr><td class="col-lg-8 name">'.$teacher->name.'</td><td class="col-lg-2">';
                    $output .= '<input type="hidden" name="teacher_id" class="teacher_id" value="'.$teacher->teacher_id.'" /><input type="hidden" class="attendance_date" name="attendance_date" value="'.$date.'" />';
                    $output .=  '<select  class="form-control attendance_status" name="attendance_status" >';
                    $output .= '<option value="">Please Select</option>';
                    if($status){
                        $one = ($status->attendance_status == 1)? "selected" : "";
                        $two = ($status->attendance_status == 2)? "selected" : "";
                        $three = ($status->attendance_status == 3)? "selected" : "";
                        $output .= '<option value="1" '.$one.'>Present</option>';
                        $output .= '<option value="2" '.$two.'>Absent</option>';
                        $output .= '<option value="3" '.$three.'>Late</option></select>';
                    }else{
                        $output .= '<option value="1">Present</option>';
                        $output .= '<option value="2">Absent</option>';
                        $output .= '<option value="3">Late</option></select>';
                    }
                    
                    $output .= '</td><td class="col-lg-2"><button data-action-type="1" type="submit" class="btn btn-default single_teacher_attendance_submit">Save</button></td></tr>';

                $output .= '</table></form>';
                $output .= '</td></tr>';
            }
            $output .=  '</tbody></table>';
            echo $output;
        }else{
            echo  $output .= '<div class="alert alert-warning"><h3>No Teacher Found</h3></div>';
        }
    }
    
    
    /*
     * Get Attendance report by month and year
     * get_attendance_report()
     * @return attendance report 
     * @author Mithun
     * @date 17/01/2018
     * 
     */
    public function get_attendance_report(Request $request) {
        if($request->attendance_report_type ==1){
            $month_year = $request->report_date;
            $class_id = $request->class_id;
            $section_id = $request->section_id;
            
            $reports = $this->make_students_attendance_report($month_year, $class_id, $section_id);
           return $reports;
        }else if($request->attendance_report_type ==2){
         $reports =   $this->make_teacher_attendance_report($request->report_month_year);
         return $reports;
        }
    }
    
    /*
     * make_teacher_students_report($month_year, $class_id, $section_id)
     * Make Students Attendance Report by month class & section
     * @param string $month_year, int $class_id, int $section_id
     * @return completed Student Attendance Report
     * @author Mithun Halder
     * @date 18/01/2018
     */
    
    public function make_students_attendance_report($month_year, $class_id, $section_id) {
        $month = (int) substr($month_year, 0,2);
        $year = (int) substr($month_year, 3);
        
        $students = Student::all()
                            ->where('class_id',$class_id)
                            ->where('section_id',$section_id);
        $html = '';
        if( $students ->count() >0){
            
            $section = Section::select('sections.*','tbl_classes.class_name')
                                       ->join('tbl_classes','sections.class_id','=','tbl_classes.class_id')
                                       ->where('section_id',$section_id)
                                       ->first();
            
            $month_name = date("F", strtotime("2001-" . $month . "-01"));
            $html .= '<div class="alert alert-success"><h3>Students Attendance Report: '.$month_name.' '.$year. '</h3>';
            $html .= '<h4><span>Class: '.$section->class_name.',</span> <span> '.$section->section_name.'</span></h4></div>';

            $html .= '<table class="table table-bordered table-responsive">';
            $html .= '<thead>';

            $total_days = cal_days_in_month(CAL_EASTER_DEFAULT, $month, $year);

             $html .= '<tr><td>Name</td>';
                for($i=1; $i<=$total_days;$i++ ){
                    if($i<10){
                        $html .= '<td>'.'0'.$i.'</td>';
                    }else{
                        $html .= '<td>'.$i.'</td>';
                    }
                }
                $html .='</tr>';
            foreach ($students as $student){
                $html .= '<tr><td>'.$student->student_name.'</td>';
                for($i=1;$i<=$total_days;$i++){
                    $student_attendance = Attendance::select('*')
                                        ->where('student_id',$student->student_id)
                                        ->whereDay('attendance_date',$i)
                                        ->whereMonth('attendance_date',$month)
                                        ->whereYear('attendance_date',$year)   
                                        ->first()
                                        ;

                    if($student_attendance){
                       if($student_attendance->attendance_status ==1)$html .= '<td><span class="label label-success" data-toggle="tooltip" title="Present">P</span></td>';
                       if($student_attendance->attendance_status ==2)$html .= '<td><span class="label label-danger" data-toggle="tooltip" title="Absent">A</span></td>';
                       if($student_attendance->attendance_status ==3)$html .= '<td><span class="label label-warning" data-toggle="tooltip" title="Late">L</span></td>';
                    }else{
                        $html .= '<td></td>';
                    }
                } 
                $html .= '</tr>';
            }
            $html .= '</thead></table>';
        
        }
        else{
            $html .= '<div class="alert alert-warning"><h3>No Student Found<h3></div>';
        }
        return $html;
    }
    
    
    
    
    /*
     * make_teacher_attendance_report($month_year)
     * Make Teacher Attendance Report by month
     * @param string $month_year
     * @return completed teacher attendance report
     * @author Mithun
     * @date 18/01/2018
     * 
     */
    
    public function make_teacher_attendance_report($month_year) {
        $month = substr($month_year, 0,2);
        $year = substr($month_year, 3);

        $teachers = Teacher::all();
        if( $teachers ->count() >0){

            $html = '';
            $month_name = date("F", strtotime("2001-" . $month . "-01"));
            $html .= '<div class="alert alert-success"><h3>Teacher Attendance Report: '.$month_name.' '.$year. '<h3></div>';

            $html .= '<table class="table table-bordered table-responsive">';
            $html .= '<thead>';

            $total_days = cal_days_in_month(CAL_EASTER_DEFAULT, $month, $year);

             $html .= '<tr><td>Name</td>';
                for($i=1; $i<=$total_days;$i++ ){
                    if($i<10){
                        $html .= '<td>'.'0'.$i.'</td>';
                    }else{
                        $html .= '<td>'.$i.'</td>';
                    }
                }
                $html .='</tr>';
            foreach ($teachers as $teacher){
                $html .= '<tr><td>'.$teacher->name.'</td>';
                for($i=1;$i<=$total_days;$i++){
                    $teachers_attendance = Attendance::select('*')
                                        ->where('teacher_id',$teacher->teacher_id)
                                        ->whereDay('attendance_date',$i)
                                        ->whereMonth('attendance_date',$month)
                                        ->whereYear('attendance_date',$year)   
                                        ->first()
                                        ;

                    if($teachers_attendance){
                       if($teachers_attendance->attendance_status ==1)$html .= '<td><span class="label label-success" data-toggle="tooltip" title="Present">P</span></td>';
                       if($teachers_attendance->attendance_status ==2)$html .= '<td><span class="label label-danger" data-toggle="tooltip" title="Absent">A</span></td>';
                       if($teachers_attendance->attendance_status ==3)$html .= '<td><span class="label label-warning" data-toggle="tooltip" title="Late">L</span></td>';

                      //$html .= 'Teacher_id: '.$teacher->teacher_id.' '. $teachers_attendance->attendance_id;  
                    }else{
                        $html .= '<td></td>';
                    }
                } 
                $html .= '</tr>';
            }
            $html .= '</thead></table>';
        }
        else{
            $html .= '<div class="alert alert-warning"><h3>No Teacher Found<h3></div>';
        }
        return $html;
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
