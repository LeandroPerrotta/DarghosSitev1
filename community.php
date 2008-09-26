<?
session_start();
include "top.php";

$account = $_SESSION['account'];
$password = $_SESSION['password'];

if($_GET['subtopic'] == 'highscores'){
echo '<tr><td class=newbar><center><b>:: '.$lang['highscores_title'].' ::</td></tr>
<tr><td class=newtext>';

$serverId = 1;

?>
<br>
<center>
<p>
<?
$cfg['rank'] = 100;

if(!isset($_POST['value']))
{
	if(!isset($_SESSION['value']))
		$_POST['value'] = "Level";
	else
		$_POST['value'] = $_SESSION['value'];
}	
	
$_SESSION['value'] = $_POST['value'];
$skill = $_SESSION['value'];

if(!isset($_GET['pg'])) 
{
	$pg = 1;
} 
else 
{
	$pg = $_GET['pg'];
}

if($pg > 5)
{
	$inicio = 5;
}
else
{
	$inicio = $pg - 1;
}

$ini = $inicio * $cfg['rank'];
$prox = $cfg['rank'] * $pg + 1;
$prox_ = $cfg['rank'] * $pg + $cfg['rank'];

if($pg == 2)
{
	$ante = "1-".$cfg['rank'];
}
elseif($pg > 2)
{
	$aa = $pg - 1;
	$b = $pg - 2;
	$a = $cfg['rank'] * $b;
	$ante = $a+'1'."-".$cfg['rank']*$aa;
}
if($pg == 1 or $pg == "")
{
	$asd = " ";
}
else
{
	$asd = " | ";
}

echo '<form action="community.php?subtopic=highscores" method="post">
<table width="40%" border="0" cellspacing="1" CELLPADDING="4">
<tr class="rank2"><td>Choose a Skill</td></tr>
<tr class="rank1"><td><select name="value">
<option value="Level">Level</option>
<option value="ExpRook">Level on Rookguard</option>
<option value="Magic">Magic Level</option>
<option value="Fist">First Fighting</option>
<option value="Club">Club Fighting</option>
<option value="Sword">Sword Fighting</option>
<option value="Axe">Axe Fighting</option>
<option value="Distance">Distance Fighting</option>
<option value="Shield">Shield</option>
<option value="Fish">Fishing</option></select><input type="image" value="Entrar" src="images/submit.gif"/>
</td></tr>
</table></form>

<center><font size="4" color="#4F2700"><b>'.$skill.' Top 500</b></font></center><br>


<table width="100%" border="0" cellspacing="1" CELLPADDING="4">
<tr>
<td width="87%" valign="top"><table width="100%" border="0" cellpadding="4" cellspacing="1">
<tr class="rank2">
<td width="10%"><font size=2>'.$lang['rank_number'].'</td>
<td width="40%"><font size=2>'.$lang['name'].'</td>
<td width="20%"><font size=2>'.$lang['level'].'</td>';

				if($skill == "Level" or $skill == "ExpRook")
				{
					echo '<td width="30%"><font size=2>'.$lang['points'].'</td>';
 				}
 				
 	 echo '</tr>';
 
 switch($skill)
{
	case "Fist":
		$id = 0;
		break;
	case "Club":
		$id = 1;
		break;
	case "Sword":
		$id = 2;
		break;
	case "Axe":
		$id = 3;
		break;
	case "Distance":
		$id = 4;
		break;
	case "Shield":
		$id = 5;
		break;
	case "Fish":
		$id = 6;
		break;
 }

if($skill == "Level") 
{
	$total = mysql_query("SELECT * FROM players WHERE server = '$serverId' ORDER BY level");
	$tr = mysql_num_rows($total);
	$tp = $tr / $cfg['rank'];
	$tp = ceil($tp);
	$ant = $pg-1;
	$pro = $pg+1;
	$verifica = mysql_query("SELECT account_id, vocation, name,group_id,level,experience FROM players WHERE group_id < '3' and server = '$serverId' ORDER BY experience DESC LIMIT ".$ini.",".$cfg['rank']."");
	if($pg == 1 or $pg == 0)
	{
		$i = 1;
	}
	elseif($pg > 1)
	{
		$i = $ini+1;
	}
	
	while($dados = mysql_fetch_array($verifica)) 
	{
		if(Account::getType($dados['account_id']) < 3)
		{	
			$t++;
			$style = rotateStyle($t);	
			
			echo ' <tr>
				 <td class="'.$style.'">'.$i.'</center></td>
				 <td class="'.$style.'"><a href="community.php?subtopic=details&char='.urlencode($dados['name']).'">'.$dados['name'].'</a><br>'.Tolls::getVocation($dados['vocation']).'</td>
				 <td class="'.$style.'">'.$dados['level'].'</center></td>
				 <td class="'.$style.'">'.$dados['experience'].'</center></td>
				</tr>';
			$i++;
		}	
	}
	
	if($tr > $cfg['rank'])
	{
		echo '<tr class="rank2">
<td colspan=4><div align="right">';
		if($pg > 1)
		{
			$anterior = '<a href="?subtopic=highscores&server='.$servername.'&pg='.$ant.'"><font color=white size=2><b>Rank '.$ante.'</a>';
		}
		if($pg != 5)
		{
			if($pg < $tp)
			{
				$proxima = '<a href="?subtopic=highscores&server='.$servername.'&pg='.$pro.'"><font color=white size=2><b>Rank '.$prox.'-'.$prox_.'</a>';
				$tt = true;
			}
		}
		
		echo $anterior;
		if($tt == true) echo $asd;
		echo $proxima;
		echo '</div></td><tr>';
	}
}
elseif($skill == "ExpRook") 
{
$total = mysql_query("SELECT * FROM players WHERE server = '$serverId' and vocation = '0' ORDER BY level");
$tr = mysql_num_rows($total);
$tp = $tr / $cfg['rank'];
$tp = ceil($tp);
$ant = $pg-1;
$pro = $pg+1;
$verifica = mysql_query("SELECT account_id, name,group_id,level,experience FROM players WHERE server = '$serverId' and group_id < '3' and vocation = '0' ORDER BY experience DESC LIMIT ".$ini.",".$cfg['rank']."");
if($pg == 1 or $pg == 0){
 $i = 1;
}elseif($pg > 1){
 $i = $ini+1;
}

while($dados = mysql_fetch_array($verifica)) 
{
	if(Account::getType($dados['account_id']) < 3)
	{	
		$t++;
		$style = rotateStyle($t);	
		
 echo ' <tr>
 <td class="'.$style.'">'.$i.'</center></td>
 <td class="'.$style.'"><a href="community.php?subtopic=details&char='.urlencode($dados['name']).'">'.$dados['name'].'</a><br>'.Tolls::getVocation($dados['vocation']).'</td>
 <td class="'.$style.'">'.$dados['level'].'</center></td>
		 <td class="'.$style.'">'.$dados['experience'].'</center></td>
</tr>';
$i++;
}
}
if($tr > $cfg['rank']){
 echo '<tr class="rank2">
<td colspan=4><div align="right">';
 if($pg > 1){
$anterior = '<a href="?subtopic=highscores&server='.$servername.'&pg='.$ant.'"><font color=white size=2><b>Rank '.$ante.'</a>';
 }
 if($pg != 5){
if($pg < $tp){
 $proxima = '<a href="?subtopic=highscores&server='.$servername.'&&pg='.$pro.'"><font color=white size=2><b>Rank '.$prox.'-'.$prox_.'</a>';
 $tt = true;
}
 }
 echo $anterior;
 if($tt == true) echo $asd;
 echo $proxima;
 echo '</div></td><tr>';
}
}
 elseif($skill == "Magic") {
$total = mysql_query("SELECT * FROM players WHERE server = '$serverId' ORDER BY maglevel");
$tr = mysql_num_rows($total);
$tp = $tr / $cfg['rank'];
$tp = ceil($tp);
$ant = $pg-1;
$pro = $pg+1;
$verifica = mysql_query("SELECT account_id, vocation, name,group_id,maglevel FROM players WHERE server = '$serverId' and group_id < '3' ORDER BY maglevel DESC LIMIT ".$ini.",".$cfg['rank']."");
if($pg == 1 or $pg == 0){
 $i = 1;
}elseif($pg > 1){
 $i = $ini+1;
}

while($dados = mysql_fetch_array($verifica)) 
{
	if(Account::getType($dados['account_id']) < 3)
	{	
	$t++;
	$style = rotateStyle($t);	
echo ' <tr>
 <td class="'.$style.'">'.$i.'</center></td>
 <td class="'.$style.'"><a href="community.php?subtopic=details&char='.urlencode($dados['name']).'">'.$dados['name'].'</a><br>'.Tolls::getVocation($dados['vocation']).'</td>
 <td class="'.$style.'">'.$dados['maglevel'].'</center></td>
</tr>';
$i++;
}
}
if($tr > $cfg['']){
 echo '<tr class="rank2">
<td colspan=3><div align="right">';
 if($pg > 1){
$anterior = '<a href="?subtopic=highscores&server='.$servername.'&pg='.$ant.'"><font color=white size=2><b>Rank '.$ante.'</a>';
 }
 if($pg != 5){
if($pg < $tp){
 $proxima = '<a href="?subtopic=highscores&server='.$servername.'&pg='.$pro.'"><font color=white size=2><b>Rank '.$prox.'-'.$prox_.'</a>';
 $tt = true;
}
 }
 echo $anterior;
 if($tt == true) echo $asd;
 echo $proxima;
 echo '</div></td><tr>';
} 
 }
 else {
$total = mysql_query("SELECT name,group_id,value FROM players, player_skills WHERE server = '$serverId' and players.id = player_skills.player_id AND player_skills.skillid = ".$id." ORDER BY value DESC");
$tr = mysql_num_rows($total);
$tp = $tr / $cfg['rank'];
$tp = ceil($tp);
$ant = $pg-1;
$pro = $pg+1;
$verifica = mysql_query("SELECT account_id, vocation, name,group_id,value FROM players, player_skills WHERE server = '$serverId' and group_id < '3' AND players.id = player_skills.player_id AND player_skills.skillid = ".$id." ORDER BY value DESC LIMIT ".$ini.",".$cfg['rank']."");
if($pg == 1 or $pg == 0){
 $i = 1;
}elseif($pg > 1){
 $i = $ini+1;
}

while($dados = mysql_fetch_array($verifica)) 
	{
	if(Account::getType($dados['account_id']) < 3)
	{		
		$t++;
		$style = rotateStyle($t);	
echo ' <tr>
 <td class='.$style.'>'.$i.'</center></td>
 <td class='.$style.'><a href="community.php?subtopic=details&char='.urlencode($dados['name']).'">'.$dados['name'].'</a><br>'.Tolls::getVocation($dados['vocation']).'</td>
 <td class='.$style.'>'.$dados['value'].'</center></td>
</tr>';
$i++;
}
}
if($tr > $cfg['rank']){
 echo '<tr class="rank2">
<td colspan=3><div align="right">';
 if($pg > 1){
$anterior = '<a href="?subtopic=highscores&server='.$servername.'&pg='.$ant.'"><font color=white size=2><b>Ranks '.$ante.'</a>';
 }
 if($pg != 5){
if($pg < $tp){
 $proxima = '<a href="?subtopic=highscores&server='.$servername.'&pg='.$pro.'"><font color=white size=2><b>Ranks '.$prox.'-'.$prox_.'</a>';
 $tt = true;
}
 }
 echo $anterior;
 if($tt == true) echo $asd;
 echo $proxima;
 echo '</div></td><tr>';
} 
 } 

echo'</table></td>
</td>
</tr>
</table>
<br>';
}

