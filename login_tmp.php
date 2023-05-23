<?php    
    include('include_headers.php');                                 
?>
<body class="fix-header fix-sidebar card-no-border">
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
    </div>

    <section id="wrapper">
        <div class="login-register" style="background-image:url(assets/images/background/login-register.jpg);">
            <div class="login-box card">
                <div class="card-header p-20" style="border-bottom: double; border-color: #28a745">
                      <div>
                        
                         <center><img src="assets/images/logo-text-login.png" alt="homepage" class="dark-logo" /></center>
                         
                        </div>
                </div>
                <div class="card-body">
                    <form class="form-horizontal form-material"  action="" method="POST" novalidate enctype="multipart/form-data">
                        <h3 class="box-title m-b-20">Sign In</h3>

                                                    <div class="form-group row">
                                                        <div class="col-lg-12 col-xs-18">
                                                            <div class="controls">
                                                                <div class="input-group">
                                                                    <input type="text" name="f_staffid" class="form-control" placeholder="Staff ID" required data-validation-required-message="Please enter Staff ID"> 
                                                                   
                                                                </div><!--end input-group-->
                                                            </div><!--end controls-->
                                                        </div><!--end col-sm-9-->
                                                    </div><!--end form-group row --->


                                                      <div class="form-group row">
                                                        <div class="col-lg-12 col-xs-18">
                                                            <div class="controls">
                                                                <div class="input-group">
                                                                    <input type="text" name="f_password" class="form-control" placeholder="Password" required data-validation-required-message="Please enter Password"> 
                                                                   
                                                                </div><!--end input-group-->
                                                            </div><!--end controls-->
                                                        </div><!--end col-sm-9-->
                                                    </div><!--end form-group row --->

                                                    <div class="form-group text-center m-t-20">
                            <div class="col-xs-12">
                                <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Log In</button>
                            </div>


                        </div>    

                            <div class="row">   
        <div class="col-lg-12 col-md-12 sub-footer">
            
            <p class="text-muted"><small>
            Copyright 2018. All Rights Reserved by <a class="text-blue-dark" href="#"><br>
            Nizwa College of Technology<br>
            E-Service Development Team</a>
        </small>
        
            </p>
        </div>
    </div>


                        
                       </form><!--end form application leave form-->





                </div><!--end card body-->
            </div><!--end login card-->
        </div><!--end login register-->
    </section>
    <p>&nbsp;</p>
                        <p>&nbsp;</p>

    <?php include('include_scripts.php'); ?>  

</body>
</html>