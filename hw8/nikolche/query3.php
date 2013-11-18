<html>
<head>
	
</head>
<body>
<?php
	include_once('../../config.php');
	
	if (isset($_POST['description'])) {

		$query = "SELECT Offers.name, FixedPriceOffers.id as FPOID, FixedPriceOffers.price AS FPOprice FROM Offers,FixedPriceOffers WHERE Offers.name LIKE '%".$_POST['description']."%' AND FixedPriceOffers.offerID = Offers.id ;";
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
			printResults($rows,array("name","FPOprice"),"FPOID","detail3.php");
		}
	}

	else {
		echo '
			Retrieve information about bids from a specific user:
			<br/>
			<br/>
			<form name="query3" action="query3.php" method="post">
			Offer description: <input type = "text" name = "description"><br><br>
			<input type = "submit" value = "Search!">
			</form>
			<br/>
			<br/>
			<i><div style="color: DarkGray;"><u>Can be tested with following data:</u><br/>
			First name: phone<br/>
			</div></i>
		';
	}
?>
</body>
</html>