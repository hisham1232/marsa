<?php
define('CACHE_FRONTEND_OPTIONS', serialize(array('automatic_cleaning_factor' => 0)));
ini_set('opcache.enable', '0');
ini_set("display_errors", 1); 
ini_set("log_errors", 1);
ini_set("error_log", dirname(__FILE__).'/logs.txt');
error_reporting(E_ALL);
//error_reporting(0);
date_default_timezone_set('Asia/Muscat');
include("phpmailer/class.phpmailer.php");
class Db {
	protected function connect() {
		$serverName = "172.16.10.15";
		$database = "dbhr3_test";
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
class DbaseManipulation extends Db { //Inheritance, inheriting class Db
	private $date;
	private $userip;
	public function __construct(){
		$this->date 	= $this->getCurrentDate();
		$this->userip 	= $this->getUserIP();
	}

	public function singleRead($tableName,$id) {
		try {
			$sql = "SELECT * FROM ".$tableName." WHERE id = :id";
			$stmt = $this->connect()->prepare($sql);
			$stmt->bindValue(':id',$id);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			return $result;
		} catch(PDOException $e) {
			throw new Exception($e->getMessage());
		}
			
	}

	public function singleReadFullQry($sql) {
		try {
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			$this->totalCount = $stmt->rowCount();
			if($this->totalCount == 0)
				$this->totalCount = 0;
			else 
				$this->totalCount = 1;
			return $result;
		} catch(PDOException $e) {
			throw new Exception($e->getMessage());
		}	
	}

	public function executeSQL($sql) {
		try {
			$stmt = $this->connect()->prepare($sql);
			$stmtExec = $stmt->execute();
			if ($stmtExec) {
				return true;
				echo $sql;
			} else {
				return false;
			}
		} catch(PDOException $e) {
			throw new Exception($e->getMessage());
		}	
	}

	public function readData($sql) {
		try {
			$result = $this->connect()->prepare($sql);
			$result->execute();
			$this->totalCount = $result->rowCount();
			if($result->rowCount() != 0) {
				while ($row = $result->fetch()) {
					$data[] = $row;
				}
				return $data;	
			}
		} catch(PDOException $e) {
			throw new Exception($e->getMessage());
		}	
	}
		
	public function insert($tableName,$fields) {
		try {
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
		} catch(PDOException $e) {
			throw new Exception($e->getMessage());
		}			
	}

	public function update($tableName,$fields,$id) {
		try {
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
		} catch(PDOException $e) {
			throw new Exception($e->getMessage());
		}	
	}

	public function destroy($tableName,$id) {
		try {
			$sql = "DELETE FROM ".$tableName." WHERE id = :id";
			$stmt = $this->connect()->prepare($sql);
			$stmt->bindValue(':id',$id);
			$stmt->execute();
		} catch(PDOException $e) {
			throw new Exception($e->getMessage());
		}			
	}

	public function fieldNameValue($tableName,$id,$fieldname) {
		try {
			$sql = "SELECT * FROM ".$tableName." WHERE id = :id";
			$stmt = $this->connect()->prepare($sql);
			$stmt->bindValue(':id',$id);
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

	public function staff_primary_id($id,$fieldname) {
		try {
			$sql = "SELECT id FROM staff WHERE staffId = :id";
			$stmt = $this->connect()->prepare($sql);
			$stmt->bindValue(':id',$id);
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
				return "";
			}
		} catch(PDOException $e) {
			throw new Exception($e->getMessage());
		}	              
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
			$sql = "SELECT * FROM contactdetails WHERE contacttype_id = :cid AND staff_id = :staffid AND isCurrent = 'Y'";
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

	public function internalLeaveBalanceId($prefix,$tableName) {
		try {
			global $lastRow;
			$sql = "SELECT TOP 1 internalleavebalance_id FROM ".$tableName." ORDER BY id DESC";
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute();
			if ($stmt->rowCount() != 0) {
				$row = $stmt->fetch(PDO::FETCH_ASSOC);
				$lastRow = $row['internalleavebalance_id'];
				$lastRow = substr($lastRow, 4, 7);
				$lastRow = (int) $lastRow + 1;
				$lastRow = $prefix . sprintf('%07s', $lastRow);
				$internalleavebalance_id = $lastRow;
				return $internalleavebalance_id;
			} else {
				$lastRow = $prefix."0000001";
				$internalleavebalance_id = $lastRow;
				return $internalleavebalance_id;
			}
		} catch(PDOException $e) {
			throw new Exception($e->getMessage());
		}	
	}

	public function emergencyLeaveBalanceId($prefix,$tableName) {
		try {
			global $lastRow;
			$sql = "SELECT TOP 1 emergencyleavebalance_id FROM ".$tableName." ORDER BY id DESC";
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute();
			if ($stmt->rowCount() != 0) {
				$row = $stmt->fetch(PDO::FETCH_ASSOC);
				$lastRow = $row['emergencyleavebalance_id'];
				$lastRow = substr($lastRow, 4, 7);
				$lastRow = (int) $lastRow + 1;
				$lastRow = $prefix . sprintf('%07s', $lastRow);
				$emergencyleavebalance_id = $lastRow;
				return $emergencyleavebalance_id;
			} else {
				$lastRow = $prefix."0000001";
				$emergencyleavebalance_id = $lastRow;
				return $emergencyleavebalance_id;
			}
		} catch(PDOException $e) {
			throw new Exception($e->getMessage());
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
			$sql = "SELECT sum(total) as balance FROM internalleavebalancedetails WHERE staffId = :staff_id AND status = 'Pending'";
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
			$sql = "SELECT sum(total) as balance FROM emergencyleavebalancedetails WHERE staffId = :staff_id AND status = 'Pending'";
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

	public function prev_approver_shortleave($id,$fieldname) {
		try {
			$sql = "SELECT * FROM approvalsequence_shortleave WHERE id = :id";
			$stmt = $this->connect()->prepare($sql);
			$stmt->bindValue(':id',$id);
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

	public function shortLeaveHistory($id,$fieldname) {
		try {
			$sql = "SELECT TOP 1 * FROM shortleave_history WHERE shortleave_id = :id ORDER BY id DESC";
			$stmt = $this->connect()->prepare($sql);
			$stmt->bindValue(':id',$id);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			$this->totalCount = $stmt->rowCount();
			if($stmt->rowCount() != 0) {
				return $result[$fieldname];	
			} else {
				return "No data found!";
			}
		} catch(PDOException $e) {
			throw new Exception($e->getMessage());
		}		
	}

	public function standardLeaveHistory($id,$fieldname) {
		try {
			$sql = "SELECT TOP 1 * FROM standardleave_history WHERE standardleave_id = :id ORDER BY id DESC";
			$stmt = $this->connect()->prepare($sql);
			$stmt->bindValue(':id',$id);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			$this->totalCount = $stmt->rowCount();
			if($stmt->rowCount() != 0) {
				return $result[$fieldname];	
			} else {
				return "No data found!";
			}
		} catch(PDOException $e) {
			throw new Exception($e->getMessage());
		}		
	}


	public function cleanString($str) {
		$str = str_replace("'", "", $str);
		$str = str_replace('"', "", $str);
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

	public function getCurrentDate(){
		return date('Y-m-d H:i:s');
	}

	public function mySQLDate($var) {
		$date = str_replace('/', '-', $var);
        $convertedDate = date('Y-m-d', strtotime($date));
		return $convertedDate;
	}

	public function getUserIP() {
		if(isset($_SERVER['HTTP_CF_CONNECTING_IP'])){
			return $_SERVER['HTTP_CF_CONNECTING_IP'];
		} else {
			return $_SERVER['REMOTE_ADDR'];
		}
	}

	public function logoutUser(){
		session_destroy();
		unset($_SESSION);
		header('Location: login.php');
		//header('Location: https://www.nct.edu.om/eservices/index.php');
	}

	public function isUserLogged(){
		if (!isset($_SESSION['login_id']) && !isset($_SESSION['username']) && !isset($_SESSION['user_type'])) {
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
		try {
			$uid = $this->cleanString($_SESSION['login_id']);
			if($mod_type == "SuperAdmin") {
				$query = "SELECT TOP 1 userType FROM users WHERE id = $uid AND userType = 0";
			} else if($mod_type == "HRHead") {
				$query = "SELECT TOP 1 userType FROM users WHERE id = $uid AND userType = 1";
			} else if($mod_type == "HRStaff") {
				$query = "SELECT TOP 1 userType FROM users WHERE id = $uid AND userType = 2";
			} else if($mod_type == "HoD_HoC") {
				$query = "SELECT TOP 1 userType FROM users WHERE id = $uid AND userType = 3";
			} else if($mod_type == "HoS") {
				$query = "SELECT TOP 1 userType FROM users WHERE id = $uid AND userType = 4";
			} else if($mod_type == "Approver") {
				$query = "SELECT TOP 1 userType FROM users WHERE id = $uid AND userType = 5";
			} else if($mod_type == "Staff") {
				$query = "SELECT TOP 1 userType FROM users WHERE id = $uid AND userType = 6";
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
		} catch(PDOException $e) {
			throw new Exception($e->getMessage());
		}	
	}

	public function withAccess($user_type,$linkid){
		try {
			$sql = "SELECT * FROM access_menu_matrix_sub WHERE user_type_id = :user_type AND active = 1 AND id = :linkid";
			$stmt = $this->connect()->prepare($sql);
			$stmt->bindValue(':user_type',$user_type);
			$stmt->bindValue(':linkid',$linkid);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			$this->totalCount = $stmt->rowCount();
			if($this->totalCount != 0) {
				return true;
			} else {
				return false;
			}
		} catch(PDOException $e) {
			throw new Exception($e->getMessage());
		}
	}

	public function isShortLeaveApprover($position_id,$fieldname) {
		try {
			$sql = "SELECT * FROM approvalsequence_shortleave WHERE approverInSequence1 = :position_id AND active = 1";
			$stmt = $this->connect()->prepare($sql);
			$stmt->bindValue(':position_id',$position_id);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			$this->totalCount = $stmt->rowCount();
			if($stmt->rowCount() != 0) {
				return 1;
			} else {
				return 0;
			}
		} catch(PDOException $e) {
			throw new Exception($e->getMessage());
		}		
	}

	public function isStandardLeaveApprover($position_id,$fieldname) {
		try {
			$sql = "SELECT * FROM approvalsequence_standardleave WHERE approver_id = :position_id AND active = 1";
			$stmt = $this->connect()->prepare($sql);
			$stmt->bindValue(':position_id',$position_id);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			$this->totalCount = $stmt->rowCount();
			if($stmt->rowCount() != 0) {
				return 1;
			} else {
				return 0;
			}
		} catch(PDOException $e) {
			throw new Exception($e->getMessage());
		}		
	}

	public function isOvertimeLeaveApprover($position_id,$fieldname) {
		try {
			$sql = "SELECT * FROM internalleaveovertime_approvalsequence WHERE approver_id = :position_id AND active = 1";
			$stmt = $this->connect()->prepare($sql);
			$stmt->bindValue(':position_id',$position_id);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			$this->totalCount = $stmt->rowCount();
			if($stmt->rowCount() != 0) {
				return 1;
			} else {
				return 0;
			}
		} catch(PDOException $e) {
			throw new Exception($e->getMessage());
		}		
	}

	public function pageId($page_name,$fieldname) {
		try {
			$sql = "SELECT id, page_name FROM access_menu_left_sub WHERE page_name = :page_name AND active = 1";
			$stmt = $this->connect()->prepare($sql);
			$stmt->bindValue(':page_name',$page_name);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			$this->totalCount = $stmt->rowCount();
			if($stmt->rowCount() != 0) {
				return $result[$fieldname];
			} else {
				return "index.php";
			}
		} catch(PDOException $e) {
			throw new Exception($e->getMessage());
		}		
	}

	public function linkId($page_id,$user_type_id,$fieldname) {
		try {
			$sql = "SELECT id, user_type_id, access_menu_left_sub_id FROM access_menu_matrix_sub WHERE access_menu_left_sub_id = :page_id and user_type_id = :user_type_id AND active = 1";
			$stmt = $this->connect()->prepare($sql);
			$stmt->bindValue(':page_id',$page_id);
			$stmt->bindValue(':user_type_id',$user_type_id);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			$this->totalCount = $stmt->rowCount();
			if($stmt->rowCount() != 0) {
				return $result[$fieldname];
			} else {
				return "index.php";
			}
		} catch(PDOException $e) {
			throw new Exception($e->getMessage());
		}		
	}

	public function getMySequenceNo($position_id,$fieldname) {
		$seq = array();
		try {
			$sql = "SELECT DISTINCT(approver_id) FROM approvalsequence_standardleave WHERE approver_id = :position_id AND active = 1";
			$stmt = $this->connect()->prepare($sql);
			$stmt->bindValue(':position_id',$position_id);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			$this->totalCount = $stmt->rowCount();
			if($stmt->rowCount() != 0) {
				return $result[$fieldname];	
			} else {
				return "No data found!";
			}
		} catch(PDOException $e) {
			throw new Exception($e->getMessage());
		}		
	}

	public function getMyDeptSequenceNo($position_id,$department_id,$fieldname) {
		try {
			$sql = "SELECT * FROM approvalsequence_standardleave WHERE approver_id = :position_id AND department_id = :department_id AND active = 1";
			$stmt = $this->connect()->prepare($sql);
			$stmt->bindValue(':position_id',$position_id);
			$stmt->bindValue(':department_id',$department_id);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			$this->totalCount = $stmt->rowCount();
			if($stmt->rowCount() != 0) {
				return $result[$fieldname];	
			} else {
				return "No data found!";
			}
		} catch(PDOException $e) {
			throw new Exception($e->getMessage());
		}		
	}

	public function standardApproverIds($position_id,$seqNo,$fieldname) {
		try {
			$sql = "SELECT * FROM approvalsequence_standardleave WHERE position_id = :position_id AND active = 1";
			$stmt = $this->connect()->prepare($sql);
			$stmt->bindValue(':position_id',$position_id);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			$this->totalCount = $stmt->rowCount();
			if($stmt->rowCount() != 0) {
				return $result[$fieldname];	
			} else {
				return "No data found!";
			}
		} catch(PDOException $e) {
			throw new Exception($e->getMessage());
		}		
	}

	public function standardLastStatus($id,$fieldname) {
		try {
			$sql = "SELECT TOP 1 * FROM standardleave_history WHERE standardleave_id = :id ORDER BY id DESC";
			$stmt = $this->connect()->prepare($sql);
			$stmt->bindValue(':id',$id);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			$this->totalCount = $stmt->rowCount();
			if($stmt->rowCount() != 0) {
				return $result[$fieldname];	
			} else {
				return "No data found!";
			}
		} catch(PDOException $e) {
			throw new Exception($e->getMessage());
		}		
	}

	public function overtimeLastStatus($requestNo,$fieldname) {
		try {
			$sql = "SELECT TOP 1 * FROM internalleaveovertime_history WHERE requestNo = :requestNo ORDER BY id DESC";
			$stmt = $this->connect()->prepare($sql);
			$stmt->bindValue(':requestNo',$requestNo);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			$this->totalCount = $stmt->rowCount();
			if($stmt->rowCount() != 0) {
				return $result[$fieldname];	
			} else {
				return "No data found!";
			}
		} catch(PDOException $e) {
			throw new Exception($e->getMessage());
		}		
	}

	public function get_staff_id_position_id($position_id,$fieldname) {
		try {
			$sql = "SELECT TOP 1 staff_id FROM employmentdetail WHERE position_id = :position_id AND isCurrent = 1";
			$stmt = $this->connect()->prepare($sql);
			$stmt->bindValue(':position_id',$position_id);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			$this->totalCount = $stmt->rowCount();
			if($stmt->rowCount() != 0) {
				return $result[$fieldname];	
			} else {
				return "No data found!";
			}
		} catch(PDOException $e) {
			throw new Exception($e->getMessage());
		}		
	}

	public function checkAccessLink($user_type,$page_name,$fieldname) {
		try {
			$sql = "SELECT id, page_name FROM access_pages WHERE user_type = :user_type and page_name = :page_name AND active = 1";
			$stmt = $this->connect()->prepare($sql);
			$stmt->bindValue(':user_type',$user_type);
			$stmt->bindValue(':page_name',$page_name);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			$this->totalCount = $stmt->rowCount();
			if($stmt->rowCount() != 0) {
				return $result[$fieldname];	
			} else {
				return "no_access_found.php";
			}
		} catch(PDOException $e) {
			throw new Exception($e->getMessage());
		}		
	}

	public function createDateRangeArray($startDate,$endDate) {
		$aryRange = array();
		$iDateFrom = mktime(1,0,0,substr($startDate,5,2), substr($startDate,8,2), substr($startDate,0,4));
		$iDateTo = mktime(1,0,0,substr($endDate,5,2), substr($endDate,8,2), substr($endDate,0,4));
	
		if ($iDateTo>=$iDateFrom) {
			array_push($aryRange,date('Y-m-d',$iDateFrom)); // First entry
			while ($iDateFrom<$iDateTo) {
				$iDateFrom+=86400; // Add 24 hours
				array_push($aryRange,date('Y-m-d',$iDateFrom));
			}
		}
		return $aryRange;
	}
	function formatAttendanceTime($seconds) {
	  $t = round($seconds);
	  return sprintf('%02d:%02d:%02d', ($t/3600),($t/60%60), $t%60);
	}




























	public function uploadPhoto(){
        $result_message="";
        // now, if image is not empty, try to upload the image
        if($this->image){
            // sha1_file() function is used to make a unique file name
            $target_directory = "uploads/";
            $target_file = $target_directory . $this->image;
            $file_type = pathinfo($target_file, PATHINFO_EXTENSION);
     
            // error message is empty
            $file_upload_error_messages="";
            // make sure that file is a real image OR a pdf file
            $check = getimagesize($_FILES["image"]["tmp_name"]);
            if($check !== false){
                // submitted file is an image
            } else {
                $file_upload_error_messages.="<div>Image was not uploaded. Image must be less than 1 MB in size.</div>";
            }
             
            // make sure certain file types are allowed
            $allowed_file_types=array("jpg", "jpeg", "png", "gif", "pdf");
            if(!in_array($file_type, $allowed_file_types)){
                $file_upload_error_messages.="<div>Submitted file is not an image/pdf file. Only JPG, JPEG, PNG, GIF, PDF files are allowed.</div>";
            }
             
            // make sure file does not exist
            if(file_exists($target_file)){
                $file_upload_error_messages.="<div>Image already exists. Try to change file name.</div>";
            }
             
            // make sure submitted file is not too large, can't be larger than 1 MB
            if($_FILES['image']['size'] > 1024000){
                $file_upload_error_messages.="<div>Image must be less than 1 MB in size.</div>";
            }
             
            // make sure the 'uploads' folder exists
            // if not, create it
            if(!is_dir($target_directory)){
                mkdir($target_directory, 0777, true);
            }

            // if $file_upload_error_messages is still empty
            if(empty($file_upload_error_messages)){
                // it means there are no errors, so try to upload the file
                if(move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)){
                    // it means photo was uploaded
                }else{
                    $result_message.="<div class='alert alert-danger'>";
                        $result_message.="<div>Unable to upload photo.</div>";
                        $result_message.="<div>Kindly update the record to upload/update photo.</div>";
                    $result_message.="</div>";
                }
            }
             
            // if $file_upload_error_messages is NOT empty
            else{
                // it means there are some errors, so show them to user
                $result_message.="<div class='alert alert-danger'>";
                    $result_message.="{$file_upload_error_messages}";
                    $result_message.="<div>Kindly update the record to upload/update photo.</div>";
                $result_message.="</div>";
            }
        }
        return $result_message;
    }
}



class sendMail {
	function smtpMailer($to, $from, $from_name, $subject, $body) { 
		define('GUSER', 'hrms@nct.edu.om'); // GMail username
		define('GPWD', 'Hr@UTAS_Nizwa^_^RK'); // GMail password
	    global $error;
	    $mail = new PHPMailer();  // create a new object
	    $mail->IsSMTP(); // enable SMTP
	    $mail->SMTPDebug = 0;  // debugging: 1 = errors and messages, 2 = messages only
	    $mail->SMTPAuth = true;  // authentication enabled
	    $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
	    $mail->Host = 'smtp.gmail.com';
	    $mail->Port = 465; 
	    $mail->Username = GUSER;  
	    $mail->Password = GPWD;           
	    $mail->SetFrom($from, $from_name);
	    $mail->Subject = $subject;
	    $mail->Body = $body;
		$mail->IsHTML(true);
	    
	    if (is_array($to)) {
	        foreach($to as $k => $v) {
	            $mail->AddAddress($v);    
	        }
	    } else {
	        $mail->AddAddress($to); 
	    }
	    
	    if(!$mail->Send()) {
	        $error = 'Mail error: '.$mail->ErrorInfo; 
	        return false;
	    } else {
	        $error = 'Message sent!';
	        return true;
	    }
	}
}

$logger = new DbaseManipulation;	
if(isset($_GET['logout']) && $_GET['logout'] == true){
	$logger->logoutUser();
}
?>