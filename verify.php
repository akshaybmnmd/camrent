<?php

require './config.php';

$id = $_REQUEST['id'];
$found = 'false';

// Create connection
$conn = new mysqli(servername, username, password, dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM `$table` WHERE `id` = '$id'";

$result = $conn->query($sql);
$dates = '"2-2-2020"';

if ($result->num_rows > 0) {
    $found = true;
    // output data of each row
    while ($row = $result->fetch_assoc()) {
        $name = $row['name'];
    }
} else {
    $found = 'false';
}
$conn->close();
?>

<html>

<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>
    <div id='reponse'></div>
    <script>
        var verified = <?php echo $found; ?>;
        if (verified) {
            $('#reponse')[0].innerHTML = "System was able to Verify you as <?php echo $name; ?>. You still need to contact Akshay to verify your ID proof. <br><br> Contact:- +91 8943705571";
        } else {
            $('#reponse')[0].innerHTML = "System wasn't able to Verify your id <?php echo $id; ?>. Contact Akshay to verify your ID. <br><br> Contact:- +91 8943705571";
        }
    </script>
</body>

</html>