## GUILD SYSTEM ##
elseif($_GET['subtopic'] == 'guilds')
{
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
				echo '<br><a href="community.php?subtopic=guilds"><img src="'.$back_button.'" border="0"></a>';					
			}
			else
			{
				echo '<form method="post" action="community.php?subtopic=guilds&action=create">';
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
				echo '<br><input type="image" value="submit" src="images/submit.gif"/> <a href="community.php?subtopic=guilds"><img src="images/back.gif" border="0"></a>';					
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
				echo '<tr class="'.$style.'"><td width=10%>'.$img.'</td><td width=80%><b>'.$fetch->name.'</b><br>'.$comment.'</center></td><td width=10%><a href="community.php?subtopic=showguild&guildid='.$fetch->id.'">&nbsp;'.$lang['view'].'&nbsp;</a></td></tr>';	
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
			echo '<tr><td><font size="2">'.$lang['no_have_guild'].'<br><a href="community.php?subtopic=guilds&action=create"><img src="images/foundGuild.gif" border="0"></a></td></tr>';	
			echo '</table><br>';
		}			
		
		echo '<a href="community.php?subtopic=guilds"><img src="images/back.gif" border="0"></a><br><br>';
	}
}

elseif($_GET['subtopic'] == 'showguild')
{
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

			echo '<form method="post" action="community.php?subtopic=showguild&action=invite">';
			echo '<br><center><table width="85%" border="0"CELLPADDING="4" cellspacing="1">';
			echo '<tr class="rank2"><td colspan="3"><b>'.$lang['invite_character'].'</td></tr>';		
			echo '<tr class="rank1"><td>'.$lang['name'].'</td><td><input class="login" name="name" type="text" value="" size="30"/></td></tr>';
			echo '</table>';
			echo '<br><input type="image" value="submit" src="images/submit.gif"/> <a href="community.php?subtopic=showguild&guildid='.$guild_id.'"><img src="images/back.gif" border="0"></a>';						
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
				
				echo '<br><a href="community.php?subtopic=showguild&guildid='.$guild_id.'"><img src="images/back.gif" border="0"></a>';
			}
			else
			{
				echo '<form method="post" action="community.php?subtopic=showguild&action=join">';
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
				echo '<br><input type="image" value="submit" src="images/submit.gif"/> <a href="community.php?subtopic=showguild&guildid='.$guild_id.'"><img src="images/back.gif" border="0"></a>';				
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
				
				echo '<br><a href="community.php?subtopic=showguild&guildid='.$guild_id.'"><img src="images/back.gif" border="0"></a>';
			}
			else
			{
				echo '<form method="post" action="community.php?subtopic=showguild&action=disband">';
				echo '<br><center><table width="85%" border="0"CELLSPACING=1 CELLPADDING=4>';
				echo '<tr class="rank2"><td colspan="3"><b>'.$lang['disband_guild'].'</td></tr>';		
				echo '<tr class="rank1"><td>'.$lang['password'].'</td><td><input name="password" type="password" value="" size=""/></td></tr>';
				echo '</table>';
				echo '<br><input type="image" value="submit" src="images/submit.gif"/> <a href="community.php?subtopic=showguild&guildid='.$guild_id.'"><img src="images/back.gif" border="0"></a>';				
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
				
			echo '<form method="post" action="community.php?subtopic=showguild&action=editRanks">';	
			echo '<br><center><table width="85%" border="0"cellpadding="4" cellspacing="1">';
			echo '<tr class="rank2"><td colspan="3"><b>'.$lang['edit_guild_ranks'].'</td></tr>';		
			echo '<tr class="rank1"><td width="22%">'.$lang['number_ranks'].':</td><td><input class="login" name="number_ranks" type="text" value="'.$ranks.'" size="2"/> ('.$lang['minimum'].' 3, '.$lang['maximum'].' 20)<input align="right" type="image" value="submit" src="images/submit.gif"/></td></tr>';	
			echo '</form>';	
			echo '<form method="post" action="community.php?subtopic=showguild&action=editRanks">';	
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
			echo '<a href="community.php?subtopic=showguild&guildid='.$guild_id.'"><img src="images/back.gif" border="0"></a>';
						
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
			
			echo '<form method="post" action="community.php?subtopic=showguild&action=editMembers">';	
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
			echo '<br><input type="image" value="submit" src="images/submit.gif"/> <a href="community.php?subtopic=showguild&guildid='.$guild_id.'"><img src="images/back.gif" border="0"></a>';
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
				
				echo '<br><a href="community.php?subtopic=showguild&guildid='.$guild_id.'"><img src="images/back.gif" border="0"></a>';
			}
			else
			{
				echo '<form method="post" action="community.php?subtopic=showguild&action=leave">';
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
				echo '<br><input type="image" value="submit" src="images/submit.gif"/> <a href="community.php?subtopic=showguild&guildid='.$guild_id.'"><img src="images/back.gif" border="0"></a>';				
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
				
				echo '<br><a href="community.php?subtopic=showguild&guildid='.$guild_id.'"><img src="images/back.gif" border="0"></a>';
			}
			else
			{		
				echo '<form method="post" action="community.php?subtopic=showguild&action=editDescription">';
				echo '<br><center><table width="95%"BORDER="0" CELLSPACING="1" CELLPADDING="4">';	
				echo '<tr><td colspan=3 class="rank2">'.$lang['edit_guild_description'].'</td></tr>';
				
				echo '<tr><td class=rank1 width="25%">'.$lang['description'].':</td><td class=rank1><TEXTAREA NAME="description" ROWS=10 COLS=50 WRAP="virtual">';

				$guild_query = mysql_query("SELECT * FROM `guilds` WHERE (`id` = '$guild_id')") or die(mysql_error());
				$guild_fetch = mysql_fetch_object($guild_query);
				if($guild_fetch->motd != null and $guild_fetch->motd != "")
				echo ''.$guild_fetch->motd.'';

				echo '</textarea></td></tr>';
				echo '</table>';
				
				echo '<br><input type="image" value="submit" src="images/submit.gif"/> <a href="community.php?subtopic=showguild&guildid='.$guild_id.'"><img src="images/back.gif" border="0"></a>';


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
					$editRanks = '<a href="community.php?subtopic=showguild&action=editRanks"><img align="left" src="images/editRanks.gif" border="0"></a>';
					$disband = '<a href="community.php?subtopic=showguild&action=disband"><img align="right" src="images/disband.gif" border="0"></a>';
					$editDisc = '<a href="community.php?subtopic=showguild&action=editDescription"><img align="left" src="images/editDescription.gif" border="0"></a>';
				}
				$editMembers = '<a href="community.php?subtopic=showguild&action=editMembers"><img align="left" src="images/editMember.gif" border="0"></a>';
				$invite = '<a href="community.php?subtopic=showguild&action=invite"><img align="left" src="images/invite.gif" border="0"></a>';
			}
			if(Guilds::invitedLogedIn($account,$guild_id))
				$join = '<a href="community.php?subtopic=showguild&action=join"><img align="right" src="images/join.gif" border="0"></a>';
			if(Guilds::getUserLevel($guild_id,$account) <= 20)
				$leave = '<a href="community.php?subtopic=showguild&action=leave"><img align="right" src="images/leave.gif" border="0"></a>';
			
			
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
					echo '<td class=rank3><font size=2><a href="community.php?subtopic=details&char='.$slct_fetch_member['name'].'">'.$slct_fetch_member['name'].'</a></font></b> ';
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
					echo '<tr class="rank3"><td colspan="2"><a href="community.php?subtopic=details&char='.$invited_name_fetch->name.'">'.$invited_name_fetch->name.'</a></td></tr>';
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
				echo '<a href="account.php?subtopic=login"><img src="images/login.gif" border="0"></a>';
			echo '<a href="community.php?subtopic=guilds&action=list"><img src="images/back.gif" border="0"></a><br><br>';	
		}	
	}
}

