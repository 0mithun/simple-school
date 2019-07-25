<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AppSetup;
class AppSetupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $app_setup = AppSetup::first();
        
       $content = view('setup.show', compact('app_setup'));
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $app_setup = AppSetup::find(1);
        return $app_setup;
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
       $app_setup = AppSetup::find(1);
       
       $request->validate([
           'app_title'                  =>  'required',
           'app_description'            =>  'required',
           'copyright_title'            =>  'required',
       ]);
       $app_setup->update($request->all());
       
       return response()->json(array('success'=>'Application Setting Update Successfully'));
    }
    
    /*
     * Update Application Logo
     * @author Mithun Halder
     * @date 29/01/2018
     */
    
    public function update_app_logo(Request $request) {
        $app_old_logo = AppSetup::find(1);
        
        $request->validate([
            'edit_logo'     =>      'mimes:png|max:1024'
        ]);
        $logo = $request->file('edit_logo');
        
        if($logo){
           $file_name = str_random(20).uniqid();
           $ext = $logo->getClientOriginalExtension();
           $full_name = $file_name.".".$ext;
           
           $path = 'public/upload/';
           $file_url = $path.$full_name;
           if($logo->move($path,$full_name)){
               if(file_exists($app_old_logo->app_logo)){
                unlink($app_old_logo->app_logo);
               }
               
               $data = [
                   'app_logo'       =>  $file_url
               ];
               $app_old_logo->update($data);
           } 
            
        }
        
        
        return response()->json(array('success'=>'Application Logo Update Successfully'));
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
