<html>
<head>
	
</head>
<body>
<?php
	include_once('../../config.php');
	
	if (isset($_POST['fname']) && isset($_POST['lname'])) {

		$query = "SELECT Offers.id, Offers.userID, Offers.catID, Offers.name, Offers.description, Offers.postTime
FROM Offers,Users 
WHERE Users.fname LIKE '%".$_POST['fname']."%' AND Users.lname LIKE '%".$_POST['lname']."%' AND Users.eid=Offers.userID;";
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
			printResults($rows,array("name"),"id","detail1.php");
		}
	}

	else {
		echo '
			Retrieve information about user, given his first name and college:
			<br/>
			<br/>
			<form name="query1" action="query1.php" method="post">
			First name: <input type = "text" name = "fname"><br><br>
			Last Name:<input type="text" name="lname"> <br> <br>
			<input type = "submit" value = "Search!">
			</form>
			<br/>
			<br/>
			<i><div style="color: DarkGray;"><u>Can be tested with following data:</u><br/>
			First name: Nikolche<br/>
			Last Name: Kolev <br/>
			<br>
			First Name: Andrei <br/>
			Last Name: Gi </br>
			</div></i>
		';
	}
?>
</body>
</html>