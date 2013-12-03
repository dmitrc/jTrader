<?php
    include_once('user-model.php');

    if (isset($_POST['action'])) 
    {
      if (isset($_POST['args'])) 
      {
        call_user_func($_POST['action'], $_POST['args']);
      }
      else
      {
        call_user_func($_POST['action']);
      }
    }

?>