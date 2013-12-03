<?php
    include_once('user-model.php');

    if (isset($_POST['action'])) 
    {  
      if ($_POST['action'] == 'login')
      {
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
      }
      else
      {
        echo '<div class="lead text-danger">Unrecognized action!</div>';
      }
      else if ($_POST['action'] == 'logout')
      {
        logout();
      }
      else
      {
        echo '<div class="lead text-danger">Unrecognized action!</div>';
      }
    }
    else
    {
      echo '<div class="lead text-danger">No action was specified!</div>';
    }

?>