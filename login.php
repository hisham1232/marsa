<?php    
    include('include_headers_login.php');                                 
?>

<body class="fix-header fix-sidebar card-no-border">
    <div class="preloader">
        <!-- <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
        </svg> -->
    </div>
    <section id="wrapper">
        <div class="login-register" style="background-image:url(assets/images/background/login-register.jpg);">
            <div class="login-box card">
                <div class="card-header p-20 m-b-20" style="border-bottom: double; border-color: #28a745">
                    <div>
                        <center><img src="assets/images/logo-text-login.png" alt="homepage" class="dark-logo" />
                        </center>
                    </div>
                </div>
                <div class="card-body">
                    <?php
                        if(isset($_POST['submitLogin'])){
                            $checkLogin = new DbaseManipulation;
                            $username = $checkLogin->cleanString($_POST['s_username']);
                            $password = md5($checkLogin->cleanString($_POST['s_password']));
                            $loginData = $checkLogin->singleReadFullQry("SELECT * FROM users WHERE username = '$username' AND password = '$password'");
                          // echo" SELECT * FROM users WHERE username = '$username' AND password = '$password'";
                           
                            if($checkLogin->totalCount == 0) {
                    ?>
                    <h4 class="box-title m-b-20 p-b-10 text-danger">
                        <center><i class='fa fa-exclamation-triangle'></i> Invalid User Id and/or Password!</center>
                    </h4>
                    <?php            
                            } else {
                                //session_start();
                                $_SESSION['login_id'] = $loginData['id'];
                                $_SESSION['username'] = $loginData['username'];
                                $_SESSION['user_type'] = $loginData['userType'];
                                $_SESSION['status'] = $loginData['status'];
                                if($_SESSION['user_type'] == 0 || $_SESSION['user_type'] == 1 || $_SESSION['user_type'] == 2)
                                    header("Location: index.php");
                                else    
                                    header("Location: index.php");
                            }
                        }
                    ?>
                    <form class="form-horizontal form-material" action="" method="POST" novalidate
                        enctype="multipart/form-data">
                        <h3 class="box-title m-b-20 p-b-10">
                            <center>Sign In</center>
                        </h3>
                        <div class="form-group row">
                            <div class="col-lg-12 col-xs-18">
                                <div class="controls">
                                    <div class="input-group">
                                        <input type="text" name="s_username" class="form-control username"
                                            placeholder="Staff ID" required
                                            data-validation-required-message="Please enter Staff ID">
                                    </div>
                                    <!--end input-group-->
                                </div>
                                <!--end controls-->
                            </div>
                            <!--end col-sm-9-->
                        </div>
                        <!--end form-group row --->

                        <div class="form-group row">
                            <div class="col-lg-12 col-xs-18">
                                <div class="controls">
                                    <div class="input-group">
                                        <input type="password" name="s_password" class="form-control"
                                            placeholder="Password" required
                                            data-validation-required-message="Please enter Password">

                                    </div>
                                    <!--end input-group-->
                                </div>
                                <!--end controls-->
                            </div>
                            <!--end col-sm-9-->
                        </div>
                        <!--end form-group row --->

                        <div class="form-group text-center m-t-20">
                            <div class="col-xs-12">
                                <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light"
                                    name="submitLogin" type="submit"><i class="fa fa-key"></i> Log In</button>
                            </div>
                        </div>

                        <div class="form-group text-center m-t-20">
                            <div class="col-xs-12">
                                <a href="resetPassword.php">Reset Password or creat new password</a>
                            </div>
                        </div>

                    </form>
                    <!--end form application leave form-->


                    <div class="row">
                        <div class="col-lg-12 col-md-12 sub-footer">
                            <p class="text-muted">
                                <small>
                                    Copyright 2020. All Rights Reserved by <a class="text-blue-dark" href="#"><br>
                                        Nizwa College of Technology<br>
                                        E-Service Development Team</a>
                                </small>
                            </p>
                        </div>
                    </div>
                </div>
                <!--end card body-->
            </div>
            <!--end login card-->
        </div>
        <!--end login register-->
    </section>
    <?php include('include_scripts.php'); ?>
    <script>
    $(document).ready(function() {
        $('.username').focus();
    });
    </script>
</body>

</html>