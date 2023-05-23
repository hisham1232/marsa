<?php
error_reporting(0);
require_once('tcpdf/config/lang/eng.php');
require_once('tcpdf/tcpdf.php');
/*include "dbaseconn/dbasemanipulation-dbhr.php";
include "dbaseconn/dbasemanipulation-dbclearance.php";*/
require_once "classes/DbaseManipulation.php";
error_reporting(0);
class MYPDF extends TCPDF {
    //Page header
    public function Header() {
    global $roInstance,$issueInstance,$dInstance;
$lefth =5;
$toph = 40;
$righth = 0;
$this->SetMargins($lefth, $toph, $righth);
		$lg1 = Array();
$lg1['a_meta_charset'] = 'UTF-8';
//$lg1['a_meta_dir'] = 'rtl';
$lg1['a_meta_language'] = 'fa';
$lg1['w_page'] = 'page';
$this->setRTL(false);
        // Logo
    	// $image_file = 'reportLogo2.jpg';
		//$image_file = 'oman-logo-kanjar.jpg';
       // $this->Image($image_file, 95, 10, 20, 20, 'JPEG', '', 'T', false, 205, '', false, false, 0, false, false, false);		
$height = 5;
$boarder =0;
$this->Ln(0);
/* arabic
$this->SetFont('almohanad','B',18);
$this->Cell(195,$height,'سلطنة عمان ',$boarder,0,'R');
$this->Ln($height);
$this->Cell(195,$height,'وزارة القوى العاملة ',$boarder,0,'R');
$this->Ln($height);
$this->Cell(195,$height,'الكلية التقنية بنزوى',$boarder,0,'R');
$this->Ln($height);*/       
//	   $this->SetFont('almohanad','B',16); for arabic
//
//$this->SetFont('helvetica', '', 10);
//$this->Cell(205,$height,'Sultanate of Oman',$boarder,0,'L');
//$this->Ln($height);
//$this->Cell(205,$height,'Ministry of Manpower ',$boarder,0,'L');
//$this->Ln($height);
//$this->Cell(205,$height,'Nizwa College of Technology',$boarder,0,'L');
$this->Ln(12);
$this->SetFont('helvetica', 'B', 14);
	//Move to the right
	//$this->Cell(202,5,'NO DUE-CERTIFICATE',0,0,'C');
    }//end of header
    // Page footer
    public function Footer() {
		$lg1 = Array();
$lg1['a_meta_charset'] = 'UTF-8';
//g1['a_meta_dir'] = 'rtl';
$lg1['a_meta_language'] = 'fa';
$lg1['w_page'] = 'page';

//set some language-dependent strings
$this->setLanguageArray($lg1); 
//$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        // Position at 15 mm from bottom
      //  $this->SetY(-15);
	    //$this->SetY(-7);
		$this->SetY(-15);
        // Set font
    $this->SetFont('helvetica','I',8);
	$height = 5;
	$boarder =1;

    $this->Ln($height);							
	//$this->Cell(100,5,'Printed By / Date: '.'Name of the store staff Here'.' /  Date here' ,0,0,'L');
	$this->Cell(80,5,'Clearance ID Number: '.$_GET['cid']);
    }//end of footer
}//end of extends
// create new PDF document
//$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false); 

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false); 

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('HRMD');
$pdf->SetTitle('NCT Clearance Form');

$pdf->setPrintHeader(true);
$pdf->setPrintFooter(true);

// set default header data
//$pdf->SetHeaderData(PDF_HEADER_LOGO);

// set header and footer fonts
//$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
//$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
//$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//set margins

$left = 5;
$top = 0;
$right = 0;

//$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetMargins($left, $top, $right);

//$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
//$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

//set auto page breaks//set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO); 

// set some language dependent data:
$lg = Array();
$lg['a_meta_charset'] = 'UTF-8';
$lg['a_meta_dir'] = 'rtl';
$lg['a_meta_language'] = 'fa';
$lg['w_page'] = 'page';

//set some language-dependent strings
$pdf->setLanguageArray($lg); 
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// ---------------------------------------------------------

// set font
$pdf->SetFont('helvetica', '', 10);
//$pdf->SetFont('timesb','',12);
// add a page
$pdf->AddPage();
//$pdf->AddPage('L'); // for lanscape
// Restore RTL direction
$pdf->setRTL(false);

