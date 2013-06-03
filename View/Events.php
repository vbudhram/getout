<!-- #!/usr/local/bin/php
-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>getOut</title>
	<link href="../css/style.css" rel="stylesheet" type="text/css" />
	<link href="../css/themes/jquery-ui-1.8.18.overcast.css" rel="stylesheet" type="text/css"></link>
	<script src="../lib/jquery-1.7.1.min.js" type="text/javascript"></script>
	<script src="../lib/jqueryUI/jquery-ui-1.8.18.custom.js" type="text/javascript"></script>
	<script type="text/javascript" src="../lib/knockout-2.0.0.js"></script>
	<script>
	$(function() {
		//$("#searchForm").submit(Search);
		
		$( "input:submit").button();

		var dates = $( "#txtDateFrom, #txtDateTo" ).datepicker({
			dateFormat: 'mm/dd/yy',
			onSelect: function( selectedDate ) {
				var option = this.id == "txtDateFrom" ? "minDate" : "maxDate",
					instance = $( this ).data( "datepicker" ),
					date = $.datepicker.parseDate(
						instance.settings.dateFormat ||
						$.datepicker._defaults.dateFormat,
						selectedDate, instance.settings );
				dates.not( this ).datepicker( "option", option, date );
			}
		});
	});

	</script>
</head>
<body>
<div class="rapidxwpr floatholder">
	<?php $activePage="events";	include_once "Header.php"; ?>
	<div>
		<?php
                    // Starting the session 
                    if (isset($_SESSION['user'])) {
                        ?>
                        <h5> Cannot find an event? <a href='CreateEvent.php'>Create One Here</a></h5>
                        <?php } ?> 
	</div>
	<div id="error">
	</div>
	<div id="middle">
	<form method="post" action="../Controller/EventsController.php" enctype="multipart/form-data" id="searchForm">
		<input type="hidden" name="action" value="search"/>
		<table>
			<tr>
				<td>
					<table cellpadding="2" cellspacing="2">
						<?php 
							if (isset($_SESSION['user']))
							{
							?><tr>
								<input type="hidden" name="userId" value="<?php echo $_SESSION['user']->GetId() ?>"/>
								<td><label for="txtDistance">Distance: </label></td>
							  	<td><input type="text" name="distance" id="txtDistance" size="6">
						  		<label for="chkMine">Organized by me</label>
						  		<input type="checkbox" value="1" id="chkMine" name="organizedByMe"/>
							  	</td>  
							</tr><?php 
							}
							?><tr>
								<td><label for="txtCity">City/State/Zip: </label></td>
								<td><input type="text" name="city" id="txtCity" size=20>/
								<input type="text" name="state" id="txtState" size="3" maxlength="2">/
								<input type="text" name="zip" id="txtZip" size="6" maxlength="5">
								<td><label for="selActivity">Activity: </label></td>
								<td>
									<select id="selActivity" name="activity" >
										<option selected="true" value="">Any</option><?php
										if (isset($_SESSION['user']))
										{?>
										<option value="0">Any of Mine</option>
										<?php	
										}
										include_once "../AppCode/ActivitySelect.php";
										echo (GenerateActivityOptions());
										?>
									</select>
								</td>
							</tr>
							<tr>
								<td><label for="txtDateFrom">Date Range: </label></td>
								<td><input type="text" name="dateFrom" id="txtDateFrom" size="11" maxlength="10"/> - <input type="text" name="dateTo" id="txtDateTo"  size="11" maxlength="10"/>
								</td>	
								<td><label for="selDOW">Day Of Week:</label></td>
								<td>
									<select id="selDOW" name="dow" >
										<option selected="true" value="">Any</option>
										<option value="Monday">Monday</option>
										<option value="Tuesday">Tuesday</option>
										<option value="Wednesday">Wednesday</option>
										<option value="Thursday">Thursday</option>
										<option value="Friday">Friday</option>
										<option value="Saturday">Saturday</option>
										<option value="Sunday">Sunday</option>
									</select>
								</td>
							</tr>
						</table>
					</td>
					<td valign="bottom" align="center">
						<div id="loading" class="hide">
							<img id="loading" src="../images/loading.gif" />
						</div>
						<small>
							<input type="submit" id="btnSearch" value="Search" name="submit" />
						</small>
					</td>
				</tr>
			</table>
		</form>
		<div id="results" class="hide">
		<table id="editTable">
			<thead>
				<tr>
					<th>When</th>
					<th>Start Time</th>
					<th>End Time</th>
					<th>Activity</th>
					<th>Team Size</th>
					<th>Avg. Skill</th>
					<th colspan="2">Where</th>
					<th>Participants</th>
					<th>Details</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: rows">
				<tr>
					<td><a data-bind=" text: MonthAndDay"/></td>
					<td><a data-bind=" text: StartsAt"/></td>
					<td><a data-bind=" text: EndsAt"/></td>
					<td><a data-bind=" text: Activity"/></td>
					<td><a data-bind=" text: TeamSize"/></td>
					<td><a data-bind=" text: Skill"/></td>
					<td><a data-bind=" text: SpotName"/></td>
					<td><a data-bind=" text: City"/></td>
					<td><a data-bind=" text: Participants"/></td>
					<td><a data-bind="attr: { href: DetailsLink}">Details</a></td>
				</tr>
			</tbody>
		</table>
		</div>
		<script src="../ViewModel/EventViewModel.js"></script>
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