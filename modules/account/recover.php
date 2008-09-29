<h2><?php echo (!$ajax) ? $lang->get(18) : null; ?></h2>

<?php
	if ($_POST) {
		foreach ($_POST as $key => $value) {
			$$key = $string->format($value);
		}
		
		if ($account_key || $account_newemail) {
			$account_email = null;
		}
		
		if (!$account_email && (!$account_key || !$account_newemail)) {
			$error[] = $lang->get(8);
		}
		
		if (($account_email && !$string->validate($account_email, "email")) || ($account_newemail && !$string->validate($account_newemail, "email"))) {
			$error[] = $lang->get(9);
		}
		
		if (!$error) {
			if ($account_key) {
				$data = $account->get("`key` = '" . $account_key . "'", "id, password");
				
				if (!$data) {
					$error[] = $lang->get(24);
				}
			} else {
				$data = $account->get("email = '" . $account_email . "'", "id, password");
				
				if (!$data) {
					$error[] = $lang->get(25);
				}
			}
		}
		
		if (!$error && !$core->mail(str_replace(array("[PLAYER_ACCNUMBER]", "[PLAYER_ACCPASSWORD]"), array($data["id"], $data["password"]), $lang->get(26)), CONFIG_SITENAME . " - " . $lang->get(14), ($account_key ? $account_newemail : $account_email))) {
			$error[] = $lang->get(16);
		}
		
		if ($error) {
			echo '<ul class="error">';
			
			foreach ($error as $value) {
				echo '<li>' . $value . '</li>';
			}
			
			echo '</ul>';
		} else {
			if ($account_key) {
				$account->update($data["id"], $account_newemail, $data["password"]);
			}
			
			echo '<ul class="success">';
			
			echo '<li>' . str_replace("[PLAYER_ACCEMAIL]", ($account_key ? $account_newemail : $account_email), $lang->get(27)) . '</li>';
			
			echo '</ul>';
		}
		
		if ($ajax) {
			exit();
		}
	}
?>

<form action="<?php echo $core->url(array(TOPIC, SUBTOPIC)); ?>" class="ajax" method="post">
	<fieldset>
		<div id="status"></div>
		
		<p>
			<label for="account_email"><?php echo $lang->get(19); ?></label><br />
			<input id="account_email" name="account_email" size="40" type="text" value="<?php echo $account_email; ?>" />
		</p>
		
		<p><a class="toggle hide_prev empty_prev_input" href="#"><?php echo $lang->get(20); ?></a></p>
		
		<div>
			<p>
				<label for="account_key"><?php echo $lang->get(21); ?></label><br />
				<input id="account_key" name="account_key" size="40" type="text" value="<?php echo $account_key; ?>" />
			</p>
			
			<p>
				<label for="account_newemail"><?php echo $lang->get(23); ?></label><br />
				<input id="account_newemail" name="account_newemail" size="40" type="text" value="<?php echo $account_newemail; ?>" />
			</p>
		</div>
		
		<p>
			<input type="submit" value="<?php echo $lang->get(29); ?>" />
		</p>
	</fieldset>
</form>