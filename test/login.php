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

            $search = ldap_search($conn,"OU=active,OU=Users,OU=CampusNet,DC=jacobs,DC=jacobs-university,DC=de","sAMAccountName=".$username,array("displayname","mail","employeeid","company","samaccountname","employeetype","givenname","sn","name","cn","houseidentifier","extensionattribute2","extensionattribute3","extensionattribute5","roomInfo","telephonenumber","description","title","physicaldeliveryofficename","department","wwwhomepage","jpegphoto","deptInfo"),0,0);
            $r = ldap_get_entries($conn, $search);

            if (count($r) == 0) {
              return "AuthData correct; Info lookup failed.";
            }

            // This will be reformatted as a beautiful map later on. Just for the display of purposes.

            $result = array(
          'eid'   => htmlentities(utf8_encode($r[0]['employeeid'][0]),ENT_COMPAT,'utf-8'),
          'employeetype'     => htmlentities(utf8_encode($r[0]['company'][0]),ENT_COMPAT,'utf-8'),
          'account'   => htmlentities(utf8_encode($r[0]['samaccountname'][0]),ENT_COMPAT,'utf-8'),
          'attributes'     => htmlentities(utf8_encode($r[0]['employeetype'][0]),ENT_COMPAT,'utf-8'),
          'fname'    => htmlentities(utf8_encode($r[0]['givenname'][0]),ENT_COMPAT,'utf-8'),
          'lname'     =>  htmlentities(utf8_encode($r[0]['sn'][0]),ENT_COMPAT,'utf-8'),
          'displayname'   => htmlentities(utf8_encode($r[0]['displayname'][0]),ENT_COMPAT,'utf-8'),
          'name'  => htmlentities(utf8_encode($r[0]['name'][0]),ENT_COMPAT,'utf-8'),
          'cn'   => htmlentities(utf8_encode($r[0]['cn'][0]),ENT_COMPAT,'utf-8'),
          'college'  => htmlentities(utf8_encode($r[0]['houseidentifier'][0]),ENT_COMPAT,'utf-8'),
          'majorinfo' => htmlentities(utf8_encode($r[0]['extensionattribute2'][0]),ENT_COMPAT,'utf-8'),
          'majorlong'  => htmlentities(utf8_encode($r[0]['extensionattribute3'][0]),ENT_COMPAT,'utf-8'),
          'country' => htmlentities(utf8_encode($r[0]['extensionattribute5'][0]),ENT_COMPAT,'utf-8'),
          'email'  => htmlentities(utf8_encode($r[0]['mail'][0]),ENT_COMPAT,'utf-8'),
          //'room'  => htmlentities(utf8_encode($r[0]['roomInfo'][0]),ENT_COMPAT,'utf-8'),
          'phone'   => htmlentities(utf8_encode($r[0]['telephonenumber'][0]),ENT_COMPAT,'utf-8'),
          'description'     => htmlentities(utf8_encode($r[0]['description'][0]),ENT_COMPAT,'utf-8'),
          //'title'  => htmlentities(utf8_encode($r[0]['title'][0]),ENT_COMPAT,'utf-8'),
          //'office'  => htmlentities(utf8_encode($r[0]['physicaldeliveryofficename'][0]),ENT_COMPAT,'utf-8'),
          //'department'  => htmlentities(utf8_encode($r[0]['department'][0]),ENT_COMPAT,'utf-8'),
          'www'  => htmlentities(utf8_encode($r[0]['wwwhomepage'][0]),ENT_COMPAT,'utf-8')
          //'photo'  => htmlentities(utf8_encode($r[0]['jpegphoto'][0]),ENT_COMPAT,'utf-8'),
          //'deptInfo'  => htmlentities(utf8_encode($r[0]['deptInfo'][0]),ENT_COMPAT,'utf-8')
              );

            ldap_unbind($conn);
            return $result;
        }
        
        return false;
    }
    
    function logout() {
        session_destroy();
    }
?>

<br/>
<form action="login.php" method="POST">
  <input type="text" name="username">
  <input type="password" name="password">
  <input type="submit"> 
</form>

<?php
      if (isset($_POST['username']) && isset($_POST['password'])) {
        $login = login($_POST['username'],$_POST['password']);
        if (!$login) {
          echo '<div style="color:red;">Login failed!</div>';
        }
        else {
          echo '<div style="color:green;">Login succeeded!</div>';
          var_export($login);
        }
      }
?>


</body>
</html>