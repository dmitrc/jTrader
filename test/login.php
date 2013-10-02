<?php
    include_once('user.php');
?>

<html>
<body>

<br/>
<form action="login.php" method="POST">
  <input type="text" name="username">
  <input type="password" name="password">
  <input type="submit"> 
</form>

<?php
      if (isset($_POST['username']) && isset($_POST['password'])) {
        $user = login($_POST['username'],$_POST['password']);
        if (!$user) {
          echo '<div style="color:red;">Login failed!</div>';
        }
        else {
          echo '<div style="color:green;">Login succeeded!</div>';
          echo "<pre>"; 
          print_r($user); 
          echo "</pre>";
        }
      }
?>


</body>
</html>