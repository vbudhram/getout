function row(data){
	var self = this;
	self.ID = data.ID;
	self.NAME = data.NAME;
	self.DESCRIPTION = data.DESCRIPTION;
	self.ACTIVEEVENTS = data.ACTIVEEVENTS;
	self.EVENTS = data.EVENTS;
	self.SPOTS = data.SPOTS;
	self.CREATED_TIME = data.CREATED_TIME;
	self.CREATED_BY = data.CREATED_BY;
}

function ViewModel() {
    var self = this;
	var pos;
	
	self.sortColumn = "";
	self.rows = ko.observableArray([]);
	
	self.load = function(data){
		$("#loading").show();
		$.getJSON('../Model/Activity.php?action=getJSON&searchfor='+data, function(allData) {
			var mappedTasks = $.map(allData, function(item) { return new row(item) });
			self.rows(mappedTasks);
			$("#loading").hide();
		});
	}
	
	self.add = function() {
		var name = $("#name").val();
		var desc = $("#description").val();
		var obj = {ID:0, NAME:name, DESCRIPTION:desc, ACTIVEEVENTS:0, EVENTS:0, SPOTS:0, CREATED_TIME:0, CREATED_BY:0};
		$("#loading").show();
		$.post("../Model/Activity.php?action=insert", obj, function(data) {
			try{
				data = $.parseJSON(data);
				if (data.id){
					obj.ID = data.id;
					obj.CREATED_TIME = data.created;
					obj.CREATED_BY = data.name;
					self.rows.push(new row(obj));
					$("#name").val("");
					$("#description").val("");
				}
			}
			catch(e){
				alert("Error Inserting Data:"+data);
			}
			$("#loading").hide();
		});
	}
	
	self.update = function(e) {
		var i = self.rows.indexOf(e) + 1;
		var table = $("#editTable");
		var row = $('tr:eq(' + i + ')', table);
		
		var editname = row.find(".editName");
		var lblname = row.find(".lblName");
		var editdesc = row.find(".editDesc");
		var lbldesc = row.find(".lblDesc");
		
		var n = editname.val();
		var d = editdesc.val();
		e.NAME = n;
		e.DESCRIPTION = d;
		lblname.text(n);
		lbldesc.text(d);
		
		$("#loading").show();
		$.post("../Model/Activity.php?action=update", e, function(data) {
			if (data == 1){
				editname.hide();
				lblname.show();
				editdesc.hide();
				lbldesc.show();
				row.find(".edit").show();
				row.find(".update").hide();
			}
			else 
				alert("Error Inserting Data:"+data);
			
			$("#loading").hide();
		});
	}
	
	self.sort = function(data) {
		if (data == self.sortColumn){
			self.sortColumn = "";
			self.rows.reverse();
		}
		else{
			self.sortColumn = data;
			self.rows.sort(function(a, b) {
				var compA = a[data].toUpperCase();
				var compB = b[data].toUpperCase();
				return (compA < compB) ? -1 : (compA > compB) ? 1 : 0;
			});
		}
	}
	
	self.viewJSON = function() {
		alert(ko.toJSON(self.rows));
	}
	
	$("#iSearch").click(function() {
		var searchFor = $("#txtSearch").val();
		if (searchFor != 'Search'){
			self.load(searchFor);
		}
	});
	
	$("#txtSearch").keypress(function(e) {
		if ( e.which == 13 ) {
			var searchFor = $("#txtSearch").val();
			if (searchFor != 'Search'){
				self.load(searchFor);
			}
		}
	});
	
	$(".edit").live("click", function() {
		var row = $(this).parent().parent();
		var editname = row.find(".editName");
		var lblname = row.find(".lblName");
		var editdesc = row.find(".editDesc");
		var lbldesc = row.find(".lblDesc");
		
		editname.val(lblname.text());
		editname.show();
		lblname.hide();
		editdesc.val(lbldesc.text());
		editdesc.show();
		lbldesc.hide();
		
		row.find(".edit").hide();
		row.find(".update").show();
	});
	
	$(".activityName").live("click", function() {
		pos = $(this).position().top;
	});
	 
	self.showPref = function(e) {
		$("#loading").show();
		$.get("../Model/Activity.php?action=loadPref&id="+e.ID, function(data) {
			var pref = $.parseJSON(data);
			
			$("#actID").val(e.ID);
			$("#teamsize").val(pref[0].TEAM_SIZE);
			$("#skilllevel").val(pref[0].USER_SKILL_LEVEL);
			$("#minoskilllevel").val(pref[0].OPPONENT_SKILL_MIN);
			$("#maxoskilllevel").val(pref[0].OPPONENT_SKILL_MAX);
			
			var div = $(".activitypreferences");
			div.css('top', pos);
			div.show();
			$("#loading").hide();
		});
	}
	
	self.closePref = function(e) {
		var div = $(".activitypreferences");
		div.hide();
	}
	
	self.savePref = function() {
		$("#loadingPref").show();
		var id = $("#actID").val();
		var teamsize = $("#teamsize").val();
		var skilllevel = $("#skilllevel").val();
		var minoskilllevel = $("#minoskilllevel").val();
		var maxoskilllevel = $("#maxoskilllevel").val();
		var obj = 
		{
			ACTIVITY_ID:id, TEAM_SIZE:teamsize, USER_SKILL_LEVEL:skilllevel, OPPONENT_SKILL_MIN:minoskilllevel, OPPONENT_SKILL_MAX:maxoskilllevel
		};
		
		$.post("../Model/Activity.php?action=savePref", obj, function() {
			$("#loadingPref").hide();
			$(".activitypreferences").hide();
		});
	}

	self.load('');
}

ko.applyBindings(new ViewModel());