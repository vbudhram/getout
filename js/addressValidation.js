$(document).ready(function () {
	$("input[type=submit]").attr("disabled", "disabled");

	$(".addr").focusout(function () {
		var address = $("input[name=address]").val();
		var city = $("input[name=city]").val();
		var state = $("input[name=state]").val();
		var zip = $("input[name=zip]").val();
		if (address != '' && city != '' && state != '' && zip != ''){
			$("#addrReq").text("*");
			$("#loading").show();
			address = address.replace(" ", "+");
			$.getJSON('http://getout.comlu.com/addressToCoordinate.php?address='+address+'&city='+city+'&state='+state+'&zip='+zip+'&&jsoncallback=?', function(data) {
				$("input[name=lat]").val(data['lat']);
				$("input[name=long]").val(data['long']);
				if (data['lat'] != 'error'){
					$('input[type="submit"]').removeAttr('disabled');
					$("#addrReq").text("*");
				}
				else{
					$("#addrReq").text("* Address entered is not valid!");
					$("input[type=submit]").attr("disabled", "disabled");
				}	
				$("#loading").hide();
			});
		}
	});
});