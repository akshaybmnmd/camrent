<?php
if (!isset($_REQUEST['action'])) {
    die();
}
require '../config.php';
$where = '';

@$id = $_REQUEST['id'];

switch ($_REQUEST['action']) {
    case 'admin':
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
        break;
    case 'fulltable':
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
        break;
    case 'booking':
        $columns = array(
            array('db' => 'id', 'dt' => 0),
            array('db' => 'name',  'dt' => 1),
            array('db' => 'phone', 'dt' => 2),
            array('db' => 'email', 'dt' => 3),
            array('db' => 'address', 'dt' => 4),
            array('db' => 'bookeddate', 'dt' => 5),
            array('db' => 'duration',  'dt' => 6),
            array('db' => 'kitlens', 'dt' => 7),
            array('db' => 'zoomlens', 'dt' => 8),
            array('db' => 'primelens', 'dt' => 9),
            array('db' => 'camera', 'dt' => 10),
            array('db' => 'rent', 'dt' => 11),
            array('db' => 'paid', 'dt' => 12),
            array('db' => 'addedcost', 'dt' => 13),
            array('db' => 'Damagecost',  'dt' => 14),
            array('db' => 'totalamound', 'dt' => 15),
            array('db' => 'remaining', 'dt' => 16),
            array('db' => 'unb', 'dt' => 17)
        );
        $where = "id ='$id'";
        break;
    default:
        die();
        break;
}

// Table's primary key
$primaryKey = 'id';

// SQL server connection information
$sql_details = array(
    'user' => username,
    'pass' => password,
    'db'   => dbname,
    'host' => servername
);

require('ssp.class.php');

echo json_encode(
    SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, $where)
);
