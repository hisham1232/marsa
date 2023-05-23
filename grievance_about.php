<?php    
    include('include_headers.php');                                 
?>  
<body class="fix-header fix-sidebar card-no-border">
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
    </div>
    <div id="main-wrapper">
        <header class="topbar">
         <?php    include('menu_top.php'); ?>   
        </header>
        <?php   include('menu_left.php'); ?>
        <div class="page-wrapper">
            <div class="container-fluid">
                <div class="row page-titles">
                    <div class="col-md-5 col-xs-18 align-self-center">
                        <h3 class="text-themecolor m-b-0 m-t-0">About Staff Grievance</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">Home</a></li>
                            <li class="breadcrumb-item">Grievance  </li>
                            <li class="breadcrumb-item">About Staff Grievance</li>
                        </ol>
                    </div>
                    <?php include('include_time_in_info.php'); ?>
                </div>



                <div class="row"><!--for result-->
                    <div class="col-lg-12 col-md-18 col-xs-18"><!---start for list div-->
                        <div class="card bg-light-warning2">
                            <div class="card-header bg-light-warning2" style="border-bottom: double; border-color: #28a745">
                                <h4 class="card-title">About Staff Grievance</h4>
                                
                            </div><!--end card header-->
                            <div class="card-body">
                                <iframe src="attachments/grievance/grievance.pdf" width="100%" height="800px"></iframe>
                            </div><!--end card body-->
                        </div><!--end card-->            
                    </div><!--end col-lg-6-->
                </div><!--end row-->
            </div>            
            <footer class="footer">
                <?php
                    include('include_footer.php'); 
                ?>
            </footer>
        </div>
    </div>
    <?php
        include('include_scripts.php');
    ?>
</body>
</html>