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
                                <button class="btn btn-default"  data-toggle="modal" data-target="#add_exam_modal"><i class="fa fa-plus"></i> Add New Exam</button>
                            </li>

                        </ul>

                        <div class="modal" id="add_exam_modal">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <span class="close" data-dismiss="modal">&times;</span>
                                        <h3 class="modal-title">Add New Exam</h3>
                                    </div>
                                    <div class="modal-body">
                                        <form class="form-horizontal" id="add_exam_form" action="" method="">
                                            {{csrf_field() }}
                                            <div class="form-group">
                                                <label for="exam_name" class="control-label col-lg-4">Exam Name</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control" id="exam_name" name="exam_name" autofocus />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="exam_year" class="control-label col-lg-4">Exam Year</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control" id="exam_year" name="exam_year" />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-lg-8 col-lg-offset-4">
                                                    <input class="btn btn-primary" type="submit"  />
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="modal" id="edit_exam_modal">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <span class="close" data-dismiss="modal">&times;</span>
                                        <h3 class="modal-title">Edit Exam</h3>
                                    </div>
                                    <div class="modal-body">
                                        <form class="form-horizontal" id="edit_exam_form" action="" method="">
                                            {{csrf_field() }}
                                            {{ method_field('PATCH') }}
                                            <input id="edit_exam_id" name="edit_exam_id" type="hidden" value="" />
                                            <div class="form-group">
                                                <label for="edit_exam_name" class="control-label col-lg-4">Exam Name</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control" id="edit_exam_name" name="edit_exam_name" autofocus />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="edit_exam_year" class="control-label col-lg-4">Exam Year:</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control" id="edit_exam_year" name="edit_exam_year"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-lg-8 col-lg-offset-4">
                                                    <input class="btn btn-primary" type="submit" value="Update" />
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <table id="exam_table" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Exam Name</th>
                                   
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




<!-- Datatables -->
<script>
    
 /**
 * Delete Exam
 */
function delete_exam(id) {
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
               url: "{{route('exam.destroy',null)}}" + "/" + id,
               type:'post',
               data: {'_method': 'DELETE', '_token': csrf},
               success:function(response){
                   console.log(response);
                   $('#exam_table').DataTable().ajax.reload();
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

function edit_exam(id){
    //alert(id);
   $.ajax({
       url: "{{url('exam')}}" + '/' + id + '/edit', 
       type: 'get',
       dataType: 'json',
       success:function(data){
           //console.log(data);
           
           $('#edit_exam_id').val(data.exam_id);
           $('#edit_exam_name').val(data.exam_name);
           $('#edit_exam_year').val(data.exam_year);
           $('#edit_exam_modal').modal('show');
       }
   });
}
    

    
    
$(document).ready(function () {
    
    //Year Picker
    $('#exam_year').datepicker({
        format: 'yyyy',
        autoclose: true,
        showOnFocus: true,
        startView: "years", 
        minViewMode: "years"
    });
    $('#edit_exam_year').datepicker({
        format: 'yyyy',
        autoclose: true,
        showOnFocus: true,
        startView: "years", 
        minViewMode: "years"
    });
    
    
    // Data Table 
    
        $('#exam_table').dataTable({
        processing: true,
        serverSide: true,
        'dom': 'Bfrtip',
        
        //order: [[0, "DESC"]],
        
        ajax: "{{url('get_exam')}}",
        
        //lengthMenu: [5,10,25,50,75,100],
        
        columns: [
            {data: 'exam_name', name: 'exam_name'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ],
        'fnDrawCallback':function(){
           $('[data-toggle="tooltip"]').tooltip();
       }
    });
    
    
    
    
    //Add New Exam

    $('#add_exam_form').submit(function(event) {
        event.preventDefault();
        var form_data  = $(this).serialize();

        $.ajax({
            url: "{{route('exam.store')}}",
            type:'post',
            data:form_data,
            beforeSend: function (xhr) {
                $('#add_exam_form').find('.form-group').removeClass('has-error');           
                $('#add_exam_form').find('.help-block').detach();           
            },
            dataType:'json',
            success:function(data) {
                $('#add_exam_form')[0].reset();
                 $('#exam_table').DataTable().ajax.reload();
               swal({
                   type:'success',
                   title:'Exam Create Successfully',
                   showConfirmButton: false,
                   timer: 1500
               });
            },error:function(error){
                response = error.responseJSON;
                errors = response.errors;
                $.each(errors,function(key, value){
                    $('#'+ key)
                        .closest('.form-group')
                        .addClass('has-error')
                        .append('<span class="help-block error col-lg-offset-4"><strong>' + value + '</strong></span>');
                        ;
                });//End Each

            }//End Error
        });//End Ajax
    });
    
    $('#edit_exam_form').submit(function(event) {
        event.preventDefault();
        var form_data = $(this).serialize();
        console.log(form_data);
        var exam_id = $('#edit_exam_id').val();
             $.ajax({
            url: "{{route('exam.update',null)}}" + '/' + exam_id ,
            type:'post',
            data:form_data,
            beforeSend: function (xhr) {
                $('#edit_exam_form').find('.form-group').removeClass('has-error');           
                $('#edit_exam_form').find('.help-block').detach();           
            },
            dataType:'json',
            success:function(data) {
                $('#edit_exam_form')[0].reset();
                $('#exam_table').DataTable().ajax.reload();
                 $('#edit_exam_modal').modal('hide');
               swal({
                   type:'success',
                   title:'Exam Updated Successfully',
                   showConfirmButton: false,
                   timer: 1500
               });
            },error:function(error){
                response = error.responseJSON;
                errors = response.errors;
                $.each(errors,function(key, value){
                    $('#'+ key)
                        .closest('.form-group')
                        .addClass('has-error')
                        .append('<span class="help-block error col-lg-offset-4"><strong>' + value + '</strong></span>');
                        ;
                });//End Each

            }//End Error
        });//End Ajax
        
    });
    
    


});//End Document Ready


</script>
<!-- /Datatables -->


@endsection