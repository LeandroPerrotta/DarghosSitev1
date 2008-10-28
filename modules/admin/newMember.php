<?/*
if($engine->accountAccess() >= GROUP_GOD)
{
	echo '<tr><td class=newbar><center><b>:: Criar GM Account ::</td></tr>
	<tr><td class=newtext><center><br>';	

	if ($_SERVER['REQUEST_METHOD'] == "POST")
	{
			$pass = my_rand(6);	
			$passMd5 = md5($pass);
			$date = time();
			$email = $_POST['email'];

			if(Account::getType($account) == 6)
			{
				switch($_POST['group'])
				{
					case "tutor";
						$group_id = 2;
					break;

					case "senator";
						$group_id = 3;
					break;

					case "gamemaster";
						$group_id = 4;
					break;

					case "community_manager";
						$group_id = 5;
					break;

					case "administrator";
						$group_id = 6;
					break;	
					
					default:
						$group_id = 2;
					break;	
				}
				
				switch($_POST['type'])
				{
					case "tutor";
						$type_id = 2;
					break;

					case "senior_tutor";
						$type_id = 3;
					break;

					case "gamemaster";
						$type_id = 4;
					break;

					case "god";
						$type_id = 5;
					break;

					default:
						$type_id = 2;
					break;							
				}					
			}
			elseif(Account::getType($account) == 5)
			{
				switch($_POST['group'])
				{
					case "tutor";
						$group_id = 2;
					break;

					case "senator";
						$group_id = 3;
					break;

					case "gamemaster";
						$group_id = 4;
					break;
					
					default:
						$group_id = 2;
					break;	
				}
				
				switch($_POST['type'])
				{
					case "tutor";
						$type_id = 2;
					break;

					case "senior_tutor";
						$type_id = 3;
					break;

					case "gamemaster";
						$type_id = 4;
					break;

					default:
						$type_id = 2;
					break;							
				}			
			}					
	
			// creates account
			$accObject = $ots->createObject('Account');
			$number = $accObject->create();

			// saves account information
			$accObject->setPassword($passMd5);
			$accObject->setEMail($email);
			$accObject->setCustomField(lastday, $date);
			$accObject->setCustomField(creation, $date);
			$accObject->setCustomField(premdays, 65535);
			$accObject->setCustomField(premFree, 1);
			$accObject->setCustomField(group_id, $group_id);
			$accObject->setCustomField(type, $type_id);
			$accObject->unblock();
			$accObject->save();	
			
			$body =	'Prezado senhor,
	Parabens! É com grande prazer que a UltraxSoft gera uma conta de membro para você!				
						
	Estes são os detalhes de sua conta:
	Sua conta é: '.$number.'
	Sua senha é: '.$pass.'

	Para criar o personagem membro em sua Account siga o procedimento normal.
							
	Para entrar em sua conta acesse:
	http://ot.darghos.com/index.php?page=account.login

	Esperamos que possa efetuar um grande trabalho ajudando o Darghos a progredir!
	Desejamos-o um bom trabalho!
						
	UltraxSoft Team..';		

		if (!mailex($email, 'Detalhes de sua conta membro!', $body))
		{
			echo "<br><center>(falha 345) Ouve um erro fatal ao enviar o e-mail, destinatario inexistente, por favor contacte um administrador.</center>";		
		}				
		else
		{		
			echo '<center><table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
			echo '<tr><td class=rank2>GM Account criada com sucesso!</td></tr>';
			echo '<tr><td class=rank1>Foi enviado ao email do novo GM com detalhes de sua conta!
			<br>Este email tem um prazo de 24 horas para chegar, mas normalmente chega na hora.
			<br><br>
			Aviso: Alguns provedores de email como a Hotmail entre outros, estão redirecionando os nossos emails enviados para a lixeira (ou lixo eletronico).
			<br> Devido a isto, caso seu email não chega na sua caixa de entrada, verifique nas pastas de lixo eletronico.';			
			echo '</table>';
			echo '<br><a href="?page=account.main"><img src="images/back.gif" border="0"></a>';
		}	
	}
	else
	{

		if(Account::getType($account) == 6)
		{
			$access = '<select name="group"><option value="senator">Senator</option><option value="gamemaster">Gamemaster</option><option value="community_manager">Comunity Manager</option><option value="administrator">Administrador</option></select>';
			$accType = '<select name="type"><option value="tutor">Tutor</option><option value="senior_tutor">Senior Tutor & Senator</option><option value="gamemaster">Gamemaster & Community Manager</option><option value="god">GOD</option></select>';
		}
		elseif(Account::getType($account) == 5)
		{
			$access = '<select name="group"><option value="senator">Senator</option><option value="gamemaster">Gamemaster</option></select>';
			$accType = '<select name="type"><option value="tutor">Tutor</option><option value="senior_tutor">Senior Tutor & Senator</option><option value="gamemaster">Gamemaster</option></select>';
		}	
		
		echo '<form action="?page=admin.newMember" method="post">';

		echo '<center><table width="65%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
		echo '<tr class=rank1><td width="10%">E-mail:</td><td width="50%"><input class="login" name="email" type="text" value="" size="30"/></td></tr>';
		echo '<tr class=rank1><td width="25%">Access:</td><td width="75%">'.$access.'</td></tr>';
		echo '<tr class=rank1><td width="25%">AccType:</td><td width="75%">'.$accType.'</td></tr>';
		echo '</table><br>';
		echo '<input type="image" value="Entrar" src="images/newaccount.gif"/>';
		echo '<br />';
		echo '</form>';
		echo '</center>';		
	}
}*/
echo "Desabilitado Temporareamente."
?>