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
                                    <h3 class="text-themecolor m-b-0 m-t-0">Staff Family Information</h3>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">Home</a></li>
                                        <li class="breadcrumb-item">Staff Details </li>
                                        <li class="breadcrumb-item">Family Information</li>
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
                                                    <a class="btn btn-secondary" href="staff_work_experience.php?id=<?php echo $id; ?>" title="Click to view Staff Work Experience" role="button"><span class="hidden-sm-up"><i class="fas fa-rocket"></i></span> <span class="hidden-xs-down"><i class="ti-angle-double-down"></i> Work Experience</a>
                                                    <a class="btn btn-secondary" href="staff_researches.php?id=<?php echo $id; ?>" title="Click to view Staff Researches" role="button"><span class="hidden-sm-up"><i class="ti-clipboard"></i></span> <span class="hidden-xs-down"><i class="ti-angle-double-down"></i> Researches</a>    
                                                    <a class="btn btn-secondary" href="staff_contacts.php?id=<?php echo $id; ?>" title="Click to view Staff Contacts" role="button"><span class="hidden-sm-up"><i class="far fa-address-book"></i></span> <span class="hidden-xs-down"><i class="ti-angle-double-down"></i> Contacts</a>    
                                                    <a class="btn btn-info" href="" title="Click to view Staff Family Information" role="button"><span class="hidden-sm-up"><i class="fas fa-users"></i></span> <span class="hidden-xs-down"><i class="fas fa-edit"></i> Family Information</a>    
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-5">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="d-flex flex-wrap">
                                                                <div>
                                                                    <h3 class="card-title">Family Information Form</h3>
                                                                </div>
                                                            </div>
                                                            <form class="form-horizontal p-t-20" action="" method="POST" novalidate enctype="multipart/form-data">
                                                                <div class="form-group row">
                                                                    <label  class="col-sm-4 control-label text-right"><span class="text-danger">*</span>Relationship</label>
                                                                    <div class="col-sm-8">
                                                                        <div class="controls">
                                                                            <div class="input-group">
                                                                                <select name="document_type" class="form-control" required data-validation-required-message="Please select Relationship Type from the list">
                                                                                    <option value="">Select Relationship Type</option>
                                                                                    <option value="1">Relationship Type</option>
                                                                                    <option value="2">Relationship Type 2</option>                                                                    
                                                                                </select>  
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label  class="col-sm-4 control-label text-right"><span class="text-danger">*</span>Civil ID</label>
                                                                    <div class="col-sm-8">
                                                                        <div class="controls">
                                                                            <div class="input-group">
                                                                                <input type="text" class="form-control" name="civil_id" required data-validation-required-message="Please enter Civil ID"/>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label  class="col-sm-4 control-label text-right"><span class="text-danger">*</span>Full Name</label>
                                                                    <div class="col-sm-8">
                                                                        <div class="controls">
                                                                            <div class="input-group">
                                                                                <input type="text" class="form-control" name="full_name" required data-validation-required-message="Please enter Contact Details"/>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label  class="col-sm-4 control-label text-right"><span class="text-danger">*</span>Gender</label>
                                                                    <div class="col-sm-8">
                                                                        <div class="controls">
                                                                            <div class="input-group">
                                                                                <select name="job_title" class="form-control" required data-validation-required-message="Please select Gender from the list">
                                                                                    <option value="">Select Gender</option>
                                                                                    <option value="1">Gender 1</option>
                                                                                    <option value="2">Gender 2</option>
                                                                                </select>  
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label for="" class="col-sm-4 control-label text-right"><span class="text-danger">*</span>Birth Date</label>
                                                                    <div class="col-sm-8">
                                                                        <div class="controls">
                                                                            <div class="input-group">
                                                                                <input type="text" class="form-control" name="birth_date" id="birth_date" required data-validation-required-message="Please enter Birth Date Date"/>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>                                                                                                                
                                                                <div class="form-group row">
                                                                    <label  class="col-sm-4 control-label text-right"><span class="text-danger">*</span>Edited By</label>
                                                                    <div class="col-sm-8">
                                                                        <div class="controls">
                                                                            <div class="input-group">
                                                                                <input type="text" class="form-control" name="edited_by"/>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label  class="col-sm-4 control-label text-right"><span class="text-danger">*</span>Modified Date</label>
                                                                    <div class="col-sm-8">
                                                                        <div class="controls">
                                                                            <div class="input-group">
                                                                                <input type="text" class="form-control" name="modified_date" readonly/>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>                                                        
                                                                <div class="form-group row m-b-0">
                                                                    <div class="offset-sm-4 col-sm-8">
                                                                        <button type="submit" name="submit" class="btn btn-info waves-effect waves-light"><i class="fa fa-paper-plane"></i> Submit</button>
                                                                        <button type="reset" class="btn btn-inverse waves-effect waves-light"><i class="fa fa-retweet"></i> Reset</button>
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
                                                                    <h3 class="card-title">Staff Contacts</h3>
                                                                    <h6 class="card-subtitle">Arabic Text Here</h6>
                                                                </div>
                                                            </div>
                                                            <div class="table-responsive">
                                                                <table class="table">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>No</th>
                                                                            <th>Name</th>
                                                                            <th>Relationship</th>
                                                                            <th>Gender</th>
                                                                            <th>Civil ID</th>
                                                                            <th>Birth Date</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td>1</td>
                                                                            <td><span class="text-primary font-weight-bold">Long Name of a Person</span></td>
                                                                            <td>Mother</td>
                                                                            <td>Female</td>
                                                                            <td>456123</td>
                                                                            <td>dd/mm/yyyy</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>2</td>
                                                                            <td><span class="text-primary font-weight-bold">Long Name of a Person</span></td>
                                                                            <td>Father</td>
                                                                            <td>Male</td>
                                                                            <td>456123</td>
                                                                            <td>dd/mm/yyyy</td>
                                                                        </tr>                                                                    
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
                    // MAterial Date picker    
                    $('#mdate').bootstrapMaterialDatePicker({ weekStart: 0, time: false,format: 'DD/MM/YYYY' });
                    $('#birth_date').datepicker({ weekStart: 0, time: false,format: 'dd/mm/yyyy' });
                    $('#issue_date').datepicker({ weekStart: 0, time: false,format: 'dd/mm/yyyy' });
                    jQuery('#date-range').datepicker({
                        toggleActive: true
                    });
                    $('.daterange').daterangepicker();
                </script>
            </body>
<?php
        } else {
            include_once('not_allowed.php');
        }
    }
?>            
</html>