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
                                    <div class="form-group">
                                        <label for="class_id" class="control-label col-lg-4">Class Name:</label>
                                        <div class="col-lg-8">
                                            <select name="class_id" id="class_id" class="class_list form-control">

                                            </select>
                                        </div>
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
                $('.mark_subject_table').html('');
                $('.subject_list').html('');
                var exam_id = $(this).val();
                if(exam_id == ''){
                    $('.class_list').html('');
                }else{
                    $.ajax({
                        url: "{{url('get_all_class_select')}}",
                        type:'get',
                        success:function(data){
                            $('.class_list').empty();
                            $('.class_list').html(data);
                        }
                    });//End Ajax
                }
            });//End Change
            
            $('#class_id').change(function (){
                class_id = $(this).val();
                $('.subject_list').html('');
                $('.mark_subject_table').html('');
                //alert(class_id);
                $.ajax({
                    url: "{{url('get_subject_by_class_id')}}"+'/'+class_id,
                    type:'get',
                    success:function(data){
                        $('.subject_list').html(data);
                    }
                });
                
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
           
           get_grade_data(exam_id,class_id,subject_id);
           
        });
        
        function get_grade_data(exam_id,class_id,subject_id){
           var csrf = csrf = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
               url:"{{url('result-setting-form')}}",
               type:'post',
               data:{'exam_id':exam_id,'class_id':class_id,'subject_id':subject_id,'_token':csrf},
               success:function(data){
                   $('.mark_subject_table').html('');
                   $('.mark_subject_table').html(data)
               }
           });
        }
        
        
        $(document).on('click','.result_grade_save',function() {
            //alert('click');
            $('.form_error').html('').css('display:none');
            var item = $(this);
            var csrf = csrf = $('meta[name="csrf-token"]').attr('content');
              
            var result_setting_id = item.closest('tr').find('.result_setting_id').val();
            var exam_id = item.closest('tr').find('.exam_id').val();
            var class_id = item.closest('tr').find('.class_id').val();
            var subject_id = item.closest('tr').find('.subject_id').val();
            var mark_greater_than = item.closest('tr').find('.mark_greater_than').val();
            var mark_less_than = item.closest('tr').find('.mark_less_than').val();
            var grade = item.closest('tr').find('.grade').val();
            
            
            $.ajax({
                url: "{{route('result-setting.store')}}",
                beforeSend: function (xhr) {
                  item.closest('tr').find('.help-block').detach();                },
                data:{'_token':csrf, 'result_setting_id':result_setting_id,'exam_id':exam_id,'class_id':class_id,'subject_id':subject_id,'mark_greater_than':mark_greater_than,'mark_less_than':mark_less_than,'grade':grade},
                type:'post',
                success:function(data){
                    get_grade_data(exam_id,class_id,subject_id);
                    swal({
                        type: 'success',
                        title: 'Grade Save Successfully',
                        showConfirmButton: false,
                        timer: 1500
                    });
                },error:function(data){
                    
                   var response = data.responseJSON;
                   var errors = response.errors;
                   if($.isEmptyObject(errors) === false){
                       $.each(errors,function(key, value){
                           item.closest('tr').find('.'+key).after('<span class="help-block error"><strong>' + value + '</strong></span>');
                       });
                       
                   }
                }
            });
        });
        
        
        $(document).on('click','.add_new_grade',function() {
            
           var subject_id = $('.list-group').find('.active').attr('data-subject-id');
           var exam_id  = $('#exam_id').val()
           var class_id  = $('#class_id').val();
           
           $.ajax({
               url:"",
               type:'get',
               success:function(){
                   
               }
           });
            
            html = '';
            html +=       '<tr>';
                html +=            '<td>';
                html +=               '<input type="hidden" class="result_setting_id" name="result_setting_id" value="" />';
                html +=               '<input type="hidden" class="exam_id" name="exam_id" value="'+exam_id+'" />';
                html +=               '<input type="hidden" class="class_id" name="class_id" value="'+class_id+'" />';
                html +=                '<input type="hidden" class="subject_id" name="subject_id" value="'+subject_id+'" />';
                html +=                '<input type="text" class="mark_greater_than form-control" name="mark_greater_than" autofocus /></td>';
                html +=            '<td><input type="text" class="mark_less_than form-control" name="mark_less_than" /></td>';
                html +=           '<td><input type="text" class="grade form-control" name="grade" /></td>';
                html +=            '<td><button type="button" class="btn btn-primary result_grade_save">Save</button><button type="button" class="btn btn-danger delete_no_entry">Delete</button></td>';
                html +=       '</tr>';
            $('.mark_subject_table tbody').append(html);
        });
        $(document).on('click','.delete_no_entry',function() {
            item = $(this);
            item.closest('tr').remove();
        });
        $(document).on('click','.class_grade_reset',function() {
            
           var csrf = csrf = $('meta[name="csrf-token"]').attr('content');
           var subject_id = $('.list-group').find('.active').attr('data-subject-id');
           var exam_id  = $('#exam_id').val()
           var class_id  = $('#class_id').val();
           
            swal({
                title: 'Are you sure Reset Grade?',
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
                        url: "{{url('reset-result-setting')}}" ,
                        method: 'post',
                        data: {'_token': csrf,'exam_id':exam_id,'class_id':class_id,'subject_id':subject_id},
                        success: function (response) {
                            get_grade_data(exam_id,class_id,subject_id);
                            console.log(response);
                            swal(
                                'Deleted!',
                                'Grade Reset Successfully.',
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
           
        });
        

    </script>
    <!-- /Datatables -->


    @endsection