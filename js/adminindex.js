var data = "";

$(document).ready(function () {
  $("#table_id").DataTable({
    processing: true,
    serverSide: true,
    ajax: "./tableData.php?action=admin",
    columnDefs: [
      {
        render: function (data, type, row) {
          return (
            '<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myAmountModal" onClick=editrent(' +
            row[0] +
            ')>Update rent</button><button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myPaymentModal" onClick=editpayment(' +
            row[0] +
            ')>Update payment</button><button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal" onClick=edit(' +
            row[0] +
            ")>Edit</button>"
          );
        },
        targets: 15,
      },
    ],
    rowCallback: function (row, data) {
      console.log(data);
      datearray = data[3].split("-");
      var d = new Date(datearray[2], datearray[1] - 1, datearray[0]);
      d.setDate(d.getDate() + parseInt(data[4]));
      const date1 = new Date();
      const diffTime = d - date1;
      const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
      $("td:eq(4)", row)[0].title = d;
      if (data.return == 1) {
        $(row)[0].style.backgroundColor = "#8f8fd0";
        $("td:eq(1)", row)[0].style.backgroundColor = "green";
      } else {
        $(row)[0].style.backgroundColor = "#9fb99f";
        $("td:eq(1)", row)[0].style.backgroundColor = "#8a8aff";
        if (diffTime > 0) {
          $("td:eq(4)", row)[0].style.backgroundColor = "green";
        } else {
          $("td:eq(4)", row)[0].style.backgroundColor = "red";
        }
      }
      if (data[11] <= "0") {
        $("td:eq(11)", row)[0].style.backgroundColor = "green";
      } else {
        $("td:eq(11)", row)[0].style.backgroundColor = "red";
      }
      if (data[12] <= "0") {
        $("td:eq(12)", row)[0].style.backgroundColor = "green";
      } else {
        $("td:eq(12)", row)[0].style.backgroundColor = "red";
      }
      if (data[14] == "0") {
        $("td:eq(14)", row)[0].style.backgroundColor = "green";
      } else {
        $("td:eq(14)", row)[0].style.backgroundColor = "red";
      }
    },
  });
});

function rentChange() {
  data[0].duration = $("#duration3")[0].value;
  data[0].camera = $("#camera3")[0].value;
  data[0].kitlens = $("#kitlens3")[0].checked ? 100 : 0;
  data[0].zoomlens = $("#zoomlens3")[0].checked ? 150 : 0;
  data[0].primelens = $("#primelens3")[0].checked ? 150 : 0;
  data[0].addedcost = $("#addedcost3")[0].value;
  data[0].Damagecost = $("#Damegecost3")[0].value;
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
  $("#rent3")[0].value = data[0].rent;
  $("#paid3")[0].value = data[0].paid;
  $("#totalamount3")[0].value = data[0].totalamound;
  $("#remaining3")[0].value = data[0].remaining;
}

function paymentChange() {
  data[0].rent = $("#rent")[0].value;
  data[0].paid = $("#paid")[0].value;
  data[0].addedcost = $("#addedcost")[0].value;
  data[0].Damagecost = $("#Damegecost")[0].value;
  data[0].totalamound =
    parseInt(data[0].rent) +
    parseInt(data[0].addedcost) +
    parseInt(data[0].Damagecost);
  data[0].remaining = parseInt(data[0].totalamound) - parseInt(data[0].paid);
  $("#rent")[0].value = data[0].rent;
  $("#paid")[0].value = data[0].paid;
  $("#addedcost")[0].value = data[0].addedcost;
  $("#Damegecost")[0].value = data[0].Damagecost;
  $("#totalamount")[0].value = data[0].totalamound;
  $("#remaining")[0].value = data[0].remaining;
}

function updatepayment() {
  data[0].action = "update";
  $.post("../ajaxHandler.php", data[0], function (result) {
    console.log(result);
    location.reload();
  });
}

function updaterent() {
  data[0].action = "update";
  $.post("../ajaxHandler.php", data[0], function (result) {
    console.log(result);
    location.reload();
  });
}

function editrent(id) {
  console.log("id", id);
  $.post(
    "../ajaxHandler.php?action=getbyid&id=" + id,
    function (jsonData, status) {
      data = jsonData;
      $("#duration3")[0].value = data[0].duration;
      $("#camera3")[0].value = data[0].camera;
      $("#kitlens3")[0].checked = data[0].kitlens == "100" ? true : false;
      $("#zoomlens3")[0].checked = data[0].zoomlens == "150" ? true : false;
      $("#primelens3")[0].checked = data[0].primelens == "150" ? true : false;
      $("#rent3")[0].value = data[0].rent;
      $("#paid3")[0].value = data[0].paid;
      $("#addedcost3")[0].value = data[0].addedcost;
      $("#Damegecost3")[0].value = data[0].Damagecost;
      $("#totalamount3")[0].value = data[0].totalamound;
      $("#remaining3")[0].value = data[0].remaining;
      console.log("Data: ", data, "\nStatus: " + status);
    }
  );
  $("#model3Heading")[0].innerHTML = "Rent" + id;
}

