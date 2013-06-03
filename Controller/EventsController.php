<?php
	include "../Model/WebUser.php";
	include "../Model/Event.php";
	include "../Model/EventSearch.php";

	
if($_REQUEST['action'] == "search")
{
	$req = new EventSearchRequest();
	session_start();
	
	if (isset($_REQUEST['eventId']))
	{

		$req->SetEventId($_REQUEST['eventId']);	
	}
	else 
	{
		if(isset($_SESSION['user']))
		{
			$req->SetUserId($_SESSION['user']->GetId());
			$req->SetDistance($_REQUEST['distance']);
		}
		$req->SetActivity($_REQUEST['activity']);
		$req->SetCity($_REQUEST['city']);
		$req->SetState($_REQUEST['state']);
		$req->SetZip($_REQUEST['zip']);
		$req->SetBeginDate($_REQUEST['dateFrom']);
		$req->SetEndDate($_REQUEST['dateTo']);
		$req->SetDOW($_REQUEST["dow"]);
				
		if(isset($_REQUEST["organizedByMe"]))
		{
			$req->SetOrganizedByMe($_REQUEST["organizedByMe"]);
		}
	}
		
	echo (Event::Search($req));
}
?>