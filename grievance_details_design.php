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
        <?php include('menu_top.php'); ?>   
        </header>
        <?php include('menu_left.php'); ?>
        <div class="page-wrapper">
            <div class="container-fluid">
                <div class="row page-titles">
                    <div class="col-md-5 col-xs-18 align-self-center">
                        <h3 class="text-themecolor m-b-0 m-t-0">Grievance Application Details</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item">Staff Grievance</li>
                            <li class="breadcrumb-item">Grievance Details</li>
                        </ol>
                    </div>
                    <?php include('include_time_in_info.php'); ?>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card "><!-- card-outline-success-->
                             <div class="card-header bg-light-warning3 p-t-5 p-b-0 m-t-0 m-b-0">
                                <div class="row">
                                   <div class="col-12">
                                        <div class="d-flex flex-wrap">
                                            <div><h3 class="card-title">Staff Grievance Form</h3></div>
                                            <div class="ml-auto">
                                                <ul class="list-inline">
                                                    <li><h6>Grievance ID [<span class="font-weight-bold">123</span>] </h6></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                </div><!--end row-->

                            </div><!--end card-header-->

                            <div class="card-body bg-light-warning2">
                                <div class="row">
                                    <div class="col-lg-6"><!---start about Details of Staff Giving Complaint div-->
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="d-flex flex-wrap">
                                                    <div>
                                                        <h3 class="card-title">Details of Staff Giving Complaint</h3>
                                                        <h6 class="card-subtitle">Arabic Text Here</h6>
                                                    </div>
                                                </div>
                                                <form class="form-horizontal" action="" method="POST" novalidate enctype="multipart/form-data">
                                                    <div class="form-group row m-b-5 m-t-0">
                                                        <label  class="col-sm-3 control-label">Staff ID Name</label>
                                                        <div class="col-sm-9">
                                                            <div class="controls">
                                                                <div class="input-group">
                                                                    <input type="text" name="" class="form-control" readonly value="123456-Khamis Sulaiman Hamood Al-khusaibi"> 
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text" id="basic-addon2">
                                                                            <i class="fas fa-user"></i>
                                                                        </span>
                                                                    </div><!--end input-group-prepend-->
                                                                </div><!--end input-group-->
                                                            </div><!--end controls-->
                                                        </div><!--end col-sm-9-->
                                                    </div><!--end form-group row --->

                                                    <div class="form-group row m-b-5 m-t-0">
                                                        <label  class="col-sm-3 control-label">Department</label>
                                                        <div class="col-sm-9">
                                                            <div class="controls">
                                                                <div class="input-group">
                                                                    <input type="text" name="" class="form-control" readonly value="Housing, Student Activities and Graduation"> 
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text" id="basic-addon2">
                                                                            <i class="fas fa-briefcase"></i>
                                                                        </span>
                                                                    </div><!--end input-group-prepend-->
                                                                </div><!--end input-group-->
                                                            </div><!--end controls-->
                                                        </div><!--end col-sm-9-->
                                                    </div><!--end form-group row --->

                                                    <div class="form-group row m-b-5 m-t-0">
                                                        <label  class="col-sm-3 control-label">Section</label>
                                                        <div class="col-sm-9">
                                                            <div class="controls">
                                                                <div class="input-group">
                                                                    <input type="text" name="" class="form-control" readonly value="Housing, Student Activities and Graduation (No Section)"> 
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text" id="basic-addon2">
                                                                            <i class="fas fa-suitcase"></i>
                                                                        </span>
                                                                    </div><!--end input-group-prepend-->
                                                                </div><!--end input-group-->
                                                            </div><!--end controls-->
                                                        </div><!--end col-sm-9-->
                                                    </div><!--end form-group row --->

                                                    <div class="form-group row m-b-5 m-t-0">
                                                        <label  class="col-sm-3 control-label">Job Title</label>
                                                        <div class="col-sm-9">
                                                            <div class="controls">
                                                                <div class="input-group">
                                                                    <input type="text" name="" class="form-control" readonly value="Act. HoD Housing, Student Activities "> 
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text" id="basic-addon2">
                                                                            <i class="far fa-credit-card"></i>
                                                                        </span>
                                                                    </div><!--end input-group-prepend-->
                                                                </div><!--end input-group-->
                                                            </div><!--end controls-->
                                                        </div><!--end col-sm-9-->
                                                    </div><!--end form-group row --->

                                                    

                                                     <div class="form-group row m-b-5 m-t-0">
                                                        <label  class="col-sm-3 control-label">Sponsor</label>
                                                        <div class="col-sm-9">
                                                            <div class="controls">
                                                                <div class="input-group">
                                                                    <input type="text" name="" class="form-control" readonly value="Ministry Of Manpower"> 
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text" id="basic-addon2">
                                                                            <i class="fas fa-tags"></i>
                                                                        </span>
                                                                    </div><!--end input-group-prepend-->
                                                                </div><!--end input-group-->
                                                            </div><!--end controls-->
                                                        </div><!--end col-sm-9-->
                                                    </div><!--end form-group row --->

                                                    <div class="form-group row m-b-5 m-t-0">
                                                        <label  class="col-sm-3 control-label">GSM</label>
                                                        <div class="col-sm-9">
                                                            <div class="controls">
                                                                <div class="input-group">
                                                                    <input type="text" name="" class="form-control" readonly value="12345678"> 
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text" id="basic-addon2">
                                                                            <i class="fas fa-phone"></i>
                                                                        </span>
                                                                    </div><!--end input-group-prepend-->
                                                                </div><!--end input-group-->
                                                            </div><!--end controls-->
                                                        </div><!--end col-sm-9-->
                                                    </div><!--end form-group row --->


                                                    <div class="form-group row m-b-5 m-t-0">
                                                        <label  class="col-sm-3 control-label">Email</label>
                                                        <div class="col-sm-9">
                                                            <div class="controls">
                                                                <div class="input-group">
                                                                    <input type="text" name="" class="form-control" readonly value="ismail.alriyami@nct.edu.om"> 
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text" id="basic-addon2">
                                                                            <i class="fas fa-envelope-open"></i>
                                                                        </span>
                                                                    </div><!--end input-group-prepend-->
                                                                </div><!--end input-group-->
                                                            </div><!--end controls-->
                                                        </div><!--end col-sm-9-->
                                                    </div><!--end form-group row --->

                                                </form><!--end form Complainant-->
                                            </div><!--end card body form-->
                                        </div><!--end card form-->
                                    </div><!--end col6 for Complainant-->

                                    <!---------------------------------------------------------------------------------------------------------->
                                    <!---------------------------------------------------------------------------------------------------------->

                                    <div class="col-lg-6"><!---start about Details of Staff Giving Complaint div-->
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="d-flex flex-wrap">
                                                    <div>
                                                        <h3 class="card-title">Complaint Given Against</h3>
                                                        <h6 class="card-subtitle">Arabic Text Here</h6>
                                                    </div>
                                                </div>
                                                <form class="form-horizontal" action="" method="POST" novalidate enctype="multipart/form-data">
                                                    <div class="form-group row m-b-5 m-t-0">
                                                        <label  class="col-sm-3 control-label">Staff ID Name</label>
                                                        <div class="col-sm-9">
                                                            <div class="controls">
                                                                <div class="input-group">
                                                                    <input type="text" name="" class="form-control" readonly value="123456-Khamis Sulaiman Hamood Al-khusaibi"> 
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text" id="basic-addon2">
                                                                            <i class="fas fa-user"></i>
                                                                        </span>
                                                                    </div><!--end input-group-prepend-->
                                                                </div><!--end input-group-->
                                                            </div><!--end controls-->
                                                        </div><!--end col-sm-9-->
                                                    </div><!--end form-group row --->

                                                    <div class="form-group row m-b-5 m-t-0">
                                                        <label  class="col-sm-3 control-label">Department</label>
                                                        <div class="col-sm-9">
                                                            <div class="controls">
                                                                <div class="input-group">
                                                                    <input type="text" name="" class="form-control" readonly value="Housing, Student Activities and Graduation"> 
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text" id="basic-addon2">
                                                                            <i class="fas fa-briefcase"></i>
                                                                        </span>
                                                                    </div><!--end input-group-prepend-->
                                                                </div><!--end input-group-->
                                                            </div><!--end controls-->
                                                        </div><!--end col-sm-9-->
                                                    </div><!--end form-group row --->

                                                    <div class="form-group row m-b-5 m-t-0">
                                                        <label  class="col-sm-3 control-label">Section</label>
                                                        <div class="col-sm-9">
                                                            <div class="controls">
                                                                <div class="input-group">
                                                                    <input type="text" name="" class="form-control" readonly value="Housing, Student Activities and Graduation (No Section)"> 
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text" id="basic-addon2">
                                                                            <i class="fas fa-suitcase"></i>
                                                                        </span>
                                                                    </div><!--end input-group-prepend-->
                                                                </div><!--end input-group-->
                                                            </div><!--end controls-->
                                                        </div><!--end col-sm-9-->
                                                    </div><!--end form-group row --->

                                                    <div class="form-group row m-b-5 m-t-0">
                                                        <label  class="col-sm-3 control-label">Job Title</label>
                                                        <div class="col-sm-9">
                                                            <div class="controls">
                                                                <div class="input-group">
                                                                    <input type="text" name="" class="form-control" readonly value="Act. HoD Housing, Student Activities "> 
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text" id="basic-addon2">
                                                                            <i class="far fa-credit-card"></i>
                                                                        </span>
                                                                    </div><!--end input-group-prepend-->
                                                                </div><!--end input-group-->
                                                            </div><!--end controls-->
                                                        </div><!--end col-sm-9-->
                                                    </div><!--end form-group row --->

                                                    

                                                     <div class="form-group row m-b-5 m-t-0">
                                                        <label  class="col-sm-3 control-label">Sponsor</label>
                                                        <div class="col-sm-9">
                                                            <div class="controls">
                                                                <div class="input-group">
                                                                    <input type="text" name="" class="form-control" readonly value="Ministry Of Manpower"> 
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text" id="basic-addon2">
                                                                            <i class="fas fa-tags"></i>
                                                                        </span>
                                                                    </div><!--end input-group-prepend-->
                                                                </div><!--end input-group-->
                                                            </div><!--end controls-->
                                                        </div><!--end col-sm-9-->
                                                    </div><!--end form-group row --->

                                                    <div class="form-group row m-b-5 m-t-0">
                                                        <label  class="col-sm-3 control-label">GSM</label>
                                                        <div class="col-sm-9">
                                                            <div class="controls">
                                                                <div class="input-group">
                                                                    <input type="text" name="" class="form-control" readonly value="12345678"> 
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text" id="basic-addon2">
                                                                            <i class="fas fa-phone"></i>
                                                                        </span>
                                                                    </div><!--end input-group-prepend-->
                                                                </div><!--end input-group-->
                                                            </div><!--end controls-->
                                                        </div><!--end col-sm-9-->
                                                    </div><!--end form-group row --->


                                                    <div class="form-group row m-b-5 m-t-0">
                                                        <label  class="col-sm-3 control-label">Email</label>
                                                        <div class="col-sm-9">
                                                            <div class="controls">
                                                                <div class="input-group">
                                                                    <input type="text" name="" class="form-control" readonly value="ismail.alriyami@nct.edu.om"> 
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text" id="basic-addon2">
                                                                            <i class="fas fa-envelope-open"></i>
                                                                        </span>
                                                                    </div><!--end input-group-prepend-->
                                                                </div><!--end input-group-->
                                                            </div><!--end controls-->
                                                        </div><!--end col-sm-9-->
                                                    </div><!--end form-group row --->
                                                </form><!--end form Complaint given Against-->
                                            </div><!--end card body form-->
                                        </div><!--end card form-->
                                    </div><!--end col6 for Complaint given Against-->
                                </div><!--end row for whole about form-->

                                <div class="row">
                                    <div class="col-lg-12"><!---start about Details of Staff Giving Complaint div-->
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="d-flex flex-wrap">
                                                    <div>
                                                        <h3 class="card-title">Details of Complaint</h3>
                                                        <h6 class="card-subtitle">Arabic Text Here</h6>
                                                    </div>
                                                </div>
                                                <form class="form-horizontal" action="" method="POST" novalidate enctype="multipart/form-data">
                                                    <div class="form-group row m-b-5 m-t-0">
                                                        <label  class="col-sm-2 control-label">Date/Time</label>
                                                        <div class="col-sm-4">
                                                            <div class="controls">
                                                                    <input type="text" name="" class="form-control text-form-data-blue" readonly value="December 30,2019"> 
                                                                
                                                            </div><!--end controls-->
                                                        </div><!--end col-sm-9-->

                                                        <label  class="col-sm-2 control-label">Academic Year & Semester</label>
                                                        <div class="col-sm-4">
                                                            <div class="controls">
                                                                    <input type="text" name="" class="form-control text-form-data-blue" readonly value="2019-2020 [Semester 1]"> 
                                                                
                                                            </div><!--end controls-->
                                                        </div><!--end col-sm-9-->
                                                    </div><!--end form-group row --->


                                                    <div class="form-group row m-b-5 m-t-0">
                                                        <label  class="col-sm-2 control-label">Nature of the complaint</label>
                                                        <div class="col-sm-4">
                                                            <div class="controls">
                                                                    <input type="text" name="" class="form-control text-form-data-blue" readonly value="Administrative"> 
                                                                
                                                            </div><!--end controls-->
                                                        </div><!--end col-sm-9-->

                                                        <label  class="col-sm-2 control-label">Status</label>
                                                        <div class="col-sm-4">
                                                            <div class="controls">
                                                                    <input type="text" name="" class="form-control text-form-data-blue" readonly value="Status Name Here"> 
                                                                
                                                            </div><!--end controls-->
                                                        </div><!--end col-sm-9-->
                                                    </div><!--end form-group row --->


                                                    <div class="form-group row m-b-5 m-t-0">
                                                        <label  class="col-sm-2 control-label">Grievance Statement</label>
                                                        <div class="col-sm-10">
                                                            <div class="controls">
                                                                    <textarea name="textarea" rows="4" id="textarea" class="form-control text-form-data-blue" readonly>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</textarea>
                                                                
                                                            </div><!--end controls-->
                                                        </div><!--end col-sm-9-->
                                                        
                                                    </div><!--end form-group row --->

                                                </form>
                                            </div><!--end card body details-->
                                        </div><!--end card  details-->
                                    </div><!--end col12 details-->
                                </div><!--end row details-->
                            </div><!--end card body-->
                        </div><!--end card card-->
                    </div><!--end col 12-->
                </div><!--end row for details--> 

                <!----------------------------------->


                <div class="row">
                    <div class="col-12">
                        <div class="card m-t-0 m-b-0"><!-- card-outline-success-->
                             <div class="card-header bg-light-warning3 p-t-5 p-b-0 m-t-0 m-b-0">
                                <div class="row">
                                   <div class="col-12">
                                        <div class="d-flex flex-wrap">
                                            <div><h3 class="card-title">Staff Grievance Process History</h3></div>
                                            <div class="ml-auto">
                                                <ul class="list-inline">
                                                    <li><h6>Grievance ID [<span class="font-weight-bold">123</span>] </h6></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                </div><!--end row-->

                            </div><!--end card-header-->

                            <div class="card-body bg-light-warning2">
                                <!---ribbon start of one office history-->
                                <div class="ribbon-wrapper card">
                                    <div class="ribbon ribbon-corner ribbon-info"><h2 class="text-white">1</h2></div><!--- css style edit ribbon-corner line 4272 add .ribbon-corner h2-->
                                    <!--start of one respondent-->
                                    <div class="card-body bg-light p-l-0 p-r-0">
                                        <div class="profiletimeline">
                                            <div class="sl-item">
                                                <div class="sl-left"> <img src="assets/images/users/avatar3.png" alt="Staff" class="img-circle"> </div>
                                                <div class="sl-right m-b-0">
                                                    <div>
                                                        <p class="m-b-0 font-weight-bold">Staff Job Title here - Majdi Mohammed Said Bait Ali Sulaiman</p>
                                                        <p class="m-b-0">Enter Date: <span class="font-weight-bold">December 30,2019</span></a> 
                                                            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  Meeting Date: <span class="font-weight-bold text-warning">December 30,2019</span></p>
                                                        <p class="m-b-0 text-justify">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                                                    </div>
                                                </div>
                                            </div><!--end sl-item-->
                                            
                                        </div><!--end profiletimeline-->
                                    </div> <!--end card-body one respondent-->

                                    <!--start of one respondent-->
                                    <div class="card-body bg-light p-l-0 p-r-0">
                                        <div class="profiletimeline">
                                            <div class="sl-item">
                                                <div class="sl-left"> <img src="assets/images/users/avatar3.png" alt="Staff" class="img-circle"> </div>
                                                <div class="sl-right m-b-0">
                                                    <div>
                                                        <p class="m-b-0 font-weight-bold">Staff Job Title here - Mohammed Mansoor Ghubaish Al-Anqoodi</p>
                                                        <p class="m-b-0">Enter Date: <span class="font-weight-bold">December 30,2019</span></a> 
                                                            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  Decision: <span class="font-weight-bold text-warning">Not-Agree</span></p>

                                                        
                                                        <p class="m-b-0 text-justify">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                                                    </div>
                                                </div>
                                            </div><!--end sl-item-->
                                            
                                        </div><!--end profiletimeline-->
                                    </div> <!--end card-body one respondent-->

                                </div>
                                <!---ribbon end here one office history-->

                                <!-------------------------------------------------------------->
                                <!---ribbon start of one office history-->
                                <div class="ribbon-wrapper card">
                                    <div class="ribbon ribbon-corner ribbon-info"><h2 class="text-white">2</h2></div><!--- css style edit ribbon-corner line 4272 add .ribbon-corner h2-->
                                    <!--start of one respondent-->
                                    
                                    <div class="card-body bg-light p-r-5 p-l-5">
                                         <form class="form-horizontal" action="" method="POST" novalidate enctype="multipart/form-data">
                                                    <div class="form-group row m-b-5 m-t-0">
                                                        <label  class="col-sm-1 control-label">Staff Name</label>
                                                        <div class="col-sm-5">
                                                            <div class="controls">
                                                                <div class="input-group">
                                                                    <input type="text" name="" class="form-control" readonly value="Majdi Mohammed Said Bait Ali Sulaiman"> 
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text" id="basic-addon2">
                                                                            <i class="fas fa-user"></i>
                                                                        </span>
                                                                    </div><!--end input-group-prepend-->
                                                                </div><!--end input-group-->
                                                            </div><!--end controls-->
                                                        </div><!--end col-sm-9-->

                                                        <label  class="col-sm-2 control-label">Job Title</label>
                                                        <div class="col-sm-4">
                                                            <div class="controls">
                                                                    <div class="input-group">
                                                                    <input type="text" name="" class="form-control" readonly value="Job Title of the staff"> 
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text" id="basic-addon2">
                                                                            <i class="far fa-credit-card"></i>
                                                                        </span>
                                                                    </div><!--end input-group-prepend-->
                                                                </div><!--end input-group-->
                                                            </div><!--end controls-->
                                                        </div><!--end col-sm-9-->
                                                    </div><!--end form-group row --->


                                                    <div class="form-group row m-b-5 m-t-0">
                                                        <label  class="col-sm-1 control-label">Meeting Date</label>
                                                        <div class="col-sm-5">
                                                            <div class="controls">
                                                                 <div class="input-group">
                                                                    <input type="text" name="" class="form-control"  required data-validation-required-message="Please enter Meeting Date"> 
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text" id="basic-addon2">
                                                                            <i class="fa fa-calendar-alt"></i>
                                                                        </span>
                                                                    </div><!--end input-group-prepend-->
                                                                </div><!--end input-group-->
                                                                
                                                            </div><!--end controls-->
                                                        </div><!--end col-sm-9-->

                                                        <label  class="col-sm-2 control-label">Enter Date</label>
                                                        <div class="col-sm-4">
                                                            <div class="controls">
                                                                <div class="input-group">
                                                                    <input type="text" name="" class="form-control"  readonly value="December 31,2019"> 
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text" id="basic-addon2">
                                                                            <i class="fa fa-calendar"></i>
                                                                        </span>
                                                                    </div><!--end input-group-prepend-->
                                                                </div><!--end input-group-->
                                                            </div><!--end controls-->
                                                        </div><!--end col-sm-9-->
                                                    </div><!--end form-group row --->

                                                    <div class="form-group row m-b-5 m-t-0">
                                                        <label  class="col-sm-1 control-label">Recommendation</label>
                                                        <div class="col-sm-11">
                                                            <div class="controls">
                                                                <div class="input-group">

                                                                    <textarea name="textarea" rows="2" id="textarea" class="form-control" required data-validation-required-message="Please enter Recommendation or Meeting Summary"></textarea>

                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text" id="basic-addon2">
                                                                            <i class="far fa-comment"></i>
                                                                        </span>
                                                                    </div><!--end input-group-prepend-->
                                                                </div><!--end input-group-->

                                                                
                                                            </div><!--end controls-->
                                                        </div><!--end col-sm-9-->
                                                    </div><!--end form-group row --->
                                                    <div class="form-group row m-b-5 m-t-0">
                                                        <div class="offset-sm-1 col-sm-11">
                                                            <button type="submit" class="btn btn-info waves-effect waves-light"><i class="fa fa-paper-plane"></i> Submit</button>
                                                            <button type="reset" class="btn btn-inverse waves-effect waves-light"><i class="fa fa-retweet"></i> Reset</button>
                                                        </div>
                                                    </div><!--end form-group row --->
                                                </form>
                                    </div> <!--end card-body one respondent-->
                                    <!--------------->
                                     <div class="card-body bg-light p-r-5 p-l-5">
                                         <form class="form-horizontal" action="" method="POST" novalidate enctype="multipart/form-data">
                                                    <div class="form-group row m-b-5 m-t-0">
                                                        <label  class="col-sm-1 control-label">Staff Name</label>
                                                        <div class="col-sm-5">
                                                            <div class="controls">
                                                                <div class="input-group">
                                                                    <input type="text" name="" class="form-control" readonly value="Majdi Mohammed Said Bait Ali Sulaiman"> 
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text" id="basic-addon2">
                                                                            <i class="fas fa-user"></i>
                                                                        </span>
                                                                    </div><!--end input-group-prepend-->
                                                                </div><!--end input-group-->
                                                            </div><!--end controls-->
                                                        </div><!--end col-sm-9-->

                                                        <label  class="col-sm-2 control-label">Job Title</label>
                                                        <div class="col-sm-4">
                                                            <div class="controls">
                                                                    <div class="input-group">
                                                                    <input type="text" name="" class="form-control" readonly value="Job Title of the staff"> 
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text" id="basic-addon2">
                                                                            <i class="far fa-credit-card"></i>
                                                                        </span>
                                                                    </div><!--end input-group-prepend-->
                                                                </div><!--end input-group-->
                                                            </div><!--end controls-->
                                                        </div><!--end col-sm-9-->
                                                    </div><!--end form-group row --->


                                                    <div class="form-group row m-b-5 m-t-0">
                                                        <label  class="col-sm-1 control-label">Decision</label>
                                                        <div class="col-sm-5">
                                                            <div class="controls">
                                                                 <div class="input-group">
                                                                    <select class="form-control" required data-validation-required-message="Please select Decision">
                                                                        <option value="">Select Decision</option>
                                                                        <option>Agree</option>
                                                                        <option>Not-Agree</option>
                                                                        </select>
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text" id="basic-addon2">
                                                                            <i class="fas fa-flag-checkered"></i>
                                                                        </span>
                                                                    </div><!--end input-group-prepend-->
                                                                </div><!--end input-group-->
                                                                
                                                            </div><!--end controls-->
                                                        </div><!--end col-sm-9-->

                                                        <label  class="col-sm-2 control-label">Enter Date</label>
                                                        <div class="col-sm-4">
                                                            <div class="controls">
                                                                <div class="input-group">
                                                                    <input type="text" name="" class="form-control"  readonly value="December 31,2019"> 
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text" id="basic-addon2">
                                                                            <i class="fa fa-calendar"></i>
                                                                        </span>
                                                                    </div><!--end input-group-prepend-->
                                                                </div><!--end input-group-->
                                                            </div><!--end controls-->
                                                        </div><!--end col-sm-9-->
                                                    </div><!--end form-group row --->

                                                    <div class="form-group row m-b-5 m-t-0">
                                                        <label  class="col-sm-1 control-label">Statement</label>
                                                        <div class="col-sm-11">
                                                            <div class="controls">
                                                                <div class="input-group">

                                                                    <textarea name="textarea" rows="2" id="textarea" class="form-control" required data-validation-required-message="Please enter Statement"></textarea>

                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text" id="basic-addon2">
                                                                            <i class="far fa-comment"></i>
                                                                        </span>
                                                                    </div><!--end input-group-prepend-->
                                                                </div><!--end input-group-->

                                                                
                                                            </div><!--end controls-->
                                                        </div><!--end col-sm-9-->
                                                    </div><!--end form-group row --->
                                                    <div class="form-group row m-b-5 m-t-0">
                                                        <div class="offset-sm-1 col-sm-11">
                                                            <button type="submit" class="btn btn-info waves-effect waves-light"><i class="fa fa-paper-plane"></i> Submit</button>
                                                            <button type="reset" class="btn btn-inverse waves-effect waves-light"><i class="fa fa-retweet"></i> Reset</button>
                                                        </div>
                                                    </div><!--end form-group row --->
                                                </form>
                                 
                                </div>
                                    <!--end card-body one respondent-->

                                </div>
                                <!---ribbon end here one office history-->



                                </div><!--end card body-->
                        </div><!--end card card-->
                    </div><!--end col 12-->
                </div><!--end row for history process-->
                

            </div>

            <footer class="footer">
                <?php include('include_footer.php'); ?>
            </footer>
        </div>
    </div>
    <?php include('include_scripts.php'); ?>  

            <script>
        // MAterial Date picker    
        $('#mdate').bootstrapMaterialDatePicker({ weekStart: 0, time: false,format: 'DD/MM/YYYY' });
        $('#start_date').datepicker({ weekStart: 0, time: false,format: 'dd/mm/yyyy' });
        $('#end_date').datepicker({ weekStart: 0, time: false,format: 'dd/mm/yyyy' });
        jQuery('#date-range').datepicker({
            toggleActive: true
        });

        $('.daterange').daterangepicker();

        </script>
</body>
</html>