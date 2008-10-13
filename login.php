<?
ob_start();
session_start();
include ('config.php');
include ('toolbox.php');

$ip_addr = $_SERVER['REMOTE_ADDR'];

if (!empty($_POST['account']))
    $account = filtreString($_POST['account'],0);
if (!empty($_POST['password']))
    $password = md5($_POST['password']);

if($account != 1)
{	
	if (isset($account) && isset($password)) 
	{
	   $query = mysql_query("SELECT * FROM accounts WHERE id = '$account' AND password = '$password'");
		if (mysql_num_rows($query) > 0)
		{
	        $sql = mysql_fetch_assoc($query);
	        $_SESSION["account"] = $account;
	        $_SESSION["password"] = $password;
			Logs::loginTries($account, $password, 1, $ip_addr);
			header ("Location: account.php?subtopic=main");	
	    } 
		else 
		{
			Logs::loginTries($account, $password, 0, $ip_addr);
	        header ("Location: account.php?subtopic=login");
	    }                
	} 
	else 
	{
	    header ("Location: index.php");
	}
}	
else 
{
    header ("Location: index.php");
} 

?> 