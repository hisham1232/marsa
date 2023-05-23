<?php
/*function __autoload($class){
		require_once "classes/$class.php";
}*/
require_once "classes/DbaseManipulation.php";
error_reporting(0);
require_once('tcpdf/config/lang/eng.php');
require_once('tcpdf/tcpdf.php');
// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false); 
$pdf->SetCreator(PDF_CREATOR);
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

$left = 10;
$top = 5;
$right = 5;
$pdf->SetMargins($left, $top, $right);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO); 

$lg = Array();
$lg['a_meta_charset'] = 'UTF-8';
$lg['a_meta_dir'] = 'rtl';
$lg['a_meta_language'] = 'fa';
$lg['w_page'] = 'page';

$pdf->setLanguageArray($lg); 
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

$pdf->SetFont('almohanad', '', 16);
$pdf->AddPage();
$image_file = 'images/oman-logo.jpg';	
$testdata=123;
$tbl = <<<EOD
<table border="0" cellpadding="1" cellspacing="1" align="right">
 <tr nobr="true">
  <td width="130">سلطنة عمان <br>وزارة القوى العاملة<br>الكلية التقنية بنزوى <br> قسم الموارد البشرية </td>
  <td width="100"></td>
  <td width="85"><img src="images/oman-logo.jpg" border="0" height="70" width="85" /></td>
 </tr>
</table>
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');
$tbl = <<<EOD
  <p align="center">OFFICIAL MISSION APPLICATION FORM</p>
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');
$pdf->setRTL(true);
/*Getting data from table*/
$staffId = $_GET['staffId'];
$requestNo = $_GET['requestNo'];
$leave = new DbaseManipulation;
/*Staff Information*/
$info = $leave->singleReadFullQry("SELECT s.id, s.staffId, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName, d.name as department, sp.name as sponsor, st.requestNo, st.dateFiled, l.name as leavetype, st.startDate, st.endDate, st.total, st.reason FROM staff as s LEFT OUTER JOIN employmentdetail as e ON e.staff_id = s.staffId LEFT OUTER JOIN department as d ON d.id = e.department_id LEFT OUTER JOIN sponsor as sp ON sp.id = e.sponsor_id LEFT OUTER JOIN standardleave as st ON st.staff_id = s.staffId LEFT OUTER JOIN leavetype as l ON l.id = st.leavetype_id WHERE e.status_id = 1 AND e.isCurrent = 1 AND s.staffId = '$staffId' AND st.requestNo = '$requestNo' ORDER BY s.firstName");
$staffFullName = $info['staffName'];
$staffDepartmentName = $info['department'];
$staffSponsorName = $info['sponsor'];

/*Leave Information*/
$dateRequested = date("d/m/Y H:i:s",strtotime($info['dateFiled']));
$reason = $info['reason'];
$leaveTypeDesc = $info['leavetype'];
$beginleave = date("d/m/Y",strtotime($info['startDate']));
$returnleave = date("d/m/Y",strtotime($info['endDate']));
$noofdays = $info['total'];
$tbl = <<<EOD
<table border="1" cellpadding="2" cellspacing="2" align="left" width="555" >
 <tr nobr="true" ><td colspan="3" align="center">Staff Information</td></tr>
 <tr nobr="false">
	<td width="130" align="right">إسم الموظف</td>
	<td width="267">{$staffFullName}</td>
	<td width="150">Staff Name</td>
 </tr>
 <tr nobr="false">
	<td width="130" align="right">رقم الموظف</td>
	<td width="267">{$staffId}</td>
	<td width="150">Staff ID</td>
 </tr>
 <tr nobr="false">
	<td width="130" align="right">القسم </td>
	<td width="267">{$staffDepartmentName}</td>
	<td width="150">Department</td>
 </tr>
 <tr nobr="false">
	<td width="130" align="right">الكفيل</td>
	<td width="267">{$staffSponsorName}</td>
	<td width="150">Sponsor</td>
 </tr>
