<html>
<head>
	
</head>
<body>
<?php
	include_once('../../config.php');

	if (!isset($_GET['id'])) {
		die("No input parameters specified! :(");
	}

	$query = 'SELECT Auctions.minPrice, Offers.name, Offers.description, Offers.postTime FROM Auctions, Offers WHERE Offers.id = Auctions.offerid AND Auctions.id = ' . $_GET['id'];
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