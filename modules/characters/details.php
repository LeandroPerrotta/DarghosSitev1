<?
unset($char);
unset($acc_id);
$char = trim($_REQUEST['char']);
$acc_id = trim($_REQUEST['acc']);
$account = $_SESSION['account'];
$password = $_SESSION['password'];

echo '<tr><td class=newbar><center><b>:: '.$lang['characters_title'].'::</td></tr>
<tr><td class=newtext><br><center>';	

if (!get_magic_quotes_gpc()) 
{
	$char = addslashes($char);
}

if($char or $acc_id)
{	
	if($char)
		$player_query = mysql_query("SELECT * FROM `players` WHERE (`name` = '$char') ");
	else
		$player_query = mysql_query("SELECT * FROM `players` WHERE (`account_id` = '$acc_id') order by level desc ");
		
	if(mysql_num_rows($player_query)==0) 
	{
		echo '<center><table width="95%" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
		echo '<tr><td class=rank2 width="75%">'.$lang['character_notExists'].'</td></tr>';
		echo '<tr class=rank3><td width="75%">'.$lang['character_notExists1'].' <b>'.$char.'</b> '.$lang['character_notExists2'].'</td></tr>';
		echo '</table><br>';	
	} 
	else 	
	{				
		$player_sql = mysql_fetch_array($player_query);
		$player_id = $player_sql['id'];
		
		$account_query = mysql_query("SELECT * FROM `accounts` WHERE (`id` = '".$player_sql['account_id']."') ") or die(mysql_error());
		$account_sql = mysql_fetch_array($account_query);
		
		$guildrank_query = mysql_query("SELECT * FROM `guild_ranks` WHERE (`id` = '".$player_sql['rank_id']."') ") or die(mysql_error());
		$guildrank_sql = mysql_fetch_array($guildrank_query);	
		
		$guild_query = mysql_query("SELECT * FROM `guilds` WHERE (`id` = '".$guildrank_sql['guild_id']."') ") or die(mysql_error());
		$guild_sql = mysql_fetch_array($guild_query);
		
		$deletion_query = mysql_query("SELECT * FROM `player_deletion` WHERE (`player_id` = '$player_id') ") or die(mysql_error());
		$deletion_sql = mysql_fetch_object($deletion_query);
		
		$guildInvites_query = mysql_query("SELECT `name`,`id` FROM guilds INNER JOIN `guild_invites` ON guilds.`id` = guild_invites.`guild_id` WHERE guild_invites.`player_id` = '".$player_id."'") or die(mysql_error());
		$guildInvites_sql = mysql_fetch_object($guildInvites_query);		
		
		

		if ($player_sql['lastlogin'] != 0) 
			$lastlog = date('M d Y, H:i:s',$player_sql['lastlogin']);
		else 
			$lastlog = 'never';
		
		echo '<table width=95% border=0 cellspacing="1" cellpadding="4">';
		$sexs = Tolls::getSex($player_sql['sex']);
		$vocations = Tolls::getVocation($player_sql['vocation']);
		$world = Tolls::getWorld($player_sql['server']);
		$town = Tolls::getTown($player_sql['town_id']);
		$group = Tolls::getGroup($account_sql['group_id']);
		$pvpmode = Tolls::getPvpMode($player_sql['pvpmode']);
		
		echo '<tr class=rank2><td colspan="2">'.$lang['character_information'].'</td></tr>';
		echo '<tr class=rank3><td width=20%>'.$lang['name'].':</td><td>'.$player_sql['name'].'</td></tr>';
		if($player_sql['old_name'] != "" or $player_sql['old_name'] != null)
			echo '<tr class=rank3><td>'.$lang['old_name'].':</td><td>'.$player_sql['old_name'].'</td></tr>';
		
		if(mysql_num_rows($deletion_query) != 0)
		echo '<tr class=rank3><td>'.$lang['deleted'].':</td><td><font color="red">'.$lang['deleted_in'].': '.date('M d Y, H:i:s',$deletion_sql->time).'</font></td></tr>';						
		echo '<tr class=rank1><td>'.$lang['sex'].':</td><td>'.$sexs.'</td></tr>';
		
		echo '<tr class=rank3><td>'.$lang['level'].':</td><td>'.$player_sql['level'].'</td></tr>';
		
		echo '<tr class=rank1><td>'.$lang['player_vs'].':</td><td>'.$pvpmode.'</td></tr>';
		
		echo '<tr class=rank1><td>'.$lang['profession'].':</td><td>'.$vocations.'</td></tr>';
		echo '<tr class=rank3><td>'.$lang['residence'].':</td><td>'.$town.'</td></tr>';

		if(mysql_num_rows($guildInvites_query) != 0)
		{
			echo '<tr class=rank1><td>'.$lang['guild_status'].':</td><td>Invited to <a href="?page=community.guildDetails&guildid='.$guildInvites_sql->id.'">'.$guildInvites_sql->name.'</a></td></tr>';
		}
		else
		{
			if($player_sql['rank_id'] == $guildrank_sql['id'])
				echo '<tr class=rank1><td>'.$lang['guild_status'].':</td><td>'.$guildrank_sql['name'].' '.$lang['guild_of_the'].' <a href="?page=community.guildDetails&guildid='.$guild_sql['id'].'">'.$guild_sql['name'].'</a></td></tr>';
			else
				echo '<tr class=rank1><td>'.$lang['guild_status'].':</td><td>None</td></tr>';
		}		
			
		echo '<tr class=rank3><td>'.$lang['last_login'].':</td><td>'.$lastlog.'</td></tr>';		
		echo '<tr class=rank1><td>'.$lang['position'].':</td><td>'.$group.'</font></td></tr>';

		if($player_sql['comment'] != '')
		{
			$comment = $player_sql['comment'];
			$comentario = nl2br($comment);
			echo '<tr class=rank3><td>'.$lang['comment'].':</td><td>'.$comentario.'</td></tr>';
		}
		
		if($player_sql['flog_url'] != '')
		{
			echo '<tr class=rank3><td>'.$lang['flogUrl'].':</td><td><a href="'.$player_sql['flog_url'].'">'.$player_sql['flog_url'].'</a></td></tr>';
		}
		
		$ban_query = mysql_query("SELECT * FROM `bans` WHERE (`player` = '".$player_sql['name']."' || `account` = '".$account_sql['id']."')");
		$ban_sql = mysql_fetch_object($ban_query);		
		
		$reason = Tolls::getReason($ban_sql->reason_id);	
		$banned_by = ''.Bans::getName($ban_sql->banned_by).'';
			
		if(mysql_num_rows($ban_query) != 0)
		{
			$bandate = date('M d Y, H:i:s',$ban_sql->time);
			echo '<tr><td class=rank1 width=30%><font size=2>'.$lang['ban_status'].':</font></td><td class=rank1><font color=FF0000 size=2>'.$lang['ban_at'].': '.$bandate.'</td></font></tr>';
			echo '<tr><td class=rank3 width=30%><font size=2>'.$lang['ban_reason'].':</font></td><td class=rank1><font color=FF0000 size=2>'.$reason.'</td></font></tr>';

			if (Account::isLogged($account,$password) or Account::isAdmin($account))
			{
				if($ban_sql->reason_id != 28)
					echo '<tr><td class=rank1 width=20%><font size=2>'.$lang['ban_by'].':</font></td><td class=rank1><font color=FF0000 size=2>'.$banned_by.'</td></font></tr>';
				
				echo '<tr><td class=rank3 width=20%><font size=2>'.$lang['ban_comment'].':</font></td><td class=rank1><font color=FF0000 size=2>'.$ban_sql->comment.'</td></font></tr>';
			}		
		}
		if($account_sql['premdays'] > 0 )
			echo '<tr class=rank1><td>'.$lang['account_status'].':</td><td>Premium Account</td></tr>';
		else
			echo '<tr class=rank1><td>'.$lang['account_status'].':</td><td>Free Account</td></tr>';				
		echo '</table><br>';

		if(Account::isAdmin($account))
		{
			if($account_sql['type'] != 6)
			{
				echo '<table width=95% border=0 cellspacing="1" cellpadding="4">';
				echo '<tr class=rank2><td colspan=2>Painel de Administradores:</td></tr>';
				echo '<tr class=rank3><td width=20%>Account:</td><td>'.$account_sql['id'].'</td></tr>';	
			//	echo '<tr class=rank1><td width="20%">Hashe:</td><td>'.$account_sql['password'].'2d</td></tr>';	
				echo '<tr class=rank1><td width=20%>Player ID:</td><td>'.$player_sql['id'].'</td></tr>';	
				echo '<tr class=rank3><td width=20%>Dias de Premium:</td><td>'.$account_sql['premdays'].'</td></tr>';	
				echo '<tr class=rank3><td width=20%>Possui House:</td><td>'.$account_sql['hasHouse'].'</td></tr>';	
				echo '<tr class=rank1><td width=20%>Email:</td><td>'.$account_sql['email'].'</td></tr>';	
				echo '<tr class=rank3><td width=20%>Email:</td><td>'.$account_sql['new_email'].'</td></tr>';	
				echo '<tr class=rank1><td width=20%>Criação da conta:</td><td>'.date('d/m/Y',$account_sql['creation']).'</td></tr>';
				echo '<tr class=rank3><td width=20%>Ultima atualização:</td><td>'.date('M d Y, H:i:s',$account_sql['lastday']).'</td></tr>';			
				echo '<tr class=rank1><td width=20%>Alertas:</td><td>'.$account_sql['warnings'].'</td></tr>';	
				echo '<tr class=rank3><td width=20%>Nome:</td><td>'.$account_sql['firstname'].' '.$account_sql['secondname'].'</td></tr>';	
				echo '<tr class=rank1><td width=20%>Localidade:</td><td>'.$account_sql['estado'].'/'.$account_sql['cidade'].'</td></tr>';	
				echo '<tr class=rank3><td width=20%>Idade:</td><td>'.$account_sql['age'].'</td></tr>';			
				if($account_sql['rk_number'] != 0)
				$rk_num = 'gerada';
				else
				$rk_num = 'não gerada';
				echo '<tr class=rank1><td width=20%>Recovery Key:</td><td>'.$rk_num.'</td></tr>';	
				echo '</table><br>';
			}			
		}	
						
		if($account_sql['rlname'] != '' && $account_sql['location'] != '')
		{	
			echo '<table width=95% border=0 cellspacing="1" cellpadding="4">';
			echo '<tr class=rank2><td colspan="2">'.$lang['account_information'].'</td></tr>';
			echo '<tr class=rank3><td width=20%>'.$lang['rl_name'].':</td><td>'.$account_sql['rlname'].'</td></tr>';
			echo '<tr class=rank1><td>'.$lang['country'].':</td><td>'.$account_sql['location'].'</td></tr>';
			
			if($account_sql['url'] == '' )
			{		
				echo '<tr class=rank3><td>Website:</td><td>None</td></tr>';
			}
			
			else
			{
				echo '<tr class=rank3><td>Website:</td><td>'.$account_sql['url'].'</td></tr>';
			}
			echo '</table>';
		}					
					
		$death_query = mysql_query("SELECT * FROM player_deaths WHERE (player_id = '".$player_sql['id']."') ORDER BY time");
		if(mysql_num_rows($death_query) != 0)
		{
			

			echo '<br><table width=95% border=0 cellspacing="1" cellpadding="4">';
			echo '<tr class=rank2><td colspan="2">'.$lang['character_deaths'].'</td></tr>';
			
			while($death_sql = mysql_fetch_array($death_query))
			{
				$t++;
				$style = rotateStyle($t);	
				
				$tempname = $death_sql['killed_by'];
				$templvl = $death_sql['level'];
				$tempAction = $death_sql['is_player'];
				
				if($tempname == "-1")
					$tempname = "Fire Field";				
						
				if ($tempname && $templvl) 
				{
					if ($tempAction == 0) 
					{					
						echo "<tr class=".$style."><td>".$lang['killed_at']." $templvl ".$lang['by_a']." $tempname (" .date('M d Y, H:i:s',$death_sql['time']). ").</td></tr>";
					}
					else
					{
						echo "<tr class=".$style."><td>".$lang['killed_at']." $templvl ".$lang['by']." <a href=\"?page=character.details&char=$tempname\"><b>$tempname</b></a> (" .date('M d Y, H:i:s',$death_sql['time']). ").</td></tr>";				
					}
				}
				
			}
			echo '</table>';	
		}

		if(Account::isAdmin($account))
			$acc_query = mysql_query("SELECT * FROM `players` WHERE (`account_id` = '".$player_sql['account_id']."') ") or die(mysql_error());
		else
			$acc_query = mysql_query("SELECT * FROM `players` WHERE (`account_id` = '".$player_sql['account_id']."' and hide = '0') ") or die(mysql_error());
		$i=1;

		if(mysql_num_rows($acc_query) != 0)
		{	
			echo '<br><table width=95% border=0 cellspacing="1" cellpadding="4">';
			echo '<tr class=rank2><td colspan="4">'.$lang['other_characters'].'</td></tr>';
			echo '<tr class=rank1><td width=65%><b>'.$lang['name'].'</td><td width=15%><b>'.$lang['world'].'</td><td width=5%><b>'.$lang['level'].'</td><td width=15%><b>Status</td></tr>';

			
			while($acc_sql = mysql_fetch_array($acc_query))
			{
				$t++;
				$style = rotateStyle($t);	

				$world = Tolls::getWorld($acc_sql['server']);
				if($acc_sql['online'] != 0)
				{
					$online = '<font color="green"><b>Online</b></font>';
				}
				else
				{
					$online = '<font color="red"><b>Offline</b></font>';
				}	

				echo '<tr class="'.$style.'"><td>'.$i.'. <a href="?page=character.details&char='.$acc_sql['name'].'">'.$acc_sql['name'].'</a></td><td>'.$world.'</td><td>'.$acc_sql['level'].'</td><td>'.$online.'</td></tr>';
				$i++;		
			}		
			echo '</table>';
		}
	}	
}

echo '<form method="post" action="?page=character.details">';
echo '<center><table width="95%" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
echo '<tr><td class=rank2 width="75%">'.$lang['search_character'].'</td></tr>';
echo '<tr class=rank3><td width="75%">'.$lang['name'].' <input class="login" type="text" name="char" maxlength="20" /> <input type="image" value="submit" src="images/submit.gif"/></td></tr>';

if(Account::isAdmin($account))
	echo '<tr class=rank3><td width="75%">Account: <input class="login" type="text" name="acc" maxlength="20" /> <input type="image" value="submit" src="images/submit.gif"/></td></tr>';

echo '</table><br>';
echo '</form>';
?>