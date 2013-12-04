<?php

	require_once(dirname(__FILE__).'/../config.php');

	function search($value){

		$catQuery = 'SELECT id,name,description,picturePath,postTime FROM Offers WHERE name LIKE \'%'.$value.'%\' OR description LIKE \'%'.$value.'%\' ORDER BY postTime DESC;';

		$catResult = mysqli_query($GLOBALS['db'],$catQuery);
		if(!$catResult){
			die('Query failed with the error: ' . mysqli_error($GLOBALS['db']) . '<br/><br/>Failing query: ' . $catQuery);			
		}
		$catRows = Array();
		while($r = mysqli_fetch_assoc($catResult)){
			$catRows[] = $r;
		}
		$outArray = Array();

		foreach($catRows as $row){
			$id = $row['id'];
			$pic = $row['picturePath'];
			$name = $row['name'];

			$query = 'SELECT FixedPriceOffers.price
			FROM FixedPriceOffers
			WHERE FixedPriceOffers.offerid ='.$row['id'].';';
			$result = mysqli_query($GLOBALS['db'],$query);
			if(!$result){
				die('Query failed with the error: ' . mysqli_error($GLOBALS['db']) . '<br/><br/>Failing query: ' . $query);			
			}
			$resRows = Array();
			while($r = mysqli_fetch_assoc($result)){
				$resRows[] = $r;
			}
			$price = $resRows[0]['price'];

			$arr = array( 'name' => $name, 'id' => $id, 'picturePath' => $pic,'price' => $price );

			$outArray[] = $arr;
		}

		echo json_encode($outArray);
	}
?>