<?
if($engine->accountAccess() >= GROUP_GOD)
{
	$query = mysql_query("SELECT * FROM `premium` ORDER by date desc") or die(mysql_error());	
	echo '<tr><td class=newbar><center><b>:: Payment List ::</td></tr>
	<tr><td class=newtext><center><br>';
	echo '<center><table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
	echo '<tr><td width="25%" class=rank1>Account of:</td><td width="5%" class=rank1>Days</td><td width="45%" class=rank1>Date</td><td width="25%" class=rank1>Status</td></tr>';
	while($fetch = mysql_fetch_object($query))
	{	
	$query2 = mysql_query("SELECT * FROM `players` WHERE `account_id` = '".$fetch->account_id."' ORDER by level desc") or die(mysql_error());
	$player_fetch = mysql_fetch_object($query2);
	$name = $player_fetch->name;
	echo '<tr><td class=rank1><a href="?page=character.details&char='.$name.'">'.$fetch->account_id.'</a></td><td class=rank1>'.$fetch->premdays.'</td><td class=rank1>'.date('M d Y, H:i:s',$fetch->date).'</td><td class=rank1>'.Tolls::premiumType($fetch->premstatus).'</td></tr>';
	}
	echo '</table><br>';
}
?>