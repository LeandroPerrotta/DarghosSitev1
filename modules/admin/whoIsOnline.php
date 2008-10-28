<?
if($engine->accountAccess() >= GROUP_COMMUNITYMANAGER)
{
	echo '<tr><td class=newbar><center><b>:: Quem esta Online? ::</td></tr>
	<tr><td class=newtext><br>';	

	switch($_GET['order'])
	{
		case "created.asc":
			$criterio = "created";
			$order = "ASC";
		break;	
		
		case "created.desc":
			$criterio = "created";
			$order = "DESC";
		break;				
		
		default:
			$criterio = "name";
			$order = "ASC";
		break;			
	}

	if($criterio == "created")
	{
		if($order == "ASC")
			$showInLink['order'] = "order=created.desc";
		else
			$showInLink['order'] = "order=created.asc";
	}	
	else
		$showInLink['order'] = "order=created.asc";

	$query2 = mysql_query("SELECT account_id, level, vocation, town_id FROM `players` WHERE online = '1' ORDER by name ASC") or die(mysql_error());		

	$totalOnline = mysql_num_rows($query2); 

	$lvlArray = array();	
		
	while($premiumTenerian = mysql_fetch_object($query2))
	{
		$onlineID++;
		
		$lvlArray[$onlineID] = $premiumTenerian->level;	
		if(Account::isPremium($premiumTenerian->account_id))
			$tenePrem++;
			
		if($premiumTenerian->level < 101)
			$lowlvl++;
		else
			$highlvl++;
			
		if($premiumTenerian->vocation == 0)	
			$no_voc++;
		elseif($premiumTenerian->vocation == 1 OR $premiumTenerian->vocation == 5)
			$sorcerer++;
		elseif($premiumTenerian->vocation == 2 OR $premiumTenerian->vocation == 6)
			$druid++;		
		elseif($premiumTenerian->vocation == 3 OR $premiumTenerian->vocation == 7)
			$paladin++;		
		elseif($premiumTenerian->vocation == 4 OR $premiumTenerian->vocation == 8)
			$knight++;	

		if($premiumTenerian->town_id == 1)	
			$quendor++;
		elseif($premiumTenerian->town_id == 2)
			$aracura++;
		elseif($premiumTenerian->town_id == 3)
			$rookgaard++;		
		elseif($premiumTenerian->town_id == 4)
			$thorn++;		
		elseif($premiumTenerian->town_id == 5)
			$salazart++;			
		elseif($premiumTenerian->town_id == 7)
			$northrend++;					
	}		

	$onlineID = null;

	while($onlineID != $totalOnline)
	{
		$onlineID++;
		$totallvl += $lvlArray[$onlineID];
	}

	$lvlmedia = (int)($totallvl / $totalOnline);

	echo '<center>
	<table width="95%" BORDER="0" CELLSPACING="1" CELLPADDING="4">
		<tr class=rank2>
			<td>Online Statistics</td>
		</tr>	
		<tr class=rank1>
			<td colspan=3>Premiums: '.$tenePrem.'</td>
		</td>				
		<tr class=rank1>
			<td colspan=3>Low lvls (100-): '.$lowlvl.'</td>
		</td>	
		<tr class=rank1>
			<td colspan=3>High lvls (100+): '.$highlvl.'</td>
		</td>				
		<tr class=rank1>
			<td colspan=3>Lvl médio: '.$lvlmedia.'</td>
		</td>			
		<tr class=rank1>
			<td colspan=3>Vocações: Sem vocação: '.$no_voc.' - Sorcerer: '.$sorcerer.' - Druid: '.$druid.' - Paladin: '.$paladin.' - Knight: '.$knight.'</td>
		</td>		
		<tr class=rank1>
			<td colspan=3>Cidades: Quendor: '.$quendor.' - Thorn: '.$thorn.' - Aracura: '.$aracura.' - Salazart: '.$salazart.' - Northrend: '.$northrend.' - Rookgaard: '.$rookgaard.'</td>
		</td>				
		<tr class=rank1>
			<td colspan=3>Total Online: '.$totalOnline.'</td>
		</td>	
	</table>

	<br>	

	<table width="95%" BORDER="0" CELLSPACING="1" CELLPADDING="4">
		<tr class=rank2>
			<td colspan=5>Players Online</td>
		</tr>	
		<tr class=rank1>
			<td width=6%></td>
			<td width=50%><b>Nome</td>
			<td><b>Level</td>
			<td><b>Vocação</td>
			<td><b><a href="?page=admin.whoisonline&'.$showInLink['order'].'">Criado</a></td>
		</tr>';
		
	$number2 = 0;

	$whoisQuery = mysql_query("SELECT vocation, group_id, name, account_id, level, created FROM `players` WHERE online = '1' ORDER by $criterio $order") or die(mysql_error());		
	while($fetch2 = mysql_fetch_object($whoisQuery))
	{
		$number2++;
		$vocation = Tolls::getVocation($fetch2->vocation);
		
		if($fetch2->group_id <= 1)
			$class = "rank3";
		else
			$class = "rank1";

		$name = $fetch2->name;
		
		if(Account::isPremium($fetch2->account_id))
			$name.= '*';
			
		$created = date("j/m/Y", ($fetch2->created));
		
		echo '<tr class='.$class.'>
				<td>'.$number2.'. </td>
				<td><a href="?page=character.details&char='.$fetch2->name.'">'.$name.'</a></td>
				<td>'.$fetch2->level.'</td>
				<td>'.$vocation.'</td>
				<td>'.$created.'</td>
			</tr>';			
	}
	echo '</table><br>';
}	
?>