<?php
    include_once('user-model.php');

    if (isset($_POST['username']) && isset($_POST['password'])) {
      $user = login($_POST['username'],$_POST['password']);
      if (!$user) {
        echo '<div class="lead text-danger">Login failed!</div>';
      }
      else {
        echo '<div class="lead text-success">Login succeeded!</div>';
        echo "<pre>"; 
        print_r($user); 
        echo "</pre>";
      }
    }
?>