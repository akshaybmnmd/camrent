<?php

require '../config.php';

// Table's primary key
$primaryKey = 'id';

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

require('ssp.class.php');

echo json_encode(
    SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns)
);
