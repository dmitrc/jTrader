<?php
    require_once(dirname(__FILE__).'/./user.php');

    function getEmail($offerid)
    {
    	$offerid = mysqli_real_escape_string($GLOBALS['db'], $offerid);

    	$query = "SELECT Users.email FROM Offers, Users WHERE Offers.id = $offerid AND Offers.userid = Users.eid;";
        $result = mysqli_query($GLOBALS['db'], $query);

        if ($result) 
        {
        	$r = mysqli_fetch_array($result);
        	return $r['email']; 
        }
        else
        {
        	echo 'false';
        }
    }

    function sendRequestEmail($offerid)
    {
        $offerid = mysqli_real_escape_string($GLOBALS['db'], $offerid);

        $eid = $_SESSION["user"]->eid;
        $from = $_SESSION["user"]->email;
        $name = $_SESSION["user"]->fname.' '.$_SESSION["user"]->lname;
        $subject = "jTrade Purchase Request";

        $url = 'http://dcode.tk/php/jtrade.php';

        $to = getEmail($offerid);

        $query = "SELECT Offers.name, FixedPriceOffers.price FROM Offers, FixedPriceOffers WHERE Offers.id = $offerid AND Offers.id = FixedPriceOffers.offerid;";
        $result = mysqli_query($GLOBALS['db'], $query);

        if ($result) 
        {
            $r = mysqli_fetch_array($result);
            
            $offerName = $r['name'];
            $price = $r['price'];
            $message = "Dear user,\r\n\r\n". $name ." would like to purchase the following item: ". $offerName .", which was posted at the price of ". $price ." Euro. Should you be interested in selling your item to this person, you are invited to contact this person and we kindly ask you to remove your item from the jTrade website.\r\n\r\All the best,\r\nyour jTrade Team." ;

            $data = array(
              'name' => $name, 
              'subject' => $subject,
              'message' => $message,
              'from' => $from,
              'to' => $to);

            $options = array(
                'http' => array(
                    'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                    'method'  => 'POST',
                    'content' => http_build_query($data),
                ),
            );
            $context  = stream_context_create($options);
            $result = file_get_contents($url, false, $context);

            var_dump($result);

            $query = "UPDATE Users SET rating=(rating+1) WHERE email = $to;";
            mysqli_query($GLOBALS['db'], $query);
        }
        else
        {
            echo 'false';
        }
    }

    function sendConfirmationEmail($idTo, $offerid)
    {
        $idTo = mysqli_real_escape_string($GLOBALS['db'], $idTo);
        $offerid = mysqli_real_escape_string($GLOBALS['db'], $offerid);

        $eid = $_SESSION["user"]->eid;
        $from = $_SESSION["user"]->email;
        $name = $_SESSION["user"]->fname.' '.$_SESSION["user"]->lname;
        $subject = "jTrade Transaction Request";
        $to = '';
        $query = "SELECT email FROM Users WHERE eid = $idTo;";
        $result = mysqli_query($GLOBALS['db'], $query);
        $url = 'http://dcode.tk/php/jtrade.php';

        if ($result) 
        {
            $r = mysqli_fetch_array($result);
            $to = $r['email'];
        }
        else
        {
            echo 'false';
        }

        $query = "SELECT Offers.name, FixedPriceOffers.price FROM Offers, FixedPriceOffers WHERE Offers.id = $offerid AND Offers.id = FixedPriceOffers.offerid;";
        $result = mysqli_query($GLOBALS['db'], $query);

        if ($result) 
        {
            $r = mysqli_fetch_array($result);
            
            $offerName = $r['name'];
            $price = $r['price'];
            $message = "Dear user,\r\n\r\n". $name ." would like to sell to you the following item: ". $offerName .", which was posted at the price of ". $price ." Euro. Should you be interested in buying this item, contact the seller for further details on how to finalize the transaction.\r\n\r\nAll the best,\r\n\r\nyour jTrade Team." ;

            $data = array(
              'name' => $name, 
              'subject' => $subject,
              'message' => $message,
              'from' => $from,
              'to' => $to);

            $options = array(
                'http' => array(
                    'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                    'method'  => 'POST',
                    'content' => http_build_query($data),
                ),
            );
            $context  = stream_context_create($options);
            $result = file_get_contents($url, false, $context);

            var_dump($result);

            $query = "UPDATE Users SET rating=(rating+1) WHERE $idTo = eid;";
            mysqli_query($GLOBALS['db'], $query);
        }
        else
        {
            echo 'false';
        }
    }

    function sendRejectionEmail($idTo, $offerid)
    {
        $idTo = mysqli_real_escape_string($GLOBALS['db'], $idTo);
        $offerid = mysqli_real_escape_string($GLOBALS['db'], $offerid);
        
        $eid = $_SESSION["user"]->eid;
        $from = $_SESSION["user"]->email;
        $name = $_SESSION["user"]->fname.' '.$_SESSION["user"]->lname;
        $subject = "jTrade Transaction Rejection";
        $to = '';
        $query = "SELECT email FROM Users WHERE eid = $idTo;";
        $result = mysqli_query($GLOBALS['db'], $query);
        $url = 'http://dcode.tk/php/jtrade.php';

        if ($result) 
        {
            $r = mysqli_fetch_array($result);
            $to = $r['email'];
        }
        else
        {
            echo 'false';
        }

        $query = "SELECT Offers.name, FixedPriceOffers.price FROM Offers, FixedPriceOffers WHERE Offers.id = $offerid AND Offers.id = FixedPriceOffers.offerid;";
        $result = mysqli_query($GLOBALS['db'], $query);

        if ($result) 
        {
            $r = mysqli_fetch_array($result);
            
            $offerName = $r['name'];
            $price = $r['price'];
            $message = "Dear user,\r\n\r\n". $name ." has removed or has already sold the following item: ". $offerName .", which was posted at the price of ". $price ." Euro. \r\n\r\nAll the best,\r\n\r\nyour jTrade Team." ;

            $data = array(
              'name' => $name, 
              'subject' => $subject,
              'message' => $message,
              'from' => $from,
              'to' => $to);

            $options = array(
                'http' => array(
                    'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                    'method'  => 'POST',
                    'content' => http_build_query($data),
                ),
            );
            $context  = stream_context_create($options);
            $result = file_get_contents($url, false, $context);

            var_dump($result);

            $query = "UPDATE Users SET rating=(rating+1) WHERE $idTo = eid;";
            mysqli_query($GLOBALS['db'], $query);
        }
        else
        {
            echo 'false';
        }
    }

?>