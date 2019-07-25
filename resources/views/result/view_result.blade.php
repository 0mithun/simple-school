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
                                    <div class="subject_list"></div>
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
                        <div class="student_result_data">
                            
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
                $('.result_entry_table').html('');
                $('.subject_list').html('');
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
                $('.result_entry_table').html('');
                $('.subject_list').html('');
                var exam_id = $(this).val();
                if(exam_id == ''){
                    $('.class_list').html('');
                }else{
                    $.ajax({
                        url: "{{url('get_all_class_list')}}" + '/' + exam_id,
                        type:'get',
                        success:function(data){
                            $('.class_list').empty();
                            $('.class_list').html(data);
                        }
                    });//End Ajax
                }
            });//End Change
            
    });
    
    
    
    
        $(document).on('click','.class_list .list-group-item',function() {
            var csrf = csrf = $('meta[name="csrf-token"]').attr('content');
            var item = $(this);
            var class_id = item.attr('data-class-id');
            var exam_id = item.attr('data-exam-id');
            $('.class_list').find('.active').removeClass('active');
            item.addClass('active');
            //console.log(class_id);
            $.ajax({
                url: "{{url('get_result_by_class')}}",
                type:'post',
                data:{'class_id':class_id,'exam_id':exam_id,'_token':csrf},
                success:function(data){
                    //console.log(data);
                 
                 $('.student_result_data').html('');
                 $('.student_result_data').html(data);
                 $('.student_result_table').dataTable({
                      'dom': 'Bfrtip',
                 });
                }
            });//End Ajax Request
        });//End Click
    
    
    
    
         /*   
            
            $('#class_id').change(function (){
                class_id = $(this).val();
                $('.subject_list').html('');
                $('.result_entry_table').html('');
                //alert(class_id);
                $.ajax({
                    url: "{{url('get_subject_by_class_id')}}"+'/'+class_id,
                    type:'get',
                    success:function(data){
                        $('.subject_list').html(data);
                    }
                });//End Ajax
                
            });
            $('.single_subject').click(function() {
                alert('clicked');
            });
        });//End Document Ready
        
       $(document).on('click','.single_subject',function() {
           var item = $(this);
           $('.list-group').find('.active').removeClass('active');
           item.addClass('active');
           var subject_id = $(this).attr('data-subject-id');
           var exam_id  = $('#exam_id').val()
           var class_id  = $('#class_id').val();
           get_result_entry_table(exam_id,class_id,subject_id);
        });
        
        function get_result_entry_table(exam_id,class_id,subject_id){
           var csrf = csrf = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
               url:"{{url('result-entry-form')}}",
               type:'post',
               data:{'exam_id':exam_id,'class_id':class_id,'subject_id':subject_id,'_token':csrf},
               success:function(data){
                   $('.result_entry_table').html('');
                   $('.result_entry_table').html(data)
               }
           });//End Ajax
        }//End Function
        
        $(document).on('click','.student_mark_save',function(){
            var item = $(this);
            var csrf = csrf = $('meta[name="csrf-token"]').attr('content');
            
            var student_mark = item.closest('tr').find('.student_mark').val();
            var student_id = item.closest('tr').find('.student_id').val();
            var exam_id = item.closest('tr').find('.student_exam_id').val();
            var class_id = item.closest('tr').find('.student_class_id').val();
            var subject_id = item.closest('tr').find('.student_subject_id').val();
            
            $.ajax({
                url: "{{route('result.store')}}",
                type:'post',
                beforeSend: function (xhr) {
                     item.closest('tr').find('.help-block').detach();    
                },
                dataType:'json',
                data:{'_token':csrf,'exam_id':exam_id,'class_id':class_id,'subject_id':subject_id,'student_id':student_id,'student_mark':student_mark},
                success:function(data){
                    swal({
                        type: 'success',
                        title: 'Mark Save Successfully',
                        showConfirmButton: false,
                        timer: 1000
                    });
                },error:function(error){
                    response = error.responseJSON;
                    errors = response.errors;
                     if($.isEmptyObject(errors) === false){
                       $.each(errors,function(key, value){
                           item.closest('tr').find('.'+key).after('<span class="help-block error"><strong>' + value + '</strong></span>');
                       });
                       
                   }
                }//End Error
            });//End Ajax
        });//End Click
        
        
        */
    </script>
    <!-- /Datatables -->


    @endsection