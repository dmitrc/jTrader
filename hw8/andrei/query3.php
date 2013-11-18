<html>
<head>
	
</head>
<body>
<?php
	include_once('../../config.php');
	
	if (isset($_POST['maxPrice'])) {

		$query = "SELECT Offers.id, MAX(Offers.postTime), Offers.name, Offers.description FROM FixedPriceOffers, Offers WHERE Offers.id = FixedPriceOffers.offerid AND FixedPriceOffers.price < '".$_POST['maxPrice']."' GROUP BY Offers.catID;";
		$result = mysqli_query($GLOBALS['db'],$query);

		if (!$result) {
    		die('Query failed with the error: ' . mysqli_error() . '<br/><br/>Failing query: ' . $query);
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
		
			echo "<b><u>Results:</u></b><br/><br/>";
			printResults($rows,array("name", "description"),"id","detail3.php");
		}
	}

	else {
		echo '
			Returns the latest offer in each category with a price smaller than the indicated one:
			<br/>
			<br/>
			<form name="query3" action="query3.php" method="post">
			Maximum price: <input type = "text" name = "maxPrice"><br><br>
			<input type = "submit" value = "Search!">
			</form>
			<br/>
			<br/>
			<i><div style="color: DarkGray;"><u>Can be tested with following data: </u><br/>
			MaxPrice: 9000<br/>
		';
	}
?>
</body>
</html>