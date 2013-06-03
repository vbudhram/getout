<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>getOut</title>
	<link href="../css/style.css" rel="stylesheet" type="text/css" />
	<link href="../css/themes/jquery-ui-1.8.18.overcast.css" rel="stylesheet" type="text/css"></link>
	<script src="../lib/jquery-1.7.1.min.js" type="text/javascript"></script>
	<script src="../lib/jqueryUI/jquery-ui-1.8.18.custom.js" type="text/javascript"></script>
	<script>
	$(function() {
		$( "input:submit" ).button();
		$( "#txtDate" ).datepicker({ minDate: 0, maxDate: "+1Y", dateFormat: "mm/dd/y" });
	});
	</script>
</head>
<body>
<div class="rapidxwpr floatholder">
	<?php $activePage = "none";	include_once "Header.php" ?>
	<div id="error">
		<?php 
			if(isset($_POST['submit']))
			{
				include "../Model/Event.php";
				if ($_POST['userId'] == '' || 
					$_POST['activityId'] == '' ||
					$_POST['spotId'] == '' || 
					$_POST['eventDate'] == '' ||
					$_POST['eventHour'] == '' || 
					$_POST['eventDayHalf'] == '' ||
					$_POST['duration'] == '' ||
					$_POST['skill'] == '' ||
					$_POST['teamSize'] == '')
				{
					echo("Could not Create Event!. Please make sure you enter all the required information");
				}
				else
				{
					$newEvent = Event::WithParams(
						0, 
						$_POST['userId'], 
						$_POST['activityId'], 
						$_POST['spotId'],
						$_POST['eventDate']." ".$_POST['eventHour'].":".$_POST['eventMinute']." ".$_POST['eventDayHalf'],
						$_POST['duration'],
						$_POST['skill'], 
						$_POST['teamSize'], 
						null);
					
					$result = $newEvent->Save();
					if(is_string($result))
					{
						echo("Error:".$result);
					}
					else
					{
						echo("Event Created. Event Id: ".$newEvent->GetId());
					}
				}
			}
		?>
	</div>
	<div id="middle">
		<?php 
			if (isset($_SESSION['user'])){
			?>		<div id="create">
			<form method="post" action="CreateEvent.php" enctype="multipart/form-data">
				<input type="hidden" name="userId" value="<?php echo $_SESSION['user']->GetId() ?>"/>
				<table cellpadding="2" cellspacing="2">
					<tr>
						<td><label for="selActivity">Activity: </label></td>
								<td>
									<select id="selActivity" name="activityId" >
										<option selected="true" value="">-Select one-</option>
										<?php	
										include_once "../AppCode/ActivitySelect.php";
										echo (GenerateActivityOptions());
										?>
									</select>
								</td>
						<td>
							<label for="selSpot">Where: </label>
						</td>
                        <td>
							<select id="selSpot" name="spotId" >
                            	<option selected="true" value="">-Select one-</option>
                                	<?php	
                                    	include_once "../AppCode/SpotSelect.php";
                                        echo (GenerateSpotOptions(isset($_REQUEST['spotid']) ? $_REQUEST['spotid'] : -1));
                                    ?>
                            </select>
							<!-- <input type="text" id ="txtSpotId" name="spotId"/>-->
						</td>
				</tr>
				<tr>
					<td>
						<label>When:</label>
					</td>
					<td>
						<input type="text" id ="txtDate" name="eventDate" value="<?php echo date("m/d/y", time()); ?>"/>
						<br/>
						<select id="selEventHour"  name="eventHour">
							<option value="1">1</option>
							<option value="2">2</option>
							<option value="3">3</option>
							<option value="4">4</option>
							<option value="5">5</option>
							<option value="6" selected="true">6</option>
							<option value="7">7</option>
							<option value="8">8</option>
							<option value="9">9</option>
							<option value="10">10</option>
							<option value="11">11</option>
							<option value="12">12</option>
						</select>
						<label>:</label>
						<select id="selEventMinutes"  name="eventMinute">
							<option value="00" selected="true">00</option>
							<option value="15">15</option>
							<option value="30">30</option>
							<option value="45">45</option>
						</select>
						<select id="selEventHalf"  name="eventDayHalf">
							<option value="AM">AM</option>
							<option value="PM"  selected="true">PM</option>
						</select>
					</td>
					<td>
						<label>Duration:</label>
					</td>
					<td>
						<input type="text" id ="txtDuration" name="duration"/>
					</td>
				</tr>
				<tr>
					<td>
						<label>Skill Level (1-10):</label>
					</td>
					<td>
						<input type="text" id ="txtSkill" name="skill"/>
					</td>
					<td>
						<label>Participants:</label>
					</td>
					<td>
						<input type="text" id ="txtSize"  name="teamSize"/>
					</td>
				</tr>
				<tr>
					<td/>
					<td/>
					<td/>
					<td>
						<small>
							<input type="submit" id="btnCreateEvent" value="Create" name="submit" />
						</small>
					</td>
				</tr>
				</table>
			</form>
		</div><?php }?>
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