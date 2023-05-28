<?php
	extract($_GET);
	include "../../classes/AjaxManipulators.php";
	$chk = new AjaxManipulators;
	$find = new AjaxManipulators;
	$rows = $chk->readData("SELECT TOP 1 staffId FROM staff WHERE staffId LIKE '$first3%' ORDER BY staffId DESC");
	$ctr = $yearCode;
	if($chk->totalCount < 1) {
		do {
			$prefix = $deptCode.$ctr;
			$rowx = $find->readData("SELECT TOP 1 staffId FROM staff WHERE staffId LIKE '$prefix%' ORDER BY staffId DESC");
			if($find->totalCount != 0) {
				foreach($rowx as $row){
?>
					<input type="text" id="hulingId" name="hulingId" class="form-control" value="<?php echo $row['staffId']; ?>" readonly/>
<?php					
				}
			}
			$ctr--;
		} while ($find->totalCount < 1);
	} else {
		foreach($rows as $row){
?>
			<input type="text" id="hulingId" name="hulingId" class="form-control" value="<?php echo $row['staffId']; ?>" readonly/>
<?php			
		}
	}
?>								
                              	