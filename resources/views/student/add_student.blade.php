<!------------------- Add Teacher Modal  ----------------------------------->

<div class="modal" id="add_student_modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <span class="close" data-dismiss="modal">&times;</span>
                <h3 class="modal-title">Add New Student</h3>
            </div>
            <div class="modal-body">
                <form id="add_student_form" method="post" action="{{route('student.store')}}" class="form-horizontal" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="control-label col-lg-4" for="student_name">Student Name</label> 
                            <div class="col-lg-8">
                                <input type="text"  class=" form-control" autofocus value="" name="student_name" id="student_name"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-4" for="date_of_birth">Date Of Birth</label> 
                            <div class="col-lg-8">
                                <div class="input-group date">
                                    <input type="text" name="date_of_birth" id="date_of_birth" class="form-control datepicker" ">
                                    <div class="input-group-addon">
                                        <span class="glyphicon glyphicon-th"></span>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-lg-4" for="age">Age</label> 
                            <div class="col-lg-8">
                                <input type="number"  class="form-control" value="" name="age" id="age"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-4" for="email">Email</label> 
                            <div class="col-lg-8">
                                <input type="text"  class="form-control" value="" name="email" id="email"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-4" for="contact">Contact</label> 
                            <div class="col-lg-8">
                                <input type="text"  class="form-control" value="" name="contact" id="contact"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-4" for="address">Address</label> 
                            <div class="col-lg-8">
                                <textarea class="form-control" cols="" rows="3" id="address" name="address"  ></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-4" for="city">City</label> 
                            <div class="col-lg-8">
                                <input type="text"  class="form-control" value="" name="city" id="city"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-4" for="country">Country</label> 
                            <div class="col-lg-8">
                                <select name="country" class="form-control" id="country">
                                    <option value="">---- Select Country ----</option>
                                </select>
                            </div>
                        </div>
                         <div class="form-group">
                            <label class="control-label col-lg-4" for="date_of_register">Register Date</label> 
                            <div class="col-lg-8">
                                <div class="input-group date">
                                    <input type="text" name="date_of_register" id="date_of_register" class="form-control datepicker" ">
                                    <div class="input-group-addon">
                                        <span class="glyphicon glyphicon-th"></span>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">

                        <div class="form-group">
                            <label class="control-label col-lg-4" for="class_id">Class</label> 
                            <div class="col-lg-8">
                                <select name="class_id" class="form-control" id="class_id">
                                    <option value="" id="no_class">---- Select Class ----</option>
                                    @foreach($all_class as $class)
                                    <option value="{{$class->class_id}}">{{$class->class_name}} ({{$class->class_numaric}})</option>
                                    @endforeach
                                    
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-4" for="section_id">Section</label> 
                            <div class="col-lg-8">
                                <select  disabled="" name="section_id" class="form-control" id="section_id">
                                    <option value=""> ---- Please Select Class ----</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-lg-4" for="student_photo">Photo</label> 
                            <div class="col-lg-8">
                                <input type="file" id="student_photo" name="student_photo" class=""  data-preview-file-type="text" />
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-8 col-lg-offset-4">

                                <button type="submit" class="btn btn-primary">Add Student</button>
                            </div>
                        </div>
                    </div>


                </form>


            </div>
            <div class="modal-footer">

                <button class="btn btn-danger " data-dismiss="modal" type="button" >Close</button>
            </div>
        </div>
    </div>
</div>
<!-----------------------End Add Teacher Modal--------------------------------------->
