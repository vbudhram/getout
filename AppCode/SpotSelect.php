<?php
	include_once "../Model/Util/DBUtil.php";
	
	function GenerateSpotOptions($selectedId) 
	{
                //gets all spots
		$stmt = "BEGIN SPOT_GET_WITHINDISTANCE('',99999,0,0,:RC); END;";
		
                $results = DBUtil::ExecuteProcedureQuery(null, $stmt);
		if (is_string($results))
			$options = Array();
		$options = $results;
	
		$html = "";//'<select name="'.$name.'">';
		foreach ($options as $a) {
			if($a['SPOT_ID'] == $selectedId)
			{
				$html .= '<option value='.$a['SPOT_ID'].' selected="true" >'.$a['NAME'].'</option>';
			}
			else 
			{
				$html .= '<option value='.$a['SPOT_ID'].'>'.$a['NAME'].'</option>';
			}
		}
		//$html .= '</select>';
		return $html;
	}
?>