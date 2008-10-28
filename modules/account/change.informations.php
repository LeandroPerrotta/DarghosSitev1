<?
if($engine->loggedIn())
{
	echo '<tr><td class=newbar><center><b>:: Informações Personalizadas ::</td></tr>
	<tr><td class=newtext><br>';
	
	$account = $engine->loadClass('Accounts');
	$account->loadByNumber($_SESSION['account']);	

	if ($_SERVER['REQUEST_METHOD'] == "POST")
	{
		$success = false;
	
		if(!$engine->filtreString($_POST['real_name']) OR !$engine->filtreString($_POST['location']) OR !$engine->filtreString($_POST['url']))		
		{
			$condition['title'] = 'Sintaxes reservadas';
			$condition['details'] = "O seu formulario contem o uso de sintaxes reservadas ao sistema interno. Por favor tente novamente com outros valores.";		
		}	
		else
		{
			$success = true;
			$account->setData('real_name', $_POST['real_name']);
			$account->setData('location', $_POST['location']);
			$account->setData('url', $_POST['url']);
			
			$account->update(array('real_name','location','url'));
			
			$condition['title'] = 'Informações publicas editadas com sucesso!';
			$condition['details'] = "As informações publicas de sua conta foram modificadas com sucesso!";	
		}	
		
		echo '<center><table width="95%" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
		echo '<tr><td class=rank2>'.$condition['title'].'</td></tr>';
		echo '<tr><td class=rank3>'.$condition['details'].'';
		echo '</table><br>';

		if($success)
			echo '<a href="?page=account.main"><img src="images/back.gif" border="0"></a>';	
		else
			echo '<a href="?page=account.changeInformations"><img src="images/back.gif" border="0"></a>';						
	}
	else
	{
		echo '
		<center>
		<table border="0" width="95%" CELLSPACING="1" CELLPADDING="2">
		Preencha os campos abaixo para editar as informações publicas de sua conta. Estas informações estarão disponiveis a todos que acessarem o profile de algum de seus personagens.
		</table>
		<br>
		
		<form method="POST" action="?page=account.changeInformations">
		<table width="95%" BORDER="0" CELLSPACING="1" CELLPADDING="4">
			<tr>
				<td class="rank2" colspan="2">Editar informações publicas da conta</td>
			</tr>
			<tr>
				<td class="rank3" width="25%">Nome Real:</td>
				<td class="rank3" width="75%"><input name="real_name" type="text" value="'.$account->getData('real_name').'" class="login" size="30"/></td>
			</tr>
			<tr>
				<td class="rank3" width="25%">Localização:</td>
				<td class="rank3" width="75%"><input name="location" type="text" value="'.$account->getData('location').'" class="login" size="30"/></td>
			</tr>
			<tr>
				<td class="rank3" width="25%">Endereço na Web:</td>
				<td class="rank3" width="75%"><input name="url" type="text" value="'.$account->getData('url').'" class="login" size="30"/></td>
			</tr>			
		</table><br>
		<input type="image" value="Entrar" src="images/submit.gif"/> 
		<a href="?page=account.main"><img src="images/back.gif" border="0"></a>	
		</form>	 
		';		
	}
}
?>	