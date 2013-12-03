<?php
    require_once(dirname(__FILE__).'/./user.php');
    require_once(dirname(__FILE__).'/./mail.php');

    if (isset($_POST['action'])) 
    {
      if (isset($_POST['args'])) 
      {
        call_user_func_array($_POST['action'], $_POST['args']);
      }
      else
      {
        call_user_func($_POST['action']);
      }
    }

?>