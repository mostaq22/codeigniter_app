<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!DOCTYPE html>
<html>


<!-- Mirrored from webapplayers.com/inspinia_admin-v2.2/login.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 24 Aug 2015 11:31:27 GMT -->
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>INSPINIA | Login</title>

    <link href="<?=base_url()?>resource/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?=base_url()?>resource/font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="<?=base_url()?>resource/css/animate.css" rel="stylesheet">
    <link href="<?=base_url()?>resource/css/style.css" rel="stylesheet">

</head>

<body class="gray-bg">
    <div class="wrapper wrapper-content  animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <?= $this->session->flashdata('message');?>
            </div>  
        </div>
    </div>
    <div class="middle-box text-center loginscreen animated fadeInDown">
        <div>
            <div>

                <h1 class="logo-name">CP+</h1>

            </div>
            <h3>Welcome to CP+</h3>
            
            <p>Login in. To see it in action.</p>

            <!-- Helper Function Called -->
            <?=form_open('login_verification',['class'=>'m-t','role'=>'form'])?>            
                <div class="form-group">
                    <input type="text" name="email" class="form-control" placeholder="Email" required="">                    
                </div>
                <div class="form-group">
                    <input type="password" name="password" class="form-control" placeholder="Password" required="">
                </div>
                <button type="submit" class="btn btn-primary block full-width m-b">Login</button>

                <a href="#"><small>Forgot password?</small></a>
                <p class="text-muted text-center"><small>Do not have an account?</small></p>
                <a class="btn btn-sm btn-white btn-block" href="register.html">Create an account</a>            
            <?=form_close()?>
            <p class="m-t"> <small>CP+ codeigniter framework base on Bootstrap 3 &copy; 2014</small> </p>
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="<?=base_url()?>resource/js/jquery-2.1.1.js"></script>
    <script src="<?=base_url()?>resource/js/bootstrap.min.js"></script>

</body>


<!-- Mirrored from webapplayers.com/inspinia_admin-v2.2/login.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 24 Aug 2015 11:31:27 GMT -->
</html>
