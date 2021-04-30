<?php
require './config.php';
if (!isset($_REQUEST['id']) && !isset($_REQUEST['number'])) {
    header("Location: index.php");
}
// Create connection
$conn = new mysqli(servername, username, password, dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$id = $_REQUEST['id'];
$number = $_REQUEST['number'];

$sql = "SELECT * FROM `$table` WHERE `id` = '$id'";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {
        if ($row['phone'] != $number) {
            $phone = $row['phone'];
            header("Location: index.php?err=number");
        }
    }
} else {
    header("Location: index.php?err=id");
}
$conn->close();
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
    <!-- Duration model -->
    <div id="durationmodel" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 id='model3Heading' class="modal-title">Add more Days</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label id='durtn' for="phone">Additional Days:</label>
                        <input type="number" class="form-control" id="duration" onChange='durationChange()' required>
                    </div>
                    <div class="form-group">
                        <label for="rent">Rent:</label>
                        <input type="number" class="form-control" id="rent" size="30" readonly>
                    </div>
                    <div class="form-group">
                        <label for="paid">Paid:</label>
                        <input type="number" class="form-control" id="paid" size="30" readonly>
                    </div>
                    <div class="form-group">
                        <label for="addedcost">Added Cost:</label>
                        <input type="number" class="form-control" id="addedcost" size="30" readonly>
                    </div>
                    <div class="form-group">
                        <label for="Damegecost">Damage Cost:</label>
                        <input type="number" class="form-control" id="Damegecost" size="30" readonly>
                    </div>
                    <div class="form-group">
                        <label for="totalamount">Total Amount:</label>
                        <input type="number" class="form-control" id="totalamount" size="30" readonly>
                    </div>
                    <div class="form-group">
                        <label for="remaining">Remaining:</label>
                        <input type="number" class="form-control" id="remaining" size="30" readonly>
                    </div>
                </div>
                <div class="modal-footer">
                    <span>Call Me at +91 8606815571</span>
                    <button type="button" class="btn btn-default" data-dismiss="modal" onClick='addDuration()'>Add</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <table id="table_id" class="display">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Address</th>
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
                <th>Total Amount</th>
                <th>Remaining</th>
                <th></th>
            </tr>
        </thead>
        <tbody></tbody>
        <tfoot>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </tfoot>
    </table>
    <script src="./js/booking.js"> </script>
</body>

</html>