<?php
	
	define( 'DB_USER', 'jtrade' );
  define( 'DB_PASS', 'WxjcXFRH' );
  define( 'DB_NAME', 'udb_jtrade' );
  define( 'DB_HOST', 'localhost' );

  define( 'TABLE_USER', 'Users' );

	dbConnect( DB_USER, DB_PASS, DB_NAME, DB_HOST );

	function dbConnect($user, $pass, $name, $host){

  	$mysqli = new mysqli($host, $user, $pass, $name);

    /* check connection */
    if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    }
  }

?>