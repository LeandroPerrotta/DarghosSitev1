<?php
	$t = microtime(true);
	
	set_time_limit(0);
	
	setlocale(LC_ALL, "pt_BR");
	date_default_timezone_set("America/Sao_Paulo");
	
	session_start();
	
	include_once("config.php");
	include_once("classes/mysql.php");
	include_once("libraries/phpmailer/class.phpmailer.php");
	include_once("classes/core.php");
	include_once("classes/string.php");
	include_once("classes/lang.php");
	
	include_once("classes/account.php");
	
	$query = explode("/", $_GET["query"]);
	
	define("TOPIC", $string->format($query[0]));
	define("SUBTOPIC", $string->format($query[1]));
	define("EXTRA_A", $string->format($query[2]));
	define("EXTRA_B", $string->format($query[3]));
	
	switch (TOPIC) {
		case $lang->get(1):
			$module = "modules/account/index.php";
		break;
		
		default:
			$module = "modules/index.php";
		break;
	}
	
	$ajax = $_POST["ajax"];
	
	if ($ajax) {
		include_once($module);
		exit();
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
		
		<title><?php echo CONFIG_SITENAME; ?></title>
		
		<link href="<?php echo $core->url(array("css.css")); ?>" media="screen" rel="stylesheet" type="text/css" />
		
		<script type="text/javascript">
			<!--
				var ajax_error = "<?php echo $lang->get(16); ?>";
				var site_address = "<?php echo CONFIG_SITEADDRESS; ?>";
			-->
		</script>
		
		<script src="<?php echo $core->url(array("js.js")); ?>" type="text/javascript"></script>
	</head>
	
	<body>
		<div id="wrapper">
			<h1><?php echo CONFIG_SITENAME; ?></h1>
			
			<ul id="navigation">
				<li><a href="#"><?php echo $lang->get(1); ?></a></li>
			</ul>
			
			<div id="content">
				<?php include_once($module); ?>
			</div>
		</div>
		<p><?php echo microtime(true) - $t; ?></p>
	</body>
</html>