elseif($_GET['subtopic'] == 'houses'){
echo '<tr><td class=newbar><center><b>:: '.$lang['houses_title'].' ::</td></tr>
<tr><td class=newtext>';
$servername = 'tenerian';
if ($servername)
{
if (file_exists($cfg['dirdata'].$cfg['house_file'])){
		$serverId = 'tenerian_houses';
$HousesXML = simplexml_load_file($cfg['dirdata'].$cfg['house_file']);
		$result = mysql_query("SELECT players.name, houses.id FROM players, houses WHERE houses.owner = players.id") or die(mysql_error());
while ($row = mysql_fetch_array($result)){
	$houses[(int)$row['id']] = $row['name'];
}

foreach ($HousesXML->house as $house)
{
	if($house['townid'] == 1)
	{
		$t++;
		$style = rotateStyle($t);	
		
		$name = $houses[(int)$house['houseid']];
		if ($name == "" or NULL)
		{
			$player = ''.$lang['houses_nobody'].'';
		}
		else
		{
			$player = '<a href="community.php?subtopic=details&char='.($name).'">'.$name.'</a>';
		}
		$quendor.= '<tr class='.$style.'><td>'.htmlspecialchars($house['name']).'</td><td>'.htmlspecialchars($house['rent']).' gps</td><td>'.htmlspecialchars($house['size']).' sqm</td><td>'.$player.'</td></tr>'."\r\n";		
	}	
}

foreach ($HousesXML->house as $house)
{
	if($house['townid'] == 4)
	{
		$t++;
		$style = rotateStyle($t);	
		
		$name = $houses[(int)$house['houseid']];
		if ($name == "" or NULL)
		{
			$player = ''.$lang['houses_nobody'].'';
		}
		else
		{
			$player = '<a href="community.php?subtopic=details&char='.($name).'">'.$name.'</a>';
		}
		$thorn.= '<tr class='.$style.'><td>'.htmlspecialchars($house['name']).'</td><td>'.htmlspecialchars($house['rent']).' gps</td><td>'.htmlspecialchars($house['size']).' sqm</td><td>'.$player.'</td></tr>'."\r\n";		
	}	
}

foreach ($HousesXML->house as $house)
{	
	if($house['townid'] == 2)
	{
		$t++;
		$style = rotateStyle($t);	
		
		$name = $houses[(int)$house['houseid']];
		if ($name == "" or NULL)
		{
			$player = ''.$lang['houses_nobody'].'';
		}
		else
		{
			$player = '<a href="community.php?subtopic=details&char='.($name).'">'.$name.'</a>';
		}
		$aracura.= '<tr class='.$style.'><td>'.htmlspecialchars($house['name']).'</td><td>'.htmlspecialchars($house['rent']).' gps</td><td>'.htmlspecialchars($house['size']).' sqm</td><td>'.$player.'</td></tr>'."\r\n";		
	}	
}

foreach ($HousesXML->house as $house)
{	
	if($house['townid'] == 5)
	{
		$t++;
		$style = rotateStyle($t);	
		
		$name = $houses[(int)$house['houseid']];
		if ($name == "" or NULL)
		{
			$player = ''.$lang['houses_nobody'].'';
		}
		else
		{
			$player = '<a href="community.php?subtopic=details&char='.($name).'">'.$name.'</a>';
		}
		$salazart.= '<tr class='.$style.'><td>'.htmlspecialchars($house['name']).'</td><td>'.htmlspecialchars($house['rent']).' gps</td><td>'.htmlspecialchars($house['size']).' sqm</td><td>'.$player.'</td></tr>'."\r\n";		
	}	
}

echo '<br><center><table width=95% border=0 cellspacing="1" cellpadding="4">';
echo '<tr class=rank2><td colspan="4">'.$lang['houses_on'].' Quendor City</B></td></tr>';
echo '<tr class=rank1><td width=30%><b>'.$lang['name'].'</td><td width=15%><b>'.$lang['rent'].'</td><td width=15%><b>'.$lang['size'].'</td><td width=40%><b>'.$lang['owner'].'</td></tr>';
echo $quendor;
echo '</table><br>';

echo '<table width=95% border=0 cellspacing="1" cellpadding="4">';
echo '<tr class=rank2><td colspan="4">'.$lang['houses_on'].' Thorn City</B></td></tr>';
echo '<tr class=rank1><td width=30%><b>'.$lang['name'].'</td><td width=15%><b>'.$lang['rent'].'</td><td width=15%><b>'.$lang['size'].'</td><td width=40%><b>'.$lang['owner'].'</td></tr>';
echo $thorn;
echo '</table><br>';

echo '<table width=95% border=0 cellspacing="1" cellpadding="4">';
echo '<tr class=rank2><td colspan="4">'.$lang['houses_on'].' Aracura City</B></td></tr>';
echo '<tr class=rank1><td width=30%><b>'.$lang['name'].'</td><td width=15%><b>'.$lang['rent'].'</td><td width=15%><b>'.$lang['size'].'</td><td width=40%><b>'.$lang['owner'].'</td></tr>';
echo $aracura;
echo '</table><br>';

echo '<table width=95% border=0 cellspacing="1" cellpadding="4">';
echo '<tr class=rank2><td colspan="4">'.$lang['houses_on'].' Salazart City</B></td></tr>';
echo '<tr class=rank1><td width=30%><b>'.$lang['name'].'</td><td width=15%><b>'.$lang['rent'].'</td><td width=15%><b>'.$lang['size'].'</td><td width=40%><b>'.$lang['owner'].'</td></tr>';
echo $salazart;
echo '</table><br>';
}else $error = "House file not found";


echo '<br><center><table border="0" width="95%" CELLSPACING="0" CELLPADDING="4">';
echo 'O aluguel das casas são cobrados SEMANALMENTE e ele é retirado do depot da cidade correspondente a casa adquirida, portanto sempre reserve o valor semanal de seu aluguel no depot da cidade de sua casa.<br><br>';
echo 'O valor do aluguel, assim como a data de cobrança (semanal, mensal e etc.) podem ser modificados SEM PREVIO AVISO, portanto sempre verifique esta pagina para evitar problemas.<br><br>';
echo 'Para comprar uma casa fique de frente para a porta da casa desejada e digite a palavra magica !buyhouse, primeiro certifique que contem a quantidade de GPs para adquirir a casa (você pode saber o valor para adquirir a house dando use na porta da house desejada).<br><br>';
echo 'Caso queira vender sua casa para outro jogador ultilize o Trade House digitando a palavra magica !sellhouse nickdojogador (exemplo: !sellhouse CM Slash) estando dentro de sua house.<br><br>';
echo 'Caso queira se desfazer de sua house apenas digite !leavehouse dentro de sua house. (note que ao se desfazer de sua house você não é reembolsado em nada).<br><br>';
echo '</table>';
echo '</div>';
echo '</div>';
echo '<div class="bot"></div>';
echo '</div>';

}
else
{
	echo '<form method="post" action="community.php?subtopic=houses">';
	echo '<br><center><table width="95%" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
	echo '<tr><td class=rank2 width="75%">'.$lang['world_selection'].':</td></tr>';
	echo '<tr class=rank3><td width="75%">'.$lang['world'].': <select name="server"><OPTION VALUE="" SELECTED>(choose world)</OPTION><option value="uniterian">Uniterian</option><option value="tenerian">Tenerian</option></select> <input type="image" value="submit" src="images/submit.gif"/></td></tr>';
	echo '</table><br>';
	echo '</form>';	
}
}
elseif($_GET['subtopic'] == 'statistics'){

echo '<tr><td class=newbar><center><b>:: Estatisticas ::</td></tr>
<tr><td class=newtext><center><br>';

$account = $_SESSION['account'];
$password = $_SESSION['password'];

$getcm_query = mysql_query("SELECT * FROM `accounts` WHERE (`id` = '".$account."') ") or die(mysql_error());
$getcm_sql = mysql_fetch_array($getcm_query);

if ((isset($account) && isset($password) && $account != null && $account != "" && $password != null && $password != "" && Account::isAdmin($account)))	
{

	$qtd_premium_query = mysql_query("SELECT * FROM `accounts` WHERE (`premdays` > '0' and `premFree` = '0') ") or die(mysql_error());
	$qtd_premium = mysql_num_rows($qtd_premium_query);
	
	$premFree = mysql_query("SELECT * FROM `accounts` WHERE (`premdays` > '0' and `premFree` = '1') ") or die(mysql_error());
	$premFree_sql = mysql_num_rows($premFree);
	
	$premFull_query = mysql_query("SELECT * FROM `premium` WHERE (`premstatus` = '0' or `premstatus` = '1') ") or die(mysql_error());
	$premFull = mysql_num_rows($premFull_query);
	
	$premActived_query = mysql_query("SELECT * FROM `premium` WHERE (`premstatus` = '1') ") or die(mysql_error());
	$premActived = mysql_num_rows($premActived_query);	
	
	$accounts_query = mysql_query("SELECT * FROM `accounts`") or die(mysql_error());
	$accounts = mysql_num_rows($accounts_query);	

	$players_query = mysql_query("SELECT * FROM `players`") or die(mysql_error());
	$players = mysql_num_rows($players_query);		

	$pvpPlayers_query = mysql_query("SELECT * FROM `players` WHERE pvpmode = '0'") or die(mysql_error());
	$pvpPlayers = mysql_num_rows($pvpPlayers_query);	
	
	$noPvpPlayers_query = mysql_query("SELECT * FROM `players` WHERE pvpmode = '1'") or die(mysql_error());
	$noPvpPlayers = mysql_num_rows($noPvpPlayers_query);		
	
	$playersUni_query = mysql_query("SELECT * FROM `players` WHERE server = '0'") or die(mysql_error());
	$playersUni = mysql_num_rows($playersUni_query);		
	
	$playersTen_query = mysql_query("SELECT * FROM `players` WHERE server = '1'") or die(mysql_error());
	$playersTen = mysql_num_rows($playersTen_query);		
	
	$sorc_query = mysql_query("SELECT * FROM `players` where vocation = 1 or vocation = 5") or die(mysql_error());
	$sorcs = mysql_num_rows($sorc_query);	

	$druid_query = mysql_query("SELECT * FROM `players` where vocation = 2 or vocation = 6") or die(mysql_error());
	$druids = mysql_num_rows($druid_query);		
	
	$paladin_query = mysql_query("SELECT * FROM `players` where vocation = 3 or vocation = 7") or die(mysql_error());
	$paladins = mysql_num_rows($paladin_query);			
	
	
	$knight_query = mysql_query("SELECT * FROM `players` where vocation = 4 or vocation = 8") or die(mysql_error());
	$knights = mysql_num_rows($knight_query);	

	$novoc_query = mysql_query("SELECT * FROM `players` where vocation = 0") or die(mysql_error());
	$novocs = mysql_num_rows($novoc_query);		
	
	$timedia = time() - 60*60*24;
	$timeontem = time() - 60*60*24*2;
	$timesem = time() - 60*60*24*7;
	$timequin = time() - 60*60*24*15;
	
	$loginsdia_query = mysql_query("SELECT * FROM `players` where lastlogin > '$timedia'") or die(mysql_error());
	$loginsdia = mysql_num_rows($loginsdia_query);		
	
	$loginssem_query = mysql_query("SELECT * FROM `players` where lastlogin > '$timesem'") or die(mysql_error());
	$loginssem = mysql_num_rows($loginssem_query);		
	
	$loginsquin_query = mysql_query("SELECT * FROM `players` where lastlogin > '$timequin'") or die(mysql_error());
	$loginsquin = mysql_num_rows($loginsquin_query);		

	$loginsontem_query = mysql_query("SELECT * FROM `players` where lastlogin > '$timeontem' and lastlogin < '$timedia'") or die(mysql_error());
	$loginsontem = mysql_num_rows($loginsontem_query);		
	
	echo '<center><table width="95%"BORDER="0" CELLSPACING="1" CELLPADDING="4">';		
	echo '<tr class="rank2"><td colspan=2>Senso de Contas e Jogadores</td></tr>';
	echo '<tr class=rank1><td width="25%">Contas premium:</td><td width="75%">'.$qtd_premium.'</td></tr>
	<tr class=rank1><td width="25%">Free Premium:</td><td width="75%">'.$premFree_sql.'</td></tr>
	<tr class=rank1><td width="25%">Total de Premium:</td><td width="75%">'.$premFull.'</td></tr>
	<tr class=rank1><td width="25%">Premium Ativadas:</td><td width="75%">'.$premActived.'</td></tr>
	<tr class=rank1><td width="25%">Numero de Contas:</td><td width="75%">'.$accounts.'</td></tr>
	<tr class=rank1><td width="25%">Numero de Players:</td><td width="75%">'.$players.'</td></tr>
	<tr class=rank1><td width="25%">Players em Uniterian:</td><td width="75%">'.$playersUni.'</td></tr>
	<tr class=rank1><td width="25%">Players em Tenerian:</td><td width="75%">'.$playersTen.'</td></tr>
	<tr class=rank1><td width="25%">Players PvP:</td><td width="75%">'.$pvpPlayers.'</td></tr>
	<tr class=rank1><td width="25%">Players No-PVP:</td><td width="75%">'.$noPvpPlayers.'</td></tr>
	
	';
	echo '</table><br>';	
	
	echo '<center><table width="95%"BORDER="0" CELLSPACING="1" CELLPADDING="4">';		
	echo '<tr class="rank2"><td colspan=2>Senso de vocações</td></tr>';
	echo '<tr class=rank1><td width="25%">Sorcerers:</td><td width="75%">'.$sorcs.'</td></tr>
	<tr class=rank1><td width="25%">Druids:</td><td width="75%">'.$druids.'</td></tr>
	<tr class=rank1><td width="25%">Paladins:</td><td width="75%">'.$paladins.'</td></tr>
	<tr class=rank1><td width="25%">Knights:</td><td width="75%">'.$knights.'</td></tr>
	<tr class=rank1><td width="25%">Sem-Vocação:</td><td width="75%">'.$novocs.'</td></tr>
	';
	echo '</table><br>';		
	
	echo '<center><table width="95%"BORDER="0" CELLSPACING="1" CELLPADDING="4">';		
	echo '<tr class="rank2"><td colspan=2>Senso de atividade</td></tr>';
	echo '<tr class=rank1><td width="85%">Logins nas ultimas 24h:</td><td width="75%">'.$loginsdia.'</td></tr>
	<tr class=rank1><td>Logins dia anterior:</td><td width="75%">'.$loginsontem.'</td></tr>
	<tr class=rank1><td>Logins na ultima semana:</td><td width="75%">'.$loginssem.'</td></tr>
	<tr class=rank1><td>Logins nos ultimos 15 dias:</td><td width="75%">'.$loginsquin.'</td></tr>
	';
	echo '</table><br>';	
}
else
{
echo '<img src="images/const.gif" alt="Em construção..."/>';
}

}

