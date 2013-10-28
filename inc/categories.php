<?php

include '../config.php';

if (isset($_POST['type']) && isset($_POST['subtype']) && isset($_POST['id']) && isset($_POST['description'])) {
	
	$id = $_POST['id'];
	$type = $_POST['type'];
	$subtype = $_POST['subtype'];
	$description = $_POST['description'];

	$sql="INSERT INTO Categories (ID, Type, Subtype, Description) VALUES ('$id', '$type', '$subtype', '$description')";
	echo '<div class = "text-muted"><small><em>' . $sql . '</em></small></div>';

	if (!mysqli_query($con,$sql))
	  {
	  die('<div class="lead text-danger"><strong>Error: </strong>' . mysqli_error($con) . '</div>');
	  }
	echo '<div class="lead text-success">Record added</div>';

	mysqli_close($con);
}

?>