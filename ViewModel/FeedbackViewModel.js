var FeedbackViewModel = function() {
    var self = this;
    var eventid = getParameterByName('eventid');
    self.COMMENT = ko.observable();
    self.URI = ko.observable();
    
    self.load = function(){
        $('#rating').html(50);  
    }

    self.save = function(){
        var value = $( "#slider" ).slider( "option", "value" );
        var comment = $( "#commentBox").val();
        var uri = $("#uri").val();
        
        $.post("../Model/Feedback.php",{
            'action':'insert',
            'eventid':eventid,
            'comment':comment,
            'uri':uri,
            'value':value
        },function(data){ 
            var result = data;
            
            if(result==1){
                window.location="../View/EventDetails.php?eventId="+eventid;
            }else{
                $('#error').html(result);
            }
            
        });
    }
    
    self.cancel = function(){
        window.location="../View/EventDetails.php?eventId="+eventid;
    }
    
    function getParameterByName(name) {
        var match = RegExp('[?&]' + name + '=([^&]*)').exec(window.location.search);
        return match && decodeURIComponent(match[1].replace(/\+/g, ' '));
    }
    
    $( "#slider" ).slider({
        start: function(event, ui) {
        },value:50
    });
    
    $( "#slider" ).bind( "slide", function(event, ui) {
        var value = ui.value;
        $('#rating').html(value);
    });
    
    self.load();
}

ko.applyBindings(new FeedbackViewModel());