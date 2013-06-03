var MyAccountModel = function() {
    var self = this;
    self.ID = ko.observable();
    self.EMAIL = ko.observable();
    self.NAME = ko.observable();
    self.LAST_ACCESSED_ON = ko.observable();
    self.LAT = ko.observable();
    self.LON = ko.observable();

    self.load = function(){
        $.get("../AppCode/Session.php",{
            'action':'getUserJSON'
        },function(data){ 
            var result = $.parseJSON(data);
            
            self.ID(result.id);
            self.EMAIL(result.email);
            self.NAME(result.name);
            self.LAST_ACCESSED_ON(result.last_access);
            self.LAT(result.lat);
            self.LON(result.lon);
        });
    };
  
    self.load();
}

ko.applyBindings(new MyAccountModel());