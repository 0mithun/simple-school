<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AppSetup;
use App\Event;
use App\Teacher;
use App\Student;
use App\ClassModel;
use App\Section;
class DashboardController extends Controller
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
    {
       $total_teacher = Teacher::all()->count();
       $total_student = Student::all()->count();
       $total_class = ClassModel::all()->count();
       $total_section = Teacher::all()->count();
        
        
       $app_setup = AppSetup::find(1);
       $content = view('dashboard.show', compact('total_teacher','total_student','total_class','total_section'));
       return view('master', compact('content','app_setup'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    { //
    }
    
    /*
     * Get All Events
     * @return all events
     * @author Mithun Halder
     * @date 29/01/2018
     * 
     */
    
    public function get_all_events() {
        $events = Event::all();
        
        return response()->json($events);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Event::create($request->all());
        
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
        $event = Event::find($id);
        
        $event->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      Event::destroy($id);
      
    }
}
