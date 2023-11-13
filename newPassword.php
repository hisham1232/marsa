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
                    
                   
                        if(isset($_GET['token'])){
                            $checkLogin = new DbaseManipulation;
                            $token = $checkLogin->cleanString($_GET['token']);
                            // $password = md5($checkLogin->cleanString($_POST['s_password']));
                            $loginData = $checkLogin->singleReadFullQry("SELECT [username] FROM [dbhr3].[dbo].[users] where token='$token'  ");
                            
                            //echo "SELECT [username] FROM [dbhr3].[dbo].[users] where token='$token'  ";
                            if($checkLogin->totalCount == 0) {
                                header("Location: resetPassword.php?massage=false");
                             } 
                             else{
                               // print_r($loginData);
                             }
                             
                        }
                        else {
                            echo "false";   }

                            if(isset($_POST['submitLogin'])){
                               // echo "HI";
                                $checkLogin = new DbaseManipulation;
                                $staff_id = $loginData['username'];
                                 if($_POST['Password']==$_POST['Password2']){
                                $password = md5($checkLogin->cleanString($_POST['Password']));
                                $checkLogin->executeSQL("UPDATE [users] SET [password] = '$password' WHERE username = $staff_id");
                               
                                $token = md5(rand());
                                
                               $checkLogin->executeSQL("UPDATE [users] SET [token] = '$token' WHERE username = $staff_id");

                                header("Location: login.php");
                            
                            }
                                 else{
                                        // echo "Passwords do not match";

                                 }
                            
                            }
                            else {                          

                            }
                    ?>
                    <form class="form-horizontal form-material" action="" method="POST" novalidate
                        enctype="multipart/form-data">
                        <h3 class="box-title m-b-20 p-b-10">
                            <center>Reset Password </center>
                        </h3>

                        <div class="form-group row">
                            <div class="col-lg-12 col-xs-18">
                                <div class="controls">
                                    <div class="input-group">
                                        <input type="Password" id="Password" name="Password"
                                            class="form-control username" placeholder="New Password" required
                                            data-validation-required-message="Please enter Staff Password" minlength="8"
                                            required>
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
                                        <input type="Password" id="Password2" name="Password2" class="form-control "
                                            placeholder="Password" required
                                            data-validation-required-message="Passwords did not match"
                                            onKeyUp="validation();"><span id="errfn"></span>
                                    </div>
                                    <!--end input-group-->
                                </div>
                                <!--end controls-->
                            </div>
                            <!--end col-sm-9-->
                        </div>


                        <div class="form-group text-center m-t-20">
                            <div class="col-xs-12">
                                <button id="button"
                                    class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light"
                                    name="submitLogin" type="submit"><i class="fa fa-key"></i>Save Password</button>
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
    var pw1 = document.getElementById("Password");
    var pw2 = document.getElementById("Password2");
    var button = document.getElementById("button");
    $(document).ready(function() {
        $('.username').focus();
        button.disabled = true;
        button.innerHTML = "Passwords did not match";
    });





    function validation() {
        var pw1 = document.getElementById("Password");
        var pw2 = document.getElementById("Password2");
        var button = document.getElementById("button");

        if (pw1.value != pw2.value) {
            document.getElementById('errfn').innerHTML = "<p style='color:red;'>Passwords did not match</p>";
            button.disabled = true;
            button.innerHTML = "Passwords did not match";
        } else {
            document.getElementById('errfn').innerHTML = "";
            button.disabled = false;
            button.innerHTML = "Save Password";

        }


    }
    </script>
</body>

</html>