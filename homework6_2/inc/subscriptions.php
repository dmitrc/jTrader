<?php

include '../config.php';

$sql="INSERT INTO Subscriptions (ID, UserID, CatID)
VALUES
('$_POST[id]','$_POST[userid]','$_POST[catid]')";

if (!mysqli_query($con,$sql))
  {
  die('<h2>Error: ' . mysqli_error($con) . '</h2>');
  }
echo "<h2> Record added </h2>";

mysqli_close($con);

?>