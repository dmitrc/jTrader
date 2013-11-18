<html>
<head>
	
</head>
<body>
<?php
	include_once('../../config.php');
	
	if (isset($_POST['type']) ) {

		$query = "SELECT Offers.* FROM Offers,Categories
		WHERE (Categories.type LIKE '%".$_POST['type']."%' OR Categories.subtype LIKE '%".$_POST['type']."%') AND Offers.catID = Categories.id;";
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
			Retrieve information about user, given his first name and college:
			<br/>
			<br/>
			<form name="query2" action="query2.php" method="post">
			Category description <input type = "text" name = "type"><br><br>
			<input type = "submit" value = "Search!">
			</form>
			<br/>
			<br/>
			<i><div style="color: DarkGray;"><u>Can be tested with following data:</u><br/>
			Category description: Electronics<br/>
			<br>
			Category description: Consumables<br/>

			</div></i>
		';
	}
?>
</body>
</html>