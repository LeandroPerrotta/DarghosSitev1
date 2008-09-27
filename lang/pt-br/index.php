<?
	ob_start();
	session_start();
	$_SESSION['lang'] = 'pt_br';
	header ("location: ../../index.php");
?>