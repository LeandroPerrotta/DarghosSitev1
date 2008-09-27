<?
	ob_start();
	session_start();
	$_SESSION['lang'] = 'en_us';
	header ("location: ../../index.php");
?>