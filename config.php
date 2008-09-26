<?php
session_start();
////////////////////////////////////////////////////////////////////////////
//                 Ultrax Server Site (SQL) 7.8 ou 7.8.1                  //
//                           by Nostradamus                               //
//                                1.1                                     //
////////////////////////////////////////////////////////////////////////////

//Configurações do OTServ
include('classes/OTS.php');

$cfg['dirdata'] = 'C:/server/data/';
$cfg['house_file'] = 'world/test-house.xml';

$maxsize = (512*10000); //Maxsize for guild images.
$guildimgdir = "images/"; //guild img dir
$screendir = "screenshots/"; //guild img dir
$imagedir = "images/"; //images

//Buttons
////////////////////////////////////////////////
$vote_button = ''.$imagedir.'vote.gif';
$back_button = ''.$imagedir.'back.gif';
$changeSex_button = ''.$imagedir.'changesex.gif';
////////////////////////////////////////////////

//Conectores SQL
////////////////////////////////////////////////

$db['user'] = "root";
$db['pass'] = "";
$db['host'] = "localhost";
$db['name'] = "otserv";
@mysql_connect($db['host'], $db['user'], $db['pass']) or die("Não foi possivel se conectar com o banco de dados.");
@mysql_select_db($db['name']) or die("Não foi possivel selecionar a tabela de dados: <b>".$db['name']."</b>.");

// database configuration - can be simply moved to external file, eg. config.php
$userdb = array(
    'host' => 'localhost',
    'user' => 'root',
    'port' => '3306',
    'database' => 'otserv',
	'password' => ''
);
/////////////////////////////////////////////////

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
