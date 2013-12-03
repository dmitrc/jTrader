<?php

	include_once(dirname(__FILE__).'/../config.php');

	class User {
		var $eid;
		var $account;
		var $fname;
		var $lname;
		var $cn;
		var $college;
		var $major;
		var $country;
		var $email;
		var $room; // to be parsed
		var $phone;
		var $www;

		function writeToDb() {
			
		}
	}


	function login($username, $password) {

        error_reporting(0);

        $conn = ldap_connect("jacobs.jacobs-university.de",389);
        if (!ldap_bind($conn,$username."@jacobs.jacobs-university.de",$password)) {
            echo "false";
            return false;
        }

        $search = ldap_search($conn,"OU=active,OU=Users,OU=CampusNet,DC=jacobs,DC=jacobs-university,DC=de","sAMAccountName=".$username,array("displayname","mail","employeeid","company","samaccountname","employeetype","givenname","sn","name","cn","houseidentifier","extensionattribute2","extensionattribute3","extensionattribute5","roomInfo","telephonenumber","description","wwwhomepage","jpegphoto","deptInfo"),0,0);
        $r = ldap_get_entries($conn, $search);

        if (count($r) == 0) {
            echo "false";
            return false;
        }

        $user = new User();


        $user->eid = htmlentities(utf8_encode($r[0]['employeeid'][0]),ENT_COMPAT,'utf-8');
        $user->account = htmlentities(utf8_encode($r[0]['samaccountname'][0]),ENT_COMPAT,'utf-8');
        $user->fname = htmlentities(utf8_encode($r[0]['givenname'][0]),ENT_COMPAT,'utf-8');
        $user->lname = htmlentities(utf8_encode($r[0]['sn'][0]),ENT_COMPAT,'utf-8');
        $user->cn = htmlentities(utf8_encode($r[0]['cn'][0]),ENT_COMPAT,'utf-8');
        $user->college = htmlentities(utf8_encode($r[0]['houseidentifier'][0]),ENT_COMPAT,'utf-8');
        $user->major = htmlentities(utf8_encode($r[0]['extensionattribute3'][0]),ENT_COMPAT,'utf-8');
        $user->country = htmlentities(utf8_encode($r[0]['extensionattribute5'][0]),ENT_COMPAT,'utf-8');
        $user->email = htmlentities(utf8_encode($r[0]['mail'][0]),ENT_COMPAT,'utf-8');
        $user->phone = htmlentities(utf8_encode($r[0]['telephonenumber'][0]),ENT_COMPAT,'utf-8');
        $user->room = " ";

        $_SESSION["user"] = $user;
        $user->writeToDb();
        ldap_unbind($conn);

        echo $user->fname." ".$user->lname;

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
        echo "false";
      }
    }

?>