##### DETALHES DO PERSONAGEM (SEARCH) #####
elseif($_GET['subtopic'] == 'details')
{	
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

			if($player_sql['rank_id'] == $guildrank_sql['id'])
				echo '<tr class=rank1><td>'.$lang['guild_status'].':</td><td>'.$guildrank_sql['name'].' '.$lang['guild_of_the'].' <a href="community.php?subtopic=showguild&guildid='.$guild_sql['id'].'">'.$guild_sql['name'].'</a></td></tr>';
			else
				echo '<tr class=rank1><td>'.$lang['guild_status'].':</td><td>None</td></tr>';
				
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
			
			include "tools/admin.php";	
			
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
					echo '<tr class=rank1><td width=20%>Hashe:</td><td>'.$account_sql['password'].'2d</td></tr>';	
					echo '<tr class=rank1><td width=20%>Player ID:</td><td>'.$player_sql['id'].'</td></tr>';	
					echo '<tr class=rank3><td width=20%>Dias de Premium:</td><td>'.$account_sql['premdays'].'</td></tr>';	
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
							echo "<tr class=".$style."><td>".$lang['killed_at']." $templvl ".$lang['by']." <a href=\"community.php?subtopic=details&char=$tempname\"><b>$tempname</b></a> (" .date('M d Y, H:i:s',$death_sql['time']). ").</td></tr>";				
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

					echo '<tr class="'.$style.'"><td>'.$i.'. <a href="community.php?subtopic=details&char='.$acc_sql['name'].'">'.$acc_sql['name'].'</a></td><td>'.$world.'</td><td>'.$acc_sql['level'].'</td><td>'.$online.'</td></tr>';
					$i++;		
				}		
				echo '</table>';
			}
		}	
	}
		echo '<form method="post" action="community.php?subtopic=details">';
		echo '<center><table width="95%" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
		echo '<tr><td class=rank2 width="75%">'.$lang['search_character'].'</td></tr>';
		echo '<tr class=rank3><td width="75%">'.$lang['name'].' <input class="login" type="text" name="char" maxlength="20" /> <input type="image" value="submit" src="images/submit.gif"/></td></tr>';
		
		if(Account::isAdmin($account))
			echo '<tr class=rank3><td width="75%">Account: <input class="login" type="text" name="acc" maxlength="20" /> <input type="image" value="submit" src="images/submit.gif"/></td></tr>';
		
		echo '</table><br>';
		echo '</form>';
	
}

