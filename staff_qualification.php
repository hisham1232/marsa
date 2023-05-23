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
                                    <h3 class="text-themecolor m-b-0 m-t-0">Staff Qualification</h3>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">Home</a></li>
                                        <li class="breadcrumb-item">Staff Details </li>
                                        <li class="breadcrumb-item">Qualification</li>
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
                                                    <a class="btn btn-info" href="" title="Click to view Staff Qualification" role="button"><span class="hidden-sm-up"><i class="fas fa-graduation-cap"></i></span> <span class="hidden-xs-down"><i class="fas fa-edit"></i> Qualification</a>
                                                    <a class="btn btn-secondary" href="staff_work_experience.php?id=<?php echo $id; ?>" title="Click to view Staff Work Experience" role="button"><span class="hidden-sm-up"><i class="fas fa-rocket"></i></span> <span class="hidden-xs-down"><i class="ti-angle-double-down"></i> Work Experience</a>
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
                                                                        $target_dir = "attachments/qualifications/";
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
                                                                            $auto = $helper->singleReadFullQry("SELECT TOP 1 id FROM staffqualification ORDER BY id DESC");
                                                                            $id_num = $auto['id'] + 1;
                                                                            $new_file_name = $_POST['staff_id']."_Qualification_".$id_num.".".$extension;
                                                                            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], "attachments/qualifications/".$new_file_name)) {
                                                                                $new_image = "attachments/qualifications/".$new_file_name;
                                                                                $fields = [
                                                                                    'staffId'=>$_POST['staff_id'],
                                                                                    'degree_id'=>$_POST['degree_id'],
                                                                                    'certificate_id'=>$_POST['certificate_id'],
                                                                                    'graduateYear'=>$_POST['year_graduated'],
                                                                                    'institution'=>$_POST['college_name'],
                                                                                    'gpa'=>$_POST['gpa'],
                                                                                    'certificateNo'=>$_POST['certificate_no'],
                                                                                    'attachment'=>$new_image,
                                                                                    'created_by'=>$staffId
                                                                                ];
                                                                                if($helper->insert("staffqualification",$fields)){
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
                                                                    $id = $_POST['qid'];
                                                                    if (!empty($_FILES['fileToUpload']['name'])) {
                                                                        $target_dir = "attachments/qualifications/";
                                                                        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
                                                                        $uploadOk = 1;
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
                                                                                <h4 class="alert-heading"><i class="fa fa-exclamation-triangle"></i> Upload Failed!</h4>
                                                                                <p>File type and file size BOTH not acceptable. File type not accepted.</p>
                                                                            </div>
                                                                            <?php        
                                                                        } else { //if everything is ok, try to upload file
                                                                            $temp = explode(".", $_FILES["fileToUpload"]["name"]);
                                                                            $extension = end($temp);
                                                                            $new_file_name = $_POST['staff_id']."_Qualification_".$id.".".$extension;
                                                                            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], "attachments/qualifications/".$new_file_name)) {
                                                                                $new_image = "attachments/qualifications/".$new_file_name;
                                                                                $fields = [
                                                                                    'staffId'=>$_POST['staff_id'],
                                                                                    'degree_id'=>$_POST['degree_id'],
                                                                                    'certificate_id'=>$_POST['certificate_id'],
                                                                                    'graduateYear'=>$_POST['year_graduated'],
                                                                                    'institution'=>$_POST['college_name'],
                                                                                    'gpa'=>$_POST['gpa'],
                                                                                    'certificateNo'=>$_POST['certificate_no'],
                                                                                    'attachment'=>$new_image,
                                                                                    'created_by'=>$staffId
                                                                                ];
                                                                                //print_r($fields); exit;
                                                                                if($helper->update("staffqualification",$fields,$id)){
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
                                                                    <h3 class="card-title">Qualification Form</h3>
                                                            </div>
                                                            </div>
                                                            <form class="form-horizontal p-t-20" action="" method="POST" novalidate enctype="multipart/form-data">
                                                                <input type="hidden" name="qid" class="qid" />
                                                                <div class="form-group row">
                                                                    <label  class="col-sm-4 control-label text-right"><span class="text-danger">*</span>Degree</label>
                                                                    <div class="col-sm-8">
                                                                        <div class="controls">
                                                                            <div class="input-group">
                                                                                <select name="degree_id" class="form-control degree_id" required data-validation-required-message="Please select Degree from the list">
                                                                                    <option value="">Select Degree</option>
                                                                                    <?php 
                                                                                        $rows = $helper->readData("SELECT id, name FROM degree WHERE active = 1 ORDER BY id");
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
                                                                    <label  class="col-sm-4 control-label text-right"><span class="text-danger">*</span>Certificate Name</label>
                                                                    <div class="col-sm-8">
                                                                        <div class="controls">
                                                                            <div class="input-group">
                                                                                <select name="certificate_id" class="form-control certificate_id" required data-validation-required-message="Please select Certificate from the list">
                                                                                    <option value="">Select Certificate</option>
                                                                                    <?php 
                                                                                        $rows = $helper->readData("SELECT id, name FROM certificate WHERE active = 1 ORDER BY id");
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
                                                                    <label  class="col-sm-4 control-label text-right"><span class="text-danger">*</span>College Name</label>
                                                                    <div class="col-sm-8">
                                                                        <div class="controls">
                                                                            <div class="input-group">
                                                                                <input name="college_name" type="text" class="form-control college_name" required data-validation-required-message="Please enter College Name" />
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label  class="col-sm-4 control-label text-right"><span class="text-danger">*</span>Year Graduated</label>
                                                                    <div class="col-sm-8">
                                                                        <div class="controls">
                                                                            <div class="input-group">
                                                                                <select name="year_graduated" class="form-control year_graduated" required data-validation-required-message="Please select Year from the list">
                                                                                    <option value="">Select</option>
                                                                                    <?php
                                                                                        $earliest_year = 1970;
                                                                                        foreach (range(date('Y'), $earliest_year) as $x) {
                                                                                            echo '<option value="'.$x.'">'.$x.'</option>';
                                                                                        }
                                                                                    ?>
                                                                                </select>  
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label  class="col-sm-4 control-label text-right"><span class="text-danger">*</span>Certificate No.</label>
                                                                    <div class="col-sm-8">
                                                                        <div class="controls">
                                                                            <div class="input-group">
                                                                                <input name="certificate_no" type="text" class="form-control certificate_no" required data-validation-required-message="Please enter Certificate No"/>

                                                                            </div>
                                                                            <div><small class="text-danger">Note: Put N/A if Certificate No. is not available.</small></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label  class="col-sm-4 control-label text-right">GPA</label>
                                                                    <div class="col-sm-8">
                                                                        <div class="controls">
                                                                            <div class="input-group">
                                                                                <input name="gpa" type="text" class="form-control gpa" />
                                                                                <input name="staff_id" type="hidden" value="<?php echo $info['staffId']; ?>" />
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
                                                                        <button type="submit" name="submit" class="btn btn-info waves-effect waves-light saveQualification"><i class="fa fa-paper-plane"></i> Submit</button>
                                                                        <button type="reset" class="btn btn-inverse waves-effect waves-light resetQualification"><i class="fa fa-retweet"></i> Reset</button>
                                                                        <button type="submit" name="update" class="btn btn-info waves-effect waves-light updateQualification"><i class="fa fa-edit"></i> Update</button>
                                                                        <a href="" class="btn btn-danger waves-effect waves-light cancel"><i class="fa fa-ban"></i> Cancel</a>
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
                                                                    <h3 class="card-title">Staff's Qualification List</h3>
                                                                    <h6 class="card-subtitle">Arabic Text Here</h6>
                                                                </div>
                                                            </div>
                                                            <div class="table-responsive">
                                                                <table class="table">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>No.</th>
                                                                            <th>Degree</th>
                                                                            <th>Qualification Name</th>
                                                                            <th>Year Graduated</th>
                                                                            <th>GPA</th>
                                                                            <th>Attachment</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php
                                                                            $staff_id = $info['staffId'];
                                                                            $rows = $helper->readData("SELECT q.*, d.name as degree, c.name as certificate FROM staffqualification as q 
                                                                            LEFT OUTER JOIN degree as d on d.id = q.degree_id
                                                                            LEFT OUTER JOIN certificate as c on c.id = q.certificate_id
                                                                            WHERE q.staffId = '$staff_id'
                                                                            ORDER BY q.id DESC");
                                                                            
                                                                            if($helper->totalCount != 0) {
                                                                                $i = 0;
                                                                                foreach($rows as $row) {
                                                                                    ?>
                                                                                        <tr>
                                                                                            <td><?php echo ++$i.'.'; ?></td>
                                                                                            <td><a class="text-success degree_name" style="cursor:pointer" data-id="<?php echo $row['id']; ?>"><?php echo $row['degree']; ?></a></td>
                                                                                            <td><?php echo $row['certificate']; ?></td>
                                                                                            <td><?php echo $row['graduateYear']; ?></td>
                                                                                            <td><?php echo $row['gpa']; ?></td>
                                                                                            <td>
                                                                                                <button class="btn btn-primary btn-xs btn-block" data-toggle="modal" data-target="#myModal<?php echo $i; ?>">
                                                                                                    <i class="fa fa-search"></i> View Attachment
                                                                                                </button>
                                                                                                <div class="modal fade" id="myModal<?php echo $i; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                                                                    <div class="modal-dialog modal-lg">
                                                                                                        <div class="modal-content">
                                                                                                            <div class="modal-header">
                                                                                                                <h4 class="modal-title" id="myModalLabel">Qualification Attachment</h4> 
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
                                            <div><hr/></div>
                                            <h3 class="text-primary">Staff Extra Certificates</h3>
                                            <div class="row">
                                                <div class="col-lg-5">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <?php
                                                                if(isset($_POST['submit2'])) {
                                                                    if (!empty($_FILES['fileToUpload']['name'])) {
                                                                        $target_dir = "attachments/extracertificates/";
                                                                        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
                                                                        $uploadOk = 1;
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
                                                                                <h4 class="alert-heading"><i class="fa fa-exclamation-triangle"></i> Upload Failed!</h4>
                                                                                <p>File type and file size BOTH not acceptable. File type not accepted.</p>
                                                                            </div>
                                                                        <?php        
                                                                        } else { //if everything is ok, try to upload file
                                                                            $temp = explode(".", $_FILES["fileToUpload"]["name"]);
                                                                            $extension = end($temp);
                                                                            $auto = $helper->singleReadFullQry("SELECT TOP 1 id FROM staffextracertificate ORDER BY id DESC");
                                                                            $id_num = $auto['id'] + 1;
                                                                            $new_file_name = $_POST['staff_id']."_Extra-Certificate_".$id_num.".".$extension;
                                                                            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], "attachments/extracertificates/".$new_file_name)) {
                                                                                $new_image = "attachments/extracertificates/".$new_file_name;
                                                                                $fields = [
                                                                                    'staffId'=>$_POST['staff_id'],
                                                                                    'extracertificates_id'=>$_POST['certificate_id'],
                                                                                    'certificateNo'=>$_POST['certificate_number'],
                                                                                    'issuedDate'=>$helper->mySQLDate($_POST['issue_date']),
                                                                                    'issuedPlace'=>$_POST['issue_place'],
                                                                                    'attachment'=>$new_image,
                                                                                    'created_by'=>$staffId
                                                                                ];
                                                                                //echo $helper->displayArr($fields);
                                                                                if($helper->insert("staffextracertificate",$fields)){
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
                                                            ?>
                                                            <?php
                                                                if(isset($_POST['update2'])) {
                                                                    $id = $_POST['ecid'];
                                                                    if (!empty($_FILES['fileToUpload']['name'])) {
                                                                        $target_dir = "attachments/extracertificates/";
                                                                        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
                                                                        $uploadOk = 1;
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
                                                                                <h4 class="alert-heading"><i class="fa fa-exclamation-triangle"></i> Upload Failed!</h4>
                                                                                <p>File type and file size BOTH not acceptable. File type not accepted.</p>
                                                                            </div>
                                                                            <?php        
                                                                        } else { //if everything is ok, try to upload file
                                                                            $temp = explode(".", $_FILES["fileToUpload"]["name"]);
                                                                            $extension = end($temp);
                                                                            $auto = $helper->singleReadFullQry("SELECT TOP 1 id FROM staffextracertificate ORDER BY id DESC");
                                                                            
                                                                            $new_file_name = $_POST['staff_id']."_Extra-Certificate_".$id.".".$extension;
                                                                            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], "attachments/extracertificates/".$new_file_name)) {
                                                                                $new_image = "attachments/extracertificates/".$new_file_name;
                                                                                $fields = [
                                                                                    'staffId'=>$_POST['staff_id'],
                                                                                    'extracertificates_id'=>$_POST['certificate_id'],
                                                                                    'certificateNo'=>$_POST['certificate_number'],
                                                                                    'issuedDate'=>$helper->mySQLDate($_POST['issue_date']),
                                                                                    'issuedPlace'=>$_POST['issue_place'],
                                                                                    'attachment'=>$new_image,
                                                                                    'created_by'=>$staffId
                                                                                ];

                                                                                //print_r($fields); exit;
                                                                                
                                                                                if($helper->update("staffextracertificate",$fields,$id)){
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
                                                                    <h3 class="card-title">Extra Certificate Form</h3>
                                                                </div>
                                                            </div>
                                                            <form class="form-horizontal p-t-20" action="" method="POST" novalidate enctype="multipart/form-data">
                                                                <div class="form-group row">
                                                                    <label  class="col-sm-4 control-label text-right"><span class="text-danger">*</span>Certificate Name</label>
                                                                    <div class="col-sm-8">
                                                                        <div class="controls">
                                                                            <div class="input-group">
                                                                                <input type="hidden" name="ecid" class="ecid" />
                                                                                <select name="certificate_id" class="form-control certificate_name" required data-validation-required-message="Please select Certificate Name from the list">
                                                                                    <option value="">Select Certificate Name</option>
                                                                                    <?php 
                                                                                        $rows = $helper->readData("SELECT id, name FROM extracertificates WHERE active = 1 ORDER BY id");
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
                                                                    <label  class="col-sm-4 control-label text-right"><span class="text-danger">*</span>Certificate Number</label>
                                                                    <div class="col-sm-8">
                                                                        <div class="controls">
                                                                            <div class="input-group">
                                                                                <input type="text" class="form-control certificate_number" name="certificate_number" required data-validation-required-message="Please enter Certificate Number" />
                                                                            </div>
                                                                            <div><small class="text-danger">Note: Put N/A if Certificate No. is not available.</small></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label for="" class="col-sm-4 control-label text-right"><span class="text-danger">*</span>Date Issue</label>
                                                                    <div class="col-sm-8">
                                                                        <div class="controls">
                                                                            <div class="input-group">
                                                                                <input type="text" class="form-control issue_date" name="issue_date" id="issue_date" required data-validation-required-message="Please enter Date Issue"/>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label  class="col-sm-4 control-label text-right"><span class="text-danger">*</span>Place Issue</label>
                                                                    <div class="col-sm-8">
                                                                        <div class="controls">
                                                                            <div class="input-group">
                                                                                <input name="staff_id" type="hidden" value="<?php echo $info['staffId']; ?>" />        
                                                                                <input type="text" class="form-control issue_place" name="issue_place" required data-validation-required-message="Please enter Place Issue" />        
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
                                                                        <button type="submit" name="submit2" class="btn btn-info waves-effect waves-light saveCerts"><i class="fa fa-paper-plane"></i> Submit</button>
                                                                        <button type="reset" class="btn btn-inverse waves-effect waves-light resetCerts"><i class="fa fa-retweet"></i> Reset</button>
                                                                        <button type="submit" name="update2" class="btn btn-info waves-effect waves-light updateCerts"><i class="fa fa-edit"></i> Update</button>
                                                                        <a href="" class="btn btn-danger waves-effect waves-light cancelCerts"><i class="fa fa-ban"></i> Cancel</a>
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
                                                                    <h3 class="card-title">Staff Extra Certificate</h3>
                                                                    <h6 class="card-subtitle">Arabic Text Here</h6>
                                                                </div>
                                                            </div>
                                                            <div class="table-responsive">
                                                                <table class="table">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>No.</th>
                                                                            <th>Certificate Name</th>
                                                                            <th>Certificate No.</th>
                                                                            <th>Date Issue</th>
                                                                            <th>Place Issue</th>
                                                                            <th>Attachment</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php
                                                                            $rowsExC = $helper->readData("SELECT e.*, ec.name as extracertName FROM staffextracertificate as e 
                                                                            LEFT OUTER JOIN extracertificates as ec on ec.id = e.extracertificates_id
                                                                            WHERE e.staffId = '$staff_id'
                                                                            ORDER BY e.id DESC");
                                                                            if($helper->totalCount != 0) {
                                                                                $i = 0;
                                                                                foreach($rowsExC as $rowExC) {
                                                                                    ?>
                                                                                        <tr>
                                                                                            <td><?php echo ++$i.'.'; ?></td>
                                                                                            <td><a class="text-success cert_name" style="cursor:pointer" data-id="<?php echo $rowExC['id']; ?>"><?php echo $rowExC['extracertName']; ?></a></td>
                                                                                            <td><?php echo $rowExC['certificateNo']; ?></td>
                                                                                            <td><?php echo date('d/m/Y',strtotime($rowExC['issuedDate'])); ?></td>
                                                                                            <td><?php echo $rowExC['issuedPlace']; ?></td>
                                                                                            <td>
                                                                                                <button class="btn btn-primary btn-xs btn-block" data-toggle="modal" data-target="#myModal2<?php echo $i; ?>">
                                                                                                    <i class="fa fa-search"></i> View Attachment
                                                                                                </button>
                                                                                                <div class="modal fade" id="myModal2<?php echo $i; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                                                                    <div class="modal-dialog modal-lg">
                                                                                                        <div class="modal-content">
                                                                                                            <div class="modal-header">
                                                                                                                <h4 class="modal-title" id="myModalLabel">Extra Certificates Attachment</h4> 
                                                                                                            </div>
                                                                                                            <div class="modal-body">
                                                                                                                <div style="text-align: center;">
                                                                                                                    <?php /*<iframe src="<?php echo $row['attachment']; ?>" style="width:750px; height:550px;" frameborder="0"></iframe>*/ ?>
                                                                                                                    <object width="750" height="550" data="<?php echo $rowExC['attachment']; ?>"></object>
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
                        $('.updateQualification').hide();
                        $('.cancel').hide();
                        $('.degree_name').click(function () {
                            $('.qid').val($(this).data('id'));
                            var id = $(this).data('id');
                            var data = {
                                id : id
                            }
                            $.ajax({
                                url	 : 'ajaxpages/staff/qualification/select_by_id.php'
                                ,type	 : 'POST'
                                ,dataType: 'json'
                                ,data	 : data
                                ,success : function(e){
                                    if(e.error == 1){
                                        bootbox.alert("<strong class='text-danger'><i class='fa fa-exclamation-triangle'></i> Unable To Continue!</strong><br/><br/>An error has been encountered during processing.");
                                    } else {
                                        $('.degree_id').append($('<option selected>').text(e.degree_name).attr('value', e.degree_id));
                                        $('.certificate_id').append($('<option selected>').text(e.certificate_name).attr('value', e.certificate_id));
                                        $('.college_name').val(e.institution);
                                        $('.year_graduated').append($('<option selected>').text(e.graduateYear).attr('value', e.graduateYear));
                                        $('.certificate_no').val(e.certificate_no);
                                        $('.gpa').val(e.gpa);
                                        //hide saveQualification
                                        $('.saveQualification').hide();
                                        $('.resetQualification').hide();
                                        $('.updateQualification').show();
                                        $('.cancel').show();
                                    }	
                                }
                                ,error	: function(e){
                                }
                            });
                        });

                        $('.updateCerts').hide();
                        $('.cancelCerts').hide();
                        $('.cert_name').click(function () {
                            $('.ecid').val($(this).data('id'));
                            var id = $(this).data('id');
                            var data = {
                                id : id
                            }
                            $.ajax({
                                url  : 'ajaxpages/staff/extracertificate/select_by_id.php'
                                ,type    : 'POST'
                                ,dataType: 'json'
                                ,data    : data
                                ,success : function(e){
                                    if(e.error == 1){
                                        bootbox.alert("<strong class='text-danger'><i class='fa fa-exclamation-triangle'></i> Unable To Continue!</strong><br/><br/>An error has been encountered during processing.");
                                    } else {
                                        $('.certificate_name').append($('<option selected>').text(e.certificateName).attr('value', e.certificate_id));
                                        $('.certificate_number').val(e.certificateNo);
                                        $('.issue_date').val(e.dateIssue);
                                        $('.issue_place').val(e.placeIssue);
                                        //hide saveQualification
                                        $('.saveCerts').hide();
                                        $('.resetCerts').hide();
                                        $('.updateCerts').show();
                                        $('.cancelCerts').show();
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
                    $('#issue_date').bootstrapMaterialDatePicker({ weekStart: 0, time: false,format: 'DD/MM/YYYY' });
                </script>
                <div class="modal fade" id="myModalNofification" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-body" style="text-align: center">
                                <h3 class="modal-title text-primary" id="myModalLabel"><i class='fa fa-info-circle'></i> Success</h3>
                                <h5>New qualification has been added and saved!</h5>
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
                                <h5>Qualification has been edited and updated!</h5>
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
                                <h5>New extra certificates has been added and saved!</h5>
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
                                <h5>Extra certificates has been edited and updated!</h5>
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