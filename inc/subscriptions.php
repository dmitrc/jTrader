<?php

include '../config.php';

if ($_POST['id'] != '' && $_POST['userid'] != '' && $_POST['catid'] != '') {
	$id = $_POST['id'];
	$uid = $_POST['userid'];
	$cid = $_POST['catid'];

	$sql="INSERT INTO Subscriptions (ID, UserID, CatID) VALUES ('$id', '$uid', '$cid')";
	echo '<div class = "text-muted"><small><em>' . $sql . '</em></small></div>';

	if (!mysqli_query($con,$sql))
	  {
	  die('<div class="lead text-danger"><strong>Error: </strong>' . mysqli_error($con) . '</div>');
	  }
	echo '<div class="lead text-success">Record added</div>';

	mysqli_close($con);
}
else 
	echo '<div class="lead text-danger"><strong>Error: One of the fields was not set.</strong>';

?>