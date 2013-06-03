<?php

include_once "WebUser.php";
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Feedback
 *
 * @author User
 */
class Feedback {

    private $id;
    private $created_by;
    private $name;
    private $created_on;
    private $event_id;
    private $uri;
    private $type;
    private $value;
    private $comment;

    public function __construct() {
        
    }

    public static function WithParams($id, $created_by, $created_on, $event_id, $uri, $type, $value) {
        $instance = new self();
        $instance->SetId($id);
        $instance->SetCreated_by($created_by);
        $instance->SetCreated_on($created_on);
        $instance->SetEvent_Id($event_id);
        $instance->SetUri($uri);
        $instance->SetType($type);
        $instance->SetValue($value);
        return $instance;
    }

    public function GetId() {
        return $this->id;
    }

    public function SetId($id) {
        $this->id = $id;
    }

    public function GetCreated_by() {
        return $this->created_by;
    }

    public function SetCreated_by($created_by) {
        $this->created_by = $created_by;
    }

    public function GetName() {
        return $this->name;
    }

    public function SetName($name) {
        $this->name = $name;
    }

    public function GetCreated_on() {
        return $this->created_on;
    }

    public function SetCreated_on($created_on) {
        $this->created_on = $created_on;
    }

    public function GetEvent_Id() {
        return $this->event_id;
    }

    public function SetEvent_Id($event_id) {
        $this->event_id = $event_id;
    }

    public function GetUri() {
        return $this->uri;
    }

    public function SetUri($uri) {
        $this->uri = $uri;
    }

    public function GetType() {
        return $this->type;
    }

    public function SetType($type) {
        $this->type = $type;
    }

    public function GetValue() {
        return $this->value;
    }

    public function SetValue($value) {
        $this->value = $value;
    }

    public function GetComment() {
        return $this->comment;
    }

    public function SetComment($comment) {
        $this->comment = $comment;
    }

    public static function Save($created_by, $event_id, $uri, $type, $value, $comment) {
        $stmt = "BEGIN FEEDBACK_INSERT('$created_by','$event_id','$uri','$type','$value','$comment',:i,:d); END;";
        $ba = array(
            new BindingVariable(':i', null, 5, 0),
            new BindingVariable(':d', null, 20, 0));

        $results = DBUtil::ExecuteProcedureNonQuery(null, $stmt, $ba);

        return $results;
    }

    public static function getAllFeedback($event_id) {
        $stmt = "BEGIN FEEDBACK_GETALL('$event_id',:RC); END;";

        $results = DBUtil::ExecuteProcedureQuery(null, $stmt);
        if (is_string($results))
            return "{}";
        
        echo json_encode($results);
    }

}

if (isset($_REQUEST['action'])) {
    if ($_REQUEST['action'] == 'getAllFeedback' && isset($_REQUEST['eventid'])) {

        session_start();

        echo(Feedback::getAllFeedback($_REQUEST['eventid']));
    } else if ($_REQUEST['action'] == 'insert') {

        session_start();

        if (isset($_SESSION['user']) && isset($_REQUEST['eventid'])) {

            $created_by = intval($_SESSION['user']->getId());
            $event_id = intval($_REQUEST['eventid']);
            $uri = NULL;
            $type = NULL;
            $value = NULL;
            $comment = NULL;

            //optional parameters
            if (isset($_REQUEST['uri']))
                $uri = $_REQUEST['uri'];

            if (isset($_REQUEST['type']))
                $type = $_REQUEST['type'];

            if (isset($_REQUEST['value']))
                $value = intval($_REQUEST['value']);

            if (isset($_REQUEST['comment']))
                $comment = $_REQUEST['comment'];

            $r = Feedback::Save($created_by, $event_id, $uri, $type, $value, $comment);
        } else {
            $r = "Session/Event Id is not set! Insert failed";
        }

        echo($r);
    } else if ($_REQUEST['action'] == 'view') {
        
    }
}
?>
