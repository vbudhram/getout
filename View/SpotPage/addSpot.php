#!/usr/local/bin/php
<?php

	$connection = oci_connect($username = 'akushnir',
                          $password = 'password',
                          $connection_string = '//oracle.cise.ufl.edu/orcl');
	if (!$connection) {
    		$e = oci_error();
    		trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
	}

	 $IdSql = oci_parse($connection, "select count(*)as nRows from spot");
	 oci_execute($IdSql);
	 while(($row = oci_fetch_row($IdSql))) {
//	 var_dump($row);
	$id1 = $row[0];
	$id = (int)$id1 + 1;
 }

	if(isset($_POST['name'])) {
		$name = $_POST['name'];
//		$location = $_POST['loaction'];
		$city = $_POST['city'];
		$zipCode = $_POST['zipCode'];
		$state = $_POST['state'];
		$strAddress = $_POST['strAddress'];
		$sDate = $_POST['sDate'];
		$click = $_POST['click'];
		$str = $_POST['created_by'];
//echo $str;
		$created_by = (int)$str;
		

 		$statement = oci_parse($connection, "insert into testSpot(spot_Id, name, city, zip, state,streetAddress,created_on, created_by) values ($id,'$name','$city','$zipCode','$state','$strAddress',to_date('" . $sDate . "', 'DD:Mon:YY'),$created_by)");
		$r = oci_execute($statement);
		if($r ) {
//		echo "The spot you entered  has been successfully created!";
			header("Location: addSpot.php");
		}
		else{
			$error = oci_error($conn);
			echo "The spot can't be created." . $error['message'];

		}
	}
	oci_free_statement($IdSql);
	oci_free_statement($statement);
	oci_close($connection);
?>

<html>
<body >
<p style = "margin-left: 200px; font-size:20px"> Please complete the spot information below! </p>
<form method="post" action="addSpot.php"
style="width :350px; margin-top:50px;margin-left: 200px;
padding:20px 20px 20px 20px;
">
	<table cellpadding="5">
		<tr >
		<td>Name</td>
		<td> </td>
		<td><input type="text" name="name"></td>
		</tr>
		<tr>
		<td>City</td>
		<td> </td>
		<td><input type="text" name="city"></td>
		</tr>
		<tr>
		<td>Zip Code</td>
		<td> </td>
		<td><input type="text" name="zipCode"></td>
		</tr>
		<tr>
		<td>State</td>
		<td> </td>
		<td><input type="text" name="state"></td>
		</tr>
		<tr>
		<td>Street Address</td>
		<td> </td>
		<td><input type="text" name="strAddress"></td>
		</tr>
		<?php
			 date_default_timezone_set('UTC');
        		$d = date('j:M:y');
		?>
		<input type = "hidden" name = "sDate" value ="<?php echo $d ?>">
		<input type = "hidden" name = "created_by" value = "45">
<!--		<input type = "hidden" name = "loaction" value = "SDO_GEOMETRY(2001, 8307, SDO_POINT_TYPE(28.5746343, -81.336504, NULL), NULL, NULL)"> -->
		<input type = "hidden" name = "click" value = "1">

		<tr>
		<td> </td>
		<td> </td>
		<td><input type="submit" name="submit" value="Submit"></td>
		</tr>
	</table>
</form>
</body>
</html>

