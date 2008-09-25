<?php
	set_time_limit(0);
	
	setlocale(LC_ALL, "pt_BR");
	date_default_timezone_set("America/Sao_Paulo");
	
	session_start();
	
	include_once("config.php");
	include_once("classes/mysql.php");
	include_once("classes/core.php");
	
	$query = explode("/", $_GET["query"]);
	
	define("TOPIC", formatar($query[0]));
	define("SUBTOPIC", formatar($query[1]));
	define("EXTRA_A", formatar($query[2]));
	define("EXTRA_B", formatar($query[3]));
	
	switch (TOPIC) {
		default:
			$module = "modules/index.php";
		break;
	}
	
	if ($_POST["ajax"]) {
		include_once($module);
		exit();
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
		
		<title><?php echo CONFIG_SITENAME; ?></title>
		
		<link href="<?php $core->url(array("css.css")); ?>" media="screen" rel="stylesheet" type="text/css" />
		
		<script src="<?php $core->url(array("js.js")); ?>" type="text/javascript"></script>
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
	</body>
</html>