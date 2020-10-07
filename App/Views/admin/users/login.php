<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Log in</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="<?php echo assets('admin/css/bootstrap.min.css')?>">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo assets('admin/css/font-awesome.min.css')?>">
    <!-- Ionicons -->
    <link rel="stylesheet" href="<?php echo assets('admin/css/ionicons.min.css')?>">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo assets('admin/css/AdminLTE.min.css')?>">
    <!-- iCheck -->
    <link rel="stylesheet" href="<?php echo assets('admin/css/blue.css')?>">

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <h1>Login Form</h1>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">Sign in to start your session</p>

        <form action="<?php echo url('admin/login/submit');?>" method="post" id="login-form">
            <div style="font-weight: bold" id="login-results">
            </div>
            <div class="form-group has-feedback">
                <input name="email" type="email" class="form-control" placeholder="Email" required>
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input name="password" type="password" class="form-control" placeholder="Password" required>
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="row">
                <div class="col-xs-8">
                    <label>
                        <input type="checkbox" name="remember"> Remember Me
                    </label>
                </div>
                <!-- /.col -->
                <div class="col-xs-4">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
                </div>
                <!-- /.col -->
            </div>
        </form>
    </div>
    <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="<?php echo assets('admin/js/jquery.min.js')?>"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo assets('admin/js/bootstrap.min.js')?>"></script>
<!-- iCheck -->
<script src="<?php echo assets('admin/js/icheck.min.js')?>"></script>

<script>
    $(function (){
        loginResults = $('#login-results');
        var flag = false;
        $('#login-form').on('submit' , function (e){
            e.preventDefault();
            if(flag === true){
                return false;
            }
            form = $(this);
            requestUrl = form.attr('action');
            requestMethod = form.attr('method');
            requestData = form.serialize();

            $.ajax({
                url : requestUrl,
                dataType : 'JSON',
                method : requestMethod,
                data : requestData,
                beforeSending : function (){
                    flag = true;
                    $('button').attr('disabled' , true);
                    loginResults.removeClass().addClass('alert alert-info').html('Logging...');
                },
                success : function (results) {
                    if(results.errors){
                        loginResults.removeClass().addClass('alert alert-danger').html('');
                        for(i =0 ; i < results.errors.length ; i++){
                            loginResults.append('<li>'+results.errors[i]+'</li>')
                        }
                        $('button').removeAttr('disabled');
                        flag = false;
                    } else if(results.success){
                        loginResults.removeClass().addClass('alert alert-success').html(results.success);
                        if(results.redirect){
                            window.location.href = results.redirect;
                        }
                    }
                }
            });
        });
    });
</script>
</body>
</html>
