<?php
session_start();
include "../../classes/AjaxManipulators.php";
$id = $_POST['id'];
$staffId = $_POST['staffId'];
$get = new AjaxManipulators;
$row = $get->singleReadFullQry("SELECT TOP 1 c.id, c.score, c.isAcademic, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName, d.name as department, j.name as jobtitle, c.canStatus FROM award_candidate as c LEFT OUTER JOIN staff as s ON c.staffId = s.staffId LEFT OUTER JOIN employmentdetail as e ON s.staffId = e.staff_id LEFT OUTER JOIN department as d ON d.id = c.department_id LEFT OUTER JOIN jobtitle as j ON j.id = e.jobtitle_id WHERE c.id = $id");
if($row['isAcademic'] == 1) {
	$category = 'Academic';
} else {
	$category = 'Non-Academic';
}
$message = json_encode(array(
    'id'=>$id,
    'staffName'=>$row['staffName'],
    'department'=>$row['department'],
    'jobtitle'=>$row['jobtitle'],
    'mark'=>number_format($row['score'],2),
    'category'=>$category,
    'error' => 0
));
echo $message;
?>


