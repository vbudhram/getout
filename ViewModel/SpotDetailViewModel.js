var SpotDetailModel = function() {
    var self = this;
    var map;
    self.ID = ko.observable();
    self.NAME = ko.observable();
    self.LON = ko.observable();
    self.LAT = ko.observable();
    self.STATE = ko.observable();
    self.CITY = ko.observable();
    self.ZIP = ko.observable();
    self.STREET_ADDRESS = ko.observable();
    
 
    self.load = function(){
        var spotid = getParameterByName('spotid');
        
        $(document).ready(function(){
            $.get("../Model/Spot.php",{
                'action':'view',
                'spotid':spotid
            },function(result){ 
                var data = $.parseJSON(result);
            
                if(data!='{}'){
                    self.ID(data.SPOT_ID);
                    self.NAME(data.NAME);
                    self.LON(data['LOCATION.SDO_POINT.X']);
                    self.LAT(data['LOCATION.SDO_POINT.Y']);
                    self.STATE(data.STATE);
                    self.CITY(data.CITY);
                    self.ZIP(data.ZIP);
                    self.STREET_ADDRESS(data.STREET_ADDRESS);
                
                    self.spot = data;
                    self.updateMarkers();
                }
            });
        }); 
    };
    
    self.updateMarkers = function(){

        var clon = self.spot['LOCATION.SDO_POINT.X'];
        var clat = self.spot['LOCATION.SDO_POINT.Y'];
        var name = self.spot.NAME;

        var center = new google.maps.LatLng(clat, clon);
        
        map = new google.maps.Map(document.getElementById('spot-detail-map'), {
            mapTypeId: google.maps.MapTypeId.SATELLITE,
            center: center,
            zoom: 18
        });
                        
        var marker = new google.maps.Marker({
            position: center, 
            map: map,
            title: name
        });
            
    };
        
    self.load();
    
    function getParameterByName(name) {
        var match = RegExp('[?&]' + name + '=([^&]*)').exec(window.location.search);
        return match && decodeURIComponent(match[1].replace(/\+/g, ' '));
    }
}

ko.applyBindings(new SpotDetailModel());