<?php

require '../config.php';

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

// Table's primary key
$primaryKey = 'id';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
    array('db' => 'id', 'dt' => 0),
    array('db' => 'name',  'dt' => 1),
    array('db' => 'phone', 'dt' => 2),
    array('db' => 'email', 'dt' => 3),
    array('db' => 'address', 'dt' => 4),
    array('db' => 'bookingdate', 'dt' => 5),
    array('db' => 'bookeddate', 'dt' => 6),
    array('db' => 'duration',  'dt' => 7),
    array('db' => 'startday', 'dt' => 8),
    array('db' => 'endday', 'dt' => 9),
    array('db' => 'kitlens', 'dt' => 10),
    array('db' => 'zoomlens', 'dt' => 11),
    array('db' => 'primelens', 'dt' => 12),
    array('db' => 'camera', 'dt' => 13),
    array('db' => 'rent', 'dt' => 14),
    array('db' => 'paid', 'dt' => 15),
    array('db' => 'addedcost', 'dt' => 16),
    array('db' => 'Damagecost',  'dt' => 17),
    array('db' => 'totalamound', 'dt' => 18),
    array('db' => 'remaining', 'dt' => 19),
    array('db' => 'Proofs', 'dt' => 20),
    array('db' => 'una',  'dt' => 21),
    array('db' => 'unb', 'dt' => 22)
);

// SQL server connection information
$sql_details = array(
    'user' => username,
    'pass' => password,
    'db'   => dbname,
    'host' => servername
);

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * If you just want to use the basic configuration for DataTables with PHP
 * server-side, there is no need to edit below this line.
 */

require('ssp.class.php');

echo json_encode(
    SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns)
);
