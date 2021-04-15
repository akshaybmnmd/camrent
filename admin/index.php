<?php
session_start();
if (!$_SESSION['login']) {
    header("Location: login.php?error=true");
    die();
}
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
?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css" />
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
</head>

<body>
    <!-- Modal -->
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 id='modelHeading' class="modal-title">Modal Header</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" class="form-control" name="name" required size="30">
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone Number:</label>
                        <input type="tel" class="form-control" name="phone" pattern="[0-9]{11}" required>
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
                        <input type="text" class="form-control" name="bookeddate" readonly required />
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
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" onClick="edit('update')">Update</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal" onClick="edit('delete')">Delete</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>
    <button class="btn btn-default"><a href="./table.php">View Full table </a> </button>
    <button class="btn btn-default"><a href="../files/">Files </a> </button>
    <input type="text" id="date" class="form-control" name="bookeddate" readonly />
    <table id="table_id" class="display">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Phone</th>
                <th>Booked Date</th>
                <th>Duration</th>
                <th>Kit Lens</th>
                <th>Zoom Lens</th>
                <th>Prime Lens</th>
                <th>Camera</th>
                <th>Rent</th>
                <th>Paid</th>
                <th>Added Cost</th>
                <th>Damage Cost</th>
                <th>Total Ammound</th>
                <th>Remaining</th>
                <th></th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
    <script>
        $(document).ready(function() {
            $("#table_id").DataTable({
                processing: true,
                serverSide: true,
                ajax: "./tableData.php",
                "columnDefs": [{
                    // The `data` parameter refers to the data for the cell defined by the
                    // `data` option, which defaults to the column being worked with, in
                    // this case `data: 0`.
                    "render": function(data, type, row) {
                        return '<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal" onClick=edit(' + row[0] + ')>Edit</button>';
                    },
                    "targets": 15
                }]
            });
        });

        function edit(id) {
            console.log("id", id);
            $('#modelHeading')[0].innerHTML = id;
        }

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