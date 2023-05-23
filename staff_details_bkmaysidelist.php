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
                    <div class="col-md-5 col-8 align-self-center">
                        <h3 class="text-themecolor m-b-0 m-t-0">Staff Information Details</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">Home</a></li>
                            <li class="breadcrumb-item">Staff Details </li>
                        </ol>
                    </div>
                    <div class="col-md-7 col-4 align-self-center">
                        <div class="d-flex m-t-10 justify-content-end">
                            <div class="d-flex m-r-20 m-l-10 hidden-md-down">
                                <div class="chart-text m-r-10">
                                    <h6 class="m-b-0"><small>September 24,2018</small></h6>
                                    <h6 class="m-b-0"><small>Your Time-In Today</small></h6>
                                    <h4 class="m-t-0 text-primary">08:00am</h4>
                                </div>
                                <div class="spark-chart">
                                    <i class="far fa-clock fa-3x text-primary"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                  <div class="row">
                    <!-- Column -->
                    <div class="col-lg-2 col-xlg-2 col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <center class="m-t-5"> <img src="assets/images/users/avatar3.png" class="img-circle" width="100" alt="Staff Picture" />
                                    <h5 class="card-title m-t-10">Mylyn Nostarez</h5>
                                    <h5 class="card-title m-t-10">Arabic Name</h5>
                                    <h6 class="card-subtitle">ETC Technician</h6>
                                    <h6 class="card-subtitle">Educational Services Section</h6>
                                    <h6 class="card-subtitle">Educational Technologies Centre</h6>
                                    <h6 class="card-subtitle">mylyn.nostarez@nct.edu.om</h6>
                            </center>
                                     <div class="list-group">
                                      <a href="staff_details.php" class="list-group-item list-group-item-success text-left">Staff Information</a>
                                      <a href="staff_employment.php" class="list-group-item list-group-item-success">Employment History</a>
                                      <a href="staff_legal_docs.php" class="list-group-item list-group-item-success">Legal Documents</a>
                                      <a href="staff_qualification.php" class="list-group-item list-group-item-success">Qualification</a>
                                      <a href="staff_work_experience.php" class="list-group-item list-group-item-success">Work Experience</a>
                                      <a href="staff_researches.php" class="list-group-item list-group-item-success">Researches</a>
                                      <a href="staff_contacts.php" class="list-group-item list-group-item-success">Contacts</a>
                                      <a href="staff_family.php" class="list-group-item list-group-item-success">Family Information</a>
                                    </div> 
                            </div><!--end card body-->
                        </div><!--end card-->
                    </div><!--end Column for profile -->
                    <!-- Column -->
                    <div class="col-lg-10 col-xlg-10 col-md-8">
                        
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Staff Information Details</h4>
                                <h6 class="card-subtitle">معلومات الموظف</h6>
                                


                                
                           </div><!--end card body-->
                        </div><!--end card for whole staff Staff Profile-->        
                    </div><!-- Column end col profiles-->
                
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