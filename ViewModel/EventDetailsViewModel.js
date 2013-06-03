function EventParticipant(data){
	var self = this;
	self.Name 			= data.NAME;
	self.Type 			= data.PARTICIPATION_TYPE;
	self.Skill 			= data.USER_SKILL_LEVEL;
	self.SkillMin		= data.OPPONENT_SKILL_MIN;
	self.SkillMax 		= data.OPPONENT_SKILL_MAX;
	self.ACount			= data.A_COUNT;
	self.SCount 		= data.S_COUNT;
	self.TypeStr        = ko.computed(function() {
							if (this.Type == 1)
								return 'Participant';
							else return 'Observer';
						  }, this);
}

function EventDetailsViewModel(row)
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
	self.Lat			= row.LAT;
	self.Lon			= row.LON;
	self.DetailsLink	= "EventDetails.php?eventId=" + self.Id;
}

function feedback(data){
    var self = this;
    self.NAME = data.NAME;
    self.RATING = data.VALUE;
    self.COMMENT = data.COMMENT_TEXT;
    self.URI = data.URI;
}

function ViewModel(){
	var self = this;
	self.rows = ko.observableArray([]);
	self.EventDetails = ko.observable();
	self.feedbacks = ko.observableArray([]);
        
	self.load = function(){
		$("#loading").show();
		
		var id = $("#eid").val();

		
		$.getJSON('../Controller/EventsController.php?action=search&eventId='+id, function(eventDetails) {
			self.EventDetails(new EventDetailsViewModel(eventDetails[0]));
			self.updateMarkers(eventDetails[0].LAT,eventDetails[0].LON);
		});
		
		$.getJSON('../Model/EventDetail.php?action=getJSON&id='+id, function(allData) {
			var mappedTasks = $.map(allData, function(item) {return new EventParticipant(item)});
			self.rows(mappedTasks);
			$("#loading").hide();
		});
		
		var id = $("#eid").val();
		var obj = {ID:id};
		$.post("../Model/EventDetail.php?action=hasJoined", obj, function(data) {
			if (data == 1){
			    $("#pType").hide();
				$("#unjoin").show();
				$("#join").hide();
			}
			else if (data == 0){
				$("#pType").show();
				$("#unjoin").hide();
				$("#join").show();
			}
			else{
				alert("Error getting Data:"+data);
			}
		});
                
                self.getFeedbacks();
	}
	
	self.join = function() {
		var id = $("#eid").val();
		var type = $("#ddlType").val();
		var obj = {ID:id, TYPE:type};
		$("#loading").show();
		$.post("../Model/EventDetail.php?action=join", obj, function(data) {
			if (data == 1){
				self.load();
			}
			else{
				alert("Error Inserting Data:"+data);
				$("#loading").hide();
			}
		});
	}
	
	self.unjoin = function() {
		var id = $("#eid").val();
		var obj = {ID:id};
		$("#loading").show();
		$.post("../Model/EventDetail.php?action=unjoin", obj, function(data) {
			if (data == 1){
				self.load();
			}
			else{
				alert("Error Inserting Data:"+data);
				$("#loading").hide();
			}
		});
	}
	
	$(document).ready(function(){
        self.updateMarkers = function(lat,lon){

        	var center = new google.maps.LatLng(lat,lon);
	        
	        map = new google.maps.Map(document.getElementById('spotmap'), {
	                mapTypeId: google.maps.MapTypeId.SATELLITE,
	                center: center,
	                zoom: 16
	            });
	                        
	            var marker = new google.maps.Marker({
	                position: center, 
	                map: map,
	                title: self.EventDetails.SpotName
	            });
        };
    });
	
        self.getFeedbacks = function(){
            var id = $("#eid").val();
        
            $.get("../Model/Feedback.php",{
                'action':'getAllFeedback',
                'eventid': id
            },function(data){ 
                var result = $.parseJSON(data);
                var mappedTasks = $.map(result, function(item) {
                    return new feedback(item)
                });

                self.feedbacks(mappedTasks);
            });
        }
        
        self.leaveFeedback = function() {
            window.location="../View/Feedback.php?eventid="+$("#eid").val();
        }
        
	self.load();
}

ko.applyBindings(new ViewModel());