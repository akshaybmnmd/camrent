<?php

require '../config.php';

session_start();
if (!$_SESSION['login']) {
    header("Location: login.php?error=true");
    die();
}

// Create connection
$conn = new mysqli(servername, username, password, dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM `$table` WHERE `unb` = '0'";

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
    <script>
        var unavailableDates = [<?php echo $dates; ?>];
    </script>
</head>

<body>
    <!-- Update payment Modal -->
    <div id="myPaymentModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 id='modelHeading' class="modal-title">Modal 1 Header</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="rent">Rent:</label>
                        <input type="number" class="form-control" id="rent" size="30" readonly>
                    </div>
                    <div class="form-group">
                        <label for="paid">Paid:</label>
                        <input type="number" class="form-control" onChange='paymentChange()' id="paid" size="30">
                    </div>
                    <div class="form-group">
                        <label for="addedcost">Added Cost:</label>
                        <input type="number" class="form-control" onChange='paymentChange()' id="addedcost" size="30">
                    </div>
                    <div class="form-group">
                        <label for="Damegecost">Damega Cost:</label>
                        <input type="number" class="form-control" onChange='paymentChange()' id="Damegecost" size="30">
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
                    <button type="button" class="btn btn-default" data-dismiss="modal" onClick="updatepayment()">Submit</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>

    <!-- Edit Modal -->
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 id='model2Heading' class="modal-title">Modal 2 Header</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="return"> Returned</label>
                        <input type="checkbox" id="return2" value="100"><br>
                    </div>
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" class="form-control" id="name2" size="30">
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone Number:</label>
                        <input type="tel" class="form-control" id="phone2" pattern="[0-9]{11}">
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" id="email2">
                    </div>
                    <div class="form-group">
                        <label for="address">Address:</label>
                        <textarea class="form-control" id="address2"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="bookeddate">Date:</label>
                        <input type="text" id='formdate2' class="form-control" />
                    </div>
                    <div class="form-group">
                        <label for="duration">Duration:</label>
                        <input type="number" class="form-control" id="duration2" max='9' min='1' value="1" pattern="[0-9]{1}" />
                    </div>
                    <div class="form-group">
                        <label for="date">Camera:</label>
                        <select class="form-control" id="camera2" value='250'>
                            <option value="250" id='cam' selected='true'>Canon 1500D</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="kitlens"> Kit lens (18-50mm)</label>
                        <input type="checkbox" id="kitlens2" value="100" checked><br>
                        <label for="zoomlens">Zoom lens (55 - 250mm)</label>
                        <input type="checkbox" id="zoomlens2" value="150"><br>
                        <label for="primelens"> Prime lens (50mm)</label>
                        <input type="checkbox" id="primelens2" value="150">
                    </div>
                    <div class="form-group">
                        <label for="rent">Rent:</label>
                        <input type="number" class="form-control" id="rent2" size="30">
                    </div>
                    <div class="form-group">
                        <label for="paid">Paid:</label>
                        <input type="number" class="form-control" id="paid2" size="30">
                    </div>
                    <div class="form-group">
                        <label for="addedcost">Added Cost:</label>
                        <input type="number" class="form-control" id="addedcost2" size="30">
                    </div>
                    <div class="form-group">
                        <label for="Damegecost">Damega Cost:</label>
                        <input type="number" class="form-control" id="Damegecost2" size="30">
                    </div>
                    <div class="form-group">
                        <label for="totalamount">Total Amount:</label>
                        <input type="number" class="form-control" id="totalamount2" size="30">
                    </div>
                    <div class="form-group">
                        <label for="remaining">Remaining:</label>
                        <input type="number" class="form-control" id="remaining2" size="30">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" onClick="update()">Update</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal" onClick="deleterow()">Delete</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>
    <!-- Edit Rent Modal 3 -->
    <div id="myAmountModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 id='model3Heading' class="modal-title">Modal 3 Header</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="duration">Duration:</label>
                        <input type="number" class="form-control" id="duration3" max='9' min='1' value="1" pattern="[0-9]{1}" onChange='rentChange()' />
                    </div>
                    <div class="form-group">
                        <label for="date">Camera:</label>
                        <select class="form-control" id="camera3" value='250' onChange='rentChange()'>
                            <option value="250" id='cam' selected='true'>Canon 1500D</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="kitlens"> Kit lens (18-50mm)</label>
                        <input type="checkbox" id="kitlens3" value="100" checked onChange='rentChange()'><br>
                        <label for="zoomlens">Zoom lens (55 - 250mm)</label>
                        <input type="checkbox" id="zoomlens3" value="150" onChange='rentChange()'><br>
                        <label for="primelens"> Prime lens (50mm)</label>
                        <input type="checkbox" id="primelens3" value="150" onChange='rentChange()'>
                    </div>
                    <div class="form-group">
                        <label for="rent">Rent:</label>
                        <input type="number" class="form-control" id="rent3" size="30" readonly>
                    </div>
                    <div class="form-group">
                        <label for="paid">Paid:</label>
                        <input type="number" class="form-control" id="paid3" size="30" readonly>
                    </div>
                    <div class="form-group">
                        <label for="addedcost">Added Cost:</label>
                        <input type="number" class="form-control" onChange='rentChange()' id="addedcost3" size="30">
                    </div>
                    <div class="form-group">
                        <label for="Damegecost">Damega Cost:</label>
                        <input type="number" class="form-control" onChange='rentChange()' id="Damegecost3" size="30">
                    </div>
                    <div class="form-group">
                        <label for="totalamount">Total Amount:</label>
                        <input type="number" class="form-control" id="totalamount3" size="30" readonly>
                    </div>
                    <div class="form-group">
                        <label for="remaining">Remaining:</label>
                        <input type="number" class="form-control" id="remaining3" size="30" readonly>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" onClick="updaterent()">Submit</button>
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
                <th>Total Amount</th>
                <th>Remaining</th>
                <th></th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
    <script src="../js/adminindex.js"></script>
</body>

</html>