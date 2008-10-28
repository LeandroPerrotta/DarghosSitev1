<?
if($engine->accountAccess() >= GROUP_GOD)
{
	echo '<tr><td class=newbar><center><b>:: Buscar Itens ::</td></tr>
	<tr><td class=newtext><center><br>';
	if ($_SERVER['REQUEST_METHOD'] == "POST")
	{
		$itemID = $_POST['item'];
		$count = $_POST['count'];
		
		$item_query = mysql_query("SELECT * FROM `player_items` WHERE `itemtype` = '$itemID' and `count` > '$count'") or die(mysql_error());
		echo '<center><table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="2">';
		echo '<tr><td class=rank2>Player Items</td></tr>';
		echo '<tr class=rank1><td width="25%">Nome</td><td width="25%">Level</td><td width="25%">Player ID</td><td width="25%"Player IP</td><td width="25%">Count</td><tr>';
		while($item_fetch = mysql_fetch_object($item_query))
		{
			$playerId = $item_fetch->player_id;	
			
			$playerName = Player::getPlayerNameById($playerId);
			$playerLevel = Player::getPlayerLevel($playerId);
			$playerIp = Player::getPlayerIp($playerId);
			echo '<tr><td width="25%" class=rank1><a target="_blank" href="?page=character.details&char='.$playerName.'">'.$playerName.'</a></td><td width="25%" class=rank1>'.$playerLevel.'</td><td width="25%" class=rank1>'.$playerId.'</td><td width="25%" class=rank1>'.$playerIp.'</td><td width="25%" class=rank1>'.$item_fetch->count.'</td><tr>';
		}
		echo '</table>';
		
		$itemdp_query = mysql_query("SELECT * FROM `player_depotitems` WHERE `itemtype` = '$itemID' and `count` > '$count' ORDER by player_id DESC") or die(mysql_error());
		echo '<br><br><center><table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="2">';
		echo '<tr><td class=rank2>Player Depot</td></tr>';
		echo '<tr class=rank1><td width="25%">Nome</td><td width="25%">Level</td><td width="25%">Player ID</td><td width="25%"Player IP</td><td width="25%">Count</td><tr>';
		while($itemdp_fetch = mysql_fetch_object($itemdp_query))
		{
			$playerId = $itemdp_fetch->player_id;	
			
			$playerName = Player::getPlayerNameById($playerId);
			$playerLevel = Player::getPlayerLevel($playerId);
			$playerIp = Player::getPlayerIp($playerId);
			echo '<tr><td width="25%" class=rank1><a target="_blank" href="?page=character.details&char='.$playerName.'">'.$playerName.'</a></td><td width="25%" class=rank1>'.$playerLevel.'</td><td width="25%" class=rank1>'.$playerId.'</td><td width="25%" class=rank1>'.$playerIp.'</td><td width="25%" class=rank1>'.$itemdp_fetch->count.'</td><tr>';
		}
		echo '</table>';	

		$itemtile_query = mysql_query("SELECT * FROM `uniterian_tile_items` WHERE `itemtype` = '$itemID' and `count` > '$count'") or die(mysql_error());
		echo '<br><br><center><table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="2">';
		echo '<tr><td class=rank2>Ground Items</td></tr>';
		echo '<tr class=rank1><td width="25%">Tile ID</td><td width="25%">Count</td><tr>';
		while($itemtile_fetch = mysql_fetch_object($itemtile_query))
		{
			echo '<tr><td width="25%" class=rank1>'.$itemtile_fetch->tile_id.'</td><td width="25%" class=rank1>'.$itemtile_fetch->count.'</td><tr>';
		}
		echo '</table>';				
	}
	else
	{
		echo '<form action="?page=admin.checkItems" method="POST">
		<center><table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="4">	
		<tr><td width="25%" class=rank1>Item ID:</td><td width="75%" class=rank1><input class=login type="text" name="item" size="9"> <input class=login type="text" name="count" size="5"></td></tr>
		</table>
		<br><input type="image" value="submit" src="images/submit.gif"/>';
	}
}
?>