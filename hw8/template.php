<html>
<head>
	
</head>
<body>
<?php
	include_once('../../config.php');
	
	if (isset($_POST['name']) && !isset($_POST['permission'])) {

		$query = "SELECT * FROM Users;";
		$result = mysqli_query($GLOBALS['db'],$query);

		if (!$result) {
    		die('Query failed with the error: ' . mysql_error() . '<br/><br/>Failing query: ' . $query);
		}
		else {
			$rows = array();
			while($r = mysqli_fetch_assoc($result)) {
    			$rows[] = $r;
			}
			print json_encode($rows);
		}
	}

	else {
		echo '
			<form name="query1" action="query1.php" method="post">
			Field: <input type = "text" name = "field1"><br>
			Field: <input type = "text" name = "field2"><br>
			
			<!-- more shit here -->

			<input type = "submit" value = "Search!">
			</form>
		';
	}
?>
</body>
</html>