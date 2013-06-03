function spot(data){
    var self = this;
    self.ID = data.SPOT_ID;
    self.COUNT = data.COUNT;
    self.NAME = data.NAME;
    self.LON = data['LOCATION.SDO_POINT.X'];
    self.LAT = data['LOCATION.SDO_POINT.Y'];
    self.STATE = data.STATE;
    self.CITY = data.CITY;
    self.ZIP = data.ZIP;
    self.STREET_ADDRESS = data.STREET_ADDRESS;
    self.CREATED_BY = data.CREATED_BY;
}

var SpotModel = function() {
    var self = this;
    var map;
    self.spots = ko.observableArray([]);
    
    var lastOpenedInfoWindow;
 
    self.load = function(){
        $(document).ready(function(){
            self.search('',99999,0,0);
        });
    }
    
    $(document).ready(function(){
        self.search = function(searchFor,distance,lat,lon){

            $.get("../Model/Spot.php",{
                'action':'getSpots',
                'search':searchFor,
                'distance': distance,
                'lat' : lat,
                'lon' : lon
            },function(data){ 
                var result = $.parseJSON(data);
                var count = 0;
                var mappedTasks = $.map(result, function(item, count) {
                    item.COUNT = String.fromCharCode('A'.charCodeAt() + count)+'.';
                    count++;
                    return new spot(item)
                });
                
                if(mappedTasks.length>0){
                    $('#no-results').hide();
                }else{
                    $('#no-results').show();
                }
                self.spots(mappedTasks);
            
                self.updateMarkers(mappedTasks);
            });
        
        }
    })
    
    self.selectSpot = function(spot){
        new google.maps.event.trigger(spot.marker,'click');
    }
    
    $(document).ready(function(){
        self.updateMarkers = function(spots){
            
            var clat = $('#lat').val();
            var clon = $('#lon').val();

            var center = new google.maps.LatLng(clat, clon);
        
            map = new google.maps.Map(document.getElementById('map'), {
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                center: center,
                zoom: 12
            });

            var i;
            for(i=0;i<spots.length;i++)
            {
                var lon = spots[i]['LON'];
                var lat = spots[i]['LAT'];
                var name = spots[i]['NAME'];
                        
                var latlng = new google.maps.LatLng(lat,lon);
                //console.log(latlng);
                        
                var marker = new google.maps.Marker({
                    position: latlng, 
                    map: map,
                    title: name
                });
               
                //Two way reference
                spots[i].marker = marker;
                marker.spot = spots[i];
                
                attachSpotInfoWindow(marker);
            }
        };
    });
    
    function attachSpotInfoWindow(marker) {
        google.maps.event.addListener(marker, 'click', function() {
            
            //Need to figure a way to get content of info window
            var message = "<h1>"+marker.spot.NAME+"</h1></br><h4>Options:</h4><a href='ViewSpot.php?spotid="+marker.spot.ID+"'>More Details</a><br/><a href='CreateEvent.php?spotid="+marker.spot.ID+"'>Create Event</a>";   
            var infowindow = new google.maps.InfoWindow(
            {
                content: message,
                size: new google.maps.Size(50,50)
            });
            
            marker.infowindow = infowindow;
            
            infowindow.open(map,marker);
            
            //Closes last opened infowindow
            if(lastOpenedInfoWindow!=null){
                lastOpenedInfoWindow.close();
            }
            //updated last opened
            lastOpenedInfoWindow = marker.infowindow;
            
            map.setZoom(13);
            map.setCenter(marker.position);
        });
    }
    
    $("#txtSearch").keypress(function(e) {
        if ( e.which == 13 ) {
            var searchFor = $("#txtSearch").val();
            if (searchFor != 'Search'){
                var distance = $('#distanceSelector').val();
                var lat = $('#lat').val();
                var lon = $('#lon').val();
                self.search(searchFor,distance,lat,lon);
            }
        }
    });
        
    self.load();
}

ko.applyBindings(new SpotModel());