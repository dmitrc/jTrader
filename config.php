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

  /**
   * Prints results of the query in a nice way with links to detail page.
   * @param  array $array  result of mysql query, converted to an array
   * @param  string $main   array of dictionary keys, to be displayed to a user (separated by spaces)
   * @param  string $aux    dictionary key, to be used as input GET parameter to the detail page script (primary key preferred)
   * @param  string $detail link to detail page script
   * @return void 
   */
  function printResults($array, $main, $aux, $detail) {
    if (count($array) == 0) {
        echo 'No results found... :(';
    }
    else {
      for ($i = 0; $i < count($array); $i = $i+1) {
          echo '<a href="'.$detail.'?'.$aux.'='.$array[$i][$aux].'">';

          for ($j = 0; $j < count($main); $j = $j+1) {
            echo $array[$i][$main[$j]];
            if ($j < count($main)-1) {
                echo ' ';
            }
          }

          echo '</a><br/>';
      }
    }
  }

  /**
   * Prints details of one object from the database
   * @param  array $array array with a single dictionary of desired object
   * @return void 
   */
  function printDetail($array) {
      $array = $array[0]; // Only one item should be returned
      $keys = array_keys($array);

      for ($i = 0; $i < count($keys); $i = $i+1) {
        echo '<b>'.$keys[$i].'</b>:   '.$array[$keys[$i]].'<br/>';
      }
  }

?>