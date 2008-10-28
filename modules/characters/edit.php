<?php
if($engine->loggedIn())
{	
	if(filtreString($_REQUEST['charname'],1) == 0)
	{
		echo "<h1>Erro!</h1><p>Personagem invalido.</p>";
		die;		
	}
	
	$query = mysql_query("SELECT * FROM players WHERE (account_id = '".$_SESSION['account']."' AND name = '".$_REQUEST['charname']."')") or die(mysql_error());
	if(mysql_num_rows($query) == 0)
	{
		echo "<h1>Erro!</h1><p>Personagem invalido.</p>";
		die;
	}

	if ($_SERVER['REQUEST_METHOD'] == "POST")
	{
		
		$com = filtreString(nl2br($_POST['comment']),0);
		$flogUrl = filtreString($_POST['flog_url'],0);
		
		if($_POST['hidechar'] == 1)
			$hide = 1;
		else
			$hide = 0;
		
		if ($com == '' or $com == NULL)
		{
			$com = NULL;
		}	
	
		echo '<tr><td class=newbar><center><b>:: Editar informações do personagem ::</td></tr>
		<tr><td class=newtext>';
	
		if(strlen($_POST['comment']) > 500)
		{
			echo '<br><center><table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
			echo '<tr><td class=rank2>Erro!</td></tr>';
			echo '</table>';
			echo '<center><table border="0" width="95%" bgcolor="black" CELLSPACING="1" CELLPADDING="2">';
			echo '<tr><td class=rank1>
			<br>O seu comentario não pode conter mais que 500 caracteres.';
			echo '</table>';
			echo '<br><a href="?page=account.main"><img src="images/back.gif" border="0"></a>';					
		}
		else
		{
			$DB->query("UPDATE players SET flog_url = '".$flogUrl."', comment = '".mysql_real_escape_string($com)."', hide = ".$hide." WHERE account_id = ".$_SESSION['account']." AND name = '".$_REQUEST['charname']."'");
			
			echo '<br><center><table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
			echo '<tr><td class=rank2>Informações editadas com exito!</td></tr>';
			echo '</table>';
			echo '<center><table border="0" width="95%" bgcolor="black" CELLSPACING="1" CELLPADDING="2">';
			echo '<tr><td class=rank1>
			<br>As informações de seu personagem foram editadas com exito!';
			echo '</table>';
			echo '<br><a href="?page=account.main"><img src="images/back.gif" border="0"></a>';							
		}
	}
	else 
	{

		$sql = mysql_fetch_assoc($query);
		?>

<tr><td class=newbar><center><b>:: Editar informações do personagem ::</td></tr>
<tr><td class=newtext>		
		
		<form action="?page=character.edit&charname=<?= $_REQUEST['charname'];?>" method="POST">

		<br><center><table border="0" width="95%" CELLSPACING="1" CELLPADDING="2">
		Aqui você podera editar as informações sobre seu personagem.<br>
		Se você nao quiser especificar algum campo, apenas o deixe em branco.
		</table>		
		
		<br><center><table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="4">	
		<tr><td colspan=3 class=rank2>Editar informações do personagem</td></tr>
		<tr><td width="25%" class=rank1>Nome:</td><td width="75%" class=rank1><? echo ''.$_REQUEST['charname'].'';?></td></tr>
		<tr><td width="25%" class=rank1 WIDTH=20% VALIGN=top>Comentarios:</td><td width="25%" class=rank1><TEXTAREA CLASS=login NAME="comment" ROWS=10 COLS=50 WRAP="virtual" MAXLENGTH="350">
		<?
		$getcomment = mysql_query("SELECT * FROM players WHERE (name = '".$_REQUEST['charname']."')") or die(mysql_error());
		$comment = mysql_fetch_array($getcomment);
		echo ''.$comment['comment'].'';
		?>
		</textarea></td></tr>	
		<tr><td width="25%" class=rank1>Flog URL:</td><td width="25%" class=rank1><INPUT CLASS=login TYPE=text NAME="flog_url" value="http://" size="45"><font size=1><br>(ie: www.www.flogao.com.br/meuchar)</td></tr>
		<tr><td width="25%" class=rank1>Esconder:</td><td width="25%" class=rank1><INPUT CLASS=login TYPE=checkbox NAME="hidechar" CHECKED VALUE="1"> selecione para esconder este personagem de sua conta</td></tr>	
		</table>
		
		<br><input type="image" value="submit" src="images/submit.gif"/> <a href="?page=account.main"><img src="images/back.gif" border="0"></a>


		</form>


		<?
	}
}
?>