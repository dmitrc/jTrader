<?php

	require_once(dirname(__FILE__).'/../config.php');

	class Offer {
		var $userID;
		var $catID;
		var $name;
		var $description;
		var $postTime;
		var $imgPath;
	}

	function getIdBySubType($subCat){
        $subCat = mysqli_real_escape_string($GLOBALS['db'], $subCat);

		$query = "SELECT Categories.id FROM `Categories` WHERE Categories.subtype = '$subCat';";

		$result = mysqli_query($GLOBALS['db'],$query);

		if (!$result) {
    		echo mysqli_error($GLOBALS['db']);
    		exit();
		}
		else {
			$id = mysqli_fetch_assoc($result);
			return $id;
		}
	}

	function addOffer( $userId, $subCatID, $name, $description, $image, $price){

 		$off = new Offer();
		$off->userID = mysqli_real_escape_string($GLOBALS['db'], $userId);
		$off->catID = getIdBySubType($subCatID);
		$off->name = mysqli_real_escape_string($GLOBALS['db'], 
			$name);
		$off->description = mysqli_real_escape_string($GLOBALS['db'], $description);
		$off->price = mysqli_real_escape_string($GLOBALS['db'],$price);

		if ($image) {
			$off->imgPath = saveBase64Image($image);
			if (!$off->imgPath) {
				// Image uploading failed :(
				$off->imgPath = "";
			}
		}
		else {
			$off->imgPath = "";
		}

		echo 'Image path: ' . $off->imgPath;

		$query = "INSERT INTO Offers (userid,catid,name,description,postTime,picturePath)
		VALUES ('$off->userID','$off->catID', '$off->name', '$off->description', NOW(),'$off->imgPath');";

		$result = mysqli_query($GLOBALS['db'],$query);
		if(!$result){
			echo mysqli_error($GLOBALS['db']);
			exit();
		} 

		$selectID = 'SELECT max(id) FROM Offers;';
		$selRes = mysqli_query($GLOBALS['db'],$selectID);
		if(!$selRes){
			echo mysqli_error($GLOBALS['db']);
			exit();
		}
		$idRows = Array();
		$idRows = array();
		while($r = mysqli_fetch_assoc($selRes)){
    		$idRows[] = $r;
		}

		$offerid = $idRows[0]['id'];

		$insertFPO = 'INSERT INTO FixedPriceOffers (offerid,price) VALUES ('.$offerid.','.$price.');';
		$fpoRes = mysqli_query($GLOBALS['db'],$insertFPO);
		if(!$fpoRes){
			echo mysqli_error($GLOBALS['db']);
			exit();
		} else {
			echo 'true';
		}


	}

	function removeOffer($offerID){
		$offerID = mysqli_real_escape_string($GLOBALS['db'], $offerID);
		$query = "DELETE FROM Offers".
					" WHERE Offers.id = $offerID";

		$result = mysqli_query($GLOBALS['db'],$query);
		if(!$result){
			echo 'false';
		} else {
			echo 'true';
		}
	}
	
	function getOfferInfo($ID){
		$ID = mysqli_real_escape_string($GLOBALS['db'], $ID);
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
		$getUserNameQuery = 'SELECT fname,lname, eid FROM Users WHERE eid = '.$iniRows[0]['userid'].';';

		$userResult = mysqli_query($GLOBALS['db'],$getUserNameQuery);

		if(!$userResult){
    		die('Query failed with the error: ' . mysqli_error($GLOBALS['db']) . '<br/><br/>Failing query: ' . $getUserNameQuery);
		}

		$userRows = array();
		while($r = mysqli_fetch_assoc($userResult)){
			$userRows[] = $r;
		}

		$author = $userRows[0]['fname'].' '.$userRows[0]['lname'];
		$eid = $userRows[0]['eid'];
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

		$arr = array( 'author_eid' => $eid, 'author'  => $author, 'name' => $name, 'description' => $description, 'time' => $time , 'picturePath' => $pic, 'category' => $category,'subcategory' =>  $subcategory, 'price' => $price );

		return $arr;
	}


	function buyItem($buyerID, $offerID){
		$offerID = mysqli_real_escape_string($GLOBALS['db'], $offerID);
		$buyerID = mysqli_real_escape_string($GLOBALS['db'], $buyerID);

		$offerQuery = 'SELECT id FROM FixedPriceOffers where offerid = '.$offerID.';';
		$offerResult = mysqli_query($GLOBALS['db'],$offerQuery);

		if(!$offerResult){
			die('Query failed with the error: ' . mysqli_error($GLOBALS['db']) . '<br/><br/>Failing query: ' . $offerQuery);			
		}
		$offerRows = Array();
		while($r = mysqli_fetch_assoc($offerResult)){
			$offerRows[] = $r;
		}

		$fpoID = $offerRows[0]['id'];

		$query = 'INSERT INTO FixedPriceBids (buyerid,fixedPriceOfferID,bidtime) VALUES('.$buyerID.','.$offerRows[0]['id'].', NOW());';

		$result = mysqli_query($GLOBALS['db'],$query);
		if(!$result){
			echo 'false';
		} else {
			echo 'true';
		}

	}

	function getOfferID($offerID){
		$offerID = mysqli_real_escape_string($GLOBALS['db'], $offerID);

		$query = 'SELECT id FROM FixedPriceOffers WHERE offerid ='.$offerID.';';
		$result = mysqli_query($GLOBALS['db'],$query);

		if(!$result){
			die('Query failed with the error: ' . mysqli_error($GLOBALS['db']) . '<br/><br/>Failing query: ' . $query);			
		}
		$rows = Array();
		while($r = mysqli_fetch_assoc($result)){
			$rows[] = $r;
		}

		$ret = $rows[0]['id'];
		return $ret;
	}

	function confirmBought($offerID, $buyerID){
		$offerID = mysqli_real_escape_string($GLOBALS['db'], $offerID);
		$buyerID = mysqli_real_escape_string($GLOBALS['db'], $buyerID);

		$fpoID = getOfferID($offerID);

		
		$query = 'SELECT buyerid FROM FixedPriceBids WHERE fixedPriceOfferID ='.$fpoID.';';

		$result = mysqli_query($GLOBALS['db'],$query);

		if(!$result){
			die('Query failed with the error: ' . mysqli_error($GLOBALS['db']) . '<br/><br/>Failing query: ' . $query);			
		}
		$rows = Array();
		while($r = mysqli_fetch_assoc($result)){
			$rows[] = $r;
		}

		foreach($rows as $row){
			if($row['buyerid']!=$buyerID){
				echo "send e-mail to the suckers / ";
			} else {
				echo "send e-mail to winner / ";
			}
		}

		$deleteQuery = 'DELETE FROM Offers WHERE id = '.$offerID.';';
		$delResult = mysqli_query($GLOBALS['db'],$deleteQuery);
		if(!$delResult){
			echo 'false';			
		} else {
			echo 'true';
		}
	}


	function allBuyers($offerID){
		$offerID = mysqli_real_escape_string($GLOBALS['db'], $offerID);

		$fixedPriceOfferID = getOfferID($offerID);

		$query = 'SELECT buyerid FROM FixedPriceBids WHERE fixedPriceOfferID ='.$fixedPriceOfferID.' ORDER BY bidtime ASC';

		$result = mysqli_query($GLOBALS['db'],$query);

		if(!$result){
			die('Query failed with the error: ' . mysqli_error($GLOBALS['db']) . '<br/><br/>Failing query: ' . $query);			
		}

		$rows = Array();
		while($r = mysqli_fetch_assoc($result)){
			$rows[] = $r;
		}
		$outArray = Array();

		foreach($rows as $row){
			$userQuery = 'SELECT fname, lname, eid FROM Users WHERE eid ='.$row['buyerid'].';';
			$userResult = mysqli_query($GLOBALS['db'],$userQuery);
			if(!$userResult){
				die('Query failed with the error: ' . mysqli_error($GLOBALS['db']) . '<br/><br/>Failing query: ' . $userQuery);			
			}
			$uRows = Array();
			while($r = mysqli_fetch_assoc($userResult)){
				$uRows[] = $r;
			}

			$outArray[] = $uRows;
		}

		return $outArray;
	}

	function recentOffers(){
		$query = 'SELECT FixedPriceOffers.price, Offers.picturePath, Offers.name, Offers.id
		FROM FixedPriceOffers, Offers
		WHERE Offers.id = FixedPriceOffers.offerid
		ORDER BY Offers.postTime DESC 
		LIMIT 6';

		$result = mysqli_query($GLOBALS['db'],$query);
		if(!$result){
			die('Query failed with the error: ' . mysqli_error($GLOBALS['db']) . '<br/><br/>Failing query: ' . $query);			
		}
		$rows = Array();
		while($r = mysqli_fetch_assoc($result)){
			$rows[] = $r;
		}

		return $rows;
	}

	function hotOffers(){
		$query = 'SELECT FixedPriceOffers.price, Offers.picturePath, Offers.name, Offers.id
		FROM FixedPriceOffers, Offers
		WHERE Offers.id = FixedPriceOffers.offerid
		LIMIT 4';

		$result = mysqli_query($GLOBALS['db'],$query);
		if(!$result){
			die('Query failed with the error: ' . mysqli_error($GLOBALS['db']) . '<br/><br/>Failing query: ' . $query);			
		}
		$rows = Array();
		while($r = mysqli_fetch_assoc($result)){
			$rows[] = $r;
		}

		return $rows;
	}



?>