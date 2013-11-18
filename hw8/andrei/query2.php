<html>
<head>
	
</head>
<body>
<?php
	include_once('../../config.php');
	
	if (isset($_POST['category']) && isset($_POST['minPrice'])) {

		$query = "SELECT * FROM Auctions, Offers, Categories  WHERE Auctions.minPrice < '".$_POST['minPrice']."' AND Auctions.offerid = Offers.id AND Offers.catid = Categories.id AND Categories.type LIKE '%".$_POST['category']."%';";
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
			Retrieve auctions from a category where the minimum price is smaller than the input value:
			<br/>
			<br/>
			<form name="query2" action="query2.php" method="post">
			Category: <input type = "text" name = "category"><br><br>
			Minimum price: <input type = "text" name = "minPrice"><br><br>
			<input type = "submit" value = "Search!">
			</form>
			<br/>
			<br/>
			<i><div style="color: DarkGray;"><u>Can be tested with following data:</u><br/>
			Category: Electronics<br/>
			Minimum price: 500<br/>
		';
	}
?>
</body>
</html>