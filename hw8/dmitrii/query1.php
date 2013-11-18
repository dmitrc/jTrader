<?php
	include_once('../../config.php');
	
	if (!isset($_POST['name']) && !isset($_POST['permission'])) {
		$result = mysqli_query($GLOBALS['db'],"SELECT * FROM Users;");
	}
?>