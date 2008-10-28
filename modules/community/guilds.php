<?
echo '<tr><td class=newbar><center><b>:: '.$lang['guilds_title'].' ::</td></tr>';
echo '<tr><td class=newtext>';

if ($_GET['action'] == 'create')
{	
	if(Account::isLogged($account,$password) and Account::isPremium($account))
	{
		if ($_SERVER['REQUEST_METHOD'] == "POST")
		{
			if(filtreString($_POST['name'],1) == 0)		
			{
				$condition = "Invalid syntax!";
				$conteudo = "This guild name contains invalid syntax. Please try again with another guild name.";
			}			
			elseif(!Account::passCheck($account,md5($_POST['password'])))
			{
				$condition = 'Password error!';
				$conteudo = 'This password is not correct.';
			}	
			elseif(!Guilds::checkLeader($account))
			{
				$condition = 'Already have a leader!';
				$conteudo = 'Is only allowed one leader or vice-leader per account.';
			}	
			elseif(!Guilds::checkName($_POST['name']))
			{
				$condition = 'Name already used!';
				$conteudo = 'The name '.$_POST['name'].' already used by another guild.';
			}					
			elseif(Guilds::hasMember(Player::getPlayerNameById($_POST['leader'])))
			{
				$condition = 'Already member!';
				$conteudo = 'The character '.Player::getPlayerNameById($_POST['leader']).' already member of other guild.';
			}				
			else
			{
				Guilds::create($_POST['name'], $_POST['leader']);
				$condition = 'Guild founded!';
				$conteudo = 'You have founded the <b>'.$_POST['name'].'</b>. Now go ahead and invite first members. Note that the guild will be deleted if it does not become active within three days.';					
			}		
			echo '<br><center><table width="95%"BORDER="0" CELLSPACING="1" CELLPADDING="4">';
			echo '<tr><td class="rank2">'.$condition.'</td></tr>';
			echo '</table>';
			echo '<center><table border="0" width="95%"CELLSPACING="1" CELLPADDING="4">';
			echo '<tr><td class=rank1>'.$conteudo.'</td></tr>';
			echo '</table>';
			echo '<br><a href="?page=community.guilds"><img src="'.$back_button.'" border="0"></a>';					
		}
		else
		{
			echo '<form method="post" action="?page=community.guilds&action=create">';
			echo '<br><center><table width="85%" border="0"CELLPADDING="4" cellspacing="1">';
			echo '<tr class="rank2"><td colspan="3"><b>'.$lang['found_guild'].'</td></tr>';		
			echo '<tr class="rank1"><td>'.$lang['guild_name'].'</td><td><input class="login" name="name" type="text" value="" size="30"/></td></tr>';
			echo '<tr class="rank1"><td>'.$lang['guild_leader'].'</td><td><select name="leader">';
			$query = mysql_query("SELECT * FROM `players` WHERE (`account_id` = '$account')");	
			while($fetch = mysql_fetch_object($query))
				echo '<option value="'.$fetch->id.'">'.$fetch->name.'</option>';	
			echo'</select></td></tr>';
			echo '<tr class="rank1"><td>'.$lang['password'].'</td><td><input class="login" name="password" type="password" value=""/></td></tr>';
			echo '</table>';
			echo '<br><input type="image" value="submit" src="images/submit.gif"/> <a href="?page=community.guilds"><img src="images/back.gif" border="0"></a>';					
		}
	}	
}	
else
{			
	$query = mysql_query("SELECT * FROM guilds ORDER by name asc");
	echo '<br><center><table width="99%" cellspacing="1" cellpadding="4">';
	echo '<tr class=rank2><td colspan="3" width=5%>'.$lang['active_guilds_on'].' on Darghos</td></tr>';	
	echo '<tr class=rank1><td width=64><b>'.$lang['logo'].'</td><td width=90% colspan=2><b>'.$lang['description'].'</td></tr>';			
	if(mysql_num_rows($query) != 0)
	{
		
		while($fetch = mysql_fetch_object($query))
		{
			$t++;
			$style = rotateStyle($t);		
			
			if (!file_exists(''.$guildimgdir.''.$fetch->guildname.'.gif')) 
			{
				$img = '<img align="center" border="0" src="'.$guildimgdir.'default_logo.gif" height=64 width=64>';
			}
			else
			{
				$img = '<br><img align="center" border="0" src="'.$guildimgdir.'.gif" height=64 width=64>';
			}

			$comment = strip_tags($fetch->motd, '<b><i><u><br>');
			echo '<tr class="'.$style.'"><td width=10%>'.$img.'</td><td width=80%><b>'.$fetch->name.'</b><br>'.$comment.'</center></td><td width=10%><a href="?page=community.guildDetails&guildid='.$fetch->id.'">&nbsp;'.$lang['view'].'&nbsp;</a></td></tr>';	
		}					
	}
	else 
	{
		echo '<tr class="rank3"><td colspan="3">'.$lang['no_guilds_fond'].' '.$serverName.'</td></tr>';	
	}
	echo '</table>';
	echo '';	

	if(Account::isPremium($account))
	{
		echo '<br><center><table width="95%" BORDER="0" CELLSPACING="1" CELLPADDING="4">';	
		echo '<tr><td><font size="2">'.$lang['no_have_guild'].'<br><a href="?page=community.guilds&action=create"><img src="images/foundGuild.gif" border="0"></a></td></tr>';	
		echo '</table><br>';
	}			
	
	echo '<a href="?page=community.guilds"><img src="images/back.gif" border="0"></a><br><br>';
}
?>