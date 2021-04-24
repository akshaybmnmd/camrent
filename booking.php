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
    <script>
        var data = '';
        $(document).ready(function() {
            $("#table_id").DataTable({
                processing: true,
                serverSide: true,
                ajax: "./admin/tableData.php?action=booking&id=148", // your php file
                "columnDefs": [{
                        "render": function(data, type, row) {
                            return '<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#durationmodel" onClick=addduration(' + row[0] + ')>Add Days</button>';
                        },
                        "targets": 17
                    }, {
                        "render": function(data, type, row) {
                            return row[6] + ' days';
                        },
                        "targets": 6
                    },
                    {
                        "render": function(data, type, row) {
                            return '100';
                        },
                        "targets": 7
                    },
                    {
                        "render": function(data, type, row) {
                            return '150';
                        },
                        "targets": 8
                    },
                    {
                        "render": function(data, type, row) {
                            return '150';
                        },
                        "targets": 9
                    },
                    {
                        "render": function(data, type, row) {
                            return '250';
                        },
                        "targets": 10
                    }
                ],
                "rowCallback": function(row, data) {
                    datearray = data[5].split("-");
                    var d = new Date(datearray[2], datearray[1] - 1, datearray[0]);
                    d.setDate(d.getDate() + parseInt(data[6]));
                    const date1 = new Date();
                    const diffTime = d - date1;
                    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                    $('td:eq(6)', row)[0].title = d;

                    if (data[7] == 0) {
                        $('td:eq(7)', row)[0].style.backgroundColor = "#ff9e9e";
                    } else {
                        $('td:eq(7)', row)[0].style.backgroundColor = "#84af84";
                    }
                    if (data[8] == 0) {
                        $('td:eq(8)', row)[0].style.backgroundColor = "#ff9e9e";
                    } else {
                        $('td:eq(8)', row)[0].style.backgroundColor = "#84af84";
                    }
                    if (data[9] == 0) {
                        $('td:eq(9)', row)[0].style.backgroundColor = "#ff9e9e";
                    } else {
                        $('td:eq(9)', row)[0].style.backgroundColor = "#84af84";
                    }
                    if (data[10] == 0) {
                        $('td:eq(10)', row)[0].style.backgroundColor = "#ff9e9e";
                    } else {
                        $('td:eq(10)', row)[0].style.backgroundColor = "#84af84";
                    }
                    if (data[13] <= 0) {
                        $('td:eq(13)', row)[0].style.backgroundColor = "green";
                    } else {
                        $('td:eq(13)', row)[0].style.backgroundColor = "red";
                    }
                    if (data[14] <= 0) {
                        $('td:eq(14)', row)[0].style.backgroundColor = "green";
                    } else {
                        $('td:eq(14)', row)[0].style.backgroundColor = "red";
                    }
                    if (data[16] <= 0) {
                        $('td:eq(16)', row)[0].style.backgroundColor = "green";
                    } else {
                        $('td:eq(16)', row)[0].style.backgroundColor = "red";
                    }
                    if (data[17] != 1) {
                        if (diffTime > 0) {
                            $('td:eq(6)', row)[0].style.backgroundColor = "green";
                        } else {
                            alert("Over Due of booked date!!");
                            $('td:eq(6)', row)[0].style.backgroundColor = "red";
                        }
                    }
                }
            });
        });

        function addDuration() {
            data[0].action = 'update';
            data[0].duration = parseInt(data[0].duration) + parseInt($('#duration')[0].value);
            data[0].rent = (parseInt(data[0].camera) + parseInt(data[0].kitlens) + parseInt(data[0].zoomlens) + parseInt(data[0].primelens)) * parseInt(data[0].duration);
            data[0].totalamound = parseInt(data[0].rent) + parseInt(data[0].addedcost) + parseInt(data[0].Damagecost);
            data[0].remaining = parseInt(data[0].totalamound) - parseInt(data[0].paid);
            $.post("./ajaxHandler.php", data[0], function(result) {
                console.log(result);
                location.reload();
            });
        }

        function durationChange() {
            duration = parseInt(data[0].duration) + parseInt($('#duration')[0].value);
            rent = (parseInt(data[0].camera) + parseInt(data[0].kitlens) + parseInt(data[0].zoomlens) + parseInt(data[0].primelens)) * parseInt(duration);
            totalamound = parseInt(rent) + parseInt(data[0].addedcost) + parseInt(data[0].Damagecost);
            remaining = parseInt(totalamound) - parseInt(data[0].paid);
            $('#durtn')[0].innerHTML = "Additional Days: " + duration;
            $('#rent')[0].value = rent;
            $('#totalamount')[0].value = totalamound;
            $('#remaining')[0].value = remaining;
        }

        function addduration(id) {
            console.log("id", id);
            $.post("./ajaxHandler.php?action=getbyid&id=" + id, function(jsonData, status) {
                data = jsonData;
                $('#durtn')[0].innerHTML = "Additional Days: " + data[0].duration;
                $('#rent')[0].value = data[0].rent;
                $('#paid')[0].value = data[0].paid;
                $('#addedcost')[0].value = data[0].addedcost;
                $('#Damegecost')[0].value = data[0].Damagecost;
                $('#totalamount')[0].value = data[0].totalamound;
                $('#remaining')[0].value = data[0].remaining;
                console.log("Data: ", data, "\nStatus: " + status);
            });
        }
    </script>
</body>

</html>