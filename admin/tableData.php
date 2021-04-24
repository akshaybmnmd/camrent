<?php

require '../config.php';

// Table's primary key
$primaryKey = 'id';

// indexes
$columns = array(
    array('db' => 'id', 'dt' => 0),
    array('db' => 'name',  'dt' => 1),
    array('db' => 'phone', 'dt' => 2),
    array('db' => 'bookeddate', 'dt' => 3),
    array('db' => 'duration',  'dt' => 4),
    array('db' => 'kitlens', 'dt' => 5),
    array('db' => 'zoomlens', 'dt' => 6),
    array('db' => 'primelens', 'dt' => 7),
    array('db' => 'camera', 'dt' => 8),
    array('db' => 'rent', 'dt' => 9),
    array('db' => 'paid', 'dt' => 10),
    array('db' => 'addedcost', 'dt' => 11),
    array('db' => 'Damagecost',  'dt' => 12),
    array('db' => 'totalamound', 'dt' => 13),
    array('db' => 'remaining', 'dt' => 14),
    array('db' => 'unb', 'dt' => "return")
);

// SQL server connection information
$sql_details = array(
    'user' => username,
    'pass' => password,
    'db'   => dbname,
    'host' => servername
);

require('ssp.class.php');

echo json_encode(
    SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns)
);
