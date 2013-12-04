<?php
	
	define( 'DB_USER', 'dcnkag' );
  define( 'DB_PASS', 'w95bGne620' );
  define( 'DB_NAME', 'jtrader' );
  define( 'DB_HOST', 'flanche.com' );

  define( 'TABLE_USER', 'Users' );

	$GLOBALS['db'] = dbConnect( DB_USER, DB_PASS, DB_NAME, DB_HOST );

	function dbConnect($user, $pass, $name, $host){

  	$db = mysqli_connect($host, $user, $pass, $name);
    
    /* check connection */
    if (mysqli_connect_errno()) {
        die("Connect failed: " . mysqli_connect_error());
    }

    return $db;
  }


  // move to utils.php, add a dot
  function saveBase64Image($data) {
    list($type, $data) = explode(';', $data);
    list(, $data) = explode(',', $data);
    list(, $type) = explode('/',$type);

    $data = base64_decode($data);  

    $now = date_create();

    $filename = date_timestamp_get($now).'.'.$type;
    $str = 'images/image' . $filename;

    if (file_put_contents(dirname(__FILE__).'/./'.$str, $data)) {
      echo $filename;
    } else {
      echo 'error';
    }

    return $filename;
  }
?>