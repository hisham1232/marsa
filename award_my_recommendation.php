<?php    
    include('include_headers.php');
    if(!$helper->isUserLogged()) {
        include_once('not_allowed.php');
    } else {
        $allowed = ($helper->isAllowed('SuperAdmin') || $helper->isAllowed('HRHead') || $helper->isAllowed('HoD_HoC')) ? true : false;
        //$linkid = $helper->cleanString($_GET['linkid']);
        //$allowed = $helper->withAccess($user_type,$linkid);
        if($allowed){
            $logged_in_department_name = $helper->fieldNameValue("department",$logged_in_department_id,'name');                            
            ?>   
            <body class="fix-header fix-sidebar card-no-border">
                <!-- <div class="preloader">
                    <svg class="circular" viewBox="25 25 50 50">
                        <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
                </div> -->
                <div id="main-wrapper">
                    <header class="topbar">
                     <?php include('menu_top.php'); ?>   
                    </header>
                    <?php include('menu_left.php'); ?>
                    <div class="page-wrapper">
                        <div class="container-fluid">
                            <div class="row page-titles">
                                <div class="col-md-5 col-xs-18 align-self-center">
                                    <h3 class="text-themecolor m-b-0 m-t-0">My Recommendation List</h3>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">Home</a></li>
                                        <li class="breadcrumb-item">Awarding </li>
                                        <li class="breadcrumb-item">My Recommendation List</li>
                                    </ol>
                                </div>
                                <?php include('include_time_in_info.php'); ?>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-md-18 col-xs-18">
                                    <div class="card card-body p-b-0 bg-light-success p-t-5">
                                        <form class="form-horizontal" action="" method="POST" novalidate enctype="multipart/form-data">
                                            <div class="form-group row">
                                                <label class="col-md-1 col-form-label">Year</label>
                                                <div class="col-md-1">
                                                    <div class="controls">
                                                        <select class="form-control" name="yearSelect">
                                                            <option value="">Select</option>
                                                            <option>2020</option>
                                                            <option>2021</option>
                                                            <option>2022</option>
                                                            <option>2023</option>
                                                            <option>2025</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <label class="col-md-1 col-form-label">Month</label>
                                                <div class="col-md-2">
                                                    <div class="controls">
                                                        <select class="form-control" name="monthSelect">
                                                            <option value="">Select Month</option>
                                                            <option value="January">January</option>
                                                            <option value="February">February</option>
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
                                                <label class="col-md-1 col-form-label">Status</label>
                                                <div class="col-md-2">
                                                    <div class="controls">
                                                        <select class="form-control" name="statusSelect">
                                                            <option value="">Select Status</option>
                                                            <option value="Recommended">Recommended</option>
                                                            <option value="Winner">Winner</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <button name="btnSearch" class="btn btn-success waves-effect waves-light" type="submit" title="Click to Search"><i class="fas fa-search"></i> Search</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-xs-18">
                                    <div class="card bg-light-success">
                                        <div class="card-header bg-light-success2 p-b-0 p-t-5" style="border-bottom: double; border-color: #28a745">
                                            <?php 
                                                $counter = new DbaseManipulation;
                                                $rowCount = $counter->singleReadFullQry("SELECT COUNT(id) as ctrRecommended FROM award_candidate WHERE canStatus = 'Recommended' AND submittedBy = '$staffId'");
                                                $rowCountWinner = $counter->singleReadFullQry("SELECT COUNT(id) as ctrWinner FROM award_candidate WHERE canStatus = 'Winner' AND submittedBy = '$staffId'");
                                            ?>
                                            <h4 class="card-title">Recommendation List [Total of Recommendation : <span class="text-primary"><?php echo $rowCount['ctrRecommended']; ?> </span>] [Number of Winners : <span class="text-primary"><?php echo $rowCountWinner['ctrWinner']; ?></span>]</h4>
                                        </div>
                                        <div class="card-body">
                                            <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>    
                                                        <th>Year</th>
                                                        <th>Month</th>
                                                        <th>Name</th>
                                                        <th>Section</th>
                                                        <th>Gender</th>
                                                        <th>Score</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        $myRecommended = new DbaseManipulation;
                                                        if(isset($_POST['btnSearch'])) {
                                                            
                                                            $sql = "SELECT c.id, c.canYear, c.canMonth, c.score, c.isAcademic, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName, sc.name as section, s.gender, c.canStatus FROM award_candidate as c LEFT OUTER JOIN staff as s ON c.staffId = s.staffId LEFT OUTER JOIN employmentdetail as e ON s.staffId = e.staff_id LEFT OUTER JOIN section as sc ON sc.id = e.section_id WHERE c.submittedBy = '$staffId'";
                                                            if ($_POST['yearSelect'] != '') {
                                                                $sql .= " AND c.canYear = '".$_POST['yearSelect']."'";
                                                            }
                                                            if ($_POST['monthSelect'] != '') {
                                                                $sql .= " AND c.canMonth = '".$_POST['monthSelect']."'";
                                                            }
                                                            if ($_POST['statusSelect'] != '') {
                                                                $sql .= " AND c.canStatus = '".$_POST['statusSelect']."'";
                                                            }
                                                            $rows = $myRecommended->readData($sql);
                                                        } else { 
                                                            $rows = $myRecommended->readData("SELECT c.id, c.canYear, c.canMonth, c.score, c.isAcademic, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName, sc.name as section, s.gender, c.canStatus FROM award_candidate as c LEFT OUTER JOIN staff as s ON c.staffId = s.staffId LEFT OUTER JOIN employmentdetail as e ON s.staffId = e.staff_id LEFT OUTER JOIN section as sc ON sc.id = e.section_id WHERE c.submittedBy = '$staffId'");
                                                        }        
                                                        if($myRecommended->totalCount != 0) {
                                                            $i = 0;
                                                            foreach ($rows as $row) {
                                                                ?>
                                                                <tr>
                                                                    <td><?php echo ++$i.'.'; ?></td>
                                                                    <td><?php echo $row['canYear']; ?></td>
                                                                    <td><?php echo $row['canMonth']; ?></td>
                                                                    <td><?php echo $row['staffName']; ?></td>
                                                                    <td><?php echo $row['section']; ?></td>
                                                                    <td><?php echo $row['gender']; ?></td>
                                                                    <td><a href="#" class="viewScore" data-id="<?php echo $row['id']; ?>" data-aca="<?php echo $row['isAcademic']; ?>"><?php echo number_format($row['score'],2); ?></a></td>
                                                                    <td><?php echo $row['canStatus']; ?></td>
                                                                </tr>
                                                                <?php
                                                            }
                                                        }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>            
                        <footer class="footer">
                            <?php include('include_footer.php'); ?>
                        </footer>
                    </div>
                </div>
                <?php include('include_scripts.php'); ?>
                <script>
                    $('.viewScore').click(function(e){
                        var id = $(this).data('id');
                        var aca = $(this).data('aca');
                        var data = {
                            id : id,
                            aca : aca
                        }
                        $.ajax({
                            url  : 'ajaxpages/awarding/viewScore.php'
                            ,type    : 'POST'
                            ,dataType: 'json'
                            ,data    : data
                            ,success : function(e){
                                if(e.error == 0){
                                    bootbox.alert({
                                        message: e.msg,
                                        size: 'large'
                                    });
                                } else {
                                    bootbox.alert("<strong class='text-danger'><i class='fa fa-exclamation-triangle'></i> Unable To Continue!</strong><br/><br/>Unable to fetch score information.");
                                }   
                            }
                            ,error  : function(e){
                            }
                        });
                    });
                </script>
            </body>
            <?php
        } else {
            include_once('not_allowed.php');
        }
    }
?>             
</html>