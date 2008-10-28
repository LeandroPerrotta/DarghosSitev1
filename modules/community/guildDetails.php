<?
echo '<tr><td class=newbar><center><b>:: '.$lang['showguild_title'].' ::</td></tr>
<tr><td class=newtext>';

$guild_id = $_SESSION['guild_id'];

if ($_GET['action'] == 'invite')
{			
	if(Guilds::getUserLevel($guild_id,$account) <= 2)
	{		
		if ($_SERVER['REQUEST_METHOD'] == "POST")
		{
			if(filtreString($_POST['name'],1) == 0)		
			{
				$condition = "Invalid syntax!";
				$conteudo = "This guild name contains invalid syntax. Please try again with another guild name.";
			}	
			elseif(Player::isOnline($_POST['name']) == 1)
			{
			$condition = 'Player is loged in!';
			$conteudo = 'The player must be offline to be invited in a guild.';
			$error++;
			}	
			elseif(!Player::exists($_POST['name']))
			{
				$condition = 'Character not found!';
				$conteudo = 'Character does not exist.';		
			}				
			elseif(Guilds::hasInvited($_POST['name']))
			{
				$condition = "Already invited!";
				$conteudo = "This player is invited in another guild.";
			}			
			elseif(Guilds::hasMember($_POST['name']))
			{
				$condition = "Already member!";
				$conteudo = "This player is already member of another guild.";
			}					
			else
			{
				Guilds::invite($_POST['name'], $guild_id);
				$condition = "Character invited!";
				$conteudo = "The player ".$_POST['name']." was invited successfully.";				
			}			

				echo '<br><center><table width="95%"BORDER="0" CELLSPACING="1" CELLPADDING="4">';
				echo '<tr><td class="rank2">'.$condition.'</td></tr>';
				echo '</table>';
				echo '<center><table border="0" width="95%"CELLSPACING="1" CELLPADDING="4">';
				echo '<tr><td class=rank1>'.$conteudo.'</td></tr>';
				echo '</table>';
		}

		echo '<form method="post" action="?page=community.guildDetails&action=invite">';
		echo '<br><center><table width="85%" border="0"CELLPADDING="4" cellspacing="1">';
		echo '<tr class="rank2"><td colspan="3"><b>'.$lang['invite_character'].'</td></tr>';		
		echo '<tr class="rank1"><td>'.$lang['name'].'</td><td><input class="login" name="name" type="text" value="" size="30"/></td></tr>';
		echo '</table>';
		echo '<br><input type="image" value="submit" src="images/submit.gif"/> <a href="?page=community.guildDetails&guildid='.$guild_id.'"><img src="images/back.gif" border="0"></a>';						
	}
}
elseif ($_GET['action'] == 'join')
{	
	if(Guilds::invitedLogedIn($account,$guild_id))
	{
		if ($_SERVER['REQUEST_METHOD'] == "POST")
		{
			if(Guilds::join($_POST['player_id'],$guild_id))
			{
				$condition = "Join completed!";
				$conteudo = "You joined to the guild ".Guilds::getGuildNameById($guild_id)." successfuly!";					
			}
			else
			{
				$condition = "Error!";
				$conteudo = "Ouve um erro com sua participação na guilda, por favor contate a UltraxSoft.";						
			}
			
			echo '<br><center><table width="95%"BORDER="0" CELLSPACING="1" CELLPADDING="4">';
			echo '<tr><td class="rank2">'.$condition.'</td></tr>';
			echo '</table>';
			echo '<center><table border="0" width="95%"CELLSPACING="1" CELLPADDING="4">';
			echo '<tr><td class=rank1>'.$conteudo.'</td></tr>';
			echo '</table>';				
			
			echo '<br><a href="?page=community.guildDetails&guildid='.$guild_id.'"><img src="images/back.gif" border="0"></a>';
		}
		else
		{
			echo '<form method="post" action="?page=community.guildDetails&action=join">';
			echo '<br><center><table width="85%" border="0"CELLPADDING="4" cellspacing="1">';
			echo '<tr class="rank2"><td colspan="3"><b>'.$lang['join_to_guild'].'</td></tr>';		
			echo '<tr class="rank1"><td>'.$lang['name'].'</td><td><select name="player_id">';
			$query = mysql_query("SELECT * FROM `players` WHERE (`account_id` = '$account')");	
			while($fetch = mysql_fetch_object($query))
			{
				$invite_query = mysql_query("SELECT * FROM `guild_invites` WHERE (`player_id` = '".$fetch->id."' and guild_id = '$guild_id')");
				$invite_fetch = mysql_fetch_object($invite_query);
				$playerName = Player::getPlayerNameById($invite_fetch->player_id);	
				if(mysql_num_rows($invite_query) != 0)
					echo '<option value="'.$invite_fetch->player_id.'">'.$playerName.'</option>';					
			}
			echo'</select></td></tr>';
			echo '</table>';
			echo '<br><input type="image" value="submit" src="images/submit.gif"/> <a href="?page=community.guildDetails&guildid='.$guild_id.'"><img src="images/back.gif" border="0"></a>';				
		}
	}
}		
elseif ($_GET['action'] == 'disband')
{	
	if(Guilds::getUserLevel($guild_id,$account) == 1)
	{
		if ($_SERVER['REQUEST_METHOD'] == "POST")
		{
			if(!Account::passCheck($account,md5($_POST['password'])))
			{
				$condition = 'Password error!';
				$conteudo = 'This password is not correct.';
			}				
			elseif(Guilds::disband($guild_id))
			{
				$condition = "Guild Disbanded!";
				$conteudo = "Your Guild was disbanded successfuly!";					
			}
			else
			{
				$condition = "Error!";
				$conteudo = "Ouve um erro com sua participação na guilda, por favor contate a UltraxSoft.";						
			}
			
			echo '<br><center><table width="95%"BORDER="0" CELLSPACING="1" CELLPADDING="4">';
			echo '<tr><td class="rank2">'.$condition.'</td></tr>';
			echo '</table>';
			echo '<center><table border="0" width="95%"CELLSPACING="1" CELLPADDING="4">';
			echo '<tr><td class=rank1>'.$conteudo.'</td></tr>';
			echo '</table>';				
			
			echo '<br><a href="?page=community.guildDetails&guildid='.$guild_id.'"><img src="images/back.gif" border="0"></a>';
		}
		else
		{
			echo '<form method="post" action="?page=community.guildDetails&action=disband">';
			echo '<br><center><table width="85%" border="0"CELLSPACING=1 CELLPADDING=4>';
			echo '<tr class="rank2"><td colspan="3"><b>'.$lang['disband_guild'].'</td></tr>';		
			echo '<tr class="rank1"><td>'.$lang['password'].'</td><td><input name="password" type="password" value="" size=""/></td></tr>';
			echo '</table>';
			echo '<br><input type="image" value="submit" src="images/submit.gif"/> <a href="?page=community.guildDetails&guildid='.$guild_id.'"><img src="images/back.gif" border="0"></a>';				
		}
	}	
}	
elseif ($_GET['action'] == 'editRanks')
{	
	if(Guilds::getUserLevel($guild_id,$account) == 1)
	{			
		if ($_SERVER['REQUEST_METHOD'] == "POST")
		{	
			$ranks_query = mysql_query("SELECT * FROM guild_ranks WHERE (`guild_id` = '".$guild_id."')");
			if($_POST['status'] != 1)	
			{
				if($_POST['number_ranks'] <= mysql_num_rows($ranks_query))
				{
					$condition = "Smaller Number of Ranks!";
					$conteudo = "The number of ranks not be smaller than the number of existing ranks.";					
				}
				elseif($_POST['number_ranks'] < 3 or $_POST['number_ranks'] > 20)
				{
					$condition = "Error";
					$conteudo = "The number of ranks must be between 3 and 20.";	
				}					
				elseif($_POST['number_ranks'] > 2 or $_POST['number_ranks'] < 21)
				{
					$ranks = $_POST['number_ranks'];	
					$condition = "Number of Ranks Changed";
					$conteudo = "The number of ranks has been changed.";	
				}	
			}				
			else
			{
				Guilds::editRank($guild_id,1,$_POST['rankName_1']);
				Guilds::editRank($guild_id,2,$_POST['rankName_2']);				
				Guilds::editRank($guild_id,3,$_POST['rankName_3']);			
				Guilds::editRank($guild_id,4,$_POST['rankName_4']);				
				Guilds::editRank($guild_id,5,$_POST['rankName_5']);		
				Guilds::editRank($guild_id,6,$_POST['rankName_6']);				
				Guilds::editRank($guild_id,7,$_POST['rankName_7']);		
				Guilds::editRank($guild_id,8,$_POST['rankName_8']);				
				Guilds::editRank($guild_id,9,$_POST['rankName_9']);		
				Guilds::editRank($guild_id,10,$_POST['rankName_10']);				
				Guilds::editRank($guild_id,11,$_POST['rankName_11']);		
				Guilds::editRank($guild_id,12,$_POST['rankName_12']);				
				Guilds::editRank($guild_id,13,$_POST['rankName_13']);		
				Guilds::editRank($guild_id,14,$_POST['rankName_14']);				
				Guilds::editRank($guild_id,15,$_POST['rankName_15']);	
				Guilds::editRank($guild_id,16,$_POST['rankName_16']);		
				Guilds::editRank($guild_id,17,$_POST['rankName_17']);				
				Guilds::editRank($guild_id,18,$_POST['rankName_18']);		
				Guilds::editRank($guild_id,19,$_POST['rankName_19']);				
				Guilds::editRank($guild_id,20,$_POST['rankName_20']);		
				$condition = "Name of Ranks Changed";
				$conteudo = "The name of ranks has been changed.";		
			}
			
			echo '<br><center><table width="95%"BORDER="0" CELLSPACING="1" CELLPADDING="4">';
			echo '<tr><td class="rank2">'.$condition.'</td></tr>';
			echo '</table>';
			echo '<center><table border="0" width="95%"CELLSPACING="1" CELLPADDING="4">';
			echo '<tr><td class=rank1>'.$conteudo.'</td></tr>';
			echo '</table>';				
		}		

		$ranks1_query = mysql_query("SELECT * FROM guild_ranks WHERE (`guild_id` = '".$guild_id."')");		
		if ($ranks == "" or $ranks == null)
			$ranks = mysql_num_rows($ranks1_query);
		$rankline = 0;	
			
		echo '<form method="post" action="?page=community.guildDetails&action=editRanks">';	
		echo '<br><center><table width="85%" border="0"cellpadding="4" cellspacing="1">';
		echo '<tr class="rank2"><td colspan="3"><b>'.$lang['edit_guild_ranks'].'</td></tr>';		
		echo '<tr class="rank1"><td width="22%">'.$lang['number_ranks'].':</td><td><input class="login" name="number_ranks" type="text" value="'.$ranks.'" size="2"/> ('.$lang['minimum'].' 3, '.$lang['maximum'].' 20)<input align="right" type="image" value="submit" src="images/submit.gif"/></td></tr>';	
		echo '</form>';	
		echo '<form method="post" action="?page=community.guildDetails&action=editRanks">';	
		echo '<tr class="rank1"><td colspan="2" width="22%">'.$lang['name_ranks'].':</td></tr>';								
		while($rankline < $ranks)
		{
			$rankline++;
			$query = mysql_query("SELECT * FROM guild_ranks WHERE (`guild_id` = '".$guild_id."' and level = '$rankline')");
			$fetch = mysql_fetch_object($query);
			if($rankline <= mysql_num_rows($ranks1_query))
				$value = $fetch->name;
			else	
				$value = "(member)";
				
			echo '<input type="hidden" name="status" value="1">';	
				
			if($rankline == $ranks)
				$submit = '<input align="right" type="image" value="submit" src="images/submit.gif"/>';					
			echo '<tr class="rank1"><td></td><td>'.$rankline.'. <input name="rankName_'.$rankline.'" type="text" value="'.$value.'" size=""/>'.$submit.'</td></tr>';					

		}
		echo '</table>';		
		echo '</form>';	
		echo '<a href="?page=community.guildDetails&guildid='.$guild_id.'"><img src="images/back.gif" border="0"></a>';
					
	}	
}	
elseif ($_GET['action'] == 'editMembers')
{
	if(Guilds::getUserLevel($guild_id,$account) <= 2)
	{
		if ($_SERVER['REQUEST_METHOD'] == "POST")
		{	
			if($_POST['action'] == "setrank")
			{
				if(Guilds::getUserLevel($guild_id,$account) >= Guilds::getMemberLevel($guild_id,$_POST['member_id']))
				{
					$condition = "Error";
					$conteudo = "You may only promote or degrade members with a lower rank than yours.";					
				}
				elseif(Guilds::getUserLevel($guild_id,$account) != 1 and $_POST['rank_id'] == 2)
				{
					$condition = "Error";
					$conteudo = "Only leaders can promote to this rank.";					
				}	
				elseif(Guilds::getUserLevel($guild_id,Player::getPlayerAccount($_POST['member_id'])) <= 2 and Guilds::getRankLevel($_POST['rank_id']) == 2)
				{
					$condition = "Error";
					$conteudo = "The account of this member already is leader or vice-leader in another character.";					
				}						
				elseif(Account::getPremDays(Player::getPlayerAccount($_POST['member_id'])) == 0 and Guilds::getRankLevel($_POST['rank_id']) == 2)
				{
					$condition = "Error";
					$conteudo = "You may only promote members with premium account to vice-leader.";					
				}					
				else
				{
					Guilds::setMemberRank($_POST['member_id'],$_POST['rank_id']);
					$condition = "Member Rank Changed";
					$conteudo = "The rank of the member has been changed successfully.";						
				}
			}
			elseif($_POST['action'] == "settitle")
			{
				if(Guilds::getUserLevel($guild_id,$account) >= Guilds::getMemberLevel($guild_id,$_POST['member_id']) and Player::getPlayerAccount($_POST['member_id']) != $account)
				{
					$condition = "Error";
					$conteudo = "You may only set title of members with a lower rank than yours.";	
				}						
				else
				{
					Guilds::setMemberTitle($_POST['member_id'],$_POST['newtitle']);
					$condition = "Member Title Changed";
					$conteudo = "The title of the member has been changed successfully.";						
				}
			}		
			elseif($_POST['action'] == "exclude")
			{
				if(Guilds::getUserLevel($guild_id,$account) >= Guilds::getMemberLevel($guild_id,$_POST['member_id']))
				{
					$condition = "Error";
					$conteudo = "You may only exclude members with a lower rank than yours.";	
				}					
				else
				{
					Guilds::excludeMember($_POST['member_id']);
					$condition = "Member Excluded";
					$conteudo = "The member has been excluded successfully.";						
				}					
			}					
			echo '<br><center><table width="95%"BORDER="0" CELLSPACING="1" CELLPADDING="4">';
			echo '<tr><td class="rank2">'.$condition.'</td></tr>';
			echo '</table>';
			echo '<center><table border="0" width="95%"CELLSPACING="1" CELLPADDING="4">';
			echo '<tr><td class=rank1>'.$conteudo.'</td></tr>';
			echo '</table>';					
		}	
		
		echo '<form method="post" action="?page=community.guildDetails&action=editMembers">';	
		echo '<br><center><table width="85%" border="0"cellpadding="4" cellspacing="1">';
		echo '<tr class="rank2"><td colspan="3"><b>'.$lang['edit_member'].'</td></tr>';		
		echo '<tr class="rank1"><td width="15%">'.$lang['name'].': <td><select name="member_id">';
		$rank_query = mysql_query("SELECT * FROM guild_ranks WHERE (`guild_id` = '".$guild_id."') ORDER by level asc");
		while($rank_fetch = mysql_fetch_object($rank_query))
		{
			$player_query = mysql_query("SELECT * FROM players WHERE (`rank_id` = '".$rank_fetch->id."')");
			while($player_fetch = mysql_fetch_object($player_query))
			{
				$rankName_query = mysql_query("SELECT * FROM guild_ranks WHERE (`id` = '".$player_fetch->rank_id."')");	
				$rankName_fetch = mysql_fetch_object($rankName_query);
				echo '<option value="'.$player_fetch->id.'">'.$player_fetch->name.' ('.$rankName_fetch->name.')</option>';				
			}
		}			
		echo '</select></td></tr>';
		echo '<tr class="rank1"><td colspan="2">'.$lang['action'].':</td></td>';
		echo '<tr class="rank1"><td colspan="2"><INPUT TYPE=radio NAME="action" VALUE="setrank"> '.$lang['set_rank_to'].' <select name="rank_id">';
		$rankline = 0;
		$rank_query1 = mysql_query("SELECT * FROM guild_ranks WHERE (`guild_id` = '".$guild_id."' and level != '1') ORDER by level asc");
		while($rank_fetch1 = mysql_fetch_object($rank_query1))
		{
			$rankline++;
			if(mysql_num_rows($rank_query1) == $rankline)
			echo '<option value="'.$rank_fetch1->id.'" SELECTED>'.$rank_fetch1->level.': '.$rank_fetch1->name.'</option>';	
			else
			echo '<option value="'.$rank_fetch1->id.'">'.$rank_fetch1->level.': '.$rank_fetch1->name.'</option>';	
		}	
		echo '</select></td></tr>';	
		echo '<tr class="rank1"><td colspan="2"><INPUT TYPE=radio NAME="action" VALUE="settitle"> '.$lang['set_title_to'].' <INPUT NAME="newtitle" SIZE=30 MAXLENGTH=75></td></tr>';
		echo '<tr class="rank1"><td colspan="2"><INPUT TYPE=radio NAME="action" VALUE="exclude"> '.$lang['exclude_from_guild'].'</td></tr>';
		echo '</table>';				
		echo '<br><input type="image" value="submit" src="images/submit.gif"/> <a href="?page=community.guildDetails&guildid='.$guild_id.'"><img src="images/back.gif" border="0"></a>';
		echo '</form>';	
	}	
}
elseif ($_GET['action'] == 'leave')
{
	if(Guilds::getUserLevel($guild_id,$account) < 21)
	{
		if ($_SERVER['REQUEST_METHOD'] == "POST")
		{
			if(Guilds::getMemberLevel($guild_id,$_POST['player_id']) == 1)
			{
				$condition = "Error";
				$conteudo = "You may not leave of this Guild!";					
			}				
			elseif(Guilds::excludeMember($_POST['player_id']))
			{
				$condition = "Leave completed!";
				$conteudo = "You leave of the guild ".Guilds::getGuildNameById($guild_id)." successfuly!";					
			}	
			else
			{
				$condition = "Error!";
				$conteudo = "Ouve um erro com sua participação na guilda, por favor contate a UltraxSoft.";						
			}
			
			echo '<br><center><table width="95%"BORDER="0" CELLSPACING="1" CELLPADDING="4">';
			echo '<tr><td class="rank2">'.$condition.'</td></tr>';
			echo '</table>';
			echo '<center><table border="0" width="95%"CELLSPACING="1" CELLPADDING="4">';
			echo '<tr><td class=rank1>'.$conteudo.'</td></tr>';
			echo '</table>';				
			
			echo '<br><a href="?page=community.guildDetails&guildid='.$guild_id.'"><img src="images/back.gif" border="0"></a>';
		}
		else
		{
			echo '<form method="post" action="?page=community.guildDetails&action=leave">';
			echo '<br><center><table width="85%" border="0"CELLPADDING="4" cellspacing="1">';
			echo '<tr class="rank2"><td colspan="3"><b>'.$lang['leave_from_guild'].'</td></tr>';		
			echo '<tr class="rank1"><td>'.$lang['name'].'</td><td><select name="player_id">';
			$query = mysql_query("SELECT * FROM `players` WHERE (`account_id` = '$account')");	
			while($fetch = mysql_fetch_object($query))
			{
				$invite_query = mysql_query("SELECT * FROM `guild_ranks` WHERE (`id` = '".$fetch->rank_id."' and guild_id = '$guild_id')");
				$invite_fetch = mysql_fetch_object($invite_query);
				$playerName = $fetch->name;	
				if(mysql_num_rows($invite_query) != 0)
					echo '<option value="'.$fetch->id.'">'.$playerName.'</option>';					
			}
			echo'</select></td></tr>';
			echo '</table>';
			echo '<br><input type="image" value="submit" src="images/submit.gif"/> <a href="?page=community.guildDetails&guildid='.$guild_id.'"><img src="images/back.gif" border="0"></a>';				
		}
	}		
}
elseif ($_GET['action'] == 'editDescription')
{
	if(Guilds::getUserLevel($guild_id,$account) == 1)
	{
		if ($_SERVER['REQUEST_METHOD'] == "POST")
		{
			$desc = filtreString(nl2br($_POST['description']),0);
			if(strlen($_POST['description']) > 500)
			{
				$condition = "Error";
				$conteudo = "Your Guild description can not contain more of 500 characters";					
			}
			elseif(Guilds::editDescription($guild_id,$desc))
			{
				$condition = "Guild Description Changed";
				$conteudo = "Your Guild description was changed successfully!";						
			}
			else
			{
				$condition = "Error!";
				$conteudo = "Ouve um erro com sua participação na guilda, por favor contate a UltraxSoft.";						
			}
			
			echo '<br><center><table width="95%"BORDER="0" CELLSPACING="1" CELLPADDING="4">';
			echo '<tr><td class="rank2">'.$condition.'</td></tr>';
			echo '</table>';
			echo '<center><table border="0" width="95%"CELLSPACING="1" CELLPADDING="4">';
			echo '<tr><td class=rank1>'.$conteudo.'</td></tr>';
			echo '</table>';				
			
			echo '<br><a href="?page=community.guildDetails&guildid='.$guild_id.'"><img src="images/back.gif" border="0"></a>';
		}
		else
		{		
			echo '<form method="post" action="?page=community.guildDetails&action=editDescription">';
			echo '<br><center><table width="95%"BORDER="0" CELLSPACING="1" CELLPADDING="4">';	
			echo '<tr><td colspan=3 class="rank2">'.$lang['edit_guild_description'].'</td></tr>';
			
			echo '<tr><td class=rank1 width="25%">'.$lang['description'].':</td><td class=rank1><TEXTAREA NAME="description" ROWS=10 COLS=50 WRAP="virtual">';

			$guild_query = mysql_query("SELECT * FROM `guilds` WHERE (`id` = '$guild_id')") or die(mysql_error());
			$guild_fetch = mysql_fetch_object($guild_query);
			if($guild_fetch->motd != null and $guild_fetch->motd != "")
			echo ''.$guild_fetch->motd.'';

			echo '</textarea></td></tr>';
			echo '</table>';
			
			echo '<br><input type="image" value="submit" src="images/submit.gif"/> <a href="?page=community.guildDetails&guildid='.$guild_id.'"><img src="images/back.gif" border="0"></a>';


			echo '</form>';			
		}	
	}
}	
else
{		
	$guild_id = $_GET['guildid'];		
	if ($guild_id != "" or $guild_id != null)
	{			
		$_SESSION['guild_id'] = $guild_id;

		
		if(Guilds::getUserLevel($guild_id,$account) <= 2)
		{
			if(Guilds::getUserLevel($guild_id,$account) == 1)
			{
				$editRanks = '<a href="?page=community.guildDetails&action=editRanks"><img align="left" src="images/editRanks.gif" border="0"></a>';
				$disband = '<a href="?page=community.guildDetails&action=disband"><img align="right" src="images/disband.gif" border="0"></a>';
				$editDisc = '<a href="?page=community.guildDetails&action=editDescription"><img align="left" src="images/editDescription.gif" border="0"></a>';
			}
			$editMembers = '<a href="?page=community.guildDetails&action=editMembers"><img align="left" src="images/editMember.gif" border="0"></a>';
			$invite = '<a href="?page=community.guildDetails&action=invite"><img align="left" src="images/invite.gif" border="0"></a>';
		}
		if(Guilds::invitedLogedIn($account,$guild_id))
			$join = '<a href="?page=community.guildDetails&action=join"><img align="right" src="images/join.gif" border="0"></a>';
		if(Guilds::getUserLevel($guild_id,$account) <= 20)
			$leave = '<a href="?page=community.guildDetails&action=leave"><img align="right" src="images/leave.gif" border="0"></a>';
		
		
		$slct_guild = mysql_query("SELECT * FROM guilds WHERE (`id` = '".$guild_id."')");
		while($slct_fetch_guild = mysql_fetch_array($slct_guild))
		{
			$name = $slct_fetch_guild['name'];
			$story = strip_tags($slct_fetch_guild['motd']);
			$creationdata = $slct_fetch_guild['creationdata'];
		}
		
		if (!file_exists("".$guildimgdir."/".$name.".gif")) 
		{
			$img = "<img src='".$guildimgdir."/default_logo.gif' height=64 width=64>";
		}
		else
		{
			$img = "<br><img src='".$guildimgdir."/".$name.".gif' height=64 width=64>";
		}
		
		echo '<center><table border="0" width="95%" cellspacing="0">';
		echo '<tr><td WIDTH=64 ><font size=2><center>'.$img.'</td><td ALIGN=center width=90%><H1>'.$name.'</td><td WIDTH=64><font size=2><center>'.$img.'</td></tr>';
		echo '</table>';

		$creation = date('d/m/Y',$creationdata);
		
		echo '<br><center><table width="95%" BORDER="0" CELLSPACING="1" CELLPADDING="4">';	
		echo '<tr><td><font size="2">'.$story.'</td></tr>';	
		echo '</table>';	

		$formedTime = $creationdata + 60 * 60 * 24 * 3;

		echo '<table width="95%" bordercolor="black" cellspacing="0">';
		if(time() > $formedTime and Guilds::totalVices($guild_id) > 3)
			echo '<br><font size=2>'.$lang['currently_active'].'.';
		else
		{
			echo '<br>'.$lang['course_of_formation'].'.';	
			echo '<br><b>'.$lang['disbanded_on'].' '.date('d/m/Y',$formedTime).' '.$lang['if_no_four_vices'].'.</b>';			
		}	
		echo '<br><br><font size=2>'.$lang['founded_in'].' <b>'.$creation.'.</b>';
		echo '</table>';
		
		echo '<table border="0" width="95%" CELLSPACING="1" CELLPADDING="4">';
		echo '<tr><td>'.$editDisc.''.$disband.'</td></tr>';
		echo '</table>';			

		//MEMBERS
		echo '<br><center><table width="95%" CELLSPACING="1" CELLPADDING="4">';
		echo '<tr><td colspan="3" class=rank2>'.$lang['guild_members'].'</td></tr>';
		echo '<tr class=rank1><td width=35%><b>'.$lang['guild_rank'].'</td><td width=55%><b>'.$lang['name_and_title'].'</td><td width=10%><b>'.$lang['level'].'</td></tr>';
		
		$slct_rank = mysql_query("SELECT * FROM guild_ranks WHERE (`guild_id` = '".$guild_id."') ORDER by level asc");
		while($slct_rank_sql = mysql_fetch_array($slct_rank))
		{
			$slct_member = mysql_query("SELECT * FROM players WHERE (`rank_id` = '".$slct_rank_sql['id']."')");
			while($slct_fetch_member = mysql_fetch_array($slct_member))
			{
				$rankname = mysql_query("SELECT name FROM guild_ranks WHERE (`id` = '".$slct_fetch_member['rank_id']."')");	
				$rankname_sql = mysql_fetch_array($rankname);
				echo '<tr>';				
				echo '<td class=rank3><font size=2>'.$rankname_sql['name'].'';
				echo '<td class=rank3><font size=2><a href="?page=character.details&char='.$slct_fetch_member['name'].'">'.$slct_fetch_member['name'].'</a></font></b> ';
				if($slct_fetch_member['guildnick'] != null)
				echo '('.$slct_fetch_member['guildnick'].')';
				echo '</td><td class=rank3><font size=2>'.$slct_fetch_member['level'].'';
				echo '</td></tr>';
				$qtdmember = 1 + $qtdmember++;
			}
		}
		echo '</table>';
		
		echo '<center><table width="95%" BORDER="0" CELLSPACING="1" CELLPADDING="4">';	
		echo '<tr><td>'.$editRanks.' '.$editMembers.'</td></tr>';	
		echo '</table>';
		
		//INVITEDS
		echo '<table width="95%" bordercolor="black" cellspacing="0">';
		echo '<br><font size=2>'.$lang['number_of_members'].': <b>'.$qtdmember.'</b><center>';	
		echo '</table>';	

		echo '<br><center><table width="95%" CELLSPACING="1" CELLPADDING="4">';
		echo '<tr><td colspan="2" class=rank2>'.$lang['invited_characters'].'</td></tr>';
		echo '<tr class=rank1><td width=75%><b>'.$lang['name'].'</td><td></td></tr>';
		$slct_inviteds = mysql_query("SELECT * FROM guild_invites WHERE (`guild_id` = '".$guild_id."')");
		if(mysql_num_rows($slct_inviteds) != 0)
		{

			
			while($slct_fetch_inviteds = mysql_fetch_array($slct_inviteds))
			{	
				$invited_name = mysql_query("SELECT * FROM players WHERE (`id` = '".$slct_fetch_inviteds['player_id']."')");
				$invited_name_fetch = mysql_fetch_object($invited_name);
				echo '<tr class="rank3"><td colspan="2"><a href="?page=character.details&char='.$invited_name_fetch->name.'">'.$invited_name_fetch->name.'</a></td></tr>';
			}			
		}
		else
			echo '<tr><td colspan="2" class=rank3>'.$lang['no_invited_characters_found'].'.</td></tr>';
		echo '</table>';
		echo '<center><table width="95%" BORDER="0" CELLSPACING="1" CELLPADDING="4">';	
		echo '<tr><td>'.$invite.''.$join.''.$leave.'</td></tr>';	
		echo '</table>';			
		echo '<br>';
		if (!Account::isLogged($account,$password))
			echo '<a href="?page=account.login"><img src="images/login.gif" border="0"></a>';
		echo '<a href="?page=community.guilds&action=list"><img src="images/back.gif" border="0"></a><br><br>';	
	}	
}
?>