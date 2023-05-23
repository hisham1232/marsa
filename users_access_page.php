<?php    
    include('include_headers.php');
    if(!$helper->isUserLogged()) {
        include_once('not_allowed.php');
    } else {
        //$allowed = ($helper->isAllowed('SuperAdmin') || $helper->isAllowed('HRHead') || $helper->isAllowed('HRStaff')) ? true : false;
        $linkid = $helper->cleanString($_GET['linkid']);
        $allowed = $helper->withAccess($user_type,$linkid);
        if($allowed){                                 
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
                                    <h3 class="text-themecolor m-b-0 m-t-0">System Users Page Restriction</h3>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">Home</a></li>
                                        <li class="breadcrumb-item">Page Restrictions</li>
                                        <li class="breadcrumb-item">View All Access<</li>
                                    </ol>
                                </div>
                                <?php include('include_time_in_info.php'); ?>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-xs-18">
                                    <div class="card">
                                    <div class="card-header bg-light-info m-b-0 p-b-0">
                                            <div class="d-flex flex-wrap">
                                                <div>
                                                    <h3 class="card-title">System Users Page Restriction Per System Module</h3>                    
                                                </div>
                                            </div>
                                        </div> 
                                        <div class="card-body">
                                            <form class="form-horizontal m-b-0" action="" method="POST" novalidate enctype="multipart/form-data">
                                                <div class="form-group row">
                                                    <label class="col-sm-2">Select User Type</label>
                                                    <div class="col-sm-4">
                                                        <div class="controls">
                                                            <input type="hidden" class="created_by" value="<?php echo $staffId; ?>" />
                                                            <select name="user_type_id" class="form-control" required data-validation-required-message="Please select user type">
                                                            <option value="">Select Here</option>
                                                                <?php 
                                                                    $utype = new DbaseManipulation;
                                                                    $rows = $utype->readData("SELECT * FROM user_types");
                                                                    foreach ($rows as $row) {
                                                                ?>
                                                                        <option value="<?php echo $row['user_type_id']; ?>"><?php echo $row['name']; ?></option>
                                                                <?php            
                                                                    }    
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <button name="submit" class="btn btn-info waves-effect waves-light" type="submit" title="Click to Search"><i class="fas fa-search"></i> View System Access</button>
                                                    </div>
                                                </div>
                                            </form>
                                            <!-- Accordion style -->
                                            <?php
                                                if(isset($_POST['submit'])) {
                                                    $user_type_id = $_POST['user_type_id'];
                                                    $get = new DbaseManipulation;
                                                    $access = $get->singleReadFullQry("SELECT * FROM user_types WHERE user_type_id = $user_type_id");
                                                    ?>                        
                                                    <div id="accordion-style-1">
                                                        <h3><span>User Type Level: </span><span class="text-primary font-italic"><?php echo $access['name']; ?></span></h3>
                                                        <div class="accordion" id="accordionShortLeaveSequence">
                                                            <?php
                                                                $access_menu_left_main = new DbaseManipulation;
                                                                $rows = $access_menu_left_main->readData("SELECT * FROM access_menu_left_main WHERE active = 1");
                                                                if($access_menu_left_main->totalCount != 0) {
                                                                    $access_menu_matrix_sub = new DbaseManipulation;
                                                                    foreach($rows as $row){
                                                                        $menu_left_id = $row['id'];
                                                                        ?>    
                                                                        <div class="card">
                                                                            <div class="card-header" id="headingOne">
                                                                                <div class="d-flex no-block align-items-center">
                                                                                    <h4 class="card-title">
                                                                                        <button class="btn collapsed btn-link text-left" type="button" data-toggle="collapse" data-target="#module<?php echo $row['id']; ?>" aria-expanded="true" aria-controls="collapseTwo">
                                                                                        <i class="fa as fa-key main"></i><i class="fa fa-angle-double-right mr-3"></i><?php echo $row['menu_name']; ?>
                                                                                        </button>
                                                                                    </h4>
                                                                                </div>
                                                                            </div>
                                                                            <div id="module<?php echo $row['id']; ?>" class="collapse fade" aria-labelledby="headingOne" data-parent="#accordionShortLeaveSequence">
                                                                                <div class="card-body">
                                                                                    <div class="table-responsive">
                                                                                        <table data-toggle="table"  data-mobile-responsive="true" class="table table-striped table-sm">
                                                                                            <thead>
                                                                                                <tr>
                                                                                                    <th><strong>Module Name</strong></th>
                                                                                                    <th><strong>Access Status</strong></th>
                                                                                                    <th><strong>Action</strong></th>
                                                                                                    <th><strong>Updated By</strong></th>
                                                                                                    <th><strong>Date Updated</strong></th>
                                                                                                </tr>
                                                                                            </thead>
                                                                                            <tbody>
                                                                                                <?php
                                                                                                    $modules = $access_menu_matrix_sub->readData("SELECT sub.*, p.page_name, p.menu_name_sub, p.menu_left_id, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName FROM access_menu_matrix_sub as sub 
                                                                                                    LEFT OUTER JOIN access_menu_left_sub as p ON p.id = sub.access_menu_left_sub_id
                                                                                                    LEFT OUTER JOIN staff as s ON s.staffId = sub.created_by
                                                                                                    WHERE sub.user_type_id = $user_type_id AND p.menu_left_id = $menu_left_id
                                                                                                    ORDER BY sub.id ASC");
                                                                                                    if($access_menu_matrix_sub->totalCount != 0) {
                                                                                                        foreach($modules as $module){
                                                                                                            ?>            
                                                                                                                <tr>
                                                                                                                    <td><i class="ti-link"></i> <?php echo $module['menu_name_sub']; ?></td>
                                                                                                                    <td>
                                                                                                                        <select name="active<?php echo $module['id']; ?>" class="form-control col-sm-6 active<?php echo $module['id']; ?>">
                                                                                                                            <?php 
                                                                                                                                for($i=0; $i <=1; $i++) {
                                                                                                                                    if($module['active'] == $i) {
                                                                                                                                        if($module['active'] == 1) {
                                                                                                                                            ?>
                                                                                                                                            <option value="<?php echo $i; ?>" selected> YES</option>
                                                                                                                                            <?php
                                                                                                                                        } else {
                                                                                                                                            ?>
                                                                                                                                            <option value="<?php echo $i; ?>" selected> NO</option>
                                                                                                                                            <?php
                                                                                                                                        }                        
                                                                                                                                    } else {
                                                                                                                                        if($module['active'] == 1) {
                                                                                                                                            ?>
                                                                                                                                            <option value="<?php echo $i; ?>"> NO</option>       
                                                                                                                                            <?php
                                                                                                                                        } else {
                                                                                                                                            ?>
                                                                                                                                            <option value="<?php echo $i; ?>"> YES</option>       
                                                                                                                                            <?php              
                                                                                                                                        }
                                                                                                                                    }        
                                                                                                                                }
                                                                                                                            ?>
                                                                                                                        </select>
                                                                                                                    </td>
                                                                                                                    <td><a href="javascript:;" data-id="<?php echo $module['id']; ?>" class="btn btn-info waves-effect waves-light btnSubmit" role="button"><span class="text-white"><i class="fa fa-paper-plane"></i> Submit</span></a></td>
                                                                                                                    <td><i class="far fa-user"></i> <span class="updated_by<?php echo $module['id']; ?>"><?php echo $module['staffName']; ?></span></td>
                                                                                                                    <td><i class="far fa-calendar"></i> <span class="updated<?php echo $module['id']; ?>"><?php echo date('d/m/Y H:i:s',strtotime($module['modified'])); ?></span></td>
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
                                                                        <?php
                                                                    }
                                                                }
                                                            ?>    

                                                        </div><!--end for accordion whole-->    
                                                    </div>
                                                    <?php
                                                }
                                            ?>    
                                            <!--end for accordion style-1-->                                   
                                        </div>
                                    </div><!--end card-->            
                                </div><!--end col-lg-10-->
                            </div><!--end row-->
                        </div>            
                        <footer class="footer">
                            <?php include('include_footer.php'); ?>
                        </footer>
                    </div>
                </div>
                <?php include('include_scripts.php'); ?>
                <script>
                    $(document).ready(function() {
                        $('.btnSubmit').click(function(e){
                            var id = $(this).data('id');
                            var av = ".active"+id;
                            var active = $(av).val();
                            var created_by = $('.created_by').val();
                            var upd = ".updated_by"+id;
                            var updated = ".updated"+id;
                            var data = {
                                id : id,
                                active : active,
                                created_by : created_by
                            }
                            $.ajax({
                                url	 : 'ajaxpages/system/restrictions/update.php'
                                ,type	 : 'POST'
                                ,dataType: 'json'
                                ,data	 : data
                                ,success : function(e){
                                    if(e.error == 1){
                                        bootbox.alert("<strong class='text-danger'><i class='fa fa-exclamation-triangle'></i> Unable To Continue!</strong><br/><br/>An error has been encountered during processing.");
                                    } else {
                                        bootbox.alert({
                                            title: "<span class='text-primary'><i class='fa fa-info-circle'></i> Information</span>", 
                                            message: e.message
                                        });
                                        $(upd).html(e.updated_by);
                                        $(updated).html(e.updated);
                                    }	
                                }
                                ,error	: function(e){
                                }
                            });
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