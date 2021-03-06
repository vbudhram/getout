#!/usr/local/bin/php
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>getOut</title>
	<link href="../css/style.css" rel="stylesheet" type="text/css" />
	<link href="../css/form.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="../js/registerForm.js"></script>
	<script type="text/javascript" src="../lib/jquery-1.7.1.min.js"></script>
	<script type="text/javascript" src="../js/login_functions.js"></script>
	<script type="text/javascript" src="../js/addressValidation.js"></script>
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
			<li><a href="About.php"><span>About</span></a></li>
			</ul>
		</div>
	</div>
	<div id="middle">
	<div id="container" >
		<!-- form post logic -->
		<div id="error">
			<?php				
				if(isset($_POST['submit'])){
					if ($_POST['email'] == '' || $_POST['firstname'] == '' ||
						$_POST['lastname'] == '' || $_POST['city'] == '' ||
						$_POST['state'] == '' || $_POST['zip'] == '' ||
						$_POST['lat'] == 'error' ||  $_POST['long'] == 'error' ||
						$_POST['password'] == ''){
						echo("Registration failed!. Please make sure you enter all the required information");
					}
					else{
						$newUser = WebUser::WithParams(
							0,
							$_POST['email'],
							$_POST['firstname'] . " " . $_POST['lastname'],
							$_POST['city'],
							$_POST['state'],
							$_POST['zip'],
							$_FILES['avatar']
						);
						
						$result = $newUser->Save($_POST['lat'], $_POST['long'], $_POST['password']);
						if(is_string($result)){
							echo("Error:".$result);
						}
						else
							header( 'Location: RegisterSuccess.php' );
					}
				}
			?>
		</div>
		<form method="post" action="Register.php" enctype="multipart/form-data">
			<header id="header" class="info">
				<h2>Registration</h2>
			</header>
			<ul>
				<li>
					<label class="desc">
						Name
						<span class="req">*</span>
					</label>
					<span>
						<input name="firstname" type="text" class="field text fn" size="15"/>
						<label>First</label>
					</span>
					<span>
						<input name="lastname" type="text" class="field text ln" value="" size="15"/>
						<label>Last</label>
					</span>
				</li>
				<li>
					<label class="desc">
						Address 
						<span id="addrReq" class="req">*</span>
						<img id="loading" class="hide" src="../images/loading.gif">
					</label>
					<div>
						<span class="addr1">
							<input name="address" type="text" class="field text addr large"/>
							<label>Street Address</label>
							</br>
						</span></br>
						<span class="city">
							<input name="city" type="text" class="field text addr"/>
							<label>City</label>
						</span>
						<span class="state">
							<input name="state" type="text" maxlength="2" class="field text addr small">
							<label>State</label>
						</span>
						<span class="zip">
							<input name="zip" type="text" class="field text addr medsmall" maxlength="5"/>
							<label>Zip Code</label>
						</span>
						<input name="lat" type="hidden"/>
						<input name="long" type="hidden"/>
					</div>
				</li>
				<li>
					<label class="desc">
						Email
						<span class="req">*</span>
					</label>
					<div>
						<input name="email" type="email" class="field text large" maxlength="50"/> 
					</div>
				</li>
				<li>
					<label class="desc">
						Password
						<span class="req">*</span>
					</label>
					<div>
						<input name="password" type="password" class="field text" maxlength="25"/> 
					</div>
				</li>
				<li>
					<label class="desc">
						Avartar
					</label>
					<div>
						<input name="avatar" type="file" class="field large"/> 
					</div>
				</li>
				<li>
					<div>
						</br>
						<input name="submit" class="submit" type="submit" value="Submit"/>
						<label>
							* Required fields must be entered to continue
						</label>
					</div>
				</li>
			</ul>
		</form> 
		</div>
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
