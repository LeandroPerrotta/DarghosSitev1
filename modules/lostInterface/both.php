<?
if($_GET["step"] == "4")
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
	else
	{
		$key = $engine->random_key(8, 2, "upper+number");	
	
		$body = '
Caro jogador,
A solicitação de recuperação do numero de sua conte e senha efetuada com sucesso! Abaixo segue o numero de sua conta. Para que seja gerada uma nova senha para sua conta basta acessar o endereço abaixo e preencher o formulario com a chave informada abaixo:
		
Número da conta: '.$account->getData("id").'		
Chave para gerar nova senha: '.$key.'
					
Endereço para gerar nova senha:					
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
			$condition['details'] = "Uma mensagem foi enviada ao e-mail cadastrado em sua conta contendo o numero de sua conta além do proximo passo para gerar uma nova senha para sua conta. Este e-mail possui um prazo de até 24h para chegar mas normalmente chega neste instante. Tenha um bom jogo!";				
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
	Escreva abaixo o e-mail registrado na conta do personagem e clique no botão "Submit" e será lhe enviado uma mensagem ao endereço de e-mail contendo as informações para prosseguir na recuperação de sua conta.
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
	</table>
	<br>
	<a href="?page=lostInterface"><img src="images/back.gif" border="0"></a> <input type="image" value="Entrar" src="images/submit.gif"/> 
	</form>
	
	<br>';
}
?>