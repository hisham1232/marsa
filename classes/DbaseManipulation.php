<?php
define('CACHE_FRONTEND_OPTIONS', serialize(array('automatic_cleaning_factor' => 0)));
ini_set('opcache.enable', '0');
ini_set("display_errors", 1); 
ini_set("log_errors", 1);
ini_set("error_log", dirname(__FILE__).'/logs.txt');
error_reporting(E_ALL);
error_reporting(0);
date_default_timezone_set('Asia/Muscat');
include("phpmailer/class.phpmailer.php");
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
class DbaseManipulation extends Db { //"extends" means inheriting class Db
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
// created by khamis
	public function checkDateRange($sql) {
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
				//echo $sql;
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

	public function employmentFieldName($id,$fieldname) {
		try {
			$sql = "SELECT * FROM employmentdetail WHERE id = :id AND isCurrent = 1 AND status_id = 1";
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

	public function CandidateId($prefix,$tableName) {
		try {
			global $lastRow;
			$sql = "SELECT TOP 1 candidateId FROM ".$tableName." ORDER BY id DESC";
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute();
			if ($stmt->rowCount() != 0) {
				$row = $stmt->fetch(PDO::FETCH_ASSOC);
				$lastRow = $row['candidateId'];
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

	public function countDepartmentWinner($department_id,$taon,$buwan,$fieldname) {
		try {
			$sql = "SELECT COUNT(id) as winnerCtr FROM award_candidate WHERE department_id = $department_id AND canYear = '$taon' AND canMonth = '$buwan' AND canStatus = 'Winner'";
			$stmt = $this->connect()->prepare($sql);
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

	public function countWinnings($staffId,$fieldname) {
		try {
			$sql = "SELECT COUNT(id) as winningCtr FROM award_candidate WHERE staffId = '$staffId' AND canStatus = 'Winner'";
			$stmt = $this->connect()->prepare($sql);
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

	public function countGrievance($department_id,$type,$fieldname) {
		try {
			$sql = "SELECT count(g.id) as statCount FROM grievance as g LEFT OUTER JOIN employmentdetail as e ON g.responder = e.staff_id LEFT OUTER JOIN department as d ON d.id = e.department_id WHERE d.id = $department_id AND g.complaint_type = $type";
			$stmt = $this->connect()->prepare($sql);
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

	public function countGrievanceDate($department_id,$type,$sDate,$eDate,$fieldname) {
		try {
			$sql = "SELECT count(g.id) as statCount FROM grievance as g LEFT OUTER JOIN employmentdetail as e ON g.responder = e.staff_id LEFT OUTER JOIN department as d ON d.id = e.department_id WHERE d.id = $department_id AND g.complaint_type = $type AND g.date_filed >= '$sDate' AND g.date_filed <= '$eDate'";
			$stmt = $this->connect()->prepare($sql);
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

	public function countGrievanceTotal($department_id,$fieldname) {
		try {
			$sql = "SELECT count(g.id) as statCountTotal FROM grievance as g LEFT OUTER JOIN employmentdetail as e ON g.responder = e.staff_id LEFT OUTER JOIN department as d ON d.id = e.department_id WHERE d.id = $department_id";
			$stmt = $this->connect()->prepare($sql);
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

	public function countGrievanceTotalDate($department_id,$sDate,$eDate,$fieldname) {
		try {
			$sql = "SELECT count(g.id) as statCountTotal FROM grievance as g LEFT OUTER JOIN employmentdetail as e ON g.responder = e.staff_id LEFT OUTER JOIN department as d ON d.id = e.department_id WHERE d.id = $department_id AND g.date_filed >= '$sDate' AND g.date_filed <= '$eDate'";
			$stmt = $this->connect()->prepare($sql);
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

	public function countGrievanceStat($department_id,$status,$fieldname) {
		try {
			$sql = "SELECT count(g.id) as statCountStatus FROM grievance as g LEFT OUTER JOIN employmentdetail as e ON g.responder = e.staff_id LEFT OUTER JOIN department as d ON d.id = e.department_id WHERE d.id = $department_id AND g.status = '$status'";
			$stmt = $this->connect()->prepare($sql);
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

	public function countGrievanceStatDate($department_id,$status,$sDate,$eDate,$fieldname) {
		try {
			$sql = "SELECT count(g.id) as statCountStatus FROM grievance as g LEFT OUTER JOIN employmentdetail as e ON g.responder = e.staff_id LEFT OUTER JOIN department as d ON d.id = e.department_id WHERE d.id = $department_id AND g.status = '$status' AND g.date_filed >= '$sDate' AND g.date_filed <= '$eDate'";
			$stmt = $this->connect()->prepare($sql);
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

	public function complaintCount($staffId,$fieldname) {
		try {
			$sql = "SELECT COUNT(id) as bilang FROM grievance WHERE complainant = '$staffId'";
			$stmt = $this->connect()->prepare($sql);
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

	public function complaintCountDate($staffId,$sDate,$eDate,$fieldname) {
		try {
			$sql = "SELECT COUNT(id) as bilang FROM grievance WHERE complainant = '$staffId' AND date_filed >= '$sDate' AND date_filed <= '$eDate'";
			$stmt = $this->connect()->prepare($sql);
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

	public function responderCount($staffId,$fieldname) {
		try {
			$sql = "SELECT COUNT(id) as bilang FROM grievance WHERE responder = '$staffId'";
			$stmt = $this->connect()->prepare($sql);
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

	public function responderCountDate($staffId,$sDate,$eDate,$fieldname) {
		try {
			$sql = "SELECT COUNT(id) as bilang FROM grievance WHERE responder = '$staffId' AND date_filed >= '$sDate' AND date_filed <= '$eDate'";
			$stmt = $this->connect()->prepare($sql);
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

	public function countAllGrievance($fieldname) {
		try {
			$sql = "SELECT COUNT(id) as totalBilang FROM grievance";
			$stmt = $this->connect()->prepare($sql);
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

	public function countAllGrievanceDate($sDate,$eDate,$fieldname) {
		try {
			$sql = "SELECT COUNT(id) as totalBilang FROM grievance WHERE date_filed >= '$sDate' AND date_filed <= '$eDate'";
			$stmt = $this->connect()->prepare($sql);
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

	public function countGrievanceStatTotal($department_id,$fieldname) {
		try {
			$sql = "SELECT count(g.id) as statCountStatusTotal FROM grievance as g LEFT OUTER JOIN employmentdetail as e ON g.responder = e.staff_id LEFT OUTER JOIN department as d ON d.id = e.department_id WHERE d.id = $department_id";
			$stmt = $this->connect()->prepare($sql);
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

	public function countGrievanceStatTotalDate($department_id,$sDate,$eDate,$fieldname) {
		try {
			$sql = "SELECT count(g.id) as statCountStatusTotal FROM grievance as g LEFT OUTER JOIN employmentdetail as e ON g.responder = e.staff_id LEFT OUTER JOIN department as d ON d.id = e.department_id WHERE d.id = $department_id AND g.date_filed >= '$sDate' AND g.date_filed <= '$eDate'";
			$stmt = $this->connect()->prepare($sql);
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

	public function countStandardClearance($department_id,$fieldname) {
		try {
			$sql = "SELECT count(*) as ctr FROM clearance as c LEFT OUTER JOIN employmentdetail as e ON c.staffId = e.staff_id WHERE e.department_id = $department_id AND e.isCurrent = 1 AND c.requestNo LIKE 'CLR-%'";
			$stmt = $this->connect()->prepare($sql);
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

	public function countShortClearance($department_id,$fieldname) {
		try {
			$sql = "SELECT count(*) as ctr FROM clearance as c LEFT OUTER JOIN employmentdetail as e ON c.staffId = e.staff_id WHERE e.department_id = $department_id AND e.isCurrent = 1 AND c.requestNo LIKE 'STC-%'";
			$stmt = $this->connect()->prepare($sql);
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

	public function countSkipClearance($department_id,$fieldname) {
		try {
			$sql = "SELECT count(*) as ctr FROM clearance_skip as c LEFT OUTER JOIN employmentdetail as e ON c.staffId = e.staff_id WHERE e.department_id = $department_id AND e.isCurrent != 1 AND c.requestNo LIKE 'SKP-%'";
			$stmt = $this->connect()->prepare($sql);
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

	public function countClearanceByStatus($department_id,$status_id,$fieldname) {
		try {
			$sql = "SELECT count(*) as ctr FROM clearance as c LEFT OUTER JOIN employmentdetail as e ON c.staffId = e.staff_id WHERE e.department_id = $department_id AND status_id = $status_id AND e.isCurrent = 1";
			$stmt = $this->connect()->prepare($sql);
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

	public function sectionId($staffId,$fieldname) {
		try {
			$sql = "SELECT TOP 1 section_id FROM employmentdetail WHERE staff_id = :staff_id AND isCurrent = 1 AND status_id = 1";
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

	public function departmentId($staffId,$fieldname) {
		try {
			$sql = "SELECT TOP 1 department_id FROM employmentdetail WHERE staff_id = :staff_id AND isCurrent = 1 AND status_id = 1";
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
		// header('Location: login.php');
		header('Location: https://www.nct.edu.om/eservices/index.php');
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



	public function getPassportNo($staffId,$fieldname) {
		try {
			$sql = "SELECT TOP 1 * FROM staffpassport WHERE isFamilyMember = 0 AND staffId = $staffId AND isCurrent = 1";
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			$this->totalCount = $stmt->rowCount();
			if($stmt->rowCount() != 0) {
				return $result[$fieldname];
			} else {
				return "No data.";
			}
		} catch(PDOException $e) {
			throw new Exception($e->getMessage());
		}	
	}

	public function getVisaNo($staffId,$fieldname) {
		try {
			$sql = "SELECT TOP 1 * FROM staffvisa WHERE isFamilyMember = 0 AND staffId = $staffId AND isCurrent = 1";
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			$this->totalCount = $stmt->rowCount();
			if($stmt->rowCount() != 0) {
				return $result[$fieldname];
			} else {
				return "No data.";
			}
		} catch(PDOException $e) {
			throw new Exception($e->getMessage());
		}	
	}



	//Staff Appraisal Functions Starts Here...


	public function getAppraisalYear($fieldname) {
		try {
			$sql = "SELECT TOP 1 appraisal_year FROM appraisal_settings WHERE status = 'OPEN'";
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			$this->totalCount = $stmt->rowCount();
			if($stmt->rowCount() != 0) {
				return $result[$fieldname];
			} else {
				return "No data.";
			}
		} catch(PDOException $e) {
			throw new Exception($e->getMessage());
		}	
	}	

	public function getTotalAppraisalStaffSection($department_id,$section_id,$fieldname) {
		try {
			$sql = "SELECT COUNT(*) AS ctr FROM employmentdetail WHERE department_id = $department_id AND section_id = $section_id AND isCurrent = 1 AND status_id = 1";
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			$this->totalCount = $stmt->rowCount();
			if($stmt->rowCount() != 0) {
				return $result[$fieldname];
			} else {
				return "No data.";
			}
		} catch(PDOException $e) {
			throw new Exception($e->getMessage());
		}	
	}

	public function getTotalAppraisalStaffDeptCenter($department_id,$fieldname) {
		try {
			$sql = "SELECT COUNT(*) AS ctr FROM employmentdetail WHERE department_id = $department_id AND isCurrent = 1 AND status_id = 1";
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			$this->totalCount = $stmt->rowCount();
			if($stmt->rowCount() != 0) {
				return $result[$fieldname];
			} else {
				return "No data.";
			}
		} catch(PDOException $e) {
			throw new Exception($e->getMessage());
		}	
	}

	public function getTotalAppraisalStaffAsstDean($department_ids,$fieldname) {
		try {
			$sql = "SELECT COUNT(*) AS ctr FROM employmentdetail WHERE department_id $department_ids AND isCurrent = 1 AND status_id = 1";
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			$this->totalCount = $stmt->rowCount();
			if($stmt->rowCount() != 0) {
				return $result[$fieldname];
			} else {
				return "No data.";
			}
		} catch(PDOException $e) {
			throw new Exception($e->getMessage());
		}	
	}

	public function getTotalAppraisalDean($fieldname) {
		try {
			$sql = "SELECT COUNT(*) AS ctr FROM employmentdetail WHERE isCurrent = 1 AND status_id = 1";
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			$this->totalCount = $stmt->rowCount();
			if($stmt->rowCount() != 0) {
				return $result[$fieldname];
			} else {
				return "No data.";
			}
		} catch(PDOException $e) {
			throw new Exception($e->getMessage());
		}	
	}

	public function getSubmittedSectionTech($department_id, $section_id, $appraisal_year, $fieldname) {
		try {
			$sql = "SELECT count(at.staff_id) as ctr FROM appraisal_technician as at LEFT OUTER JOIN employmentdetail as e ON e.staff_id = at.staff_id WHERE e.department_id = $department_id AND e.section_id = $section_id AND e.isCurrent = 1 AND e.status_id = 1 AND at.appraisal_year = '$appraisal_year'";
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			$this->totalCount = $stmt->rowCount();
			if($stmt->rowCount() != 0) {
				return $result[$fieldname];
			} else {
				return "No data.";
			}
		} catch(PDOException $e) {
			throw new Exception($e->getMessage());
		}	
	}

	public function getSubmittedDepartment($department_id, $appraisal_year, $fieldname) {
		try {
			$sql = "SELECT count(at.staff_id) as ctr FROM appraisal_technician as at LEFT OUTER JOIN employmentdetail as e ON e.staff_id = at.staff_id WHERE e.department_id = $department_id AND e.isCurrent = 1 AND e.status_id = 1 AND at.appraisal_year = '$appraisal_year'";
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			$this->totalCount = $stmt->rowCount();
			if($stmt->rowCount() != 0) {
				return $result[$fieldname];
			} else {
				return "No data.";
			}
		} catch(PDOException $e) {
			throw new Exception($e->getMessage());
		}	
	}

	public function getAppraisalType($staff_id,$fieldname) {
		try {
			$sql = "SELECT TOP 1 * FROM appraisal_type WHERE staff_id = $staff_id";
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			$this->totalCount = $stmt->rowCount();
			if($stmt->rowCount() != 0) {
				return $result[$fieldname];
			} else {
				return "No data.";
			}
		} catch(PDOException $e) {
			throw new Exception($e->getMessage());
		}	
	}

	 

	 

	public function countTrainingPerSection($section_id, $appraisal_year, $fieldname) {
		try {
			$sql = "SELECT count(t.id) as ctr  FROM appraisal_trainings as t LEFT OUTER JOIN employmentdetail as e ON e.staff_id = t.staff_id WHERE e.section_id = $section_id AND appraisal_year = '$appraisal_year'";
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			$this->totalCount = $stmt->rowCount();
			if($stmt->rowCount() != 0) {
				return $result[$fieldname];
			} else {
				return "No data.";
			}
		} catch(PDOException $e) {
			throw new Exception($e->getMessage());
		}	
	}

	 
	public function countDisSatisfaction($fieldname1,$fieldname) {
		try {
			$sql = "SELECT count(".$fieldname1.") as ctr2 FROM exit_interview_final WHERE ".$fieldname1." = 1";
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			$this->totalCount = $stmt->rowCount();
			if($stmt->rowCount() != 0) {
				return $result[$fieldname];
			} else {
				return "0";
			}
		} catch(PDOException $e) {
			throw new Exception($e->getMessage());
		}	
	}
	 
	public function countOpinionToSupervisor($fieldname1,$val,$fieldname) {
		try {
			$sql = "SELECT count(".$fieldname1.") as ctrOpinionSupervisor FROM exit_interview_final WHERE ".$fieldname1." = $val";
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			$this->totalCount = $stmt->rowCount();
			if($stmt->rowCount() != 0) {
				return $result[$fieldname];
			} else {
				return "0";
			}
		} catch(PDOException $e) {
			throw new Exception($e->getMessage());
		}	
	}
	 
	public function countSubmittedMyStaffAppraisalListHOSTechnician($section_id, $appraisal_year, $fieldname) {
		try {
			$sql = "SELECT COUNT(id) as submitted FROM appraisal_technician WHERE section_id = $section_id AND appraisal_year = '$appraisal_year'";
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			$this->totalCount = $stmt->rowCount();
			if($stmt->rowCount() != 0) {
				return $result[$fieldname];
			} else {
				return "No data.";
			}
		} catch(PDOException $e) {
			throw new Exception($e->getMessage());
		}	
	}
	public function countSubmittedMyStaffAppraisalListHOSLecturer($section_id, $appraisal_year, $fieldname) {
		try {
			$sql = "SELECT COUNT(id) as submitted FROM appraisal_lecturer WHERE section_id = $section_id AND appraisal_year = '$appraisal_year'";
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			$this->totalCount = $stmt->rowCount();
			if($stmt->rowCount() != 0) {
				return $result[$fieldname];
			} else {
				return "No data.";
			}
		} catch(PDOException $e) {
			throw new Exception($e->getMessage());
		}	
	}
	public function countMyStaffAppraisalListHOSTechnicianApproved($section_id, $appraisal_year, $fieldname) {
		try {
			$sql = "SELECT COUNT(id) as approved FROM appraisal_technician WHERE section_id = $section_id AND appraisal_year = '$appraisal_year' AND current_sequence >= 2";
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			$this->totalCount = $stmt->rowCount();
			if($stmt->rowCount() != 0) {
				return $result[$fieldname];
			} else {
				return "No data.";
			}
		} catch(PDOException $e) {
			throw new Exception($e->getMessage());
		}	
	}
	public function countMyStaffAppraisalListHOSLecturerApproved($section_id, $appraisal_year, $fieldname) {
		try {
			$sql = "SELECT COUNT(id) as approved FROM appraisal_lecturer WHERE section_id = $section_id AND appraisal_year = '$appraisal_year' AND current_sequence >= 2";
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			$this->totalCount = $stmt->rowCount();
			if($stmt->rowCount() != 0) {
				return $result[$fieldname];
			} else {
				return "No data.";
			}
		} catch(PDOException $e) {
			throw new Exception($e->getMessage());
		}	
	}


	public function countSubmittedMyStaffAppraisalListHODHOCTechnician($department_id, $appraisal_year, $fieldname) {
		try {
			$sql = "SELECT COUNT(id) as submitted FROM appraisal_technician WHERE department_id = $department_id AND appraisal_year = '$appraisal_year'";
			//echo $sql;
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			$this->totalCount = $stmt->rowCount();
			if($stmt->rowCount() != 0) {
				return $result[$fieldname];
			} else {
				return "No data.";
			}
		} catch(PDOException $e) {
			throw new Exception($e->getMessage());
		}	
	}

	public function countSubmittedMyStaffAppraisalListAsstDean($table_name, $department_ids, $appraisal_year, $fieldname) {
		try {
			$sql = "SELECT COUNT(id) as submitted FROM $table_name WHERE department_id $department_ids AND appraisal_year = '$appraisal_year'";
			//echo $sql.'<br/>';
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			$this->totalCount = $stmt->rowCount();
			if($stmt->rowCount() != 0) {
				return $result[$fieldname];
			} else {
				return "No data.";
			}
		} catch(PDOException $e) {
			throw new Exception($e->getMessage());
		}	
	}

	public function countSubmittedMyStaffAppraisalListAsstDeanExclude($table_name, $department_ids, $appraisal_year, $myPositionId, $fieldname) {
		try {
			$sql = "SELECT COUNT(id) as submitted FROM $table_name WHERE department_id $department_ids AND appraisal_year = '$appraisal_year' AND position_id != $myPositionId";
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			$this->totalCount = $stmt->rowCount();
			if($stmt->rowCount() != 0) {
				return $result[$fieldname];
			} else {
				return "No data.";
			}
		} catch(PDOException $e) {
			throw new Exception($e->getMessage());
		}	
	}

	public function countSubmittedMyStaffAppraisalListHODHOCLecturer($department_id, $appraisal_year, $fieldname) {
		try {
			$sql = "SELECT COUNT(id) as submitted FROM appraisal_lecturer WHERE department_id = $department_id AND appraisal_year = '$appraisal_year'";
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			$this->totalCount = $stmt->rowCount();
			if($stmt->rowCount() != 0) {
				return $result[$fieldname];
			} else {
				return "No data.";
			}
		} catch(PDOException $e) {
			throw new Exception($e->getMessage());
		}	
	}
	public function countSubmittedMyStaffAppraisalListHODHOCAdmin($department_id, $appraisal_year, $fieldname) {
		try {
			$sql = "SELECT COUNT(id) as submitted FROM appraisal_admin WHERE department_id = $department_id AND appraisal_year = '$appraisal_year'";
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			$this->totalCount = $stmt->rowCount();
			if($stmt->rowCount() != 0) {
				return $result[$fieldname];
			} else {
				return "No data.";
			}
		} catch(PDOException $e) {
			throw new Exception($e->getMessage());
		}	
	}
	public function countSubmittedMyStaffAppraisalListHODHOCHOS($department_id, $appraisal_year, $fieldname) {
		try {
			$sql = "SELECT COUNT(id) as submitted FROM appraisal_hos WHERE department_id = $department_id AND appraisal_year = '$appraisal_year'";

			$stmt = $this->connect()->prepare($sql);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			$this->totalCount = $stmt->rowCount();
			if($stmt->rowCount() != 0) {
				return $result[$fieldname];
			} else {
				return "No data.";
			}
		} catch(PDOException $e) {
			throw new Exception($e->getMessage());
		}	
	}

	public function countMyStaffAppraisalListHODTechnicianApproved($department_id, $appraisal_year, $fieldname) {
		try {
			$sql = "SELECT COUNT(id) as approved FROM appraisal_technician WHERE department_id = $department_id AND appraisal_year = '$appraisal_year' AND current_sequence >= 2";
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			$this->totalCount = $stmt->rowCount();
			if($stmt->rowCount() != 0) {
				return $result[$fieldname];
			} else {
				return "No data.";
			}
		} catch(PDOException $e) {
			throw new Exception($e->getMessage());
		}	
	}
	public function countMyStaffAppraisalListHODLecturerApproved($department_id, $appraisal_year, $fieldname) {
		try {
			$sql = "SELECT COUNT(id) as approved FROM appraisal_lecturer WHERE department_id = $department_id AND appraisal_year = '$appraisal_year' AND current_sequence >= 2";
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			$this->totalCount = $stmt->rowCount();
			if($stmt->rowCount() != 0) {
				return $result[$fieldname];
			} else {
				return "No data.";
			}
		} catch(PDOException $e) {
			throw new Exception($e->getMessage());
		}	
	}
	public function countMyStaffAppraisalListHODAdminApproved($department_id, $appraisal_year, $fieldname) {
		try {
			$sql = "SELECT COUNT(id) as approved FROM appraisal_admin WHERE department_id = $department_id AND appraisal_year = '$appraisal_year' AND current_sequence >= 2";
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			$this->totalCount = $stmt->rowCount();
			if($stmt->rowCount() != 0) {
				return $result[$fieldname];
			} else {
				return "No data.";
			}
		} catch(PDOException $e) {
			throw new Exception($e->getMessage());
		}	
	}
	public function countMyStaffAppraisalListHODHOSApproved($department_id, $appraisal_year, $fieldname) {
		try {
			$sql = "SELECT COUNT(id) as approved FROM appraisal_hos WHERE department_id = $department_id AND appraisal_year = '$appraisal_year' AND current_sequence >= 2";
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			$this->totalCount = $stmt->rowCount();
			if($stmt->rowCount() != 0) {
				return $result[$fieldname];
			} else {
				return "No data.";
			}
		} catch(PDOException $e) {
			throw new Exception($e->getMessage());
		}	
	}
	public function countMyStaffAppraisalListHODHOCApproved($department_id, $appraisal_year, $fieldname) {
		try {
			$sql = "SELECT COUNT(id) as approved FROM appraisal_hod WHERE department_id = $department_id AND appraisal_year = '$appraisal_year' AND current_sequence >= 2";
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			$this->totalCount = $stmt->rowCount();
			if($stmt->rowCount() != 0) {
				return $result[$fieldname];
			} else {
				return "No data.";
			}
		} catch(PDOException $e) {
			throw new Exception($e->getMessage());
		}	
	}

	public function countAppraisals($table_name, $appraisal_year, $fieldname) {
		try {
			$sql = "SELECT COUNT(id) as total FROM $table_name WHERE appraisal_year = '$appraisal_year'";
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			$this->totalCount = $stmt->rowCount();
			if($stmt->rowCount() != 0) {
				return $result[$fieldname];
			} else {
				return "No data.";
			}
		} catch(PDOException $e) {
			throw new Exception($e->getMessage());
		}	
	}

	public function countTrainings($appraisal_year, $fieldname) {
		try {
			$sql = "SELECT COUNT(id) as total FROM appraisal_trainings WHERE appraisal_year = '$appraisal_year'";
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			$this->totalCount = $stmt->rowCount();
			if($stmt->rowCount() != 0) {
				return $result[$fieldname];
			} else {
				return "No data.";
			}
		} catch(PDOException $e) {
			throw new Exception($e->getMessage());
		}	
	}

	public function appraisalHOSStatus($appraisal_year, $staff_id, $fieldname) {
		try {
			$sql = "SELECT * FROM appraisal_hos WHERE staff_id = '$staff_id' AND appraisal_year = '$appraisal_year'";
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			$this->totalCount = $stmt->rowCount();
			if($stmt->rowCount() != 0) {
				return $result[$fieldname];
			} else {
				return "No data.";
			}
		} catch(PDOException $e) {
			throw new Exception($e->getMessage());
		}	
	}

	public function appraisalHODStatus($appraisal_year, $staff_id, $fieldname) {
		try {
			$sql = "SELECT * FROM appraisal_hod WHERE staff_id = '$staff_id' AND appraisal_year = '$appraisal_year'";
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			$this->totalCount = $stmt->rowCount();
			if($stmt->rowCount() != 0) {
				return $result[$fieldname];
			} else {
				return "No data.";
			}
		} catch(PDOException $e) {
			throw new Exception($e->getMessage());
		}	
	}

	public function appraisalGetCompletedDate($table_name, $appraisal_type_id, $staff_id, $fieldname) {
		try {
			$sql = "SELECT * FROM $table_name WHERE appraisal_type_id = $appraisal_type_id AND staff_id = $staff_id";
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			$this->totalCount = $stmt->rowCount();
			if($stmt->rowCount() != 0) {
				return $result[$fieldname];
			} else {
				return "No data.";
			}
		} catch(PDOException $e) {
			throw new Exception($e->getMessage());
		}	
	}

	public function appraisalGetCompletedDate2($table_name, $appraisal_type_id, $staff_id, $fieldname) {
		try {
			$sql = "SELECT * FROM $table_name WHERE appraisal_id = $appraisal_type_id AND staff_id = $staff_id";
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			$this->totalCount = $stmt->rowCount();
			if($stmt->rowCount() != 0) {
				return $result[$fieldname];
			} else {
				return "No data.";
			}
		} catch(PDOException $e) {
			throw new Exception($e->getMessage());
		}	
	}
	


	// Staff Appraisal Functions Ends Here...


	



	 

	// public function getSubmittedSectionTech($department_id, $section_id, $appraisal_year, $fieldname) {
	// 	try {
	// 		$sql = "SELECT count(at.staff_id) as ctr FROM appraisal_technician as at LEFT OUTER JOIN employmentdetail as e ON e.staff_id = at.staff_id WHERE e.department_id = 5 AND e.section_id = 2 AND e.isCurrent = 1 AND e.status_id = 1 AND at.appraisal_year = '$appraisal_year'";
	// 		$stmt = $this->connect()->prepare($sql);
	// 		$stmt->execute();
	// 		$result = $stmt->fetch(PDO::FETCH_ASSOC);
	// 		$this->totalCount = $stmt->rowCount();
	// 		if($stmt->rowCount() != 0) {
	// 			return $result[$fieldname];
	// 		} else {
	// 			return "No data.";
	// 		}
	// 	} catch(PDOException $e) {
	// 		throw new Exception($e->getMessage());
	// 	}	
	// }

	// public function getSubmittedDepartment($department_id, $appraisal_year, $fieldname) {
	// 	try {
	// 		$sql = "SELECT count(at.staff_id) as ctr FROM appraisal_technician as at LEFT OUTER JOIN employmentdetail as e ON e.staff_id = at.staff_id WHERE e.department_id = 5 AND e.isCurrent = 1 AND e.status_id = 1 AND at.appraisal_year = '$appraisal_year'";
	// 		$stmt = $this->connect()->prepare($sql);
	// 		$stmt->execute();
	// 		$result = $stmt->fetch(PDO::FETCH_ASSOC);
	// 		$this->totalCount = $stmt->rowCount();
	// 		if($stmt->rowCount() != 0) {
	// 			return $result[$fieldname];
	// 		} else {
	// 			return "No data.";
	// 		}
	// 	} catch(PDOException $e) {
	// 		throw new Exception($e->getMessage());
	// 	}	
	// }

	 

	public function countTechAppraisal($appraisal_year, $fieldname) {
		try {
			$sql = "SELECT count(*) as ctr FROM appraisal_technician WHERE appraisal_year = '$appraisal_year'";
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			$this->totalCount = $stmt->rowCount();
			if($stmt->rowCount() != 0) {
				return $result[$fieldname];
			} else {
				return "No data.";
			}
		} catch(PDOException $e) {
			throw new Exception($e->getMessage());
		}	
	}

	public function countTrainingPerDept($department_id, $appraisal_year, $fieldname) {
		try {
			$sql = "SELECT count(t.id) as ctr  FROM appraisal_trainings as t LEFT OUTER JOIN employmentdetail as e ON e.staff_id = t.staff_id WHERE e.department_id = $department_id AND appraisal_year = '$appraisal_year'";
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			$this->totalCount = $stmt->rowCount();
			if($stmt->rowCount() != 0) {
				return $result[$fieldname];
			} else {
				return "No data.";
			}
		} catch(PDOException $e) {
			throw new Exception($e->getMessage());
		}	
	}

	 

	public function countReasonForLeaving($fieldname1,$fieldname) {
		try {
			$sql = "SELECT count(".$fieldname1.") as ctr FROM exit_interview_final WHERE ".$fieldname1." = 1";
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			$this->totalCount = $stmt->rowCount();
			if($stmt->rowCount() != 0) {
				return $result[$fieldname];
			} else {
				return "0";
			}
		} catch(PDOException $e) {
			throw new Exception($e->getMessage());
		}	
	}
	public function countReasonForLeavingByStaff($fieldname1,$staff_id,$fieldname) {
		try {
			$sql = "SELECT count(".$fieldname1.") as ctr FROM exit_interview_final WHERE ".$fieldname1." = 1 AND staffId = '$staff_id'";
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			$this->totalCount = $stmt->rowCount();
			if($stmt->rowCount() != 0) {
				return $result[$fieldname];
			} else {
				return "0";
			}
		} catch(PDOException $e) {
			throw new Exception($e->getMessage());
		}	
	}
	public function countReasonForLeavingByDate($fieldname1,$to,$from,$fieldname) {
		try {
			$sql = "SELECT count(".$fieldname1.") as ctr FROM exit_interview_final WHERE ".$fieldname1." = 1 AND dateSubmitted >= '$to' AND dateSubmitted <= '$from'";
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			$this->totalCount = $stmt->rowCount();
			if($stmt->rowCount() != 0) {
				return $result[$fieldname];
			} else {
				return "0";
			}
		} catch(PDOException $e) {
			throw new Exception($e->getMessage());
		}	
	}
	 
	public function countDisSatisfactionByStaff($fieldname1,$staff_id,$fieldname) {
		try {
			$sql = "SELECT count(".$fieldname1.") as ctr2 FROM exit_interview_final WHERE ".$fieldname1." = 1 AND staffId = '$staff_id'";
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			$this->totalCount = $stmt->rowCount();
			if($stmt->rowCount() != 0) {
				return $result[$fieldname];
			} else {
				return "0";
			}
		} catch(PDOException $e) {
			throw new Exception($e->getMessage());
		}	
	}
	public function countDisSatisfactionByDate($fieldname1,$to,$from,$fieldname) {
		try {
			$sql = "SELECT count(".$fieldname1.") as ctr2 FROM exit_interview_final WHERE ".$fieldname1." = 1 AND dateSubmitted >= '$to' AND dateSubmitted <= '$from'";
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			$this->totalCount = $stmt->rowCount();
			if($stmt->rowCount() != 0) {
				return $result[$fieldname];
			} else {
				return "0";
			}
		} catch(PDOException $e) {
			throw new Exception($e->getMessage());
		}	
	}
	public function countOpinionToCollege($fieldname1,$val,$fieldname) {
		try {
			$sql = "SELECT count(".$fieldname1.") as ctrOpinionCollege FROM exit_interview_final WHERE ".$fieldname1." = $val";
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			$this->totalCount = $stmt->rowCount();
			if($stmt->rowCount() != 0) {
				return $result[$fieldname];
			} else {
				return "0";
			}
		} catch(PDOException $e) {
			throw new Exception($e->getMessage());
		}	
	}
	public function countOpinionToCollegeByStaff($fieldname1,$val,$staff_id,$fieldname) {
		try {
			$sql = "SELECT count(".$fieldname1.") as ctrOpinionCollege FROM exit_interview_final WHERE ".$fieldname1." = $val AND staffId = '$staff_id'";
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			$this->totalCount = $stmt->rowCount();
			if($stmt->rowCount() != 0) {
				return $result[$fieldname];
			} else {
				return "0";
			}
		} catch(PDOException $e) {
			throw new Exception($e->getMessage());
		}	
	}
	public function countOpinionToCollegeByDate($fieldname1,$val,$to,$from,$fieldname) {
		try {
			$sql = "SELECT count(".$fieldname1.") as ctrOpinionCollege FROM exit_interview_final WHERE ".$fieldname1." = $val AND dateSubmitted >= '$to' AND dateSubmitted <= '$from'";
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			$this->totalCount = $stmt->rowCount();
			if($stmt->rowCount() != 0) {
				return $result[$fieldname];
			} else {
				return "0";
			}
		} catch(PDOException $e) {
			throw new Exception($e->getMessage());
		}	
	}
	 
	public function countOpinionToSupervisorByStaff($fieldname1,$val,$staff_id,$fieldname) {
		try {
			$sql = "SELECT count(".$fieldname1.") as ctrOpinionSupervisor FROM exit_interview_final WHERE ".$fieldname1." = $val AND staffId = '$staff_id'";
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			$this->totalCount = $stmt->rowCount();
			if($stmt->rowCount() != 0) {
				return $result[$fieldname];
			} else {
				return "0";
			}
		} catch(PDOException $e) {
			throw new Exception($e->getMessage());
		}	
	}
	public function countOpinionToSupervisorByDate($fieldname1,$val,$to,$from,$fieldname) {
		try {
			$sql = "SELECT count(".$fieldname1.") as ctrOpinionSupervisor FROM exit_interview_final WHERE ".$fieldname1." = $val AND dateSubmitted >= '$to' AND dateSubmitted <= '$from'";
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			$this->totalCount = $stmt->rowCount();
			if($stmt->rowCount() != 0) {
				return $result[$fieldname];
			} else {
				return "0";
			}
		} catch(PDOException $e) {
			throw new Exception($e->getMessage());
		}	
	}
	public function countOpinionToJob($fieldname1,$val,$fieldname) {
		try {
			$sql = "SELECT count(".$fieldname1.") as ctrOpinionJob FROM exit_interview_final WHERE ".$fieldname1." = $val";
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			$this->totalCount = $stmt->rowCount();
			if($stmt->rowCount() != 0) {
				return $result[$fieldname];
			} else {
				return "0";
			}
		} catch(PDOException $e) {
			throw new Exception($e->getMessage());
		}	
	}
	public function countOpinionToJobByStaff($fieldname1,$val,$staff_id,$fieldname) {
		try {
			$sql = "SELECT count(".$fieldname1.") as ctrOpinionJob FROM exit_interview_final WHERE ".$fieldname1." = $val AND staffId = '$staff_id'";
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			$this->totalCount = $stmt->rowCount();
			if($stmt->rowCount() != 0) {
				return $result[$fieldname];
			} else {
				return "0";
			}
		} catch(PDOException $e) {
			throw new Exception($e->getMessage());
		}	
	}
	public function countOpinionToJobByDate($fieldname1,$val,$to,$from,$fieldname) {
		try {
			$sql = "SELECT count(".$fieldname1.") as ctrOpinionJob FROM exit_interview_final WHERE ".$fieldname1." = $val AND dateSubmitted >= '$to' AND dateSubmitted <= '$from'";
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			$this->totalCount = $stmt->rowCount();
			if($stmt->rowCount() != 0) {
				return $result[$fieldname];
			} else {
				return "0";
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
		define('GPWD', 'mvps icra cbsb wkmv'); // GMail password
	    global $error;
	    $mail = new PHPMailer();  // create a new object
	    $mail->IsSMTP(); // enable SMTP
	    $mail->SMTPDebug = 1;  // debugging: 1 = errors and messages, 2 = messages only
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