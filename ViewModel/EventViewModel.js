function resultItem(row)
{
	var self = this;
	self.Activity 		= row.ACTIVITYNAME;
	self.ActivityId 	= row.ACTIVITY_ID;
	self.Skill 			= row.AVERAGE_SKILL;
	self.CanJoin		= row.CANJOIN;
	self.City 			= row.CITY;
	self.CreatedById	= row.CREATED_BY;
	self.CreatedOn		= row.CREATED_ON;
	self.CreatedByName	= row.CREATOR;
	self.MonthAndDay	= row.EVENT_DAY;
	self.DOW 			= row.EVENT_DOW;
	self.EndsAt 		= row.EVENT_END_TIME;
	self.StartsAt 		= row.EVENT_START_TIME;
	self.Id 			= row.ID;
	self.Participants 	= row.PARTICIPANTS;
	self.SpotName 		= row.SPOTNAME;
	self.SpotId 		= row.SPOT_ID;
	self.State 			= row.STATE;
	self.TeamSize 		= row.TEAM_SIZE;
	self.Zip 			= row.ZIP;
	self.DetailsLink	= "EventDetails.php?eventId=" + self.Id;
}

function ViewModel()
{
	var self = this;
	self.rows = ko.observableArray([]);
	
	self.search = function(){
		$("#loading").show();
		$("#btnSearch").hide();
		$("#results").hide();
		$.post("../Controller/EventsController.php", $("#searchForm").serialize(), function(data){
			var mappedTasks = $.map(data, function(item) { return new resultItem(item) });
			self.rows(mappedTasks);
			}, "json");
		
		$("#loading").hide();
		$("#btnSearch").show();
		$("#results").show();
	}
	
	$("#btnSearch").click(function(e) {
		e.preventDefault();
		self.search();
	});
}

ko.applyBindings(new ViewModel());