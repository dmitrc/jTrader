<?php

	include_once(dirname(__FILE__).'/../config.php');

	class User {
		var $eid;
		var $employeetype;
		var $account;
		var $attributes;
		var $fname;
		var $lname;
		var $displayname;
		var $name;
		var $cn;
		var $college;
		var $majorinfo;
		var $majorlong;
		var $country;
		var $email;
		var $room; // to be parsed
		var $phone;
		var $description;
		var $www;

		function writeToDb() {
			
		}
	}


	function login($username, $password) {

        $conn = ldap_connect("jacobs.jacobs-university.de",389);
        if (!ldap_bind($conn,$username."@jacobs.jacobs-university.de",$password)) {
            echo "no";
            return false;
        }

        $search = ldap_search($conn,"OU=active,OU=Users,OU=CampusNet,DC=jacobs,DC=jacobs-university,DC=de","sAMAccountName=".$username,array("displayname","mail","employeeid","company","samaccountname","employeetype","givenname","sn","name","cn","houseidentifier","extensionattribute2","extensionattribute3","extensionattribute5","roomInfo","telephonenumber","description","wwwhomepage","jpegphoto","deptInfo"),0,0);
        $r = ldap_get_entries($conn, $search);

        if (count($r) == 0) {
            echo "no";
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
        $user->cn = htmlentities(utf8_encode($r[0]['cn'][0]),ENT_COMPAT,'utf-8');
        $user->college = htmlentities(utf8_encode($r[0]['houseidentifier'][0]),ENT_COMPAT,'utf-8');
        $user->majorinfo = htmlentities(utf8_encode($r[0]['extensionattribute2'][0]),ENT_COMPAT,'utf-8');
        $user->majorlong = htmlentities(utf8_encode($r[0]['extensionattribute3'][0]),ENT_COMPAT,'utf-8');
        $user->country = htmlentities(utf8_encode($r[0]['extensionattribute5'][0]),ENT_COMPAT,'utf-8');
        $user->email = htmlentities(utf8_encode($r[0]['mail'][0]),ENT_COMPAT,'utf-8');
        $user->phone = htmlentities(utf8_encode($r[0]['telephonenumber'][0]),ENT_COMPAT,'utf-8');
        $user->description = htmlentities(utf8_encode($r[0]['description'][0]),ENT_COMPAT,'utf-8');
        $user->www = htmlentities(utf8_encode($r[0]['wwwhomepage'][0]),ENT_COMPAT,'utf-8');
        $user->room = " ";

        $_SESSION["user"] = $user;
        $user->writeToDb();
        ldap_unbind($conn);

        echo $user->fname." ".$user->lname;
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
        echo "<no>";
      }
    }

?>