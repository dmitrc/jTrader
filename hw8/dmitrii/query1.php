<html>
<head>
	
</head>
<body>
<?php
	include_once('../../config.php');
	
	if (isset($_POST['fname']) && isset($_POST['college'])) {

		$query = "SELECT * FROM Users WHERE Users.fname LIKE '%".$_POST['fname']."%' AND Users.college = '".$_POST['college']."';";
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
			printResults($rows,array("fname","lname"),"eid","detail1.php");
		}
	}

	else {
		echo '
			Retrieve information about user, given his first name and college:
			<br/>
			<br/>
			<form name="query1" action="query1.php" method="post">
			First name: <input type = "text" name = "fname"><br><br>
			College:<br><input type="radio" name="college" value="K">Krupp<br>
			<input type="radio" name="college" value="C">College III<br>
			<input type="radio" name="college" value="N">Nordmetall<br>
			<input type="radio" name="college" value="M">Mercator<br><br>
			<input type = "submit" value = "Search!">
			</form>
			<br/>
			<br/>
			<i><div style="color: DarkGray;"><u>Can be tested with following data:</u><br/>
			First name: Nikolche<br/>
			College: College III</div></i>
		';
	}
?>
</body>
</html>