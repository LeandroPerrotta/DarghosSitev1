<?
echo '<tr><td class=newbar><center><b>:: '.$page["subTitle"].' ::</td></tr>
<tr><td class=newtext><br>';

if ($_SERVER['REQUEST_METHOD'] == "POST")
{
	$success = false;
	
	if($_SESSION['password'] != $engine->encrypt($_POST['password']))
	{
		$condition['title'] = 'Confirmação de senha incorreta';
		$condition['details'] = "Para agendar uma mudança de e-mail é necessario confirmar sua senha corretamente por motivos de segurança.";		
	}	
	else
	{
		$query = mysql_query("SELECT id, premdays, lastday FROM accounts WHERE premdays > 0");

		while($fetch = mysql_fetch_object($query))
		{		
			$daysToRemove = ((time() - $fetch->lastday) / 86400) > 0 ? (int)((time() - $fetch->lastday) / 86400) : 0;
			$newDays = ($fetch->premdays - $daysToRemove) > 0 ? ($fetch->premdays - $daysToRemove) : 0;
			
			if($newDays == 0)
			{
				mysql_query("UPDATE players SET town_id = '".$citys['quendor']['id']."', posx = '".$citys['quendor']['x']."', posy = '".$citys['quendor']['y']."', posz = '".$citys['quendor']['z']."' WHERE account_id = '".$fetch->id."' AND town_id != '3'");
				mysql_query("UPDATE accounts SET premdays = '0', lastday = '".time()."', premFree = '0' WHERE id = ".$fetch->id."");
				$free++;
			}
			else
			{
				mysql_query("UPDATE accounts SET premdays = '".$newDays."', lastday = '".time()."' WHERE id = ".$fetch->id."");
				$updated++;			
			}
			$accounts++;
		}
		
		$success = true;
		
		$condition['title'] = 'Operação efetuada com sucesso!';
		$condition['details'] = "Todas contas que possuiam premium days foram atualizadas com sucesso! Segue abaixo o relatorio:
			<p>Total de contas modificadas: $accounts</p>
			<p>Total de contas com premdays atualizados: $updated</p>
			<p>Total de contas que tiveram sua premium account expirada e os personagens enviados a Quendor: $free</p>";			
	}
	
	echo '<center><table width="95%" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
	echo '<tr><td class=rank2>'.$condition['title'].'</td></tr>';
	echo '<tr><td class=rank3>'.$condition['details'].'';
	echo '</table><br>';

	if($success)
		echo '<a href="?page=account.main"><img src="images/back.gif" border="0"></a>';	
	else
		echo '<a href="?page=admin.updateAllAccounts"><img src="images/back.gif" border="0"></a>';		
}
else
{
	echo '
	<center>
	<table border="0" width="95%" CELLSPACING="1" CELLPADDING="2">
	<p>Este recurso tem a função, de efetuar de modo manual, uma atualização geral de todas contas do servidor, efetuando as seguintes operações:</p>
	<li>Contagem e Atualização dos premium days de todas conta.</li>
	<li>Envio dos personagens que tiverem a premium expirada para cidade Free Account.</li>
	<p>Nota: É recomendavel que este recurso seja efetuado apénas com o servidor OFFLINE.</p>
	</table>
	<br>

	<form method="POST" action="?page=admin.updateAllAccounts">
	<table width="95%" BORDER="0" CELLSPACING="1" CELLPADDING="4">
		<tr>
			<td class="rank2" colspan="2">Confirmar senha</td>
		</tr>
		<tr>
			<td class="rank3" width="25%">Senha:</td>
			<td class="rank3" width="75%"><input name="password" type="password" value="" class="login" size="30"/></td>
		</tr>
	</table><br>
	<input type="image" value="Entrar" src="images/submit.gif"/> 	
	';		
	
}