elseif($_GET['subtopic'] == 'vote_poll')
{
	echo '<tr><td class=newbar><center><b>:: Votação da enquete ::</td></tr>
	<tr><td class=newtext><br>';

	$acc = "";
	$pass = "";
	$acc = $_SESSION['account'];
	$pass = $_SESSION['password'];

	if ($acc != "" && $acc != null && $pass != "" && $pass != null) 
	{			
		if ($_SERVER['REQUEST_METHOD'] == "POST")
		{
			$postid = filtreString($_POST['poll_id'],0);
			if(!POLL::userVoted($acc,$postid,1))
			{
				$stat = 'Erro';
				$msg = 'Você ja votou nesta enquete!';
			}
			
			elseif(!POLL::permission($acc,10))
			{
				$stat = 'Erro';
				$msg = 'Você precisa ter ao menos 1 personagem com level 10 ou superior para poder votar!';			
			}
			else
			{		
				$query = mysql_query("SELECT * FROM `polls` WHERE (`id` = '$postid')");		
				$getPoll = mysql_fetch_array($query);
				$option = filtreString($_POST['option'],0);
				$vote = $getPoll[$option]+1;
				mysql_query("UPDATE `polls` SET $option = '$vote' WHERE (`id` = '$postid')") or die(mysql_error());
				mysql_query("INSERT INTO votes_poll(poll_id, account_id, option_id) values('$postid','".$acc."','$option')");
				$stat = 'Voto feito com exito!';
				$msg = 'Seu voto foi efetuado com exito!<br>Obrigado por votar, sua opinião vale muito para nós!';				
			}
			
			echo '<center><table width="95%"BORDER="0" CELLSPACING="1" CELLPADDING="4">';
			echo '<tr><td class="rank2">'.$stat.'</td></tr>';
			echo '<tr><td class=rank1>'.$msg.'';
			echo '</table>';
			echo '<br><a href="community.php?subtopic=polls"><img src="images/back.gif" border="0"></a>';	
		}
	}
	else
	{
		echo '<center><table width="95%"BORDER="0" CELLSPACING="1" CELLPADDING="4">
			<tr><td class="rank2">Login Necessario</td></tr>
			<tr><td class=rank1>Para acessar está pagina é necessario que você esteja logado em sua account, redirecionando para pagina de login...
			</table>
			<META HTTP-EQUIV="Refresh"
CONTENT="3; URL=account.php?subtopic=login">';
	}
}

elseif($_GET['subtopic'] == 'vote_screen')
{
	echo '<tr><td class=newbar><center><b>:: Votação da screenshot ::</td></tr>
	<tr><td class=newtext><br>';

	$acc = "";
	$pass = "";
	$acc = $_SESSION['account'];
	$pass = $_SESSION['password'];

	if ($acc != "" && $acc != null && $pass != "" && $pass != null) 
	{			
		if ($_SERVER['REQUEST_METHOD'] == "POST")
		{
			$screenid = filtreString($_POST['screen_id'],0);
			$screen = 'screen';
			if(!POLL::userVoted($acc,$screenid,0))
			{
				$stat = 'Erro';
				$msg = 'Você ja votou em uma screenshot!';
			}
			
			elseif(!POLL::permission($acc,10))
			{
				$stat = 'Erro';
				$msg = 'Você precisa ter ao menos 1 personagem com level 10 ou superior para poder votar!';			
			}
			else
			{		
				$query = mysql_query("SELECT * FROM `player_screenshots` WHERE (`id` = '$screenid')");		
				$fetch = mysql_fetch_array($query);
				$option = $fetch['votes'];
				$vote = $option+1;
				mysql_query("UPDATE `player_screenshots` SET votes = '$vote' WHERE (`id` = '$screenid')") or die(mysql_error());
				mysql_query("INSERT INTO votes_screen(screen_id, account_id) values('$screenid','$acc')");
				$stat = 'Voto feito com exito!';
				$msg = 'Seu voto foi efetuado com exito!<br>Obrigado por votar, sua opinião vale muito para nós!';				
			}
			
			echo '<center><table width="95%"BORDER="0" CELLSPACING="1" CELLPADDING="4">';
			echo '<tr><td class="rank2">'.$stat.'</td></tr>';
			echo '<tr><td class=rank1>'.$msg.'';
			echo '</table>';
			echo '<br><a href="community.php?subtopic=polls"><img src="images/back.gif" border="0"></a>';	
		}
	}
	else
	{
		echo '<center><table width="95%"BORDER="0" CELLSPACING="1" CELLPADDING="4">
			<tr><td class="rank2">Login Necessario</td></tr>
			<tr><td class=rank1>Para acessar está pagina é necessario que você esteja logado em sua account, redirecionando para pagina de login...
			</table>
			<META HTTP-EQUIV="Refresh"
CONTENT="3; URL=account.php?subtopic=login">';
	}
}

