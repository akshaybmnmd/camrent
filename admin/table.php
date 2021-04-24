<?php
// phpinfo();
require '../config.php';

session_start();
if (!$_SESSION['login']) {
  header("Location: login.php?error=true");
  die();
}
?>

<!DOCTYPE html>
<html>

<head>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" />
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css" />

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
</head>

<body>
  <a href="./index.php">View Admin table </a> <br>
  <table id="table_id" class="display">
    <thead>
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Phone</th>
        <th>Email</th>
        <th>Address</th>
        <th>Booking Date</th>
        <th>Booked Date</th>
        <th>Duration</th>
        <th>Start</th>
        <th>End</th>
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
        <th>Proofs</th>
        <th>IP</th>
        <th>0/1</th>
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
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
    </tfoot>
  </table>
  <script>
    $(document).ready(function() {
      $("#table_id").DataTable({
        processing: true,
        serverSide: true,
        ajax: "./tableData.php?action=fulltable", // your php file
        "rowCallback": function(row, data) {
          datearray = data[6].split("-");
          var d = new Date(datearray[2], datearray[1] - 1, datearray[0]);
          d.setDate(d.getDate() + parseInt(data[7]));
          const date1 = new Date();
          const diffTime = d - date1;
          const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
          $('td:eq(7)', row)[0].title = d;
          if (data[16] <= 0) {
            $('td:eq(16)', row)[0].style.backgroundColor = "green";
          } else {
            $('td:eq(16)', row)[0].style.backgroundColor = "red";
          }
          if (data[17] <= 0) {
            $('td:eq(17)', row)[0].style.backgroundColor = "green";
          } else {
            $('td:eq(17)', row)[0].style.backgroundColor = "red";
          }
          if (data[19] <= 0) {
            $('td:eq(19)', row)[0].style.backgroundColor = "green";
          } else {
            $('td:eq(19)', row)[0].style.backgroundColor = "red";
          }
          if (data[22] == 1) {
            $('td:eq(1)', row)[0].style.backgroundColor = "green";
          } else {
            $('td:eq(1)', row)[0].style.backgroundColor = "#8a8aff";
            if (diffTime > 0) {
              $('td:eq(7)', row)[0].style.backgroundColor = "green";
            } else {
              $('td:eq(7)', row)[0].style.backgroundColor = "red";
            }
          }
        }
      });
    });
  </script>
</body>

</html>