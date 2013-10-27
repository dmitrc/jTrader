<?php
// Create connection
$con=mysqli_connect("ftp://dcucleschi-4:g2NRV9DL@userweb.jacobs-university.de","jtrade","WxjcXFRH","udb_jtrade");

// Check connection
if (mysqli_connect_errno($con))
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
?>