<?php
	class Core {
		function mail($message, $subject, $to, $from = CONFIG_SITEEMAIL) {
			if (mail($to, $subject, $message, "From: " . $from)) {
				return true;
			}
			
			return false;
		}
		
		function url($attr = array()) {
			foreach ($attr as $value) {
				$url .= $value . "/";
			}
			
			$url = CONFIG_SITEADDRESS . $url;
			$url = substr($url, 0, strlen($url) - 1);
			
			return $url;
		}
	}
	
	$core = new Core();
?>