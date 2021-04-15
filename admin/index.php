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
</head>

<body>
    <!-- Modal 1 -->
    <div id="myPaymentModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 id='modelHeading' class="modal-title">Modal Header</h4>
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

    <!-- Modal 2 -->
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
                        <label for="return"> Returned</label>
                        <input type="checkbox" id="return" value="100"><br>
                    </div>
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" class="form-control" id="name" size="30">
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone Number:</label>
                        <input type="tel" class="form-control" id="phone" pattern="[0-9]{11}">
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" id="email">
                    </div>
                    <div class="form-group">
                        <label for="address">Address:</label>
                        <textarea class="form-control" id="address"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="bookeddate">Date:</label>
                        <input type="text" id='formdate' class="form-control" />
                    </div>
                    <div class="form-group">
                        <label for="duration">Duration:</label>
                        <input type="number" class="form-control" id="duration" max='9' min='1' value="1" pattern="[0-9]{1}" />
                    </div>
                    <div class="form-group">
                        <label for="date">Camera:</label>
                        <select class="form-control" id="camera" value='250'>
                            <option value="250" id='cam' selected='true'>Canon 1500D</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="kitlens"> Kit lens (18-50mm)</label>
                        <input type="checkbox" id="kitlens" value="100" checked><br>
                        <label for="zoomlens">Zoom lens (55 - 250mm)</label>
                        <input type="checkbox" id="zoomlens" value="150"><br>
                        <label for="primelens"> Prime lens (50mm)</label>
                        <input type="checkbox" id="primelens" value="150">
                    </div>
                    <div class="form-group">
                        <label for="rent">Rent:</label>
                        <input type="number" class="form-control" id="rent" size="30">
                    </div>
                    <div class="form-group">
                        <label for="paid">Paid:</label>
                        <input type="number" class="form-control" id="paid" size="30">
                    </div>
                    <div class="form-group">
                        <label for="addedcost">Added Cost:</label>
                        <input type="number" class="form-control" id="addedcost" size="30">
                    </div>
                    <div class="form-group">
                        <label for="Damegecost">Damega Cost:</label>
                        <input type="number" class="form-control" id="Damegecost" size="30">
                    </div>
                    <div class="form-group">
                        <label for="totalamount">Total Amount:</label>
                        <input type="number" class="form-control" id="totalamount" size="30">
                    </div>
                    <div class="form-group">
                        <label for="remaining">Remaining:</label>
                        <input type="number" class="form-control" id="remaining" size="30">
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
    <!-- Modal 3 -->
    <div id="myAmountModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 id='modelHeading' class="modal-title">Modal Header</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="duration">Duration:</label>
                        <input type="number" class="form-control" id="duration" max='9' min='1' value="1" pattern="[0-9]{1}" />
                    </div>
                    <div class="form-group">
                        <label for="date">Camera:</label>
                        <select class="form-control" id="camera" value='250'>
                            <option value="250" id='cam' selected='true'>Canon 1500D</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="kitlens"> Kit lens (18-50mm)</label>
                        <input type="checkbox" id="kitlens" value="100" checked><br>
                        <label for="zoomlens">Zoom lens (55 - 250mm)</label>
                        <input type="checkbox" id="zoomlens" value="150"><br>
                        <label for="primelens"> Prime lens (50mm)</label>
                        <input type="checkbox" id="primelens" value="150">
                    </div>
                    <div class="form-group">
                        <label for="rent">Rent:</label>
                        <input type="number" class="form-control" id="rent" size="30" readonly>
                    </div>
                    <div class="form-group">
                        <label for="paid">Paid:</label>
                        <input type="number" class="form-control" onChange='paymentChange()' id="paid" size="30" readonly>
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
    <script>
        var data = '';
        $(document).ready(function() {
            $("#table_id").DataTable({
                processing: true,
                serverSide: true,
                ajax: "./tableData.php",
                "columnDefs": [{
                    "render": function(data, type, row) {
                        return '<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myPaymentModal" onClick=editpayment(' + row[0] + ')>Update payment</button><button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal" onClick=edit(' + row[0] + ')>Edit</button>';
                    },
                    "targets": 15
                }]
            });
        });

        function paymentChange() {
            data[0].rent = $('#rent')[0].value;
            data[0].paid = $('#paid')[0].value;
            data[0].addedcost = $('#addedcost')[0].value;
            data[0].Damagecost = $('#Damegecost')[0].value;
            data[0].totalamound = parseInt(data[0].rent) + parseInt(data[0].addedcost) + parseInt(data[0].Damagecost);
            data[0].remaining = parseInt(data[0].totalamound) - parseInt(data[0].paid);
            $('#rent')[0].value = data[0].rent;
            $('#paid')[0].value = data[0].paid;
            $('#addedcost')[0].value = data[0].addedcost;
            $('#Damegecost')[0].value = data[0].Damagecost;
            $('#totalamount')[0].value = data[0].totalamound;
            $('#remaining')[0].value = data[0].remaining;
        }

        function updatepayment() {
            data[0].action = 'update';
            $.post("../ajaxHandler.php", data[0], function(result) {
                console.log(result);
                location.reload();
            });
        }

        function editpayment(id) {
            console.log("id", id);
            $.post("../ajaxHandler.php?action=getbyid&id=" + id, function(jsonData, status) {
                data = jsonData;
                $('#rent')[0].value = data[0].rent;
                $('#paid')[0].value = data[0].paid;
                $('#addedcost')[0].value = data[0].addedcost;
                $('#Damegecost')[0].value = data[0].Damagecost;
                $('#totalamount')[0].value = data[0].totalamound;
                $('#remaining')[0].value = data[0].remaining;
                console.log("Data: ", data, "\nStatus: " + status);
            });
            $('#modelHeading')[0].innerHTML = id;
        }

        function edit(id) {
            console.log("id", id);
            $.post("../ajaxHandler.php?action=getbyid&id=" + id, function(jsonData, status) {
                data = jsonData;
                $('#name')[0].value = data[0].name;
                $('#phone')[0].value = data[0].phone;
                $('#email')[0].value = data[0].email;
                $('#address')[0].value = data[0].address;
                $('#formdate')[0].value = data[0].bookeddate;
                $('#duration')[0].value = data[0].duration;
                $('#camera')[0].value = data[0].camera;
                $('#kitlens')[0].checked = data[0].kitlens == '100' ? true : false;
                $('#zoomlens')[0].checked = data[0].zoomlens == '150' ? true : false;
                $('#primelens')[0].checked = data[0].primelens == '150' ? true : false;
                $('#rent')[0].value = data[0].rent;
                $('#paid')[0].value = data[0].paid;
                $('#addedcost')[0].value = data[0].addedcost;
                $('#Damegecost')[0].value = data[0].Damagecost;
                $('#totalamount')[0].value = data[0].totalamound;
                $('#remaining')[0].value = data[0].remaining;
                $('#return')[0].checked = data[0].unb;
                console.log("Data: ", data, "\nStatus: " + status);
            });

            $('#modelHeading')[0].innerHTML = id;
        }

        function update() {
            data[0].action = 'update';
            data[0].name = $('#name')[0].value;
            data[0].phone = $('#phone')[0].value;
            data[0].email = $('#email')[0].value;
            data[0].address = $('#address')[0].value;
            data[0].bookeddate = $('#formdate')[0].value;
            data[0].duration = $('#duration')[0].value;
            data[0].camera = $('#camera')[0].value;
            data[0].kitlens = $('#kitlens')[0].checked ? 100 : 0;
            data[0].zoomlens = $('#zoomlens')[0].checked ? 150 : 0;
            data[0].primelens = $('#primelens')[0].checked ? 150 : 0;
            data[0].rent = $('#rent')[0].value;
            data[0].paid = $('#paid')[0].value;
            data[0].addedcost = $('#addedcost')[0].value;
            data[0].Damagecost = $('#Damegecost')[0].value;
            data[0].totalamound = $('#totalamount')[0].value;
            data[0].remaining = $('#remaining')[0].value;
            data[0].unb = $('#return')[0].checked ? 1 : 0;
            $.post("../ajaxHandler.php", data[0], function(result) {
                console.log(result);
                location.reload();
            });
        }

        function deleterow() {
            data[0].action = 'delete';
            if (confirm("Do you want to delete?")) {
                $.post("../ajaxHandler.php", data[0], function(result) {
                    console.log(result);
                    location.reload();
                });
            }
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
        });
        $(function() {
            $('#formdate').datepicker({
                dateFormat: "dd-m-yy"
            });
        });
    </script>
</body>

</html>