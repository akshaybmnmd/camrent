<?php

require './config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    phpinfo();
    exit("Only handles POST requests");
}
// print_r($_FILES);
// print_r($_REQUEST);

echo '<script>console.log("Got POST")</script>';
// Count total files
$countfiles = count($_FILES['file']['name']);
// Looping all files
for ($i = 0; $i < $countfiles; $i++) {
    $filename = $_FILES['file']['name'][$i];

    // Upload file
    if (move_uploaded_file($_FILES['file']['tmp_name'][$i], 'files/' . $filename)) {
        echo '<script>console.log("' . $filename . '")</script>';
        $Proofs = $Proofs . '<a href="https://dataaccesspoint.000webhostapp.com/camrent/files/' . $filename . '" target="_blank">image_' . $i . '</a><br>';
    } else {
        echo '<script>console.log("Error!")</script>';
    }
}

$name = $_REQUEST['name'];
$phone = $_REQUEST['phone'];
$email = $_REQUEST['email'];
$address = $_REQUEST['address'];
$bookeddate = $_REQUEST['bookeddate'];
$duration = $_REQUEST['duration'];
$startday = $_REQUEST['startday'] ? $_REQUEST['startday'] : 0;
$endday = $_REQUEST['endday'] ? $_REQUEST['endday'] : 0;
$kitlens = $_REQUEST['kitlens'] ? $_REQUEST['kitlens'] : 0;
$zoomlens = $_REQUEST['zoomlens'] ? $_REQUEST['zoomlens'] : 0;
$primelens = $_REQUEST['primelens'] ? $_REQUEST['primelens'] : 0;
$camera = $_REQUEST['camera'] ? $_REQUEST['camera'] : 250;
$rent = ($kitlens + $zoomlens + $primelens + $camera) * $duration;
$paid = 0;
$addedcost = 0;
$Damagecost = 0;
$totalamound = $rent + $addedcost + $Damagecost;
$remaining = $rent;

$ip = $_SERVER['REMOTE_ADDR'];

// Create connection
$conn = new mysqli(servername, username, password, dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "INSERT INTO `$table` (`name`, `phone`, `email`, `address`, `bookeddate`, `duration`, `startday`, `endday`, `kitlens`, `zoomlens`, `primelens`, `camera`, `rent`, `paid`, `addedcost`, `Damagecost`, `totalamound`, `remaining`, `Proofs`, `una`, `unb`, `unc`, `und`) 
VALUES ('$name', '$phone', '$email', '$address', '$bookeddate', '$duration', '$startday', '$endday', '$kitlens', '$zoomlens', '$primelens', '$camera', '$rent', '$paid', $addedcost, '$Damagecost', '$totalamound', '$remaining', '$Proofs', '$ip', '0', NULL, NULL)";

if ($conn->query($sql) === TRUE) {
    $id = $conn->insert_id;
    exit("Your booking has been placed for $bookeddate upto $duration days with a rent of $totalamound. Your booking ID is $id.<br> Contact with Akshay to confirm your booking.<br><br> Contact:- +91 8943705571<br><br><a href='http://camrent.akshays.space/camrent/'>Book Another One</a><br><br><a href='http://camrent.akshays.space/camrent/verify.php?id=$id'>Verify your booking</a>");
} else {
    exit("Something went wrong, Contact Akshay -> +91 8943705571");
}
$conn->close();
header('Location: http://camrent.akshays.space/camrent/');
