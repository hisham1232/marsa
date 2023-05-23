<?php    
    include('include_headers.php');
    if(!$helper->isUserLogged()) {
        include_once('not_allowed.php');
    } else {
        $allowed = ($helper->isAllowed('SuperAdmin') || $helper->isAllowed('HRHead') || $helper->isAllowed('HRStaff')) ? true : false;
        //$linkid = $helper->cleanString($_GET['linkid']);
        //$allowed = $helper->withAccess($user_type,$linkid);
        if($allowed){
            $dropdown = new DbaseManipulation;                                 
?>  
            <body class="fix-header fix-sidebar card-no-border">
                <div class="preloader">
                    <svg class="circular" viewBox="25 25 50 50">
                        <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
                </div>
                <div id="main-wrapper">
                    <header class="topbar">
                    <?php   include('menu_top.php'); ?>   
                    </header>
                    <?php   include('menu_left.php'); ?>
                    <div class="page-wrapper">
                        <div class="container-fluid">
                            <div class="row page-titles">
                                <div class="col-md-5 col-8 align-self-center">
                                    <h3 class="text-themecolor m-b-0 m-t-0">Generate Staff ID</h3>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">Home</li>
                                        <li class="breadcrumb-item">College Staff</li>
                                        <li class="breadcrumb-item active">Generate Staff ID</li>
                                    </ol>
                                </div>
                                <?php include('include_time_in_info.php'); ?>
                            </div>
                            <div class="row">
                                <div class="col-lg-6"><!---start form div-->
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex flex-wrap">
                                                <div>
                                                    <h3 class="card-title">Generate Staff ID Form</h3>
                                                    <h6 class="card-subtitle">إستمارة إنشاء رقم الموظف</h6> 
                                                </div>
                                            </div>
                                            <div class="form-horizontal p-t-20">
                                                <div class="form-group row">
                                                    <label for="exampleInputuname3" class="col-sm-3 control-label"><span class="text-danger">*</span>Department<br> القسم</label>
                                                    <div class="col-sm-9">
                                                        <div class="controls">
                                                            <div class="input-group">
                                                                <select name="fDepartment" id="fDepartment" class="form-control select2" required data-validation-required-message="Please select department">
                                                                    <option value="">Select Department</option>
                                                                    <option value="1">Admin</option>
                                                                    <option value="2">Business</option>
                                                                    <option value="3">ELC - English Language Centre</option>
                                                                    <option value="4">ETC - Educational Technologies Centre</option>
                                                                    <option value="5">Engineering</option>
                                                                    <option value="6">IT - Information Technology</option>
                                                                    <option value="7">Maintenance</option>
                                                                </select>   
                                                            </div><!--end input-group-->
                                                        </div><!--end controls-->
                                                    </div><!--end col-sm-9-->
                                                </div><!--end form-group row -->

                                                <div class="form-group row">
                                                    <label for="exampleInputuname3" class="col-sm-3 control-label"><span class="text-danger">*</span>Year<br> السنة</label>
                                                    <div class="col-sm-9">
                                                        <div class="controls">
                                                            <div class="input-group">
                                                                <select name="fYear" id="fYear" class="form-control select2" required data-validation-required-message="Please select year">
                                                                    <option value="">Select Year</option>
                                                                    <?php
                                                                        for($i=2019; $i <= 2030; $i++){
                                                                            ?>
                                                                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                                                            <?php
                                                                        }
                                                                    ?>
                                                                </select>
                                                            </div><!--end input-group-->
                                                        </div><!--end controls-->
                                                    </div><!--end col-sm-9-->
                                                </div><!--end form-group row -->

                                                <?php /*<div class="form-group row">
                                                    <label for="exampleInputuname3" class="col-sm-3 control-label">Last Staff ID<br> آخر رقم موظف</label>
                                                    <div class="col-sm-9">
                                                        <div class="controls">
                                                            <div id="lastStaffId" class="input-group">
                                                                <input type="text" class="form-control" readonly />
                                                            </div>
                                                        </div><!--end controls-->
                                                    </div><!--end col-sm-9-->
                                                </div><!--end form-group row -->

                                                <div class="form-group row">
                                                    <label for="exampleInputuname3" class="col-sm-3 control-label">Last Staff Name<br> آخر اسم موظف</label>
                                                    <div class="col-sm-9">
                                                        <div class="controls">
                                                            <div id="lastStaffName" class="input-group">
                                                                <input type="text" class="form-control" readonly />
                                                            </div>
                                                        </div><!--end controls-->
                                                    </div><!--end col-sm-9-->
                                                </div><!--end form-group row --> */ ?>

                                                <div class="form-group row">
                                                    <label for="exampleInputuname3" class="col-sm-3 control-label">New Staff ID<br> رقم الموظف الجديد</label>
                                                    <div class="col-sm-9">
                                                        <div class="controls">
                                                            <div id="newStaffId" class="input-group text-blue">---</div>
                                                        </div><!--end controls-->
                                                    </div><!--end col-sm-9-->
                                                </div><!--end form-group row -->

                                                <div class="form-group row m-b-0">
                                                    <div class="offset-sm-3 col-sm-9">
                                                        <button onclick="submitNewId()" name="submitFromGenerateId" class="btn btn-info waves-effect waves-light"><i class="fa fa-paper-plane"></i> Submit</button>
                                                        <a href="" class="btn btn-inverse waves-effect waves-light"><i class="fa fa-retweet"></i> Reset</a>
                                                    </div>
                                                </div>
                                            </div><!--end form changed to div-->
                                        </div><!--end card body-->
                                    </div><!--end card-->
                                </div><!--end col-lg-6-->
                                <!------------------------------------------------------------------------>
                                <!------------------------------------------------------------------------>

                                
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
                <script>
                    $('#fYear').on('change', function() {
                        var deptCode = $('#fDepartment').val();
                        var yearCode = $('#fYear').val();
                        var yearCodeLast2 = yearCode.slice(-2);
                        var firstThree = deptCode + yearCodeLast2;
                        var data = {
                            deptCode : deptCode,
                            firstThree : firstThree
                        }
                        $.ajax({
                            url  : 'ajaxpages/ids/newstaffid.php'
                            ,type    : 'POST'
                            ,dataType: 'json'
                            ,data    : data
                            ,success : function(e){
                                if(e.error == 0){
                                    $("#newStaffId").text(firstThree+e.lastThree);
                                } else {
                                    bootbox.alert("<strong class='text-danger'><i class='fa fa-exclamation-triangle'></i> Unable To Continue!</strong><br/><br/>An error has been encountered during processing.");
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