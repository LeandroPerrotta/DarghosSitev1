<?php
	switch (SUBTOPIC) {
		case $lang->get(2):
			include_once("create.php");
		break;
		
		case $lang->get(3):
			include_once("update.php");
		break;
		
		default:
			include_once("view.php");
		break;
	}
?>