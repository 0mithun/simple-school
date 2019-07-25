@extend('master')
@section('stylesheet')
<!-- NProgress -->
<link href="{{asset('assets')}}/vendors/nprogress/nprogress.css" rel="stylesheet">
<!-- iCheck -->
<link href="{{asset('assets')}}/vendors/iCheck/skins/flat/green.css" rel="stylesheet">
<link href="{{asset('assets')}}/vendors/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet">

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs/jszip-2.5.0/dt-1.10.16/b-1.5.1/b-flash-1.5.1/b-html5-1.5.1/b-print-1.5.1/datatables.min.css"/>

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
            <div class="col-md-8 col-sm-8col-xs-8">
                <div class="x_panel full_height">
                    <div class="x_title">
                        <h2>Button Example <small>Users</small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li>
                                <button class="btn btn-default"  data-toggle="modal" data-target="#add_subject_modal"><i class="fa fa-plus"></i> Add New Subject</button>
                            </li>

                        </ul>


                        <!------------------- Add Subject Modal  ----------------------------------->

                        <div class="modal" id="add_subject_modal">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <span class="close" data-dismiss="modal">&times;</span>
                                        <h3 class="modal-title">Add New Subject</h3>
                                    </div>
                                    <div class="modal-body">
                                        <form id="add_subject_form" method="post" action="{{route('subject.store')}}" class="form-horizontal">
                                            {{csrf_field()}}
                                            <input type="hidden"  name="class_id" id="class_id" />
                                            <div class="form-group">
                                                <label class="control-label col-lg-4" for="subject_name">Subject Name</label> 
                                                <div class="col-lg-8">
                                                    <input type="text"  class=" form-control" autofocus value="" name="subject_name" id="subject_name"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-lg-4" for="marks">Total Mark</label> 
                                                <div class="col-lg-8">
                                                    <input type="number"  class=" form-control" autofocus value="" name="marks" id="marks"/>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-lg-4" for="teacher_id">Teacher </label> 
                                                <div class="col-lg-8">
                                                    <select name="teacher_id" id="teacher_id" class="form-control">
                                                         <option value="">Select Teacher</option>
                                                        @foreach($all_teacher as $teacher)
                                                         <option value="{{$teacher->teacher_id}}">{{$teacher->name}}</option>
                                                        @endforeach
                                                        
                                                    </select>
                                                   
                                                    
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-lg-offset-4 col-lg-8">
                                                    <input  class="btn btn-primary" type="submit" value="Add New Subject" />
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
                        <!-----------------------End Add Class Modal--------------------------------------->





                        <!------------------------------Edit Class Modal----------------------------------->                      
                        <div class="modal" id="edit_subject_modal">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <span class="close" data-dismiss="modal">&times;</span>
                                        <h3 class="modal-title">Edit Subject Information</h3>
                                    </div>
                                    <div class="modal-body">
                                        <form id="edit_subject_form" method="post" action="" class="form-horizontal">
                                            {{csrf_field()}}
                                            {{ method_field('PATCH') }}
                                            <input type="hidden"   name="subject_id" id="subject_id"/>
                                            <div class="form-group">
                                                <label class="control-label col-lg-4" for="edit_subject_name">Section Name</label> 
                                                <div class="col-lg-8">
                                                    <input type="text"  class=" form-control" autofocus value="" name="edit_subject_name" id="edit_subject_name"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-lg-4" for="edit_marks">Total Mark</label> 
                                                <div class="col-lg-8">
                                                    <input type="number"  class=" form-control" autofocus value="" name="edit_marks" id="edit_marks"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-lg-4" for="edit_teacher_id">Teacher</label> 
                                                <div class="col-lg-8">
                                                    <select id="edit_teacher_id" class="form-control" name="edit_teacher_id" >
                                                        @foreach($all_teacher as $teacher)
                                                         <option value="{{$teacher->teacher_id}}">{{$teacher->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-lg-8 col-lg-offset-4">
                                                    <input type="submit" class="btn btn-primary" value="Update Subject" />
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



                        <!------------------------End Edit Class Modal---------------------------------->


                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <table id="subject_table" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Subject Name</th>
                                    <th>Teacher Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="">

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


<!--<script src="{{asset('assets')}}/build/js/custom.min.js"></script>-->




<!-- Datatables -->
<script>
function make_datatable(id){
    $('#subject_table').dataTable({
        processing: true,
        serverSide: true,
        'dom': 'Bfrtip',
        //order: [[0, "DESC"]],
        ajax: "{{url('get_subject')}}" + '/' + id,
        //lengthMenu: [5,10,25,50,75,100],
        columns: [
            {data: 'subject_name', name: 'subject_name'},
            {data: 'name', name: 'teachers.name'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ],
        'fnDrawCallback':function(){
           $('[data-toggle="tooltip"]').tooltip();
       }

    });
}

function edit_subject(id){
    $.ajax({
        url: "{{url('subject')}}" + '/' + id + '/edit',
        type:'get',
        dataType: 'json',
        success:function(data){
            console.log(data);
            $('#subject_id').val(data.subject_id);
            $('#edit_subject_name').val(data.subject_name);
            $('#edit_marks').val(data.marks);
            $('#edit_teacher').val(data.teacher_id);
            $('#edit_subject_modal').modal('show');
        }
    });
    
   
}

function delete_subject(id){
        csrf = $('meta[name="csrf-token"]').attr('content');
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
          //  alert(id);
           $.ajax({
               url: "{{route('subject.destroy',null)}}" + "/" + id,
               type:'post',
               data: {'_method': 'DELETE', '_token': csrf},
               success:function(response){
                   console.log(response);
                   $('#subject_table').DataTable().ajax.reload();
                   swal(
                     'Deleted!',
                     'Subject has been deleted.',
                     'success',
                    );
               }
           });
        } else if (result.dismiss === 'cancel') {
            swal(
                    'Cancelled',
                    'Your imaginary file is safe :)',
                    'error',
                    );
        }
    });
}

