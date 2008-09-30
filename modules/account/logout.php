<h2><?php echo (!$ajax) ? $lang->get(38) : null; ?></h2>

<?php
	session_destroy();
	session_unset();
	
	echo '<ul class="success">';
	
	echo '<li>' . $lang->get(39) . '</li>';
	
	echo '</ul>';
	
	$core->redirect(array(TOPIC), 2);
?>