<?
//header ("Location: http://www.darghos.net/");	

/*if($_SERVER['SERVER_NAME'] != "www.darghos.com.br")
	header ("Location: http://www.darghos.com.br".$_SERVER['REQUEST_URI']."");*/	

$starttime = explode(' ', microtime());
$starttime = $starttime[1] + $starttime[0];
session_start();

$cfg['WEB_STATUS'] = 0;
if($cfg['WEB_STATUS'] == 1)
{
	include "manutention.php";
	die();
}

$account = $_SESSION['account'];
$password = $_SESSION['password'];

include "config.php";

/*$DB->query("SELECT * FROM site.visitstopotsev WHERE ip = '".$_SERVER['REMOTE_ADDR']."'");

if($DB->num_rows() != 0)
{
	$fetch = $DB->fetch();
	if($fetch->date + 60 * 60 < time())
	{
		$DB->query("UPDATE site.visitstopotsev SET date = '".time()."' WHERE ip = '".$_SERVER['REMOTE_ADDR']."'");
		header ("Location: http://www.topotserv.com/index.php?act=otserv&serverid=25&module=vote&t=true");	
	}
}
else
{
	$DB->query("INSERT INTO site.visitstopotsev (`ip`,`date`) values ('".$_SERVER['REMOTE_ADDR']."', '".time()."')");
	header ("Location: http://www.topotserv.com/index.php?act=otserv&serverid=25&module=vote&t=true");	
}*/

include "modules.php";
include "layout.php";

$starttime = explode(' ', microtime());
$starttime = $starttime[1] + $starttime[0];

$mtime = explode(' ', microtime());
$totaltime = $mtime[0] + $mtime[1] - $starttime;

echo 'Carregado em '.$totaltime.' segundos.';
?>