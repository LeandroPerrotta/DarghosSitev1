<h2><?php echo (!$ajax) ? $lang->get(53) : null; ?></h2>

<?php
	if ($_POST) {
		foreach ($_POST as $key => $value) {
			$$key = $string->format($value);
		}
		
		if (!$character_name || !$character_sex || !$character_voc) {
			$error[] = $lang->get(8);
		}
		
		$character_name = ucwords(strtolower($character_name));
		$cn1 = $character_name[0] . $character_name[1];
		$cn2 = $character_name[0] . $character_name[1] . $character_name[2];
		$character_sex = ($character_sex < 3 || $character_sex > 4) ? 3 : $character_sex;
		$character_voc = ($character_voc < 1 || $character_voc > 4) ? 1 : $character_voc;
		
		// TODO: player should be able to create a character with single quotes (')
		
		if (!ereg("^([A-Za-z ]+)$", $character_name)) {
			$error[] = $lang->get(61);
		}
		
		if ($cn1 == "GM" || $cn1 == "Gm" || $cn1 == "CM" || $cn1 == "Cm" || $cn2 == "GOD" || $cn2 == "GOd" || $cn2 == "GoD") {
			$error[] = $lang->get(62);
		}
		
		if (!$error) {
			$data = $character->get("name = '" . $character_name . "'", "name");
			
			if ($data) {
				$error[] = $lang->get(60);
			}
		}
		
		if ($error) {
			echo '<ul class="error">';
			
			foreach ($error as $value) {
				echo '<li>' . $value . '</li>';
			}
			
			echo '</ul>';
		} else {
			$character->create($_SESSION["id"], 4, $character_name, $character_sex, $character_voc);
			
			echo '<ul class="success">';
			
			echo '<li>' . $lang->get(63) . '</li>';
			
			echo '</ul>';
			
			$core->redirect(array($lang->get(1)));
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
			<label for="character_name"><?php echo $lang->get(54); ?></label><br />
			<input id="character_name" name="character_name" size="40" type="text" value="<?php echo $character_name; ?>" />
		</p>
		
		<p>
			<label for="character_sexmale"><?php echo $lang->get(55); ?></label><br />
			<input <?php echo (!$character_sex || $character_sex == 3) ? 'checked="checked"': null; ?> id="character_sexmale" name="character_sex" type="radio" value="3" /> <label for="character_sexmale"><?php echo $lang->get(57); ?></label>
			<input <?php echo ($character_sex == 4) ? 'checked="checked"': null; ?> id="character_sexfemale" name="character_sex" type="radio" value="4" /> <label for="character_sexfemale"><?php echo $lang->get(58); ?></label>
		</p>
		
		<p>
			<label for="character_vocsorcerer"><?php echo $lang->get(56); ?></label><br />
			<input <?php echo (!$character_voc || $character_voc == 1) ? 'checked="checked"': null; ?> id="character_vocsorcerer" name="character_voc" type="radio" value="1" /> <label for="character_vocsorcerer">Sorcerer</label>
			<input <?php echo ($character_voc == 2) ? 'checked="checked"': null; ?> id="character_vocdruid" name="character_voc" type="radio" value="2" /> <label for="character_vocdruid">Druid</label>
			<input <?php echo ($character_voc == 3) ? 'checked="checked"': null; ?> id="character_vocpaladin" name="character_voc" type="radio" value="3" /> <label for="character_vocpaladin">Paladin</label>
			<input <?php echo ($character_voc == 4) ? 'checked="checked"': null; ?> id="character_vocknight" name="character_voc" type="radio" value="4" /> <label for="character_vocknight">Knight</label>
		</p>
		
		<p>
			<input type="submit" value="<?php echo $lang->get(59); ?>" />
		</p>
	</fieldset>
</form>