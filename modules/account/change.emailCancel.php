<?
if($engine->loggedIn())
{
	$account = $_SESSION['account'];
	$password = $_SESSION['password'];

	echo '<tr><td class=newbar><center><b>:: Cancelamento de mudança de e-mail ::</td></tr>
	<tr><td class=newtext><br>';

	if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		$account = $engine->loadClass('Accounts');
		$account->loadByNumber($_SESSION['account']);	
		
		$success = false;
	
		if($_SESSION['password'] != md5($_POST['password']))
		{
			$condition['title'] = 'Confirmação de senha incorreta';
			$condition['details'] = "Para cancelar uma mudança de e-mail é necessario confirmar sua senha corretamente por motivos de segurança.";		
		}
		else
		{
			$success = true;
			$account->cancelChangeEmail();
			
			$condition['title'] = 'Mudança cancelada com sucesso!';
			$condition['details'] = "A mudança de e-mail registrada para sua conta foi cancelada com sucesso.";				
		}		
	
		echo '<center><table width="95%" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
		echo '<tr><td class=rank2>'.$condition['title'].'</td></tr>';
		echo '<tr><td class=rank1>'.$condition['details'].'';
		echo '</table><br>';

		if($success)
			echo '<a href="?page=account.main"><img src="images/back.gif" border="0"></a>';	
		else
			echo '<a href="?page=account.cancelChangeEmail"><img src="images/back.gif" border="0"></a>';			
	}
	else
	{
		echo '
		<center>		
		<form method="POST" action="?page=account.cancelChangeEmail">
		<table width="95%" BORDER="0" CELLSPACING="1" CELLPADDING="4">
			<tr>
				<td class="rank2" colspan="2">Cancelar mudança de e-mail</td>
			</tr>
			<tr>
				<td class="rank3" width="25%">Senha:</td>
				<td class="rank3" width="75%"><input name="password" type="password" value="" class="login" size="30"/></td>
			</tr>
		</table><br>
		<input type="image" value="Entrar" src="images/submit.gif"/> 
		<a href="?page=account.main"><img src="images/back.gif" border="0"></a>	
		</form>	 
		';	
	}
}	
?>	