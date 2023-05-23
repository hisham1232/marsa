<?php    
    include('include_headers.php');
    if(!$helper->isUserLogged()) {
        include_once('not_allowed.php');
    } else {
        $allowed = $helper->isAllowed('SuperAdmin');
        if($allowed){                                 
?>  
            <body class="fix-header fix-sidebar card-no-border">
                <div class="preloader">
                    <svg class="circular" viewBox="25 25 50 50">
                        <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
                    </svg>
                </div>
                <div id="main-wrapper">
                    <header class="topbar">
                    <?php include('menu_top.php'); ?>   
                    </header>
                    <?php include('menu_left.php'); ?>
                    <div class="page-wrapper">
                        <div class="container-fluid">
                            <div class="row page-titles">
                                <div class="col-md-5 col-8 align-self-center">
                                    <h3 class="text-themecolor m-b-0 m-t-0">File Maintenance</h3>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">Home</a></li>
                                        <li class="breadcrumb-item">File Maintenance</li>
                                        <li class="breadcrumb-item">Commands</li>
                                    </ol>
                                </div>
                                <?php include('include_time_in_info.php'); ?>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex flex-wrap">
                                                <div>
                                                    <h3 class="card-title">Commands</h3>
                                                    <h6 class="card-subtitle">الأوامر</h6> 
                                                </div>
                                            </div>
                                            <?php 
                                                if(isset($_POST['submit'])) {
                                                    $sql = $_POST['query'];
                                                    echo $sql;
                                                    if($helper->executeSQL($sql)) {
                                                        ?>            
                                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                            <h4 class="alert-heading"><i class="fa fa-info-circle"></i> Success!</h4>
                                                            <p>Command has been executed successfully.</p>
                                                        </div>
                                                        <?php
                                                    } 
                                                }
                                            ?>
                                            <form class="form-horizontal p-t-20" action="" method="POST" novalidate enctype="multipart/form-data">
                                                <div class="form-group row">
                                                    <label for="exampleInputuname3" class="col-sm-3 control-label"></label>
                                                    <div class="col-sm-12">
                                                        <div class="controls">
                                                            <div class="input-group">
                                                                <input type="text" name="query" class="form-control" required data-validation-required-message="Please don't leave the text box as blank." /> 
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row m-b-0">
                                                    <div class="col-sm-12">
                                                        <button type="submit" name="submit" class="btn btn-info waves-effect waves-light"><i class="fa fa-paper-plane"></i> Submit</button>
                                                        <a href="" class="btn btn-inverse waves-effect waves-light"><i class="fa fa-retweet"></i> Reset</a>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                
                            </div><!--end row-->
                        </div>            
                        <footer class="footer">
                            <?php
                                include('include_footer.php'); 
                            ?>
                        </footer>
                    </div>
                </div>
                <?php include('include_scripts.php'); ?>
            </body>
<?php
        } else {
            include_once('not_allowed.php');
        }
    }
?>
</html>