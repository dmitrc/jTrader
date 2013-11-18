<html>
<head>
	
</head>
<body>
<?php
	include_once('../../config.php');
	
	if (isset($_POST['item']) && isset($_POST['price'])) {

		$query = "SELECT Offers.* FROM Offers, FixedPriceOffers WHERE Offers.id = FixedPriceOffers.offerid AND Offers.name LIKE '%".$_POST['item']."%' AND FixedPriceOffers.price < '".$_POST['price']."';";
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
			printResults($rows,array("name"),"id","detail2.php");
		}
	}

	else {
		echo '
			Search fixed price offers with name containing some text and price, less than specified:
			<br/>
			<br/>
			<form name="query2" action="query2.php" method="post">
			Item: <input type = "text" name = "item"><br>
			Max price: <input type = "text" name = "price"><br><br>
			<input type = "submit" value = "Search!">
			</form>
			<br/>
			<br/>
			<i><div style="color: DarkGray;"><u>Can be tested with following data:</u><br/>
			Item: Xperia<br/>
			Max price: 9999</div></i>
		';
	}
?>
</body>
</html>