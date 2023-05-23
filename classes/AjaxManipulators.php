<?php
define('CACHE_FRONTEND_OPTIONS', serialize(array('automatic_cleaning_factor' => 0)));
ini_set('opcache.enable', '0');
ini_set("display_errors", 1); 
ini_set("log_errors", 1);
ini_set("error_log", dirname(__FILE__).'/logs.txt');
error_reporting(E_ALL);
error_reporting(0);
date_default_timezone_set('Asia/Muscat');
//include("phpmailer/class.phpmailer.php");
class Db {
	protected function connect() {
		$serverName = "DESKTOP-71OFDN3";
		$database = "dbhr3";
		$uid = 'sa';
		$pwd = 'Nct@123456';
		try {
			$conn = new PDO("sqlsrv:server=$serverName;Database=$database", $uid, $pwd, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // set the PDO error mode to exception
		    return $conn;
		} catch(PDOException $e) {
		    echo "Connection failed: " . $e->getMessage();
		}
	}
} 
class AjaxManipulators extends Db { //"extends" means inheriting class Db

	private $date;
	private $userip;
	public function __construct(){
		$this->date 	= $this->getCurrentDate();
		$this->userip 	= $this->getUserIP();
	}

	public function singleRead($tableName,$id) {
		$sql = "SELECT * FROM ".$tableName." WHERE id = :id";
		$stmt = $this->connect()->prepare($sql);
		$stmt->bindValue(':id',$id);
		$stmt->execute();
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		return $result;
	}

	public function singleReadFullQry($sql) {
		$stmt = $this->connect()->prepare($sql);
		$stmt->execute();
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		$this->totalCount = $stmt->rowCount();
		return $result;
	}

	public function executeSQL($sql) {
		try {
			$stmt = $this->connect()->prepare($sql);
			$stmtExec = $stmt->execute();
			if ($stmtExec) {
				return true;
			} else {
				return false;
			}
		} catch(PDOException $e) {
			throw new Exception($e->getMessage());
		}	
	}

	public function readData($sql) {
		$result = $this->connect()->query($sql);
		$this->totalCount = $result->rowCount();
		if($result->rowCount() != 0) {
			while ($row = $result->fetch()) {
				$data[] = $row;
			}
			return $data;	
		}
	}

	public function insert($tableName,$fields) {
		$implodeColumns = implode(', ',array_keys($fields));
		$implodePlaceholder = implode(', :',array_keys($fields));
		$sql = "INSERT INTO ".$tableName." ($implodeColumns) VALUES (:".$implodePlaceholder.")";
		$stmt = $this->connect()->prepare($sql);
		foreach ($fields as $key => $value) {
			$stmt->bindValue(':'.$key,$value);
		}

		$stmtExec = $stmt->execute();
		if ($stmtExec) {
			return true;
		} else {
			return false;
		}
	}

	public function update($tableName,$fields,$id) {
		$st = "";
		$counter = 1;
		$total_fields = count($fields);
		foreach ($fields as $key => $value) {
			if($counter === $total_fields) {
				$set = "$key = :".$key;
				$st = $st.$set;
			} else {
				$set = "$key = :".$key.", ";
				$st = $st.$set;
				$counter++;
			}
		}

		$sql = "";
		$sql.= "UPDATE ".$tableName." SET ".$st;
		$sql.= " WHERE id = ".$id;
		$stmt = $this->connect()->prepare($sql);
		foreach ($fields as $key => $value) {
			$stmt->bindValue(':'.$key, $value);
		}
		$stmtExec = $stmt->execute();

		if($stmtExec) {
			return true;
		}
	}

	public function destroy($tableName,$id) {
		$sql = "DELETE FROM ".$tableName." WHERE id = :id";
		$stmt = $this->connect()->prepare($sql);
		$stmt->bindValue(':id',$id);
		$stmtExec = $stmt->execute();
		if($stmtExec) {
			return true;
		} else {
			return false;
		}		
	}

