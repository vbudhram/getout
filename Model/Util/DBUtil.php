<?php
	include_once "DBSettings.php";
	
	class BindingVariable
	{
		public $key;
		public $val;
		public $size;
		public $isBlob;
		
		public function __construct($key, $val, $size, $isBlob)
		{
			$this->key = $key;
			$this->val = $val;
			$this->size = $size;
			$this->isBlob = $isBlob;
		}
		
		public function __toString()
    	{
        	return (string)$this->val;
    	}
	}
	
	class DBUtil{
		/**
 		* Executes a procedure and if successfull returns the results in an array
		* else returns a string with the error msg
 		*/
		static function ExecuteProcedureQuery($conn, $stmt, &$bindArray=array()){
			$closeConn = false;
			if ($conn == null) {
				$closeConn = true;
				//create connection
				$conn = oci_connect(DBSettings::GetUsername(),
                        			DBSettings::GetPassword(),
                        			DBSettings::GetConnectionString());
			}
		
			if (!$conn) {
    			$e = oci_error();
    			return "oci_connect error: " . $e['message'];
			}	
			
			// Execute the call to the stored procedure
      		$stid = @oci_parse($conn, $stmt);
      		if (!$stid) {
        		$e = oci_error($conn);
    			return "oci_parse error: " . $e['message'];
      		}
      		
      		$t = 0;
      		$refcur = oci_new_cursor($conn);
      		if (!$refcur) {
        		$e = oci_error($conn);
    			return "oci_new_cursor call failed";
      		}
      		
      		$r = @oci_bind_by_name($stid, ':RC', $refcur, -1, OCI_B_CURSOR);
      		if (!$r) {
        		$e = oci_error($stid);
    			return "oci_bind_by_name error: " . $e['message'];
      		}
      		
      		foreach ($bindArray as $obj) {
    			$r = oci_bind_by_name($stid, $obj->key, $obj->val, $obj->size);
    			if (!$r) {
        			$e = oci_error($stid);
    				return "oci_bind_by_name error: " . $e['message'];
      			}
			}
      		
      		$r = @oci_execute($stid);
      		if (!$r) {
        		$e = oci_error($stid);
    			return "oci_execute error: " . $e['message'];
      		}
      		
      		// Now treat the ref cursor as a statement resource
      		$r = @oci_execute($refcur, OCI_DEFAULT);
      		if (!$r) {
        		$e = oci_error($stid);
    			return "oci_execute error: " . $e['message'];
      		}
      		
      		$results = null;
      		$r = @oci_fetch_all($refcur, $results, null, null,OCI_FETCHSTATEMENT_BY_ROW);
      		if (!$r) {
        		$e = oci_error($conn);
    			return "oci_fetch_all error";
      		}
      		
      		if ($closeConn){	
      			oci_free_statement($stid);
				oci_close($conn);
			}
			
      		return ($results);
		}
	
		/**
 		* Executes a procedure and return true if successfull else returns a string with error msg
 		*/
		static function ExecuteProcedureNonQuery($conn, $stmt, &$bindArray=array()){
			$closeConn = false;
			if ($conn == null) {
				$closeConn = true;
				//create connection
				$conn = oci_connect(DBSettings::GetUsername(),
                        			DBSettings::GetPassword(),
                        			DBSettings::GetConnectionString());
			}
		
			if (!$conn) {
    			$e = oci_error();
    			return "oci_connect error: " . $e['message'];
			}	
			
			// Execute the call to the stored procedure
      		$stid = @oci_parse($conn, $stmt);
      		if (!$stid) {
        		$e = oci_error($conn);
    			return "oci_parse error: " . $e['message'];
      		}
      		
      		$t = 0;
      		$refcur = oci_new_cursor($conn);
      		if (!$refcur) {
        		$e = oci_error($conn);
    			return "oci_new_cursor call failed";
      		}
      		
			$lob = null;
			$loc = null;
                        
                if($bindArray!=null){
                    foreach ($bindArray as $obj) {
                                    if ($obj->isBlob == 1){
                                            $lob = OCINewDescriptor($conn, OCI_D_LOB);
                                            $r = oci_bind_by_name($stid, $obj->key, $lob, $obj->size, OCI_B_BLOB);
                                    }
                                    else
                                            $r = oci_bind_by_name($stid, $obj->key, $obj->val, $obj->size);
                            if (!$r) {
                                    $e = oci_error($stid);
                                    return "oci_bind_by_name error: " . $e['message'] . " - Key: ".$obj->key;
                            }
                            }
                }
                
      		$r = @oci_execute($stid);
      		if (!$r) {
        		$e = oci_error($stid);
    			return "oci_execute error: " . $e['message'];
      		}
      		
      		if ($closeConn){	
      			oci_free_statement($stid);
				oci_close($conn);
			}
			
			return true;
		}
	}
?>
