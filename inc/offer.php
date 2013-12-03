<?php

	include_once(dirname(__FILE__).'/../config.php');

	class Offer {
		var $userID;
		var $catID;
		var $name;
		var $description;
		var $postTime;
	}

	function getIdBySubType($subCat){
		$query = "SELECT Categories.id FROM `Categories` WHERE Categories.subtype=$subCat ;"

		$result = mysql_query($db,$query);
		if (!$result) {
    		die('Query failed with the error: ' . mysqli_error() . '<br/><br/>Failing query: ' . $query);
		}
		else {
			$id = mysqli_fetch_assoc($result))
			
			return $id;
		}
	}

	function addOffer( $userId, $subCatID, $name, $description){
		$off = new Offer();
		$off->userID = $userId;
		$off->catID = getIdBySubType($subCatID);
		$off->name = $name;
		$off->description = $description;

		$query = "INSERT INTO Offers (userid,catid,name,description,postTime) 
		VALUES ($off->userId,$off->catID, $off->name, $off->description, NOW());";

		$result = mysql_query($db,$query);
		if(!$result){
			echo 'false';
		} else {
			echo 'true';
		}

	}

	function removeOffer($offerID){
		$query = "DELETE FROM Offers".
					" WHERE Offers.id = $offerID";

		$result = mysql_query($db,$query);
		if(!$result){
			echo 'false';
		} else {
			echo 'true';
		}


		
	}
	
	function getInfo($ID){
		$initialInfoQuery = "SELECT userid,catid,name,description FROM Offers;"
		
		$initialResult = mysql_query($db,$initialInfoQuery);
		if(!$initialResult){
    		die('Query failed with the error: ' . mysqli_error() . '<br/><br/>Failing query: ' . $query);
		} 

		$iniRows = array();
		while($r = mysqli_fetch_assoc($result)) {
    		$iniRows[] = $r;
		}

		echo $iniRows["userid"];
		
	}

?>