	public function fieldNameValue($tableName,$id,$fieldname) {
		$sql = "SELECT * FROM ".$tableName." WHERE id = :id";
		$stmt = $this->connect()->prepare($sql);
		$stmt->bindValue(':id',$id);
		$stmt->execute();
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		return $result[$fieldname];
	}

	public function getStaffName($id,$firstName,$secondName,$thirdName,$lastName){
		try {
			$sql = "SELECT firstName, secondName, thirdName, lastName FROM staff WHERE staffId = :id";
			$stmt = $this->connect()->prepare($sql);
			$stmt->bindValue(':id',$id);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			$this->totalCount = $stmt->rowCount();
			if($stmt->rowCount() != 0) {
				return preg_replace('/( )+/', ' ',$result[$firstName]." ".$result[$secondName]." ".$result[$thirdName]." ".$result[$lastName]);
			} else {
				return "testing";
			}
		} catch(PDOException $e) {
			throw new Exception($e->getMessage());
		}	              
	}
	//Dito tayo Today
	public function getStaffNameUsingStaffId($id,$firstName,$secondName,$thirdName,$lastName){
        $sql = "SELECT s.firstName, s.secondName, s.thirdName, s.lastName FROM staff as s LEFT OUTER JOIN employmentdetail as e ON s.staffId = e.staff_id WHERE e.isCurrent = 1 AND e.status_id = 1 AND s.staffId = :id";
        $stmt = $this->connect()->prepare($sql);
		$stmt->bindValue(':id',$id);
		$stmt->execute();
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
        return preg_replace('/( )+/', ' ',$result[$firstName]." ".$result[$secondName]." ".$result[$thirdName]." ".$result[$lastName]);
                   
	}
	
	public function employmentIDs($staffId,$fieldname) {
		try {
			$sql = "SELECT * FROM employmentdetail WHERE staff_id = :staff_id AND isCurrent = 1 AND status_id = 1";
			$stmt = $this->connect()->prepare($sql);
			$stmt->bindValue(':staff_id',$staffId);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			$this->totalCount = $stmt->rowCount();
			if($stmt->rowCount() != 0) {
				return $result[$fieldname];
			} else {
				return "";
			}
		} catch(PDOException $e) {
			throw new Exception($e->getMessage());
		}	
	}

	public function getIdsUsingPositionId($tableName,$id,$fieldname) {
		$sql = "SELECT $fieldname FROM ".$tableName." WHERE isCurrent = 1 AND status_id = 1 AND position_id = :id";
		$stmt = $this->connect()->prepare($sql);
		$stmt->bindValue(':id',$id);
		$stmt->execute();
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		return $result[$fieldname];
	}

	public function getIdsUsingPositionId2($id,$fieldname) {
		$sql = "SELECT staff_id FROM employmentdetail WHERE isCurrent = 1 AND status_id = 1 AND position_id = :id";
		$stmt = $this->connect()->prepare($sql);
		$stmt->bindValue(':id',$id);
		$stmt->execute();
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		return $result[$fieldname];
	}

	public function staffFamilyIDs($staffId,$relationship,$fieldname) {
		try {
			$sql = "SELECT * FROM stafffamily WHERE staffId = :staff_id AND relationship = :relationship";
			$stmt = $this->connect()->prepare($sql);
			$stmt->bindValue(':staff_id',$staffId);
			$stmt->bindValue(':relationship',$relationship);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			$this->totalCount = $stmt->rowCount();
			if($stmt->rowCount() != 0) {
				return $result[$fieldname];
			} else {
				return "";
			}
		} catch(PDOException $e) {
			throw new Exception($e->getMessage());
		}	
	}
	
	public function getContactInfo($cid,$staffId,$fieldname) {
		try {
			$sql = "SELECT * FROM contactdetails WHERE contacttype_id = :cid AND staff_id = :staffid";
			$stmt = $this->connect()->prepare($sql);
			$stmt->bindValue(':cid',$cid);
			$stmt->bindValue(':staffid',$staffId);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			$this->totalCount = $stmt->rowCount();
			if($stmt->rowCount() != 0) {
				return $result[$fieldname];
			} else {
				return "No contact found.";
			}
		} catch(PDOException $e) {
			throw new Exception($e->getMessage());
		}	
	}

