<?
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
include "modules.php";
include "layout.php";

$starttime = explode(' ', microtime());
$starttime = $starttime[1] + $starttime[0];

$mtime = explode(' ', microtime());
$totaltime = $mtime[0] + $mtime[1] - $starttime;

echo 'Carregado em '.$totaltime.' segundos.';
?>