function editpayment(id) {
  console.log("id", id);
  $.post(
    "../ajaxHandler.php?action=getbyid&id=" + id,
    function (jsonData, status) {
      data = jsonData;
      $("#rent")[0].value = data[0].rent;
      $("#paid")[0].value = data[0].paid;
      $("#addedcost")[0].value = data[0].addedcost;
      $("#Damegecost")[0].value = data[0].Damagecost;
      $("#totalamount")[0].value = data[0].totalamound;
      $("#remaining")[0].value = data[0].remaining;
      console.log("Data: ", data, "\nStatus: " + status);
    }
  );
  $("#modelHeading")[0].innerHTML = id;
}

function edit(id) {
  console.log("id", id);
  $.post(
    "../ajaxHandler.php?action=getbyid&id=" + id,
    function (jsonData, status) {
      data = jsonData;
      $("#name2")[0].value = data[0].name;
      $("#phone2")[0].value = data[0].phone;
      $("#email2")[0].value = data[0].email;
      $("#address2")[0].value = data[0].address;
      $("#formdate2")[0].value = data[0].bookeddate;
      $("#duration2")[0].value = data[0].duration;
      $("#camera2")[0].value = data[0].camera;
      $("#kitlens2")[0].checked = data[0].kitlens == "100" ? true : false;
      $("#zoomlens2")[0].checked = data[0].zoomlens == "150" ? true : false;
      $("#primelens2")[0].checked = data[0].primelens == "150" ? true : false;
      $("#rent2")[0].value = data[0].rent;
      $("#paid2")[0].value = data[0].paid;
      $("#addedcost2")[0].value = data[0].addedcost;
      $("#Damegecost2")[0].value = data[0].Damagecost;
      $("#totalamount2")[0].value = data[0].totalamound;
      $("#remaining2")[0].value = data[0].remaining;
      $("#return2")[0].checked = data[0].unb == 1 ? true : false;
      console.log("Data: ", data, "\nStatus: " + status);
    }
  );
  $("#model2Heading")[0].innerHTML = "Edit " + id;
}

function update() {
  data[0].action = "update";
  data[0].name = $("#name2")[0].value;
  data[0].phone = $("#phone2")[0].value;
  data[0].email = $("#email2")[0].value;
  data[0].address = $("#address2")[0].value;
  data[0].bookeddate = $("#formdate2")[0].value;
  data[0].duration = $("#duration2")[0].value;
  data[0].camera = $("#camera2")[0].value;
  data[0].kitlens = $("#kitlens2")[0].checked ? 100 : 0;
  data[0].zoomlens = $("#zoomlens2")[0].checked ? 150 : 0;
  data[0].primelens = $("#primelens2")[0].checked ? 150 : 0;
  data[0].rent = $("#rent2")[0].value;
  data[0].paid = $("#paid2")[0].value;
  data[0].addedcost = $("#addedcost2")[0].value;
  data[0].Damagecost = $("#Damegecost2")[0].value;
  data[0].totalamound = $("#totalamount2")[0].value;
  data[0].remaining = $("#remaining2")[0].value;
  data[0].unb = $("#return2")[0].checked ? 1 : 0;
  $.post("../ajaxHandler.php", data[0], function (result) {
    console.log(result);
    location.reload();
  });
}

function deleterow() {
  data[0].action = "delete";
  if (confirm("Do you want to delete?")) {
    $.post("../ajaxHandler.php", data[0], function (result) {
      console.log(result);
      location.reload();
    });
  }
}

function available(date) {
  dmy = date.getDate() + "-" + (date.getMonth() + 1) + "-" + date.getFullYear();
  var d = new Date();
  if (
    (date.getDate() <= d.getDate() && date.getMonth() == d.getMonth()) ||
    (date.getMonth() < d.getMonth() && date.getFullYear() == d.getFullYear()) ||
    date.getFullYear() < d.getFullYear()
  ) {
    return [false, "", "unAvailable"];
  }
  if ($.inArray(dmy, unavailableDates) !== -1) {
    return [false, "", "unAvailable"];
  } else {
    return [true, "", "Available"];
  }
}
$(function () {
  $("#date").datepicker({
    beforeShowDay: available,
    autoSize: true,
    dateFormat: "dd-m-yy",
  });
});
$(function () {
  $("#formdate").datepicker({
    dateFormat: "dd-m-yy",
  });
});
