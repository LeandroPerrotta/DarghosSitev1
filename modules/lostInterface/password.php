<?
if($_GET["step"] == "confirmKey")
{
	if ($_SERVER['REQUEST_METHOD'] == "POST")
	{				
		$success = false;
		
		if(!$engine->filtreString($_POST['account']) OR !$engine->filtreString($_POST['key']))
		{
			$condition['title'] = 'Sintaxes reservadas';
			$condition['details'] = "O seu formulario contem o uso de sintaxes reservadas ao sistema interno. Por favor tente novamente com outros valores.";
		}		
		else
		{
			$account = $engine->loadClass('Accounts');
		
			if(!$account->loadByNumber($_POST['account']))
			{
				$condition['title'] = 'Conta incorreta';
				$condition['details'] = "Não existe nenhuma conta com o numero informado em nosso banco de dados.";					
			}
			elseif($account->loadChangePasswordKey() != $_POST['key'])
			{
				$condition['title'] = 'Chave invalida';
				$condition['details'] = "Está chave não é valida para esta conta.";		
			}	
			else
			{
				$newpassword = $engine->random_key(8, 1);	
			
				$body = '
Caro jogador,
Todo o processo da Interface de Recuperação de Contas foi completado com sucesso e foi gerada uma nova senha para sua conta. Anote sua nova senha abaixo:
					
Nova senha: '.$newpassword.'
						
Para efetuar o login em sua conta acesse o endereço abaixo:						
'.GLOBAL_URL.'/index.php?page=account.login

Lembre-se que para manter sua conta sempre com maior nivel de segurança recomendamos que modifique a senha de acesso a cada '.RECOMENDED_CHANGEPASS_PERIOD.' dias.
					
Nós vemos no Darghos!
Equipe UltraxSoft.';	
						
				if (!mailex($account->getData("email"), 'Recuperação de Conta', $body))
				{
					$condition['title'] = "Falha ao enviar email!";
					$condition['details'] = "Ouve uma falha em nosso servidor de emails que impossibilitou o envio do seu email. A ultima operação foi anulada. Tente novamente mais tarde.";	
				}		
				else
				{
					$success = true;
					
					$account->setData('password', $engine->encrypt($newpassword));
					$account->update(array('password'));
					$account->ereaseChangePasswordKeys();
					
					$condition['title'] = 'Senha gerada com sucesso!';
					$condition['details'] = "Uma mensagem foi enviada ao e-mail cadastrado em sua conta contendo a nova senha de acesso gerada para sua conta. Este e-mail possui um prazo de até 24h para chegar mas normalmente chega neste instante. Tenha um bom jogo!";				
				}		
			}
		}
		
		echo '<br><center><table width="95%" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
		echo '<tr><td class=rank2>'.$condition['title'].'</td></tr>';
		echo '<tr><td class=rank3>'.$condition['details'].'';
		echo '</table><br>';

		if($success)
			echo '<a href="?page=account.main"><img src="images/back.gif" border="0"></a>';	
		else
			echo '<a href="?page=lostInterface"><img src="images/back.gif" border="0"></a>';			
	}
	else
	{
		echo '
		<br>
		<center>
		<table border="0" width="95%" CELLSPACING="1" CELLPADDING="2">
		Escreva abaixo a chave informada no e-mail da etapa passada junto com o numero da conta e clique no botão "Submit" e será lhe enviado uma mensagem ao endereço de e-mail contendo sua nova senha.
		</table>
		<br>

		<form method="POST" action="?page=lostInterface&step=confirmKey">
		<table width="95%" BORDER="0" CELLSPACING="1" CELLPADDING="4">
		<tr>
			<td class=rank2 colspan="2">Recuperação de Conta</td>
		</tr>
		<tr>
			<td class="rank3" width="35%">Chave:</td>
			<td class="rank3"><input name="key" type="text" value="" class="login" size="30"/></td>
		</tr>
		<tr>
			<td class="rank3" width="35%">Numero da Conta:</td>
			<td class="rank3"><input name="account" type="password" value="" class="login" size="30"/></td>
		</tr>	
		</table>
		<br>
		<input type="image" value="Entrar" src="images/submit.gif"/> 
		</form>
		
		<br>';	
	}
}
elseif($_GET["step"] == "4")
{
	$player = $engine->loadClass('Players');
	$player->loadByName($_SESSION['lostInterface']['character']);
	
	$account = $engine->loadClass('Accounts');
	$account->loadByNumber($player->getData("account_id"));	
	
	$success = false;
	
	if($account->getData("email") != $_POST['email'])
	{
		$condition['title'] = 'E-mail incorreto';
		$condition['details'] = "Este não é o endereço de e-mail registrado para esta conta.";		
	}	
	elseif($account->getData("id") != $_POST['account'])
	{
		$condition['title'] = 'Conta incorreta';
		$condition['details'] = "O numero da conta informado não corresponde ao numero da conta do personagem informado.";			
	}
	else
	{
		$key = $engine->random_key(8, 2, "upper+number");	
	
		$body = '
Caro jogador,
A solicitação para gerar uma nova senha para sua conta foi efetuada com sucesso! Para que seja gerada uma nova senha para sua conta basta acessar o endereço abaixo e preencher o formulario com a chave informada abaixo:
				
Chave para mudança de senha: '.$key.'
					
'.GLOBAL_URL.'/index.php?page=lostInterface&step=confirmKey

Atenção: Está chave será auto-destruida em 24 horas. Após este periodo será necessario obter uma nova chave repetindo todo o processo percorrido até aqui.
				
Nós vemos no Darghos!
Equipe UltraxSoft.';	
				
		if (!mailex($account->getData("email"), 'Recuperação de Conta', $body))
		{
			$condition['title'] = "Falha ao enviar email!";
			$condition['details'] = "Ouve uma falha em nosso servidor de emails que impossibilitou o envio do seu email. A ultima operação foi anulada. Tente novamente mais tarde.";			
		}		
		else
		{
			$success = true;
			
			$account->addChangePasswordKey($key);
			
			$condition['title'] = 'E-mail enviado com sucesso!';
			$condition['details'] = "Uma mensagem foi enviada ao e-mail cadastrado em sua conta contendo o proximo passo para gerar uma nova senha para sua conta. Este e-mail possui um prazo de até 24h para chegar mas normalmente chega neste instante. Tenha um bom jogo!";				
		}
	}
	
	echo '<br><center><table width="95%" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
	echo '<tr><td class=rank2>'.$condition['title'].'</td></tr>';
	echo '<tr><td class=rank3>'.$condition['details'].'';
	echo '</table><br>';

	if($success)
		echo '<a href="?page=account.main"><img src="images/back.gif" border="0"></a>';	
	else
		echo '<a href="?page=lostInterface"><img src="images/back.gif" border="0"></a>';		
}
elseif($_GET["step"] == "3")
{
	echo '
	<br>
	<center>
	<table border="0" width="95%" CELLSPACING="1" CELLPADDING="2">
	Escreva abaixo o e-mail registrado na conta do personagem junto o numero da conta e clique no botão "Submit" e será lhe enviado uma mensagem ao endereço de e-mail contendo as informações do proximo passo para gerar uma nova senha para sua conta.
	</table>
	<br>

	<form method="POST" action="?page=lostInterface&step=4">
	<table width="95%" BORDER="0" CELLSPACING="1" CELLPADDING="4">
	<tr>
		<td class=rank2 colspan="2">Recuperação de Conta</td>
	</tr>
	<tr>
		<td class="rank3" width="35%">Endereço de e-mail:</td>
		<td class="rank3"><input name="email" type="text" value="" class="login" size="30"/></td>
	</tr>
	<tr>
		<td class="rank3" width="35%">Numero da Conta:</td>
		<td class="rank3"><input name="account" type="password" value="" class="login" size="30"/></td>
	</tr>	
	</table>
	<br>
	<a href="?page=lostInterface"><img src="images/back.gif" border="0"></a> <input type="image" value="Entrar" src="images/submit.gif"/> 
	</form>
	
	<br>';
}
?>