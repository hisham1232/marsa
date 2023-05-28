<?php
ini_set("display_errors", 1); error_reporting(E_ALL);
/*
 * DataTables example server-side processing script.
 *
 * Please note that this script is intentionally extremely simple to show how
 * server-side processing can be implemented, and probably shouldn't be used as
 * the basis for a large complex system. It is suitable for simple use cases as
 * for learning.
 *
 * See http://datatables.net/usage/server-side for full details on the server-
 * side processing requirements of DataTables.
 *
 * @license MIT - http://datatables.net/license_mit
 */
 
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Easy set variables
 */
// DB table to use
$table = 'v_standardleave';
// Table's primary key
$primaryKey = 'id';
 
// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
    array(
        'db'        => 'requestNo',
        'dt'        => 0,
        'formatter' => function( $d, $row ) {
            return "<a href='standardleave_details.php?id=$d&uid=$row[1]'>".$d."</a>";
        }
    ),
    array( 'db' => 'staff_id',  'dt' => 1 ),
    array( 'db' => 'staffName',   'dt' => 2 ),
    array( 'db' => 'department',     'dt' => 3 ),
    array( 'db' => 'section',     'dt' => 4 ),
    array( 'db' => 'sponsor',     'dt' => 5 ),
    array( 'db' => 'leave_type',     'dt' => 6 ),
    array( 'db' => 'dateFiled',     'dt' => 7 ),
    array( 'db' => 'startDate',     'dt' => 8 ),
    array( 'db' => 'startDate',     'dt' => 9 ),
    array( 'db' => 'total',     'dt' => 10 ),
    array( 'db' => 'currentStatus',     'dt' => 11 )
);
 
// SQL server connection information
$sql_details = array(
    'user' => 'p09a05',
    'pass' => '15935789',
    'db'   => 'dbhr3_test',
    'host' => 'localhost'
);
require('ssp.class.php');
 
echo json_encode(
    SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
);