
<?php 
	include_once "WebUser.php";
	
	class EventDetail
	{
		public static function GetJSON($eventId){
			$stmt = "BEGIN EVENT_PARTICIPANTS_GET(:RC, '$eventId'); END;";
			$results = DBUtil::ExecuteProcedureQuery(null, $stmt);
			if (is_string($results))
				return "{}";
			return json_encode($results);
		}
		
		public static function Join($eventId, $userId, $type){
			$stmt = "BEGIN EVENT_PARTICIPANTS_INSERT($userId, '$eventId', $type); END;";
			$results = DBUtil::ExecuteProcedureNonQuery(null, $stmt);
			if (is_string($results))
				return $results;
			return true;
		}
		
		public static function Unjoin($eventId, $userId){
			$stmt = "BEGIN EVENT_PARTICIPANTS_DELETE($userId, '$eventId'); END;";
			$results = DBUtil::ExecuteProcedureNonQuery(null, $stmt);
			if (is_string($results))
				return $results;
			return true;
		}
		
		public static function HasJoined($eventId, $userId){
			$stmt = "BEGIN EVENT_PARTICIPANTS_HASJOINED($userId, '$eventId', :i); END;";
			$ba = array(new BindingVariable(':i',0,5,0));
			$results = DBUtil::ExecuteProcedureNonQuery(null, $stmt, $ba);
			if (is_string($results))
				return $results;
			return $ba[0]->val;
		}
	}
	 
	if ($_REQUEST['action'] == 'getJSON'){
		echo(EventDetail::GetJSON($_REQUEST['id']));
	}
	
	else if ($_REQUEST['action'] == 'join'){
		session_start(); 
		if(isset($_SESSION['user'])) { 
			$eid = $_POST["ID"];
			$type = $_POST["TYPE"];
			$uid = $_SESSION['user']->GetId();
			echo(EventDetail::Join($eid, $uid, $type));
		}
	}
	
	else if ($_REQUEST['action'] == 'unjoin'){
		session_start(); 
		if(isset($_SESSION['user'])) { 
			$eid = $_POST["ID"];
			$uid = $_SESSION['user']->GetId();
			echo(EventDetail::Unjoin($eid, $uid));
		}
	}
	
	else if ($_REQUEST['action'] == 'hasJoined'){
		session_start(); 
		if(isset($_SESSION['user'])) { 
			$eid = $_POST["ID"];
			$r = EventDetail::HasJoined($eid, $_SESSION['user']->GetId());
			echo($r);
		}
	}
?>