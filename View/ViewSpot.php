<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>getOut</title>
        <link href="../css/style.css" rel="stylesheet" type="text/css" />
        <link href="../css/spot.css" rel="stylesheet" type="text/css" />
        <link href="../css/form.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="../lib/jquery-1.7.1.min.js"></script>
        <script type="text/javascript" src="../lib/knockout-2.0.0.js"></script>
        <script type="text/javascript" src="../js/login_functions.js"></script>
        <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>
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
                include "../Model/Spot.php";
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
                <div id="container" style="width:350px;float:left;" >
                    <form>
                        <header id="header" class="info">
                            <h2 data-bind="text: NAME"></h2>
                        </header>
                        <ul>
                            <li>
                                <label class="desc">
                                    Address 
                                    <img id="loading" class="hide" src="../images/loading.gif">
                                </label>
                                <div>
                                    <span class="addr1">
                                        <input name="address" type="text" class="field text addr large" disabled="true" data-bind="value: STREET_ADDRESS"/>
                                        <label>Street Address</label>
                                        </br>
                                    </span></br>
                                </div>
                                <span class="city">
                                    <input name="city" type="text" class="field text addr" disabled="true" data-bind="value: CITY"/>
                                    <label>City</label>
                                </span>
                                <span class="state">
                                    <input name="state" type="text" maxlength="2" class="field text addr small" disabled="true" data-bind="value: STATE">
                                        <label>State</label>
                                </span>
                                <span class="zip">
                                    <input name="zip" type="text" class="field text addr medsmall" maxlength="5" disabled="true" data-bind="value: ZIP"/>
                                    <label>Zip Code
                                    </label>
                                </span>
                            </li>
                            <li>
                                <label class="desc">
                                    Location
                                </label>
                                <div id="latlon">
                                    <span>
                                        <input disabled="true" data-bind="value: LAT"/>
                                        <label>Latitude</label>
                                    </span>
                                    <span>
                                        <input disabled="true" data-bind="value: LON"/>
                                        <label>Longitude</label>
                                    </span>
                                </div>
                            </li>
                        </ul>
                    </form>
                </div>
                <div id="spot-detail-map"></div>
                <div style="clear:both"/>
                
                <table>
                    <tbody>
                        <tr>
                            <th colspan="6">
                                <h4>Top Events</>
                            </th>
                        </tr>
                    </tbody>
                </table>
                <table>
                    <tbody>
                        <tr>
                            <th colspan="6">
                                <h4>Top Activities</>
                            </th>
                        </tr>
                    </tbody>
                </table>
                <table>
                    <tbody>
                        <tr>
                            <th colspan="6">
                                <h4>What people are saying near here</>
                            </th>
                        </tr>
                        <tr>
                            <th colspan="6">
                                <h6>Register to see!</>
                            </th>
                        </tr>
                    </tbody>
                </table>
                <script type="text/javascript" src="../ViewModel/SpotDetailViewModel.js"></script>
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
