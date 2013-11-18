<html>
<head>
	
</head>
<body>
<?php
	include_once('../../config.php');

	if (!isset($_GET['FPOID'])) {
		die("No input parameters specified! :(");
	}

	$query = 'SELECT * FROM FixedPriceOffers WHERE FixedPriceOffers.id = ' . $_GET['FPOID'];
	$result = mysqli_query($GLOBALS['db'],$query);

	if (!$result) {
    	die('Query failed with the error: ' . mysql_error() . '<br/><br/>Failing query: ' . $query);
	}
	else {
		$rows = array();
		while($r = mysqli_fetch_assoc($result)) {
			$rows[] = $r;
		}
	
		$query2 = 'SELECT Offers.userID, Offers.name, Offers.description FROM Offers WHERE Offers.id = '.$rows[0]['offerid'].' ;';
		$result2 = mysqli_query($GLOBALS['db'],$query2);
		if(!$result2){
			die('Query failed with the error: ' . mysql_error() . '<br/><br/>Failing query: ' . $query2);
		}

		$rows2 = array();
		while($r = mysqli_fetch_assoc($result2)) {
			$rows2[] = $r;
		}

		/*
		echo "<b><u>Raw:</u></b> <br/>";
		var_export($rows);
		echo '<br/><br/>';
		*/

		echo "<b><u>Offer Details:</u></b><br/><br/>";
		printDetail($rows2);
		echo "<br> <b><u>Bid Details:</u></b><br>";
		printDetail($rows);
	}
?>
</body>
</html>