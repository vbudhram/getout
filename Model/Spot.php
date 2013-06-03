<?php

include_once "WebUser.php";

class Spot {

    private $spot_id;
    private $name;
    private $city;
    private $state;
    private $zip;
    private $street_address;
    private $lat;
    private $lon;
    private $createdby;

    public function __construct() {
        
    }

    public static function WithParams($spot_id, $name, $city, $state, $zip, $street_address, $lat, $lon) {
        $instance = new self();
        $instance->SetSpot_Id($spot_id);
        $instance->SetName($name);
        $instance->SetCity($city);
        $instance->SetState($state);
        $instance->SetZip($zip);
        $instance->SetLat($lat);
        $instance->SetLon($lon);
        $instance->SetStreet_Address($street_address);
        return $instance;
    }

    public function GetSpot_Id() {
        return $this->spot_id;
    }

    public function SetSpot_Id($spot_id) {
        $this->spot_id = $spot_id;
    }

    public function GetName() {
        return $this->name;
    }

    public function SetName($name) {
        $this->name = $name;
    }

    public function GetCity() {
        return $this->city;
    }

    public function SetCity($city) {
        $this->city = $city;
    }

    public function GetState() {
        return $this->state;
    }

    public function SetState($state) {
        $this->state = $state;
    }

    public function GetZip() {
        return $this->zip;
    }

    public function SetZip($zip) {
        $this->zip = $zip;
    }

    public function GetLat() {
        return $this->lat;
    }

    public function SetLat($lat) {
        $this->lat = $lat;
    }

    public function GetLon() {
        return $this->lat;
    }

    public function SetLon($lon) {
        $this->lon = $lon;
    }

    public function GetStreet_Address() {
        return $this->street_address;
    }

    public function SetStreet_Address($street_address) {
        $this->street_address = $street_address;
    }

    public function GetCreatedby() {
        return $this->createdby;
    }

    public function SetCreatedby($createdby) {
        $this->createdby = $createdby;
    }

    public function __toString() {
        return (string) $this->name;
    }

    public function Save($createdBy) {
        //prepare save statement
        $stmt = "BEGIN SPOT_INSERT('$this->name','$this->city','$this->zip','$this->state','$this->lat','$this->lon','$this->street_address',$createdBy,:c,:i); END;";
        $ba = array(new BindingVariable(':c', null, 20, 0), new BindingVariable(':i', null, 20, 0));
        //execute save statement using DBUtil and return result
        $r = DBUtil::ExecuteProcedureNonQuery(null, $stmt, $ba);
        if ($r == 1) {
            if (isset($_SESSION['user'])) {
                //username not being set in session?? 
                $name = $_SESSION['user']->GetName();
            } else {
                $name = 0;
            }
            $a = array('createdby' => $ba[0]->val, 'id' => $ba[1]->val);
        }
        else
            return $r;
    }

    public static function getSpots($searchFor, $distance, $lat, $lon) {
        //prepare save statement
        //$sql = "BEGIN SPOT_GET('$searchFor',:RC); END;";
        //$user = $_SESSION['user'];
        $sql = "BEGIN SPOT_GET_WITHINDISTANCE('$searchFor','$distance','$lat','$lon',:RC); END;";
        //$ba = array(new BindingVariable(':rc', -1, OCI_B_CURSOR, true));
        //execute save statement using DBUtil and return result
        //return DBUtil::ExecuteProcedureNonQuery(null, $sql, $ba);
        //Not sure why I can not use the execute procedure method
        $conn = oci_connect(DBSettings::GetUsername(), DBSettings::GetPassword(), DBSettings::GetConnectionString());
        if (!$conn) {
            $e = oci_error();
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        $stid = oci_parse($conn, $sql);
        $refcur = oci_new_cursor($conn);
        oci_bind_by_name($stid, ':rc', $refcur, -1, OCI_B_CURSOR);
        oci_execute($stid);

        // Execute the returned REF CURSOR and fetch from it like a statement identifier
        oci_execute($refcur);

        $result = NULL;
        while ($row = oci_fetch_array($refcur, OCI_ASSOC)) {
            //$result[] = Spot::WithParams($row['SPOT_ID'], $row['NAME'], $row['CITY'], $row['STATE'], $row['ZIP'], $row['STREET_ADDRESS'], $row['LOCATION.SDO_POINT.Y'], $row['LOCATION.SDO_POINT.X']);
            $result[] = $row;
        }

        oci_free_statement($refcur);
        oci_free_statement($stid);
        oci_close($conn);

        if ($result == NULL)
            return "{}";

        echo json_encode($result);
    }

    public static function getSpot($id) {
        $stmt = "BEGIN SPOT_GET('$id',:RC); END;";
        $results = DBUtil::ExecuteProcedureQuery(null, $stmt);

        if (is_string($results))
            return "{}";
        return json_encode($results[0]);
    }

}

if (isset($_REQUEST['action'])) {
    if ($_REQUEST['action'] == 'getSpots') {
        session_start();
        echo(Spot::getSpots($_REQUEST['search'], $_REQUEST['distance'], $_REQUEST['lat'], $_REQUEST['lon']));
    } else if ($_REQUEST['action'] == 'insert') {
        $obj = Spot::WithRow($_POST);
        session_start();
        if (isset($_SESSION['user'])) {
            $r = $obj->Save($_SESSION['user']->GetId());
        } else {
            $r = "Session is not set! Insert failed";
        }
        echo($r);
    } else if($_REQUEST['action'] == 'view'){
        echo (Spot::getSpot($_REQUEST['spotid']));
    }
}
?>