<?php
session_start();
include "../../classes/AjaxManipulators.php";
$id = $_POST['id'];
$aca = $_POST['aca'];
$getScore = new AjaxManipulators;
if($aca == 1) {
	$table = '<table class="table">
		<thead>
	        <tr>
	            <th class="text-center">C1</th>
	            <th class="text-center">C2</th>
	            <th class="text-center">C3</th>
	            <th class="text-center">C4</th>
	            <th class="text-center">C5</th>
	            <th class="text-center">C6</th>
	            <th class="text-center">C7</th>
	            <th class="text-center">C8</th>
	            <th class="text-center">C9</th>
	            <th class="text-center">C10</th>
	            <th class="text-center">C11</th>
				<th class="text-center">C12</th>
				<th class="text-center">C13</th>
				<th class="text-center">C14</th>
	        </tr>
	    </thead>
	    <tbody>';	
		$rows = $getScore->readData("SELECT TOP 1 * FROM award_raw_score_academic WHERE award_candidate_id = $id");
		foreach ($rows as $row) {
			$comment = $row['comment'];
			$table .= '
			    <tr>
				    <td class="text-center">'.$row['c1'].'</td>
				    <td class="text-center">'.$row['c2'].'</td>
				    <td class="text-center">'.$row['c3'].'</td>
				    <td class="text-center">'.$row['c4'].'</td>
				    <td class="text-center">'.$row['c5'].'</td>
				    <td class="text-center">'.$row['c6'].'</td>
				    <td class="text-center">'.$row['c7'].'</td>
				    <td class="text-center">'.$row['c8'].'</td>
				    <td class="text-center">'.$row['c9'].'</td>
				    <td class="text-center">'.$row['c10'].'</td>
				    <td class="text-center">'.$row['c11'].'</td>
				    <td class="text-center">'.$row['c12'].'</td>
				    <td class="text-center">'.$row['c13'].'</td>
				    <td class="text-center">'.$row['c14'].'</td>
				</tr>';
		}
		$table .= '
			    <tr>
				    <td colspan="12" class="text-left"><strong>Notes/Comments: </strong><br>'.$comment.'</td>
				</tr>';
	$table .=  '</tbody></table>';		
} else {
	$table = '<table class="table">
		<thead>
	        <tr>
	            <th class="text-center">C1</th>
	            <th class="text-center">C2</th>
	            <th class="text-center">C3</th>
	            <th class="text-center">C4</th>
	            <th class="text-center">C5</th>
	            <th class="text-center">C6</th>
	            <th class="text-center">C7</th>
	            <th class="text-center">C8</th>
	            <th class="text-center">C9</th>
	            <th class="text-center">C10</th>
	            <th class="text-center">C11</th>
				<th class="text-center">C12</th>
	        </tr>
	    </thead>
	    <tbody>';	
		$rows = $getScore->readData("SELECT TOP 1 * FROM award_raw_score_nonacademic WHERE award_candidate_id = $id");
		foreach ($rows as $row) {
			$comment = $row['comment'];
			$table .= '
			    <tr>
				    <td class="text-center">'.$row['c1'].'</td>
				    <td class="text-center">'.$row['c2'].'</td>
				    <td class="text-center">'.$row['c3'].'</td>
				    <td class="text-center">'.$row['c4'].'</td>
				    <td class="text-center">'.$row['c5'].'</td>
				    <td class="text-center">'.$row['c6'].'</td>
				    <td class="text-center">'.$row['c7'].'</td>
				    <td class="text-center">'.$row['c8'].'</td>
				    <td class="text-center">'.$row['c9'].'</td>
				    <td class="text-center">'.$row['c10'].'</td>
				    <td class="text-center">'.$row['c11'].'</td>
				    <td class="text-center">'.$row['c12'].'</td>
				</tr>';
		}
		$table .= '
			    <tr>
				    <td colspan="12" class="text-left"><strong>Notes/Comments: </strong><br>'.$comment.'</td>
				</tr>';
	$table .=  '</tbody></table>';
}

$message = json_encode(array(
	'msg'=>$table,
    'error' => 0
));
echo $message;
?>


