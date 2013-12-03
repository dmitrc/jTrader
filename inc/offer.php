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
		$query = "SELECT Categories.id FROM `Categories` WHERE Categories.subtype=$subCat ;";

		$result = mysqli_query($GLOBALS['db'],$query);

		if (!$result) {
    		die('Query failed with the error: ' . mysqli_error() . '<br/><br/>Failing query: ' . $query);
		}
		else {
			$id = mysqli_fetch_assoc($result);
			
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

		$result = mysqli_query($GLOBALS['db'],$query);
		if(!$result){
			echo 'false';
		} else {
			echo 'true';
		}

	}

	function removeOffer($offerID){
		$query = "DELETE FROM Offers".
					" WHERE Offers.id = $offerID";

		$result = mysqli_query($GLOBALS['db'],$query);
		if(!$result){
			echo 'false';
		} else {
			echo 'true';
		}


		
	}
	
	function getInfo($ID){
		$initialInfoQuery = "SELECT id, userid,catid,name,description,postTime, picturePath FROM Offers WHERE id = $ID;";
		
		$initialResult = mysqli_query($GLOBALS['db'],$initialInfoQuery);

		if(!$initialResult){
    		die('Query failed with the error: ' . mysqli_error() . '<br/><br/>Failing query: ' . $initialInfoQuery);
		} 

		$iniRows = array();
		while($r = mysqli_fetch_assoc($initialResult)){
    		$iniRows[] = $r;
		}
		//user info
		$getUserNameQuery = 'SELECT fname,lname FROM Users WHERE eid = '.$iniRows[0]['userid'].';';

		$userResult = mysqli_query($GLOBALS['db'],$getUserNameQuery);

		if(!$userResult){
    		die('Query failed with the error: ' . mysqli_error($GLOBALS['db']) . '<br/><br/>Failing query: ' . $getUserNameQuery);
		}

		$userRows = array();
		while($r = mysqli_fetch_assoc($userResult)){
			$userRows[] = $r;
		}

		$author = $userRows[0]['fname'].' '.$userRows[0]['lname'];
		$name = $iniRows[0]['name'];
		$description = $iniRows[0]['description'];
		$time = $iniRows[0]['postTime'];
		$pic = $iniRows[0]['picturePath'];

		$getCatQuery = 'SELECT type, subtype FROM Categories WHERE id = '.$iniRows[0]['catid'].';';

		$catResult = mysqli_query($GLOBALS['db'],$getCatQuery);

		if(!$catResult){
			die('Query failed with the error: ' . mysqli_error($GLOBALS['db']) . '<br/><br/>Failing query: ' . $catResult);
		}
		$catRows = array();
		while($r = mysqli_fetch_assoc($catResult)){
			$catRows[] = $r;
		}

		$category = $catRows[0]['type'];
		$subcategory = $catRows[0]['subtype'];

		$fixedPriceOfferQuery = 'SELECT price FROM FixedPriceOffers WHERE offerid = '.$iniRows[0]['id'].';';
		$fpoResult = mysqli_query($GLOBALS['db'],$fixedPriceOfferQuery);
		if(!$fpoResult){
			die('Query failed with the error: ' . mysqli_error($GLOBALS['db']) . '<br/><br/>Failing query: ' . $fixedPriceOfferQuery);
		}
		$fpoRows = Array();
		while($r = mysqli_fetch_assoc($fpoResult)){
			$fpoRows[] = $r;
		}

		$price = $fpoRows[0]['price'];

		$arr = array( 'author'  => $author, 'name' => $name, 'description' => $description, 'time' => $time , 'pic' => $pic, 'category' => $category,'subcategory' =>  $subcategory, 'price' => $price );

		echo json_encode($arr);
		return json_encode($arr);
	}


	function buyItem($buyerID, $offerID){
		
	}

?>