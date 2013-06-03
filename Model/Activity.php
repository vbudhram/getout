<?php 
	include "WebUser.php";
	
	class Activity
	{
		private $id;
		private $name;
		private $description;
		private $createdTime;
		private $createdBy;
		
		public function __construct() { }
		
		public static function WithRow($row){
			$instance = new self();
			$instance->LoadRow($row);
			return $instance;
		}
		
		public function GetId(){
			return $this->id;
		}
		
		public function SetId($id){
			$this->id = $id;
		}
		
		public function GetName(){
			return $this->name;
		}
		
		public function SetName($name){
			$this->name = $name;
		}
		
		public function GetDescription(){
			return $this->description;
		}
		
		public function SetDescription($description){
			$this->description = $description;
		}
		
		public function Save($createdBy){
			//prepare save statement
			$stmt = "BEGIN ACTIVITY_INSERT('$createdBy','$this->name','$this->description',:i,:c); END;";
			$ba = array(new BindingVariable(':i',0,5,0),new BindingVariable(':c',null,20,0));
			//execute save statement using DBUtil and return result
			$r = DBUtil::ExecuteProcedureNonQuery(null, $stmt, $ba);
			if ($r == 1){
				if(isset($_SESSION['user'])) { 
					$name = $_SESSION['user']->GetName();
				}	
				else{
					$name = 0;
				}
				$a = array("id" => $ba[0]->val, "created" => $ba[1]->val, "name" => $name);
				return json_encode($a);
			}
			else return $r;
		}
		
		public function Update(){
			//prepare save statement
			$stmt = "BEGIN ACTIVITY_UPDATE($this->id,'$this->name','$this->description'); END;";
			//execute save statement using DBUtil and return result
			return DBUtil::ExecuteProcedureNonQuery(null, $stmt);
		}
		
		public static function GetJSON($searchFor = null){
			$stmt = "BEGIN ACTIVITY_GET(:RC, '$searchFor'); END;";
			$results = DBUtil::ExecuteProcedureQuery(null, $stmt);
			if (is_string($results))
				return "{}";
			return json_encode($results);
		}
		
		private function LoadRow($row){
			$this->id = $row['ID'];
			$this->name = $row['NAME'];
			$this->description = $row['DESCRIPTION'];
		}
		
		public function __toString(){
        	return (string)$this->name;
    	}
	}
	 
	if ($_REQUEST['action'] == 'getJSON'){
		echo(Activity::GetJSON($_REQUEST['searchfor']));
	}
	
	else if ($_REQUEST['action'] == 'insert'){
		$obj = Activity::WithRow($_POST);
		session_start(); 
		if(isset($_SESSION['user'])) { 
			$r = $obj->Save($_SESSION['user']->GetId());
		}
		else {
			$r = "Session is not set! Insert failed";
		}

		echo($r);
	}
	
	else if ($_REQUEST['action'] == 'update'){
		$obj = Activity::WithRow($_POST);
		$r = $obj->Update();
		echo($r);
	}
	
	else if ($_REQUEST['action'] == 'loadPref'){
		session_start(); 
		if(isset($_SESSION['user'])) { 
			$activity_id = $_REQUEST["id"];
			$user_id = $_SESSION['user']->GetId();
			$stmt = "BEGIN USER_ACTIVITY_PREF_GET(:RC, $activity_id, $user_id); END;";
			$results = DBUtil::ExecuteProcedureQuery(null, $stmt);
			if (is_string($results)){
				$r = array("TEAM_SIZE" => "", "USER_SKILL_LEVEL" => "", "OPPONENT_SKILL_MIN" => "", "OPPONENT_SKILL_MAX" => "");
				echo "[".json_encode($r)."]";
			}
			else{ 
				echo json_encode($results);
			}
		}
	}
	
	else if ($_REQUEST['action'] == 'savePref'){
		session_start(); 
		if(isset($_SESSION['user'])) { 
			$user_id = $_SESSION['user']->GetId();
			$a_id = $_POST["ACTIVITY_ID"];
			$teamsize = $_POST["TEAM_SIZE"];
			$skill_level = $_POST["USER_SKILL_LEVEL"];
			$skill_min = $_POST["OPPONENT_SKILL_MIN"];
			$skill_max = $_POST["OPPONENT_SKILL_MAX"];
			$stmt = "BEGIN USER_ACTIVITY_PREF_SAVE($teamsize, $skill_level, $skill_min, $a_id, $user_id, $skill_max); END;";
			DBUtil::ExecuteProcedureNonQuery(null, $stmt);
		}
	}
	
	
?>