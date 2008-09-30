<h2><?php echo (!$ajax) ? $lang->get(32) : null; ?></h2>

<?php
	if ($_POST) {
		foreach ($_POST as $key => $value) {
			$$key = $string->format($value);
		}
		
		if (!$account_id || !$account_password) {
			$error[] = $lang->get(8);
		}
		
		if (!$error) {
			$data = $account->get("id = '" . $account_id . "' AND password = '" . $account_password . "'", "id, email");
			
			if (!$data) {
				$error[] = $lang->get(36);
			}
		}
		
		if ($error) {
			echo '<ul class="error">';
			
			foreach ($error as $value) {
				echo '<li>' . $value . '</li>';
			}
			
			echo '</ul>';
		} else {
			$_SESSION["id"] = $account_id;
			$_SESSION["email"] = $data["email"];
			
			echo '<ul class="success">';
			
			echo '<li>' . $lang->get(37) . '</li>';
			
			echo '</ul>';
			
			$core->redirect(array(TOPIC), 2);
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
			<label for="account_id"><?php echo $lang->get(33); ?></label><br />
			<input id="account_id" name="account_id" size="40" type="text" value="<?php echo $account_id; ?>" />
		</p>
		
		<p>
			<label for="account_password"><?php echo $lang->get(34); ?></label><br />
			<input id="account_password" name="account_password" size="40" type="password" value="<?php echo $account_password; ?>" />
		</p>
		
		<p>
			<input type="submit" value="<?php echo $lang->get(35); ?>" />
		</p>
	</fieldset>
</form>