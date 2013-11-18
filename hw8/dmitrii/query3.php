<html>
<head>
	
</head>
<body>
<?php
	include_once('../../config.php');
	
	if (isset($_POST['clearance'])) {

		$query = "SELECT * FROM Users, Admins WHERE Users.eid = Admins.eid AND Admins.clearanceLevel >= '".$_POST['clearance']."';";
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
			printResults($rows,array("fname","lname"),"eid","detail3.php");
		}
	}

	else {
		echo '
			Get full information about admins, with clearance level more than indicated:
			<br/>
			<br/>
			<form name="query3" action="query3.php" method="post">
			Min clearance: <input type = "text" name = "clearance"><br><br>
			<input type = "submit" value = "Search!">
			</form>
			<br/>
			<br/>
			<i><div style="color: DarkGray;"><u>Can be tested with following data:</u><br/>
			Min clearance: 5
			</div></i>
		';
	}
?>
</body>
</html>