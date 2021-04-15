<?php
// Turn off all error reporting
error_reporting(0);
header('Content-type: application/json');
require './config.php';
require_once('./responseBuilder.php');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    exit(json_encode(['error' => "Only handles POST requests"]));
}

//commom parameters
$action = $_REQUEST['action'];

// Database parameters
$id = $_REQUEST['id'];
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
$gotit = $_REQUEST['unb'];
$ip = $_SERVER['REMOTE_ADDR'];

$con = mysqli_connect(servername, username, password, dbname);
if (!$con) {
    die(json_encode(["error" => mysqli_connect_error()]));
}


switch ($action) {
    case 'insert':
        $sql = "INSERT INTO `$table` (`name`, `phone`, `email`, `address`, `bookeddate`, `duration`, `startday`, `endday`, `kitlens`, `zoomlens`, `primelens`, `camera`, `rent`, `paid`, `addedcost`, `Damagecost`, `totalamound`, `remaining`, `Proofs`, `una`, `unb`, `unc`, `und`) 
VALUES ('$name', '$phone', '$email', '$address', '$bookeddate', '$duration', '$startday', '$endday', '$kitlens', '$zoomlens', '$primelens', '$camera', '$rent', '$paid', $addedcost, '$Damagecost', '$totalamound', '$remaining', '$Proofs', '$ip', NULL, NULL, NULL)";
        insert($con, $sql);
        break;
    case 'getall':
        $sql = "SELECT * FROM `$table`";
        select($con, $sql);
        break;
    case 'getbyid':
        $sql = "SELECT * FROM `$table` WHERE `id` = $id";
        select($con, $sql);
        break;
    case 'update':
        $sql = "UPDATE `$table` SET `name` = '$name', `phone` = '$phone', `address` = '$address',  `bookeddate` = '$bookeddate', `duration` = '$duration', `startday` = '$startday', `endday` = '$endday', `kitlens` = '$kitlens', `zoomlens` = '$zoomlens', `primelens` = '$primelens', `camera` = '$camera', `rent` = '$rent', `paid` = '$paid', `addedcost` = '$addedcost', `Damagecost` = '$Damagecost', `totalamound` = '$totalamound', `remaining` = '$remaining', `Proofs` = '$Proofs', `unb` = '$gotit' WHERE `$table`.`id` = $id";
        update($con, $sql);
        break;
    case 'delete':
        $sql = "DELETE FROM `$table` WHERE `$table`.`id` = $id";
        delete($con, $sql);
        break;
    default:
        exit(json_encode([
            'status' => 'no defined action',
            'action' => "$action",
        ]));
}

function select($con, $sql)
{
    $query = mysqli_query($con, $sql);
    $response = responseBuilder($query);
    mysqli_close($con);
    exit($response);
}

function insert($con, $sql)
{
    $query = mysqli_query($con, $sql);
    if ($query) {
        echo json_encode([
            'status' => 'ok',
            'record_id' => "$query",
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'error' => mysqli_error($con),
        ]);
    }
    mysqli_close($con);
}

function update($con, $sql)
{
    $query = mysqli_query($con, $sql);
    if ($query) {
        echo json_encode([
            'status' => 'ok',
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'error' => mysqli_error($con),
        ]);
    }
    mysqli_close($con);
}

function delete($con, $sql)
{
    $query = mysqli_query($con, $sql);
    if ($query) {
        echo json_encode([
            'status' => 'ok',
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'error' => mysqli_error($con),
        ]);
    }
    mysqli_close($con);
}
