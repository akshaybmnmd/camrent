<?php

require './config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    exit("Only handles POST requests");
}

//commom parameters
$action = $_REQUEST['action'];

// Database parameters
$name = $_REQUEST['name'];
$phone = $_REQUEST['phone'];
$email = $_REQUEST['email'];
$address = $_REQUEST['address'];
$bookeddate = $_REQUEST['bookeddate'];
$duration = $_REQUEST['duration'];
$startday = $_REQUEST['startday'];
$endday = $_REQUEST['endday'];
$kitlens = $_REQUEST['kitlens'];
$zoomlens = $_REQUEST['zoomlens'];
$primelens = $_REQUEST['primelens'];
$camera = $_REQUEST['camera'];
$rent = $_REQUEST['rent'];
$paid = $_REQUEST['paid'];
$addedcost = $_REQUEST['addedcost'];
$Damagecost = $_REQUEST['Damagecost'];
$totalamound = $_REQUEST['totalamound'];
$remaining = $_REQUEST['remaining'];
$Proofs = $_REQUEST['Proofs'];
$ip = $_SERVER['REMOTE_ADDR'];

// Create connection
$conn = new mysqli(servername, username, password, dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

switch ($action) {
    case 'insert':
        $sql = "INSERT INTO `$table` (`name`, `phone`, `email`, `address`, `bookeddate`, `duration`, `startday`, `endday`, `kitlens`, `zoomlens`, `primelens`, `camera`, `rent`, `paid`, `addedcost`, `Damagecost`, `totalamound`, `remaining`, `Proofs`, `una`, `unb`, `unc`, `und`) 
VALUES ('$name', '$phone', '$email', '$address', '$bookeddate', '$duration', '$startday', '$endday', '$kitlens', '$zoomlens', '$primelens', '$camera', '$rent', '$paid', $addedcost, '$Damagecost', '$totalamound', '$remaining', '$Proofs', '$ip', NULL, NULL, NULL)";
        break;
    case 'getall':
        $sql = "SELECT * FROM `camrent`";
        break;
    default:
        exit('Undefined action ' . $action);
}

if ($conn->query($sql) === TRUE) {
    echo "<br>\n New record created successfully.";
} else {
    echo "<br>\n Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();
