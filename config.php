<?php
	
	define( 'DB_USER', 'jtrade' );
  define( 'DB_PASS', 'WxjcXFRH' );
  define( 'DB_NAME', 'udb_jtrade' );
  define( 'DB_HOST', 'localhost' );

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

?>