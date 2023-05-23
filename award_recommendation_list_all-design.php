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
                        <h3 class="text-themecolor m-b-0 m-t-0">All Recommendation List (Read Only)</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">Home</a></li>
                            <li class="breadcrumb-item">Awarding </li>
                            <li class="breadcrumb-item">All Recommendation List</li>
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



                 <!------------------------------------------------->
                 <div class="row">
                    <div class="col-lg-12 col-md-18 col-xs-18">
                        <div class="card card-body bg-light-success p-b-0">
                 <form class="form-horizontal" action="" method="POST" novalidate enctype="multipart/form-data">

                    <div class="form-group row">
                        <label class="col-md-1 col-form-label">Year</label>
                        <div class="col-md-1">
                            <div class="controls">
                                <select class="form-control">
                                    <option value="">Select</option>
                                    <option>2020</option>
                                </select>
                            </div>
                        </div>

                        <label class="col-md-1 col-form-label">Month</label>
                        <div class="col-md-2">
                            <div class="controls">
                                <select class="custom-select select2">
                                    <option value="">Select Month</option>
                                    <option value="January">January</option>
                                    <option value="Febuary">Febuary</option>
                                    <option value="March">March</option>
                                    <option value="April">April</option>
                                    <option value="May">May</option>
                                    <option value="June">June</option>
                                    <option value="July">July</option>
                                    <option value="August">August</option>
                                    <option value="September">September</option>
                                    <option value="October">October</option>
                                    <option value="November">November</option>
                                    <option value="December">December</option>
                                </select>
                            </div>
                        </div>

                        <label class="col-md-1 col-form-label">Department</label>
                        <div class="col-md-2">
                            <div class="controls">
                                <select class="custom-select select2">
                                    <option value="">Select Department</option>
                                    <option value="">Information Technology </option>
                                    <option value="">Housing, Student Activities and Graduation</option>
                                    <option value="">English Language Center</option>
                                    
                                </select>
                            </div>
                        </div>

                         <label class="col-md-1 col-form-label">Category</label>
                        <div class="col-md-2">
                            <div class="controls">
                                <select class="custom-select select2">
                                    <option value="">Select Category</option>
                                    <option value="">Academic</option>
                                    <option value="">Non-Academic</option>
                                </select>
                            </div>
                        </div>
    <div class="col-md-1">
        <button class="btn btn-success waves-effect waves-light"  type="submit" title="Click to Search"><i class="fas fa-search"></i> Search</button>
    </div>
    
  </div><!--end form-group-->
  
                    </form>
                        </div>
                    </div>
                </div>
                <!------------------------------------------------->

                


                <div class="row"><!--for result-->
                    <div class="col-lg-12 col-xs-18"><!---start for list div-->
                        <div class="card">
                            <div class="card-header bg-light-success2" style="border-bottom: double; border-color: #28a745">
                                <h4 class="card-title">Recommendation List for [<span class="text-primary">2020 - January</span>]</h4>
                                
                            </div><!--end card header-->
                            <div class="card-body bg-light-success">
                                <div class="table-responsive">
                                    <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Year</th>
                                                <th>Month</th>    
                                                <th>Department</th>
                                                <th>Name</th>
                                                <th>Catagory</th>
                                                <th>Mark</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>2020</td>
                                                <td>January</td>
                                                <td>Information Technology</td>
                                                <td><a href="award_add.php">Shreemathi Vedanta Rajagopalan</a></td>
                                                <td>Academic</td>
                                                <td>92</td>
                                                <td>
                                                </td>
                                                
                                            </tr>
                                             <tr>
                                                <td>2</td>
                                                <td>2020</td>
                                                <td>January</td>
                                                <td>Engineering</td>
                                                <td><a href="award_add.php">Abdul Nasar Mohammed Mohammed</a></td>
                                                <td>Academic</td>
                                                <td>93</td>
                                                <td>
                                                </td>
                                            </tr>
                                            <tr class="bg-light-yellow text-danger">
                                                <td>3</td>
                                                <td>2020</td>
                                                <td>January</td>
                                                <td>Housing, Student Activities and Graduation</td>
                                                <td><a href="award_add.php">Abdul Nasar Mohammed Mohammed</a></td>
                                                <td>Non-Academic</td>
                                                <td>93</td>
                                                <td><span class="text-danger"><i class="fas fa-trophy"></i> Winner</span></td>
                                            </tr>

                                            <tr>
                                                <td>4</td>
                                                <td>2020</td>
                                                <td>February</td>
                                                <td>English Language Center</td>
                                                <td><a href="award_add.php">Salwa Khamis Said Al-sulaimi</a></td>
                                                <td>Academic</td>
                                                <td>95</td>
                                                <td></td>
                                            </tr>

                                            <tr class="bg-light-yellow text-danger">
                                                <td>5</td>
                                                <td>2020</td>
                                                <td>February</td>
                                                <td>Educational Technologies Centre</td>
                                                <td><a href="award_add.php">Gilbert B. Pajimna</a></td>
                                                <td>Non-Academic</td>
                                                <td>96</td>
                                                <td><span class="text-danger"><i class="fas fa-trophy"></i> Winner</span></td>
                                            </tr>

                                            <tr>
                                                <td>6</td>
                                                <td>2020</td>
                                                <td>February</td>
                                                <td>Business Department</td>
                                                <td><a href="award_add.php">Radhakrishnan Subramaniam</a></td>
                                                <td>Academic</td>
                                                <td>97</td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>7</td>
                                                <td>2020</td>
                                                <td>February</td>
                                                <td>Admission and Registration</td>
                                                <td><a href="award_add.php">Azza Mohammed Abdullah Al-nabhani</a></td>
                                                <td>Non-Academic</td>
                                                <td>96</td>
                                                <td>
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div><!--end table-responsive-->
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
    

