<?
if($engine->accountAccess() >= GROUP_GAMEMASTER)
{
	echo '<tr><td class=newbar><center><b>:: Gerenciamento de Tutores ::</td></tr>
	<tr><td class=newtext><br>';
	if ($_SERVER['REQUEST_METHOD'] == "POST")
	{
		$name = filtreString($_POST['name'],0);
		
		if($_POST['action'] == 1)
		{
			$query = mysql_query("SELECT * FROM `players` WHERE `name` = '$name'") or die(mysql_error());
			$fetch = mysql_fetch_object($query);

			$limitTutors_query = mysql_query("SELECT * FROM `player_tutors` WHERE `superior_id` = '$account'") or die(mysql_error());
			$superior_fetch = mysql_fetch_object($query);	
			
			if(mysql_num_rows($query) == 0)
			{
				$condition = 'Erro';
				$conteudo = 'Personagem inexistente';
			}
			elseif(Account::isGM($account) and mysql_num_rows($limitTutors_query) > 3 or Account::isCM($account) and mysql_num_rows($limitTutors_query) > 9)
			{
				$condition = 'Erro';
				$conteudo = 'Você ja possui o numero maximo de tutores promovidos!';	
			}
			elseif($fetch->group_id > 1)
			{
				$condition = 'Erro';
				$conteudo = 'Personagem já foi promovido!';	
			}			
			else
			{
				mysql_query("UPDATE `players` SET group_id = '2', tutor_time = '".time()."' WHERE (`name` = '$name')");
				mysql_query("UPDATE `accounts` SET type = '2', group_id = '2' WHERE (`id` = '".$fetch->account_id."')");
				mysql_query("INSERT INTO player_tutors(player_id,superior_id) values('".$fetch->id."','$account')") or die(mysql_error());	
				$condition = 'Sucesso!';
				$conteudo = 'O jogador '.$name.' foi promovido a tutor com exito!';					
			}
		}
		else
		{
			$query = mysql_query("SELECT * FROM `players` WHERE `name` = '$name' and `group_id` = '2'") or die(mysql_error());
			$fetch = mysql_fetch_object($query);

			$superior_query = mysql_query("SELECT * FROM `player_tutors` WHERE `player_id` = '".$fetch->id."' and `superior_id` = '$account'") or die(mysql_error());
			$superior_fetch = mysql_fetch_object($query);

			if(mysql_num_rows($query) == 0)
			{
				$condition = 'Erro';
				$conteudo = 'Personagem inexistente ou não é um tutor.';
			}
			elseif($fetch->group_id > 2)
			{
				$condition = 'Erro';
				$conteudo = 'Personagem não pode ser despromovido!';	
			}
			elseif(Account::isGM($account) and mysql_num_rows($superior_query) == 0)
			{
				$condition = 'Erro';
				$conteudo = 'Este tutor não esta sob sua supervisão.';	
			}			
			else
			{
				mysql_query("UPDATE `players` SET group_id = '0' WHERE (`name` = '$name')");
				mysql_query("UPDATE `accounts` SET group_id = '1', type = '1' WHERE (`id` = ".$fetch->account_id.")");
				mysql_query("DELETE FROM player_tutors WHERE (`player_id` = '".$fetch->id."')");
				$condition = 'Sucesso!';
				$conteudo = 'O jogador '.$name.' foi despromovido com exito!';					
			}		
		}
		echo '<center><table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
		echo '<tr><td class=rank2>'.$condition.'</td></tr>';
		echo '</table>';
		echo '<center><table border="0" width="95%" bgcolor="black" CELLSPACING="1" CELLPADDING="2">';
		echo '<tr><td class=rank1>'.$conteudo.'</td></tr>';
		echo '</table>';
		echo '<br><a href="?page=admin.tutorsManager"><img src="'.$back_button.'" border="0"></a>';				
	}
	else
	{
		echo '<center><table border="0" width="95%" CELLSPACING="1" CELLPADDING="2">
	Membros da equipe podem ultilizar este recurso para promover jogadores enteressados em ajudar a comunidade do UltraX a tutores.<br><br>Obs: Note que para a promoção ser feita com sucesso o jogador que sera promovido deve estar offline.
	</table><br>';
		echo '<center><table width="85%" border="0" bgcolor="black" cellpadding="2" cellspacing="1">';
		echo '<tr class="rank2"><td colspan="4"><b>Lista de Tutores:</td></tr>';
		echo '<tr class="rank1"><td width="50%"><b>Nome:</td><td><b>Supervisor:</b></td><td><b>Desde:</b></td><td></td></tr>';
		
		$query = mysql_query("SELECT * FROM `players` WHERE `group_id` = '2'") or die(mysql_error());
		
		if(mysql_num_rows($query) != 0)
		while($fetch = mysql_fetch_object($query))
		{
			$tutorInfo_query = mysql_query("SELECT * FROM `player_tutors` WHERE `player_id` = '".$fetch->id."'") or die(mysql_error());
			$tutorInfo_fetch = mysql_fetch_object($tutorInfo_query);

			$superiorInfo_query = mysql_query("SELECT * FROM `players` WHERE `account_id` = '".$tutorInfo_fetch->superior_id."' order by level desc ") or die(mysql_error());	
			$superiorInfo_fetch = mysql_fetch_object($superiorInfo_query);
			
			if($fetch->online == 1)
				$status = "<font color=green><b>Online</b></font>";
			else	
				$status = "Offline";
				
			echo '<tr class="rank1"><td><a href="?page=character.details&char='.$fetch->name.'">'.$fetch->name.'</a></td><td>'.$superiorInfo_fetch->name.'</td><td>'.date("M d Y", $fetch->tutor_time).'</td><td>'.$status.'</td></tr>';
		}
		else
			echo '<tr class="rank1"><td>Nenhum tutor ativo no momento.</td></tr>';
		
		echo '</table>';
		
		echo '<form action="?page=admin.tutorsManager" method="post">';
		echo '<br><center><table width="85%" border="0" bgcolor="black" cellpadding="2" cellspacing="1">';
		echo '<tr class="rank2"><td colspan="3"><b>Gerenciar tutor:</td></tr>';	
		echo '<tr class=rank1><td width="10%">Player:</td><td width="50%" class=rank1><input class="login" name="name" type="text" value="" size="30"/></td></tr>';
		echo '<tr class=rank1><td width="10%">Ação:</td><td width="10%"><select name="action"><option value="1">Promover</option><option value="0">Despromover</option></select></td></tr>';
		echo '</table>';
		echo '<br><input align="center" type="image" value="Entrar" src="images/submit.gif"/>';
	}
}	
?>