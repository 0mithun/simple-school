@extend('master')
@section('stylesheet')
<!-- NProgress -->
<link href="{{asset('assets')}}/vendors/nprogress/nprogress.css" rel="stylesheet">
<!-- iCheck -->
<link href="{{asset('assets')}}/vendors/iCheck/skins/flat/green.css" rel="stylesheet">
<link href="{{asset('assets')}}/vendors/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet">

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs/jszip-2.5.0/dt-1.10.16/b-1.5.1/b-flash-1.5.1/b-html5-1.5.1/b-print-1.5.1/datatables.min.css"/>

<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.5/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />
<!-- if using RTL (Right-To-Left) orientation, load the RTL CSS file after fileinput.css by uncommenting below -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.5/css/fileinput-rtl.min.css" media="all" rel="stylesheet" type="text/css" />

@endsection

@section('content')
<!-- page content -->
<div class="right_col" role="main">
    <div class="">


        <div class="clearfix"></div>

        <div class="row full_height">
            <div class="col-md-4 col-sm-4 col-xs-4">
                <div class="x_panel full_height">
                    <div class="x_title">
                        <h2><i class="fa fa-bars"></i> Class</h2>
                       
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="panel panel-default">
                            <div class="list-group" id="class_list">
                               @foreach($all_class as $class)
                               <a  href="#" class="list-group-item" data-id="{{$class->class_id}}">{{$class->class_name." (".$class->class_numaric.")"}}</a>
                               @endforeach
                            </div>
                        </div>

                        <div class="clearfix"></div>

                    </div>
                </div>
            </div>
            <div class="col-md-8 col-sm-12 col-xs-12">
                <div class="x_panel full_height">
                    <div class="x_title">
                        <h2>Button Example <small>Users</small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li>
                                <button class="btn btn-default"  data-toggle="modal" data-target="#add_student_modal"><i class="fa fa-plus"></i> Add New Student</button>
                            </li>

                        </ul>

                        @include('student.add_student')
                        @include('student.edit_student')
                        @include('student.show_student')

                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        
                        <div class="" role="" data-example-id="togglable-tabs">
                          <ul id="section_tab" class="nav nav-tabs bar_tabs" role="tablist">
                          </ul>
                          <div id="myTabContent" class="tab-content">
                            <div role="" class="tab-pane fade active in" id="all_students" aria-labelledby="home-tab">
                                <table id="student_table" class="table table-striped table-bordered">
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
                              
                            <div role="" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">
                                <div class="well well-sm">
                                    <span class="section_class_name"></span><br><span class="section_section_name"></span> 
                                </div>
                               <table id="student_section_table" class="table table-striped table-bordered">
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

        </div>
    </div>
</div>

@endsection
@section('script')

<!-- NProgress -->
<!-- FastClick -->
<script src="{{asset('assets')}}/vendors/fastclick/lib/fastclick.js"></script>
<script src="{{asset('assets')}}/vendors/nprogress/nprogress.js"></script>
<!-- iCheck -->
<script src="{{asset('assets')}}/vendors/iCheck/icheck.min.js"></script>
<script src="{{asset('assets')}}/vendors/sweetalert2/dist/sweetalert2.min.js"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs/jszip-2.5.0/dt-1.10.16/b-1.5.1/b-flash-1.5.1/b-html5-1.5.1/b-print-1.5.1/datatables.min.js"></script>

<!-- the main fileinput plugin file -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.5/js/fileinput.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.5/themes/fa/theme.js"></script>
<!-- Custom Theme Scripts -->
<script src="{{asset('assets')}}/js/jQuery.populateCountry.min.js"></script>

<!--<script src="{{asset('assets')}}/build/js/custom.min.js"></script>-->




<!-- Datatables -->
<script>




