<?php
	extract($_GET);
	include "../../classes/AjaxManipulators.php";
	$chk = new AjaxManipulators;
	$find = new AjaxManipulators;
	$getName = new AjaxManipulators;
	$rows = $chk->readData("SELECT TOP 1 id, staffId FROM staff WHERE staffId LIKE '$first3%' ORDER BY staffId DESC");
	$ctr = $yearCode;
	if($chk->totalCount == 0) {
		do {
			$prefix = $deptCode.$ctr;
			$rowx = $find->readData("SELECT TOP 1 id, staffId FROM staff WHERE staffId LIKE '$prefix%' ORDER BY staffId DESC");
			if ($find->totalCount != 0) {
				foreach($rowx as $row){
					$staffName = $getName->getStaffName($row['id'],'firstName','secondName','thirdName','lastName');
?>
					<input type="text" id="hulingName" name="hulingName" class="form-control" value="<?php echo $staffName; ?>" readonly/>
<?php					
				}
			}
			$ctr--;
		} while ($find->totalCount < 1);
	} else {
		foreach($rows as $row){
			$staffName = $getName->getStaffName($row['id'],'firstName','secondName','thirdName','lastName');
?>
			<input type="text" id="hulingName" name="hulingName" class="form-control" value="<?php echo $staffName; ?>" readonly/>
<?php			
		}
	}
?>								
                              	