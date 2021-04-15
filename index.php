<?php
$servername = "localhost";
$username = "id9993574_akshaybmnmd";
$password = "akshaybmn";
$dbname = "id9993574_accumulate";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM `camrent` WHERE `unb` = '0'";

$result = $conn->query($sql);
$dates = '"2-2-2020"';

if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {
        if ($row['duration'] > 1) {
            $x = 1;
            $tempday = $row['bookeddate'];
            while ($x < $row['duration']) {
                $date = date_create($tempday);
                date_add($date, date_interval_create_from_date_string("1 days"));
                $dates = $dates . ',"' . date_format($date, "j-n-Y") . '"';
                $tempday = date_format($date, "j-n-Y");
                $x++;
            }
        }
        $dates = $dates . ',"' . $row['bookeddate'] . '"';
    }
} else {
}
$conn->close();
?>

<html>

<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</head>

<body>
    <form name="myForm" action="./action_page.php" method="POST" enctype='multipart/form-data'>
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" name="name" required size="30">
        </div>
        <div class="form-group">
            <label for="phone">Phone Number:</label>
            <input type="tel" class="form-control" name="phone" pattern="[0-9]{10}" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" name="email">
        </div>
        <div class="form-group">
            <label for="address">Address:</label>
            <textarea class="form-control" name="address" required></textarea>
        </div>
        <div class="form-group">
            <label for="bookeddate">Date:</label>
            <input type="text" id="date" class="form-control" name="bookeddate" readonly required />
        </div>
        <div class="form-group">
            <label for="duration">Duration:</label>
            <input type="number" id='durtn' class="form-control" name="duration" max='9' min='1' value="1" pattern="[0-9]{1}" required />
        </div>
        <div class="form-group">
            <label for="date">Camera:</label>
            <select class="form-control" name="camera" value='250' readonly required>
                <option value="250" id='cam' selected='true'>Canon 1500D</option>
            </select>
        </div>
        <div class="form-group">
            <label for="kitlens"> Kit lens (18-50mm)</label>
            <input type="checkbox" id='a' name="kitlens" value="100" checked><br>
            <label for="zoomlens">Zoom lens (55 - 250mm)</label>
            <input type="checkbox" id='b' name="zoomlens" value="150"><br>
            <label for="primelens"> Prime lens (50mm)</label>
            <input type="checkbox" id='c' name="primelens" value="150">
        </div>
        <div class="form-group">
            <label for="myfile">Upload a ID proof:</label>
            <input type="file" class="form-control" name="file[]" id="file" multiple>
            <!-- <input type="file" id="myfile" class="form-control" name="myfile"> -->
        </div>
        <input type="submit" class="btn btn-default" value="Submit">
    </form>
    <div id='amound'>Call Me at +91 8943705571</div>
    <script type="text/javascript">
        var unavailableDates = [<?php echo $dates; ?>];

        function available(date) {
            dmy = date.getDate() + "-" + (date.getMonth() + 1) + "-" + date.getFullYear();
            var d = new Date();
            if ((date.getDate() <= d.getDate() && date.getMonth() == d.getMonth()) || (date.getMonth() < d.getMonth() && date.getFullYear() == d.getFullYear()) || (date.getFullYear() < d.getFullYear())) {
                return [false, "", "unAvailable"];
            }
            if ($.inArray(dmy, unavailableDates) !== -1) {
                return [false, "", "unAvailable"];
            } else {
                return [true, "", "Available"];
            }
        }
        $(function() {
            $('#date').datepicker({
                beforeShowDay: available,
                autoSize: true,
                dateFormat: "dd-m-yy"
            });
        })
    </script>
</body>

</html>