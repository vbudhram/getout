<?php
    if(isset($_SESSION['user'])){
?>
<script language="Javascript">
    //gets the latlon of a user if they are logged in
    $(document).ready(function(){
        $('#lat').val(<?php echo $_SESSION['user']->getLat()?>);
        $('#lon').val(<?php echo $_SESSION['user']->getLon()?>);
    });
</script>
<?php
    }else {
?>
<script language="Javascript">
//determines latlon of guests
$(document).ready(function(){
    if (navigator.geolocation) 
    {
        console.log(navigator);
        navigator.geolocation.getCurrentPosition( 
            function (position) {  
                $('#lat').val(position.coords.latitude);
                $('#lon').val(position.coords.longitude);
            }, 
            // next function is the error callback
            // not sure where a default location should be if it fails to get broswer latlon
            function (error){
                $('#lat').val(28.5746343);
                $('#lon').val(-81.3365036);
            });
    } 
    else{
        // browser doesnt support geolocation api error
        // default if browser doesnt support latlon
        $('#lat').val(28.5746343);
        $('#lon').val(-81.3365036);
    }
});
</script>
<?php
    };
?>