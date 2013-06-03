<?php

include "Util/DBUtil.php";

class WebUser {

    private $id;
    private $email;
    private $name;
    private $city;
    private $state;
    private $zip;
    private $avatar;
    private $lat;
    private $lon;
    private $last_access;

    public function __construct() {
        
    }

    public static function WithEmail($email) {
        $instance = new self();
        $instance->SetId(0);
        $instance->SetEmail($email);
        return $instance;
    }

    public static function WithParams($id, $email, $name, $city, $state, $zip, $avatar, $lat, $lon, $last_access) {
        $instance = new self();
        $instance->SetId($id);
        $instance->SetEmail($email);
        $instance->SetName($name);
        $instance->SetCity($city);
        $instance->SetState($state);
        $instance->SetZip($zip);
        $instance->SetAvatar($avatar);
        $instance->SetLat($lat);
        $instance->SetLon($lon);
        $instance->SetLast_access($last_access);
        return $instance;
    }

    public function GetId() {
        return $this->id;
    }

    public function SetId($id) {
        $this->id = $id;
    }

    public function GetEmail() {
        return $this->email;
    }

    public function SetEmail($email) {
        $this->email = $email;
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

    public function GetAvatar() {
        return $this->avatar;
    }

    public function SetAvatar($avatar) {
        $this->avatar = $avatar;
    }

    public function GetLat() {
        return $this->lat;
    }

    public function SetLat($lat) {
        $this->lat = $lat;
    }

    public function GetLon() {
        return $this->lon;
    }

    public function SetLon($lon) {
        $this->lon = $lon;
    }

    public function GetLast_access() {
        return $this->lon;
    }

    public function SetLast_access($last_access) {
        $this->last_access = $last_access;
    }

    public function getJSON() {
        $var = get_object_vars($this);
        foreach ($var as &$value) {
            if (is_object($value) && method_exists($value, 'getJsonData')) {
                $value = $value->getJsonData();
            }
        }
        return json_encode($var);
    }

    public function UpdatePassword($currPassword, $newPassword) {
        $currPasswordHash = $this->GenerateHash($currPassword);
        $newPasswordHash = $this->GenerateHash($newPassword);
        
        $stmt = "BEGIN WEBUSER_UPDATE_PASSWORD('$this->id','$currPasswordHash','$newPasswordHash'); END;";
        
        return DBUtil::ExecuteProcedureNonQuery(null, $stmt,$ba);
    }

    public function Update() {
        $stmt = "BEGIN WEBUSER_UPDATE('$this->id','$this->email','$this->name','$this->city','$this->zip','$this->state',null,'$this->lat','$this->lon'); END;";
        
        return DBUtil::ExecuteProcedureNonQuery(null, $stmt,$ba);
 
    }

    public function Save($lat, $long, $password) {
        //genate password hash
        $hash = WebUser::GenerateHash($password);
        //prepare save statement
        $stmt = "BEGIN WEBUSER_INSERT('$this->email','$hash','','$this->name','$this->city','$this->zip','$this->state',null,$lat,$long,:r,:c,:d); END;";
        $ba = array(new BindingVariable(':r', 0, 5, 0), new BindingVariable(':c', null, 20, 0), new BindingVariable(':d', null, 20, 0));
        //execute save statement using DBUtil and return result
        return DBUtil::ExecuteProcedureNonQuery(null, $stmt, $ba);
    }

    public static function Login($email, $password) {
        //genate password hash
        $hash = WebUser::GenerateHash($password);
        //prepare login statement
        $stmt = "BEGIN WEBUSER_LOGIN('$email','$hash',:i,:n,:c,:z,:s,:a,:la,:lo,:d,:r); END;";
        //prepare binding array
        $ba = array(new BindingVariable(':i', 0, 38, 0),
            new BindingVariable(':n', '', 25, 0),
            new BindingVariable(':c', '', 30, 0),
            new BindingVariable(':z', '', 5, 0),
            new BindingVariable(':s', '', 2, 0),
            new BindingVariable(':a', '', -1, 1),
            new BindingVariable(':la', 0.0, 100, 0),
            new BindingVariable(':lo', 0.0, 100, 0),
            new BindingVariable(':d', null, 20, 0),
            new BindingVariable(':r', null, 20, 0));

        //execute login statement using DBUtil
        DBUtil::ExecuteProcedureNonQuery(null, $stmt, $ba);
        //if login failed return null else create and return user
        if ($ba[0]->val == null)
            return null;
        else {
            return WebUser::WithParams($ba[0]->val, $email, $ba[1]->val, $ba[2]->val, $ba[4]->val, $ba[3]->val, $ba[5]->val, $ba[6]->val, $ba[7]->val, $ba[8]->val);
        }
    }

    private static function GenerateHash($plainText) {
        return substr(sha1($plainText), 0, 50);
    }

    public function __toString() {
        return (string) $this->name;
    }

}

?>
