<?php
	include_once "../Model/Util/DBUtil.php";
	
	function GenerateActivityOptions($name = '') {
		$stmt = "BEGIN ACTIVITY_GET(:RC, ''); END;";
		$results = DBUtil::ExecuteProcedureQuery(null, $stmt);
		if (is_string($results))
			$options = Array();
		$options = $results;
	
		$html = "";//'<select name="'.$name.'">';
		foreach ($options as $a) {
			$html .= '<option value='.$a['ID'].'>'.$a['NAME'].'</option>';
		}
		//$html .= '</select>';
		return $html;
	}
?>