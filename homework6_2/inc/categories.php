<?php

include '../config.php';

$sql="INSERT INTO Categories (ID, Type, Subtype, Description)
VALUES
('$_POST[id]','$_POST[type]','$_POST[subtype]','$_POST[description]')";

if (!mysqli_query($con,$sql))
  {
  die('<h2>Error: ' . mysqli_error($con) . '</h2>');
  }
echo "<h2> Record added </h2>";

mysqli_close($con);

?>