	public function getTaskStatus($id,$taskId,$fieldname) {
		try {
			$sql = "SELECT * FROM taskprocesshistory WHERE taskprocess_id = :id And task_id = :task_id";
			$stmt = $this->connect()->prepare($sql);
			$stmt->bindValue(':id',$id);
			$stmt->bindValue(':task_id',$taskId);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			$this->totalCount = $stmt->rowCount();
			if($stmt->rowCount() != 0) {
				return $result[$fieldname];
			} else {
				return "Pending";
			}
		} catch(PDOException $e) {
			throw new Exception($e->getMessage());
		}		
	}

	public function requestNo($prefix,$tableName) {
		try {
			global $lastRow;
			$sql = "SELECT TOP 1 requestNo FROM ".$tableName." ORDER BY id DESC";
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute();
			if ($stmt->rowCount() != 0) {
				$row = $stmt->fetch(PDO::FETCH_ASSOC);
				$lastRow = $row['requestNo'];
				$lastRow = substr($lastRow, 4, 7);
				$lastRow = (int) $lastRow + 1;
				$lastRow = $prefix . sprintf('%07s', $lastRow);
				$newRequestNo = $lastRow;
				return $newRequestNo;
			} else {
				$lastRow = $prefix."0000001";
				$newRequestNo = $lastRow;
				return $newRequestNo;
			}
		} catch(PDOException $e) {
			throw new Exception($e->getMessage());
		}	
	}

	public function leaveRequestNo($prefix,$tableName) {
	    global $lastRow;
	    $sql = "SELECT TOP 1 requestNo FROM ".$tableName." ORDER BY requestNo DESC";
	    $stmt = $this->connect()->prepare($sql);
	    $stmt->execute();

	    if ($stmt->rowCount() != 0) {
	        $row = $stmt->fetch(PDO::FETCH_ASSOC);
	        $lastRow = $row['requestNo'];
	        $lastRow = substr($lastRow, 4, 7);
	        $lastRow = (int) $lastRow + 1;
	        $lastRow = $prefix . sprintf('%07s', $lastRow);
	        $newRequestNo = $lastRow;
	        return $newRequestNo;
	    } else {
	        $lastRow = $prefix."0000001";
	        $newRequestNo = $lastRow;
	        return $newRequestNo;
	    }
	}

	public function getInternalLeaveBalance($staffId,$fieldname) {
		try {
			$sql = "SELECT sum(total) as balance FROM internalleavebalancedetails WHERE staffId = :staff_id";
			$stmt = $this->connect()->prepare($sql);
			$stmt->bindValue(':staff_id',$staffId);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			$this->totalCount = $stmt->rowCount();
			if($stmt->rowCount() != 0) {
				return $result[$fieldname];	
			} else {
				return 0;
			}
		} catch(PDOException $e) {
			throw new Exception($e->getMessage());
		}		
	}

	public function getInternalLeavePending($staffId,$fieldname) {
		try {
			$sql = "SELECT sum(total) as balance FROM internalleavebalancedetails WHERE staffId = :staff_id AND `status` = 'Pending'";
			$stmt = $this->connect()->prepare($sql);
			$stmt->bindValue(':staff_id',$staffId);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			$this->totalCount = $stmt->rowCount();
			if($stmt->rowCount() != 0) {
				return $result[$fieldname];
			} else {
				return 0;
			}
		} catch(PDOException $e) {
			throw new Exception($e->getMessage());
		}		
	}