/*Getting data from table*/
$staffId = $_GET['id'];
$clearanceNo = $_GET['cid'];
$getStaffInfo = new DbaseManipulation;
$row = $getStaffInfo->singleReadFullQry("SELECT cas.*, c.requestNo, c.dateCreated, c.isCleared, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName, 
d.name as department, sp.name as sponsor, j.name as position 
FROM clearance_approval_status as cas 
LEFT OUTER JOIN clearance as c ON cas.clearance_id = c.id 
LEFT OUTER JOIN staff as s ON cas.staffId = s.staffId 
LEFT OUTER JOIN employmentdetail as e ON c.staffId = e.staff_id 
LEFT OUTER JOIN department as d ON d.id = e.department_id 
LEFT OUTER JOIN sponsor as sp ON sp.id = e.sponsor_id 
LEFT OUTER JOIN jobtitle as j ON j.id = e.jobtitle_id 
WHERE s.staffId = '$staffId'");

$staffName = trim($row['staffName']);
$position = $row['position'];
$sponsor = $row['sponsor'];
$department = $row['department'];

$imgCheck = '<img src="images/check.jpg" height="12" width="12">';
$imgCross = '<img src="images/cross.jpg" height="12" width="12">';

$cid = $row['clearance_id'];
$deptArray = array(); $AdminArray = array(); $FinanceArray = array(); $ETCArray = array(); $HRArray = array(); $ADAFAArray = array(); 

$readerHelper = new DbaseManipulation;

$rows = $readerHelper->readData("SELECT clearance_process_id, status, dateUpdated FROM clearance_approval_status WHERE clearance_process_id IN (1,2) AND clearance_id = $cid");
foreach ($rows as $row) {
    array_push($deptArray,$row['status']);
    $dateUpdated = date('d/m/Y H:i:s A',strtotime($row['dateUpdated']));
}
if (in_array('Pending', $deptArray)) {
	$staffDept = $imgCross;
	$staffDeptSignature = 'Pending'.' - '.$dateUpdated;
} else if (in_array('Declined', $deptArray)) {
    $staffDept = $imgCross;
	$staffDeptSignature = 'Declined'.' - '.$dateUpdated;
} else {
    $staffDept = $imgCheck;
	$staffDeptSignature = 'Completed'.' - '.$dateUpdated;
}

$rows = $readerHelper->readData("SELECT clearance_process_id, status, dateUpdated FROM clearance_approval_status WHERE clearance_process_id IN (1) AND clearance_id = $cid");
foreach ($rows as $row) {
    array_push($deptArray,$row['status']);
    $dateUpdated = date('d/m/Y H:i:s A',strtotime($row['dateUpdated']));
}
if (in_array('Pending', $deptArray)) {
	$sectionHead = $imgCross;
	$sectionHeadSignature = 'Pending'.' - '.$dateUpdated;
} else if (in_array('Declined', $deptArray)) {
    $sectionHead = $imgCross;
	$sectionHeadSignature = 'Declined'.' - '.$dateUpdated;
} else {
    $sectionHead = $imgCheck;
	$sectionHeadSignature = 'Completed'.' - '.$dateUpdated;
}

$rows = $readerHelper->readData("SELECT clearance_process_id, status, dateUpdated FROM clearance_approval_status WHERE clearance_process_id IN (2) AND clearance_id = $cid");
foreach ($rows as $row) {
    array_push($deptArray,$row['status']);
    $dateUpdated = date('d/m/Y H:i:s A',strtotime($row['dateUpdated']));
}
if (in_array('Pending', $deptArray)) {
	$departmentHead = $imgCross;
	$departmentHeadSignature = 'Pending'.' - '.$dateUpdated;
} else if (in_array('Declined', $deptArray)) {
    $departmentHead = $imgCross;
	$departmentHeadSignature = 'Declined'.' - '.$dateUpdated;
} else {
    $departmentHead = $imgCheck;
	$departmentHeadSignature = 'Completed'.' - '.$dateUpdated;
}

$rows = $readerHelper->readData("SELECT clearance_process_id, status, dateUpdated FROM clearance_approval_status WHERE clearance_process_id IN (3) AND clearance_id = $cid");
foreach ($rows as $row) {
    array_push($deptArray,$row['status']);
    $dateUpdated = date('d/m/Y H:i:s A',strtotime($row['dateUpdated']));
}
if (in_array('Pending', $deptArray)) {
	$Admin = $imgCross;
	$AdminSignature = 'Pending'.' - '.$dateUpdated;
} else if (in_array('Declined', $deptArray)) {
    $Admin = $imgCross;
	$AdminSignature = 'Declined'.' - '.$dateUpdated;
} else {
    $Admin = $imgCheck;
	$AdminSignature = 'Completed'.' - '.$dateUpdated;
}

$rows = $readerHelper->readData("SELECT clearance_process_id, status, dateUpdated FROM clearance_approval_status WHERE clearance_process_id IN (4) AND clearance_id = $cid");
foreach ($rows as $row) {
    array_push($deptArray,$row['status']);
    $dateUpdated = date('d/m/Y H:i:s A',strtotime($row['dateUpdated']));
}
if (in_array('Pending', $deptArray)) {
	$Store = $imgCross;
	$StoreSignature = 'Pending'.' - '.$dateUpdated;
} else if (in_array('Declined', $deptArray)) {
    $Store = $imgCross;
	$StoreSignature = 'Declined'.' - '.$dateUpdated;
} else {
    $Store = $imgCheck;
	$StoreSignature = 'Completed'.' - '.$dateUpdated;
}

$rows = $readerHelper->readData("SELECT clearance_process_id, status, dateUpdated FROM clearance_approval_status WHERE clearance_process_id IN (5) AND clearance_id = $cid");
foreach ($rows as $row) {
    array_push($deptArray,$row['status']);
    $dateUpdated = date('d/m/Y H:i:s A',strtotime($row['dateUpdated']));
}
if (in_array('Pending', $deptArray)) {
	$Finance = $imgCross;
	$FinanceSignature = 'Pending'.' - '.$dateUpdated;
} else if (in_array('Declined', $deptArray)) {
    $Finance = $imgCross;
	$FinanceSignature = 'Declined'.' - '.$dateUpdated;
} else {
    $Finance = $imgCheck;
	$FinanceSignature = 'Completed'.' - '.$dateUpdated;
}

$rows = $readerHelper->readData("SELECT clearance_process_id, status, dateUpdated FROM clearance_approval_status WHERE clearance_process_id IN (6,7,8) AND clearance_id = $cid");
foreach ($rows as $row) {
    array_push($deptArray,$row['status']);
    $dateUpdated = date('d/m/Y H:i:s A',strtotime($row['dateUpdated']));
}
if (in_array('Pending', $deptArray)) {
	$ETC = $imgCross;
	$ETCSignature = 'Pending'.' - '.$dateUpdated;
} else if (in_array('Declined', $deptArray)) {
    $ETC = $imgCross;
	$ETCSignature = 'Declined'.' - '.$dateUpdated;
} else {
    $ETC = $imgCheck;
	$ETCSignature = 'Completed'.' - '.$dateUpdated;
}

$rows = $readerHelper->readData("SELECT clearance_process_id, status, dateUpdated FROM clearance_approval_status WHERE clearance_process_id IN (6) AND clearance_id = $cid");
foreach ($rows as $row) {
    array_push($deptArray,$row['status']);
    $dateUpdated = date('d/m/Y H:i:s A',strtotime($row['dateUpdated']));
}
if (in_array('Pending', $deptArray)) {
	$CSS = $imgCross;
	$CSSSignature = 'Pending'.' - '.$dateUpdated;
} else if (in_array('Declined', $deptArray)) {
    $CSS = $imgCross;
	$CSSSignature = 'Declined'.' - '.$dateUpdated;
} else {
    $CSS = $imgCheck;
	$CSSSignature = 'Completed'.' - '.$dateUpdated;
}

$rows = $readerHelper->readData("SELECT clearance_process_id, status, dateUpdated FROM clearance_approval_status WHERE clearance_process_id IN (7) AND clearance_id = $cid");
foreach ($rows as $row) {
    array_push($deptArray,$row['status']);
    $dateUpdated = date('d/m/Y H:i:s A',strtotime($row['dateUpdated']));
}
if (in_array('Pending', $deptArray)) {
	$LSS = $imgCross;
	$LSSSignature = 'Pending'.' - '.$dateUpdated;
} else if (in_array('Declined', $deptArray)) {
    $LSS = $imgCross;
	$LSSSignature = 'Declined'.' - '.$dateUpdated;
} else {
    $LSS = $imgCheck;
	$LSSSignature = 'Completed'.' - '.$dateUpdated;
}

$rows = $readerHelper->readData("SELECT clearance_process_id, status, dateUpdated FROM clearance_approval_status WHERE clearance_process_id IN (8) AND clearance_id = $cid");
foreach ($rows as $row) {
    array_push($deptArray,$row['status']);
    $dateUpdated = date('d/m/Y H:i:s A',strtotime($row['dateUpdated']));
}
if (in_array('Pending', $deptArray)) {
	$ETCHead = $imgCross;
	$ETCHeadSignature = 'Pending'.' - '.$dateUpdated;
} else if (in_array('Declined', $deptArray)) {
    $ETCHead = $imgCross;
	$ETCHeadSignature = 'Declined'.' - '.$dateUpdated;
} else {
    $ETCHead = $imgCheck;
	$ETCHeadSignature = 'Completed'.' - '.$dateUpdated;
}

$rows = $readerHelper->readData("SELECT clearance_process_id, status, dateUpdated FROM clearance_approval_status WHERE clearance_process_id IN (9) AND clearance_id = $cid");
foreach ($rows as $row) {
    array_push($deptArray,$row['status']);
    $dateUpdated = date('d/m/Y H:i:s A',strtotime($row['dateUpdated']));
}
if (in_array('Pending', $deptArray)) {
	$HR = $imgCross;
	$HRSignature = 'Pending'.' - '.$dateUpdated;
} else if (in_array('Declined', $deptArray)) {
    $HR = $imgCross;
	$HRSignature = 'Declined'.' - '.$dateUpdated;
} else {
    $HR = $imgCheck;
	$HRSignature = 'Completed'.' - '.$dateUpdated;
}

$rows = $readerHelper->readData("SELECT clearance_process_id, status, dateUpdated FROM clearance_approval_status WHERE clearance_process_id IN (10) AND clearance_id = $cid");
foreach ($rows as $row) {
    array_push($deptArray,$row['status']);
    $dateUpdated = date('d/m/Y H:i:s A',strtotime($row['dateUpdated']));
}
if (in_array('Pending', $deptArray)) {
	$ADAFA = $imgCross;
	$ADAFASignature = 'Pending'.' - '.$dateUpdated;
} else if (in_array('Declined', $deptArray)) {
    $ADAFA = $imgCross;
	$ADAFASignature = 'Declined'.' - '.$dateUpdated;
} else {
    $ADAFA = $imgCheck;
	$ADAFASignature = 'Completed'.' - '.$dateUpdated;
}

$tbl = <<<EOD
<table border="1" cellpadding="2" cellspacing="2" align="right" width="555">
  <tr nobr="false">
	<td width="50" align="left"><strong>Name</strong></td>
	<td width="215" align="left">{$staffName}</td>
	<td width="60" align="left"><strong>Position</strong></td>
	<td width="215" align="left">{$position}</td>

 </tr>
<tr nobr="false">
	<td width="50" align="left"><strong>Sponsor</strong></td>
	<td width="215" align="left">{$sponsor}</td>
	<td width="60" align="left"><strong>Department</strong></td>
	<td width="215" align="left">{$department}</td>

 </tr>
</table>
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');


$tbl = <<<EOD
<table border="1" cellpadding="2" cellspacing="2" align="right" width="555">
  <tr nobr="false">
	<td width="30" align="center"><strong>No</strong></td>
	<td width="150" align="center"><strong>Section</strong></td>
	<td width="180" align="center"><strong>Item</strong></td>
	<td width="180" align="center"><strong>Signature</strong></td>
 </tr>
 <tr nobr="false">
	<td width="30" align="center"><strong>1</strong></td>
	<td width="150" align="left"><strong>Staff’s Department</strong></td>
	<td width="180" align="left">{$staffDept}</td>
	<td width="180" align="left">{$staffDeptSignature}</td>
 </tr>
 <tr nobr="false">
	<td width="30" align="center"><strong>1.a</strong></td>
	<td width="150" align="left"><strong>Section Head</strong></td>
	<td width="180" align="left">{$sectionHead}</td>
	<td width="180" align="left">{$sectionHeadSignature}</td>
 </tr>
 <tr nobr="false">
	<td width="30" align="center"><strong>1.b</strong></td>
	<td width="150" align="left"><strong>Department Head</strong></td>
	<td width="180" align="left"><i>{$departmentHead}</i></td>
	<td width="180" align="left">{$departmentHeadSignature}</td>
 </tr>
 
 <tr nobr="false">
	<td width="30" align="center" rowspan="5"><strong>2</strong></td>
	<td width="150" align="left" rowspan="5"><strong>Administrative Affairs</strong></td>
	<td width="180" align="left">{$Admin} - Accommodation</td>
	<td width="180" align="left" rowspan="5">{$AdminSignature}</td>
 </tr>
  <tr nobr="false">
	<td width="180" align="left">{$Admin} - Furniture</td>
 </tr>
  <tr nobr="false">
	<td width="180" align="left">{$Admin} - Electricity</td>
 </tr>
  <tr nobr="false">
	<td width="180" align="left">{$Admin} - Water</td>
 </tr>
  <tr nobr="false">
	<td width="180" align="left">{$Admin} - Telephone</td>
 </tr>

 <tr nobr="false">
	<td width="30" align="center" rowspan="5"><strong>3</strong></td>
	<td width="150" align="left" rowspan="5"><strong>College Store</strong></td>
	<td width="180" align="left">{$Store} - Personal Official Use IDs.</td>
	<td width="180" align="left" rowspan="5">{$StoreSignature}</td>
 </tr>
  <tr nobr="false">
	<td width="180" align="left">{$Store} - Store Dues</td>
 </tr>
  <tr nobr="false">
	<td width="180" align="left">{$Store} - Office Furniture</td>
 </tr>
  <tr nobr="false">
	<td width="180" align="left">{$Store} - Equipment</td>
 </tr>
   <tr nobr="false">
	<td width="180" align="left">{$Store} - Others</td>
 </tr>

 <tr nobr="false">
	<td width="30" align="center"><strong>4</strong></td>
	<td width="150" align="left"><strong>Financial Affairs</strong></td>
	<td width="180" align="left">{$Finance} - Debts</td>
	<td width="180" align="left">{$FinanceSignature}</td>
 </tr>
 <tr nobr="false">
	<td width="30" align="center"><strong>5</strong></td>
	<td width="150" align="left"><strong>ETC</strong></td>
	<td width="180" align="left">{$ETC}</td>
	<td width="180" align="left">{$ETCSignature}</td>
 </tr>
 <tr nobr="false">
	<td width="30" align="center"><strong>5.a</strong></td>
	<td width="150" align="left"><strong>CSS-HoS</strong></td>
	<td width="180" align="left">{$CSS}</td>
	<td width="180" align="left">{$CSSSignature}</td>
 </tr>
 <tr nobr="false">
	<td width="30" align="center"><strong>5.b</strong></td>
	<td width="150" align="left"><strong>Library-HoS</strong></td>
	<td width="180" align="left">{$LSS}</td>
	<td width="180" align="left">{$LSSSignature}</td>
 </tr>
 <tr nobr="false">
	<td width="30" align="center"><strong>5.c</strong></td>
	<td width="150" align="left"><strong>ETC-HoC</strong></td>
	<td width="180" align="left">{$ETCHead}</td>
	<td width="180" align="left">{$ETCHeadSignature}</td>
 </tr>
 <tr nobr="false">
	<td width="30" align="center"><strong>6</strong></td>
	<td width="150" align="left"><strong>Human Resource</strong></td>
	<td width="180" align="left">{$HR}</td>
	<td width="180" align="left">{$HRSignature}</td>
 </tr> 
 <tr nobr="false">
	<td width="30" align="center"><strong>7</strong></td>
	<td width="150" align="left"><strong>ADAFA</strong></td>
	<td width="180" align="left">{$ADAFA}</td>
	<td width="180" align="left">{$ADAFASignature}</td>
 </tr> 

</table>
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');


$tbl = <<<EOD
<table border="0" cellpadding="2" cellspacing="2" align="right" width="510">
  <tr nobr="false">
	<td width="560" align="left">We confirm that the above mentioned employee has cleared all his dues with us, and is therefore entitled to get his passport and other benefits.</td>
 </tr>
</table>
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');

$pdf->Ln(20);
$tbl = <<<EOD
<table border="0" cellpadding="2" cellspacing="2" align="right" width="555">
  <tr nobr="false">
	<td width="160" align="center">Employee’s Signature</td>
	<td width="180" align="center">Head of Human Resources Dept.</td>
	<td width="180" align="center">Assistant Dean for Adm & Fin Approval</td>
 </tr>
</table>
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');

//---------------------------------------------------------

//Close and output PDF document
$pdf->Output('Clearance.pdf', 'I');

//============================================================+
// END OF FILE                                                 
//============================================================+
?>
