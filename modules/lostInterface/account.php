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
	elseif($account->getData("password") != $engine->encrypt($_POST['password']))
	{
		$condition['title'] = 'Senha incorreta';
		$condition['details'] = "A senha de acesso informada não corresponde a senha de acesso registrada para esta conta.";			
	}
	else
	{
		$body = '
Caro jogador,
A recuperação do numero de sua conta foi efetuada com sucesso! Abaixo segue o número de sua conta:
				
Número de conta: '.$account->getData("id").'
					
Para acessar sua conta acesse:
'.GLOBAL_URL.'/index.php?page=account.login
				
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
			
			$condition['title'] = 'E-mail enviado com sucesso!';
			$condition['details'] = "Uma mensagem foi enviada ao e-mail cadastrado em sua conta contendo o numero da conta para acesso. Este e-mail possui um prazo de até 24h para chegar mas normalmente chega neste instante. Tenha um bom jogo!";				
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
	Escreva abaixo o e-mail registrado na conta do personagem junto com a atual senha de acesso e clique no botão "Submit" e será lhe enviado uma mensagem ao endereço de e-mail contendo o numero de sua conta.
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
		<td class="rank3" width="35%">Senha:</td>
		<td class="rank3"><input name="password" type="password" value="" class="login" size="30"/></td>
	</tr>	
	</table>
	<br>
	<a href="?page=lostInterface"><img src="images/back.gif" border="0"></a> <input type="image" value="Entrar" src="images/submit.gif"/> 
	</form>
	
	<br>';
}
?>