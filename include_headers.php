<?php
    session_start(); 
    /*function __autoload($class){
        require_once "classes/$class.php";
    }*/
    require_once "classes/DbaseManipulation.php";
    //$con = mysqli_connect("localhost","p09a05","15935789","dbhr3_test") or die("Cannot connect to remote server!");
    $helper = new DbaseManipulation;
    $SQLActiveStaff = "SELECT s.id, s.staffId, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName, e.status_id, e.isCurrent FROM staff as s LEFT OUTER JOIN employmentdetail as e ON e.staff_id = s.staffId WHERE e.status_id = 1 AND e.isCurrent = 1 ORDER BY s.firstName"; 
    $staffId = $_SESSION['username'];
    $user_type = $_SESSION['user_type'];
    $primary_staff_id = $helper->staff_primary_id($staffId,'id');
    $logged_name = $helper->getStaffName($staffId,'firstName','secondName','thirdName','lastName');
    $logged_in_email = $helper->getContactInfo(2,$staffId,'data');
    $logged_in_gsm = $helper->getContactInfo(1,$staffId,'data');
    $logged_in_department_id = $helper->employmentIDs($staffId,'department_id');
    $logged_in_section_id = $helper->employmentIDs($staffId,'section_id');
    $logged_in_sponsor_id = $helper->employmentIDs($staffId,'sponsor_id');
    $myPositionId = $helper->employmentIDs($staffId,'position_id');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon.png">
    <title>NCT- HRMS 3.0</title>
    <!-- Bootstrap Core CSS -->
    <link href="assets/plugins/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/style.css" rel="stylesheet">
    <!-- You can change the theme colors from here -->
    <link href="css/colors/megna.css" id="theme" rel="stylesheet">
    <link href="css/demo_backtotop.css" rel="stylesheet">
    <link href="assets/plugins/datatables/jquery.dataTables.min.css" rel="stylesheet">

    <link href="assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet">
    <!-- Page plugins css -->
    <link href="assets/plugins/clockpicker/dist/jquery-clockpicker.min.css" rel="stylesheet">
    <!-- Color picker plugins css -->
    <link href="assets/plugins/jquery-asColorPicker-master/css/asColorPicker.css" rel="stylesheet">
    <!-- Date picker plugins css -->
    <link href="assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
    <!-- Daterange picker plugins css -->
    <link href="assets/plugins/timepicker/bootstrap-timepicker.min.css" rel="stylesheet">
    <link href="assets/plugins/daterangepicker/daterangepicker.css" rel="stylesheet">

    <link href="assets/plugins/select2/dist/css/select2.css" rel="stylesheet" type="text/css" />

    <link href="assets/plugins/switchery/dist/switchery.min.css" rel="stylesheet" />
    <link href="assets/plugins/bootstrap-select/bootstrap-select.min.css" rel="stylesheet" />
    <link href="assets/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.css" rel="stylesheet" />
    <link href="assets/plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.css" rel="stylesheet" />
    <link href="assets/plugins/multiselect/css/multi-select.css" rel="stylesheet" type="text/css" />

    <!--Charts-->
    <link href="assets/plugins/chartist-js/dist/chartist.min.css" rel="stylesheet">
    <link href="assets/plugins/chartist-js/dist/chartist-init.css" rel="stylesheet">
    <link href="assets/plugins/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.css" rel="stylesheet">
    <link href="assets/plugins/css-chart/css-chart.css" rel="stylesheet">
    <link href="assets/plugins/c3-master/c3.min.css" rel="stylesheet">

    <!-- fullCalendar -->
    <link rel="stylesheet" href="fullcalendar/dist/fullcalendar.min.css">
    <link rel="stylesheet" href="fullcalendar/dist/fullcalendar.print.min.css" media="print">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
</head>