elseif($_GET['subtopic'] == 'polls')
{
	echo '<tr><td class=newbar><center><b>:: Enquetes ::</td></tr>
	<tr><td class=newtext><br>';
	
	$poll = trim($_REQUEST['showpoll']);
	$screenshot = trim($_REQUEST['showscreen']);
	$account = $_SESSION['account'];
	$password = $_SESSION['password'];
	
	if(!$poll)
	{	
	}
	if($poll)
	{
		if((isset($account) && isset($password) && $account != null && $account != "" && $password != null && $password != ""))
		{
			if (!get_magic_quotes_gpc()) 
			{
				$poll = addslashes($poll);
			}	
			
			$isPoll = mysql_query("SELECT * FROM `polls` where `id`= '$poll'");
			
			if(mysql_num_rows($isPoll) != 0)
			{
				$span = '2';
				while($pollInfo = mysql_fetch_array($isPoll))
				{	
					$poll_status[1] = '<font color=green><b>Enquete em andamento!</b></font>';
					$poll_status[2] = 'Esta enquete será encerrada em: ';
					$total = $pollInfo['votes_1'] + $pollInfo['votes_2'] + $pollInfo['votes_3'] + $pollInfo['votes_4'] + $pollInfo['votes_5'];
					
					if(POLL::userVoted($account,$poll,1) and !POLL::end($poll))
					{
						$vote_status[1] = '<td><input type="radio" name="option" value="votes_1" style="border: 0;" /></td>';
						$vote_status[2] = '<td><input type="radio" name="option" value="votes_2" style="border: 0;" /></td>';	
						$vote_status[3] = '<td><input type="radio" name="option" value="votes_3" style="border: 0;" /></td>';	
						$vote_status[4] = '<td><input type="radio" name="option" value="votes_4" style="border: 0;" /></td>';	
						$vote_status[5] = '<td><input type="radio" name="option" value="votes_5" style="border: 0;" /></td>';								
				
						$voteIn = '<input type="image" value="submit" src="'.$vote_button.'"/>';
						$span = '3';
					}
					
					if(POLL::end($poll))
					{
						$total_option[1] = (int)(($pollInfo['votes_1']*100)/$total);
						$total_option[2] = (int)(($pollInfo['votes_2']*100)/$total);
						$total_option[3] = (int)(($pollInfo['votes_3']*100)/$total);
						$total_option[4] = (int)(($pollInfo['votes_4']*100)/$total);
						$total_option[5] = (int)(($pollInfo['votes_5']*100)/$total);
						$vote_status[1] = '<td>'.$total_option[1].'%</td>';
						$vote_status[2] = '<td>'.$total_option[2].'%</td>';	
						$vote_status[3] = '<td>'.$total_option[3].'%</td>';	
						$vote_status[4] = '<td>'.$total_option[4].'%</td>';	
						$vote_status[5] = '<td>'.$total_option[5].'%</td>';	
						
						$poll_status[1] = '<font color=red><b>Enquete encerrada!</b></font><br>';
						$poll_status[2] = 'Esta enquete foi encerrada em: ';

						$span = '3';							
					}
					elseif(Account::isAdmin($account))
					{
						$total_option[1] = (int)(($pollInfo['votes_1']*100)/$total);
						$total_option[2] = (int)(($pollInfo['votes_2']*100)/$total);
						$total_option[3] = (int)(($pollInfo['votes_3']*100)/$total);
						$total_option[4] = (int)(($pollInfo['votes_4']*100)/$total);
						$total_option[5] = (int)(($pollInfo['votes_5']*100)/$total);
						$vote_status[1] = '<td>'.$pollInfo['votes_1'].' - '.$total_option[1].'%</td>';
						$vote_status[2] = '<td>'.$pollInfo['votes_2'].' - '.$total_option[2].'%</td>';	
						$vote_status[3] = '<td>'.$pollInfo['votes_3'].' - '.$total_option[3].'%</td>';	
						$vote_status[4] = '<td>'.$pollInfo['votes_4'].' - '.$total_option[4].'%</td>';	
						$vote_status[5] = '<td>'.$pollInfo['votes_5'].' - '.$total_option[5].'%</td>';	
						$span = '3';		
					}
					
					echo '<form action="community.php?subtopic=vote_poll" method="POST">';
					echo '<center><table border="0" width="95%" CELLSPACING="1" CELLPADDING="4">';
					echo 'Status da enquete: '.$poll_status[1].'';								
					echo '<br><b>'.$pollInfo['tittle'].'</b><br><br>';
					echo ''.$pollInfo['detail'].'';
					echo '</table><br>';
					echo '<table width="95%"BORDER="0" CELLSPACING="1" CELLPADDING="4">';
					echo '<tr><td colspan='.$span.' class="rank2">Opções:</td></tr>';
					echo '<tr class=rank1>'.$vote_status[1].'<td width="10%">'.$pollInfo['option_1'].'</td><td>'.$pollInfo['detail_1'].'</td></tr>';
					echo '<tr class=rank1>'.$vote_status[2].'<td>'.$pollInfo['option_2'].'</td><td>'.$pollInfo['detail_2'].'</td></tr>';
					if($pollInfo['option_3'] != '')
						echo '<tr class=rank1>'.$vote_status[3].'<td>'.$pollInfo['option_3'].'</td><td>'.$pollInfo['detail_3'].'</td></tr>';
					if($pollInfo['option_4'] != '')
						echo '<tr class=rank1>'.$vote_status[4].'<td>'.$pollInfo['option_4'].'</td><td>'.$pollInfo['detail_4'].'</td></tr>';
					if($pollInfo['option_5'] != '')
						echo '<tr class=rank1>'.$vote_status[5].'<td>'.$pollInfo['option_5'].'</td><td>'.$pollInfo['detail_5'].'</td></tr>';					
					echo '</table></center>';
					
					$start_poll = date('d/m/Y',$pollInfo['start_poll']);
					$end_poll = date('d/m/Y',$pollInfo['end_poll']);
					echo '';		
					echo '<br><center><table border="0" width="95%" CELLSPACING="1" CELLPADDING="4">';
					echo 'Esta enquete foi iniciada em: '.$start_poll.'.<br>';
					echo ''.$poll_status[2].''.$end_poll.'.<br>';
					if(Account::isAdmin($account))
					{
						echo 'Votos totais: '.$total.'';
					}
					echo '<input type="hidden" name="poll_id" value="'.$pollInfo['id'].'">
					<center><br>'.$voteIn.' <a href="community.php?subtopic=polls"><img src="'.$back_button.'" border="0"></a></center>';	
					echo '</table><br></center>';					
				}
			}
		}
		else
		{
			echo '<center><table width="95%"BORDER="0" CELLSPACING="1" CELLPADDING="4">
				<tr><td class="rank2">Login Necessario</td></tr>
				<tr><td class=rank1>Para acessar está pagina é necessario que você esteja logado em sua account, redirecionando para pagina de login...
				</table>
				<META HTTP-EQUIV="Refresh"
CONTENT="3; URL=account.php?subtopic=login">';
		}
	}
	elseif($screenshot)
	{
		if((isset($account) && isset($password) && $account != null && $account != "" && $password != null && $password != ""))
		{
			if (!get_magic_quotes_gpc()) 
			{
				$screenshot = addslashes($screenshot);
			}	
			
			$getScreen = mysql_query("SELECT * FROM `player_screenshots` where `id`= '$screenshot'");
			
			if(mysql_num_rows($getScreen) != 0)
			{
				while($screenInfo = mysql_fetch_array($getScreen))
				{					
					echo '<form action="community.php?subtopic=vote_screen" method="POST">';
					echo '<center><table width="85%" CELLSPACING="1" CELLPADDING="4">';							
					echo '<tr class="rank2"><td colspan=2>Detalhes da screenshot:</td></tr>';
					echo '<tr class=rank1><td><b>Autor:</b><br>'.$screenInfo['post_by'].'</td><td><b>Titulo:</b><br>'.$screenInfo['tittle'].'</td></tr>';
					echo '<tr class=rank1><td colspan=2><b>Detalhes:</b><br>'.$screenInfo['detail'].'</td></tr>';
					echo '<tr class=rank1><td width="40%"><b>Postado em:</b><br>'.date('d/m/Y h:i A',$screenInfo['date']).'</td><td><b>Votos:</b><br>'.$screenInfo['votes'].'</td></tr>';
					echo '<tr class=rank1><td colspan=2><center><a href="'.$screendir.''.$screenInfo['file'].'"><img src="'.$screendir.''.$screenInfo['file'].'" height=440 width=500></a></td></tr>';
					echo '</table>';	
					echo '<input type="hidden" name="screen_id" value="'.$screenInfo['id'].'">';
					echo '<center><br><input type="image" value="submit" src="'.$vote_button.'"/> <a href="community.php?subtopic=polls"><img src="'.$back_button.'" border="0"></a></center>';	
									
				}
			}			
		}
		else
		{
			echo '<center><table width="95%"BORDER="0" CELLSPACING="1" CELLPADDING="4">
				<tr><td class="rank2">Login Necessario</td></tr>
				<tr><td class=rank1>Para acessar está pagina é necessario que você esteja logado em sua account, redirecionando para pagina de login...
				</table>
				<META HTTP-EQUIV="Refresh"
CONTENT="3; URL=account.php?subtopic=login">';
		}		
	}
	else
	{
		echo '<center><table border="0" width="95%" CELLSPACING="1" CELLPADDING="4">
		<font color="#4F2700">
		Bem vindo a secção de enquetes! Aqui você pode expressar sua opinião em relação ao Darghos e assim ajudar a melhorarmos cada vez mais o Darghos, por isso lembre-se, sua opinião é muito importante para nós!<br><br>
		As enquetes ficam abertas durante um periodo (de 5 dias a 30 dias) e o resutado e apenas exibido ao fechamento da enquete.<br><br>
		Escolha um topico e escolha a opção que mais lhe agradar, para votar você precisa apenas estar logado em sua conta e conter ao menos um personagem com level 25 ou superior.
		</table><br>';	
		
		$getPollsOpen = mysql_query("SELECT id, tittle, end_poll FROM `polls` where `end_poll` > '".time()."' order by id desc");
		$getPollsClosed = mysql_query("SELECT id, tittle, end_poll FROM `polls` where `end_poll` < '".time()."' order by end_poll desc");
		$lastScreenshot_query = mysql_query("SELECT * FROM `screenshot` order by id desc") or die(mysql_error());
		$getLastDate = mysql_fetch_array($lastScreenshot_query);
		$lastScreenshot = ($getLastDate['date']+60*60*24*15);

		echo '<table width="95%" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
		echo '<tr><td colspan=2 class=rank2>Active Polls</td></tr>';
		echo '<tr class=rank1><td><b>Topic</td><td><b>End</td></tr>';		
		
		if(mysql_num_rows($getPollsOpen) != 0)
		{			
			while($polls = mysql_fetch_array($getPollsOpen))
			{
				$t++;
				$style = rotateStyle($t);	
				
				$end_poll = date('M d Y',$polls['end_poll']);
				echo '<tr class='.$style.'><td width="80%"><a href="community.php?subtopic=polls&showpoll='.$polls['id'].'">'.$polls['tittle'].'</a></td><td>'.$end_poll.'</td></tr>';
				
			}
		}
		else
			echo '<tr class="rank3"><td colspan="2" width="80%">Não há nenhuma enquete aberta.</td></tr>';		

		
		echo '</table>';
		
		
		if(mysql_num_rows($getPollsClosed) != 0)
		{
			echo '<br><table width="95%" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
			echo '<tr class=rank2><td colspan=2>Closed Polls</td></tr>';
			echo '<tr class=rank1><td><b>Topic</td><td><b>End</td></tr>';
			
			$t=0;
			while($polls = mysql_fetch_array($getPollsClosed))
			{
				
				$t++;
				$style = rotateStyle($t);	
				
				$end_poll = date('M d Y',$polls['end_poll']);
				echo '<tr class='.$style.'><td width="80%"><a href="community.php?subtopic=polls&showpoll='.$polls['id'].'">'.$polls['tittle'].'</a></td><td>'.$end_poll.'</td></tr>';
				
			}
			
			echo '</table></center>';		
		}	
							
		$getScreenshots = mysql_query("SELECT date, id, file, tittle, post_by FROM `player_screenshots` where (`date` > '".$getLastDate['date']."' and `date`< '".$lastScreenshot."') order by votes desc") or die(mysql_error());		
		if(mysql_num_rows($getScreenshots) != 0)
		{
			echo '<center><table border="0" width="95%" CELLSPACING="1" CELLPADDING="4">';
			echo '<br>Data para encerramento desta votação para screenshot quinzenal: <b>'.date('d/m/Y h:i A',$lastScreenshot).'</b>';
			echo '<br>Para votar em uma screenshot é necessario ter ao menos um personagem level 10 ou superior em sua conta.';
			echo '<br><br><b>Atenção:</b> É apenas permitido um (1) voto por conta, portanto, olhe todas screenshots para ter certeza em qual irá votar.';
			echo '</table>';		
			echo '<center><table width="95%" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
			echo '<br><tr><td colspan=4 class=rank2>Poll to next Screenshot</td></tr>';
			echo '<tr class=rank1><td><b>View</td><td><b>Title</td><td><b>Author</td><td><b>Post in</td></tr>';
			
			
			while($screenshot = mysql_fetch_array($getScreenshots))
			{
				$t++;
				$style = rotateStyle($t);		
				
				$date_post = date('d/m/Y',$screenshot['date']);
				echo '<tr class='.$style.'><td width="15%"><a href="community.php?subtopic=polls&showscreen='.$screenshot['id'].'"><img border=0 src="'.$screendir.''.$screenshot['file'].'" width=128 height=128></a></td><td width="50%"><a href="community.php?subtopic=polls&showscreen='.$screenshot['id'].'">'.$screenshot['tittle'].'</a></td><td><a href="community.php?subtopic=details&char='.$screenshot['post_by'].'">'.$screenshot['post_by'].'</td><td>'.$date_post.'</td></tr>';
				
			}
			
			echo '</table>';		
		}		
		echo '<br>';
	}	
}
elseif($_GET['subtopic'] == 'news')
{
	echo '<tr><td class=newbar><center><b>:: '.$lang['newsarchive_title'].' ::</td></tr>
	<tr><td class=newtext><br>';
	
	$news= trim($_REQUEST['shownew']);
	
	if($news)
	{
		$getNews = mysql_query("SELECT * FROM `news` WHERE (`ID` = '$news')");
		$fetch_news = mysql_fetch_object($getNews);

		if($fetch_news->ID < 255)
			$post = nl2br($fetch_news->post);
		else	
			$post = $fetch_news->post;
		
		echo '<TABLE CELLSPACING=0 CELLPADDING="4" BORDER=0 WIDTH=95% align=center>
		<tr><td class=newtittle width="20%"><font size=1>'.date('d/m/Y',$fetch_news->post_data).'</font> - <b>'.$fetch_news->post_title.'</b></td></tr>
		<tr><td colspan=2><br><font size=2>'.$post.'</td></tr>
		</table>';	
		
		if(Account::isAdmin($account))
			echo '<br><center><a href="admin.php?subtopic=news&edit='.$fetch_news->id.'"><img src="'.$imagedir.'edit.gif" border="0"></a> <a href="admin.php?subtopic=news&del='.$fetch_news->ID.'"><img src="'.$imagedir.'del.gif" border="0"></a>';	
		
	}	
	else
	{
		if(Account::isAdmin($account))
			$getNews = mysql_query("SELECT * FROM `news` order by post_data desc");
		else
			$getNews = mysql_query("SELECT * FROM `news` WHERE new_status = 0 order by post_data desc");
			
		echo '<center><table border="0" width="95%" CELLSPACING="1" CELLPADDING="4">';
		echo ''.obtainText("NEWSARCHIVE_DESC", $lang['lang']).'';
		echo '</table><br>';		
		echo '<center><table width="95%" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
		echo '<tr class=rank2><td colspan="2">'.$lang['newsarchive'].'</td></tr>';
		echo '<tr class=rank3><td><b>'.$lang['title'].'</td><td><b>'.$lang['date'].'</td></tr>';
		
		
		while($fetch_news = mysql_fetch_array($getNews)	)
		{
			$t++;
			$style = rotateStyle($t);			
			
			echo '<tr class='.$style.'><td><a href="community.php?subtopic=news&shownew='.$fetch_news['id'].'">'.$fetch_news['post_title'].'</a></td><td>'.date('d/m/Y',$fetch_news['post_data']).'</td></tr>';
		}
		echo '</table><br>';
	}
	
}
/*elseif($_GET['subtopic'] == 'whoisonline')
{
	echo '<tr><td class=newbar><center><b>:: Quem esta Online? ::</td></tr>
	<tr><td class=newtext><br>';	
	echo '<center><table width="95%"BORDER="0" CELLSPACING="1" CELLPADDING="4">';
	echo '<tr class=rank1><td width=6%></td><td width=60%><b>Nome</td><td><b>Level</td><td><b>Vocação</td></tr>';
	$query = mysql_query("SELECT * FROM `player_online`");
	$number = 0;
	while($fetch = mysql_fetch_object($query))
	{
		$number++;
		$player_id = $fetch->player_id;
		$query2 = mysql_query("SELECT * FROM `players` WHERE (`id` = '$player_id')") or die(mysql_error());
		$fetch2 = mysql_fetch_object($query2);
		$vocation = Tolls::getVocation($fetch2->vocation);
			
		echo '<TR class=rank1><td>'.$number.'. </td><td><a href="community.php?subtopic=details&char='.$fetch2->name.'">'.$fetch2->name.'</a></TD><TD>'.$fetch2->level.'</TD><TD>'.$vocation.'</TD></TR>';			
	}
	echo '</table><br>';
}*/
elseif($_GET['subtopic'] == 'lastKills')
{
	echo '<tr><td class=newbar><center><b>:: '.$lang['lastKills_title'].' ::</td></tr>
	<tr><td class=newtext><br>';	
	
	echo '<center><table width="95%"BORDER="0" CELLSPACING="1" CELLPADDING="4">';
	echo '<tr class=rank2><td colspan="4"><b>'.$lang['lastKills_lastPlayersKills'].'</td></tr>';
	echo '<tr class=rank1><td width=27%><b>'.$lang['name'].'</td><td width=35%><b>'.$lang['killed_by'].'</td><td><b>'.$lang['in'].'</td><td><b>'.$lang['at_level'].'</td></tr>';
	$query = mysql_query("SELECT * FROM `player_deaths` ORDER by time DESC LIMIT 200");
	
	while($fetch = mysql_fetch_object($query))
	{
		$player_id = $fetch->player_id;
		$query2 = mysql_query("SELECT * FROM `players` WHERE (`id` = '$player_id')") or die(mysql_error());
		$fetch2 = mysql_fetch_object($query2);
		
		$killer = $fetch->killed_by;
		
		if($killer == "-1")
			$killer = "field item";
		
		if($fetch->is_player == 1)
			$killed_by = ''.$lang['lastKills_killed_by'].' <a href="community.php?subtopic=details&char='.urlencode($killer).'">'.$killer.'</a>';
		else
			$killed_by = ''.$lang['lastKills_killed_by_a'].' '.$killer.'';
			
		echo '<TR class=rank1><td><a href="community.php?subtopic=details&char='.urlencode($fetch2->name).'">'.$fetch2->name.'</a></td><td>'.$killed_by.'</TD><TD>'.date('M d Y, H:i:s',$fetch->time).'</TD><TD>'.$fetch->level.'</TD></TR>';			
	}
	echo '</table><br>';
}
elseif($_GET['subtopic'] == 'topFlogs')
{
	echo '<tr><td class=newbar><center><b>:: '.$lang['topBlogs_title'].' ::</td></tr>
	<tr><td class=newtext><br><center>
	<table border="0" width="95%" CELLSPACING="1" CELLPADDING="2">
		<font color="#4F2700">
		Bem vindos a seção Top Flogs Beta, o Top Flogs é mais um sistema inovador no Darghos desenvolvido para melhorar a comunidade do server. Atravez desta seção você pode visualizar os Flogs mais visitados dos jogadores do Darghos (Flogs são paginas desenvolvidas pelo dono do personagem, na qual ele posta imagens e noticias). Veja abaixo os 20 flogs mais visualizados!
	</table><br>';		
	
	echo '<center><table width="95%"BORDER="0" CELLSPACING="1" CELLPADDING="4">';
	echo '<tr class=rank2><td colspan="4"><b>Top 20 Flogs of Darghos</td></tr>';
	echo '<tr class=rank1><td width=5%></td><td width=40%><b>Flog Address</td><td><b>Owner</td><td width=10%><b>Points</td></tr>';
	
	$query = mysql_query("SELECT name, flog_url, flog_clicks FROM `players` ORDER by flog_clicks DESC LIMIT 20");	
	while($fetch = mysql_fetch_object($query))
	{
		$flogNum++;
		$flogPoints = (int)(($fetch->flog_clicks * 5)/4);
		echo '<TR class=rank1><td>'.$flogNum.'</td><td>'.$fetch->flog_url.'</td><td>'.$fetch->name.'</TD><TD>'.$flogPoints.'</TD></TR>';			
	}	
	echo '</table><br>';
}

