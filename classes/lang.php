<?php
	class Lang {
		function get($id) {
			$lang = array(
				1 => 'account',
				2 => 'create',
				3 => 'update',
				4 => 'Account Create',
				5 => 'Your e-mail:',
				6 => 'Your password:',
				7 => 'Create',
				8 => 'One or more required fields were not filled in.',
				9 => 'The typed e-mail is not valid.',
				10 => '<p><strong>Privacy Policy Terms</strong><br />Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Suspendisse elit nunc, adipiscing condimentum, ornare quis, venenatis in, nibh. Suspendisse porttitor, orci sed lobortis auctor, odio odio scelerisque nisl, vel ullamcorper leo justo et pede. Maecenas libero sapien, varius quis, consectetuer ac, posuere lobortis, metus. Duis velit orci, malesuada sit amet, congue sit amet, ultrices ac, risus. Sed tempus condimentum lorem. Curabitur elit metus, tempus nec, auctor quis, lacinia in, velit. Morbi euismod. Curabitur at sem eu felis viverra elementum. Duis dui orci, consectetuer et, bibendum at, viverra id, sem. Donec pellentesque mattis nisl. Curabitur velit. Cras scelerisque, justo eget euismod mollis, lorem nisi tempor nunc, lobortis dignissim risus sem ac mauris. Curabitur magna pede, venenatis a, egestas quis, rhoncus et, nisl. Phasellus fringilla facilisis ligula. Vivamus pretium, augue et varius accumsan, neque felis dignissim risus, eget vestibulum ligula tellus in augue. Vivamus augue. Pellentesque tempus, nibh a tristique feugiat, ipsum urna imperdiet diam, ut luctus ante est sed felis. Duis augue pede, vestibulum egestas, vulputate sit amet, ultrices malesuada, orci. Aenean et enim.</p>',
				11 => 'I have read and I agree to Privacy Policy Terms.',
				12 => 'To create an account you should agree to Privacy Policy Terms.',
				13 => 'Your password should have at least 6 characters.',
				14 => 'Your account data',
				15 => "Hello player of " . CONFIG_SITENAME . ",\nYour account has been successfully created!\n\nBelow follows the details of your account:\nYour account number is: [PLAYER_ACCNUMBER]\nYour password is: [PLAYER_ACCPASSWORD]\nYou key is: [PLAYER_ACCKEY]\n\nThe account key is used to change your account e-mail instantly, so take care of that information.\n\nTo create your character and start the game visit:\n" . CONFIG_SITEADDRESS . "account\n\nSee you in World of " . CONFIG_SITENAME . "!\n" . CONFIG_SITEOWNER,
				16 => 'Internal error. Please try again.',
				17 => 'Account successfully created. Please check your e-mail.',
				18 => 'Account Recover',
				19 => 'Account e-mail:',
				20 => 'I do not remember my account e-mail.',
				21 => 'Account key:',
				22 => "recover",
				23 => "New account email:",
				24 => 'The typed key is not valid.',
				25 => 'The typed email do not exists.',
			);
			
			return $lang[$id];
		}
	}
	
	$lang = new lang();
?>