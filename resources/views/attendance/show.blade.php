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


            <div class="" role="tabpanel" data-example-id="togglable-tabs">
                <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#report_tab" class="report_tab" role="tab" data-toggle="tab" aria-expanded="true">Attendance Report</a>
                    </li>
                    <li role="presentation" class=""><a href="#attendance_tab" role="tab" class="attendance_tab" data-toggle="tab" aria-expanded="false">Take Attendance</a>
                    </li>
                </ul>
                <div id="myTabContent" class="tab-content ">
                   @include('attendance.attendance_report')
                   @include('attendance.take_attendance')
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

    $('#attendance_type').on('change', function () {
        $('.form_element').empty();
        var type = $(this).val();
        if (type == 2) {
            take_teacher_attendance();
        } else if (type == 1) {
            take_student_attendance()
        }
    });
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    $('.attendance_tab').on('click',function(){
       $('#attendance_report_type').val('');
        $('.report_form_element').empty();
    });
    $('.report_tab').on('click',function(){
       $('#attendance_type').val('');
        $('.form_element').empty();
    });
});

function take_teacher_attendance() {
    var html = ' <div class="form-group">';
    html += '<label for="date" class="control-label">Date</label>';
    html += '<input name="date" id="date" type="text" class="form-control" />';
    html += '</div>';
    html += ' <div class="form-group">';
    html += '<input type="submit" value="Submit" class="btn btn-primary" />';
    html += '</div>';
    $('.form_element').html(html);
    $('#date').datepicker({
        format: 'dd-mm-yyyy',
        todayHighlight: true,
        autoclose: true,
        showOnFocus: true
    });
}


$('#attendance_form').submit(function (event) {
    event.preventDefault();
    var date = $('#date').val();
    var type = $('#attendance_type').val();
    var form_data = $(this).serialize();

    $('#attendance_data').empty();

    if (type == 1) {
        var data = $(this).serialize();
        $.ajax({
            url: "{{url('load-student-attendance')}}",
            type: 'post',
            data: form_data,
            success: function (data) {
                $('#attendance_data').html(data);
                $('#attendance_table table:odd').css('background-color', '#f9f9f9');
            }
        });
    } else if (type == 2) {
        $('#attendance_data').load("{{url('load-teacher-attendance')}}" + '/' + date, function (data) {
            $('#attendance_table table:odd').css('background-color', '#f9f9f9');
        });
    }

});

//Save Teacher Attendance
$(document).on('click', '.single_teacher_attendance_submit', function (event) {
    event.preventDefault();
    var element = $(this);
    var form = $(this).closest('.single_attendance_form');
    teacher_id = form.find('.teacher_id').val();
    attendance_date = form.find('.attendance_date').val();
    attendance_status = form.find('.attendance_status').val();
    $.ajax({
        url: "{{route('attendance.store')}}",
        type: 'POST',
        data: {'teacher_id': teacher_id, 'attendance_date': attendance_date, 'attendance_status': attendance_status, 'attendance_type': 2},
        datType: 'json',
        success: function (data) {

            if (data.valid) {
                element.removeClass('btn-primary').addClass('btn-success');
            } else {
                alert('Please Select Attendance Status');
            }
        }
    });
});

//Save Student Attendance
$(document).on('submit', '.single_attendance_form', function (event) {
    event.preventDefault();
    var form = $(this);
    var element = form.find('.single_student_attendance_submit');
    var form_data = $(this).serialize();

    $.ajax({
        url: "{{route('attendance.store')}}",
        type: 'POST',
        data: form_data,
        datType: 'json',
        success: function (data) {
            if (data.valid) {
                element.removeClass('btn-primary').addClass('btn-success');
            } else {
                alert('Please Select Attendance Status');
            }
        }
    });
});



function take_student_attendance() {
    $('.form_element').empty();
    $('.form_element').load("{{url('get-class-select')}}"+ '/'+1, function (data) {
        $('#date').datepicker({
            format: 'dd-mm-yyyy',
            todayHighlight: true,
            autoclose: true,
            showOnFocus: true
        });
    });
}
$(document).on('change', '#class_id', function () {
    $('#section_id').empty().attr('disabled', 'disabled');
    var class_id = $(this).val();
    $.ajax({
        url: "{{url('get_section_by_class')}}" + '/' + class_id,
        type: 'get',
        success: function (data) {
            if (data.valid) {
                $('#section_id').html(data.html).removeAttr('disabled');

            } else {
                $('#section_id').html(data.html)
            }
        }
    });

});

/*
 * 
 * 
 * Attendance Report
 */

$(document).on('change','#attendance_report_type',function(){
    $('.report_form_element').empty();
    var report_type = $(this).val();
    $('#report_form_element').empty();
    if(report_type ==1){
        get_student_report();
    }else if(report_type ==2){
        get_teacher_report();
    }
});



$('#attendance_report_type_form').submit(function(event){
    event.preventDefault();
    $('#attendance_report_data').empty();
    var form_data = $(this).serialize();
    $.ajax({
        url:"{{url('get-attendance-report')}}",
        type:'post',
        data:form_data,
        success:function(data){
            $('#attendance_report_data').html(data);
            $('[data-toggle="tooltip"]').tooltip();
        }
    });
});

function get_student_report() {
    $('.report_form_element').empty();
    $('.report_form_element').load("{{url('get-class-select')}}"+ '/'+2, function (data) {
        $('#report_date').datepicker({
           format: 'mm-yyyy',
            autoclose: true,
            showOnFocus: true,
            startView: "year", 
            minViewMode: "months"
        });
    });
};


function get_teacher_report(){
    var html = ' <div class="form-group">';
    html += '<label for="date" class="control-label">Date</label>';
    html += '<input name="report_month_year" id="report_month_year" type="text" class="form-control" />';
    html += '</div>';
    html += ' <div class="form-group">';
    html += '<input type="submit" value="Submit" class="report_type_form btn btn-primary" />';
    html += '</div>';
    $('.report_form_element').html(html);
    $('#report_month_year').datepicker({
        format: 'mm-yyyy',
        autoclose: true,
        showOnFocus: true,
        startView: "year", 
        minViewMode: "months"
    });
}

</script>
<!-- /Datatables -->


@endsection