<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>getOut</title>
        <link href="../css/style.css" rel="stylesheet" type="text/css" />
        <link href="../css/spot.css" rel="stylesheet" type="text/css" />
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

                include "../AppCode/Location.php";

                if (isset($_SESSION['user'])) {
                    // Code for Logged members 
                    ?><p id='accountLinks'><?php echo($_SESSION['user']) ?> | <a href='MyAccount.php'>My Account</a> | <a href='../AppCode/Session.php?action=logout'>Log Out</a></p><?php
            } else {
                // Code for Guests 
                    ?><p id='accountLinks'><a id='showLogIn' href='#'>Log In</a> | <a href='Register.php'>Register</a></p><?php
            }
                ?>
                <input type="hidden" id="lat"/>
                <input type="hidden" id="lon"/>
                <div id="topmenu">
                    <ul>
                        <li><a href="Events.php"><span><img class="ico" src="../images/event.png" height="20" width="20"></img>Events</span></a></li>
                        <li><a class="active"><span><img class="ico" src="../images/spot.png" height="20" width="15"></img>Spots</span></a></li>
                        <li><a href="Activities.php"><span><img class="ico" src="../images/activity.png" height="20" width="20"></img>Activities</span></a></li>
                        <li><a href="About.php"><span>About</span></a></li>
                    </ul>
                </div>
            </div>
            <div id="middle">
                <div id="spots-search">
                    <div id="search" class="right">
                        <input id="txtSearch" value="Search" type="text" onfocus="if (this.value == &#39;Search&#39;) {this.value = &#39;&#39;;}" onblur="if (this.value == &#39;&#39;) {this.value = &#39;Search&#39;;}" />
                        <img id="iSearch" src="../images/search.png"/>
                        <select id="distanceSelector" name="distance" >
                            <option selected="true" value="99999">Any</option>
                            <option value="1">1 Miles</option>
                            <option value="5">5 Miles</option>
                            <option value="10">10 Miles</option>
                            <option value="15">15 Miles</option>
                            <option value="25">25 Miles</option>
                            <option value="50">50 Miles</option>
                            <option value="100">100 Miles</option>
                        </select>
                    </div>

                    <div class="spots-search-title">
                        <h1>Spots</h1>
                        <?php
                        // Starting the session 
                        if (isset($_SESSION['user'])) {
                            ?>
                            <h5> Know a spot? <a href='../View/CreateSpot.php'>Click to Create One</a></h5>
                            <?php
                        } else {
                            ?>
                            <h5> Know a spot? Log In to create one</h5>
                            <?php
                        }
                        // Code for Guests 
                        ?> 
                    </div>
                </div>

                <div id="error" class="right"></div>

                <div style="clear:both;"/>

                <div id="search-results">
                    <div id="no-results" >No Results Found!</div>
                    <table id="result-table" data-bind="foreach: spots">
                        <tbody>
                            <tr data-bind="click: $parent.selectSpot" id="spot-title-row">
                                <th colspan="2">
                                    <h4 class="spot-result-count" data-bind="text: COUNT"/>
                                </th>
                                <th colspan="4">
                                    <h4 class="spot-result-title" data-bind="text: NAME"/>
                                </th>
                            </tr>
                            <tr>
                                <td colspan="2"/>
                                <td colspan="4">
                                    <h5 class="spot-result-desc" data-bind="text: STREET_ADDRESS"/>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2"/>
                                <td colspan="2">
                                    <h5 class="spot-result-desc" data-bind="text: CITY"/>
                                </td>
                                <td>
                                    <h5 class="spot-result-desc" data-bind="text: STATE"/>
                                </td>
                                <td>
                                    <h5 class="spot-result-desc" data-bind="text: ZIP"/>
                                </td>
                                <tr/>
                        </tbody>
                    </table>
                </div>


                <div id="map"></div>

                <script type="text/javascript" src="../ViewModel/SpotViewModel.js"></script>

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
