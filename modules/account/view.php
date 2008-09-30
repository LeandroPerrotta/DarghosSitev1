<h2><?php echo (!$ajax) ? $lang->get(40) : null; ?></h2>

<?php
	echo '<h3>' . $lang->get(41) . '</h3>';
	
	$data = $account->get("id = " . $_SESSION["id"], "created, email");
	
	// TODO: account change email and password
	
	echo '
		<ul>
			<li><strong>' . $lang->get(42) . '</strong> ' . $string->format($data["created"], "date") . '</li>
			<li><strong>' . $lang->get(43) . '</strong> ' . $data["email"] . '</li>
			<li><strong>' . $lang->get(44) . '</strong> ' . $lang->get(45) . ' | ' . $lang->get(46) . ' | <a href="' . $core->url(array(TOPIC, $lang->get(31))) . '">' . $lang->get(51) . '</a></li>
		</ul>
	';
	
	echo '<h3>' . $lang->get(47) . '</h3>';
	
	$data = $character->get("account_id = " . $_SESSION["id"], "id, name", true, "name ASC");
	
	// TODO: character edit and delete
	
	echo '<ul>';
	
	foreach ($data as $d) {
		echo '<li><strong>' . $d["name"] . '</strong> - ' . $lang->get(48) . ' | ' . $lang->get(49) . '</li>';
	}
	
	echo '</ul>';
	
	echo '<p><a href="' . $core->url(array($lang->get(52), $lang->get(2))) . '">' . $lang->get(50) . '</a></p>';
?>