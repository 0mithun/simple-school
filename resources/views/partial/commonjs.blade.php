<script type="text/javascript">

    $(document).ready(function () {
        //$('.dataTables_paginate').removeClass('dataTables_paginate').addClass('pull-right');

        $('.datepicker').datepicker({
            format: 'dd/mm/yyyy',
            todayHighlight: true,
            autoclose: true,
            showOnFocus: true
        });
        
        //tooltip
        $('[data-toggle="tooltip"]').tooltip();


        //Datepicker
        $('#user_date_of_birth').datepicker({
            format: 'dd-mm-yyyy',
            todayHighlight: true,
            autoclose: true,
            showOnFocus: true
        });
        


        $('#userphoto').fileinput({
            'showUpload': false,
            showClose: false,
            allowedFileExtensions: ['jpg', 'gif', 'png']
        });
        
        
        $('#user_photo_form').submit(function(event) {
            event.preventDefault();
            var form = $('#user_photo_form')[0];
            var data = new FormData(form);
            
            user_id = "{{Auth::user()->id}}";
            
            $.ajax({
                url: "{{route('profile.update',null)}}" + '/' + user_id,
                type: 'POST',
                data: data,
                beforeSend: function (xhr) {
                    $('#user_photo_form').find('.help-block').detach();
                    $('#user_photo_form').find('.form-group').removeClass('has-error');
                },
                processData: false, // Important!
                contentType: false,
                cache: false,
                dataType: 'json',
                success: function (resource) {
                    $('#user_photo_form')[0].reset();                         
                    $('#old_user_photo').attr('src',resource.userphoto);
                    get_user_data();
                    swal({
                        type: 'success',
                        title: 'User Photo Update Successfully',
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
                                .append('<span class="help-block error"><strong>' + value + '</strong></span>');
                        });
                    }
                }
            });
            
        });
        
        $('#profile_form').submit(function (event) {
            event.preventDefault();
            
            form_data = $(this).serialize();
            user_id = "{{Auth::user()->id}}";
            
            $.ajax({
                url: "{{route('profile.update',null)}}" + '/' + user_id,
                data: form_data,
                type: 'post',
                beforeSend: function (xhr) {
                    $('#profile_form').find('.help-block').detach();
                    $('#profile_form').find('.form-group').removeClass('has-error');
                },
                dataType: 'json',
                success: function (response) {
                    get_user_data();
                    swal({
                        type: 'success',
                        title: 'Profile Update Successfully',
                        showConfirmButton: false,
                        timer: 2500
                    });
                },
                error: function (error) {
                    var response = error.responseJSON;
                    var errors = response.errors;
                    if ($.isEmptyObject(errors) === false) {
                        $.each(errors, function (key, value) {
                            $('#' + key)
                                .closest('.form-group')
                                .addClass('has-error')
                                .append('<span class="help-block error col-lg-offset-3"><strong>' + value + '</strong></span>');
                        });
                    }//end if
                }//end error
            });//End ajax req
        });//End Form Submit


        $('#user_password_form').submit(function(event) {
            event.preventDefault();
            //alert('clicked');
                form_data = $(this).serialize();
                user_id = "{{Auth::user()->id}}";
                //console.log(form_data);
            $.ajax({
                url: "{{route('profile.update',null)}}" + '/' + user_id,
                data: form_data,
                type: 'post',
                beforeSend: function (xhr) {
                    $('#user_password_form').find('.help-block').detach();
                    $('#user_password_form').find('.form-group').removeClass('has-error');
                },
                dataType: 'json',
                success: function (response) {
                        $('#user_password_form')[0].reset();
                    swal({
                        type: 'success',
                        title: 'Password Update Successfully',
                        showConfirmButton: false,
                        timer: 2500
                    });
                },
                error: function (error) {
                    var response = error.responseJSON;
                    var errors = response.errors;
                    if ($.isEmptyObject(errors) === false) {
                        $.each(errors, function (key, value) {
                            $('#' + key)
                                .closest('.form-group')
                                .addClass('has-error')
                                .append('<span class="help-block error col-lg-offset-3"><strong>' + value + '</strong></span>');
                        });
                    }//end if
                }//end error
            });//End ajax req
            
        });
    });
    
    function get_user_data(){
        $.ajax({
            url: "{{url('profile')}}" + '/' + "{{Auth::user()->id}}",
            type:'get',
            dataType:'json',
            success:function(data){
                //console.log(data);
                $('.loged_in_user_name').text(data.name);
                $('.loged_in_user_photo').attr('src',data.user_photo);
            }
        });
    }
</script>