	public function getEmergencyLeaveBalance($staffId,$fieldname) {
		try {
			$sql = "SELECT sum(total) as balance FROM emergencyleavebalancedetails WHERE staffId = :staff_id";
			$stmt = $this->connect()->prepare($sql);
			$stmt->bindValue(':staff_id',$staffId);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			$this->totalCount = $stmt->rowCount();
			if($stmt->rowCount() != 0) {
				return $result[$fieldname];	
			} else {
				return 0;
			}
		} catch(PDOException $e) {
			throw new Exception($e->getMessage());
		}		
	}

	public function getEmergencyLeavePending($staffId,$fieldname) {
		try {
			$sql = "SELECT sum(total) as balance FROM emergencyleavebalancedetails WHERE staffId = :staff_id AND `status` = 'Pending'";
			$stmt = $this->connect()->prepare($sql);
			$stmt->bindValue(':staff_id',$staffId);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			$this->totalCount = $stmt->rowCount();
			if($stmt->rowCount() != 0) {
				return $result[$fieldname];
			} else {
				return 0;
			}
		} catch(PDOException $e) {
			throw new Exception($e->getMessage());
		}		
	}
	
	public function cleanString($str) {
		$str = strip_tags($str);
		$str = trim($str);
		if(get_magic_quotes_gpc()) {
			$str = stripslashes($str);
		}
		return $str;
	}

	public function displayArr($arr){
		echo '<pre>';
		print_r($arr);
		echo '</pre>';
	}

	public function displayDateTime($date) {
		$convertedDate = date("d/m/Y H:i:s",strtotime($date));
		return $convertedDate;
	}

	public function mySQLDate($var) {
		$date = str_replace('/', '-', $var);
        $convertedDate = date('Y-m-d', strtotime($date));
		return $convertedDate;
	}

	public function getCurrentDate(){
		return date('Y-m-d H:i:s');
	}

	public function getUserIP() {
		if(isset($_SERVER['HTTP_CF_CONNECTING_IP'])){
			return $_SERVER['HTTP_CF_CONNECTING_IP'];
		} else {
			return $_SERVER['REMOTE_ADDR'];
		}
	}

	public function logoutUser(){
		//session_start();
		session_destroy();
		unset($_SESSION);
		header('Location: login.php');
	}

	public function isUserLogged(){
		if (!isset($_SESSION['id']) && !isset($_SESSION['username'])) {
			return false;
		} else {
			return true;
		}
	}

	public function isAllowed($mod_type){
		/*NOTE: To successfully use this function, make sure that you create a $_SESSION['id'] variable AFTER SUCCESSFUL LOGINS
			0 - Super Admin
			1 - HR Head
			2 - HR Staff
			3 - Department/Centre Heads (HoD/HoC)
			4 - Section Head (HoS)
			5 - Approver
			6 - Staff
		*/
		$uid = $this->cleanString($_SESSION['id']);
		if($mod_type == "SuperAdmin") {
			$query = "SELECT userType FROM users WHERE id = $uid AND userType = 0 LIMIT 1";
		} else if($mod_type == "HRHead") {
			$query = "SELECT userType FROM users WHERE id = $uid AND userType = 1 LIMIT 1";
		} else if($mod_type == "HRStaff") {
			$query = "SELECT userType FROM users WHERE id = $uid AND userType = 2 LIMIT 1";
		} else if($mod_type == "HoD_HoC") {
			$query = "SELECT userType FROM users WHERE id = $uid AND userType = 3 LIMIT 1";
		} else if($mod_type == "HoS") {
			$query = "SELECT userType FROM users WHERE id = $uid AND userType = 4 LIMIT 1";
		} else if($mod_type == "Approver") {
			$query = "SELECT userType FROM users WHERE id = $uid AND userType = 5 LIMIT 1";
		} else if($mod_type == "Staff") {
			$query = "SELECT userType FROM users WHERE id = $uid AND userType = 6 LIMIT 1";
		}

		$stmt = $this->connect()->prepare($query);
		$stmt->execute();
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		$this->totalCount = $stmt->rowCount();
		if($this->totalCount != 0) {
			return true;
		} else {
			return false;
		}
	}
}
?>