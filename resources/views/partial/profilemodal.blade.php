<div class="modal fade in" id="profile_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <span class="close" data-dismiss="modal" >&times;</span>
                <h3 class="modal-title">Change User Information</h3>
            </div>
            <div class="modal-body">

                <div class="" role="tabpanel" data-example-id="togglable-tabs">
                    <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#personal_info" class="" role="tab" data-toggle="tab" aria-expanded="true">Personal Information</a>
                        </li>

                        <li role="presentation" ><a href="#user_photo" class="" role="tab" data-toggle="tab" aria-expanded="false">Photo</a>
                        </li>
                        <li role="presentation" ><a href="#user_password" role="tab" class="" data-toggle="tab" aria-expanded="false">Password</a>
                        </li>
                    </ul>
                    <div id="myTabContent" class="tab-content ">
                        <div role="tabpanel" class="tab-pane fade active in" id="personal_info" aria-labelledby="home-tab">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <form id="profile_form" data-parsley-validate="" class="form-horizontal form-label-left">
                                        {{ csrf_field() }} 
                                        {{ method_field('PUT') }}
                                        <input name="user_id" type="hidden" value="{{Auth::user()->id}}" />
                                        
                                        <input name="form_type" type="hidden" value="change_personal_information" />
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="user_name">Name: <span class="required">*</span>
                                            </label>
                                            <div class="col-md-9 col-sm-9 col-xs-12">
                                                <input type="text" id="user_name" name="user_name" value="{{Auth::user()->name}}"  class="form-control col-md-7 col-xs-12">
                                            </div>
                                        </div>
                                        <br>
                                        <div class="form-group">
                                            <label for="user_email" class="control-label col-md-3 col-sm-3 col-xs-12">Email: <span class="required">*</span></label>
                                            <div class="col-md-9 col-sm-9 col-xs-12">
                                                <input id="user_email" name="user_email" class="form-control col-md-7 col-xs-12" value="{{Auth::user()->email}}" type="text">
                                            </div>
                                        </div>
                                        <br>
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Gender: <span class="required">*</span></label>
                                            <div class="col-md-9 col-sm-9 col-xs-12">
                                                <div id="gender" class="btn-group" data-toggle="buttons">
                                                    <?php 
                                                        $sex = Auth::user()->sex;
                                                        
                                                        
                                                    ?>
                                                    @if($sex ==1)
                                                    <label class="btn btn-default active" >
                                                            <input type="radio" name="sex" class="form-control" checked="checked" value="1" data-parsley-multiple="gender"> &nbsp; Male &nbsp;
                                                    </label>
                                                    @else
                                                    <label class="btn btn-default" >
                                                            <input type="radio" name="sex" class="form-control" value="1" data-parsley-multiple="gender"> &nbsp; Male &nbsp;
                                                    </label>
                                                    @endif
                                                    
                                                    @if($sex ==2)
                                                    <label class="btn btn-default active" >
                                                            <input type="radio" name="sex" class="form-control" checked="checked" value="2" data-parsley-multiple="gender"> &nbsp; Female &nbsp;
                                                    </label>
                                                    @else
                                                    <label class="btn btn-default" >
                                                            <input type="radio" name="sex" class="form-control" value="2" data-parsley-multiple="gender"> &nbsp; Female &nbsp;
                                                    </label>
                                                    @endif
                                                    
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="user_date_of_birth">Date Of Birth <span class="">*</span>
                                            </label>
                                            <div class="col-md-9 col-sm-9 col-xs-12">
                                                <input id="user_date_of_birth" name="user_date_of_birth" value="{{date('d-m-Y', strtotime( Auth::user()->date_of_birth))}}" class="form-control col-md-7 col-xs-12"  type="text">
                                            </div>
                                        </div>
                                        <div class="ln_solid"></div>
                                        <div class="form-group">
                                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                                <button type="submit" class="btn btn-success">Submit</button>
                                                <button type="button" data-dismiss="modal" class=" btn btn-danger">Cancel</button>
                                            </div>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="user_photo" aria-labelledby="home-tab">
                            <div class="panel">
                                <div class="panel-body">
                                    <div class="col-lg-6">
                                        <img class="img-thumbnail" id="old_user_photo" src="{{asset(Auth::user()->user_photo)}}" />
                                    </div>
                                    <div class="col-lg-6">
                                        <form method="post" action="" enctype="multipart/form-data" id="user_photo_form" class="form-horizontal form-label-left">
                                            
                                            {{csrf_field()}}
                                            {{method_field('PUT')}}
                                            <input name="user_id" type="hidden" value="{{Auth::user()->id}}" />
                                            <input name="form_type" value="user_photo" type="hidden"  />
                                            <div class="form-group">
                                                <label class="control-label" for="userphoto">Photo</label> 
                                                
                                                    <input type="file" id="userphoto" name="userphoto"  data-preview-file-type="text" />
                                                
                                            </div>
                                            <div class="form-group">
                                                <div class="col-lg-12">
                                                    <input type="submit" class="btn btn-success" />
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div role="tabpanel" class="tab-pane fade" id="user_password" aria-labelledby="home-tab">
                            <div class="panel">
                                <div class="panel-body">
                                    <form action="" method="" id="user_password_form" class="form-horizontal form-label-left">
                                        {{ csrf_field() }}
                                            {{ method_field('PUT') }}
                                        <input name="user_id" type="hidden" value="{{Auth::user()->id}}" />
                                        <input name="form_type" type="hidden" value="change_password" />
                                        <div class="form-group">
                                            <label class="control-label col-lg-3" for="old_password">Old Password</label>
                                            <div class="col-lg-9">
                                                <input type="password" name="old_password" class="form-control" id="old_password" />
                                            </div>
                                        </div>
                                        <br>
                                        <div class="form-group">
                                            <label for="new_password" class="control-label col-lg-3">New Password</label>
                                            <div class="col-lg-9">
                                                <input type="password" id="new_password" name="new_password" class="form-control" />
                                            </div>
                                        </div>
                                        <br>
                                        <div class="form-group">
                                            <label for="confirm_password" class="control-label col-lg-3">Confirm Password</label>
                                            <div class="col-lg-9">
                                                <input name="confirm_password" id="confirm_password" type="password" class="form-control" />
                                            </div>
                                        </div>
                                        <div class="ln_solid"></div>
                                        <div class="form-group">
                                            <div class="col-lg-9 col-md-offset-3">
                                                <button type="submit" class="btn btn-success">Submit</button>
                                                <button type="button" data-dismiss="modal" class=" btn btn-danger">Cancel</button>

                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>