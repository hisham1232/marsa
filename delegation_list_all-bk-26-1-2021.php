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
                        <h3 class="text-themecolor m-b-0 m-t-0">All Delegation List</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item">Delegation</li>
                            <li class="breadcrumb-item">All Delegation List</li>

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


                    <div class="col-lg-12">
                        <!---start for list div-->
                        <div class="card">
                            <div class="card-header bg-light-info p-t-5 p-b-0">
                                <h4 class="card-title">List of All Delegation</h4>
                                <h6 class="card-subtitle">قائمة كل التفويضات</h6>
                            </div>
                            <div class="card-body">

                                <div class="table-responsive">
                                    <table id="example23" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Request ID</th>
                                                <th>Request By</th>
                                                <th>Delegated Staff</th>
                                                <th>Department</th>
                                                <th>Role Delegated</th>
                                                <th>Delegation Date</th>
                                                <th>Days</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>OLT-1234567</td>
                                                <td>Staff Name Here</td>
                                                <td>Staff Name Here</td>
                                                <td>Information Technology</td>
                                                <td><span class="text-primary">Approve Standard Leave,Approve Clearance</span></td>
                                                <td>21/10/2018 - 23/10/2018</td>
                                                <td>3</td>
                                                <td>Accepted</td>
                                                <td><button type="button" title="Click to View Details" class="btn btn btn-outline-info btn-sm"
                                                        data-toggle="modal" data-target="#viewModal" data-whatever="@mdo"><i
                                                            class="fas fa-search fa-2x"></i></button>
                                                </td>

                                            </tr>
                                            <tr>
                                                <td>OLT-1234567</td>
                                                <td>Staff Name Here</td>
                                                <td>Staff Name Here</td>
                                                <td>Information Technology</td>
                                                <td><span class="text-primary">Approve Standard Leave,Approve Clearance</span></td>
                                                <td>21/10/2018 - 23/10/2018</td>
                                                <td>3</td>
                                                <td>Created</td>
                                               <td><button type="button" title="Click to View Details" class="btn btn btn-outline-info btn-sm"
                                                        data-toggle="modal" data-target="#viewModal" data-whatever="@mdo"><i
                                                            class="fas fa-search fa-2x"></i></button>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>OLT-1234567</td>
                                                <td>Staff Name Here</td>
                                                <td>Staff Name Here</td>
                                                <td>Information Technology</td>
                                                <td><span class="text-primary">Approve Standard Leave,Approve Clearance</span></td>
                                                <td>21/10/2018 - 23/10/2018</td>
                                                <td>3</td>
                                                <td>Finished</td>
                                                <td><button type="button" title="Click to View Details" class="btn btn btn-outline-info btn-sm"
                                                        data-toggle="modal" data-target="#viewModal" data-whatever="@mdo"><i
                                                            class="fas fa-search fa-2x"></i></button>
                                                </td>

                                            </tr>
                                        </tbody>
                                    </table>



                                </div>
                                <!--end table-responsive-->
                            </div>
                            <!--end card body-->
                        </div>
                        <!--end card-->


                        <!---no record --->

                        <div class="card">
                            <div class="card-body bg-light-info">
                                <div class="d-flex flex-wrap">
                                    <div style="margin:auto !important;">
                                        <h1 class="text-info" style="font-size: 110px !important;
    font-weight: 700 !important;line-height: 110px !important; text-align: center !important;">
                                            <center><i class="fas fa-clipboard-list"></i></center>
                                        </h1>
                                        <h2 class="text-danger">NO Records for APPROVAL Found!</h2>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end col-lg-12-->
                </div>
                <!--end row-->
            </div>

            <!--- Start Modal for view-->
            <div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="exampleModalLabel1">Delegation Details</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="modal-body">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-md-6">Request By : <span class="text-primary">Name of Staff</span></div>
                                    <div class="col-md-6">Request ID : <span class="text-primary">DLX-123456</span></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">Request Date : <span class="text-primary">24/12/2018</span></div>
                                    <div class="col-md-6">Status : <span class="text-primary">Accepted</span></div>
                                </div>
                                <hr>

                                <div class="row">
                                    <div class="col-md-3">Delegated Role :</div>
                                    <div class="col-md-7"><span class="text-primary">Approve Standard Leave,Approve
                                            Clearance</span></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">Delegated Staff : </div>
                                    <div class="col-md-7"><span class="text-primary">Staff Name</span></div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3">Delegated Date : </div>
                                    <div class="col-md-7"><span class="text-primary">24/12/2018 - 27/12/2018</span></div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3">Delegation Note : </div>
                                    <div class="col-md-7"><span class="text-primary">Note here...</span></div>
                                </div>

                                <hr>
                                <p class="font-weight-bold">History</p>

                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-sm">
                                        <thead>
                                            <tr>
                                                <th>Staff Name</th>
                                                <th>Date</th>
                                                <th>Notes/Comment</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Staff Name Here</td>
                                                <td>21/10/2018</td>
                                                <td>Text Notes Here</td>
                                                <td>Created</td>
                                            </tr>
                                            <tr>
                                                <td>Staff Name Here</td>
                                                <td>22/10/2018</td>
                                                <td>Text Notes Here</td>
                                                <td>Accepted</td>
                                            </tr>
                                        </tbody>
                                    </table>



                                </div>
                                <!--end table-responsive-->



                            </div>
                            <!--end container-fluid-->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.end modal for view details -->



           
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

    <script>
        // MAterial Date picker    
        $('#mdate').bootstrapMaterialDatePicker({
            weekStart: 0,
            time: false,
            format: 'DD/MM/YYYY'
        });
        $('#start_date').datepicker({
            weekStart: 0,
            time: false,
            format: 'dd/mm/yyyy'
        });
        $('#end_date').datepicker({
            weekStart: 0,
            time: false,
            format: 'dd/mm/yyyy'
        });
        jQuery('#date-range').datepicker({
            toggleActive: true
        });
        $('.daterange').daterangepicker();
    </script>
    <script>
        $(function(){
            $('.extendDelegation').on('submit', function(e){
                e.preventDefault();
                //alert("Ajax and JQuery Manipulation Here, use JSON object as response from PHP, use also bootbox to inform the user.");
                var data_collection = {
                    id : id,
                    notes : notes
                };
                $.ajax({
                    url : "ajaxpages/modal_forms/delegations/update.php",
                    type : "POST",
                    dataType : "json",
                    data : data_collection,
                    success : function(d) {
                        if (1 == d.error) {
                            arena_status_panel.text(d.message);
                            page_load_blocker(false);
                        } else {
                            arena_status_panel.text(d.message);
                            me.update_console();
                            var new_points = parseFloat(curr_points) + parseFloat(d.amount);
                            $("#curPoints").val(new_points);
                            $("#playerPoints").text(number_format(new_points));
                            if (d.deplete) {
                                $("tr#" + odds).find(".tdbet-amount,.tdwin-amount").hide();
                                //$("tr#" + odds).find(".meronbtn,.walabtn,.drawbtn").show();
                            } else {
                                $("tr#" + odds).find(".tdbet-amount").text("...");
                                $("tr#" + odds).find(".tdwin-amount").text("...");
                            }
                            page_load_blocker(false);
                            me.update_console();
                        }
                    },
                    error : function() {
                    }    
                });
                function(data, status, xhr){
                    // do something here with response;
                });*/
            });
        });
    </script>
</body>
</html>