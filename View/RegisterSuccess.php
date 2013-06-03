#!/usr/local/bin/php
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>getOut</title>
	<link href="../css/style.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="../lib/jquery-1.7.1.min.js"></script>
	<script type="text/javascript" src="../js/login_functions.js"></script>
</head>
<body>
<div class="rapidxwpr floatholder">
	<div id="header">
		<h1 id="title">getOut</h1>
		<div id="loginBox">
			<img id="closeLogin" src="../images/close.png" height="15" width="15">
			<form>
				<input type="text" id="username" class="loggin_input" value="username" onfocus="if (this.value == &#39;username&#39;) {this.value = &#39;&#39;;}" onblur="if (this.value == &#39;&#39;) {this.value = &#39;username&#39;;}" />
				<br />
				<input type="password" id="password" class="loggin_input" value="password" onfocus="if (this.value == &#39;password&#39;) {this.value = &#39;&#39;;}" onblur="if (this.value == &#39;&#39;) {this.value = &#39;password&#39;;}" />
				<br />
				<img id="loginLoading" class="hide" src="../images/loading.gif" />
				<p id="loginMsg">Login failed</p>
				<input type="button" id="loggin_submit" value="Log In" />
			</form>
		</div>
		
		<?php 
			include "../Model/WebUser.php";
			// Starting the session 
			session_start(); 
			if(isset($_SESSION['user'])) { 
				// Code for Logged members 
    			?><p id='accountLinks'><a href='MyAccount.php'>My Account</a> | <a href='../AppCode/Session.php?action=logout'>Log Out</a></p><?php
    		} 
			else { 
        		// Code for Guests 
    			?><p id='accountLinks'><a id='showLogIn' href='#'>Log In</a> | <a href='Register.php'>Register</a></p><?php
    		} 
		?> 
		<div id="topmenu">
			<ul>
			<li><a href="Events.php"><span><img class="ico" src="../images/event.png" height="20" width="20"></img>Events</span></a></li>
			<li><a href="Spots.php"><span><img class="ico" src="../images/spot.png" height="20" width="15"></img>Spots</span></a></li>
			<li><a href="Activities.php"><span><img class="ico" src="../images/activity.png" height="20" width="20"></img>Activities</span></a></li>
			<li><a class="active"><span>About</span></a></li>
			</ul>
		</div>
	</div>
	<div id="middle">
		<?php
			if (isset($_SESSION['user'])){
				header( 'Location: Events.php' ) ;
			}
		?>
		<h2>You have successfully registered!</h2> <h3>Use the login control on top right corner to log in!</h3> 
	</div>
</div>
<div class="rapidxwpr floatholder">
	<div id="footer" class="clearingfix">
		<ul class="footermenu">
			<li><a href="#">Events</a></li>
			<li><a href="#">Spots</a></li>
			<li><a href="#">Activities</a></li>
			<li><a href="#">About</a></li>
		</ul>
	</div>
</div>				
</body>
</html>