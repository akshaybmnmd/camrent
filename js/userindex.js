$(function () {
  $(" #date").datepicker({
    beforeShowDay: available,
    autoSize: true,
    dateFormat: "dd-m-yy",
  });
});

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

function editrent() {}
