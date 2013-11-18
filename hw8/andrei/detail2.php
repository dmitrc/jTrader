<html>
<head>
	
</head>
<body>
<?php
	include_once('../../config.php');

	if (!isset($_GET['offerid'])) {
		die("No input parameters specified! :(");
	}

	$query = 'SELECT * FROM Users WHERE Offers.id = ' . $_GET['offerid'];
	$result = mysqli_query($GLOBALS['db'],$query);

	if (!$result) {
    	die('Query failed with the error: ' . mysql_error() . '<br/><br/>Failing query: ' . $query);
	}
	else {
		$rows = array();
		while($r = mysqli_fetch_assoc($result)) {
			$rows[] = $r;
		}

		/*
		echo "<b><u>Raw:</u></b> <br/>";
		var_export($rows);
		echo '<br/><br/>';
		*/

		echo "<b><u>Details:</u></b><br/><br/>";
		printDetail($rows);
	}
?>
</body>
</html>