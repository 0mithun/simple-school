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
            <div class="col-md-4 col-sm-4 col-xs-4">
                <div class="x_panel full_height">


                    <div class="x_title">
                        <h2><i class="fa fa-bars"></i> Class</h2>

                        <div class="clearfix">
                        </div>
                    </div>
                    <div class="x_content">
                        <div class="pael">
                            <div class="panel-body">
                                <form class="form-horizontal" id="" method="" action="">
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label" for="exam_year">Exam Year:</label>
                                        <div class="col-lg-8">
                                            <select name="exam_year" id="exam_year" class="form-control">
                                                <option value="" selected>---- Please Select Year ----</option>
                                                @foreach($exam_years as $exam_year)
                                                    <option value="{{$exam_year->exam_year}}">{{$exam_year->exam_year}}</option>
                                                @endforeach
                                               
                                            </select>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="form-group">
                                        <label class="control-label col-lg-4" for="exam_id">Exam Name: </label>
                                        <div class="col-lg-8">
                                            <select class="form-control" name="exam_id" id="exam_id">
                                                
                                            </select>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="class_list">
                                        
                                    </div>
                                    
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-md-8 col-sm-8 col-xs-8">
                <div class="x_panel full_height">


                    <div class="x_title">
                        <h2><i class="fa fa-bars"></i> Class</h2>

                        <div class="clearfix">
                        </div>
                        
                    </div>
                    <div class="x_content">
                        <div class="mark_subject_table">
                            
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

        $(document).ready(function () {
            // Data Table 
            $('#exam_year').change(function(){
                $('.class_list').html('');
                $('.mark_subject_table').html('');
                var exam_year = $(this).val();
              if(exam_year == ''){
                  $('#exam_id').html('');
              }else{
                $.ajax({
                      url: "{{url('get_exams_by_year')}}"+ '/'+exam_year,
                      type:'get',
                      success:function(data){
                          $('#exam_id').html(data);
                      }
                  });//End Ajax
              }//end if
            });//End Change

            $('#exam_id').change(function() {
                $('.class_list').empty();
                $('.mark_subject_table').html('');
                var exam_id = $(this).val();
                if(exam_id == ''){
                    $('.class_list').html('');
                }else{
                    $.ajax({
                        url: "{{url('get_all_class_list')}}"+ '/'+ exam_id,
                        type:'get',
                        success:function(data){
                            $('.class_list').empty();
                            $('.class_list').html(data);
                        }
                    });//End Ajax
                }
            });//End Change
        });//End Document Ready
        
        $(document).on('click','.class_list .list-group-item',function() {
            var csrf = $('meta[name="csrf-token"]').attr('content');
            var item = $(this);
            var class_id = item.attr('data-class-id');
            var exam_id = item.attr('data-exam-id');
            $('.class_list').find('.active').removeClass('active');
            item.addClass('active');
            //console.log(class_id);
            $.ajax({
                url: "{{url('get_subject_by_class')}}",
                type:'post',
                data:{'class_id':class_id,'exam_id':exam_id,'_token':csrf},
                success:function(data){
                 //   console.log(data);
                 $('.mark_subject_table').html('');
                 $('.mark_subject_table').html(data);
                }
            });//End Ajax Request
        });//End Click
        
        
        $(document).on('click','.mark_subject_save',function() {
             var item = $(this);
             var csrf = csrf = $('meta[name="csrf-token"]').attr('content');
             
             var total_mark = item.closest('tr').find('.total_mark').attr('id');
             var total_val = item.closest('tr').find('.total_mark').val();
             var total_id = total_mark.substr(11);
             
             var pass_mark = item.closest('tr').find('.pass_mark').attr('id');
             var pass_val = item.closest('tr').find('.pass_mark').val();
             var pass_id = pass_mark.substr(10);
                          
             var exam_id  = item.closest('tr').find('.exam_id').val();
             var class_id  = item.closest('tr').find('.class_id').val();
             var subject_id  = item.closest('tr').find('.subject_id').val();

             data = {};
             data[total_mark] = total_val;
             data[pass_mark] = pass_val;
             data['_token'] = csrf;
             data['class_id'] = class_id;
             data['exam_id'] = exam_id;
             data['subject_id'] = subject_id;
             data['total_id'] = total_id;
             data['pass_id'] = pass_id;
             
             
             $.ajax({
                 url: "{{route('mark.store')}}",
                 type:'post',
                 beforeSend: function (xhr) {
                    $('td').find('.help-block').remove();   
                    $('table').find('.has-error').removeClass('has-error');   
                },
                 data:data,
                dataType:'json', 
                success:function(data){
                     swal({
                        type: 'success',
                        title: 'Mark Save Successfully',
                        showConfirmButton: false,
                        timer: 1500
                    });
                 },error:function(error){
                    var response = error.responseJSON;
                    var errors = response.errors;
                    if ($.isEmptyObject(errors) === false) {
                        $.each(errors, function (key, value) {
                            $('#' + key)
                                    .closest('td')
                                    .addClass('has-error')
                                    .append('<span class="help-block error"><strong>' + value + '</strong></span>');
                        });//End Each
                    }//End if
                 }//End Errors
                 
             });//End Ajax
        });
       


    </script>
    <!-- /Datatables -->


    @endsection