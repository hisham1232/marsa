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
            $header_info = new DbaseManipulation;
            if(isset($_GET['id'])) { //Mali ito, temporary lang ito muna, ayusin katulad ng ginawa sa HR 2.0
                $id = $header_info->cleanString($_GET['id']);
                $info = $header_info->singleReadFullQry("
                SELECT s.id, s.staffId, s.civilId, s.ministryStaffId, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName, s.salutation, s.firstName, s.secondName, s.thirdName, s.lastName, s.firstNameArabic, s.secondNameArabic, s.thirdNameArabic, s.lastNameArabic, s.gender, s.maritalStatus, s.birthdate, s.joinDate, n.name as nationality, s.nationality_id, d.name as department, e.department_id, sc.name as section, e.section_id, j.name as jobtitle, e.jobtitle_id, p.title as staff_position, e.position_id, st.name as status, e.status_id, sp.name as specialization, e.specialization_id, q.name as qualification, e.qualification_id, spo.name as sponsor, e.sponsor_id, slr.name as salarygrade, e.salarygrade_id, e.employmenttype_id, pc.name as position_category, e.position_category_id, scv.attachment  
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
                LEFT OUTER JOIN staff_cv as scv ON s.staffId = scv.staff_id
                WHERE e.isCurrent = 1 AND s.id = $id
                ");
                $mobile = $header_info->getContactInfo(1,$info['staffId'],'data');
                $email_add = $header_info->getContactInfo(2,$info['staffId'],'data');
            } else {
                header("Location: staff_list_active.php");
            }
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
                                <div class="col-md-5 col-8 align-self-center">
                                    <h3 class="text-themecolor m-b-0 m-t-0">Staff Information Details</h3>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">Home</a></li>
                                        <li class="breadcrumb-item">Staff Details </li>
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
                                                </div><!--end row-->
                                            </div><!--end card header-->

                                            <div class="card-body">
                                                <div class="btn-toolbar btn-block" role="toolbar" aria-label="Toolbar with button groups">
                                                    <div class="btn-group" role="group" aria-label="First group">
                                                        <a class="btn btn-info" href="" title="Click to view Staff Details" role="button"><span class="hidden-sm-up"><i class="fas fa-user-md"></i></span> <span class="hidden-xs-down"><i class="fas fa-edit"></i> Staff Details</a>
                                                        <a class="btn btn-secondary" href="staff_employment.php?id=<?php echo $id; ?>" title="Click to view Employment History" role="button"><span class="hidden-sm-up"><i class="ti-briefcase"></i></span> <span class="hidden-xs-down"><i class="ti-angle-double-down"></i> Employment History</a>
                                                        <a class="btn btn-secondary" href="staff_legal_documents.php?id=<?php echo $id; ?>" title="Click to view Legal Documents" role="button"><span class="hidden-sm-up"><i class="far fa-credit-card"></i></span> <span class="hidden-xs-down"> <i class="ti-angle-double-down"></i>Legal Documents</a>
                                                        <a class="btn btn-secondary" href="staff_qualification.php?id=<?php echo $id; ?>" title="Click to view Staff Qualification" role="button"><span class="hidden-sm-up"><i class="fas fa-graduation-cap"></i></span> <span class="hidden-xs-down"><i class="ti-angle-double-down"></i> Qualification</a>
                                                        <a class="btn btn-secondary" href="staff_work_experience.php?id=<?php echo $id; ?>" title="Click to view Staff Work Experience" role="button"><span class="hidden-sm-up"><i class="fas fa-rocket"></i></span> <span class="hidden-xs-down"><i class="ti-angle-double-down"></i> Work Experience</a>
                                                        <a class="btn btn-secondary" href="staff_researches.php?id=<?php echo $id; ?>" title="Click to view Staff Researches" role="button"><span class="hidden-sm-up"><i class="ti-clipboard"></i></span> <span class="hidden-xs-down"><i class="ti-angle-double-down"></i> Researches</a>    
                                                        <a class="btn btn-secondary" href="staff_contacts.php?id=<?php echo $id; ?>" title="Click to view Staff Contacts" role="button"><span class="hidden-sm-up"><i class="far fa-address-book"></i></span> <span class="hidden-xs-down"><i class="ti-angle-double-down"></i> Contacts</a>    
                                                        <a class="btn btn-secondary" href="staff_family.php?id=<?php echo $id; ?>" title="Click to view Staff Family Information" role="button"><span class="hidden-sm-up"><i class="fas fa-users"></i></span> <span class="hidden-xs-down"><i class="ti-angle-double-down"></i> Family Information</a>    
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <script>
                                                                    if ( window.history.replaceState ) {
                                                                        window.history.replaceState( null, null, window.location.href );
                                                                    }
                                                                </script>
                                                                <?php
                                                                    if(isset($_POST['submitUpdate'])){
                                                                        $save = new DbaseManipulation;
                                                                        $id = $save->cleanString($_GET['id']);
                                                                        $staffId = $save->cleanString($_POST['staffId']); //required
                                                                        $civilId = $save->cleanString($_POST['civilId']); //required
                                                                        $ministryStaffId = $save->cleanString($_POST['ministryStaffId']);
                                                                        $salutation = $save->cleanString($_POST['salutation']); //required
                                                                        $firstName = $save->cleanString($_POST['firstName']); //required
                                                                        $secondName = $save->cleanString($_POST['secondName']);
                                                                        $thirdName = $save->cleanString($_POST['thirdName']);
                                                                        $lastName = $save->cleanString($_POST['lastName']); //required
                                                                        $firstNameArabic = $save->cleanString($_POST['firstNameArabic']);
                                                                        $secondNameArabic = $save->cleanString($_POST['secondNameArabic']);
                                                                        $thirdNameArabic = $save->cleanString($_POST['thirdNameArabic']);
                                                                        $lastNameArabic = $save->cleanString($_POST['lastNameArabic']);    
                                                                        if(!empty($_POST['birthdate'])) {
                                                                            $birthdate = $save->cleanString($_POST['birthdate']);
                                                                            $birthdate = $save->mySQLDate($birthdate);
                                                                        } else {
                                                                            $birthdate = date("Y-m-d",time());
                                                                        }    
                                                                        $gender = $save->cleanString($_POST['gender']);
                                                                        $joinDate = $save->cleanString($_POST['joinDate']);
                                                                        $joinDate = $save->mySQLDate($joinDate);
                                                                        $maritalStatus = $save->cleanString($_POST['maritalStatus']);
                                                                        if(!empty($_POST['nationality_id'])) {
                                                                            $nationality_id = $save->cleanString($_POST['nationality_id']);
                                                                        } else {
                                                                            $nationality_id = 194;
                                                                        }
                                                                        $gsm = $save->cleanString($_POST['gsm']);
                                                                        $email = $save->cleanString($_POST['email']);

                                                                        $fieldsStaff = [
                                                                            'civilId'=>$civilId,
                                                                            'salutation'=>$salutation,
                                                                            'firstName'=>$firstName,
                                                                            'secondName'=>$secondName,
                                                                            'thirdName'=>$thirdName,
                                                                            'lastName'=>$lastName,
                                                                            'firstNameArabic'=>$firstNameArabic,
                                                                            'secondNameArabic'=>$secondNameArabic,
                                                                            'thirdNameArabic'=>$thirdNameArabic,
                                                                            'lastNameArabic'=>$lastNameArabic,
                                                                            'birthdate'=>$birthdate,
                                                                            'gender'=>$gender,
                                                                            'joinDate'=>$joinDate,
                                                                            'maritalStatus'=>$maritalStatus,
                                                                            'nationality_id'=>$nationality_id
                                                                        ];
                                                                        if($save->update("staff",$fieldsStaff,$id)) {
                                                                            $save->executeSQL("UPDATE contactdetails SET data = '$email' WHERE contacttype_id = 2 AND staff_id = $staffId");
                                                                            $save->executeSQL("UPDATE contactdetails SET data = '$gsm' WHERE contacttype_id = 1 AND staff_id = $staffId");  

                                                                            if (!empty($_FILES['fileToUpload']['name'])) {
                                                                                $uploadOk = 1;
                                                                                $errorNo = 0;
                                                                                $acceptable = array("application/pdf");
                                                                                  
                                                                                if ($_FILES["fileToUpload"]["size"] > 10485760) {
                                                                                    $uploadOk = 0;
                                                                                    $errorNo = 1;
                                                                                    $errMsg = "File size is too big. Only 10MB is the maximum allowed file size.";
                                                                                }
                                                                                if (!in_array($_FILES['fileToUpload']['type'], $acceptable) && (!empty($_FILES["fileToUpload"]["type"]))) { //Allow certain file formats
                                                                                    $uploadOk = 0;
                                                                                    $errorNo = 2;
                                                                                    $errMsg = "Sorry, PDF file extensions are allowed to upload. File type not accepted.";
                                                                                }
                                                                                if ($uploadOk == 0) {
                                                                                    if($errorNo == 1) {
                                                                                        ?>
                                                                                        <br/>
                                                                                        <div class="alert alert-danger">
                                                                                            <h4 class="alert-heading"><i class="fa fa-exclamation-triangle"></i> CV Upload Failed!</h4>
                                                                                            <p><?php echo $errMsg; ?></p>
                                                                                        </div>
                                                                                        <?php        
                                                                                    } else if ($errorNo == 2) {
                                                                                        ?>
                                                                                        <br/>
                                                                                        <div class="alert alert-danger">
                                                                                            <h4 class="alert-heading"><i class="fa fa-exclamation-triangle"></i> CV Upload Failed!</h4>
                                                                                            <p><?php echo $errMsg; ?></p>
                                                                                        </div>
                                                                                        <?php
                                                                                    }   
                                                                                } else { //if everything is ok, try to upload file
                                                                                    $temp = explode(".", $_FILES["fileToUpload"]["name"]);
                                                                                    $extension = end($temp);
                                                                                    $new_file_name = $staffId.".".$extension;
                                                                                    $row = $helper->singleReadFullQry("SELECT TOP 1 * FROM staff_cv WHERE staff_id = '$staffId'");
                                                                                    if($helper->totalCount != 0) {
                                                                                        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], "attachments/cv/".$new_file_name)) {
                                                                                            $attachment = "attachments/cv/".$new_file_name;
                                                                                            //Update the table
                                                                                            $updateCV = new DbaseManipulation;
                                                                                            $updateCV->executeSQL("UPDATE staff_cv SET attachment = '$attachment' WHERE staff_id = '$staffId'");
                                                                                        } else {
                                                                                            ?>
                                                                                            <br/>
                                                                                            <div class="alert alert-danger">
                                                                                                <h4 class="alert-heading"><i class="fa fa-exclamation-triangle"></i> CV Upload Failed!</h4>
                                                                                                <p>File size is too big. Only 10MB is the maximum allowed file size.</p>
                                                                                            </div>       
                                                                                            <?php 
                                                                                            die();               
                                                                                        }
                                                                                    } else {
                                                                                        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], "attachments/cv/".$new_file_name)) {
                                                                                            $attachment = "attachments/cv/".$new_file_name;
                                                                                            //Insert into the table
                                                                                            $date = date('Y-m-d H:i:s',time());
                                                                                            $saveCV = new DbaseManipulation;
                                                                                            $saveCV->executeSQL("INSERT INTO staff_cv (staff_id, attachment, added_by, date_added) VALUES ('$staffId', '$attachment', '$loggedInStaffId', '$date')");
                                                                                        } else {
                                                                                            ?>
                                                                                            <br/>
                                                                                            <div class="alert alert-danger">
                                                                                                <h4 class="alert-heading"><i class="fa fa-exclamation-triangle"></i> CV Upload Failed!</h4>
                                                                                                <p>File size is too big. Only 10MB is the maximum allowed file size.</p>
                                                                                            </div>       
                                                                                            <?php 
                                                                                            die();               
                                                                                        }
                                                                                    }    
                                                                                }
                                                                            }
                                                                            ?>
                                                                            <div class="alert alert-success" role="alert">
                                                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                                <h4 class="alert-heading"><i class="fa fa-info-circle"></i> Update Successful!</h4>
                                                                                <p>Staff basic information has been edited and updated! Kindly refresh this page (F5) to see changes.</p>
                                                                            </div>
                                                                            <?php
                                                                        }        
                                                                    }
                                                                ?>
                                                                <!-- <div class="alert alert-warning" role="alert">
                                                                    <h4 class="alert-heading"><i class="fa fa-exclamation-triangle"></i> Staff Details Form Reminder!</h4>
                                                                    <small>Read-only fields like <strong>department, section, job title, sponsor, salary grade, employment, status, etc.</strong> must be edit and update in Employment History Tab.</small>
                                                                </div> -->
                                                            </div>
                                                            <div class="card-body">
                                                                <form  class="form-horizontal" action="" method="POST" novalidate enctype="multipart/form-data">
                                                                    <div class="row">
                                                                        <!--First Column col-lg-4-->
                                                                        <div class="col-lg-4">
                                                                            <div class="form-group row">
                                                                                <label class="col-sm-4 text-right control-label col-form-label">Title</label>
                                                                                <div class="col-sm-8">
                                                                                    <div class="controls">
                                                                                        <div class="input-group">
                                                                                            <select name="salutation" class="form-control select2" required data-validation-required-message="Please select title">
                                                                                                <?php
                                                                                                    $salutations = array("Mr.", "Mrs.", "Ms.", "Dr.");
                                                                                                    foreach ($salutations as $row) {
                                                                                                        if($info['salutation'] == $row) {
                                                                                                ?>
                                                                                                            <option value="<?php echo $info['salutation']; ?>" selected><?php echo $info['salutation']; ?></option>
                                                                                                <?php        
                                                                                                        } else {
                                                                                                ?>
                                                                                                            <option value="<?php echo $row; ?>"><?php echo $row; ?></option>
                                                                                                <?php            
                                                                                                        }
                                                                                                    }        
                                                                                                ?>
                                                                                            </select>   
                                                                                        </div><!--end input-group-->
                                                                                    </div><!--end controls-->
                                                                                </div><!--end col-sm-8-->
                                                                            </div>
                                                                            <div class="form-group row">
                                                                                <label class="col-sm-4 text-right control-label col-form-label">First Name</label>
                                                                                <div class="col-sm-8">
                                                                                    <div class="controls">
                                                                                        <div class="input-group">
                                                                                            <input type="text" value="<?php echo $info['firstName']; ?>" name="firstName" class="form-control firstName" required data-validation-required-message="Please enter first name"/>   
                                                                                        </div><!--end input-group-->
                                                                                    </div><!--end controls-->
                                                                                </div><!--end col-sm-8-->
                                                                            </div>
                                                                            <div class="form-group row">
                                                                                <label class="col-sm-4 text-right control-label col-form-label">Second Name</label>
                                                                                <div class="col-sm-8">
                                                                                    <div class="controls">
                                                                                        <div class="input-group">
                                                                                            <input type="text" value="<?php echo $info['secondName']; ?>" name="secondName" class="form-control" />   
                                                                                        </div><!--end input-group-->
                                                                                    </div><!--end controls-->
                                                                                </div><!--end col-sm-8-->
                                                                            </div>
                                                                            <div class="form-group row">
                                                                                <label class="col-sm-4 text-right control-label col-form-label">Third Name</label>
                                                                                <div class="col-sm-8">
                                                                                    <div class="controls">
                                                                                        <div class="input-group">
                                                                                            <input type="text" value="<?php echo $info['thirdName']; ?>" name="thirdName" class="form-control"/>   
                                                                                        </div><!--end input-group-->
                                                                                    </div><!--end controls-->
                                                                                </div><!--end col-sm-8-->
                                                                            </div>
                                                                            <div class="form-group row">
                                                                                <label class="col-sm-4 text-right control-label col-form-label">Last Name</label>
                                                                                <div class="col-sm-8">
                                                                                    <div class="controls">
                                                                                        <div class="input-group">
                                                                                            <input type="text" value="<?php echo $info['lastName']; ?>" name="lastName" class="form-control" required data-validation-required-message="Please enter last name"/>   
                                                                                        </div><!--end input-group-->
                                                                                    </div><!--end controls-->
                                                                                </div><!--end col-sm-8-->
                                                                            </div>
                                                                            <div class="form-group row">
                                                                                <label class="col-sm-4 text-right control-label col-form-label">Arabic First Name</label>
                                                                                <div class="col-sm-8">
                                                                                    <div class="controls">
                                                                                        <div class="input-group">
                                                                                            <input type="text" value="<?php echo $info['firstNameArabic']; ?>" name="firstNameArabic" class="form-control" />   
                                                                                        </div><!--end input-group-->
                                                                                    </div><!--end controls-->
                                                                                </div><!--end col-sm-8-->
                                                                            </div>
                                                                            <div class="form-group row">
                                                                                <label class="col-sm-4 text-right control-label col-form-label">Arabic Second Name</label>
                                                                                <div class="col-sm-8">
                                                                                    <div class="controls">
                                                                                        <div class="input-group">
                                                                                            <input type="text" value="<?php echo $info['secondNameArabic']; ?>" name="secondNameArabic" class="form-control" />   
                                                                                        </div><!--end input-group-->
                                                                                    </div><!--end controls-->
                                                                                </div><!--end col-sm-8-->
                                                                            </div>
                                                                            <div class="form-group row">
                                                                                <label class="col-sm-4 text-right control-label col-form-label">Arabic Third Name</label>
                                                                                <div class="col-sm-8">
                                                                                    <div class="controls">
                                                                                        <div class="input-group">
                                                                                            <input type="text" value="<?php echo $info['thirdNameArabic']; ?>" name="thirdNameArabic" class="form-control"/>   
                                                                                        </div><!--end input-group-->
                                                                                    </div><!--end controls-->
                                                                                </div><!--end col-sm-8-->
                                                                            </div>
                                                                            <div class="form-group row">
                                                                                <label class="col-sm-4 text-right control-label col-form-label">Arabic Last Name</label>
                                                                                <div class="col-sm-8">
                                                                                    <div class="controls">
                                                                                        <div class="input-group">
                                                                                            <input type="text" value="<?php echo $info['lastNameArabic']; ?>" name="lastNameArabic" class="form-control"/>   
                                                                                        </div><!--end input-group-->
                                                                                    </div><!--end controls-->
                                                                                </div><!--end col-sm-8-->
                                                                            </div>
                                                                        </div>
                                                                        <!--End First Column col-lg-4-->
                                                                        
                                                                        <!--Second Column col-lg-4-->
                                                                        <div class="col-lg-4">
                                                                            <div class="form-group row">
                                                                                <label class="col-sm-4 text-right control-label col-form-label">Staff ID</label>
                                                                                <div class="col-sm-8">
                                                                                    <div class="controls">
                                                                                        <div class="input-group">
                                                                                            <input type="text" value="<?php echo $info['staffId']; ?>" name="staffId" class="form-control" required data-validation-containsnumber-regex="(\d)+" data-validation-containsnumber-message="No Characters Allowed, Numeric values only" maxlength="7" readonly />  
                                                                                        </div><!--end input-group-->
                                                                                    </div><!--end controls-->
                                                                                </div><!--end col-sm-8-->
                                                                            </div>
                                                                            <div class="form-group row">
                                                                                <label class="col-sm-4 text-right control-label col-form-label">Civil ID</label>
                                                                                <div class="col-sm-8">
                                                                                    <div class="controls">
                                                                                        <div class="input-group">
                                                                                            <input type="text" value="<?php echo $info['civilId']; ?>" name="civilId" class="form-control" required data-validation-containsnumber-regex="(\d)+" data-validation-containsnumber-message="No Characters Allowed, Numeric values only" maxlength="9" />   
                                                                                        </div><!--end input-group-->
                                                                                    </div><!--end controls-->
                                                                                </div><!--end col-sm-8-->
                                                                            </div>
                                                                            <div class="form-group row">
                                                                                <label class="col-sm-4 text-right control-label col-form-label">Ministry ID</label>
                                                                                <div class="col-sm-8">
                                                                                    <div class="controls">
                                                                                        <div class="input-group">
                                                                                            <input type="text" value="<?php echo $info['ministryStaffId']; ?>" name="ministryStaffId" class="form-control" data-validation-containsnumber-regex="(\d)+" data-validation-containsnumber-message="No Characters Allowed, Numeric values only" readonly />   
                                                                                        </div><!--end input-group-->
                                                                                    </div><!--end controls-->
                                                                                </div><!--end col-sm-8-->
                                                                            </div>
                                                                            <div class="form-group row">
                                                                                <label class="col-sm-4 text-right control-label col-form-label">Gender</label>
                                                                                <div class="col-sm-8">
                                                                                    <div class="controls">
                                                                                        <div class="input-group">
                                                                                            <select name="gender" class="form-control select2">
                                                                                                <option value="">Select Gender</option>
                                                                                                <?php
                                                                                                    $genders = array("Male", "Female");
                                                                                                    foreach ($genders as $row) {
                                                                                                        if($info['gender'] == $row) {
                                                                                                ?>
                                                                                                            <option value="<?php echo $info['gender']; ?>" selected><?php echo $info['gender']; ?></option>
                                                                                                <?php        
                                                                                                        } else {
                                                                                                ?>
                                                                                                            <option value="<?php echo $row; ?>"><?php echo $row; ?></option>
                                                                                                <?php            
                                                                                                        }
                                                                                                    }        
                                                                                                ?>
                                                                                            </select>    
                                                                                        </div><!--end input-group-->
                                                                                    </div><!--end controls-->
                                                                                </div><!--end col-sm-8-->
                                                                            </div>
                                                                            <div class="form-group row">
                                                                                <label class="col-sm-4 text-right control-label col-form-label">Marital Status</label>
                                                                                <div class="col-sm-8">
                                                                                    <div class="controls">
                                                                                        <div class="input-group">
                                                                                            <select name="maritalStatus" class="form-control select2">
                                                                                                <option value="">Select Marital Status</option>
                                                                                                <?php
                                                                                                    $maritals = array("Single", "Married", "Divorced", "Widowed");
                                                                                                    foreach ($maritals as $row) {
                                                                                                        if($info['maritalStatus'] == $row) {
                                                                                                ?>
                                                                                                            <option value="<?php echo $info['maritalStatus']; ?>" selected><?php echo $info['maritalStatus']; ?></option>
                                                                                                <?php        
                                                                                                        } else {
                                                                                                ?>
                                                                                                            <option value="<?php echo $row; ?>"><?php echo $row; ?></option>
                                                                                                <?php            
                                                                                                        }
                                                                                                    }        
                                                                                                ?>
                                                                                            </select>    
                                                                                        </div><!--end input-group-->
                                                                                    </div><!--end controls-->
                                                                                </div><!--end col-sm-8-->
                                                                            </div>
                                                                            <div class="form-group row">
                                                                                <label class="col-sm-4 text-right control-label col-form-label">Nationality</label>
                                                                                <div class="col-sm-8">
                                                                                    <div class="controls">
                                                                                        <div class="input-group">
                                                                                            <select name="nationality_id" class="form-control select2">
                                                                                                <option value="">Select Nationality</option>
                                                                                                <?php 
                                                                                                    $nationalities = new DbaseManipulation;
                                                                                                    $rows = $nationalities->readData("SELECT * FROM nationality");
                                                                                                    foreach ($rows as $row) {
                                                                                                        if($info['nationality_id'] == $row['id']) {
                                                                                                ?>
                                                                                                            <option value="<?php echo $info['nationality_id']; ?>" selected><?php echo $info['nationality']; ?></option>
                                                                                                <?php            
                                                                                                        } else {
                                                                                                ?>
                                                                                                            <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                                                                                <?php           
                                                                                                        } 
                                                                                                    }    
                                                                                                ?>
                                                                                            </select>    
                                                                                        </div><!--end input-group-->
                                                                                    </div><!--end controls-->
                                                                                </div><!--end col-sm-8-->
                                                                            </div>
                                                                            <div class="form-group row">
                                                                                <label class="col-sm-4 text-right control-label col-form-label">Birth Date</label>
                                                                                <div class="col-sm-8">
                                                                                    <div class="controls">
                                                                                        <div class="input-group">
                                                                                            <input type="text" value="<?php echo date('d/m/Y',strtotime($info['birthdate'])); ?>" class="form-control" name="birthdate" id="birthday_date"/>   
                                                                                        </div><!--end input-group-->
                                                                                    </div><!--end controls-->
                                                                                </div><!--end col-sm-8-->
                                                                            </div>
                                                                            <div class="form-group row">
                                                                                <label class="col-sm-4 text-right control-label col-form-label">GSM</label>
                                                                                <div class="col-sm-8">
                                                                                    <div class="controls">
                                                                                        <div class="input-group">
                                                                                            <input type="text" value="<?php echo $mobile; ?>" name="gsm" class="form-control" required data-validation-containsnumber-regex="(\d)+" data-validation-containsnumber-message="No Characters Allowed, Numeric values only" maxlength="8" />   
                                                                                        </div><!--end input-group-->
                                                                                    </div><!--end controls-->
                                                                                </div><!--end col-sm-8-->
                                                                            </div>
                                                                            <div class="form-group row">
                                                                                <label class="col-sm-4 text-right control-label col-form-label">Email Address</label>
                                                                                <div class="col-sm-8">
                                                                                    <div class="controls">
                                                                                        <div class="input-group">
                                                                                            <input type="text" value="<?php echo $email_add; ?>" name="email" class="form-control" data-validation-regex-regex="([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})" data-validation-regex-message="Enter Valid Email">   
                                                                                        </div><!--end input-group-->
                                                                                    </div><!--end controls-->
                                                                                </div><!--end col-sm-8-->
                                                                            </div>
                                                                            <div class="form-group row">
                                                                                <label class="col-sm-4 text-right control-label col-form-label">Join Date</label>
                                                                                <div class="col-sm-8">
                                                                                    <div class="controls">
                                                                                        <div class="input-group">
                                                                                            <input type="text" value="<?php echo date('d/m/Y',strtotime($info['joinDate'])); ?>" class="form-control" name="joinDate" id="join_date" required data-validation-required-message="Please enter joining date"/>
                                                                                        </div><!--end input-group-->
                                                                                    </div><!--end controls-->
                                                                                </div><!--end col-sm-8-->
                                                                            </div>


                                                                            <div class="form-group row">
                                                                                <label class="col-sm-4 text-right control-label col-form-label">Curriculum Vitae</label>
                                                                                <div class="col-sm-8">
                                                                                    <div class="controls">
                                                                                        <div class="input-group">
                                                                                            <input type="file" name="fileToUpload" accept=".pdf" class="form-control">
                                                                                        </div>
                                                                                        <p class="text-danger">PDF Only</p>
                                                                                        <button type="button" class="btn btn-primary btn-xs btn-block" data-toggle="modal" data-target="#myModal"><i class="fa fa-search"></i> View CV </button>
                                                                                        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                                                            <div class="modal-dialog modal-lg">
                                                                                                <div class="modal-content">
                                                                                                    <div class="modal-header">
                                                                                                        <h4 class="modal-title" id="myModalLabel">Qualification Attachment</h4> 
                                                                                                    </div>
                                                                                                    <div class="modal-body">
                                                                                                        <div style="text-align: center;">
                                                                                                            <object width="750" height="750" data="<?php echo $info['attachment']; ?>"></object>
                                                                                                            <!-- object tag will allow download of pdf files BUT NOT with image files -->
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="modal-footer">
                                                                                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div><!--end controls-->
                                                                                </div><!--end col-sm-8-->
                                                                            </div>
                                                                        </div>
                                                                        <!--End Second Column col-lg-4-->
                                                                        
                                                                        <!--Third Column col-lg-4-->    
                                                                        <div class="col-lg-4">
                                                                            <div class="form-group row">
                                                                                <label class="col-sm-4 text-right control-label col-form-label">Specialization</label>
                                                                                <div class="col-sm-8">
                                                                                    <div class="controls">
                                                                                        <div class="input-group">
                                                                                        <input type="text" value="<?php echo $info['specialization']; ?>" class="form-control" readonly />        
                                                                                            <?php /*<select name="specialization_id" class="form-control select2">
                                                                                                <option value="0">Select Specialization</option>
                                                                                                <?php 
                                                                                                    $specialization = new DbaseManipulation;
                                                                                                    $rows = $specialization->readData("SELECT id, name FROM specialization");
                                                                                                    foreach ($rows as $row) {
                                                                                                        if($info['specialization_id'] == $row['id']) {
                                                                                                ?>
                                                                                                            <option value="<?php echo $info['specialization_id']; ?>" selected><?php echo $info['specialization']; ?></option>
                                                                                                <?php            
                                                                                                        } else {
                                                                                                ?>
                                                                                                            <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                                                                                <?php           
                                                                                                        } 
                                                                                                    }    
                                                                                                ?>
                                                                                            </select>*/ ?>    
                                                                                        </div><!--end input-group-->
                                                                                    </div><!--end controls-->
                                                                                </div><!--end col-sm-8-->
                                                                            </div>
                                                                            <div class="form-group row">
                                                                                <label class="col-sm-4 text-right control-label col-form-label">Qualification</label>
                                                                                <div class="col-sm-8">
                                                                                    <div class="controls">
                                                                                        <div class="input-group">
                                                                                            <input type="text" value="<?php echo $info['qualification']; ?>" class="form-control" readonly />
                                                                                            <?php /*<select name="qualification_id" class="form-control select2">
                                                                                                <option value="0">Select Qualification</option>
                                                                                                <?php 
                                                                                                    $qualification = new DbaseManipulation;
                                                                                                    $rows = $qualification->readData("SELECT id, name FROM qualification");
                                                                                                    foreach ($rows as $row) {
                                                                                                        if($info['qualification_id'] == $row['id']) {
                                                                                                ?>
                                                                                                            <option value="<?php echo $info['qualification_id']; ?>" selected><?php echo $info['qualification']; ?></option>
                                                                                                <?php            
                                                                                                        } else {
                                                                                                ?>
                                                                                                            <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                                                                                <?php           
                                                                                                        } 
                                                                                                    }    
                                                                                                ?>
                                                                                            </select>*/ ?>    
                                                                                        </div><!--end input-group-->
                                                                                    </div><!--end controls-->
                                                                                </div><!--end col-sm-8-->
                                                                            </div>
                                                                            <div class="form-group row">
                                                                                <label class="col-sm-4 text-right control-label col-form-label">College Position</label>
                                                                                <div class="col-sm-8">
                                                                                    <div class="controls">
                                                                                        <div class="input-group">
                                                                                            <input type="text" value="<?php echo $info['staff_position']; ?>" class="form-control" readonly />        
                                                                                            <?php /*<select name="position_id" class="form-control select2">
                                                                                                <option value="0">Select College Position</option>
                                                                                                <?php 
                                                                                                    $staff_position = new DbaseManipulation;
                                                                                                    $rows = $staff_position->readData("SELECT id, code, title FROM staff_position");
                                                                                                    foreach ($rows as $row) {
                                                                                                        if($info['position_id'] == $row['id']) {
                                                                                                ?>
                                                                                                            <option value="<?php echo $info['position_id']; ?>" selected><?php echo $info['staff_position']; ?></option>
                                                                                                <?php            
                                                                                                        } else {
                                                                                                ?>
                                                                                                            <option value="<?php echo $row['id']; ?>"><?php echo $row['title']; ?></option>
                                                                                                <?php           
                                                                                                        } 
                                                                                                    }    
                                                                                                ?>
                                                                                            </select>*/ ?>
                                                                                        </div><!--end input-group-->
                                                                                    </div><!--end controls-->
                                                                                </div><!--end col-sm-8-->
                                                                            </div>
                                                                            <div class="form-group row">
                                                                                <label class="col-sm-4 text-right control-label col-form-label">Position Category</label>
                                                                                <div class="col-sm-8">
                                                                                    <div class="controls">
                                                                                        <div class="input-group">
                                                                                            <input type="text" value="<?php echo $info['position_category']; ?>" class="form-control" readonly />        
                                                                                        </div><!--end input-group-->
                                                                                    </div><!--end controls-->
                                                                                </div><!--end col-sm-8-->
                                                                            </div>
                                                                            <div class="form-group row">
                                                                                <label class="col-sm-4 text-right control-label col-form-label">Department</label>
                                                                                <div class="col-sm-8">
                                                                                    <div class="controls">
                                                                                        <div class="input-group">
                                                                                            <input type="text" value="<?php echo $info['department']; ?>" class="form-control" readonly />
                                                                                            <?php /*<select name="department_id" class="form-control select2" required data-validation-required-message="Please select department">
                                                                                                <option value="0">Select Department</option>
                                                                                                <?php 
                                                                                                    $departments = new DbaseManipulation;
                                                                                                    $rows = $departments->readData("SELECT id, name FROM department");
                                                                                                    foreach ($rows as $row) {
                                                                                                        if($info['department_id'] == $row['id']) {
                                                                                                ?>
                                                                                                            <option value="<?php echo $info['department_id']; ?>" selected><?php echo $info['department']; ?></option>
                                                                                                <?php            
                                                                                                        } else {
                                                                                                ?>
                                                                                                            <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                                                                                <?php           
                                                                                                        } 
                                                                                                    }    
                                                                                                ?>
                                                                                            </select>*/ ?>
                                                                                        </div><!--end input-group-->
                                                                                    </div><!--end controls-->
                                                                                </div><!--end col-sm-8-->
                                                                            </div>
                                                                            <div class="form-group row">
                                                                                <label class="col-sm-4 text-right control-label col-form-label">Section</label>
                                                                                <div class="col-sm-8">
                                                                                    <div class="controls">
                                                                                        <div class="input-group">
                                                                                            <input type="text" value="<?php echo $info['section']; ?>" class="form-control" readonly />
                                                                                            <?php /*<select name="section_id" class="form-control select2">
                                                                                                <option value="0">Select Section</option>
                                                                                                <?php 
                                                                                                    $sections = new DbaseManipulation;
                                                                                                    $rows = $sections->readData("SELECT id, name FROM section");
                                                                                                    foreach ($rows as $row) {
                                                                                                        if($info['section_id'] == $row['id']) {
                                                                                                ?>
                                                                                                            <option value="<?php echo $info['section_id']; ?>" selected><?php echo $info['section']; ?></option>
                                                                                                <?php            
                                                                                                        } else {
                                                                                                ?>
                                                                                                            <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                                                                                <?php           
                                                                                                        } 
                                                                                                    }    
                                                                                                ?>
                                                                                            </select>*/ ?>  
                                                                                        </div><!--end input-group-->
                                                                                    </div><!--end controls-->
                                                                                </div><!--end col-sm-8-->
                                                                            </div>
                                                                            <div class="form-group row">
                                                                                <label class="col-sm-4 text-right control-label col-form-label">Job Title</label>
                                                                                <div class="col-sm-8">
                                                                                    <div class="controls">
                                                                                        <div class="input-group">
                                                                                            <input type="text" value="<?php echo $info['jobtitle']; ?>" class="form-control" readonly />
                                                                                            <?php /*<select name="jobtitle_id" class="form-control select2">
                                                                                                <option value="0">Select Job Title</option>
                                                                                                <?php 
                                                                                                    $jobs = new DbaseManipulation;
                                                                                                    $rows = $jobs->readData("SELECT id, name FROM jobtitle");
                                                                                                    foreach ($rows as $row) {
                                                                                                        if($info['jobtitle_id'] == $row['id']) {
                                                                                                ?>
                                                                                                            <option value="<?php echo $info['jobtitle_id']; ?>" selected><?php echo $info['jobtitle']; ?></option>
                                                                                                <?php            
                                                                                                        } else {
                                                                                                ?>
                                                                                                            <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                                                                                <?php           
                                                                                                        } 
                                                                                                    }    
                                                                                                ?>
                                                                                            </select>*/ ?>    
                                                                                        </div><!--end input-group-->
                                                                                    </div><!--end controls-->
                                                                                </div><!--end col-sm-8-->
                                                                            </div>
                                                                            
                                                                            <div class="form-group row">
                                                                                <label class="col-sm-4 text-right control-label col-form-label">Sponsor</label>
                                                                                <div class="col-sm-8">
                                                                                    <div class="controls">
                                                                                        <div class="input-group">
                                                                                            <input type="text" value="<?php echo $info['sponsor']; ?>" class="form-control" readonly />
                                                                                            <?php /*<select name="sponsor_id" class="form-control select2">
                                                                                                <option value="0">Select Sponsor</option>
                                                                                                <?php 
                                                                                                    $sponsor = new DbaseManipulation;
                                                                                                    $rows = $sponsor->readData("SELECT id, name FROM sponsor");
                                                                                                    foreach ($rows as $row) {
                                                                                                        if($info['sponsor_id'] == $row['id']) {
                                                                                                ?>
                                                                                                            <option value="<?php echo $info['sponsor_id']; ?>" selected><?php echo $info['sponsor']; ?></option>
                                                                                                <?php            
                                                                                                        } else {
                                                                                                ?>
                                                                                                            <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                                                                                <?php           
                                                                                                        } 
                                                                                                    }    
                                                                                                ?>
                                                                                            </select>*/ ?>    
                                                                                        </div><!--end input-group-->
                                                                                    </div><!--end controls-->
                                                                                </div><!--end col-sm-8-->
                                                                            </div>
                                                                            <div class="form-group row">
                                                                                <label class="col-sm-4 text-right control-label col-form-label">Salary Grade</label>
                                                                                <div class="col-sm-8">
                                                                                    <div class="controls">
                                                                                        <div class="input-group">
                                                                                            <input type="text" value="<?php echo $info['salarygrade']; ?>" class="form-control" readonly />
                                                                                            <?php /*<select name="salarygrade_id" class="form-control select2">
                                                                                                <option value="0">Select Salary Grade</option>
                                                                                                <?php 
                                                                                                    $salarygrade = new DbaseManipulation;
                                                                                                    $rows = $salarygrade->readData("SELECT id, name FROM salarygrade");
                                                                                                    foreach ($rows as $row) {
                                                                                                        if($info['salarygrade_id'] == $row['id']) {
                                                                                                ?>
                                                                                                            <option value="<?php echo $info['salarygrade_id']; ?>" selected><?php echo $info['salarygrade']; ?></option>
                                                                                                <?php            
                                                                                                        } else {
                                                                                                ?>
                                                                                                            <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                                                                                <?php           
                                                                                                        } 
                                                                                                    }    
                                                                                                ?>
                                                                                            </select>*/ ?>   
                                                                                        </div><!--end input-group-->
                                                                                    </div><!--end controls-->
                                                                                </div><!--end col-sm-8-->
                                                                            </div>
                                                                            <div class="form-group row">
                                                                                <label class="col-sm-4 text-right control-label col-form-label">Employment</label>
                                                                                <div class="col-sm-8">
                                                                                    <div class="controls">
                                                                                        <div class="input-group">
                                                                                            <input type="text" value="<?php if($info['employmenttype_id'] == 1) echo 'Full Time'; else echo 'Part Time'; ?>" class="form-control" readonly />
                                                                                            <?php /*<select name="employmenttype_id" class="form-control select2">
                                                                                                <option value="0">Select Employment</option>
                                                                                                <?php
                                                                                                    $employments = array("1", "2");
                                                                                                    foreach ($employments as $row) {
                                                                                                        if($info['employmenttype_id'] == $row) {
                                                                                                            if($info['employmenttype_id'] == 1) {
                                                                                                ?>
                                                                                                                <option value="<?php echo $info['employmenttype_id']; ?>" selected><?php echo "Full Time"; ?></option>
                                                                                                <?php
                                                                                                            } else {        
                                                                                                ?>
                                                                                                                <option value="<?php echo $info['employmenttype_id']; ?>" selected><?php echo "Part Time"; ?></option>
                                                                                                <?php    
                                                                                                            }    
                                                                                                        } else {
                                                                                                            if($info['employmenttype_id'] == 2) {
                                                                                                ?>
                                                                                                                <option value="<?php echo $row; ?>"><?php echo "Full Time"; ?></option>
                                                                                                <?php
                                                                                                            } else {
                                                                                                ?>
                                                                                                                <option value="<?php echo $row; ?>"><?php echo "Part Time"; ?></option>
                                                                                                <?php                
                                                                                                            }                
                                                                                                        }
                                                                                                    }        
                                                                                                ?>
                                                                                            </select>*/ ?>    
                                                                                        </div><!--end input-group-->
                                                                                    </div><!--end controls-->
                                                                                </div><!--end col-sm-8-->
                                                                            </div>
                                                                            <div class="form-group row">
                                                                                <label class="col-sm-4 text-right control-label col-form-label">Status</label>
                                                                                <div class="col-sm-8">
                                                                                    <div class="controls">
                                                                                        <div class="input-group">
                                                                                            <input type="text" value="<?php echo $info['status']; ?>" class="form-control" readonly />
                                                                                            <?php /*<select name="status_id" class="form-control select2">
                                                                                                <option value="0">Select Status</option>
                                                                                                <?php 
                                                                                                    $statuses = new DbaseManipulation;
                                                                                                    $rows = $statuses->readData("SELECT id, name FROM status");
                                                                                                    foreach ($rows as $row) {
                                                                                                        if($info['status_id'] == $row['id']) {
                                                                                                ?>
                                                                                                            <option value="<?php echo $info['status_id']; ?>" selected><?php echo $info['status']; ?></option>
                                                                                                <?php            
                                                                                                        } else {
                                                                                                ?>
                                                                                                            <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                                                                                <?php           
                                                                                                        } 
                                                                                                    }    
                                                                                                ?>
                                                                                            </select>*/ ?>    
                                                                                        </div><!--end input-group-->
                                                                                    </div><!--end controls-->
                                                                                </div><!--end col-sm-8-->
                                                                            </div>                                   
                                                                            <div class="form-group m-b-0">
                                                                                <div class="offset-sm-4 col-sm-8">
                                                                                    <button type="submit" name="submitUpdate" class="btn btn-info waves-effect waves-light"><i class="fa fa-paper-plane"></i> Submit</button>
                                                                                    <button type="reset" class="btn btn-inverse waves-effect waves-light"><i class="fa fa-retweet"></i> Reset</button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <!--End Third Column col-lg-4-->
                                                                    </div><!--end row for form-->  
                                                                </form>
                                                            </div><!--end card body-->
                                                        </div><!--end card for outline-info--> 
                                                    </div>       
                                                </div><!--end row for whole-->   
                                            </div><!--end card body-->
                                        </div><!--end card card-->
                                </div><!--end col 12-->
                            </div><!--end row-->
                        </div>
                        <footer class="footer">
                            <?php include('include_footer.php'); ?>
                        </footer>
                    </div>
                </div>
                <?php include('include_scripts.php'); ?>  
                <script>
                    $('#birthday_date').bootstrapMaterialDatePicker({ weekStart: 0, time: false,format: 'DD/MM/YYYY' });
                    $('#join_date').bootstrapMaterialDatePicker({ weekStart: 0, time: false,format: 'DD/MM/YYYY' });
                    $(function() {
                        $(".firstName").focus();
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