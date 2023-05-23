<?php    
    include('include_headers.php');
    if(!$helper->isUserLogged()) {
        include_once('not_allowed.php');
    } else {
        $allowed = ($helper->isAllowed('SuperAdmin') || $helper->isAllowed('HRHead')) ? true : false;
        //$linkid = $helper->cleanString($_GET['linkid']);
        //$allowed = $helper->withAccess($user_type,$linkid);
        if($allowed){                                 
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
                                <div class="col-md-5 col-sm-12 align-self-center">
                                    <h3 class="text-themecolor m-b-0 m-t-0"><i class="fas fa-diagnoses"></i> Appraisal Type - Staff</h3>
                                    <ol class="breadcrumb">
                                         <li class="breadcrumb-item">Home</a></li>
                                        <li class="breadcrumb-item">Staff Appraisal</li>
                                        <li class="breadcrumb-item">Appraisal Type</li>
                                    </ol>
                                </div>
                                <?php include('include_time_in_info.php'); ?>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">                        
                                    <div class="card">
                                        <div class="card-header bg-light-success m-b-0 m-t-0 p-t-5 p-b-0" style="border-bottom: double; border-color: #28a745">
                                            <h4 class="card-title font-weight-bold"><a style="cursor: pointer; color: #FFF" data-toggle="modal" data-target="#modalAdd" class="btn btn-danger waves-effect waves-light pull-right"><span class="text-white"><i class="fa fa-plus"></i> Add New</span></a></h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table id="dynamicTableListAll" class="display nowrap table table-hover table-striped table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Action</th>
                                                            <th>Staff ID - Name</th>
                                                            <th>Department</th>
                                                            <th>Section</th>
                                                            <th>Apprisal Type</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php 
                                                            $rows = $helper->readData("SELECT at.*, atd.name as appraisal_type_description, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName, d.name as department, sec.name as section 
                                                                FROM appraisal_type at INNER JOIN staff s ON at.staff_id = s.staffId
                                                                INNER JOIN employmentdetail as e ON e.staff_id = at.staff_id
                                                                INNER JOIN department as d ON d.id = e.department_id 
                                                                INNER JOIN section as sec ON sec.id = e.section_id 
                                                                INNER JOIN appraisal_type_description as atd ON atd.id = at.appraisal_type
                                                                WHERE e.isCurrent = 1 AND e.status_id = 1");
                                                            foreach ($rows as $row) {
                                                                ?>
                                                                <tr id='<?php echo $row['id']; ?>'>
                                                                    <td>
                                                                        <a data-id="<?php echo $row['id']; ?>" data-sname="<?php echo $row['staffName']; ?>" data-apptype="<?php echo $row['appraisal_type_description']; ?>"  data-toggle="modal" data-target="#modalEdit" style="cursor: pointer; color: #FFF" class="btn btn-primary cModalEdit"><i class="fa fa-edit"></i> Edit</a>
                                                                    </td>
                                                                    <td><?php echo $row['staff_id'].' - '.$row['staffName']; ?></td>
                                                                    <td><?php echo $row['department']; ?></td>
                                                                    <td><?php echo $row['section']; ?></td>
                                                                    <td><span class="atd"><?php echo $row['appraisal_type_description']; ?></span></td>
                                                                </tr>
                                                                <?php
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
                    $(document).ready(function(){
                        remap_controls();
                    }); 
                    function remap_controls(){

                        $('.cModalEdit').click(function(){
                            $('.appraisal_type_primary_key_id').val($(this).data("id"));
                            $('.staffName').val($(this).data("sname"));
                            $('.appraisalType').val($(this).data("apptype"));
                        });

                        $('.processUpdate').click(function(){
                            var id = $('.appraisal_type_primary_key_id').val();
                            var new_appraisal_type = $('.new_appraisal_type').val();
                            bootbox.hideAll();
                            bootbox.confirm({
                                message: "You are about to change the appraisal type of this staff. <br>Do you want to continue?",
                                buttons: {
                                    confirm: {
                                        label: 'Continue',
                                        className: 'btn-success btn-sm'
                                    },
                                    cancel: {
                                        label: 'Cancel',
                                        className: 'btn-danger btn-sm'
                                    }
                                },
                                callback: function (result) {
                                    if(result==true){
                                        var data = {
                                            id : id,
                                            new_appraisal_type : new_appraisal_type
                                        }
                                        $.ajax({
                                            url  : 'ajaxpages/leaves/settings/appraisal_update_appraisal_type.php',
                                            type    : 'POST',
                                            dataType: 'json',
                                            data    : data,
                                            success : function(e){
                                                if(e.error == 0) {
                                                    bootbox.hideAll();
                                                    bootbox.alert(e.msg);
                                                    $('.appraisalType').val(e.new_appraisal_type_display);
                                                    $('tr#'+id).find('.atd').html(e.new_appraisal_type_display);
                                                    return;
                                                } else {
                                                    bootbox.hideAll();
                                                    bootbox.alert(e.msg);
                                                    return;
                                                }
                                            }, error  : function(e){}
                                        });
                                    }
                                }
                            });
                        });

                        $('.processAdd').click(function(){
                            var staff_id = $('.staff_id').val();
                            var appraisal_type = $('.appraisal_type').val();
                            var data = {
                                staff_id : staff_id,
                                appraisal_type : appraisal_type
                            }
                            $.ajax({
                                url  : 'ajaxpages/leaves/settings/appraisal_add_appraisal_type.php',
                                type    : 'POST',
                                dataType: 'json',
                                data    : data,
                                success : function(e){
                                    if(e.error == 0) {
                                        bootbox.hideAll();
                                        bootbox.alert(e.msg);
                                    } else {
                                        bootbox.hideAll();
                                        bootbox.alert(e.msg);
                                    }
                                }, error  : function(e){}
                            });
                        });
                        
                    }
                </script>



                <div class="modal fade" id="modalEdit">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header" style="display: block !important">
                                <button class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                <h4 class="modal-title text-dark" id="myModalLabel">Edit Appraisal Type</h4>
                            </div>
                            <div class="modal-body">
                                <form class="form-horizontal">
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label text-dark">Staff Name</label>
                                        <div class="col-lg-9">
                                            <input type="hidden" class="appraisal_type_primary_key_id" />
                                            <input type="text" class="form-control staffName" readonly />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label text-dark">Current Appraisal Type</label>
                                        <div class="col-lg-9">
                                            <input type="text" class="form-control appraisalType" readonly />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label text-dark">New Appraisal Type</label>
                                        <div class="col-lg-9">
                                            <select class="form-control new_appraisal_type">
                                                <option value="" selected>Select</option>
                                                <?php 
                                                    $rows = $helper->readData("SELECT * FROM appraisal_type_description");

                                                    foreach ($rows as $row) {
                                                        ?>
                                                        <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                                        <?php
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-primary processUpdate"><i class="fa fa-paper-plane"></i> Update</button>
                                <button class="btn btn-dark" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="modalAdd">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header" style="display: block !important">
                                <button class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                <h4 class="modal-title text-dark" id="myModalLabel">Add New Appraisal Type</h4>
                            </div>
                            <div class="modal-body">
                                <form class="form-horizontal">
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label text-dark">Staff Name</label>
                                        <div class="col-lg-9">
                                            <select class="form-control staff_id">
                                                <option value="" selected>Select</option>
                                                <?php 
                                                    $rows = $helper->readData("SELECT s.staffId, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName FROM staff as s LEFT OUTER JOIN employmentdetail as e ON s.staffId = e.staff_id WHERE e.isCurrent = 1 AND e.status_id = 1 ORDER BY s.firstName");
                                                    foreach ($rows as $row) {
                                                        ?>
                                                        <option value="<?php echo $row['staffId']; ?>"><?php echo $row['staffName']; ?></option>
                                                        <?php
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label text-dark">Appraisal Type</label>
                                        <div class="col-lg-9">
                                            <select class="form-control appraisal_type">
                                                <option value="" selected>Select</option>
                                                <?php 
                                                    $rows = $helper->readData("SELECT * FROM appraisal_type_description");
                                                    foreach ($rows as $row) {
                                                        ?>
                                                        <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                                        <?php
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-primary processAdd"><i class="fa fa-paper-plane"></i> Save</button>
                                <button class="btn btn-dark" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </body>
            <?php
        } else {
            include_once('not_allowed.php');
        }
    }
?>             
</html>