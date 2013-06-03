<?php

class EventSearchRequest
{
	private $_EventId;
	public function GetEventId() { return $this->NullIfEmpty($this->_EventId); }
	public function SetEventId($EventId) { $this->_EventId = $EventId; }
	
	private $_UserId;
	public function GetUserId() { return $this->NullIfEmpty($this->_UserId); }
	public function SetUserId($UserId) { $this->_UserId = $UserId; }
	
	private $_Distance;
	public function GetDistance() { return $this->NullIfEmpty($this->_Distance); }
	public function SetDistance($Distance) { $this->_Distance = $Distance; }
	
	private $_City;
	public function GetCity() { return $this->NullIfEmpty($this->_City, "'"); }
	public function SetCity($City) { $this->_City = $City; }
	
	private $_State;
	public function GetState() { return $this->NullIfEmpty($this->_State, "'"); }
	public function SetState($State) { $this->_State = $State; }
	
	private $_Zip;
	public function GetZip() { return $this->NullIfEmpty($this->_Zip, "'"); }
	public function SetZip($Zip) { $this->_Zip = $Zip; }
	
	private $_BeginDate;
	public function GetBeginDate() { return $this->formatDate($this->_BeginDate); }
	public function SetBeginDate($BeginDate) { $this->_BeginDate = $BeginDate; }
	
	private $_EndDate;
	public function GetEndDate() { return $this->formatDate($this->_EndDate); }
	public function SetEndDate($EndDate) { $this->_EndDate = $EndDate; }
	
	private $_DOW;
	public function GetDOW() { return $this->NullIfEmpty($this->_DOW, "'"); }
	public function SetDOW($DOW) { $this->_DOW = $DOW; }
	
	private $_Activity;
	public function GetActivity() { return $this->NullIfEmpty($this->_Activity); }
	public function SetActivity($Activity) { $this->_Activity = $Activity; }
	
	private $_Spot;
	public function GetSpot() { return $this->NullIfEmpty($this->_Spot); }
	public function SetSpot($Spot) { $this->_Spot = $Spot; }
	
	private $_OrganizedByMe;
	public function GetOrganizedByMe() { return $this->NullIfEmpty($this->_OrganizedByMe); }
	public function SetOrganizedByMe($OrganizedByMe) { $this->_OrganizedByMe = $OrganizedByMe; }
	
	private $_Participant;
	public function GetParticipant() { return $this->NullIfEmpty($this->_Participant); }
	public function SetParticipant($Participant) { $this->_Participant = $Participant; }
	
	private function NullIfEmpty($value, $wrapString = "")
	{
		
		return rtrim($value) == "" ? "null" : 
			$wrapString.$value.$wrapString;
	}
	
	private function formatDate($strDate)
	{
		if(rtrim($strDate)=="") { return "null";}
		
		$date = strtotime($strDate);
		return "To_Date('".date("m/d/y", $date)."', 'MM/DD/YY')";
	}
}

?>