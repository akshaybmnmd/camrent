if (verified) {
  $("#reponse")[0].innerHTML =
    "System was able to Verify you as <?php echo $name; ?>. You still need to contact Akshay to verify your ID proof. <br><br> Contact:- +91 8606815571";
} else {
  $("#reponse")[0].innerHTML =
    "System wasn't able to Verify your id <?php echo $id; ?>. Contact Akshay to verify your ID. <br><br> Contact:- +91 8606815571";
}
