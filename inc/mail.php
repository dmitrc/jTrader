<?php
    require_once(dirname(__FILE__).'/./user.php');

    function sendRequestEmail($idTo, $offerid)
    {
        $eid = $_SESSION["user"]->eid;
        $from = $_SESSION["user"]->email;
        $name = $_SESSION["user"]->account;
        $subject = "jTrade Purchase Request";
        $to = '';
        $query = "SELECT email FROM Users WHERE id = $idTo;";
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
            $message = 'Dear user,\r\n\r\n'. $name .'would like to purchase the following item: '. $offerName .', which was posted at the price of '. $price .' Euro. Should you be interested in selling your item to this person, you are invited to reply to this email with your response and to remove your item from the jTrade website.\r\n\r\nAll the best,\r\n\r\nthe jTrade Team' ;

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



?>