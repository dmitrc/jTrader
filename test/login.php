<html>
<body>

<?php

    function login($username, $password) {
        if (($username == "admin") && (user::admin(sha1(md5($password))))) {
            $_SESSION["user"] = "admin";
            return true;
        } else {
            $conn = ldap_connect("jacobs.jacobs-university.de",389);
            if (!ldap_bind($conn,$username."@jacobs.jacobs-university.de",$password)) {
                return false;
            }

            $_SESSION["user"] = $username;

            ldap_unbind($conn);
            return true;
        }
        
        return false;
    }
    
    function logout() {
        session_destroy();
    }


    if (isset($_POST['username']) && isset($_POST['password'])) {
    if (!login($_POST['username'],$_POST['password'])) {
       echo "Seems invalid!";
     }
     else {
        echo "Seems valid!";
     }
   }

?>

<br/>
<form action="login.php" method="POST">
  <input type="text" name="username">
  <input type="password" name="password">
  <input type="submit"> 
</form>


</body>
</html>