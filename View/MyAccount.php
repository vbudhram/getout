<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>getOut</title>
        <link href="../css/style.css" rel="stylesheet" type="text/css" />
        <link href="../css/form.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="../lib/jquery-1.7.1.min.js"></script>
        <script type="text/javascript" src="../lib/knockout-2.0.0.js"></script>
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
                if (isset($_SESSION['user'])) {
                    // Code for Logged members 
                    ?><p id='accountLinks'><?php echo($_SESSION['user']) ?> | <a href='MyAccount.php'>My Account</a> | <a href='../AppCode/Session.php?action=logout'>Log Out</a></p><?php
                } else {
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
                <div id="messages">
                <?php
                    if (isset($_GET['update'])) {
                        if ($_GET['update']=='success') {
                            echo("Sucessfully Updated!");
                        }
                    }
                ?>
                </div>
                <div id="error">
                    <?php

                    if (isset($_POST['submit'])) {
                        if ($_POST['name'] == '' || $_POST['email']=='') {
                            echo("Update failed!. Please make sure you enter all the required information");
                        } else {
                            
                            //Need to make a clone of session object. Errors are persisting to session
                            $user = $_SESSION['user'];
                            
                            $orgName = $user->getName();
                            $orgEmail = $user->getEmail();
                            
                            $user->setName($_POST['name']);
                            $user->setEmail($_POST['email']);
                            
                            $result = $user->Update();
                            
                            if (is_string($result)) {
                                $user->setName($orgName);
                                $user->setEmail($orgEmail);
                                $_SESSION['user'] = $user;
                                echo("Error:" . $result);
                            }
                            else
                                $_SESSION['user'] = $user;
                                header('Location: MyAccount.php?update=success');
                        }
                    }

                    ?>
                
                </div>
                <form method="post" action="../View/MyAccount.php" enctype="multipart/form-data">
                    <header id="header" class="info">
                        <h2>My Account Settings</h2>
                    </header>
                    <ul>
                        <li>
                            <label class="desc">
                                Name
                                <span class="req">*</span>
                            </label>
                            <span>
                                <input name="name" class="field text fn" size="15" data-bind="value: NAME"/>
                            </span>
                        </li>
                                                <li>
                            <label class="desc">
                                Email
                                <span class="req">*</span>
                            </label>
                            <div>
                                <input name="email" type="email" class="field text large" maxlength="50" data-bind="value: EMAIL"/> 
                            </div>
                        </li>
                        <li>
                            <label class="desc">
                                Location
                            </label>
                            <div id="latlon">
                                <span>
                                    <input id="curlat" disabled="true" data-bind="value: LAT"/>
                                    <label>Latitude</label>
                                </span>
                                <span>
                                    <input id="curlon" disabled="true" data-bind="value: LON"/>
                                    <label>Longitude</label>
                                </span>
                            </div>
                        </li>
                        <li>
                            <a id="changeAddressLink" href="ChangeLocation.php">Change Location</a>
                        </li>
                        <li>
                            <a id="changePasswordLink" href="ChangePassword.php">Change Password</a>
                        </li>
                        <li>
                            <label class="desc">
                                Avatar
                            </label>
                            <div>
                                <input name="avatar" type="file" class="field large"/> 
                            </div>
                        </li>
                        <li>
                            <div>
                                </br>
                                <input name="submit" class="submit" type="submit" value="Save"/>
                                <label>
                                    * Required fields
                                </label>
                            </div>
                        </li>
                    </ul>
                    <script type="text/javascript" src="../ViewModel/MyAccountViewModel.js"></script>
                </form>
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