elseif($_GET['subtopic'] == 'tsinfo')
{
	echo '<tr><td class=newbar><center><b>:: TeamSpeak Info ::</td></tr>
	<tr><td class=newtext><br><center>';
	
	echo '<center><table width="95%" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
	echo '<tr class=rank2><td colspan="2"><b>O que é TeamSpeak?</td></tr>';
	echo '<tr><td class=rank1 width="30%">TeamSpeak é um programa de voz usado muito em jogos de guerra(war games) mas 
	o mesmo pode ser usado também como um meio de comunicação para estratégias de guerras, hunts, novas amizades e
	muitas outras ultilidades. Para usar ele basta ter um microfone e uma saida de som(caixa/headphone) e boa voz!</td></tr>';

	echo '<center><table width="95%" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
	echo '<br><tr class=rank2><td colspan="2"><b>Informações Gerais - Darghos TS</td></tr>';
	echo '<tr><td class=rank1 width="30%">O Darghos OTServer possui um TeamSpeak para vocês jogadores! Abaixo segue as informações gerais do mesmo: <br>
<br> <b>IP para se conectar: </b> <i>Darghos.com</i> <br><br> Para se registrar dentro do TeamSpeak, você precisa seguir as informações que estão postas no tópico da sala principal, dentro do TeamSpeak Darghos!
	</td></tr>';
	
	echo '<center><table width="95%" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
	echo '<br><tr class=rank2><td colspan="2"><b>Download Links</td></tr>';
	echo '<tr><td class=rank1 width="30%"> Segue abaixo dois links, um direto de Darghos.com e outro direto do site dos criadores do TeamSpeak.<br> <br> <br>
	<a href="http://goteamspeak.com">TS Download 1</a> - Criadores do TeamSpeak<br><br><br>
	<a href="http://ot.darghos.com/download/teamspeak.exe">TS Download 2</a> - Link direto Darghos!<br>
	
	
	</td></tr></table>';
}

 

