<?
if($engine->accountAccess() >= GROUP_GOD)
{
	echo '<tr><td class=newbar><center><b>:: Item Log ::</td></tr>
	<tr><td class=newtext><br>';

	echo '<center><table width="85%" border="0" cellpadding="4" cellspacing="1">';
	echo '<tr class="rank2"><td colspan="4"><b>Lista de itens obtidos pelo Item Shop:</td></tr>';
	echo '<tr class="rank1"><td width="25%"><b>Usuario:</td><td><b>Data:</td><td><b>Item:</td><td><b>Premdays:</td></tr>';

	$query = mysql_query("SELECT * FROM `item_shop` order by date desc") or die(mysql_error());

	if(mysql_num_rows($query) != 0)
	{
		$totalDays = 0;
		
		while($fetch = mysql_fetch_object($query))
		{
			$count++;
			$acc_query = mysql_query("SELECT * FROM `players` WHERE (`account_id` = '".$fetch->account_id."') ORDER by level desc") or die(mysql_error());
			$acc_fetch = mysql_fetch_object($acc_query);		
			
			$totalDays = $totalDays + $fetch->price;
			
			if($count <= 500)
				echo '<tr class="rank1"><td><a href="?page=character.details&char='.$acc_fetch->name.'">'.$acc_fetch->name.'</a>('.$fetch->account_id.')</td><td>'.date('d/m/Y',$fetch->date).'</td><td>'.$fetch->item_name.'</td><td>'.$fetch->price.'</td></tr>';
		}
		$totalDays = $totalDays * 0.5;
		echo '<tr class="rank1"><td colspan="4">Renda média: R$ '.$totalDays.'</td></tr>';
	}
	else
		echo '<tr class="rank1"><td>Nenhum evento até o momento.</td></tr>';

	echo '</table><br>';	
}	
?>