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
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel full_height">
                    <div class="x_title">
                        <h2>Button Example <small>Users</small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li>
                                <button class="btn btn-default"  data-toggle="modal" data-target="#add_class_modal"><i class="fa fa-plus"></i> Add New Class</button>
                            </li>

                        </ul>


                        <!------------------- Add Class Modal  ----------------------------------->

                        <div class="modal" id="add_class_modal">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <span class="close" data-dismiss="modal">&times;</span>
                                        <h3 class="modal-title">Add New Class</h3>
                                    </div>
                                    <div class="modal-body">
                                        <form id="add_class_form" method="post" action="{{route('class.store')}}" class="form-horizontal">
                                            {{csrf_field()}}
                                                <div class="form-group">
                                                    <label class="control-label col-lg-4" for="class_name">Class Name</label> 
                                                    <div class="col-lg-8">
                                                        <input type="text"  class=" form-control" autofocus value="" name="class_name" id="class_name"/>
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label class="control-label col-lg-4" for="class_numaric">Class Numaric</label> 
                                                    <div class="col-lg-8">
                                                        <input type="number"  class="form-control" value="" name="class_numaric" id="class_numaric"/>
                                                    </div>
                                                </div>
                                            <div class="form-group">
                                                <div class="col-lg-offset-4 col-lg-8">
                                                    <input  class="btn btn-primary" type="submit" value="Add New Class" />
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
                        <div class="modal" id="edit_class_modal">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <span class="close" data-dismiss="modal">&times;</span>
                                        <h3 class="modal-title">Edit Class Information</h3>
                                    </div>
                                    <div class="modal-body">
                                        <form id="edit_class_form" method="post" action="" class="form-horizontal">
                                            {{csrf_field()}}
                                            {{ method_field('PATCH') }}
                                            <input type="hidden"   name="class_id" id="class_id"/>
                                                <div class="form-group">
                                                    <label class="control-label col-lg-4" for="edit_class_name">Class Name</label> 
                                                    <div class="col-lg-8">
                                                        <input type="text"  class=" form-control" autofocus value="" name="edit_class_name" id="edit_class_name"/>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-lg-4" for="edit_class_numaric">Class Numaric</label> 
                                                    <div class="col-lg-8">
                                                        <input type="number"  class="form-control" value="" name="edit_class_numaric" id="edit_class_numaric"/>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-lg-8 col-lg-offset-4">
                                                        <input type="submit" class="btn btn-primary" value="Update Class" />
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
                        <table id="class_table" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>class Name</th>
                                    <th>Class Numaric</th>
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
    
$(document).ready(function () {


    //Make Datatable
    var table = $('#class_table').dataTable({
        processing: true,
        serverSide: true,
        'dom': 'Bfrtip',
        //order: [[0, "DESC"]],
        ajax: "{{route('class.get_class')}}",
        //lengthMenu: [5,10,25,50,75,100],
        columns: [
            {data: 'class_name', name: 'class_name'},
            {data: 'class_numaric', name: 'class_numaric'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ],
        'fnDrawCallback':function(){
           $('[data-toggle="tooltip"]').tooltip();
       }

    });
    
   $('#add_class_form').submit(function(e){
       e.preventDefault();
       var data = $(this).serialize();
       $.ajax({
           url: "{{route('class.store')}}",
           type: 'post',
           data: data,
           beforeSend: function (xhr) {
                $('#add_class_form').find('.help-block').detach();
                $('#add_class_form').find('.form-group').removeClass('has-error');
            },
           dataType:'json',
           success:function(){
                $('#add_class_form')[0].reset();
                $('#class_table').DataTable().ajax.reload();
                swal({
                    type: 'success',
                    title: 'Class Add Successfully',
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
   
   $('#edit_class_form').submit(function(e){
        e.preventDefault();
        var data = $(this).serialize();
        var class_id = $('#class_id').val();
        $.ajax({
            url: "{{url('class')}}" + "/" + class_id,
            type: 'post',
            data: data,
             beforeSend: function (xhr) {
                $('#edit_teacher_form').find('.help-block').detach();
                $('#edit_teacher_form').find('.form-group').removeClass('has-error');
            },
            dataType:'json',
            success:function(message){
                console.log(message);
                $('#edit_class_form')[0].reset();
                $('#edit_class_modal').modal('hide');
                $('#class_table').DataTable().ajax.reload();
                swal({
                    type: 'success',
                    title: 'Class Information Update Successfully',
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


function delete_class(id){
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
           $.ajax({
               url: "{{route('class.destroy',null)}}" + "/" + id,
               type:'post',
               data: {'_method': 'DELETE', '_token': csrf},
               success:function(response){
                   console.log(response);
                   $('#class_table').DataTable().ajax.reload();
                   swal(
                     'Deleted!',
                     'Class has been deleted.',
                     'success'
                    );
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


function edit_class(id){
  $.ajax({
      url:  "{{url('class')}}" + '/' + id + '/edit',
      type: 'get',
      dataType:'json',
      success:function(response){
          //console.log(response);
          $('#edit_class_name').val(response.class_name);
          $('#edit_class_numaric').val(response.class_numaric);
          $('#class_id').val(response.class_id);
          $('#edit_class_modal').modal('show');
      }
  });
}


</script>
<!-- /Datatables -->


@endsection