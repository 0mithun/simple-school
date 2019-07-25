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

                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="col-lg-9">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Application Information </h3>
                                </div>
                                <div class="panel-body">
                                    <form class="form-horizontal" id="app_setup_form">
                                        {{csrf_field() }}
                                        {{method_field('PUT') }}
                                        <div class="form-group">
                                            <label class="control-label col-lg-4" for="app_title">Application Title:</label>
                                            <div class="col-lg-8">
                                                <input type="text" name="app_title" id="app_title" autofocus class="form-control" value="{{ $app_setup->app_title}}" />
                                             </div>
                                        </div>
                                        <br>
                                        <div class="form-group">
                                            <label class="control-label col-lg-4" for="app_description">Application Description:</label>
                                            <div class="col-lg-8">
                                                <textarea class="form-control" id="app_description" name="app_description" cols="" rows="10">{{$app_setup->app_description}}</textarea>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="form-group">
                                            <label class="control-label col-lg-4" for="copyright_title">Copyright Title:</label>
                                            <div class="col-lg-8">
                                                <input type="text" name="copyright_title" id="copyright_title" class="form-control" value="{{$app_setup->copyright_title}}"  />
                                            </div>
                                        </div>
                                        <br>
                                        <div class="form-group">
                                            <div class="col-lg-8 col-lg-offset-4">
                                                <input type="submit"  class="btn btn-primary" value='Save'/>
                                                <input type="reset"  class="btn btn-danger"/>
                                                
                                            </div>
                                        </div>
                                    </form>
                                   
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Application Logo</h3>
                                </div>
                                <div class="panel-body">
                                    <form class="form-horizontal" method="" action=""  enctype="multipart/form-data" id="app_logo_form">
                                        {{ csrf_field() }}
                                         <div class="form-group">
                                            <div class="form-group">
                                                <label class="control-label col-lg-2" for="edit_logo">Photo</label> 
                                                <div class="col-lg-10">
                                                    <input type="file" id="edit_logo" name="edit_logo" class=""/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-lg-9 col-lg-offset-3">
                                                    <button type="submit" class="btn btn-primary">Update Logo</button>
                                                </div>
                                            </div>
                                    </form>
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


<!--<script src="{{asset('assets')}}/build/js/custom.min.js"></script>-->




<!-- Datatables -->
<script>
$(document).ready(function() {
    var old_logo = "{{ $app_setup->app_logo }}"


    $('#edit_logo').fileinput({
    overwriteInitial: true,
    maxFileSize: 1500,
    showClose: false,
    showCaption: false,
    showBrowse: false,
    browseOnZoneClick: true,
    removeLabel: '',
    removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
    removeTitle: 'Cancel or reset changes',
    elErrorContainer: '#kv-avatar-errors-2',
    msgErrorClass: 'alert alert-block alert-danger',
    defaultPreviewContent: '<img id="old_logo" src="{{ $app_setup->app_logo }}" alt="Your Avatar" style="width:208px;height:200px;"><h6 class="text-muted">Click to select</h6>',
    
    layoutTemplates: {main2: '{preview} {remove} {browse}'}
    });
});


function app_setup_data(){
    $.ajax({
        url: "{{route('app-setup.show',null)}}" + '/' + 1,
        type:'get',
        success:function(data){
            $('#old_logo').attr('src',data.app_logo);
            $('.app_logo').attr('src',data.app_logo);
        }
    });
}


$('#app_logo_form').submit(function (event) {
    event.preventDefault();
    var form = $('#app_logo_form')[0];
    var data = new FormData(form);
    $.ajax({
        url: "{{url('app-logo-update')}}",
        type: 'POST',
        data: data,
        beforeSend: function (xhr) {
            $('#app_logo_form').find('.help-block').detach();
            $('#app_logo_form').find('.form-group').removeClass('has-error');
        },
        processData: false, // Important!
        contentType: false,
        cache: false,
        dataType: 'json',
        success: function (resource) {
            console.log(resource);
            $('#app_logo_form')[0].reset();
            app_setup_data();
            swal({
                type: 'success',
                title: 'Application Logo Update Successfully',
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
                        .append('<span class="help-block error col-lg-offset-2"><strong>' + value + '</strong></span>');
                });
            }
        }
    });
});











$('#app_setup_form').submit(function(event) {
    event.preventDefault();
    var form_data = $(this).serialize();
    $.ajax({
        url: "{{route('app-setup.update',null)}}" + '/' + 1,
        type:'post',
        data:form_data,
        beforeSend: function (xhr) {
           $('#app_setup_form').find('.help-block').detach();
           $('#app_setup_form').find('.form-group').removeClass('has-error');             
        },
        dataType:'json',
        success:function(data){
            swal({
                type: 'success',
                title: 'Application Information Update Successfully',
                showConfirmButton: false,
                timer: 1500
            });
        },error:function(data){
            response  = data.responseJSON;
            errors = response.errors;
            if($.isEmptyObject(errors) == false){
                $.each(errors,function(key, value) {
                   $('#'+key)
                        .closest('.form-group')
                        .addClass('has-error')
                        .append('<span class="help-block error col-lg-offset-4"><strong>' + value + '</strong></span>');
                              
                });
            }
        }
    });
});


</script>
<!-- /Datatables -->


@endsection