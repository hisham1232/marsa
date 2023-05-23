<?php include('include_headers.php'); ?>
<style>
* {
    margin: 0;
    padding: 0;
}

html {
    background: url(error-bg.jpg) no-repeat center center fixed;
    -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    background-size: cover;
}
</style>

<body class="fix-header fix-sidebar card-no-border">
    <div class="error-box" style="padding-top: 5% !important;">
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <!---start form div-->
                <div class="card" style="background-color: rgba(250,250,250,0.8) !important;">
                    <div class="card-body">
                        <div class="d-flex flex-wrap">
                            <div style="margin:auto !important;">
                                <h1 class="text-info"
                                    style="font-size: 210px !important; font-weight: 900 !important;line-height: 210px !important; text-align: center !important;">
                                    <center><i class="ti-lock"></i></center>
                                </h1>
                                <h2 class="text-uppercase text-danger">No User Session Found!</h2>
                                <p class="m-t-30 m-b-30">Add Your Text Here</p>
                                <!-- <a href="https://www.nct.edu.om/eservices/index.php" title="Click to Proceed to NCT E-Services Login Page." class="btn btn-info btn-rounded waves-effect waves-light m-b-40">Proceed to NCT E-Services Login page <i class="fa fa-paper-plane"></i></a> -->
                                <a href="login.php" title="Click to Proceed to NCT E-Services Login Page."
                                    class="btn btn-info btn-rounded waves-effect waves-light m-b-40">Proceed to NCT
                                    E-Services Login page <i class="fa fa-paper-plane"></i></a>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
        include('include_scripts.php');
    ?>
</body>

</html>