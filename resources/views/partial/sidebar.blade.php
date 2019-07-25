<!-- sidebar menu -->
<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
    <div class="menu_section">
        <h3>General</h3>
        <ul class="nav side-menu">

            <li><a href="{{route('teacher.index')}}"><i class="fa fa-group"></i> Manage Teacher</a></li>
            <li><a href="{{route('class.index')}}"><i class="fa fa-th-large"></i>Manage Class</a></li>
            <li><a href="{{route('section.index')}}"><i class="fa fa-columns"></i> Manage Section</a></li>
            <li><a href="{{route('subject.index')}}"><i class="fa fa-th-list"></i>Manage Subject</a></li>
            <li><a href="{{route('student.index')}}"><i class="fa fa-user-times"></i>Manage Student</a></li>

            <li><a href="{{route('attendance.index')}}"><i class="fa fa-check-square-o"></i>Manage Attendance</a></li>
            
            <li><a href="#"><i class="fa fa-university"></i> Exam <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="{{route('exam.index')}}"><i class="fa fa-edit"></i>Manage Exam</a></li>
                    <li><a href="{{route('mark.index')}}"><i class="fa fa-cogs"></i> Exam Mark Setting</a></li>
                </ul>
            </li>
            <li><a href="#"><i class="fa fa-table"></i>  Result <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="{{route('result.index')}}"><i class="fa fa-edit"></i> Result Entry</a></li>
                    <li><a href="{{URL::to('view-result')}}"><i class="fa fa-eye"></i>Student Result</a></li>
                    <li><a href="{{route('result-setting.store')}}"><i class="fa fa-cogs"></i> Result Setting</a></li>
                </ul>
            </li>
            <li><a href="{{route('app-setup.index')}}"><i class="fa fa-gear"></i>General Settings</a></li>
        </ul>
    </div>
</div>