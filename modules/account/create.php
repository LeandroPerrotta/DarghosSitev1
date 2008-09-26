<h2><?php echo (!$ajax) ? $lang->get(4) : null; ?></h2>

<?php
	if ($_POST) {
		foreach ($_POST as $key => $value) {
			$$key = $string->format($value);
		}
		
		if (!$account_email || !$account_password) {
			$error[] = $lang->get(8);
		}
		
		if ($account_email && !$string->validate($account_email)) {
			$error[] = $lang->get(9);
		}
		
		if ($account_password && strlen($account_password) < 6) {
			$error[] = $lang->get(13);
		}
		
		if (!$account_privacypolicy) {
			$error[] = $lang->get(12);
		}
		
		if (!$error) {
			$account_id = $account->id();
			$account_key = $account->key();
			
			if (!$core->mail(str_replace(array("[PLAYER_ACCKEY]", "[PLAYER_ACCNUMBER]", "[PLAYER_ACCPASSWORD]"), array($account_key, $account_id, $account_password), $lang->get(15)), CONFIG_SITENAME . " - " . $lang->get(14), $account_email)) {
				$error[] = $lang->get(16);
			}
		}
		
		if ($error) {
			echo '<ul class="error">';
			
			foreach ($error as $value) {
				echo '<li>' . $value . '</li>';
			}
			
			echo '</ul>';
		} else {
			$account->create($account_id, $account_email, $account_key, $account_password);
			
			echo '<ul class="success">';
			
			echo '<li>' . $lang->get(17) . '</li>';
			
			echo '</ul>';
		}
		
		if ($ajax) {
			exit();
		}
	}
?>

<form action="<?php echo $core->url(array($lang->get(1), $lang->get(2))); ?>" class="ajax" method="post">
	<fieldset>
		<div id="status"></div>
		
		<p>
			<label for="account_email"><?php echo $lang->get(5); ?></label><br />
			<input id="account_email" name="account_email" size="40" type="text" value="<?php echo $account_email; ?>" />
		</p>
		
		<p>
			<label for="account_password"><?php echo $lang->get(6); ?></label><br />
			<input id="account_password" name="account_password" size="40" type="password" value="<?php echo $account_password; ?>" />
		</p>
		
		<div id="privacy_policy"><?php echo $lang->get(10); ?></div>
		
		<p>
			<input <?php echo $account_privacypolice ? 'checked="checked"' : null; ?> name="account_privacypolice" id="account_privacypolice" type="checkbox" value="1" /> 
			<label for="account_privacypolice"><?php echo $lang->get(11); ?></label>
		</p>
		
		<p>
			<input type="submit" value="<?php echo $lang->get(7); ?>" />
		</p>
	</fieldset>
</form>