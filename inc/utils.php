<?php

	require_once(dirname(__FILE__).'/../config.php');

	function search($value){
		$value = mysqli_real_escape_string($GLOBALS['db'], $value);


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

		return $outArray;
	}

	function searchByCat($value){
		$value = mysqli_real_escape_string($GLOBALS['db'], $value);

		$catQuery = 'SELECT id FROM Categories WHERE type LIKE \'%'.$value.'%\';';

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
			$query = 'SELECT id, picturePath, postTime,name FROM Offers WHERE catid = '.$row['id'].' ORDER BY postTime DESC;';
			$result = mysqli_query($GLOBALS['db'],$query);
			if(!$result){
				die('Query failed with the error: ' . mysqli_error($GLOBALS['db']) . '<br/><br/>Failing query: ' . $query);			
			}
			$resRows = Array();
			while($r = mysqli_fetch_assoc($result)){
				$resRows[] = $r;
			}
			foreach($resRows as $item){
				$id = $item['id'];
				$name = $item['name'];
				$pic = $item['picturePath'];

				$lq = 'SELECT FixedPriceOffers.price
				FROM FixedPriceOffers
				WHERE FixedPriceOffers.offerid ='.$item['id'].';';
				$res = mysqli_query($GLOBALS['db'],$lq);
				if(!$res){
					die('Query failed with the error: ' . mysqli_error($GLOBALS['db']) . '<br/><br/>Failing query: ' . $lq);			
				}
				$resRows = Array();
				while($r = mysqli_fetch_assoc($res)){
					$resRows[] = $r;
				}
				$price = $resRows[0]['price'];

				$arr = array( 'name' => $name, 'id' => $id, 'picturePath' => $pic,'price' => $price );
				$outArray[] = $arr;
			}
		}
		return $outArray;
	}

	function searchBySubCat($value){
		
		$value = mysqli_real_escape_string($GLOBALS['db'], $value);

		$catQuery = 'SELECT id FROM Categories WHERE subtype LIKE \'%'.$value.'%\';';

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
			$query = 'SELECT id, picturePath, postTime,name FROM Offers WHERE catid = '.$row['id'].' ORDER BY postTime DESC;';
			$result = mysqli_query($GLOBALS['db'],$query);
			if(!$result){
				die('Query failed with the error: ' . mysqli_error($GLOBALS['db']) . '<br/><br/>Failing query: ' . $query);			
			}
			$resRows = Array();
			while($r = mysqli_fetch_assoc($result)){
				$resRows[] = $r;
			}
			foreach($resRows as $item){
				$id = $item['id'];
				$name = $item['name'];
				$pic = $item['picturePath'];

				$lq = 'SELECT FixedPriceOffers.price
				FROM FixedPriceOffers
				WHERE FixedPriceOffers.offerid ='.$item['id'].';';
				$res = mysqli_query($GLOBALS['db'],$lq);
				if(!$res){
					die('Query failed with the error: ' . mysqli_error($GLOBALS['db']) . '<br/><br/>Failing query: ' . $lq);			
				}
				$resRows = Array();
				while($r = mysqli_fetch_assoc($res)){
					$resRows[] = $r;
				}
				$price = $resRows[0]['price'];

				$arr = array( 'name' => $name, 'id' => $id, 'picturePath' => $pic,'price' => $price );
				$outArray[] = $arr;
			}
		}
		return $outArray;
	}
?>