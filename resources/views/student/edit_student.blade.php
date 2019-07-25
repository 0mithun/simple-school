<!------------------------------Edit Teacher Modal----------------------------------->                      
<div class="modal" id="edit_student_modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <span class="close" data-dismiss="modal">&times;</span>
                <h3 class="modal-title">Edit Teacher Information</h3>
            </div>
            <div class="modal-body">
                <form id="edit_student_form" method="post" action="" class="form-horizontal" enctype="multipart/form-data">
                    {{csrf_field()}}
                    {{ method_field('PATCH') }}
                    <input type="hidden"   name="student_id" id="student_id"/>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="control-label col-lg-4" for="edit_student_name">Teacher Name</label> 
                            <div class="col-lg-8">
                                <input type="text"  class=" form-control" autofocus value="" name="edit_student_name" id="edit_student_name"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-4" for="edit_date_of_birth">Date Of Birth</label> 
                            <div class="col-lg-8">
                                <div class="input-group date">
                                    <input type="text" name="edit_date_of_birth" id="edit_date_of_birth" class="form-control datepicker" ">
                                    <div class="input-group-addon">
                                        <span class="glyphicon glyphicon-th"></span>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-4" for="edit_email">Email</label> 
                            <div class="col-lg-8">
                                <input type="text"  class="form-control" value="" name="edit_email" id="edit_email"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-4" for="edit_age">Age</label> 
                            <div class="col-lg-8">
                                <input type="number"  class="form-control" value="" name="edit_age" id="edit_age"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-4" for="edit_contact">Contact</label> 
                            <div class="col-lg-8">
                                <input type="text"  class="form-control" value="" name="edit_contact" id="edit_contact"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-4" for="edit_address">Address</label> 
                            <div class="col-lg-8">
                                <textarea class="form-control" cols="" rows="3" id="edit_address" name="edit_address"  ></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-4" for="edit_city">City</label> 
                            <div class="col-lg-8">
                                <input type="text"  class="form-control" value="" name="edit_city" id="edit_city"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-4" for="edit_country">Country</label> 
                            <div class="col-lg-8">
                                <select name="edit_country" class="form-control" id="edit_country">
                                    <option value="">---- Select Country ----</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-4" for="edit_date_of_register">Register Date</label> 
                            <div class="col-lg-8">
                                <div class="input-group date">
                                    <input type="text" name="edit_date_of_register" id="edit_date_of_register" class="form-control datepicker" ">
                                    <div class="input-group-addon">
                                        <span class="glyphicon glyphicon-th"></span>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="control-label col-lg-4" for="edit_class_id">Class</label> 
                            <div class="col-lg-8">
                                <select name="edit_class_id" class="form-control" id="edit_class_id">
                                    @foreach($all_class as $class)
                                    <option value="{{$class->class_id}}">{{$class->class_name}} ({{$class->class_numaric}})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-4" for="edit_section_id">Section</label> 
                            <div class="col-lg-8">
                                <select name="edit_section_id" class="form-control" id="edit_section_id">
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-4">Old Image</label>
                            <div class="edit_photo_thumb col-lg-8">
                                <img class="img-thumbnail" id="old_student_photo" src="{{asset('upload')}}/CRVKw3kxa0E3Yo9y7FVT5a45318202cf2.jpg" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-4" for="edit_student_photo">Photo</label> 
                            <div class="col-lg-8">
                                <input type="file" id="edit_student_photo" name="edit_student_photo" class=""  data-preview-file-type="text" />
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-8 col-lg-offset-4">
                                <button type="submit" class="btn btn-primary">Update Student</button>
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


<!------------------------End Edit Teacher Modal---------------------------------->