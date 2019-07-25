@extend('master')
@section('stylesheet')

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs/jszip-2.5.0/dt-1.10.16/b-1.5.1/b-flash-1.5.1/b-html5-1.5.1/b-print-1.5.1/datatables.min.css"/>

@endsection

@section('content')
<!-- page content -->
<div class="right_col" role="main">
    <div class="">


        <div class="clearfix"></div>

        <div class="row full_height">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel full_height">
                    <div class="x_title">
                        <h2>Button Example <small>Users</small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li>
                                <button class="btn btn-default"  data-toggle="modal" data-target="#add_teacher_modal"><i class="fa fa-plus"></i> Add New Teacher</button>
                            </li>

                        </ul>


                        <!------------------- Add Teacher Modal  ----------------------------------->

                        <div class="modal" id="add_teacher_modal">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <span class="close" data-dismiss="modal">&times;</span>
                                        <h3 class="modal-title">Add New Teacher</h3>
                                    </div>
                                    <div class="modal-body">
                                        <form id="add_teacher_form" method="post" action="{{route('teacher.store')}}" class="form-horizontal" enctype="multipart/form-data">
                                            {{csrf_field()}}
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="control-label col-lg-4" for="name">Teacher Name</label> 
                                                    <div class="col-lg-8">
                                                        <input type="text"  class=" form-control" autofocus value="" name="name" id="name"/>
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
                                                    <label class="control-label col-lg-4" for="email">Email</label> 
                                                    <div class="col-lg-8">
                                                        <input type="text"  class="form-control" value="" name="email" id="email"/>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-lg-4" for="age">Age</label> 
                                                    <div class="col-lg-8">
                                                        <input type="number"  class="form-control" value="" name="age" id="age"/>
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
                                            </div>
                                            <div class="col-lg-6">

                                                <div class="form-group">
                                                    <label class="control-label col-lg-4" for="job_type">Job Type</label> 
                                                    <div class="col-lg-8">
                                                        <select name="job_type" class="form-control" id="job_type">
                                                            <option value="">Select Job Type</option>
                                                            <option value="1">Part Time</option>
                                                            <option value="2">Full Time</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="control-label col-lg-4" for="photo">Photo</label> 
                                                    <div class="col-lg-8">
                                                        <input type="file" id="photo" name="photo" class=""  data-preview-file-type="text" />
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-lg-8 col-lg-offset-4">

                                                        <button type="submit" class="btn btn-primary">Add Teacher</button>
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





                        <!------------------------------Edit Teacher Modal----------------------------------->                      
                        <div class="modal" id="edit_teacher_modal">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <span class="close" data-dismiss="modal">&times;</span>
                                        <h3 class="modal-title">Edit Teacher Information</h3>
                                    </div>
                                    <div class="modal-body">
                                        <form id="edit_teacher_form" method="post" action="" class="form-horizontal" enctype="multipart/form-data">
                                            {{csrf_field()}}
                                            {{ method_field('PATCH') }}
                                            <input type="hidden"   name="teacher_id" id="teacher_id"/>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="control-label col-lg-4" for="edit_name">Teacher Name</label> 
                                                    <div class="col-lg-8">
                                                        <input type="text"  class=" form-control" autofocus value="" name="edit_name" id="edit_name"/>
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
                                                    <label class="control-label col-lg-4" for="edit_job_type">Job Type</label> 
                                                    <div class="col-lg-8">
                                                        <select name="edit_job_type" class="form-control" id="edit_job_type">
                                                            <option value="">Select Job Type</option>
                                                            <option value="1">Part Time</option>
                                                            <option value="2">Full Time</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">

                                                <div class="form-group">
                                                    <label class="control-label col-lg-4">Old Image</label>
                                                    <div class="edit_photo_thumb col-lg-8">
                                                        <img class="img-thumbnail" id="old_teacher_photo" src="{{asset('upload')}}/CRVKw3kxa0E3Yo9y7FVT5a45318202cf2.jpg" />
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="control-label col-lg-4" for="edit_photo">Photo</label> 
                                                    <div class="col-lg-8">
                                                        <input type="file" id="edit_photo" name="edit_photo" class=""  data-preview-file-type="text" />
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-lg-8 col-lg-offset-4">
                                                        <button type="submit" class="btn btn-primary">Update Teacher</button>
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




  <!----------------------Show Teacher Modal------------------------------------->


                        <div class="modal fade" id="show_teacher_modal">
                            <div class="modal-dialog  modal-lg ">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <span class="close" data-dismiss="modal"> &times;</span>
                                        <h3 class="modal-title">
                                            Teacher Information
                                        </h3>
                                        
                                    </div>
                                    <div class="modal-body">
                                        <div class="col-lg-8">
                                            <table class="table table-bordered table-striped">
                                                <thead></thead>
                                                <tbody>
                                                    <tr>
                                                        <td>Teacher Name:</td>
                                                        <td id="teacher_name"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Age</td>
                                                        <td id="teacher_age"></td>
                                                    </tr>
                                                    </tr>
                                                    <tr>
                                                        <td>Date of Birth</td>
                                                        <td id="teacher_date_of_birth"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Contact:</td>
                                                        <td id="teacher_contact"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Email:</td>
                                                        <td id="teacher_email"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Address</td>
                                                        <td id="teacher_address"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>City:</td>
                                                        <td id="teacher_city"></td>
                                                    </tr>
                                                    </tr>
                                                    <tr>
                                                        <td>Country:</td>
                                                        <td id="teacher_country"></td>
                                                    </tr>
                                                    </tr>
                                                    <tr>
                                                        <td>Job Type:</td>
                                                        <td id="teacher_job_type"></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="thumbnail">
                                                <img id="teacher_photo" src="" />
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-danger" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>


