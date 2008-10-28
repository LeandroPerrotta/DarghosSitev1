<?
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
		$killed_by = ''.$lang['lastKills_killed_by'].' <a href="?page=character.details&char='.urlencode($killer).'">'.$killer.'</a>';
	else
		$killed_by = ''.$lang['lastKills_killed_by_a'].' '.$killer.'';
		
	echo '<TR class=rank1><td><a href="?page=character.details&char='.urlencode($fetch2->name).'">'.$fetch2->name.'</a></td><td>'.$killed_by.'</TD><TD>'.date('M d Y, H:i:s',$fetch->time).'</TD><TD>'.$fetch->level.'</TD></TR>';			
}
echo '</table><br>';
?>