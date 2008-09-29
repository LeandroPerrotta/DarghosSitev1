<?php
	class Core {
		function mail($message, $subject, $to, $from = CONFIG_SITEEMAIL) {
			$mail = new PHPMailer();
			
			$mail->Host = SMTP_HOST;
			$mail->IsSMTP();
			$mail->Password = SMTP_PASS;
			$mail->SMTPAuth = true;
			$mail->Username = SMTP_USER;
			
			$mail->AddAddress($to);
			$mail->AddReplyTo($from, CONFIG_SITENAME);
			$mail->From = $from;
			$mail->FromName = CONFIG_SITENAME;
			
			$mail->Body = $message;
			$mail->Subject = $subject;
			
			if ($mail->Send()) {
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