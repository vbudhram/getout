<div id="header">
	<script src="../js/login_functions.js" type="text/javascript"></script>
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
   			?><p id='accountLinks'><?php echo("Welcome ".$_SESSION['user']) ?> &nbsp;&nbsp;&nbsp;&nbsp; | <a href='MyAccount.php'>My Account</a> | <a href='../AppCode/Session.php?action=logout'>Log Out</a></p><?php
   		} 
		else { 
       		// Code for Guests 
   			?><p id='accountLinks'><a id='showLogIn' href='#'>Log In</a> | <a href='Register.php'>Register</a></p><?php
   		} 
	?> 
	
	<div id="topmenu">
		<ul>
		<li><a <?php if (isset($activePage) && $activePage == "events") {echo "class=\"active\"";} 
					else { echo "href=\"Events.php\""; }
		?>><span><img class="ico" src="../images/event.png" height="20" width="20"></img>Events</span></a></li>
		<li><a <?php if (isset($activePage) && $activePage == "spots") {echo "class=\"active\"";} 
					else { echo "href=\"Spots.php\""; }
		?>><span><img class="ico" src="../images/spot.png" height="20" width="15"></img>Spots</span></a></li>
		<li><a <?php if (isset($activePage) && $activePage == "activities") {echo "class=\"active\"";} 
					else { echo "href=\"Activities.php\""; }
		?>><span><img class="ico" src="../images/activity.png" height="20" width="20"></img>Activities</span></a></li>
		<li><a <?php if (isset($activePage) && $activePage == "about") {echo "class=\"active\"";} 
					else { echo "href=\"About.php\""; }
		?>><span>About</span></a></li>
		</ul>
	</div>
</div>
