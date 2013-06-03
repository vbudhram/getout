<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>getOut</title>
	<link href="../css/style.css" rel="stylesheet" type="text/css" />
	<link href="../css/themes/jquery-ui-1.8.18.overcast.css" rel="stylesheet" type="text/css"></link>
	<script src="../lib/jquery-1.7.1.min.js" type="text/javascript"></script>
	<script src="../lib/jqueryUI/jquery-ui-1.8.18.custom.js" type="text/javascript"></script>
	<script type="text/javascript" src="../lib/knockout-2.0.0.js"></script>
	<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>
</head>
<body>
<div class="rapidxwpr floatholder">
	<?php 
		$activePage="events";	include_once "Header.php"; 
		include_once "../Model/Event.php";
	?>
	<div id="middle">
		
		<a href="Events.php">Back To Events</a></br>
		<?php
			$eventId = $_REQUEST['eventId'];
			if ($eventId > 0)
			{?>
				<input type="hidden" id="eid" value="<?php echo($eventId); ?>"/>
				<h2>Event Details</h2>
				<div data-bind="with: EventDetails">
					<table cellpadding="20px" cellspacing="20px">
						<thead>
							<tr valign="middle">
								<th>What</th>
								<th>When</th>
								<th>Where</th>
							</tr>
						</thead>
						<tbody>
						<tr valign="top">
							<td>
								<table cellpadding="8px" cellspacing="8px">
									<tr><td><b>Activity: </b></td><td><span  data-bind="text: Activity"></span></td></tr>
									<tr><td><b>Average Skill: </b></td><td><span  data-bind="text: Skill"></span></td></tr>
									<tr><td><b>Team size: </b></td><td><span  data-bind="text: TeamSize"></span></td></tr>
									<tr><td><b>Organized By: </b></td><td><span  data-bind="text: CreatedByName"></span></td></tr>
									<tr><td><b>Created On: </b></td><td><span  data-bind="text: CreatedOn"></span></td></tr>
								</table>
							</td>
							<td>
								<table cellpadding="8px" cellspacing="8px">
									<tr><td><b data-bind="text: DOW"></b></td></tr>
									<tr><td><b data-bind="text: MonthAndDay"></b></td></tr>
									<tr><td><b>Start Time:</b></td><td><span  data-bind="text: StartsAt"></span></td></tr>
									<tr><td><b>End Time:</b></td><td><span  data-bind="text: EndsAt"></span></td></tr>
								</table>
							</td>
							<td>
								<table cellpadding="8px" cellspacing="8px">
									<tr><td><b data-bind="text: SpotName"></b></td></tr>
									<tr><td><span  data-bind="text: City"></span>&nbsp;&nbsp;<span  data-bind="text: State"></span>&nbsp;&nbsp;<span  data-bind="text: Zip"></span></td></tr>
									<tr><td>
                                                                                <div id="spotmap" style="width:300px;height: 300px"></div>
									</td>
									</tr>
								</table>
							</td>
						</tr>
						</tbody>
					</table>
				</div>

				<h2>Participant Information</h2>
				
				<table id="editTable">
					<thead>
						<tr>
							<th>
								<a href="#">Name</a>
							</th>
							<th>
								<a href="#">Participation Type</a>
							</th>
							<th>
								<a href="#">Skill </a>
							</th>
							<th>
								<a href="#">Opponent Skill Min</a>
							</th>
							<th>
								<a href="#">Opponent Skill Max</a>
							</th>
							<th>
								<a href="#">N Of Participations On Activity</a>
							</th>
							<th>
								<a href="#">N Of Participations In Spot</a>
							</th>
							<th>
								<a href="#">N Of Participations With User</a>
							</th>
							<th></th>
						</tr>
					</thead>
					<tbody data-bind="foreach: rows">
						<tr>
							<td data-bind="text: Name"></td>
							<td data-bind="text: TypeStr"></td>
							<td align="center" data-bind="text: Skill"></td>
							<td align="center" data-bind="text: SkillMin"></td>
							<td align="center" data-bind="text: SkillMax"></td>
							<td align="center" data-bind="text: ACount"></td>
							<td align="center" data-bind="text: SCount"></td>
							<td align="center" data-bind="text: SCount"></td>
						</tr>     
					</tbody>
				</table>
				<table>
				<tr>
					<td><?php if(isset($_SESSION['user'])) { ?>
						<div id="pType" class="hide">
							<b>Participation Type</b>
							<select id="ddlType">
								<option value="1">Participant</option>
								<option value="2">Observer</option>
							</select>
						</div>
					</td>
					<td>
						<?php	
							echo('<input id="join" class="submit hide" type="submit" value="Join" data-bind="click: join"/>');
							echo('<input id="unjoin" class="submit hide" type="submit" value="Unjoin" data-bind="click: unjoin"/>');	
						} 
						else { echo("<b>Register to join an event</b>"); }
						?>
					</td>
					<td>
						<div id="loading" class="hide left">
							<img id="loading" src="../images/loading.gif" />
							Loading...
						</div>
					</td>
				</tr>
			</table>
                                
                                <h2>Feedback</h2>
				
				<table id="editTable">
					<thead>
						<tr>
							<th>
								<a href="#">Rating</a>
							</th>
							<th>
								<a href="#">Comment</a>
							</th>
                                                    <th>
								<a href="#">Name </a>
							</th>
							<th>
								<a href="#">URI </a>
							</th>
						</tr>
					</thead>
					<tbody data-bind="foreach: feedbacks">
						<tr>
                                                        <td align="center" data-bind="text: RATING"></td>
							<td data-bind="text: COMMENT"></td>
                                                        <td data-bind="text: NAME"></td>
                                                        <td data-bind="text: URI"></td>
						</tr>     
					</tbody>
                                    
				</table>
                                <table>
                                    <tbody>
                                       <tr>
                                        <td>
                                            <?php if(isset($_SESSION['user'])) { ?>
                                            <input class="submit" value="Leave" type="submit" data-bind="click: leaveFeedback"/>
                                            <?php }?>
                                        </td>
                                    </tr> 
                                    </tbody>
                                </table>
			<?php } ?>
	</div>
	<script type="text/javascript" src="../ViewModel/EventDetailsViewModel.js"></script>
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