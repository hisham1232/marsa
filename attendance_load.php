<?php
    $staffId = $_GET['id'];
    $serverName = "apps1.nct.edu.om";
    $database = "dbhr3";
    $uid = 'appsuser';
    $pwd = 'wzYjj8!^Q_#Hm9GK';
    $connect = new PDO("sqlsrv:server=$serverName;Database=$database", $uid, $pwd);
    $data = array();
    $query = "SELECT * FROM v_attendance WHERE StaffId = '$staffId'";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $ctr = 0;
    foreach($result as $row) {
        $data[] = array(
        'id'      => ++$ctr,
        'title'   => '',
        'start'   => $row['Date'].' '.$row['TimeIn'],
        'end'     => $row['Date'].' '.$row['TimeOut']
        );
    }
    echo json_encode($data);
?>