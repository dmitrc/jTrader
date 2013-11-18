<html>
<head>
	
</head>
<body>
<?php
	include_once('../../config.php');
	
	if (isset($_POST['timeLimit'])) {

		$query = "SELECT id, closingtime FROM Auctions WHERE closingtime < NOW() + INTERVAL '".$_POST['timeLimit']."' HOUR;";
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
			printResults($rows,array("id", "closingtime"),"id","detail1.php");
		}
	}

	else {
		echo '
			Retrieve auctions where the closing time is within a certain amount of time:
			<br/>
			<br/>
			<form name="query1" action="query1.php" method="post">
			Time Limit: <input type = "text" name = "timeLimit"><br><br>
			<input type = "submit" value = "Search!">
			</form>
			<br/>
			<br/>
			<i><div style="color: DarkGray;"><u>Can be tested with following data - expired auctions are returned if database is not cleaned:</u><br/>
			Time Limit: 1<br/>
		';
	}
?>
</body>
</html>