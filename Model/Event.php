<?php 
	include_once "Util/DBUtil.php";
	
	class Event
	{
		private $_Id;
		public function GetId() { return $this->_Id; }
		public function SetId($Id) { $this->_Id = $Id; }
		
		private $_Creator;
		public function GetCreator() { return $this->_Creator; }
		public function SetCreator($Creator) { $this->_Creator = $Creator; }
		
		private $_Activity;
		public function GetActivity() { return $this->_Activity; }
		public function SetActivity($Activity) { $this->_Activity = $Activity; }

		private $_Spot;
		public function GetSpot() { return $this->_Spot; }
		public function SetSpot($Spot) { $this->_Spot = $Spot; }
		
		private $_EventDateTime;
		public function GetEventDateTime() { return $this->_EventDateTime; }
		public function SetEventDateTime($EventDateTime) { $this->_EventDateTime = $EventDateTime; }
		
		private $_Duration;
		public function GetDuration() { return $this->_Duration; }
		public function SetDuration($Duration) { $this->_Duration = $Duration; }
		
		private $_Skill;
		public function GetSkill() { return $this->_Skill; }
		public function SetSkill($Skill) { $this->_Skill = $Skill; }
		
		private $_TeamSize;
		public function GetTeamSize() { return $this->_TeamSize; }
		public function SetTeamSize($TeamSize) { $this->_TeamSize = $TeamSize; }
		
		private $_CreatedOn;
		public function GetCreatedOn() { return $this->_CreatedOn; }
		public function SetCreatedOn($CreatedOn) { $this->_CreatedOn = $CreatedOn; }
		
		private $_Error;
		public function GetError() { return $this->_Error; }
		
		
		public function __construct() { }
		
		
		public static function WithParams($id, $creator, $activity, $spot, $datetime, $duration, $skill, $teamsize, $createdOn)
		{
			$instance = new self();
			$instance->SetId($id);
			$instance->SetCreator($creator);
			$instance->SetActivity($activity);
			$instance->SetSpot($spot);
			$instance->SetEventDateTime($datetime);
			$instance->SetDuration($duration);
			$instance->SetSkill($skill);
			$instance->SetTeamSize($teamsize);
			return $instance;
		}
		
	
		public function Save(){

			$stmt = "BEGIN Event_Insert('$this->_EventDateTime','$this->_Duration','$this->_Skill','$this->_TeamSize','$this->_Creator','$this->_Activity','$this->_Spot', :i,:c); END;";
			$ba = array(
				new BindingVariable(':i',null,5,0),
				new BindingVariable(':c',null,20,0));

			$result = DBUtil::ExecuteProcedureNonQuery(null, $stmt, $ba);
			if($result == true)
			{
				$this->SetId($ba[0]->val);
				$this->SetCreatedOn($ba[1]->val);
				return $result;
			}
			else
			{
				$this->_Error = $result;
			}
		}
		
		
				
		public function __toString(){
        	return (string)$this->_Id;
    	}
    	
    	public static function Search(EventSearchRequest $req)
    	{
    		$stmt = "BEGIN Events_Search(:RC,". 
    			$req->GetEventId().",".
    			$req->GetUserId().",".
    			$req->GetDistance().",".
    			$req->GetCity().",".
    			$req->GetState().",".
    			$req->GetZip().",".
    			$req->GetBeginDate().",".
    			$req->GetEndDate().",".
    			$req->GetDOW().",".
    			$req->GetActivity().",".
    			$req->GetSpot().",".
    			$req->GetOrganizedByMe()."); END;";	
    		$results = DBUtil::ExecuteProcedureQuery(null, $stmt);
			if (is_string($results))
				return "{}";
			return json_encode($results);
    	}
		
		public static function GetById($id)
    	{
			$stmt = "BEGIN EVENT_GET_BY_ID(:RC, $id); END;";
			$results = DBUtil::ExecuteProcedureQuery(null, $stmt);
			if (is_string($results)){
				return $results;
			}
			else{
				$result = $results[0];
				return Event::WithParams($result["ID"], 
					$result["CREATOR"], 
					$result["ACTIVITY"], 
					$result["SPOT"], 
					$result["DATE_TIME"], 
					$result["DURATION"], 
					$result["AVERAGE_SKILL"], 
					$result["TEAM_SIZE"], 
					$result["CREATED_ON"]);
			}
		}
	}
?>
