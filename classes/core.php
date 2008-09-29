<?php
	class Core {
		function mail($message, $subject, $to, $from = CONFIG_SITEEMAIL) {
			// TODO: move configs to config.php
			
			$mail = new PHPMailer();
			
			$mail->Host = "smtp.darghos.com";
			$mail->IsSMTP();
			$mail->Password = "***REMOVED***";
			$mail->SMTPAuth = true;
			$mail->Username = "auto-responder@darghos.com";
			
			$mail->AddAddress($to);
			$mail->AddReplyTo($from, CONFIG_SITENAME);
			$mail->From = $from;
			$mail->FromName = CONFIG_SITENAME;
			
			$mail->Body = $message;
			$mail->Subject = $subject;
			
			if ($mail->Send()) {
				return true;
			} else {
				echo $mail->ErrorInfo;
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