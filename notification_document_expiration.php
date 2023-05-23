<?php    
    include('include_headers.php');?>
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
                                    <h3 class="text-themecolor m-b-0 m-t-0">Document Notification</h3>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">Home</a></li>
                                        <li class="breadcrumb-item">Document Notification</li>
                                    </ol>
                                </div>
                                <?php include('include_time_in_info.php'); ?>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="card-title">All Documents About To Expire</h4>
                                            <h6 class="card-subtitle">قائمة كل الإجازات</h6>
                                            <div class="table-responsive">
                                                <table id="dynamicTableAllSTL" class="display table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                                    <thead>
                                                       <tr>
                                                        <th>Staff Id</th>
                                                        <th>Staff Name</th>
                                                        <th>Department</th>
                                                        <th>Section</th>
                                                        <th>Designation</th>
                                                        <th>Sponsor</th>
                                                        <th>Document Type</th>
                                                        <th>Document ID</th>
                                                        <th>Expiration Date</th>
                                                        <th>Document Status</th>
                                                      </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php 
                                                            
                                                            $visa = new DbaseManipulation;
                                                            $rows = $visa->readData("SELECT v.id, v.staffId, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName, v.civilId, v.cExpiryDate, v.number as visanumber, v.issueDate, v.expiryDate, d.name as department, sec.name as section, sp.name as sponsor, j.name as jobtitle FROM staffvisa v INNER JOIN employmentdetail e ON v.staffId = e.staff_id INNER JOIN department d ON e.department_id = d.id INNER JOIN section sec ON e.section_id = sec.id INNER JOIN sponsor sp ON e.sponsor_id = sp.id INNER JOIN jobtitle j ON e.jobtitle_id = j.id INNER JOIN staff s ON v.staffId = s.staffId WHERE v.isFamilyMember = 0 AND v.isCurrent = 1 AND e.isCurrent = 1 and e.status_id = 1");
                                                            if($visa->totalCount != 0) {
                                                                foreach($rows as $row){
                                                                    $civilIdExpiry = $row['cExpiryDate'];
                                                                    $now = time(); // or your date as well
                                                                    $your_date = strtotime($row['cExpiryDate']);
                                                                    $datediff = $your_date - $now;
                                                                    $date =  round($datediff / (60 * 60 * 24));
                                                                    $dateStatus = $date; 
                                                                    /*
                                                                    $now_date = date('Y-m-d',time());
                                                                    $civilIdExpiry = $row['cExpiryDate'];
                                                                    $date1 = $civilIdExpiry;
                                                                    $date2 = $now_date;
                                                                    $diff = abs(strtotime($date2) - strtotime($date1));
                                                                    $years = floor($diff / (365*60*60*24));
                                                                    $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
                                                                    $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
                                                                    */
                                                                    if($dateStatus < 31) { //30 days
                                                                        ?>
                                                                        <tr>
                                                                            <td><?php echo $row['staffId']; ?></td>
                                                                            <td><?php echo $row['staffName']; ?></td>
                                                                            <td><?php echo $row['department']; ?></td>
                                                                            <td><?php echo $row['section']; ?></td>
                                                                            <td><?php echo $row['jobtitle']; ?>></td>
                                                                            <td><?php echo $row['sponsor']; ?></td>
                                                                            <td><span class="label label-success">Visa/Civil ID</span></td>
                                                                            <td><?php echo $row['civilId']; ?></td>
                                                                            <?php 
                                                                                if($civilIdExpiry == '') {
                                                                                    ?>
                                                                                    <td>Not Found!</td>
                                                                                    <td><span class="label label-danger">Incorrect Expiry Date</span></td>
                                                                                    <?php
                                                                                } else {
                                                                                    ?>
                                                                                    <td><?php echo date('d/m/Y',strtotime($row['cExpiryDate'])); ?></td>
                                                                                    <td><span class="label label-warning"><?php echo $dateStatus.' days' ?></span></td>
                                                                                    <?php
                                                                                }
                                                                            ?>
                                                                        </tr>
                                                                        <?php
                                                                    }
                                                                }
                                                            }
                                                            


                                                            $passport = new DbaseManipulation;
                                                            $rowsP = $passport->readData("SELECT p.id, p.staffId, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName, p.number as passportNumber, p.issueDate, p.expiryDate, d.name as department, sec.name as section, sp.name as sponsor, j.name as jobtitle FROM staffpassport p INNER JOIN employmentdetail e ON p.staffId = e.staff_id INNER JOIN department d ON e.department_id = d.id INNER JOIN section sec ON e.section_id = sec.id INNER JOIN sponsor sp ON e.sponsor_id = sp.id INNER JOIN jobtitle j ON e.jobtitle_id = j.id INNER JOIN staff s ON p.staffId = s.staffId WHERE p.isFamilyMember = 0 AND p.isCurrent = 1 AND e.isCurrent = 1 and e.status_id = 1");
                                                            if($passport->totalCount != 0) {
                                                                foreach($rowsP as $row){
                                                                    $expiryDate = $row['expiryDate'];
                                                                    $now = time(); // or your date as well
                                                                    $your_date = strtotime($row['expiryDate']);
                                                                    $datediff = $your_date - $now;
                                                                    $date =  round($datediff / (60 * 60 * 24));
                                                                    $dateStatus = $date; 
                                                                    /*
                                                                    $now_date = date('Y-m-d',time());
                                                                    $date1 = $expiryDate;
                                                                    $date2 = $now_date;
                                                                    $diff = abs(strtotime($date2) - strtotime($date1));
                                                                    $years = floor($diff / (365*60*60*24));
                                                                    $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
                                                                    $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
                                                                    */
                                                                    if($dateStatus < 31) { //30 days
                                                                        ?>
                                                                        <tr>
                                                                            <td><?php echo $row['staffId']; ?></td>
                                                                            <td><?php echo $row['staffName']; ?></td>
                                                                            <td><?php echo $row['department']; ?></td>
                                                                            <td><?php echo $row['section']; ?></td>
                                                                            <td><?php echo $row['jobtitle']; ?>></td>
                                                                            <td><?php echo $row['sponsor']; ?></td>
                                                                            <td><span class="label label-info">Passport</span></td>
                                                                            <td><?php echo $row['passportNumber']; ?></td>
                                                                            <?php 
                                                                                if($expiryDate == '') {
                                                                                    ?>
                                                                                    <td>Not Found!</td>
                                                                                    <td><span class="label label-danger">Incorrect Expiry Date</span></td>
                                                                                    <?php
                                                                                } else {
                                                                                    ?>
                                                                                    <td><?php echo date('d/m/Y',strtotime($row['expiryDate'])); ?></td>
                                                                                    <td><span class="label label-warning"><?php echo $dateStatus.' days' ?></span></td>
                                                                                    <?php
                                                                                }
                                                                            ?>
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
                <?php
                    include('include_scripts.php');
                ?>
            </body>

       
</html>