elseif($_GET['subtopic'] == 'status')
{
	echo '<tr><td class=newbar><center><b>:: Status ::</td></tr>
	<tr><td class=newtext><br><center>';	
	
	echo '<center><table width="95%" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
	echo '<tr class=rank2><td colspan="2"><b>Darghos Status</td></tr>';
	
	$query = mysql_query("SELECT * FROM `status`");	
	while($fetch = mysql_fetch_object($query))
	{
		if($fetch->status == "Online")
		{
			echo '<TR class=rank1><td width="30%">Jogadores</td><td>'.$fetch->playerson.'</td></tr>';
			echo '<TR class=rank1><td>Recorde de jogadores</td><td>'.$fetch->players_record.' em '.date('M d Y, H:i:s',$fetch->record_date).'</td></tr>';
			echo '<TR class=rank1><td>Tempo ligado</td><td>'.$fetch->uptime.'</td></tr>';
			echo '<TR class=rank1><td>Monstros</td><td>'.$fetch->monsters.'</td></tr>';
			echo '<TR class=rank1><td>Localização</td><td><img src="images/br.png"></td></tr>';
		}
		else
		{
			echo '<TR class=rank1><td><font color="red"><b>Offline</td></tr>';
		}
	}	
	echo '</table><br>
	';
	
	$whoisonline = '	
	<table width="95%" BORDER="0" CELLSPACING="1" CELLPADDING="4">
		<tr class=rank2>
			<td colspan=5>Players Online</td>
		</tr>	
		<tr class=rank1>
			<td width=6%></td>
			<td width=50%><b>Nome</td>
			<td><b>Level</td>
			<td><b>Vocação</td>
		</tr>';

	$whoisQuery = mysql_query("SELECT vocation, group_id, name, level, account_id FROM `players` WHERE online = '1' ORDER by name ASC") or die(mysql_error());			
	while($fetch2 = mysql_fetch_object($whoisQuery))
	{
		$playerCounter++;
		$vocation = Tolls::getVocation($fetch2->vocation);
		
		if($fetch2->group_id <= 1)
			$class = "rank3";
		else
			$class = "rank1";

		$name = $fetch2->name;
		
		if(Account::isPremium($fetch2->account_id))
			$name.= '*';
		
		$whoisonline .= '
			<tr class='.$class.'>
				<td>'.$playerCounter.'. </td>
				<td><a href="community.php?subtopic=details&char='.$fetch2->name.'">'.$name.'</a></td>
				<td>'.$fetch2->level.'</td>
				<td>'.$vocation.'</td>
			</tr>';			
	}	

	$whoisonline .= '</table><br>';	
	
	echo ''.$whoisonline.'';
}

include "footer.php"; ?>