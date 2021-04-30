var data = "";
$(document).ready(function () {
  $("#table_id").DataTable({
    processing: true,
    serverSide: true,
    ajax: "./admin/tableData.php?action=booking&id=148", // your php file
    columnDefs: [
      {
        render: function (data, type, row) {
          return (
            '<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#durationmodel" onClick=addduration(' +
            row[0] +
            ")>Add Days</button>"
          );
        },
        targets: 17,
      },
      {
        render: function (data, type, row) {
          return row[6] + " days";
        },
        targets: 6,
      },
      {
        render: function (data, type, row) {
          return "100";
        },
        targets: 7,
      },
      {
        render: function (data, type, row) {
          return "150";
        },
        targets: 8,
      },
      {
        render: function (data, type, row) {
          return "150";
        },
        targets: 9,
      },
      {
        render: function (data, type, row) {
          return "250";
        },
        targets: 10,
      },
    ],
    rowCallback: function (row, data) {
      datearray = data[5].split("-");
      var d = new Date(datearray[2], datearray[1] - 1, datearray[0]);
      d.setDate(d.getDate() + parseInt(data[6]));
      const date1 = new Date();
      const diffTime = d - date1;
      const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
      $("td:eq(6)", row)[0].title = d;

      if (data[7] == 0) {
        $("td:eq(7)", row)[0].style.backgroundColor = "#ff9e9e";
      } else {
        $("td:eq(7)", row)[0].style.backgroundColor = "#84af84";
      }
      if (data[8] == 0) {
        $("td:eq(8)", row)[0].style.backgroundColor = "#ff9e9e";
      } else {
        $("td:eq(8)", row)[0].style.backgroundColor = "#84af84";
      }
      if (data[9] == 0) {
        $("td:eq(9)", row)[0].style.backgroundColor = "#ff9e9e";
      } else {
        $("td:eq(9)", row)[0].style.backgroundColor = "#84af84";
      }
      if (data[10] == 0) {
        $("td:eq(10)", row)[0].style.backgroundColor = "#ff9e9e";
      } else {
        $("td:eq(10)", row)[0].style.backgroundColor = "#84af84";
      }
      if (data[13] <= 0) {
        $("td:eq(13)", row)[0].style.backgroundColor = "green";
      } else {
        $("td:eq(13)", row)[0].style.backgroundColor = "red";
      }
      if (data[14] <= 0) {
        $("td:eq(14)", row)[0].style.backgroundColor = "green";
      } else {
        $("td:eq(14)", row)[0].style.backgroundColor = "red";
      }
      if (data[16] <= 0) {
        $("td:eq(16)", row)[0].style.backgroundColor = "green";
      } else {
        $("td:eq(16)", row)[0].style.backgroundColor = "red";
      }
      if (data[17] != 1) {
        if (diffTime > 0) {
          $("td:eq(6)", row)[0].style.backgroundColor = "green";
        } else {
          alert("Over Due of booked date!!");
          $("td:eq(6)", row)[0].style.backgroundColor = "red";
        }
      }
    },
  });
});

function addDuration() {
  data[0].action = "update";
  data[0].actionby = "user";
  data[0].duration =
    parseInt(data[0].duration) + parseInt($("#duration")[0].value);
  data[0].rent =
    (parseInt(data[0].camera) +
      parseInt(data[0].kitlens) +
      parseInt(data[0].zoomlens) +
      parseInt(data[0].primelens)) *
    parseInt(data[0].duration);
  data[0].totalamound =
    parseInt(data[0].rent) +
    parseInt(data[0].addedcost) +
    parseInt(data[0].Damagecost);
  data[0].remaining = parseInt(data[0].totalamound) - parseInt(data[0].paid);
  $.post("./ajaxHandler.php", data[0], function (result) {
    console.log(result);
    location.reload();
  });
}

function durationChange() {
  duration = parseInt(data[0].duration) + parseInt($("#duration")[0].value);
  rent =
    (parseInt(data[0].camera) +
      parseInt(data[0].kitlens) +
      parseInt(data[0].zoomlens) +
      parseInt(data[0].primelens)) *
    parseInt(duration);
  totalamound =
    parseInt(rent) + parseInt(data[0].addedcost) + parseInt(data[0].Damagecost);
  remaining = parseInt(totalamound) - parseInt(data[0].paid);
  $("#durtn")[0].innerHTML = "Additional Days: " + duration;
  $("#rent")[0].value = rent;
  $("#totalamount")[0].value = totalamound;
  $("#remaining")[0].value = remaining;
}

function addduration(id) {
  $.post(
    "./ajaxHandler.php?action=getbyid&id=" + id,
    function (jsonData, status) {
      data = jsonData;
      $("#durtn")[0].innerHTML = "Additional Days: " + data[0].duration;
      $("#rent")[0].value = data[0].rent;
      $("#paid")[0].value = data[0].paid;
      $("#addedcost")[0].value = data[0].addedcost;
      $("#Damegecost")[0].value = data[0].Damagecost;
      $("#totalamount")[0].value = data[0].totalamound;
      $("#remaining")[0].value = data[0].remaining;
    }
  );
}
