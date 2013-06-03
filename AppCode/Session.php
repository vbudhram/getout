<?php
	include "../Model/WebUser.php";
	// Starting the session 
	session_start(); 
	if ($_REQUEST['action'] == "logout"){
		unset($_SESSION['user']);
		header("Location: ../View/Events.php");
	}
	
	else if ($_REQUEST['action'] == "login"){		
		if((isset($_POST['username']) && isset($_POST['password']))) {
			$email = $_POST['username'];
			$pw = $_POST['password'];
			//try to login user
			$user = WebUser::Login($email, $pw);
			if ($user == null)
				echo("false");
			else {
				$_SESSION['user'] = $user; 
				echo("true");
			}
		}
		else{
			echo("false");
		}
	}
        else if ($_REQUEST['action'] == "getUserJSON"){
             if(isset($_SESSION['user'])){  
                 $result = $_SESSION['user']->getJSON();
                 echo $result;
             }
        }
?>