<!---------------------End Show Teacher Modal--------------------------------->
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <table id="teacher_table" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Photo</th>
                                    <th>Name</th>
                                    <th>Age</th>
                                    <th>Contact</th>
                                    <th>Email</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>



                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection
@section('script')


<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs/jszip-2.5.0/dt-1.10.16/b-1.5.1/b-flash-1.5.1/b-html5-1.5.1/b-print-1.5.1/datatables.min.js"></script>

<script src="{{asset('assets')}}/js/jQuery.populateCountry.min.js"></script>

<!--<script src="{{asset('assets')}}/build/js/custom.min.js"></script>-->




<!-- Datatables -->
<script>
$(document).ready(function () {
    // Data Table 

    $('#photo').fileinput({
        'showUpload': false,
        showClose: false,
        allowedFileExtensions: ['jpg', 'gif', 'png']
    });
    $('#edit_photo').fileinput({
        'showUpload': false,
        showClose: false,
        allowedFileExtensions: ['jpg', 'gif', 'png']
    });



    $('#country').populateCountry();
    $('#edit_country').populateCountry();
  

    //Make Datatable
    var table = $('#teacher_table').dataTable({
        processing: true,
        serverSide: true,
        'dom': 'Bfrtip',
        //order: [[0, "DESC"]],
        ajax: {
            'url':"{{route('teacher.get_teacher')}}",
        },
        //lengthMenu: [5,10,25,50,75,100],
        columns: [
            {data: 'photo', name: 'photo'},
            {data: 'name', name: 'name'},
            {data: 'age', name: 'age'},
            {data: 'contact', name: 'contact'},
            {data: 'email', name: 'email'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ],
       'fnDrawCallback':function(){
           $('[data-toggle="tooltip"]').tooltip();
       }

    });
     


});


//Add Teacher Information
$('#add_teacher_form').submit(function (event) {
    event.preventDefault();
    var form = $('#add_teacher_form')[0];
    var data = new FormData(form);
    $.ajax({
        url: "{{route('teacher.store')}}",
        type: 'POST',
        data: data,
        beforeSend: function (xhr) {
            $('#add_teacher_form').find('.help-block').detach();
            $('#add_teacher_form').find('.form-group').removeClass('has-error');
        },
        processData: false, // Important!
        contentType: false,
        cache: false,
        dataType: 'json',
        success: function (resource) {
            $('#add_teacher_form')[0].reset();
            $('#teacher_table').DataTable().ajax.reload();
            swal({
                type: 'success',
                title: 'Teacher Add Successfully',
                showConfirmButton: false,
                timer: 1500
            });
        },
        error: function (error) {
            console.log(error);
            var response = error.responseJSON;
            var errors = response.errors;
            if ($.isEmptyObject(errors) === false) {
                $.each(errors, function (key, value) {
                    $('#' + key)
                        .closest('.form-group')
                        .addClass('has-error')
                        .append('<span class="help-block error col-lg-offset-4"><strong>' + value + '</strong></span>');
                });
            }
        }
    });
});


/*
 * 
 * Edit Teacher Information
 */
$('#edit_teacher_form').submit(function (event) {
    event.preventDefault();
    var teacher_id = $('#teacher_id').val();
    var form = $('#edit_teacher_form')[0];
    var data = new FormData(form);
    $.ajax({

        url: "{{route('teacher.update',null)}}" + "/" + teacher_id,
        type: 'post',
        data: data,
        beforeSend: function (xhr) {
            $('#edit_teacher_form').find('.help-block').detach();
            $('#edit_teacher_form').find('.form-group').removeClass('has-error');
        },
        processData: false,
        contentType: false,
        cache: false,
        dataType: 'json',
        success: function (resource) {
            console.log(resource);
            $('#edit_teacher_form')[0].reset();
            $('#edit_teacher_modal').modal('hide');
            $('#teacher_table').DataTable().ajax.reload();
            swal({
                type: 'success',
                title: 'Teacher Information Update Successfully',
                showConfirmButton: false,
                timer: 1500
            });
        },
        error: function (error) {
            console.log(error);
            var response = error.responseJSON;
            var errors = response.errors;
            if ($.isEmptyObject(errors) === false) {
                $.each(errors, function (key, value) {
                    $('#' + key)
                        .closest('.form-group')
                        .addClass('has-error')
                        .append('<span class="help-block error col-lg-offset-4"><strong>' + value + '</strong></span>');

                });
            }
        }
    });
});

//Show Teacher Information
function show_teacher(id) {
    $.ajax({
        url: "{{route('teacher.show',null)}}" +'/'+ id,
        type:'get',
        success: function (data, textStatus, jqXHR) {
            $('#teacher_name').text(data.name);
            $('#teacher_age').text(data.age);
           var date = data.date_of_birth;
           day = date.substr(8,2);
           month = date.substr(5,2);
           year =  date.substr(0,4);
           
            full_date = day+'/'+month+'/'+year;
            $('#teacher_date_of_birth').text(full_date);
            $('#teacher_contact').text(data.contact);
            $('#teacher_email').text(data.email);
            $('#teacher_address').text(data.address);
            $('#teacher_city').text(data.city);
            $('#teacher_country').text(data.country);
            $('#teacher_job_type').text((data.job_type ==1)? 'Full Time': 'Part Time');

            $('#teacher_photo').attr('src',data.photo);

            $('#show_teacher_modal').modal('show');
        }
    });
}




//Make Edit Teacher Form
function edit_teacher(id) {
    $.ajax({
        url: "{{url('teacher')}}" + "/" + id + "/edit",
        type: 'get',
        dataType: 'json',
        success: function (response) {
            console.log(response);
            $('#teacher_id').val(response.teacher_id);
            $('#edit_name').val(response.name);
            $('#edit_date_of_birth').val(response.date_of_birth);
            $('#edit_email').val(response.email);
            $('#edit_age').val(response.age);
            $('#edit_contact').val(response.contact);
            $('#edit_address').val(response.address);
            $('#edit_city').val(response.city);
            $('#edit_country').val(response.country);
            $('#edit_job_type').val(response.job_type);
            $('#old_teacher_photo').attr('src', response.photo);
            $('#edit_teacher_modal').modal('show');
        }
    });
}




//Delete Teacher Information
function delete_teacher(student_id) {
    csrf = $('meta[name="csrf-token"]').attr('content');
    var url = "{{ route('teacher.destroy',null)}}" + '/' + student_id;
    swal({
        title: 'Are you sure delete?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel!',
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        buttonsStyling: false,
        reverseButtons: true
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: url,
                method: 'post',
                data: {'_method': 'DELETE', '_token': csrf},
                success: function (response) {

                    console.log(response);
                    swal(
                        'Deleted!',
                        'Teacher has been deleted.',
                        'success'
                        );
                    $('#teacher_table').DataTable().ajax.reload();
                }
            });
        } else if (result.dismiss === 'cancel') {
            swal(
                'Cancelled',
                'Your imaginary file is safe :)',
                'error'
                );
        }
    });
}


</script>
<!-- /Datatables -->


@endsection