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
                        <h3 class="text-themecolor m-b-0 m-t-0">My Staff List</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">Home</a></li>
                            <li class="breadcrumb-item">My Department </li>
                            <li class="breadcrumb-item">My Staff List</li>
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
                    <div class="col-lg-4 col-xlg-3 col-md-5">
                        <div class="card">
                            <div class="card-body">
                                <center class="m-t-20"> <img src="assets/images/users/avatar3.png" class="img-circle" width="150" alt="Staff Picture" />
                                    <h4 class="card-title m-t-10">Mylyn Nostarez</h4>
                                    <h4 class="card-title m-t-10">Arabic Name</h4>
                                    <h5 class="card-subtitle">ETC Technician</h5>
                                    <h5 class="card-subtitle">Educational Services Section</h5>
                                    <h5 class="card-subtitle">Educational Technologies Centre</h5>
                                    <h5 class="card-subtitle">mylyn.nostarez@nct.edu.om</h5>
                                     <!-- Button trigger modal -->
                         </center>
                            </div>
                            <div><hr> </div>
                            <div class="card-body">
                                <small class="text-muted">Staff ID</small><h6>123456</h6>
                                <small class="text-muted">GSM</small><h6>12345678</h6>
                                <small class="text-muted">Sponsor</small><h6>Bahwan Cybertek LLC</h6>
                                <small class="text-muted">Join Date</small><h6>dd/mm/yyyy</h6>                                
                                <small class="text-muted">Nationality</small><h6>Filipino</h6>
                                <small class="text-muted">Gender</small><h6>Female</h6>
                                <small class="text-muted">Marital Status</small><h6>Single</h6>
                                <small class="text-muted">Date of Birth</small><h6>dd/mm/yy</h6>

       
                            </div>
                        </div>
                    </div>
                    <!--end Column for profile -->
                    <!-- Column -->
                    <div class="col-lg-8 col-xlg-9 col-md-7">
                        
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Staff Profile</h4>
                                <h6 class="card-subtitle">ملف الموظف</h6>
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#Qualification" role="tab"><span class="hidden-sm-up"><i class="fas fa-graduation-cap"></i></span> <span class="hidden-xs-down">Qualification</span></a> </li>
                                    <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#employment" role="tab"><span class="hidden-sm-up"><i class="ti-briefcase"></i></span> <span class="hidden-xs-down">Employment History</span></a> </li>
                                    <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#work" role="tab"><span class="hidden-sm-up"><i class="fas fa-rocket"></i></span> <span class="hidden-xs-down">Work Experience</span></a> </li>
                                    

                                </ul>
                                <!-- Tab panes -->
                                <div class="tab-content tabcontent-border">
                                    <div class="tab-pane active" id="Qualification" role="tabpanel">
                                        <div class="card-body">
                                            <h4 class="card-title">Educational Background</h4>
                                            <div class="comment-widgets">
                                                 <!-- start Comment Row -->
                                                <div class="d-flex flex-row comment-row">
                                                    <div class="comment-text active w-100">
                                                        <h4 class="text-primary">Masters - Computer Science</h4>
                                                        <p class="m-b-5">Name of University</p>
                                                        <div class="comment-footer "> 
                                                            <span class="action-icons active">
                                                                 <a href="javascript:void(0)" title="Year Graduated"><small><i class="ti-calendar"></i></small> April 14, 2016</a>
                                                                 <a href="javascript:void(0)" title="GPA"><i class="ti-bar-chart"></i> 95</a>
                                                                 <a href="javascript:void(0)" title="Click to view Attachment"  data-toggle="modal" data-target=".masters_modal"><i class="ti-files"></i> Attachment</a>

                                                                 <div class="modal fade masters_modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                                                                        <div class="modal-dialog modal-lg">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <h4 class="modal-title" id="myLargeModalLabel">Qualification Attachment</h4>
                                                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                                </div><!-- /.modal-header -->
                                                                                <div class="modal-body">
                                                                                     <div style="text-align: center;">
                                    <iframe src="http://docs.google.com/gview?url=http://www.pdf995.com/samples/pdf.pdf&embedded=true" 
                                    width="100%" height="315"  frameborder="0"></iframe></div><!--end div text-center-->

                                                                                </div><!--end modal body-->
                                                                                <div class="modal-footer">
                                                                                    <button type="button" class="btn btn-info waves-effect text-left" data-dismiss="modal">Close</button>
                                                                                </div><!-- /.modal-footer -->
                                                                            </div><!-- /.modal-content -->
                                                                        </div>
                                                                        <!-- /.modal-dialog -->
                                                                </div><!-- /.modal -->
                                                            </span><!--end action-icons span--> 
                                                        </div><!--end comment-footer-->
                                                    </div><!--end comment-text-->
                                                </div><!-------------- d-flex end Comment Row ------------->


                                                 <!-- start Comment Row -->
                                                <div class="d-flex flex-row comment-row">
                                                    <div class="comment-text active w-100">
                                                        <h4 class="text-primary">Bachelor - Computer Science</h4>
                                                        <p class="m-b-5">Name of University</p>
                                                        <div class="comment-footer "> 
                                                            <span class="action-icons active">
                                                                 <a href="javascript:void(0)" title="Year Graduated"><small><i class="ti-calendar"></i></small> May 14, 2010</a>
                                                                 <a href="javascript:void(0)" title="GPA"><i class="ti-bar-chart"></i> 86</a>
                                                                 <a href="javascript:void(0)" title="Click to view Attachment"  data-toggle="modal" data-target=".bachelor_modal"><i class="ti-files"></i> Attachment</a>

                                                                 <div class="modal fade bachelor_modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                                                                        <div class="modal-dialog modal-lg">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <h4 class="modal-title" id="myLargeModalLabel">Qualification Attachment</h4>
                                                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                                </div><!-- /.modal-header -->
                                                                                <div class="modal-body">
                                                                                     <div style="text-align: center;">
                                    <iframe src="http://docs.google.com/gview?url=http://www.pdf995.com/samples/pdf.pdf&embedded=true" 
                                    width="100%" height="315"  frameborder="0"></iframe></div><!--end div text-center-->

                                                                                </div><!--end modal body-->
                                                                                <div class="modal-footer">
                                                                                    <button type="button" class="btn btn-info waves-effect text-left" data-dismiss="modal">Close</button>
                                                                                </div><!-- /.modal-footer -->
                                                                            </div><!-- /.modal-content -->
                                                                        </div>
                                                                        <!-- /.modal-dialog -->
                                                                </div><!-- /.modal -->
                                                            </span><!--end action-icons span--> 
                                                        </div><!--end comment-footer-->
                                                    </div><!--end comment-text-->
                                                </div><!-------------- d-flex end Comment Row ------------->

                                            </div><!--end comment-widgets-->
                                        <!-------------------------end for educational Background-->
                                        <div><hr class="text-primary"></div>
                                        <h4 class="card-title">Extra Certificates</h4>
                                            <div class="comment-widgets">
                                                 <!-- start Comment Row -->
                                                <div class="d-flex flex-row comment-row">
                                                    <div class="comment-text active w-100">
                                                        <h4 class="text-primary">International Computer Driving License (ICDL)</h4>
                                                        <p class="m-b-5">ICDLO123456789
                                                        <div class="comment-footer "> 
                                                            <span class="action-icons active">
                                                                 <a href="javascript:void(0)" title="Date Issue"><small><i class="ti-calendar"></i></small> dd/mm/yyyy
                                                                 <a href="javascript:void(0)" title="Place Issue"><i class="ti-location-pin"></i> Muscat Oman</a>
                                                                 <a href="javascript:void(0)" title="Click to view Attachment"  data-toggle="modal" data-target=".masters_modal"><i class="ti-files"></i> Attachment</a>

                                                                 <div class="modal fade masters_modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                                                                        <div class="modal-dialog modal-lg">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <h4 class="modal-title" id="myLargeModalLabel">Qualification Attachment</h4>
                                                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                                </div><!-- /.modal-header -->
                                                                                <div class="modal-body">
                                                                                     <div style="text-align: center;">
                                    <iframe src="http://docs.google.com/gview?url=http://www.pdf995.com/samples/pdf.pdf&embedded=true" 
                                    width="100%" height="315"  frameborder="0"></iframe></div><!--end div text-center-->

                                                                                </div><!--end modal body-->
                                                                                <div class="modal-footer">
                                                                                    <button type="button" class="btn btn-info waves-effect text-left" data-dismiss="modal">Close</button>
                                                                                </div><!-- /.modal-footer -->
                                                                            </div><!-- /.modal-content -->
                                                                        </div>
                                                                        <!-- /.modal-dialog -->
                                                                </div><!-- /.modal -->
                                                            </span><!--end action-icons span--> 
                                                        </div><!--end comment-footer-->
                                                    </div><!--end comment-text-->
                                                </div><!-------------- d-flex end Comment Row ------------->

                                            </div><!--end comment-widgets-->
                                        <!-------------------------end for extra certificate-->

                                        </div><!--end card-body-->
                                    </div><!--end of tab for qaulification-->
                                    <!----------------------------------------------------->
                                    <!----------------------------------------------------->
                                    <!----------------------------------------------------->

                                    <div class="tab-pane" id="employment" role="tabpanel">
                                     <div class="card-body">
                                            <h4 class="card-title">Employment History(NCT)</h4>
                                            <div class="comment-widgets">
                                                 <!-- start Comment Row -->
                                                <div class="d-flex flex-row comment-row">
                                                    <div class="comment-text active w-100">
                                                        <h4 class="text-primary">Computer Technician</h4>
                                                        <p class="m-b-5">Educational Technologies Centre - Educational Services Section</p>
                                                        <p class="m-b-5">Position Here</p>

                                                        <div class="comment-footer "> 
                                                            <span class="action-icons active">
                                                                 <a href="javascript:void(0)" title="Employment Status Date"><small><i class="ti-calendar"></i></small> April 14, 2018</a>
                                                                 <a href="javascript:void(0)" title="Sponsor"><i class="ti-anchor"></i> Bahwan Cybertek LLC</a>
                                                                 <span class="label label-light-success">Active Job <i class=" ti-check-box"></i></span>
                                                                 
                                                            </span><!--end action-icons span--> 
                                                        </div><!--end comment-footer-->
                                                    </div><!--end comment-text-->
                                                </div><!-------------- d-flex end Comment Row ------------->


                                                 <!-- start Comment Row -->
                                                <div class="d-flex flex-row comment-row">
                                                    <div class="comment-text active w-100">
                                                        <h4 class="text-primary">Computer Technician</h4>
                                                        <p class="m-b-5">Educational Technologies Centre - Computer Services Section</p>
                                                        <p class="m-b-5">Position Here</p>

                                                        <div class="comment-footer "> 
                                                            <span class="action-icons active">
                                                                 <a href="javascript:void(0)" title="Employment Status Date"><small><i class="ti-calendar"></i></small> April 14, 2016</a>
                                                                 <a href="javascript:void(0)" title="Sponsor"><i class="ti-anchor"></i> Bahwan Cybertek LLC</a>
                                                                 
                                                                 
                                                            </span><!--end action-icons span--> 
                                                        </div><!--end comment-footer-->
                                                    </div><!--end comment-text-->
                                                </div><!-------------- d-flex end Comment Row ------------->

                                            </div><!--end comment-widgets-->
                                        
                                    </div><!--end card-body-->

                                    </div><!--end tab-pane for employment history in NCT-->
                                    <!----------------------------------------------->
                                    <!----------------------------------------------->
                                    <!----------------------------------------------->

                                    <div class="tab-pane" id="work" role="tabpanel">
                                        <div class="card-body">
                                            <h4 class="card-title">Work Experience</h4>
                                            <div class="comment-widgets">
                                                 <!-- start Comment Row -->
                                                <div class="d-flex flex-row comment-row">
                                                    <div class="comment-text active w-100">
                                                        <h4 class="text-primary">Desgination Title</h4>
                                                        <p class="m-b-5">Organization Name</p>
                                                        <div class="comment-footer "> 
                                                            <span class="action-icons active">
                                                                 <a href="javascript:void(0)" title="Employment Date"><small><i class="ti-calendar"></i></small> dd/mm/yyyy - dd/mm/yyyy</a>
                                                                 <a href="javascript:void(0)" title="Organization Type"><i class=" ti-blackboard"></i> Academic</a>
                                                                 <a href="javascript:void(0)" title="Click to view Attachment"  data-toggle="modal" data-target=".employment_modal"><i class="ti-files"></i> Attachment</a>

                                                                 <div class="modal fade employment_modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                                                                        <div class="modal-dialog modal-lg">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <h4 class="modal-title" id="myLargeModalLabel">Employment Attachment</h4>
                                                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                                </div><!-- /.modal-header -->
                                                                                <div class="modal-body">
                                                                                     <div style="text-align: center;">
                                    <iframe src="http://docs.google.com/gview?url=http://www.pdf995.com/samples/pdf.pdf&embedded=true" 
                                    width="100%" height="315"  frameborder="0"></iframe></div><!--end div text-center-->

                                                                                </div><!--end modal body-->
                                                                                <div class="modal-footer">
                                                                                    <button type="button" class="btn btn-info waves-effect text-left" data-dismiss="modal">Close</button>
                                                                                </div><!-- /.modal-footer -->
                                                                            </div><!-- /.modal-content -->
                                                                        </div>
                                                                        <!-- /.modal-dialog -->
                                                                </div><!-- /.modal -->
                                                                 
                                                            </span><!--end action-icons span--> 
                                                        </div><!--end comment-footer-->
                                                    </div><!--end comment-text-->
                                                </div><!-------------- d-flex end Comment Row ------------->

                                                <!-------------------------end for work experience-->
                                        <div><hr class="text-primary"></div>


                                        <h4 class="card-title">Staff Training / Seminar / Conference Attended</h4>
                                            <div class="comment-widgets">
                                                 <!-- start Comment Row -->
                                                <div class="d-flex flex-row comment-row">
                                                    <div class="comment-text active w-100">
                                                        <h4 class="text-primary">Title of the Training / Seminar / Conference Attended</h4>
                                                        <p class="m-b-5">Workshop</p>
                                                        <p class="m-b-5">Place of Workshop</p>

                                                        <div class="comment-footer "> 
                                                            <span class="action-icons active">
                                                                 <a href="javascript:void(0)" title="Employment Date"><small><i class="ti-calendar"></i></small> dd/mm/yyyy - dd/mm/yyyy</a>
                                                                 <a href="javascript:void(0)" title="Sponsor by College"><i class="ti-wallet"></i> Sponsor by College</a>
                                                                 <a href="javascript:void(0)" title="Click to view Attachment"  data-toggle="modal" data-target=".training_modal"><i class="ti-files"></i> Attachment</a>

                                                                 <div class="modal fade training_modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                                                                        <div class="modal-dialog modal-lg">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <h4 class="modal-title" id="myLargeModalLabel">Training Attachment</h4>
                                                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                                </div><!-- /.modal-header -->
                                                                                <div class="modal-body">
                                                                                     <div style="text-align: center;">
                                    <iframe src="http://docs.google.com/gview?url=http://www.pdf995.com/samples/pdf.pdf&embedded=true" 
                                    width="100%" height="315"  frameborder="0"></iframe></div><!--end div text-center-->

                                                                                </div><!--end modal body-->
                                                                                <div class="modal-footer">
                                                                                    <button type="button" class="btn btn-info waves-effect text-left" data-dismiss="modal">Close</button>
                                                                                </div><!-- /.modal-footer -->
                                                                            </div><!-- /.modal-content -->
                                                                        </div>
                                                                        <!-- /.modal-dialog -->
                                                                </div><!-- /.modal -->
                                                                 
                                                            </span><!--end action-icons span--> 
                                                        </div><!--end comment-footer-->
                                                    </div><!--end comment-text-->
                                                </div><!-------------- d-flex end Comment Row ------------->


                                    </div><!--end card-body-->
                                    </div><!--end tab-pane for work experience-->
                                    <!----------------------------------------------->
                                    <!----------------------------------------------->
                                    <!----------------------------------------------->

                                    

                                </div><!---end tab-content -->
                            </div> <!--end card-body-->
                        </div><!--end card for tabs-->
                    </div>
                    <!-- Column end col for tabs-->
                
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