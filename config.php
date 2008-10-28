<?php
//Configurações do OTServ
$cfg['dirdata'] = 'C:/Darghos/Old8.11/data/';
$cfg['house_file'] = 'world/test-house.xml';

$maxsize = (512*10000); //Maxsize for guild images.
$guildimgdir = "images/"; //guild img dir
$screendir = "screenshots/"; //guild img dir
$imagedir = "images/"; //images

//Cidades
$city['quendor'] = array('id' => '1', 'x' => '2020', 'y' => '1903', 'z' => '7');

//Buttons
////////////////////////////////////////////////
$vote_button = ''.$imagedir.'vote.gif';
$back_button = ''.$imagedir.'back.gif';
$changeSex_button = ''.$imagedir.'changesex.gif';
////////////////////////////////////////////////

//Conectores SQL
////////////////////////////////////////////////
$userdb = array(
    'host' => 'localhost',
    'user' => 'root',
    'port' => '3306',
    'database' => 'newot',
	'password' => ''
);

if(!@mysql_connect($userdb['host'], $userdb['user'], $userdb['password']))
{
	$errorDefault['title'] = "Banco de dados em manutenção.";
	$errorDefault['details'] = "Tente novamente mais tarde...";
	include("manutention.php");
	die();
}

if(!@mysql_select_db($userdb['database']))
{
	$errorDefault['title'] = "Banco de dados em manutenção.";
	$errorDefault['details'] = "Tente novamente mais tarde...";
	include("manutention.php");
	die();
}

/////////////////////////////////////////////////

/*  DEFINITIONS  */

// GROUPS
define('GROUP_PLAYER', 1);
define('GROUP_TUTOR', 2);
define('GROUP_SENATOR', 3);
define('GROUP_GAMEMASTER', 4);
define('GROUP_COMMUNITYMANAGER', 5);
define('GROUP_GOD', 6);

define('SHOW_TESTSERVER', 1);
define('SHOW_TICKETS', 1);

define('ENCRYPT_TYPE', 'md5');
define('RECOMENDED_CHANGEPASS_PERIOD', '30');
define('USE_QUESTION_TRIES', '3');
define('SUSPEND_QUESTION_TIME', 60 * 60 * 24);

define('SMTP_HOST', 'smtp-auth.no-ip.com');
define('SMTP_PORT', 587);
define('SMTP_USER', 'darghos.net@noip-smtp');
define('SMTP_PASS', '***REMOVED***');

define('GLOBAL_URL', 'http://ot.darghos.com');
define('STATUS_UPDATE', 60);
define('SCHEDULER_EMAILCHANGER', 5);

define('SLOT_HEAD', 1);
define('SLOT_BACKPACK', 3);
define('SLOT_ARMOR', 4);
define('SLOT_RIGHTHAND', 5);
define('SLOT_LEFTHAND', 6);
define('SLOT_LEGS', 7);
define('SLOT_FEET', 8);
define('SLOT_AMMO', 10);
/* END DEFINITIONS */

$g_vocation['none'] = 0;
$g_vocation['sorcerer'] = 1;
$g_vocation['druid'] = 2;
$g_vocation['paladin'] = 3;
$g_vocation['knight'] = 4;

$g_genre['female'] = 0;
$g_genre['male'] = 1;

$g_residence['quendor'] = 1;
$g_residence['aracura'] = 2;
$g_residence['rookgaard'] = 3;
$g_residence['thorn'] = 4;
$g_residence['salazart'] = 5;
$g_residence['northrend'] = 7;

include "classes/engine.php";
include "classes/admin.php";
include "toolbox.php";

$engine = Engine::getInstance();

$DB = $engine->loadClass("database");

include "serverInfo.php";

if($_SESSION['lang'] == "")
{
	include('lang/pt-br/global.php');
}	
else
{
	if($_SESSION['lang'] == 'pt_br')
		include('lang/pt-br/global.php');
	else
		include('lang/en-us/global.php');
}
?>
