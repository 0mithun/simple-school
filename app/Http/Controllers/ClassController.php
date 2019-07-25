<?php

namespace App\Http\Controllers;

use App\ClassModel;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\AppSetup;
class ClassController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $app_setup = AppSetup::find(1);
        $content = view('class.show');
        return view('master', compact('content','app_setup'));
    }

    
    /*
     * 
     * Get All Class Information 
     * @return All Teacher Information from tbl_classes
     * @Author: Mithun Halder
     * @date: 06/01/2018 (dd/mm/yyyy)
     *
     * 
     */

    public function get_class() {
        $class = ClassModel::select('*');
                //->orderBy('class_id','desc');
        
        return DataTables::of($class)
                ->orderColumns([''], '-:column $1')
                ->addColumn('action',function($class){
            return '<div class="btn-group pull-right">
                                   <button class="btn btn-default class_edit"  onclick="edit_class('.$class->class_id.')" data-toggle="tooltip" title="Edit Class" dta-id="'.$class->class_id.'"><i class="fa fa-edit"></i></button>
                                   <button class="btn btn-danger class_delete"  onclick="delete_class('.$class->class_id.')" data-toggle="tooltip" title="Delete Class" data-id="'.$class->class_id.'"><i class="fa fa-trash"></i></button>
                              </div>';
        })->make('true');
                
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
            'class_name'    =>  'required',
            'class_numaric' =>  'required|numeric|unique:tbl_classes,class_numaric'
        ]);
        ClassModel::create($request->all());
        
       return response()->json(array('success'=>'Class Added Successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ClassModel  $classModel
     * @return \Illuminate\Http\Response
     */
    public function show(ClassModel $classModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ClassModel  $classModel
     * @return \Illuminate\Http\Response
     */
    public function edit(ClassModel $classModel, $id)
    {
        $class = ClassModel::find($id);
        return response()->json($class);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ClassModel  $classModel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ClassModel $classModel, $id)
    {
        $class = ClassModel::find($id);
        
        $request->validate([
            'edit_class_name'        =>  'required',
            'edit_class_numaric'     =>  ($class->class_numaric == $request->edit_class_numaric) ? 'required|numeric': 'required|numeric|unique:tbl_classes,class_numaric'
        ]);
        
        $data = [
          'class_name'      =>  $request->edit_class_name,
          'class_numaric'   =>  $request->edit_class_numaric
        ];
        
        $class->update($data);
        
        
       return response()->json(array('success'=>'Class Information Updated Successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ClassModel  $classModel
     * @return \Illuminate\Http\Response
     */
    public function destroy(ClassModel $classModel, $id)
    {
       $class  = $classModel::find($id);
       $classModel::destroy($id);
       return 'delete';
    }
}
