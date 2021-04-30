$(document).ready(function () {
  $("#table_id").DataTable({
    processing: true,
    serverSide: true,
    ajax: "./tableData.php?action=fulltable", // your php file
    rowCallback: function (row, data) {
      datearray = data[6].split("-");
      var d = new Date(datearray[2], datearray[1] - 1, datearray[0]);
      d.setDate(d.getDate() + parseInt(data[7]));
      const date1 = new Date();
      const diffTime = d - date1;
      const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
      $("td:eq(7)", row)[0].title = d;
      if (data[16] <= 0) {
        $("td:eq(16)", row)[0].style.backgroundColor = "green";
      } else {
        $("td:eq(16)", row)[0].style.backgroundColor = "red";
      }
      if (data[17] <= 0) {
        $("td:eq(17)", row)[0].style.backgroundColor = "green";
      } else {
        $("td:eq(17)", row)[0].style.backgroundColor = "red";
      }
      if (data[19] <= 0) {
        $("td:eq(19)", row)[0].style.backgroundColor = "green";
      } else {
        $("td:eq(19)", row)[0].style.backgroundColor = "red";
      }
      if (data[22] == 1) {
        $("td:eq(1)", row)[0].style.backgroundColor = "green";
      } else {
        $("td:eq(1)", row)[0].style.backgroundColor = "#8a8aff";
        if (diffTime > 0) {
          $("td:eq(7)", row)[0].style.backgroundColor = "green";
        } else {
          $("td:eq(7)", row)[0].style.backgroundColor = "red";
        }
      }
    },
  });
});
