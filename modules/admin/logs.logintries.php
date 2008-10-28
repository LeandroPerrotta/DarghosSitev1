<?
if($engine->accountAccess() >= GROUP_GOD)
{
	$query = mysql_query("SELECT * FROM site.logs_logintries ORDER by date desc LIMIT 500") or die(mysql_error());
	echo '<tr><td class=newbar><center><b>:: Login Tries Logs ::</td></tr>
	<tr><td class=newtext><center><br>';
	echo '<center><table width="95%" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
	echo '<tr class=rank2><td colspan=4><b>All Premium Accounts</td></tr>';
	echo '<tr class=rank1>
			<td width="40%"><b>Account</td>
			<td width="10%"><b>Success</td>
			<td width="10%"><b>IP Addr</td>
			<td width="40%"><b>Date</td>
	</tr>';

	while($fetch = mysql_fetch_object($query))
	{	
		echo '<tr class=rank3>
			<td>'.$fetch->account.'</a></td>
			<td>'.$fetch->success.'</td>
			<td>'.$fetch->ip.'</td>
			<td>'.date('M d Y, H:i:s',$fetch->date).'</td>
		</tr>';
	}
	echo '</table><br>';
}	
?>
