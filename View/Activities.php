<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>getOut</title>
		<link href="../css/style.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="../lib/knockout-2.0.0.js"></script>
		<script type="text/javascript" src="../lib/jquery-1.7.1.min.js"></script>
		<script type="text/javascript" src="../js/login_functions.js"></script>
	</head>
	<body>
		<div class="rapidxwpr floatholder">
			<?php 
				$activePage="activities";	
				include_once "Header.php"; 
			?>
			<div id="middle">
				<div id="search" class="right">
					<input id="txtSearch" value="Search" type="text" onfocus="if (this.value == &#39;Search&#39;) {this.value = &#39;&#39;;}" onblur="if (this.value == &#39;&#39;) {this.value = &#39;Search&#39;;}" />
					<img id="iSearch" src="../images/search.png"/>
				</div>
				<div id="loading" class="hide left">
					<img id="loading" src="../images/loading.gif" />
					Loading...
				</div>
				<div class="clear"></div>
				<table id="editTable">
					<thead>
						<tr>
							<th>
								<a href="#" data-bind="click: sort.bind($data, 'NAME')">Name</a>
							</th>
							<th>
								<a href="#" data-bind="click: sort.bind($data, 'DESCRIPTION')">Desciption</a>
							</th>
							<th>
								<a href="#" data-bind="click: sort.bind($data, 'ACTIVEEVENTS')">No Of Active Events</a>
							</th>
							<th>
								<a href="#" data-bind="click: sort.bind($data, 'EVENTS')">No Of Total Events</a>
							</th>
							<th>
								<a href="#" data-bind="click: sort.bind($data, 'SPOTS')">No Of Kown Spots Available</a>
							</th>
							<th>
								<a href="#" data-bind="click: sort.bind($data, 'CREATED_TIME')">Created</a>
							</th>
							<th>
								<a href="#" data-bind="click: sort.bind($data, 'CREATED_BY')">Created By</a>
							</th>
							<th></th>
						</tr>
					</thead>
					<tbody data-bind="foreach: rows">
						<tr>
							<td>
								<input class="editName hide" type="text" />
								<?php 
									if (isset($_SESSION['user'])){
								?>
								<a href="#" data-bind="click: $root.showPref, text: NAME" class="activityName lblName" />
								<?php }  
									else{
								?>
								<label data-bind="text: NAME" class="lblName" />
								<?php } ?>
							</td>
							<td>
								<input class="editDesc hide" type="text" />
								<label class="lblDesc" data-bind="text: DESCRIPTION"/>
							</td>
							<td data-bind="text: ACTIVEEVENTS"></td>
							<td data-bind="text: EVENTS"></td>
							<td data-bind="text: SPOTS"></td>
							<td data-bind="text: CREATED_TIME"></td>
							<td data-bind="text: CREATED_BY"></td>
							<?php 
								if (isset($_SESSION['user'])){
							?>
							<td>
								<a class="edit" href="#">Edit</a>
								<a class="update hide" class="hide" href="#" data-bind="click: $root.update">Update</a>
							</td>
							<?php } ?>
						</tr>     
					</tbody>
					<?php 
						if (isset($_SESSION['user'])){
					?>
					<tfoot>
						<tr>
							<td><input id="name" type="text" /></td>
							<td><input id="description" type="text" /></td>
							<td></td><td></td><td></td><td></td><td></td>
							<td><a href="#" data-bind="click: add">Add</a></td>
						</tr>
					</tfoot>
					<?php } ?>
				</table>
				<button data-bind='click: $root.viewJSON'>view JSON</button>
				<div class="activitypreferences hide">
					<p>Activity Preferences</p>
					<img id="closePref" src="../images/close.png" height="15" width="15" data-bind="click: closePref" />
					<div class="clear"/>
					<input type="hidden" id="actID" /> 
					<table>
						<tr>
							<td>Desired Team Size:</td>
							<td><input id="teamsize"/></td>
						</tr>
						<tr>
							<td>Your Skill Level (1-10):</td>
							<td><input id="skilllevel"/></td>
						</tr>
						<tr>
							<td>Min Opponent Skill Level (1-10):</td>
							<td><input id="minoskilllevel"/></td>
						</tr>
						<tr>
							<td>Max Opponent Skill Level (1-10):</td>
							<td><input id="maxoskilllevel"/></td>
						</tr>
					</table>
					<div id="loadingPref" class="hide left">
						<img src="../images/loading.gif" />
						Saving...
					</div>
					<input type="button" id="savePref" value="Save" data-bind="click: savePref"/>
				</div>
				<script type="text/javascript" src="../ViewModel/ActivityViewModel.js"></script>
			</div>
		</div>	
		<div id="footer" class="clearingfix">
			<ul class="footermenu">
				<li><a href="#">Events</a></li>
				<li><a href="#">Spots</a></li>
				<li><a href="#">Activities</a></li>
				<li><a href="#">About</a></li>
			</ul>
		</div>		
	</body>
</html>