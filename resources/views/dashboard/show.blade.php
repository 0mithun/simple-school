@extend('master')

@section('stylesheet')
<link href="{{asset('assets')}}/css/fullcalendar.min.css" rel="stylesheet" />
@endsection

@section('content')
<!-- page content -->


<div class="right_col" role="main">
    <!-- top tiles -->
    <div class="row tile_count">
        <div class="col-md-3 col-sm-4 col-xs-6 tile_stats_count">

            <span class="count_top"><i class="fa fa-group"></i> Total Teacher</span>
            <div class="clearfix"></div>
            <input type="text" class="total_teacher" value="{{$total_teacher}}" />
        </div>
        <div class="col-md-3 col-sm-4 col-xs-6 tile_stats_count">

            <span class="count_top"><i class="fa fa-user-plus"></i> Total Student</span>
            <div class="clearfix"></div>
            <input type="text" class="total_student" value="{{$total_student}}" />
        </div>
        <div class="col-md-3 col-sm-4 col-xs-6 tile_stats_count">

            <span class="count_top"><i class="fa fa-th-large"></i> Total Class</span>
            <div class="clearfix"></div>
            <input type="text" class="total_class" value="{{$total_class}}" />
        </div>
        <div class="col-md-3 col-sm-4 col-xs-6 tile_stats_count">

            <span class="count_top"><i class="fa fa-columns"></i> Total Section</span>
            <div class="clearfix"></div>
            <input type="text" class="total_section" value="{{$total_section}}" />
        </div>


    </div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                
                <div class="x_content">
                    <div id="ful_calendar"></div>
                </div>
            </div>
        </div>
    </div>



</div>

<!-- /page content -->
@endsection

@section('script')

<script type="text/javascript" src="{{asset('assets')}}/js/jquery.knob.min.js"></script>

<script src="{{asset('assets')}}/js/full-calendar/moment.min.js"></script>
<script  src="{{asset('assets')}}/js/full-calendar/fullcalendar.min.js"></script>

<script type="text/javascript">
$(document).ready(function () {
    $('.total_teacher').knob({
        "fgColor": "#1ABB9C",
        'height': '200'
    });
    $('.total_student').knob({
        "fgColor": "#86CBDD",
        'height': '200'
    });
    $('.total_class').knob({
        "fgColor": "#6AE76F",
        'height': '200',
        'margin-left':'30'
    });
    $('.total_section').knob({
        "fgColor": "#4584EF",
        'height': '200'
    });

var calendar = $('#ful_calendar').fullCalendar({
        editable:true,
        height:450,
        header:{
            left: 'prev,next,today',
            center:'title',
            right:'month,agendaWeek, agendaDay'
        },
        events:"{{url('get_all_events')}}",
        selectable:true,
        selectHelper:true,
        select:function(start, end, allDay){
            var title = prompt('Enter Your Title');
            if(title){
                var csrf = $('meta[name="csrf-token"]').attr('content');
                var start = $.fullCalendar.formatDate(start, 'Y-MM-DD HH:mm:ss');
                var end = $.fullCalendar.formatDate(end, 'Y-MM-DD HH:mm:ss');
                $.ajax({
                    url:"{{route('dashboard.store')}}",
                    type:'post',
                    data:{'_token':csrf,'title':title,'start':start,'end':end},
                    success:function(){
                       calendar.fullCalendar('refetchEvents');
                       alert('Event Add Successfully');
                    }
                });
            }
        },
        editable:true,
        eventResize:function(event){
            var csrf = $('meta[name="csrf-token"]').attr('content');
            var start = $.fullCalendar.formatDate(event.start, 'Y-MM-DD HH:mm:ss');
            var end = $.fullCalendar.formatDate(event.end, 'Y-MM-DD HH:mm:ss');
            var title = event.title;
            var event_id = event.event_id;
            
            $.ajax({
                url: "{{route('dashboard.update',null)}}" + '/' + event_id,
                type:'post',
                data:{'_token':csrf,'title':title,'start':start,'end':end,'_method':'PUT'},
                success:function(){
                    calendar.fullCalendar('refetchEvents');
                       alert('Event Update Successfully');
                }
            });
        },
        eventDrop:function(event){
             var csrf = $('meta[name="csrf-token"]').attr('content');
            var start = $.fullCalendar.formatDate(event.start, 'Y-MM-DD HH:mm:ss');
            var end = $.fullCalendar.formatDate(event.end, 'Y-MM-DD HH:mm:ss');
            var title = event.title;
            var event_id = event.event_id;
            
            $.ajax({
                url: "{{route('dashboard.update',null)}}" + '/' + event_id,
                type:'post',
                data:{'_token':csrf,'title':title,'start':start,'end':end,'_method':'PUT'},
                success:function(){
                    calendar.fullCalendar('refetchEvents');
                       alert('Event Update Successfully');
                }
            });
        },
        eventClick:function(event){
            if(confirm('Are you sure want to remove it?')){
               var event_id = event.event_id;
               var csrf = $('meta[name="csrf-token"]').attr('content');
               $.ajax({
                   url:"{{route('dashboard.destroy',null)}}" + '/'+ event_id,
                   type:'post',
                   data: {'_method': 'DELETE', '_token': csrf},
                   success:function(){
                       calendar.fullCalendar('refetchEvents');
                       alert('Event Remove Successfully');
                   }
               });
            }
        }
    });
});

</script>






@endsection