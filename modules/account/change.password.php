<?
if($engine->loggedIn())
{
	echo '<tr><td class=newbar><center><b>:: Mudança de Senha ::</td></tr>
	<tr><td class=newtext><br>';	
	
	if ($_SERVER['REQUEST_METHOD'] == "POST")
	{
		$account = $engine->loadClass('Accounts');
		$account->loadByNumber($_SESSION['account']);			
	
		$success = false;
	
		if($_POST['new_password'] != $_POST['confirm_new_password'])		
		{
			$condition['title'] = 'Confirmação incorreta';
			$condition['details'] = "A confirmação da nova senha está incorreta, para modificar a sua senha com sucesso é necessario confirmar a nova senha corretamente.";		
		}
		elseif(strlen($_POST['new_password']) < 5 OR strlen($_POST['new_password']) > 25)
		{
			$condition['title'] = 'Quantidade de caracteres';
			$condition['details'] = "As nova senha para sua conta deve possuir entre 5 e 25 caracteres.";		
		}		
		elseif($engine->encrypt($_POST['new_password']) == $_SESSION['password'])
		{
			$condition['title'] = 'Senhas identicas';
			$condition['details'] = "A nova senha informada é igual a senha atualmente usada para sua conta, para modificar a senha de sua conta elas devem ser diferentes.";		
		}
		elseif($_SESSION['password'] != $engine->encrypt($_POST['password']))
		{
			$condition['title'] = 'Confirmação de senha incorreta';
			$condition['details'] = "Para modificar sua senha é necessario confirmar a senha atual!";			
		}
		else
		{
			$success = true;
			$account->setData('password', $engine->encrypt($_POST['new_password']));
			
			$account->update(array('password'));
			
			$_SESSION['password'] = $engine->encrypt($_POST['new_password']);
			
			$condition['title'] = 'Senha modificada com sucesso!';
			$condition['details'] = "A senha de acesso a sua conta foi modificada com sucesso!";	
		}	
		
		echo '<center><table width="95%" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
		echo '<tr><td class=rank2>'.$condition['title'].'</td></tr>';
		echo '<tr><td class=rank3>'.$condition['details'].'';
		echo '</table><br>';

		if($success)
			echo '<a href="?page=account.main"><img src="images/back.gif" border="0"></a>';	
		else
			echo '<a href="?page=account.changePassword"><img src="images/back.gif" border="0"></a>';						
	}
	else
	{
		echo '
		<center>
		<table border="0" width="95%" CELLSPACING="1" CELLPADDING="2">
		Para modificar sua senha preencha corretamente os campos abaixo.
		</table>
		<br>
		
		<form method="POST" action="?page=account.changePassword">
		<table width="95%" BORDER="0" CELLSPACING="1" CELLPADDING="4">
			<tr>
				<td class="rank2" colspan="2">Modificar senha</td>
			</tr>
			<tr>
				<td class="rank3" width="25%">Nova senha:</td>
				<td class="rank3" width="75%"><input name="new_password" type="password" value="" class="login" size="30"/></td>
			</tr>
			<tr>
				<td class="rank3" width="25%">Confirmar nova senha:</td>
				<td class="rank3" width="75%"><input name="confirm_new_password" type="password" value="" class="login" size="30"/></td>
			</tr>
			<tr>
				<td class="rank3" width="25%">Senha atual:</td>
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