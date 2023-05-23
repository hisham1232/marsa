<?php    
    include('include_headers.php');
    include('include_scripts.php');
    if(!$helper->isUserLogged()) {
        include_once('not_allowed.php');
    } else {
        $allowed =  true;
        //$allowed = ($helper->isAllowed('SuperAdmin') || $helper->isAllowed('HRHead') || $helper->isAllowed('HRStaff')) ? true : false;
        //$linkid = $helper->cleanString($_GET['linkid']);
        //$allowed = $helper->withAccess($user_type,$linkid);
        if($allowed){                                 
            $dropdown = new DbaseManipulation;                                 
            $header_info = new DbaseManipulation;
            if(isset($_GET['id'])) {
                $id = $header_info->cleanString($_GET['id']);
                $info = $header_info->singleReadFullQry("
                SELECT s.id, s.staffId, s.civilId, s.ministryStaffId, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName, s.salutation, s.firstName, s.secondName, s.thirdName, s.lastName, s.firstNameArabic, s.secondNameArabic, s.thirdNameArabic, s.lastNameArabic, s.gender, s.maritalStatus, s.birthdate, s.joinDate, n.name as nationality, s.nationality_id, d.name as department, e.department_id, sc.name as section, e.section_id, j.name as jobtitle, e.jobtitle_id, p.title as staff_position, e.position_id, st.name as status, e.status_id, sp.name as specialization, e.specialization_id, q.name as qualification, e.qualification_id, spo.name as sponsor, e.sponsor_id, slr.name as salarygrade, e.salarygrade_id, e.employmenttype_id, pc.name as position_category, e.position_category_id 
                FROM staff as s 
                LEFT OUTER JOIN employmentdetail as e ON s.staffId = e.staff_id 
                LEFT OUTER JOIN department as d ON d.id = e.department_id 
                LEFT OUTER JOIN section as sc ON sc.id = e.section_id 
                LEFT OUTER JOIN jobtitle as j ON j.id = e.jobtitle_id
                LEFT OUTER JOIN staff_position as p ON p.id = e.position_id
                LEFT OUTER JOIN nationality as n ON n.id = s.nationality_id 
                LEFT OUTER JOIN status as st ON st.id = e.status_id 
                LEFT OUTER JOIN specialization as sp ON sp.id = e.specialization_id 
                LEFT OUTER JOIN qualification as q ON q.id = e.qualification_id
                LEFT OUTER JOIN sponsor as spo ON spo.id = e.sponsor_id
                LEFT OUTER JOIN salarygrade as slr ON slr.id = e.salarygrade_id
                LEFT OUTER JOIN position_category as pc ON pc.id = e.position_category_id
                WHERE e.isCurrent = 1 AND s.id = $id
                ");
                $mobile = $header_info->getContactInfo(1,$info['staffId'],'data');
                $email_add = $header_info->getContactInfo(2,$info['staffId'],'data');
            } else {
                header("Location: staff_list_active.php");
            }
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
                                <div class="col-md-5 col-8 align-self-center">
                                    <h3 class="text-themecolor m-b-0 m-t-0">Staff Work Experience and Trainings</h3>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">Home</a></li>
                                        <li class="breadcrumb-item">Staff Details </li>
                                        <li class="breadcrumb-item">Work Experience</li>
                                    </ol>
                                </div>
                                <?php include('include_time_in_info.php'); ?>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="card border-success">
                                        <div class="card-header" style="border-bottom: double; border-color: #28a745">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="profiletimeline">
                                                        <div class="sl-item">
                                                            <div class="sl-left"> <img src="<?php echo 'https://www.nct.edu.om/images/staff-photos/'.$info['staffId'].'.jpg'; ?>" alt="Staff" class="img-circle"/> </div>
                                                            <div class="sl-right">
                                                                <div><a href="#" class="link"><?php echo $info['staffName']; ?></a> <span class="sl-date text-primary">[Staff ID : <?php echo $info['staffId']; ?>]</span>
                                                                    <div class="like-comm">
                                                                        <a href="javascript:void(0)" class="link m-r-5"><?php echo $info['jobtitle']; ?></a> | 
                                                                        <a href="javascript:void(0)" class="link m-r-5"><?php echo $info['section']; ?></a> |
                                                                        <a href="javascript:void(0)" class="link m-r-5"><?php echo $info['department']; ?></a> 
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div><!--end profiletimeline-->
                                                </div>    
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="btn-toolbar btn-block" role="toolbar" aria-label="Toolbar with button groups">
                                                <div class="btn-group" role="group" aria-label="First group">
                                                    <a class="btn btn-secondary" href="staff_details.php?id=<?php echo $id; ?>" title="Click to view Staff Details" role="button"><span class="hidden-sm-up"><i class="fas fa-user-md"></i></span> <span class="hidden-xs-down"><i class="ti-angle-double-down"></i> Staff Details</a>
                                                    <a class="btn btn-secondary" href="staff_employment.php?id=<?php echo $id; ?>" title="Click to view Employment History" role="button"><span class="hidden-sm-up"><i class="ti-briefcase"></i></span> <span class="hidden-xs-down"><i class="ti-angle-double-down"></i> Employment History</a>                                                                            
                                                    <a class="btn btn-secondary" href="staff_legal_documents.php?id=<?php echo $id; ?>" title="Click to view Legal Documents" role="button"><span class="hidden-sm-up"><i class="far fa-credit-card"></i></span> <span class="hidden-xs-down"><i class="ti-angle-double-down"></i> Legal Documents</a>
                                                    <a class="btn btn-secondary" href="staff_qualification.php?id=<?php echo $id; ?>" title="Click to view Staff Qualification" role="button"><span class="hidden-sm-up"><i class="fas fa-graduation-cap"></i></span> <span class="hidden-xs-down"><i class="ti-angle-double-down"></i> Qualification</a>
                                                    <a class="btn btn-info" href="" title="Click to view Staff Work Experience" role="button"><span class="hidden-sm-up"><i class="fas fa-rocket"></i></span> <span class="hidden-xs-down"><i class="fas fa-edit"></i> Work Experience</a>
                                                    <a class="btn btn-secondary" href="staff_researches.php?id=<?php echo $id; ?>" title="Click to view Staff Researches" role="button"><span class="hidden-sm-up"><i class="ti-clipboard"></i></span> <span class="hidden-xs-down"><i class="ti-angle-double-down"></i> Researches</a>    
                                                    <a class="btn btn-secondary" href="staff_contacts.php?id=<?php echo $id; ?>" title="Click to view Staff Contacts" role="button"><span class="hidden-sm-up"><i class="far fa-address-book"></i></span> <span class="hidden-xs-down"><i class="ti-angle-double-down"></i> Contacts</a>    
                                                    <!-- <a class="btn btn-secondary" href="staff_family.php?id=<?php echo $id; ?>" title="Click to view Staff Family Information" role="button"><span class="hidden-sm-up"><i class="fas fa-users"></i></span> <span class="hidden-xs-down"><i class="ti-angle-double-down"></i> Family Information</a> -->    
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-5">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <?php 
                                                                if(isset($_POST['submit'])) {
                                                                    if (!empty($_FILES['fileToUpload']['name'])) {
                                                                        $target_dir = "attachments/workexperiences/";
                                                                        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
                                                                        $uploadOk = 1;
                                                                        $acceptable = array();
                                                                        $acceptable = array('application/pdf', 'image/jpeg', 'image/jpg', 'image/gif', 'image/png');
                                                                        
                                                                        if ($_FILES["fileToUpload"]["size"] > 2097152) {
                                                                            ?>
                                                                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                                <h4 class="alert-heading"><i class="fa fa-exclamation-triangle"></i> Upload Failed!</h4>
                                                                                <p>Sorry, file size is too large. Files size should be up to 2MB only.</p>
                                                                            </div>    
                                                                            <?php            
                                                                            $uploadOk = 0;
                                                                            
                                                                        }
                                                                        // Allow certain file formats
                                                                        if(!in_array($_FILES['fileToUpload']['type'], $acceptable) && (!empty($_FILES["fileToUpload"]["type"]))) {
                                                                            ?>
                                                                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                                <h4 class="alert-heading"><i class="fa fa-exclamation-triangle"></i> Upload Failed!</h4>
                                                                                <p>Sorry, only JPG, JPEG, PNG, GIF, PDF files are allowed to upload. File type not accepted.</p>
                                                                            </div>    
                                                                            <?php                
                                                                            $uploadOk = 0;
                                                                        }
                                                                        if ($uploadOk == 0) {
                                                                            ?>
                                                                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                                <h4 class="alert-heading"><i class="fa fa-exclamation-triangle"></i> Upload Failed!!!</h4>
                                                                                <p>File type and file size BOTH not acceptable. File type not accepted.</p>
                                                                            </div>
                                                                            <?php        
                                                                        } else { //if everything is ok, try to upload file
                                                                            $temp = explode(".", $_FILES["fileToUpload"]["name"]);
                                                                            $extension = end($temp);
                                                                            $auto = $helper->singleReadFullQry("SELECT TOP 1 id FROM staffworkexperience ORDER BY id DESC");
                                                                            $id_num = $auto['id'] + 1;
                                                                            $new_file_name = $_POST['staff_id']."_WorkExperience_".$id_num.".".$extension;
                                                                            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], "attachments/workexperiences/".$new_file_name)) {
                                                                                $new_image = "attachments/workexperiences/".$new_file_name;
                                                                                $fields = [
                                                                                    'staffId'=>$_POST['staff_id'],
                                                                                    'designation'=>$_POST['designation'],
                                                                                    'organizationName'=>$_POST['organization_name'],
                                                                                    'organizationType'=>$_POST['organization_type'],
                                                                                    'startDate'=>$helper->mySQLDate($_POST['emp_start_date']),
                                                                                    'endDate'=>$helper->mySQLDate($_POST['emp_end_date']),
                                                                                    'attachment'=>$new_image,
                                                                                    'enteredBy'=>$staffId
                                                                                ];
                                                                                //print_r($fields); exit;
                                                                                if($helper->insert("staffworkexperience",$fields)){
                                                                                    ?>
                                                                                        <script>
                                                                                            $(document).ready(function() {
                                                                                                $('#myModalNofification').modal('show');
                                                                                            });
                                                                                        </script>
                                                                                    <?php
                                                                                }                
                                                                            } else {
                                                                                ?>
                                                                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                                    <h4 class="alert-heading"><i class="fa fa-exclamation-triangle"></i> Upload Failed!</h4>
                                                                                    <p>Sorry, there was an error uploading your attachment, please try again.</p>
                                                                                </div>       
                                                                                <?php                
                                                                            }
                                                                        }
                                                                    }                                                                    
                                                                }
                                                                if(isset($_POST['update'])) {
                                                                    $id = $_POST['wid'];
                                                                    if (!empty($_FILES['fileToUpload']['name'])) {
                                                                        $target_dir = "attachments/workexperiences/";
                                                                        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
                                                                        $uploadOk = 1;
                                                                        $acceptable = array();
                                                                        $acceptable = array('application/pdf', 'image/jpeg', 'image/jpg', 'image/gif', 'image/png');
                                                                        
                                                                        if ($_FILES["fileToUpload"]["size"] > 2097152) {
                                                                            ?>
                                                                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                                <h4 class="alert-heading"><i class="fa fa-exclamation-triangle"></i> Upload Failed!</h4>
                                                                                <p>Sorry, file size is too large. Files size should be up to 2MB only.</p>
                                                                            </div>    
                                                                            <?php            
                                                                            $uploadOk = 0;
                                                                            
                                                                        }
                                                                        // Allow certain file formats
                                                                        if(!in_array($_FILES['fileToUpload']['type'], $acceptable) && (!empty($_FILES["fileToUpload"]["type"]))) {
                                                                            ?>
                                                                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                                <h4 class="alert-heading"><i class="fa fa-exclamation-triangle"></i> Upload Failed!</h4>
                                                                                <p>Sorry, only JPG, JPEG, PNG, GIF, PDF files are allowed to upload. File type not accepted.</p>
                                                                            </div>    
                                                                            <?php                
                                                                            $uploadOk = 0;
                                                                        }
                                                                        if ($uploadOk == 0) {
                                                                            ?>
                                                                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                                <h4 class="alert-heading"><i class="fa fa-exclamation-triangle"></i> Upload Failed!!!</h4>
                                                                                <p>File type and file size BOTH not acceptable. File type not accepted.</p>
                                                                            </div>
                                                                            <?php        
                                                                        } else { //if everything is ok, try to upload file
                                                                            $temp = explode(".", $_FILES["fileToUpload"]["name"]);
                                                                            $extension = end($temp);
                                                                            $new_file_name = $_POST['staff_id']."_WorkExperience_".$id.".".$extension;
                                                                            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], "attachments/workexperiences/".$new_file_name)) {
                                                                                $new_image = "attachments/workexperiences/".$new_file_name;
                                                                                $fields = [
                                                                                    'staffId'=>$_POST['staff_id'],
                                                                                    'designation'=>$_POST['designation'],
                                                                                    'organizationName'=>$_POST['organization_name'],
                                                                                    'organizationType'=>$_POST['organization_type'],
                                                                                    'startDate'=>$helper->mySQLDate($_POST['emp_start_date']),
                                                                                    'endDate'=>$helper->mySQLDate($_POST['emp_end_date']),
                                                                                    'attachment'=>$new_image,
                                                                                    'enteredBy'=>$staffId
                                                                                ];
                                                                                //echo $id;
                                                                                //print_r($fields); exit;
                                                                                
                                                                                if($helper->update("staffworkexperience",$fields,$id)){
                                                                                    ?>
                                                                                        <script>
                                                                                            $(document).ready(function() {
                                                                                                $('#myModalNofificationU').modal('show');
                                                                                            });
                                                                                        </script>
                                                                                    <?php
                                                                                }                
                                                                            } else {
                                                                                ?>
                                                                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                                    <h4 class="alert-heading"><i class="fa fa-exclamation-triangle"></i> Upload Failed!</h4>
                                                                                    <p>Sorry, there was an error uploading your attachment, please try again.</p>
                                                                                </div>       
                                                                                <?php                
                                                                            }
                                                                        }
                                                                    }                                                                    
                                                                }
                                                            ?>
                                                            <div class="d-flex flex-wrap">
                                                                <div>
                                                                    <h3 class="card-title">Work Experience Form</h3>
                                                                </div>
                                                            </div>
                                                            <form class="form-horizontal p-t-20" action="" method="POST" novalidate enctype="multipart/form-data">
                                                                <div class="form-group row">
                                                                    <label  class="col-sm-4 control-label text-right"><span class="text-danger">*</span>Designation</label>
                                                                    <div class="col-sm-8">
                                                                        <div class="controls">
                                                                            <div class="input-group">
                                                                                <input type="hidden" name="wid" class="wid" />
                                                                                <input name="staff_id" type="hidden" value="<?php echo $info['staffId']; ?>" />
                                                                                <textarea name="designation" class="form-control designation" required data-validation-required-message="Please enter Designation" ></textarea>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label  class="col-sm-4 control-label text-right"><span class="text-danger">*</span>Organization Name</label>
                                                                    <div class="col-sm-8">
                                                                        <div class="controls">
                                                                            <div class="input-group">
                                                                                <textarea name="organization_name" class="form-control organization_name" required data-validation-required-message="Please enter Organization Name" ></textarea>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label  class="col-sm-4 control-label text-right"><span class="text-danger">*</span>Organization Type</label>
                                                                    <div class="col-sm-8">
                                                                        <div class="controls">
                                                                            <div class="input-group">
                                                                                <select name="organization_type" class="form-control organization_type" required data-validation-required-message="Please select Organization Type from the list">
                                                                                    <option value="">Select Organization</option>
                                                                                    <option value="Academic">Academic</option>
                                                                                    <option value="Industry">Industry</option>
                                                                                </select>  
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>                                                
                                                                <div class="form-group row">
                                                                    <label for="" class="col-sm-4 control-label text-right"><span class="text-danger">*</span>Start Date</label>
                                                                    <div class="col-sm-8">
                                                                        <div class="controls">
                                                                            <div class="input-group">
                                                                                <input type="text" class="form-control emp_start_date" name="emp_start_date" id="emp_start_date" required data-validation-required-message="Please enter Start Date"/>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label for="" class="col-sm-4 control-label text-right"><span class="text-danger">*</span>End Date</label>
                                                                    <div class="col-sm-8">
                                                                        <div class="controls">
                                                                            <div class="input-group">
                                                                                <input type="text" class="form-control emp_end_date" name="emp_end_date" id="emp_end_date" required data-validation-required-message="Please enter End Date"/>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label  class="col-sm-4 control-label text-right"><span class="text-danger">*</span>Attachment</label>
                                                                    <div class="col-sm-8">
                                                                        <div class="controls">
                                                                            <div class="input-group">
                                                                                <input type="file" accept=".jpg, .jpeg, .png, .pdf" class="form-control" name="fileToUpload" required data-validation-required-message="Please attach the document" />
                                                                            </div>
                                                                            <div><small class="text-danger">Note: Only .jpg, .jpeg, .png, .pdf file extension is accepted. Maximum of 2MB (2,000 KB) is allowed per attachment.</small></div>
                                                                        </div>
                                                                    </div>
                                                                </div>                                                    
                                                                <div class="form-group row m-b-0">
                                                                    <div class="offset-sm-4 col-sm-8">
                                                                        <button type="submit" name="submit" class="btn btn-info waves-effect waves-light saveWork"><i class="fa fa-paper-plane"></i> Submit</button>
                                                                        <button type="reset" class="btn btn-inverse waves-effect waves-light resetWork"><i class="fa fa-retweet"></i> Reset</button>
                                                                        <button type="submit" name="update" class="btn btn-info waves-effect waves-light updateWork"><i class="fa fa-edit"></i> Update</button>
                                                                        <a href="" class="btn btn-danger waves-effect waves-light cancel"><i class="fa fa-ban"></i> Cancel</a>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!---------------------------------------------------------------------------------------------------------->
                                                <!---------------------------------------------------------------------------------------------------------->
                                                <div class="col-lg-7"><!---start list div-->
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="d-flex flex-wrap">
                                                                <div>
                                                                    <h3 class="card-title">Work Experience List</h3>
                                                                    <h6 class="card-subtitle">Arabic Text Here</h6>
                                                                </div>
                                                            </div>
                                                            <div class="table-responsive">
                                                                <table class="table">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>No</th>
                                                                            <th>Designation</th>
                                                                            <th>Name of Organization</th>
                                                                            <th>Type</th>
                                                                            <th>Start Date</th>
                                                                            <th>End Date</th>
                                                                            <th>Attachment</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php
                                                                            $staff_id = $info['staffId'];
                                                                            $rows = $helper->readData("SELECT * FROM staffworkexperience WHERE staffId = '$staff_id' ORDER BY id DESC");
                                                                            if($helper->totalCount != 0) {
                                                                                $i = 0;
                                                                                foreach($rows as $row) {
                                                                                    ?>
                                                                                        <tr>
                                                                                            <td><?php echo ++$i.'.'; ?></td>
                                                                                            <td><a class="text-success workName" style="cursor:pointer" data-id="<?php echo $row['id']; ?>"><?php echo $row['designation']; ?></a></td>
                                                                                            <td><?php echo $row['organizationName']; ?></td>
                                                                                            <td><?php echo $row['organizationType']; ?></td>
                                                                                            <td><?php echo date('d/m/Y',strtotime($row['startDate'])); ?></td>
                                                                                            <td><?php echo date('d/m/Y',strtotime($row['endDate'])); ?></td>
                                                                                            <td>
                                                                                                <button class="btn btn-primary btn-xs btn-block" data-toggle="modal" data-target="#myModal<?php echo $i; ?>">
                                                                                                    <i class="fa fa-search"></i> View Attachment
                                                                                                </button>
                                                                                                <div class="modal fade" id="myModal<?php echo $i; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                                                                    <div class="modal-dialog modal-lg">
                                                                                                        <div class="modal-content">
                                                                                                            <div class="modal-header">
                                                                                                                <h4 class="modal-title" id="myModalLabel">Attachment</h4> 
                                                                                                            </div>
                                                                                                            <div class="modal-body">
                                                                                                                <div style="text-align: center;">
                                                                                                                    <?php /*<iframe src="<?php echo $row['attachment']; ?>" style="width:750px; height:550px;" frameborder="0"></iframe>*/ ?>
                                                                                                                    <object width="750" height="550" data="<?php echo $row['attachment']; ?>"></object>
                                                                                                                    <!-- object tag will allow download of pdf files BUT NOT with image files -->
                                                                                                                </div>
                                                                                                            </div>
                                                                                                            <div class="modal-footer">
                                                                                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </td>
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
                                            <!------------------------------------------------------->
                                            <!------------------------------------------------------->
                                            <div><hr></div>
                                            <h3 class="text-primary">Staff Training / Seminar / Conference Attended</h3>
                                            <div class="row">
                                                <div class="col-lg-5">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <?php 
                                                                if(isset($_POST['submit2'])) {
                                                                    if (!empty($_FILES['fileToUpload']['name'])) {
                                                                        $target_dir = "attachments/seminars/";
                                                                        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
                                                                        $uploadOk = 1;
                                                                        $acceptable = array();
                                                                        $acceptable = array('application/pdf', 'image/jpeg', 'image/jpg', 'image/gif', 'image/png');
                                                                        
                                                                        if ($_FILES["fileToUpload"]["size"] > 2097152) {
                                                                            ?>
                                                                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                                <h4 class="alert-heading"><i class="fa fa-exclamation-triangle"></i> Upload Failed!</h4>
                                                                                <p>Sorry, file size is too large. Files size should be up to 2MB only.</p>
                                                                            </div>    
                                                                            <?php            
                                                                            $uploadOk = 0;
                                                                            
                                                                        }
                                                                        // Allow certain file formats
                                                                        if(!in_array($_FILES['fileToUpload']['type'], $acceptable) && (!empty($_FILES["fileToUpload"]["type"]))) {
                                                                            ?>
                                                                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                                <h4 class="alert-heading"><i class="fa fa-exclamation-triangle"></i> Upload Failed!</h4>
                                                                                <p>Sorry, only JPG, JPEG, PNG, GIF, PDF files are allowed to upload. File type not accepted.</p>
                                                                            </div>    
                                                                            <?php                
                                                                            $uploadOk = 0;
                                                                        }
                                                                        if ($uploadOk == 0) {
                                                                            ?>
                                                                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                                <h4 class="alert-heading"><i class="fa fa-exclamation-triangle"></i> Upload Failed!!!</h4>
                                                                                <p>File type and file size BOTH not acceptable. File type not accepted.</p>
                                                                            </div>
                                                                            <?php        
                                                                        } else { //if everything is ok, try to upload file
                                                                            $temp = explode(".", $_FILES["fileToUpload"]["name"]);
                                                                            $extension = end($temp);
                                                                            $auto = $helper->singleReadFullQry("SELECT TOP 1 id FROM stafftraining ORDER BY id DESC");
                                                                            $id_num = $auto['id'] + 1;
                                                                            $new_file_name = $_POST['staff_id']."_Seminars_".$id_num.".".$extension;
                                                                            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], "attachments/seminars/".$new_file_name)) {
                                                                                $new_image = "attachments/seminars/".$new_file_name;
                                                                                $fields = [
                                                                                    'staffId'=>$_POST['staff_id'],
                                                                                    'trainingtype_id'=>$_POST['category_name'],
                                                                                    'title'=>$_POST['title'],
                                                                                    'startDate'=>$helper->mySQLDate($_POST['train_start_date']),
                                                                                    'endDate'=>$helper->mySQLDate($_POST['train_end_date']),
                                                                                    'place'=>$_POST['train_place'],
                                                                                    'inCollege'=>$_POST['inCollege'],
                                                                                    'isSponsoredByCollege'=>$_POST['isSponsoredByCollege'],
                                                                                    'attachment'=>$new_image,
                                                                                    'createdBy'=>$staffId
                                                                                ];
                                                                                //print_r($fields); exit;
                                                                                if($helper->insert("stafftraining",$fields)){
                                                                                    ?>
                                                                                        <script>
                                                                                            $(document).ready(function() {
                                                                                                $('#myModalNofification2').modal('show');
                                                                                            });
                                                                                        </script>
                                                                                    <?php
                                                                                }                
                                                                            } else {
                                                                                ?>
                                                                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                                    <h4 class="alert-heading"><i class="fa fa-exclamation-triangle"></i> Upload Failed!</h4>
                                                                                    <p>Sorry, there was an error uploading your attachment, please try again.</p>
                                                                                </div>       
                                                                                <?php                
                                                                            }
                                                                        }
                                                                    }                                                                    
                                                                }

                                                                if(isset($_POST['update2'])) {
                                                                    $id = $_POST['sid'];
                                                                    if (!empty($_FILES['fileToUpload']['name'])) {
                                                                        $target_dir = "attachments/seminars/";
                                                                        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
                                                                        $uploadOk = 1;
                                                                        $acceptable = array();
                                                                        $acceptable = array('application/pdf', 'image/jpeg', 'image/jpg', 'image/gif', 'image/png');
                                                                        
                                                                        if ($_FILES["fileToUpload"]["size"] > 2097152) {
                                                                            ?>
                                                                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                                <h4 class="alert-heading"><i class="fa fa-exclamation-triangle"></i> Upload Failed!</h4>
                                                                                <p>Sorry, file size is too large. Files size should be up to 2MB only.</p>
                                                                            </div>    
                                                                            <?php            
                                                                            $uploadOk = 0;
                                                                            
                                                                        }
                                                                        // Allow certain file formats
                                                                        if(!in_array($_FILES['fileToUpload']['type'], $acceptable) && (!empty($_FILES["fileToUpload"]["type"]))) {
                                                                            ?>
                                                                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                                <h4 class="alert-heading"><i class="fa fa-exclamation-triangle"></i> Upload Failed!</h4>
                                                                                <p>Sorry, only JPG, JPEG, PNG, GIF, PDF files are allowed to upload. File type not accepted.</p>
                                                                            </div>    
                                                                            <?php                
                                                                            $uploadOk = 0;
                                                                        }
                                                                        if ($uploadOk == 0) {
                                                                            ?>
                                                                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                                <h4 class="alert-heading"><i class="fa fa-exclamation-triangle"></i> Upload Failed!!!</h4>
                                                                                <p>File type and file size BOTH not acceptable. File type not accepted.</p>
                                                                            </div>
                                                                            <?php        
                                                                        } else { //if everything is ok, try to upload file
                                                                            $temp = explode(".", $_FILES["fileToUpload"]["name"]);
                                                                            $extension = end($temp);
                                                                            $new_file_name = $_POST['staff_id']."_Seminars_".$id.".".$extension;
                                                                            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], "attachments/seminars/".$new_file_name)) {
                                                                                $new_image = "attachments/seminars/".$new_file_name;
                                                                                $fields = [
                                                                                    'staffId'=>$_POST['staff_id'],
                                                                                    'trainingtype_id'=>$_POST['category_name'],
                                                                                    'title'=>$_POST['title'],
                                                                                    'startDate'=>$helper->mySQLDate($_POST['train_start_date']),
                                                                                    'endDate'=>$helper->mySQLDate($_POST['train_end_date']),
                                                                                    'place'=>$_POST['train_place'],
                                                                                    'inCollege'=>$_POST['inCollege'],
                                                                                    'isSponsoredByCollege'=>$_POST['isSponsoredByCollege'],
                                                                                    'attachment'=>$new_image,
                                                                                    'createdBy'=>$staffId
                                                                                ];
                                                                                //print_r($fields); exit;
                                                                                 
                                                                                if($helper->update("stafftraining",$fields,$id)){
                                                                                    ?>
                                                                                        <script>
                                                                                            $(document).ready(function() {
                                                                                                $('#myModalNofificationUu').modal('show');
                                                                                            });
                                                                                        </script>
                                                                                    <?php
                                                                                }               
                                                                            } else {
                                                                                ?>
                                                                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                                    <h4 class="alert-heading"><i class="fa fa-exclamation-triangle"></i> Upload Failed!</h4>
                                                                                    <p>Sorry, there was an error uploading your attachment, please try again.</p>
                                                                                </div>       
                                                                                <?php                
                                                                            }
                                                                        }
                                                                    }                                                                    
                                                                }
                                                            ?>
                                                            <div class="d-flex flex-wrap">
                                                                <div>
                                                                    <h3 class="card-title">Training/Seminar/Conference Form</h3>
                                                                </div>
                                                            </div>
                                                            <form class="form-horizontal p-t-20" action="" method="POST" novalidate enctype="multipart/form-data">
                                                                <div class="form-group row">
                                                                    <label  class="col-sm-4 control-label text-right"><span class="text-danger">*</span>Category Name</label>
                                                                    <div class="col-sm-8">
                                                                        <div class="controls">
                                                                            <div class="input-group">
                                                                                <input type="hidden" name="sid" class="sid" />
                                                                                <input name="staff_id" type="hidden" value="<?php echo $info['staffId']; ?>" />
                                                                                <select name="category_name" class="form-control category_name" required data-validation-required-message="Please select Category Name from the list">
                                                                                    <option value="">Select Category</option>
                                                                                    <?php 
                                                                                        $rows = $helper->readData("SELECT id, name FROM trainingtype WHERE active = 1 ORDER BY id");
                                                                                        foreach ($rows as $row) {
                                                                                    ?>
                                                                                            <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                                                                    <?php            
                                                                                        }    
                                                                                    ?>
                                                                                </select>  
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label  class="col-sm-4 control-label text-right"><span class="text-danger">*</span>Title</label>
                                                                    <div class="col-sm-8">
                                                                        <div class="controls">
                                                                            <div class="input-group">
                                                                                <textarea name="title" class="form-control title" required data-validation-required-message="Please enter Title" ></textarea>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label for="" class="col-sm-4 control-label text-right"><span class="text-danger">*</span>Start Date</label>
                                                                    <div class="col-sm-8">
                                                                        <div class="controls">
                                                                            <div class="input-group">
                                                                                <input type="text" class="form-control train_start_date" name="train_start_date" id="train_start_date" required data-validation-required-message="Please enter Start Date"/>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label for="" class="col-sm-4 control-label text-right"><span class="text-danger">*</span>End Date</label>
                                                                    <div class="col-sm-8">
                                                                        <div class="controls">
                                                                            <div class="input-group">
                                                                                <input type="text" class="form-control train_end_date" name="train_end_date" id="train_end_date" required data-validation-required-message="Please enter End Date"/>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label  class="col-sm-4 control-label text-right"><span class="text-danger">*</span>Place</label>
                                                                    <div class="col-sm-8">
                                                                        <div class="controls">
                                                                            <div class="input-group">
                                                                                <textarea name="train_place" class="form-control train_place" required data-validation-required-message="Please enter Place of event" ></textarea>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>                                                    
                                                                <div class="form-group row">
                                                                    <label  class="col-sm-4 control-label text-right"><span class="text-danger">*</span>Inside College</label>
                                                                    <div class="col-sm-8">
                                                                        <div class="controls">
                                                                            <div class="input-group">
                                                                                <select name="inCollege" class="form-control inCollege" required data-validation-required-message="Please select option from the list">
                                                                                    <option value="">Select</option>
                                                                                    <option value="1">Yes</option>
                                                                                    <option value="2">No</option>
                                                                                </select>  
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label  class="col-sm-4 control-label text-right"><span class="text-danger">*</span>Sponsor by College</label>                                                    
                                                                    <div class="col-sm-8">
                                                                        <div class="controls">
                                                                            <div class="input-group">
                                                                                <select name="isSponsoredByCollege" class="form-control isSponsoredByCollege" required data-validation-required-message="Please select option from the list">
                                                                                    <option value="">Select</option>
                                                                                    <option value="1">Yes</option>
                                                                                    <option value="2">No</option>
                                                                                </select>  
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label  class="col-sm-4 control-label text-right"><span class="text-danger">*</span>Attachment</label>
                                                                    <div class="col-sm-8">
                                                                        <div class="controls">
                                                                            <div class="input-group">
                                                                                <input type="file" accept=".jpg, .jpeg, .png, .pdf" class="form-control" name="fileToUpload" required data-validation-required-message="Please attach the document" />
                                                                            </div>
                                                                        </div>
                                                                        <div><small class="text-danger">Note: Only .jpg, .jpeg, .png, .pdf file extension is accepted. Maximum of 2MB (2,000 KB) is allowed per attachment.</small></div>
                                                                    </div>
                                                                </div>                                                            
                                                                <div class="form-group row m-b-0">
                                                                    <div class="offset-sm-4 col-sm-8">
                                                                        <button type="submit" name="submit2" class="btn btn-info waves-effect waves-light saveTraining"><i class="fa fa-paper-plane"></i> Submit</button>
                                                                        <button type="reset" class="btn btn-inverse waves-effect waves-light resetTraining"><i class="fa fa-retweet"></i> Reset</button>
                                                                        <button type="submit" name="update2" class="btn btn-info waves-effect waves-light updateTraining"><i class="fa fa-edit"></i> Update</button>
                                                                        <a href="" class="btn btn-danger waves-effect waves-light cancelTraining"><i class="fa fa-ban"></i> Cancel</a>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!---------------------------------------------------------------------------------------------------------->
                                                <!---------------------------------------------------------------------------------------------------------->
                                                <div class="col-lg-7">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="d-flex flex-wrap">
                                                                <div>
                                                                    <h3 class="card-title">Training / Seminar / Conference List</h3>
                                                                    <h6 class="card-subtitle">Arabic Text Here</h6>
                                                                </div>
                                                            </div>
                                                            <div class="table-responsive">
                                                                <table class="table">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>No</th>
                                                                            <th>Category</th>
                                                                            <th>Title</th>
                                                                            <th>Start Date</th>
                                                                            <th>End Date</th>
                                                                            <th>Attachment</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php
                                                                            $rows = $helper->readData("SELECT e.*, t.name as trainingType FROM stafftraining as e LEFT OUTER JOIN trainingtype as t on t.id = e.trainingtype_id WHERE e.staffId = '$staff_id' ORDER BY e.id DESC");
                                                                            if($helper->totalCount != 0) {
                                                                                $i = 0;
                                                                                foreach($rows as $row) {
                                                                                    ?>
                                                                                        <tr>
                                                                                            <td><?php echo ++$i.'.'; ?></td>
                                                                                            <td><a class="text-success category" style="cursor:pointer" data-id="<?php echo $row['id']; ?>"><?php echo $row['trainingType']; ?></a></td>
                                                                                            <td><?php echo $row['title']; ?></td>
                                                                                            <td><?php echo date('d/m/Y',strtotime($row['startDate'])); ?></td>
                                                                                            <td><?php echo date('d/m/Y',strtotime($row['endDate'])); ?></td>
                                                                                            <td>
                                                                                                <button class="btn btn-primary btn-xs btn-block" data-toggle="modal" data-target="#myModal2<?php echo $i; ?>">
                                                                                                    <i class="fa fa-search"></i> View Attachment
                                                                                                </button>
                                                                                                <div class="modal fade" id="myModal2<?php echo $i; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                                                                    <div class="modal-dialog modal-lg">
                                                                                                        <div class="modal-content">
                                                                                                            <div class="modal-header">
                                                                                                                <h4 class="modal-title" id="myModalLabel">Staff Training / Seminar / Conference Attachment</h4> 
                                                                                                            </div>
                                                                                                            <div class="modal-body">
                                                                                                                <div style="text-align: center;">
                                                                                                                    <?php /*<iframe src="<?php echo $row['attachment']; ?>" style="width:750px; height:550px;" frameborder="0"></iframe>*/ ?>
                                                                                                                    <object width="750" height="550" data="<?php echo $row['attachment']; ?>"></object>
                                                                                                                    <!-- object tag will allow download of pdf files BUT NOT with image files -->
                                                                                                                </div>
                                                                                                            </div>
                                                                                                            <div class="modal-footer">
                                                                                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </td>
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
                        $('.updateWork').hide();
                        $('.cancel').hide();
                        $('.workName').click(function () {
                            $('.wid').val($(this).data('id'));
                            var id = $(this).data('id');
                            var data = {
                                id : id
                            }
                            $.ajax({
                                url  : 'ajaxpages/staff/workexperience/select_by_id.php'
                                ,type    : 'POST'
                                ,dataType: 'json'
                                ,data    : data
                                ,success : function(e){
                                    if(e.error == 1){
                                        bootbox.alert("<strong class='text-danger'><i class='fa fa-exclamation-triangle'></i> Unable To Continue!</strong><br/><br/>An error has been encountered during processing.");
                                    } else {
                                        $('.designation').val(e.designation);
                                        $('.organization_name').val(e.organizationName);
                                        $('.organization_type').val(e.organizationType);
                                        $('.emp_start_date').val(e.startDate);
                                        $('.emp_end_date').val(e.endDate);
                                        //hide saveWork
                                        $('.saveWork').hide();
                                        $('.resetWork').hide();
                                        $('.updateWork').show();
                                        $('.cancel').show();
                                    }   
                                }
                                ,error  : function(e){
                                }
                            });
                        });


                        $('.updateTraining').hide();
                        $('.cancelTraining').hide();
                        $('.category').click(function () {
                            $('.sid').val($(this).data('id'));
                            var id = $(this).data('id');
                            var data = {
                                id : id
                            }
                            $.ajax({
                                url  : 'ajaxpages/staff/training/select_by_id.php'
                                ,type    : 'POST'
                                ,dataType: 'json'
                                ,data    : data
                                ,success : function(e){
                                    if(e.error == 1){
                                        bootbox.alert("<strong class='text-danger'><i class='fa fa-exclamation-triangle'></i> Unable To Continue!</strong><br/><br/>An error has been encountered during processing.");
                                    } else {
                                        $('.category_name').append($('<option selected>').text(e.category).attr('value', e.category_id));
                                        $('.title').val(e.title);
                                        $('.organization_type').val(e.organizationType);
                                        $('.train_start_date').val(e.startDate);
                                        $('.train_end_date').val(e.endDate);
                                        $('.train_place').val(e.place);
                                        $('.inCollege').append($('<option selected>').text(e.inCollege).attr('value', e.inCollegeId));
                                        $('.isSponsoredByCollege').append($('<option selected>').text(e.isSponsoredByCollege).attr('value', e.isSponsoredByCollegeId));
                                        
                                        //hide saveWork
                                        $('.saveTraining').hide();
                                        $('.resetTraining').hide();
                                        $('.updateTraining').show();
                                        $('.cancelTraining').show();
                                    }   
                                }
                                ,error  : function(e){
                                }
                            });
                        });    
                    
                    });    
                </script>
                <script>
                    // Material Date picker    
                    $('#emp_start_date').bootstrapMaterialDatePicker({ weekStart: 0, time: false,format: 'DD/MM/YYYY' });
                    $('#emp_end_date').bootstrapMaterialDatePicker({ weekStart: 0, time: false,format: 'DD/MM/YYYY' });
                    $('#train_start_date').bootstrapMaterialDatePicker({ weekStart: 0, time: false,format: 'DD/MM/YYYY' });
                    $('#train_end_date').bootstrapMaterialDatePicker({ weekStart: 0, time: false,format: 'DD/MM/YYYY' });
                </script>
                <div class="modal fade" id="myModalNofification" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-body" style="text-align: center">
                                <h3 class="modal-title text-primary" id="myModalLabel"><i class='fa fa-info-circle'></i> Success</h3>
                                <h5>New work experience has been added and saved!</h5>
                                <a href="" class="btn btn-primary"><i class='fa fa-check'></i> OK</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="myModalNofificationU" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-body" style="text-align: center">
                                <h3 class="modal-title text-primary" id="myModalLabel"><i class='fa fa-info-circle'></i> Success</h3>
                                <h5>Work experience has been edited and updated!</h5>
                                <a href="" class="btn btn-primary"><i class='fa fa-check'></i> OK</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="myModalNofification2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-body" style="text-align: center">
                                <h3 class="modal-title text-primary" id="myModalLabel"><i class='fa fa-info-circle'></i> Success</h3>
                                <h5>New Staff Training / Seminar / Conference has been added and saved!</h5>
                                <a href="" class="btn btn-primary"><i class='fa fa-check'></i> OK</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="myModalNofificationUu" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-body" style="text-align: center">
                                <h3 class="modal-title text-primary" id="myModalLabel"><i class='fa fa-info-circle'></i> Success</h3>
                                <h5>Staff Training / Seminar / Conference has been edited and updated!</h5>
                                <a href="" class="btn btn-primary"><i class='fa fa-check'></i> OK</a>
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