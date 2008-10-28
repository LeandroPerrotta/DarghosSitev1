<?
class Engine
{
	public static $instance;
	
	function loadClass($class)
	{
		include_once("classes/".$class.".php");
		return new $class();		
	}

	private function __construct()
	{	
		include_once("classes/database.php");
		$this->DB = Database::getInstance();
	}
	
	public static function getInstance() 
	{
		if(self::$instance == null) 
		{
			self::$instance = new Engine();
		}
		
		return self::$instance;
	}		
	
	function loggedIn()
	{
		$account = $_SESSION['account'];
		$password = $_SESSION['password'];
		
		if($account != null OR $account != "" OR $password != null OR $password != "")
		{	
			$this->DB->query("SELECT id, password FROM accounts WHERE id = $account AND password = '$password'");
			
			if($this->DB->num_rows() != 0)
			{
				return true;
			}
			else
				return false;
		}
		else
			return false;	
	}
	
	function filtreString($string)
	{
		if(preg_match("/(from|select|insert|delete|where|drop table|show tables|#|\*|--|\\\\)/i", $string))
			return false;
		else
			return true;	
	}	
	
	function encrypt($string)
	{
		switch(ENCRYPT_TYPE)
		{
			case "md5":
				return md5($string);
			break;	
		}		
	}	
	
	function random_key($tamanho, $separadores, $randTypeElement = "default") 
	{ 
		$options['upper'] = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$options['lower'] = "abcdefghijklmnopqrstuvwxyz";
		$options['number'] = "01234567890123456789";
			
		if($randTypeElement != "default")
		{
			$randTypeElement = explode("+", $randTypeElement);
			
			foreach($randTypeElement as $value)
			{
				$fullRand .= $options[$value];
			}
		}
		else
			$fullRand = $options['upper'].$options['lower'].$options['number'];
			
		$countChars = strlen($fullRand);
	
		$string = "";
		$part = array();
	
		for($i = 0; $i < $separadores; $i++)
		{
			for($n = 0; $n < $tamanho; $n++)
			{
				$rand = mt_rand(1, $countChars);
				$part[$i] .= $fullRand[$rand];	
			}
			
			if($i == 0)
				$string .= $part[$i];
			else
				$string .= "-".$part[$i];
		}
		
		return $string;
	}	
	
	function isEmailFormat($string)
	{
		if(preg_match('/^[a-z][\w\.+-]*[a-z0-9]@[a-z0-9][\w\.+-]*\.[a-z][a-z\.]*[a-z]$/i', $string))
			return true;
		else
			return false;
	}
	
	function accountAccess()
	{
		$account = $_SESSION['account'];
		$password = $_SESSION['password'];
		
		if($account != null OR $account != "" OR $password != null OR $password != "")
		{	
			$this->DB->query("SELECT id, password, group_id FROM accounts WHERE id = $account AND password = '$password'");
			
			if($this->DB->num_rows() != 0)
			{
				$fetch = $this->DB->fetch();
				return $fetch->group_id;
			}
			else
				return false;
		}
		else
			return false;			
	}
	
	function sendEmail($recipient, $subject, $content)
	{
		require("phpmailer/class.phpmailer.php");

		$mailsend = false;

		$mail = new PHPMailer();
		$mail->IsSMTP();						
		$mail->SMTPAuth   = true; 
		$mail->Host       = SMTP_HOST;   
		$mail->Port       = SMTP_PORT;  

		$mail->FromName   = "Darghos Server";
		$mail->Username   = SMTP_USER;
		$mail->Password   = "***REMOVED***";

		$mail->From = "Darghos";
		$mail->AddAddress($recipient);

		$mail->Subject = $subject;
		$mail->Body    = $content;
		
		$result = $mail->Send();
		
		if($result)
		{
			$mailsend = true;
		}	
		
		if($mailsend)
		{
			$this->DB->query("INSERT INTO site.sended_emails (`to`,`time`,`by`,`sucess`,`engine`) values('".$recipient."','".time()."','darghos.net@noip-smtp','1','open tibia')");
			return true;
		}	
		else
		{
			$this->DB->query("INSERT INTO site.sended_emails (`to`,`time`,`by`,`sucess`,`engine`,`error`) values('".$recipient."','".time()."','all','2','open tibia','".$mail->ErrorInfo."')");
			return false;
		}	
	}	
	
	function isFromBlackList($string)
	{
		$this->DB->query("SELECT * FROM site.`blackList_strings`");
		
		$isInBlackList = 0;
		
		while($fetch = $this->DB->fetch())
		{
			if(eregi($fetch->string, $string))
				$isInBlackList++;
		}
		
		if($isInBlackList == 0)
			return false;
		else
			return true;		
	}
	
	function canUseName($nameString)
	{
		if(trim($nameString) != $nameString)
			return false;	
		
		$palavras = explode(" ", $nameString);
		
		if(count($palavras) > 3)
			return false;
		
		if(ucfirst($palavras[0]) != $palavras[0])
			return false;
			
		if(ucfirst($palavras[2]) != $palavras[2])
			return false;			
			
		if(count($palavras) == 3)
		{
			if(strlen($palavras[0]) < 3)
				return false;	
				
			if(strlen($palavras[2]) < 3)
				return false;	
		}
		elseif(count($palavras) == 2)	
		{
			if(strlen($palavras[0]) < 3)
				return false;	
				
			if(strlen($palavras[1]) < 3)
				return false;			
		}
		elseif(count($palavras) == 1)	
		{
			if(strlen($palavras[0]) < 3)
				return false;			
		}		
	
		for($a = 0; $a != count($palavras); $a++)
		{	
			foreach(count_chars($palavras[$a], 1) as $letra => $quantidade)
			{
				if($quantidade > 4)
					return false;				
			}
		}
			
		if(strlen($nameString) > 30)	
			return false;
			
		$letras = str_split($nameString);	
		$space = array();
		
		for($a = 0; $a != count($letras); $a++)
		{
			if($letras[$a] == " ")
			{
				if(count($space) != 0 and ($space[0] + 1) == $a)
					return false;

				$space[] = $a;
			}				
		}
		
		$temp = strspn("$nameString", "qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM- ");
		
		if($temp != strlen($nameString))
			return false;
		
		return true;
	}		
}
?>