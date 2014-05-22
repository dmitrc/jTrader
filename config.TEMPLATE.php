<?php
	
	define( 'DB_USER', 'FILL-ME' );
  define( 'DB_PASS', 'FILL-ME' );
  define( 'DB_NAME', 'FILL-ME' );
  define( 'DB_HOST', 'FILL-ME' );

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

    $filename = 'image'.date_timestamp_get($now).'.'.$type;
    $str = 'images/' . $filename;

    if (file_put_contents(dirname(__FILE__).'/./'.$str, $data)) {
      return $filename;
    } else {
      return false;
    }
  }
?>
