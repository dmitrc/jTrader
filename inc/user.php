<?php

	include_once(dirname(__FILE__).'/../config.php');

	class User {
		var $eid;
		var $employeetype;
		var $account;
		var $fname;
		var $lname;
		var $displayname;
		var $name;
		var $college;
		var $email;
		var $room; // to be parsed
		var $phone;
    }

		function writeToDb() 
        {
            $name = $_SESSION["user"]->accountname;

            $query = "SELECT name FROM Users WHERE name == $name;";
            $result = mysqli_query($GLOBALS['db'], $query);

            if (!$result) 
            {
                $eid = $_SESSION["user"]->eid;
                $fname = $_SESSION["user"]->fname;
                $lname = $_SESSION["user"]->lname;
                $college = $_SESSION["user"]->college;
                $roomPhone = $_POST['user']->phone;
                $roomNumber = $_POST['user']->room;
                $email = $_POST['description']->email;
                $rating = 0;

                $sql="INSERT INTO Users (eid, name, fname, lname, roomPhone, roomNumber, college, email, rating) VALUES ('$eid', '$name', '$fname', '$lname','$roomPhone '$roomNumber', '$college', '$email', '$rating')";
                echo '<div class = "text-muted"><small><em>' . $sql . '</em></small></div>';

                if (!mysqli_query($con,$sql))
                  {
                  die('<div class="lead text-danger"><strong>Error: </strong>' . mysqli_error($con) . '</div>');
                  }
                echo '<div class="lead text-success">New user has been added to the database.</div>';

                mysqli_close($con);
            }
		}
	}


	function login($username, $password) {

        error_reporting(0);
        $conn = ldap_connect("jacobs.jacobs-university.de",389);
        if (!ldap_bind($conn,$username."@jacobs.jacobs-university.de",$password)) {
            echo "false";
            return false;
        }

        $search = ldap_search($conn,"OU=active,OU=Users,OU=CampusNet,DC=jacobs,DC=jacobs-university,DC=de","sAMAccountName=".$username,array("displayname","mail","employeeid","company","samaccountname","employeetype","givenname","sn","name","cn","houseidentifier","extensionattribute2","extensionattribute3","extensionattribute5","roomInfo","telephonenumber","description","title","physicaldeliveryofficename","department","wwwhomepage","jpegphoto","deptInfo"),0,0);
        $r = ldap_get_entries($conn, $search);

        if (count($r) == 0) {
          echo "false";
          return false;
        }

        $user = new User();

        $user->eid = htmlentities(utf8_encode($r[0]['employeeid'][0]),ENT_COMPAT,'utf-8');
        $user->employeetype = htmlentities(utf8_encode($r[0]['company'][0]),ENT_COMPAT,'utf-8');
        $user->account = htmlentities(utf8_encode($r[0]['samaccountname'][0]),ENT_COMPAT,'utf-8');
        $user->attributes = htmlentities(utf8_encode($r[0]['employeetype'][0]),ENT_COMPAT,'utf-8');
        $user->fname = htmlentities(utf8_encode($r[0]['givenname'][0]),ENT_COMPAT,'utf-8');
        $user->lname = htmlentities(utf8_encode($r[0]['sn'][0]),ENT_COMPAT,'utf-8');
        $user->displayname = htmlentities(utf8_encode($r[0]['displayname'][0]),ENT_COMPAT,'utf-8');
        $user->name = htmlentities(utf8_encode($r[0]['name'][0]),ENT_COMPAT,'utf-8');
        $user->college = htmlentities(utf8_encode($r[0]['houseidentifier'][0]),ENT_COMPAT,'utf-8');
        $user->country = htmlentities(utf8_encode($r[0]['extensionattribute5'][0]),ENT_COMPAT,'utf-8');
        $user->email = htmlentities(utf8_encode($r[0]['mail'][0]),ENT_COMPAT,'utf-8');
        $user->phone = htmlentities(utf8_encode($r[0]['telephonenumber'][0]),ENT_COMPAT,'utf-8');
        $user->room = "XX999";

        $_SESSION["user"] = $user;
        $user->writeToDb();
        ldap_unbind($conn);
        error_reporting(4);

        return $user;
    }

    function logout() 
    {
    	session_destroy();
    }

    function isLoggedIn() 
    {
      if (isset($_SESSION))
      {
        echo $_SESSION["user"]->name;
      }
      else
      {
        echo "no";
      }
    }

?>