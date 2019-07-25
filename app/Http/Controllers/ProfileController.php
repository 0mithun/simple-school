<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;
class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   
    public function change_password(Request $request) {
     
        $request->validate([
            'old_password'      =>  'required',
            'new_password'      =>  'required',
            'confirm_password'  =>  'required'
        ]);
        
        
        return response()->json(array('success'=>'Password Updated Successfully'));   
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
        $user = User::find($id);
        return response()->json($user);
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
        $user = User::find($id);
        //$data = array('user_photo' => '');
        if($request->form_type =='change_password'){
            $password = $user->password;
//            $old_password = 'old_password';
            
            if(Hash::check($request->old_password,$password)){
                $old_password_validate = 'required';
            }else{
                $old_password_validate = 'required|exists:users,password';
            }
             $request->validate([
                'old_password'      =>  $old_password_validate,
                'new_password'      =>  'required|min:6',
                'confirm_password'  =>  'required|same:new_password'
            ]);
             
            $data = [
                'password'          => Hash::make($request->confirm_password)
            ]; 
             $user->update($data);
             return response()->json(array('success'=>'Profile Updated Successfully'));
        }else if($request->form_type == 'change_personal_information'){
            $request->validate([
                'user_name'               =>  'required',
                'user_email'              =>  ($user->email == $request->user_email)? 'required|email': 'required|email|unique:users,email',
                'user_date_of_birth'      =>  'required',
                'sex'                =>  'required'
            ]);

            $data = [
                'name'              => $request->user_name,
                'email'             => $request->user_email,
                'date_of_birth' =>  date('Y-m-d', strtotime($request->user_date_of_birth)),
                'sex'               => $request->sex,
            ];
            $date = date('Y-d-m', strtotime($request->date_of_birth));
            $user->update($data);
            return response()->json(array('success'=>'Profile Updated Successfully'));
        }else if($request->form_type == 'user_photo'){
            $request->validate([
                'userphoto'        =>  'required'
            ]);
            
            
            
            $user_photo = $request->file('userphoto');
            if($user_photo){
                $file_name = str_random(20). uniqid();
                $ext = strtolower($user_photo->getClientOriginalExtension());
                $full_name = $file_name.'.'.$ext;

                $path = 'public/upload/';
                $url =  $path.$full_name;
                if($user_photo->move($path,$full_name)){
                    $data['user_photo'] = $url;
                    $user->update($data);
                   return response()->json(array('success'=>'Profile Updated Successfully','userphoto' => $data['user_photo']));
                }
            }
        }
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
