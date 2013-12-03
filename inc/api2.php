<?php
    include_once('user-model.php');

    if (isset($_POST['action'])) 
    {
      if ($_POST['action'] == 'login') 
      {
        if (isset($_POST['args'])
          && sizeof($_POST['args']) == 2)
        {
          $user = login($_POST['args']);
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

        else if ($_POST['action'] == 'logout')
        {
          logout();
        }

        else if ($_POST['action'] == 'isLoggedIn')
        {
          if (isLoggedIn())
          {
            echo $_SESSION["user"]->name;
          }
          else
          {
            echo "<no>";
          }
        }

        else
        {
          echo '<div class="lead text-danger">Unrecognized arguments for login action!</div>'; 
        }
      }
      else 
      {
        echo '<div class="lead text-danger">Unrecognized action!</div>';
      }
    }

?>