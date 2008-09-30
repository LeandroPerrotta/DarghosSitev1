<?php
	class String {
		function format($string, $type = null) {
			switch ($type) {
				case "date":
					$string = date("d.m.Y", $string);
				break;
				
				default:
					if (is_int($string)) {
						$string = (int)$string;
					} else {
						$string = htmlspecialchars($string, ENT_QUOTES);
					}
				break;
			}
			
			return $string;
		}
		
		function validate($string, $type = null) {
			switch ($type) {
				default:
					if (filter_var($string, FILTER_VALIDATE_EMAIL)) {
						return true;
					}
				break;
			}
			
			return false;
		}
	}
	
	$string = new String();
?>