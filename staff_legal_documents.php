<?php    
    include('include_headers.php');
    include('include_scripts.php');
    if(!$helper->isUserLogged()) {
        include_once('not_allowed.php');
    } else {
        $allowed = true;
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
                WHERE s.id = $id AND e.isCurrent = 1
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
                                    <h3 class="text-themecolor m-b-0 m-t-0">Staff Legal Documents</h3>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">Home</a></li>
                                        <li class="breadcrumb-item">Staff Details </li>
                                        <li class="breadcrumb-item">Legal Documents</li>
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
                                                                <div>
                                                                    <a href="#" class="link"><?php echo $info['staffName']; ?></a> <span class="sl-date text-primary">[Staff ID : <?php echo $info['staffId']; ?>]</span>
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
                                                    <a class="btn btn-secondary" href="staff_details.php?id=<?php echo $id; ?>" title="Click to view Staff Details" role="button"><span class="hidden-sm-up"><i class="fas fa-user-md"></i></span> <span class="hidden-xs-down"><i class="ti-angle-double-down"></i> Staff Details</a>
                                                    <a class="btn btn-secondary" href="staff_employment.php?id=<?php echo $id; ?>" title="Click to view Employment History" role="button"><span class="hidden-sm-up"><i class="ti-briefcase"></i></span> <span class="hidden-xs-down"><i class="fas fa-edit"></i> Employment History</a>
                                                    <a class="btn btn-info" href="staff_legal_documents.php?id=<?php echo $id; ?>" title="Click to view Legal Documents" role="button"><span class="hidden-sm-up"><i class="far fa-credit-card"></i></span> <span class="hidden-xs-down"> <i class="ti-angle-double-down"></i> Legal Documents</a>
                                                    <a class="btn btn-secondary" href="staff_qualification.php?id=<?php echo $id; ?>" title="Click to view Staff Qualification" role="button"><span class="hidden-sm-up"><i class="fas fa-graduation-cap"></i></span> <span class="hidden-xs-down"><i class="ti-angle-double-down"></i> Qualification</a>
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
                                                                    
                                                                    if($_POST['document_type'] == 1) {
                                                                        $preFileName = "civilid_";
                                                                    } else if($_POST['document_type'] == 2) {
                                                                        $preFileName = "visa_";
                                                                    } else if($_POST['document_type'] == 3) {
                                                                        $preFileName = "passport_";
                                                                    }    
                                                                    if (!empty($_FILES['fileToUpload']['name'])) {
                                                                        $target_dir = "attachments/legaldocs/";
                                                                        $target_file = $newReqNo;
                                                                        $uploadOk = 1;
                                                                        $errorNo = 0;
                                                                        $acceptable = array('image/jpeg', 'image/jpg', 'image/png', "application/pdf");
                                                                          
                                                                        if ($_FILES["fileToUpload"]["size"] > 2097152) {
                                                                            $uploadOk = 0;
                                                                            $errorNo = 1;
                                                                            $errMsg = "File size is too big. Only 2MB is the maximum allowed file size.";
                                                                        }
                                                                        if (!in_array($_FILES['fileToUpload']['type'], $acceptable) && (!empty($_FILES["fileToUpload"]["type"]))) { //Allow certain file formats
                                                                            $uploadOk = 0;
                                                                            $errorNo = 2;
                                                                            $errMsg = "Sorry, only JPG, JPEG, PNG, PDF file extensions are allowed to upload. File type not accepted.";
                                                                        }
                                                                        if ($uploadOk == 0) {
                                                                            if($errorNo == 1) {
                                                                                ?>
                                                                                <br/>
                                                                                <div class="alert alert-danger">
                                                                                    <h4 class="alert-heading"><i class="fa fa-exclamation-triangle"></i> Upload Failed!</h4>
                                                                                    <p><?php echo $errMsg; ?></p>
                                                                                </div>
                                                                                <?php        
                                                                            } else if ($errorNo == 2) {
                                                                                ?>
                                                                                <br/>
                                                                                <div class="alert alert-danger">
                                                                                    <h4 class="alert-heading"><i class="fa fa-exclamation-triangle"></i> Upload Failed!</h4>
                                                                                    <p><?php echo $errMsg; ?></p>
                                                                                </div>
                                                                                <?php
                                                                            }   
                                                                        } else { //if everything is ok, try to upload file
                                                                            $temp = explode(".", $_FILES["fileToUpload"]["name"]);
                                                                            $extension = end($temp);
                                                                            $new_file_name = $_POST['staff_id'].".".$extension;
                                                                            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], "attachments/legaldocs/".$preFileName.$new_file_name)) {
                                                                                $attachment = "attachments/legaldocs/".$preFileName.$new_file_name;
                                                                            } else {
                                                                                ?>
                                                                                <br/>
                                                                                <div class="alert alert-danger">
                                                                                    <h4 class="alert-heading"><i class="fa fa-exclamation-triangle"></i> Upload Failed!</h4>
                                                                                    <p>File size is too big. Only 2MB is the maximum allowed file size.</p>
                                                                                </div>       
                                                                                <?php 
                                                                                die();               
                                                                            }
                                                                        }
                                                                    } else {
                                                                        $attachment = "";
                                                                    }

                                                                    if($_POST['document_type'] == 3) {
                                                                        $fields = [
                                                                            'staffId'=>$_POST['staff_id'],
                                                                            'stafffamily_id'=>$id,
                                                                            'number'=>$_POST['document_no'],
                                                                            'issueDate'=>$helper->mySQLDate($_POST['issue_date']),
                                                                            'expiryDate'=>$helper->mySQLDate($_POST['expiry_date']),
                                                                            'isFamilyMember'=>0,
                                                                            'isCurrent'=>$_POST['document_status'],
                                                                            'enteredBy'=>$staffId,
                                                                            'attachment'=>$attachment
                                                                        ];
                                                                        if($helper->insert("staffpassport",$fields)){
                                                                            ?>
                                                                                <script>
                                                                                    $(document).ready(function() {
                                                                                        $('#myModalNofification').modal('show');
                                                                                    });
                                                                                </script>
                                                                            <?php
                                                                        }
                                                                    } else if($_POST['document_type'] == 2) { //Visa
                                                                        $fields = [
                                                                            'staffId'=>$_POST['staff_id'],
                                                                            'stafffamily_id'=>$id,
                                                                            'number'=>$_POST['document_no'],
                                                                            'issueDate'=>$helper->mySQLDate($_POST['issue_date']),
                                                                            'expiryDate'=>$helper->mySQLDate($_POST['expiry_date']),
                                                                            'isFamilyMember'=>0,
                                                                            'isCurrent'=>$_POST['document_status'],
                                                                            'enteredBy'=>$staffId,
                                                                            'attachment'=>$attachment
                                                                        ];
                                                                        if($helper->insert("staffvisa",$fields)){
                                                                            ?>
                                                                                <script>
                                                                                    $(document).ready(function() {
                                                                                        $('#myModalNofification').modal('show');
                                                                                    });
                                                                                </script>
                                                                            <?php
                                                                        }
                                                                    } else if($_POST['document_type'] == 1) { //Civil ID
                                                                        $nationality_id = $_POST['nationality_id'];
                                                                        if($nationality_id != 136) { //Non-Omani
                                                                            $getId = new DbaseManipulation;
                                                                            $row = $getId->singleReadFullQry("SELECT TOP 1 * FROM staffvisa WHERE staffId = ".$_POST['staff_id']." AND isCurrent = 1");
                                                                            $idToUpdate = $row['id'];
                                                                            $fields = [
                                                                                'civilId'=>$_POST['document_no'],
                                                                                'cExpiryDate'=>$helper->mySQLDate($_POST['expiry_date']),
                                                                                'attachment2'=>$attachment
                                                                            ];
                                                                            if($helper->update("staffvisa",$fields,$idToUpdate)) {
                                                                                ?>
                                                                                    <script>
                                                                                        $(document).ready(function() {
                                                                                            $('#myModalNofification').modal('show');
                                                                                        });
                                                                                    </script>
                                                                                <?php
                                                                            }
                                                                        } else {
                                                                            $fields = [
                                                                                'staffId'=>$_POST['staff_id'],
                                                                                'stafffamily_id'=>$id,
                                                                                'civilId'=>$_POST['document_no'],
                                                                                'issueDate'=>$helper->mySQLDate($_POST['issue_date']),
                                                                                'cExpiryDate'=>$helper->mySQLDate($_POST['expiry_date']),
                                                                                'isFamilyMember'=>0,
                                                                                'attachment2'=>$attachment
                                                                            ];
                                                                            if($helper->insert("staffvisa",$fields)) {
                                                                                ?>
                                                                                    <script>
                                                                                        $(document).ready(function() {
                                                                                            $('#myModalNofification').modal('show');
                                                                                        });
                                                                                    </script>
                                                                                <?php
                                                                            }
                                                                        }    
                                                                    }
                                                                }

                                                                if(isset($_POST['update'])) {
                                                                    $haydee = $_POST['vid'];
                                                                    $fields = [
                                                                        'staffId'=>$_POST['staff_id'],
                                                                        'stafffamily_id'=>$id,
                                                                        'number'=>$_POST['document_no'],
                                                                        'issueDate'=>$helper->mySQLDate($_POST['issue_date']),
                                                                        'expiryDate'=>$helper->mySQLDate($_POST['expiry_date']),
                                                                        'isFamilyMember'=>0,
                                                                        'isCurrent'=>$_POST['document_status'],
                                                                        'enteredBy'=>$staffId
                                                                    ];
                                                                    if($helper->update("staffvisa",$fields,$haydee)){
                                                                        ?>
                                                                            <script>
                                                                                $(document).ready(function() {
                                                                                    $('#myModalNofificationVisa').modal('show');
                                                                                });
                                                                            </script>
                                                                        <?php
                                                                    }
                                                                }

                                                                if(isset($_POST['update2'])) {
                                                                    $haydee = $_POST['pid'];
                                                                    $fields = [
                                                                        'staffId'=>$_POST['staff_id'],
                                                                        'stafffamily_id'=>$id,
                                                                        'number'=>$_POST['document_no'],
                                                                        'issueDate'=>$helper->mySQLDate($_POST['issue_date']),
                                                                        'expiryDate'=>$helper->mySQLDate($_POST['expiry_date']),
                                                                        'isFamilyMember'=>0,
                                                                        'isCurrent'=>$_POST['document_status'],
                                                                        'enteredBy'=>$staffId
                                                                    ];
                                                                    if($helper->update("staffpassport",$fields,$haydee)){
                                                                        ?>
                                                                            <script>
                                                                                $(document).ready(function() {
                                                                                    $('#myModalNofificationPass').modal('show');
                                                                                });
                                                                            </script>
                                                                        <?php
                                                                    }
                                                                }

                                                                if(isset($_POST['update3'])) {
                                                                    $haydee = $_POST['cid'];
                                                                    $fields = [
                                                                        'civilId'=>$_POST['document_no'],
                                                                        'issueDate'=>$helper->mySQLDate($_POST['issue_date']),
                                                                        'expiryDate'=>$helper->mySQLDate($_POST['expiry_date']),
                                                                        'isCurrent'=>$_POST['document_status']
                                                                    ];
                                                                    if($helper->update("staffvisa",$fields,$haydee)){
                                                                        ?>
                                                                            <script>
                                                                                $(document).ready(function() {
                                                                                    $('#myModalNofificationCivilId').modal('show');
                                                                                });
                                                                            </script>
                                                                        <?php
                                                                    }
                                                                }
                                                            ?>
                                                            <div class="d-flex flex-wrap">
                                                                <div>
                                                                    <h3 class="card-title">Legal Document Form</h3>
                                                                </div>
                                                            </div>
                                                            <form class="form-horizontal p-t-20" action="" method="POST" novalidate enctype="multipart/form-data">
                                                                <div class="form-group row">
                                                                    <label  class="col-sm-4 control-label text-right"><span class="text-danger">*</span>Document Type</label>
                                                                    <div class="col-sm-8">
                                                                        <div class="controls">
                                                                            <div class="input-group">
                                                                                <input type="hidden" name="cid" class="cid" />
                                                                                <input type="hidden" name="vid" class="vid" />
                                                                                <input type="hidden" name="pid" class="pid" />
                                                                                <input type="hidden" name="nationality_id" value="<?php echo $info['nationality_id']; ?>" class="nid" />
                                                                                <input name="staff_id" type="hidden" value="<?php echo $info['staffId']; ?>" />
                                                                                <select name="document_type" class="form-control document_type" required data-validation-required-message="Please select Document Type from the list">
                                                                                    <option value="">Select Document Type</option>
                                                                                    <?php 
                                                                                        if($info['nationality_id'] != 136) {
                                                                                            ?>
                                                                                            <option value="2">Visa</option>
                                                                                            <?php 
                                                                                        }
                                                                                    ?>        
                                                                                    <option value="3">Passport</option>
                                                                                    <?php 
                                                                                        $rowCount = $helper->singleReadFullQry("SELECT TOP 1 * FROM staffvisa WHERE staffId = $staffId AND isCurrent = 1");
                                                                                        if($helper->totalCount != 0 || $info['nationality_id'] == 136) { //136 Omani
                                                                                            ?>
                                                                                            <option value="1">Civil ID</option>
                                                                                            <?php 
                                                                                        }
                                                                                    ?>    
                                                                                </select>  
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group row">
                                                                    <label  class="col-sm-4 control-label text-right"><span class="text-danger">*</span>Upload</label>
                                                                    <div class="col-sm-8">
                                                                        <div class="controls">
                                                                            <div class="input-group">
                                                                                <input type="file" name="fileToUpload" accept=".jpg, .jpeg, .png, .pdf" class="form-control"> 
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group row">
                                                                    <label  class="col-sm-4 control-label text-right"><span class="text-danger">*</span>Document No.</label>
                                                                    <div class="col-sm-8">
                                                                        <div class="controls">
                                                                            <div class="input-group">
                                                                                <input type="text" class="form-control document_no" name="document_no" required data-validation-required-message="Please enter Document Number"/>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label  class="col-sm-4 control-label text-right"><span class="text-danger">*</span>Issue Date</label>
                                                                    <div class="col-sm-8">
                                                                        <div class="controls">
                                                                            <div class="input-group">
                                                                                <input type="text" class="form-control issue_date" name="issue_date" id="issue_date" required data-validation-required-message="Please enter Issue Date"/>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group row">
                                                                    <label  class="col-sm-4 control-label text-right"><span class="text-danger">*</span>Expiry Date</label>
                                                                    <div class="col-sm-8">
                                                                        <div class="controls">
                                                                            <div class="input-group">
                                                                                <input type="text" class="form-control expiry_date" name="expiry_date" id="expiry_date" required data-validation-required-message="Please enter Expiry Date"/>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group row">
                                                                    <label  class="col-sm-4 control-label text-right">Document Status</label>
                                                                    <div class="col-sm-8">
                                                                        <div class="controls">
                                                                            <div class="input-group">
                                                                                <select name="document_status" class="form-control document_status">
                                                                                    <option value="1">Active</option>
                                                                                    <option value="0">Expired</option>
                                                                                </select>  
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group row m-b-0">
                                                                    <div class="offset-sm-4 col-sm-8">
                                                                        <button type="submit" name="submit" class="btn btn-info waves-effect waves-light saveDocs"><i class="fa fa-paper-plane"></i> Submit</button>
                                                                        <button type="reset" class="btn btn-inverse waves-effect waves-light resetDocs"><i class="fa fa-retweet"></i> Reset</button>
                                                                        <button type="submit" name="update" class="btn btn-info waves-effect waves-light updateDocs"><i class="fa fa-edit"></i> Update</button>
                                                                        <button type="submit" name="update2" class="btn btn-info waves-effect waves-light updateDocs2"><i class="fa fa-edit"></i> Update</button>
                                                                        <button type="submit" name="update3" class="btn btn-info waves-effect waves-light updateDocs3"><i class="fa fa-edit"></i> Update</button>
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
                                                                    <h3 class="card-title">Staff Legal Documents</h3>
                                                                    <h6 class="card-subtitle">Arabic Text Here</h6>
                                                                </div>
                                                            </div>
                                                            <div class="table-responsive">
                                                                <table class="table">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>No.</th>
                                                                            <th>Type</th>
                                                                            <th>Number</th>
                                                                            <th>Issue Date</th>
                                                                            <th>Expiry Date</th>
                                                                            <th>Status</th>
                                                                            <th>View</th>
                                                                            <th>Action</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <!-- Civil ID -->
                                                                        <?php
                                                                            $i = 0;
                                                                            $staff_id = $info['staffId']; 
                                                                            $getCivil = new DbaseManipulation;
                                                                            $rows = $getCivil->readData("SELECT * FROM staffvisa WHERE staffId = '$staff_id' AND civilId != ''");
                                                                            if($getCivil->totalCount != 0) {
                                                                                foreach ($rows as $row) {
                                                                                    ?>
                                                                                    <tr>
                                                                                        <td><?php echo ++$i.'.'; ?></td>
                                                                                        <td><a class="text-success civilId" style="cursor:pointer" data-id="<?php echo $row['id']; ?>" data-type="c">Civil ID</a></td>
                                                                                        <td><?php echo $row['civilId']; ?></td>
                                                                                        <td><?php echo $row['issueDate'] ? date('d/m/Y',strtotime($row['issueDate'])) : 'Not Found!'; ?></td>
                                                                                        <td><?php echo date('d/m/Y',strtotime($row['cExpiryDate'])); ?></td>
                                                                                        <td><?php echo $row['isCurrent'] ? "Active" : "Expired"; ?></td>
                                                                                        <td>
                                                                                            <button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#myModal<?php echo $i; ?>">
                                                                                                <i class="fa fa-search"></i> View Attachment
                                                                                            </button>
                                                                                            <div class="modal fade" id="myModal<?php echo $i; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                                                                <div class="modal-dialog modal-lg">
                                                                                                    <div class="modal-content">
                                                                                                        <div class="modal-header">
                                                                                                            <h4 class="modal-title" id="myModalLabel">Document Viewer</h4> 
                                                                                                        </div>
                                                                                                        <div class="modal-body">
                                                                                                            <div style="text-align: center;">
                                                                                                                <object width="750" height="550" data="<?php echo $row['attachment2']; ?>"></object>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                        <div class="modal-footer">
                                                                                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </td>
                                                                                        <td>
                                                                                            <button data-id="<?php echo $row['id']; ?>" class="btn btn-danger btn-xs btnDeleteCivilVisa"><i class="fa fa-trash"></i> Delete</button>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <?php
                                                                                }
                                                                            }
                                                                        ?>
                                                                        <!-- Visa -->
                                                                        <?php
                                                                            $staff_id = $info['staffId']; 
                                                                            $getVisa = new DbaseManipulation;
                                                                            $rows = $getVisa->readData("SELECT * FROM staffvisa WHERE staffId = '$staff_id'");
                                                                            if($getVisa->totalCount != 0 && $info['nationality_id'] != 136) {
                                                                                foreach ($rows as $row) {
                                                                                    ?>
                                                                                    <tr>
                                                                                        <td><?php echo ++$i.'.'; ?></td>
                                                                                        <td><a class="text-success visa" style="cursor:pointer" data-id="<?php echo $row['id']; ?>" data-type="v">Visa</a></td>
                                                                                        <td><?php echo $row['number']; ?></td>
                                                                                        <td><?php echo $row['issueDate'] ? date('d/m/Y',strtotime($row['issueDate'])) : 'Not Found!'; ?></td>
                                                                                        <td><?php echo date('d/m/Y',strtotime($row['expiryDate'])); ?></td>
                                                                                        <td><?php echo $row['isCurrent'] ? "Active" : "Expired"; ?></td>
                                                                                        <td>
                                                                                            <button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#myModal<?php echo $i; ?>">
                                                                                                <i class="fa fa-search"></i> View Attachment
                                                                                            </button>
                                                                                            <div class="modal fade" id="myModal<?php echo $i; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                                                                <div class="modal-dialog modal-lg">
                                                                                                    <div class="modal-content">
                                                                                                        <div class="modal-header">
                                                                                                            <h4 class="modal-title" id="myModalLabel">Document Viewer</h4> 
                                                                                                        </div>
                                                                                                        <div class="modal-body">
                                                                                                            <div style="text-align: center;">
                                                                                                                <object width="750" height="550" data="<?php echo $row['attachment']; ?>"></object>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                        <div class="modal-footer">
                                                                                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </td>
                                                                                        <td>
                                                                                            <button data-id="<?php echo $row['id']; ?>" class="btn btn-danger btn-xs btnDeleteCivilVisa"><i class="fa fa-trash"></i> Delete</button>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <?php
                                                                                }
                                                                            }
                                                                        ?>
                                                                        <!-- Passport -->
                                                                        <?php
                                                                            $staff_id = $info['staffId']; 
                                                                            $getPass = new DbaseManipulation;
                                                                            $rows = $getPass->readData("SELECT * FROM staffpassport WHERE staffId = '$staff_id'");
                                                                            if($getPass->totalCount != 0) {
                                                                                foreach ($rows as $row) {
                                                                                    ?>
                                                                                    <tr>
                                                                                        <td><?php echo ++$i.'.'; ?></td>
                                                                                        <td><a class="text-success passport" style="cursor:pointer" data-id="<?php echo $row['id']; ?>" data-type="p">Passport</a></td>
                                                                                        <td><?php echo $row['number']; ?></td>
                                                                                        <td><?php echo $row['issueDate'] ? date('d/m/Y',strtotime($row['issueDate'])) : 'Not Found!'; ?></td>
                                                                                        <td><?php echo date('d/m/Y',strtotime($row['expiryDate'])); ?></td>
                                                                                        <td><?php echo $row['isCurrent'] ? "Active" : "Expired"; ?></td>
                                                                                        <td>
                                                                                            <button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#myModal<?php echo $i; ?>">
                                                                                                <i class="fa fa-search"></i> View Attachment
                                                                                            </button>
                                                                                            <div class="modal fade" id="myModal<?php echo $i; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                                                                <div class="modal-dialog modal-lg">
                                                                                                    <div class="modal-content">
                                                                                                        <div class="modal-header">
                                                                                                            <h4 class="modal-title" id="myModalLabel">Document Viewer</h4> 
                                                                                                        </div>
                                                                                                        <div class="modal-body">
                                                                                                            <div style="text-align: center;">
                                                                                                                <object width="750" height="550" data="<?php echo $row['attachment']; ?>"></object>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                        <div class="modal-footer">
                                                                                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </td>
                                                                                        <td>
                                                                                            <button data-id="<?php echo $row['id']; ?>" class="btn btn-danger btn-xs btnDeletePassport"><i class="fa fa-trash"></i> Delete</button>
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
                    $('#expiry_date').bootstrapMaterialDatePicker({ weekStart: 0, time: false,format: 'DD/MM/YYYY' });
                    $('#issue_date').bootstrapMaterialDatePicker({ weekStart: 0, time: false,format: 'DD/MM/YYYY' });
                </script>
                <script>
                    $(document).ready(function(){
                        $('.updateDocs').hide();
                        $('.updateDocs2').hide();
                        $('.updateDocs3').hide();
                        $('.cancel').hide();
                        $('.civilId').click(function () {
                            $('.cid').val($(this).data('id'));
                            var id = $(this).data('id');
                            var data = {
                                id : id
                            }
                            $.ajax({
                                url  : 'ajaxpages/staff/legaldocs/select_by_cid.php'
                                ,type    : 'POST'
                                ,dataType: 'json'
                                ,data    : data
                                ,success : function(e){
                                    if(e.error == 1){
                                        bootbox.alert("<strong class='text-danger'><i class='fa fa-exclamation-triangle'></i> Unable To Continue!</strong><br/><br/>An error has been encountered during processing.");
                                    } else {
                                        $('.document_type').empty();
                                        $('.document_type').append($('<option selected>').text("Civil ID").attr('value', 1));
                                        $('.document_no').val(e.number);
                                        $('.issue_date').val(e.issueDate);
                                        $('.expiry_date').val(e.expiryDate);
                                        $('.document_status').append($('<option selected>').text(e.isCurrent).attr('value', e.isCurrentId));
                                        
                                        $('.saveDocs').hide();
                                        $('.resetDocs').hide();
                                        $('.updateDocs2').hide();
                                        $('.updateDocs').hide();
                                        $('.updateDocs3').show();
                                        $('.cancel').show();
                                    }   
                                }
                                ,error  : function(e){
                                }
                            });
                        });

                        $('.visa').click(function () {
                            $('.vid').val($(this).data('id'));
                            var id = $(this).data('id');
                            var data = {
                                id : id
                            }
                            $.ajax({
                                url  : 'ajaxpages/staff/legaldocs/select_by_id.php'
                                ,type    : 'POST'
                                ,dataType: 'json'
                                ,data    : data
                                ,success : function(e){
                                    if(e.error == 1){
                                        bootbox.alert("<strong class='text-danger'><i class='fa fa-exclamation-triangle'></i> Unable To Continue!</strong><br/><br/>An error has been encountered during processing.");
                                    } else {
                                        $('.document_type').empty();
                                        $('.document_type').append($('<option selected>').text("Visa").attr('value', 2));
                                        $('.document_no').val(e.number);
                                        $('.issue_date').val(e.issueDate);
                                        $('.expiry_date').val(e.expiryDate);
                                        $('.document_status').append($('<option selected>').text(e.isCurrent).attr('value', e.isCurrentId));
                                        
                                        $('.saveDocs').hide();
                                        $('.resetDocs').hide();
                                        $('.updateDocs2').hide();
                                        $('.updateDocs').show();
                                        $('.updateDocs3').hide();
                                        $('.cancel').show();
                                    }   
                                }
                                ,error  : function(e){
                                }
                            });
                        });

                        $('.passport').click(function () {
                            $('.pid').val($(this).data('id'));
                            var id = $(this).data('id');
                            var data = {
                                id : id
                            }
                            $.ajax({
                                url  : 'ajaxpages/staff/legaldocs/select_by_id2.php'
                                ,type    : 'POST'
                                ,dataType: 'json'
                                ,data    : data
                                ,success : function(e){
                                    if(e.error == 1){
                                        bootbox.alert("<strong class='text-danger'><i class='fa fa-exclamation-triangle'></i> Unable To Continue!</strong><br/><br/>An error has been encountered during processing.");
                                    } else {
                                        $('.document_type').empty();
                                        $('.document_type').append($('<option selected>').text("Passport").attr('value', 3));
                                        $('.document_no').val(e.number);
                                        $('.issue_date').val(e.issueDate);
                                        $('.expiry_date').val(e.expiryDate);
                                        $('.document_status').append($('<option selected>').text(e.isCurrent).attr('value', e.isCurrentId));
                                        
                                        $('.saveDocs').hide();
                                        $('.resetDocs').hide();
                                        $('.updateDocs').hide();
                                        $('.updateDocs2').show();
                                        $('.updateDocs3').hide();
                                        $('.cancel').show();
                                    }   
                                }
                                ,error  : function(e){
                                }
                            });
                        });   

                        $('.btnDeleteCivilVisa').click(function () {
                            var id = $(this).data('id');
                            bootbox.hideAll();
                            bootbox.confirm({
                                message: "Deleting Civil ID or Visa will delete both. Do you want to continue?",
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
                                            tbl: 'visacivil'
                                        }
                                        $.ajax({
                                            url  : 'ajaxpages/staff/legaldocs/delete.php'
                                            ,type    : 'POST'
                                            ,dataType: 'json'
                                            ,data    : data
                                            ,success : function(e){
                                                if(e.error == 0){
                                                    alert(e.msg);
                                                    window.location.reload();
                                                } else {
                                                    
                                                }   
                                            }
                                            ,error  : function(e){
                                            }
                                        });
                                    }
                                }
                            });
                        });
                        $('.btnDeletePassport').click(function () {
                            var id = $(this).data('id');
                            bootbox.hideAll();
                            bootbox.confirm({
                                message: "This action will delete your passport information. Do you want to continue?",
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
                                            tbl: 'passport'
                                        }
                                        $.ajax({
                                            url  : 'ajaxpages/staff/legaldocs/delete.php'
                                            ,type    : 'POST'
                                            ,dataType: 'json'
                                            ,data    : data
                                            ,success : function(e){
                                                if(e.error == 0){
                                                    alert(e.msg);
                                                    window.location.reload();
                                                } else {
                                                    
                                                }   
                                            }
                                            ,error  : function(e){
                                            }
                                        });
                                    }
                                }
                            });
                        });                 
                    });    
                </script>
                <div class="modal fade" id="myModalNofification" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-body" style="text-align: center">
                                <h3 class="modal-title text-primary" id="myModalLabel"><i class='fa fa-info-circle'></i> Success</h3>
                                <h5>New document details has been added and saved!</h5>
                                <a href="" class="btn btn-primary"><i class='fa fa-check'></i> OK</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="myModalNofificationVisa" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-body" style="text-align: center">
                                <h3 class="modal-title text-primary" id="myModalLabel"><i class='fa fa-info-circle'></i> Success</h3>
                                <h5>Visa document details has been edited and updated!</h5>
                                <a href="" class="btn btn-primary"><i class='fa fa-check'></i> OK</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="myModalNofificationPass" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-body" style="text-align: center">
                                <h3 class="modal-title text-primary" id="myModalLabel"><i class='fa fa-info-circle'></i> Success</h3>
                                <h5>Passport document details has been edited and updated!</h5>
                                <a href="" class="btn btn-primary"><i class='fa fa-check'></i> OK</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="myModalNofificationCivilId" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-body" style="text-align: center">
                                <h3 class="modal-title text-primary" id="myModalLabel"><i class='fa fa-info-circle'></i> Success</h3>
                                <h5>Civil Id document details has been edited and updated!</h5>
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