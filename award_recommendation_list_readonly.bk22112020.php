<?php    
    include('include_headers.php');
    if(!$helper->isUserLogged()) {
        include_once('not_allowed.php');
    } else {
        $allowed = ($helper->isAllowed('SuperAdmin') || $helper->isAllowed('HRHead') || $staffId == '119084' || $staffId == '121101' || $staffId == '189010') ? true : false;
        //$linkid = $helper->cleanString($_GET['linkid']);
        //$allowed = $helper->withAccess($user_type,$linkid);
        if($allowed){
                $logged_in_department_name = $helper->fieldNameValue("department",$logged_in_department_id,'name');
                $isAcademic = $helper->fieldNameValue("department",$logged_in_department_id,'isAcademic');                            
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
                                    <h3 class="text-themecolor m-b-0 m-t-0">Recommendation List (Read Only)</h3>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">Home</a></li>
                                        <li class="breadcrumb-item">Awarding </li>
                                        <li class="breadcrumb-item">Recommendation List</li>
                                    </ol>
                                </div>
                                <?php include('include_time_in_info.php'); ?>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-xs-18">
                                    <div class="card">
                                        <div class="card-header bg-light-success2" style="border-bottom: double; border-color: #28a745">
                                            <h4 class="card-title">Recommendation List for [<span class="text-primary"><?php echo date('Y'); ?> - <?php echo date('F'); ?></span>]</h4>
                                        </div>
                                        <div class="card-body bg-light-success">
                                            <div class="table-responsiveXXX">
                                                <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>    
                                                            <th>Department</th>
                                                            <th>Name</th>
                                                            <th>Catagory</th>
                                                            <th>Mark</th>
                                                            <th>Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php 
                                                            $canYear = date('Y');
                                                            $canMonth = date('F');
                                                            $list = new DbaseManipulation;
                                                            $rows = $list->readData("SELECT c.id, c.score, c.isAcademic, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName, d.name as department, c.canStatus FROM award_candidate as c LEFT OUTER JOIN staff as s ON c.staffId = s.staffId LEFT OUTER JOIN employmentdetail as e ON s.staffId = e.staff_id LEFT OUTER JOIN department as d ON d.id = c.department_id WHERE c.canMonth = '$canMonth' AND c.canYear = '$canYear'");
                                                            if($list->totalCount != 0) {
                                                                $i = 0;
                                                                foreach ($rows as $row) {
                                                                    if($row['canStatus'] == 'Winner') {
                                                                        $panalo = 1;
                                                                    }
                                                                    if($panalo == 1) {
                                                                        ?>
                                                                        <tr class="bg-light-yellow text-danger">
                                                                            <td><?php echo ++$i.'.'; ?></td>
                                                                            <td><?php echo $row['department']; ?></td>
                                                                            <td><a href=""><?php echo $row['staffName']; ?></a></td>
                                                                            <td><?php echo $row['isAcademic'] ? "Academic" : "Non-Academic"; ?></td>
                                                                            <td><?php echo number_format($row['score'],2); ?></td>
                                                                            <td><span class="text-danger"><i class="fas fa-trophy"></i> Winner</span></td>
                                                                        </tr>
                                                                        <?php
                                                                    } else {
                                                                        ?>
                                                                        <tr>
                                                                            <td><?php echo ++$i.'.'; ?></td>
                                                                            <td><?php echo $row['department']; ?></td>
                                                                            <td><a href=""><?php echo $row['staffName']; ?></a></td>
                                                                            <td><?php echo $row['isAcademic'] ? "Academic" : "Non-Academic"; ?></td>
                                                                            <td><a href="#" class="viewScore" data-id="<?php echo $row['id']; ?>" data-aca="<?php echo $row['isAcademic']; ?>"><?php echo number_format($row['score'],2); ?></a></td>
                                                                            <td></td>
                                                                        </tr>
                                                                        <?php
                                                                    }    
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