$(document).ready(function () {
    //File Input
    $('#student_photo').fileinput({
        'showUpload': false,
        showClose: false,
        allowedFileExtensions: ['jpg', 'gif', 'png']
    });
    $('#edit_student_photo').fileinput({
        'showUpload': false,
        showClose: false,
        allowedFileExtensions: ['jpg', 'gif', 'png']
    });

//country Js
    $('#country').populateCountry();
    $('#edit_country').populateCountry();


//Make Dropdown
    $('#class_id').on('change', function () {
        $('#no_class').remove();
        var class_id = $(this).val();
        $.ajax({
            url: "{{url('make_section')}}" + '/' + class_id,
            type: 'get',
            success: function (data) {
                if (data != '') {
                    $('#section_id').empty().removeAttr('disabled');
                    $('#section_id').html(data).prepend('<option selected>---- Please Select Section ----</optioin>');
                } else {
                    $('#section_id').empty().attr('disabled', 'disabled');
                    $('#section_id').html('<option>---- No Section Found ----</option>');
                }
            }
        });
    });

    $('#edit_class_id').on('change', function () {
        var class_id = $(this).val();
        $.ajax({
            url: "{{url('make_section')}}" + '/' + class_id,
            type: 'get',
            success: function (data) {
                if (data != '') {
                    $('#edit_section_id').empty().removeAttr('disabled');
                    $('#edit_section_id').html(data).prepend('<option selected>---- Please Select Section ----</optioin>');
                } else {
                    $('#edit_section_id').empty().attr('disabled', 'disabled');
                    $('#edit_section_id').html('<option>---- No Section Found ----</option>');

                }

            }
        });
    });
    
    
    var class_id = $('#class_list .list-group-item ').first().attr('data-id');
    make_datatable(class_id);    
    make_section(class_id);
    
    
    //make section
    function make_section (id){
           
        $.ajax({
            url:"{{url('get_sections_by_class_id')}}" + '/' + id,
            type:'get',
            dataType:'json',
            success:function(data){
               var tab=  $('#section_tab');
               tab.empty();
               var list =  '<li  class="active"><a href="#all_students" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">All Students</a></li>';
               //tab.append('<li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">Profile</a></li>');
               $.each(data,function(key, value){
                   list += '<li ><a class="section_list" href="#tab_content2" role="tab" data-toggle="tab" aria-expanded="false" data-sec-id="'+value.section_id+'" data-class-id="'+value.class_id+'">'+value.section_name+'</a></li>';
               });
               tab.html(list);
               
               
            }
        });
    }
    
    //Make Datatable
    function make_datatable(class_id){
         var table = $('#student_table').dataTable({
            processing: true,
            serverSide: true,
            'dom': 'Bfrtip',
            //order: [[0, "DESC"]],
            ajax: "{{url('get_students')}}" + '/'+ class_id,
            //lengthMenu: [5,10,25,50,75,100],
            columns: [
                {data: 'student_photo', name: 'student_photo'},
                {data: 'student_name', name: 'student_name'},
                {data: 'age', name: 'age'},
                {data: 'contact', name: 'contact'},
                {data: 'email', name: 'email'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ],
            'fnDrawCallback':function(){
                $('[data-toggle="tooltip"]').tooltip();
            }
        });
    }
    
     //make class list
    $('#class_list .list-group-item ').first().addClass('active');
    $('#class_list .list-group-item ').click(function(){
        var item = $(this);
        var id = item.attr('data-id')
        $('#class_list').find('.active').removeClass('active');       
        item.addClass('active'); 
        
        $('#all_students').removeClass('active in ');        
        $('#tab_content2').removeClass('in active');        
        $('#all_students').addClass('in active');       
        
        $("#student_table").dataTable().fnDestroy();       
        
        make_datatable(id);
        make_section(id);
        
    });

    
   
   
    //make section datatable
    $(document).on('click','#section_tab .section_list',function(){
        var section_id = $(this).attr('data-sec-id');
        var classid =  $(this).attr('data-class-id');
        $("#student_section_table").dataTable().fnDestroy();
        make_section_datatable(classid, section_id);
        $.ajax({
            url: "{{url('get_section_by_section_id')}}" + '/' + section_id,
            type:'get',
            dataType:'json',
            success:function(data){
                $('.section_section_name').text('');
                $('.section_class_name').text('');
                $('.section_section_name').text(data.section_name);
                $('.section_class_name').text(data.class_name + ' ('+data.class_numaric+ ')');
        
            }
        });
        
        
    });
   
   //Make Section Datatable
   
    function make_section_datatable(class_id, section_id){
        var table = $('#student_section_table').dataTable({
            processing: true,
            serverSide: true,
            'dom': 'Bfrtip',
            //order: [[0, "DESC"]],
            ajax: "{{url('get_students_by_section')}}" + '/'+ class_id + '/'+section_id,
            //lengthMenu: [5,10,25,50,75,100],
            columns: [
                {data: 'student_photo', name: 'student_photo'},
                {data: 'student_name', name: 'student_name'},
                {data: 'age', name: 'age'},
                {data: 'contact', name: 'contact'},
                {data: 'email', name: 'email'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ],
            'fnDrawCallback':function(){
                $('[data-toggle="tooltip"]').tooltip();
            }
        });
    }
    
   
    
    
  
    
});

//Add New Student
$('#add_student_form').submit(function (event) {
    event.preventDefault();
    var form = $(this)[0];
    var data = new FormData(form);
    $.ajax({
        url: "{{route('student.store')}}",
        type: 'post',
        data: data,
        beforeSend: function (xhr) {
            $('#add_student_form').find('.help-block').detach();
            $('#add_student_form').find('.form-group').removeClass('has-error');
        },
        processData: false,
        contentType: false,
        cache: false,
        dataType: 'json',
        success: function (resource) {
            $('#class_id').prepend('<option value="" id="no_class" selected>---- Select Class ----</option>');
            $('#section_id').attr('disabled', 'disabled')
            $('#add_student_form')[0].reset();
            $('#student_table').DataTable().ajax.reload();
            swal({
                type: 'success',
                title: 'Student Add Successfully',
                showConfirmButton: false,
                timer: 1500
            });
        },
        error: function (error) {
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
 * Edit Student Information
 */

$('#edit_student_form').submit(function (event) {
    event.preventDefault();
    var student_id = $('#student_id').val();
    var form = $('#edit_student_form')[0];
    var data = new FormData(form);
    $.ajax({

        url: "{{route('student.update',null)}}" + "/" + student_id,
        type: 'post',
        data: data,
        beforeSend: function (xhr) {
            $('#edit_student_form').find('.help-block').detach();
            $('#edit_student_form').find('.form-group').removeClass('has-error');
        },
        processData: false,
        contentType: false,
        cache: false,
        dataType: 'json',
        success: function (resource) {
            $('#edit_student_form')[0].reset();
            $('#edit_student_modal').modal('hide');
            $('#student_table').DataTable().ajax.reload();
            $('#student_section_table').DataTable().ajax.reload();
            swal({
                type: 'success',
                title: 'Student Information Update Successfully',
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

//Show Student
function show_student(id){
    $.ajax({
        url: "{{route('student.show',null)}}" + '/' + id,
        type: 'get',
        success:function(data){
            $('#studentname').text(data.student_name);
            $('#student_age').text(data.age);
            $('#student_date_of_birth').text(data.date_of_birth);
            $('#student_contact').text(data.contact);
            $('#student_email').text(data.email);
            $('#student_address').text(data.address);
            $('#student_city').text(data.city);
            $('#student_country').text(data.country);
            $('#student_date_of_registration').text(data.date_of_register);
            $('#student_class').text(data.class_name);
            $('#student_section').text(data.section_name);
            $('#studentphoto').attr('src',data.student_photo);
            $('#show_student_modal').modal('show');
        }
    });
}




//Make Edit Student Form
function edit_student(id) {
    $.ajax({

        url: "{{url('student')}}" + "/" + id + "/edit",
        type: 'get',
        dataType: 'json',
        success: function (response) {
            $('#student_id').val(response.student_id);
            $('#edit_student_name').val(response.student_name);
            $('#edit_date_of_birth').val(response.date_of_birth);
            $('#edit_email').val(response.email);
            $('#edit_age').val(response.age);
            $('#edit_contact').val(response.contact);
            $('#edit_address').val(response.address);
            $('#edit_city').val(response.city);
            $('#edit_country').val(response.country);
            $('#edit_date_of_register').val(response.date_of_register);
            $('#edit_class_id').val(response.class_id);

            $('#edit_section_id').empty();
            $('#edit_section_id').load("{{url('make_section')}}" + '/' + response.class_id, function (data) {
                $('#edit_section_id').val(response.section_id);
            });
            $('#old_student_photo').attr('src', response.student_photo);
            $('#edit_student_modal').modal('show');
        }
    });
}


//Delete Teacher Information
function delete_student(student_id) {
    csrf = $('meta[name="csrf-token"]').attr('content');
    var url = "{{ route('student.destroy',null)}}" + '/' + student_id;
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
                //dataType: 'json' ,
                method: 'post',
                data: {'_method': 'DELETE', '_token': csrf},
                success: function (response) {
                    swal(
                        'Deleted!',
                        'Student has been deleted.',
                        'success'
                        );
                    $('#student_table').DataTable().ajax.reload();
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

@endsection