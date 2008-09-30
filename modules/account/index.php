<?php
	switch (SUBTOPIC) {
		case $lang->get(2):
			include_once("create.php");
		break;
		
		case $lang->get(30):
			include_once("login.php");
		break;
		
		case $lang->get(31):
			include_once("logout.php");
		break;
		
		case $lang->get(22):
			include_once("recover.php");
		break;
		
		case $lang->get(3):
			include_once("update.php");
		break;
		
		default:
			include_once("view.php");
		break;
	}
?>