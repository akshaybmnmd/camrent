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
  <script src="../js/table.js"></script>
</body>

</html>