$(document).ready(function () {

    //Make Datatable
    var class_id = $('#class_list .list-group-item ').first().attr('data-id');
    make_datatable(class_id);
     $('#class_id').val(class_id);
    $('#class_list .list-group-item ').first().addClass('active');
    
    $('#class_list .list-group-item ').click(function(){
        var item = $(this);
        var id = item.attr('data-id')
        $('#class_list').find('.active').removeClass('active');
       
        item.addClass('active');
       
        $('#class_id').val(id);
        $("#subject_table").dataTable().fnDestroy()
        make_datatable(id);
    });
    
    $('#add_subject_form').submit(function(e){
        e.preventDefault();
        data = $(this).serialize();
        $.ajax({
            url: "{{route('subject.store')}}",
            type:'post',
            data: data,
            beforeSend: function (xhr) {
                $('#add_subject_form').find('.help-block').detach();
                $('#add_subject_form').find('.form-group').removeClass('has-error');
            },
            dataType:'json',
            success:function(response){
             console.log(response);
             $('#add_subject_form')[0].reset();
                $('#subject_table').DataTable().ajax.reload();
                swal({
                    type: 'success',
                    title: 'Subject Add Successfully',
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
    
    $('#edit_subject_form').submit(function(e){
        e.preventDefault();
        var data = $(this).serialize();
        var section_id = $('#subject_id').val();
        $.ajax({
            url: "{{url('subject')}}" + '/' + section_id,
            data: data,
            type:'post',
            beforeSend: function (xhr) {
                $('#edit_subject_form').find('.help-block').detach();
                $('#edit_subject_form').find('.form-group').removeClass('has-error');
            },
            dataType: 'json',
            success:function(message){
                console.log(message);
                $('#edit_subject_form')[0].reset();
                $('#edit_subject_modal').modal('hide');
                $('#subject_table').DataTable().ajax.reload();
                swal({
                    type: 'success',
                    title: 'Subject Information Update Successfully',
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



});



</script>
<!-- /Datatables -->


@endsection