<!-- The Modal -->

<!-- sample modal content -->

<div id="myModal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="myLargeModalLabel">Selection for Employee of the Month [<span class="text-primary">2020-January</span>]</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            </div>
                               
                                            <div class="modal-body">
                                                <form>
                                                    <div class="form-group row">
                                                        <label  class="col-sm-3 control-label">Staff Name</label>
                                                        <div class="col-sm-9">
                                                            <div class="controls">
                                                                <div class="input-group">

                                                                     <input type="text" name="" class="form-control" readonly value="Staff Name Here"> 
                                                                   <div class="input-group-prepend">
                                                                        <span class="input-group-text" id="basic-addon2">
                                                                            <i class="fas fa-user"></i>
                                                                        </span>
                                                                    </div><!--end input-group-prepend-->
                                                                </div><!--end input-group-->
                                                            </div><!--end controls-->
                                                        </div><!--end col-sm-9-->
                                                    </div><!--end form-group row --->

                                                    <div class="form-group row">
                                                        <label  class="col-sm-3 control-label">Department</label>
                                                        <div class="col-sm-9">
                                                            <div class="controls">
                                                                <div class="input-group">

                                                                     <input type="text" name="" class="form-control" readonly value="Department Name Here"> 
                                                                   <div class="input-group-prepend">
                                                                        <span class="input-group-text" id="basic-addon2">
                                                                            <i class="fas fa-briefcase"></i>
                                                                        </span>
                                                                    </div><!--end input-group-prepend-->
                                                                </div><!--end input-group-->
                                                            </div><!--end controls-->
                                                        </div><!--end col-sm-9-->
                                                    </div><!--end form-group row --->

                                                    <div class="form-group row">
                                                        <label  class="col-sm-3 control-label">Job Title</label>
                                                        <div class="col-sm-9">
                                                            <div class="controls">
                                                                <div class="input-group">
                                                                <input type="text" name="" class="form-control" readonly value="Job Title"> 
                                                                   <div class="input-group-prepend">
                                                                        <span class="input-group-text" id="basic-addon2">
                                                                            <i class="fas fa-file-alt"></i>
                                                                        </span>
                                                                    </div><!--end input-group-prepend-->
                                                                </div><!--end input-group-->
                                                            </div><!--end controls-->
                                                        </div><!--end col-sm-9-->
                                                    </div><!--end form-group row --->

                                                    <div class="form-group row">
                                                        <label  class="col-sm-3 control-label">Category</label>
                                                        <div class="col-sm-9">
                                                            <div class="controls">
                                                                <div class="input-group">
                                                                <input type="text" name="" class="form-control" readonly value="Academic"> 
                                                                   <div class="input-group-prepend">
                                                                        <span class="input-group-text" id="basic-addon2">
                                                                            <i class="fas fa-tags"></i>
                                                                        </span>
                                                                    </div><!--end input-group-prepend-->
                                                                </div><!--end input-group-->
                                                            </div><!--end controls-->
                                                        </div><!--end col-sm-9-->
                                                    </div><!--end form-group row --->

                                                    <div class="form-group row">
                                                        <label  class="col-sm-3 control-label">Mark</label>
                                                        <div class="col-sm-9">
                                                            <div class="controls">
                                                                <div class="input-group">
                                                                <input type="text" name="" class="form-control" readonly value="96"> 
                                                                   <div class="input-group-prepend">
                                                                        <span class="input-group-text" id="basic-addon2">
                                                                            <i class="fas fa-percent"></i>
                                                                        </span>
                                                                    </div><!--end input-group-prepend-->
                                                                </div><!--end input-group-->
                                                            </div><!--end controls-->
                                                        </div><!--end col-sm-9-->
                                                    </div><!--end form-group row --->

                                                    <div class="form-group">
                                                        <label for="message-text" class="control-label">Reason for Selecting This Staff:</label>
                                                        <textarea class="form-control" id="message-text"></textarea>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <p class="text-small"><i class="fas fa-exclamation-triangle text-danger"></i>Warning!!! Once you click Submit button you cannot change it anymore!</p>
                                                <br>
                                                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-danger waves-effect waves-light">Submit</button>
                                            </div>


        </div><!--end modal-content-->
      </div><!--end modal-dialog-->
    </div><!--end modal-->




    <?php
        include('include_scripts.php');
    ?>

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