</table>
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');
$pdf->setRTL(true);
$tbl = <<<EOD
<table border="1" cellpadding="2" cellspacing="2" align="right" width="555">
 <tr nobr="true" >
	<td border="0" align="center">Official Mission Information</td>
 </tr>
 <tr nobr="false">
	<td width="130">تاريخ الطلب</td>
	<td width="267" align="left">{$dateRequested} </td>
	<td width="150" align="left">Date Requested </td>
 </tr>
 <tr nobr="false">
	<td width="130">بدء الإجازة</td>
	<td width="267" align="left">{$beginleave} </td>
	<td width="150" align="left">Starting Date </td>
 </tr>
 <tr nobr="false">
	<td width="130">العودة من الإجازة</td>
	<td width="267" align="left">{$returnleave} </td>
	<td width="150" align="left">Ending Date </td>
 </tr>
 <tr nobr="false">
	<td width="130">عدد الأيام</td>
	<td width="267" align="left">{$noofdays} </td>
	<td width="150" align="left">Number of Days </td>
 </tr>
 <tr nobr="false">
	<td width="130">أسباب المغادرة</td>
	<td width="267" align="left">{$reason} </td>
	<td width="150" align="left">Reasons for Filing</td>
 </tr> 
</table>
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');

/*Leave History Here*/
$history = new DbaseManipulation;
$rows = $history->readData("SELECT TOP 1 sh.*, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName FROM standardleave_history as sh LEFT OUTER JOIN staff as s ON s.staffId = sh.staff_id WHERE requestNo = '$requestNo' ORDER BY id DESC");
$tbl_header = '<table border="1" cellpadding="2" cellspacing="2" align="left" width="555"><tr nobr="true" ><td colspan="4" align="center">Approval History Information</td></tr><tr nobr="false">
	<td width="156">Status</td>
	<td width="158">Notes/Comments</td>
	<td width="95">Date/Time</td>
	<td width="136">Staff Name</td>
 </tr>';
$tbl_footer = '</table>';
$tbl = '';
foreach($rows as $row){
	$histStaffName = $row['staffName'];
	$notes = $row['notes'];
	$datecreated = date('d/m/Y H:i:s',strtotime($row['created']));
	$cycleStatus = $row['status'];
$tbl .= '
    <tr>
		<td style="border: 1px solid #000; width: 156px;">'.$cycleStatus.'</td>
		<td style="border: 1px solid #000; width: 158px;">'.$notes.'</td>
		<td style="border: 1px solid #000; width: 95px;">'.$datecreated.'</td>
		<td style="border: 1px solid #000; width: 136px;">'.$histStaffName.'</td>
    </tr>
';}
$rows = $history->readData("SELECT TOP 1 sh.*, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName FROM standardleave_history as sh LEFT OUTER JOIN staff as s ON s.staffId = sh.staff_id WHERE requestNo = '$requestNo' ORDER BY id");
foreach($rows as $row){
	$histStaffName = $row['staffName'];
	$notes = $row['notes'];
	$datecreated = date('d/m/Y H:i:s',strtotime($row['created']));
	$cycleStatus = $row['status'];
$tbl .= '
    <tr>
		<td style="border: 1px solid #000; width: 156px;">'.$cycleStatus.'</td>
		<td style="border: 1px solid #000; width: 158px;">'.$notes.'</td>
		<td style="border: 1px solid #000; width: 95px;">'.$datecreated.'</td>
		<td style="border: 1px solid #000; width: 136px;">'.$histStaffName.'</td>
    </tr>
';}
$pdf->writeHTML($tbl_header . $tbl . $tbl_footer, true, false, false, false, '');
$tbl = <<<EOD
  <p align="left">College Dean Signature :</p>
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');
$pdf->SetFont('almohanad','B',18);

//Close and output PDF document
$pdf->Output('Leave Application Form.pdf', 'I');
//============================================================+
// END OF FILE                                                 
//============================================================+
?>
