<?php
session_start();
include "../../classes/AjaxManipulators.php";
$staffId = $_POST['staffId'];
$get = new AjaxManipulators;
$row = $get->singleReadFullQry("SELECT s.id, s.staffId, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName, s.gender, d.name as department, sc.name as section, sp.name as sponsor, j.name as jobtitle, e.status_id, e.sponsor_id FROM staff as s LEFT OUTER JOIN employmentdetail as e ON s.staffId = e.staff_id LEFT OUTER JOIN department as d ON d.id = e.department_id LEFT OUTER JOIN section as sc ON e.section_id = sc.id LEFT OUTER JOIN sponsor as sp ON sp.id = e.sponsor_id LEFT OUTER JOIN jobtitle as j ON j.id = e.jobtitle_id WHERE s.staffId = '$staffId'");
$message = json_encode(array(
    'staffName'=>$row['staffName'],
    'department'=>$row['department'],
    'section'=>$row['section'],
    'jobtitle'=>$row['jobtitle'],
    'sponsor'=>$row['sponsor'],
    'error' => 0
));
echo $message;
?>


