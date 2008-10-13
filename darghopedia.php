<?
include "top.php";

if($_GET['subtopic'] == 'main')
{
?>
<tr><td class=newbar><center><b>:: Darghopédia ::</td></tr>
<tr><td class=newtext>
<center>
<p>
<br><center><table border="0" width="95%" CELLSPACING="1" CELLPADDING="2">
Bem vindo a Darghopédia! Esta é uma area dedicada a todo conteudo do jogo, o Darghopédia será uma biblioteca que falará sobre o mundo, as cidades, os lugares, as quests e muitas outras coisas que existem no grande mundo de Darghos.
</table><br>
<center><table border="0" width="95%" CELLSPACING="1" CELLPADDING="4">
<tr class=rank2><td><b>O Mundo de Darghos</a></td></tr>
<tr class=rank3><td>Todo roteiro do jogo se passa sob uma terra, que conta com 3 continentes. O continente principal (conhecido como Mainland) é o maior de todos, conta com diversas criaturas, planicies, montanhas, cavernas alem de suas 2 cidades, Quendor e Thorn.<br>
<table cellspacing="1" cellpadding="4" width="10%" align="left" border="0">
<td><td><a href="images/others/world.png"><img alt="" border=0 src="images/others/world_m.png" /></a></td></tr></table>
<br>O outro continente, conhecido como Premium Earth guarda muitos desafios e misterios, alem da cidade de Aracura, a principal cidade dos jogadores Premium Account. E não podemos esquecer o continente inciial, que contem a vila de RookGuard, um local para os iniciantes que ainda estão aprendendo a jogar. Porem não subestime esta pequena ilha que guarda tremendos misterios! Clique na imagem ao lado para exibir o mundo completo de Darghos e aprenda um pouco sobre este grande mundo de Darghos, um mundo repleto de aventuras, misterios e muita diversão para você e seus amigos.</td></tr>
</table><br>
<table border="0" width="95%" CELLSPACING="1" CELLPADDING="4">
<tr class=rank2><td><b>As Cidades</a></td></tr>
<tr class=rank3><td>O mundo de Darghos conta com 4 cidades: Quendor, Aracura, Thorn, Salazart e Rookguard.<br>
<table cellspacing="1" cellpadding="4" width="10%" align="left" border="0">
<td><td><a target="_blank" href="maps.php?subtopic=quendor" width="300" height="300"><img border="0" src="images/quendor.jpg" alt="Quendor City details." width="240" height="220" /></a></td></tr></table>
<br><b>Quendor</b><br>Quendor é a cidade mais antiga, uma cidade muito popular pela sua tradição, existente desde os primordios (desde antes de Darghos ser Darghos) esta cidade foi modificada muitas vezes ao longo do tempo, hoje sendo quase totalmente diferente da primeira Quendor.</td></tr>
<tr class=rank3><td>
<table cellspacing="1" cellpadding="4" width="10%" align="left" border="0">
<td><td><a target="_blank" href="maps.php?subtopic=thorn" width="300" height="300"><img border="0" src="images/thorn.jpg" alt="Thorn City details." width="240" height="220" /></a></td></tr></table>
<br><b>Thorn</b><br>Thorn é a segunda maior cidade do jogo, disponivel para free accounts e situada em meio a um pantano, proximo de locais importantes como Elf Village e o Undeads Camp é uma boa cidade para iniciantes.</td></tr>
<tr class=rank3><td>
<table cellspacing="1" cellpadding="4" width="10%" align="left" border="0">
<td><td><a target="_blank" href="maps.php?subtopic=aracura" width="300" height="300"><img border="0" src="images/aracura.jpg" alt="Thorn City details." width="240" height="220" /></a></td></tr></table>
<br><b>Aracura</b><br>Aracura é a uma cidade disponivel apenas a jogadores com uma premium account, junto a Quendor são as duas cidades mais antigas do jogo, contem tanto locais perigosos como sua Dragons Lair a até locais para iniciantes como o Buero e suas Dwarf Caves.</td></tr>
<tr class=rank3><td>
<table cellspacing="1" cellpadding="4" width="10%" align="left" border="0">
<td><td><a target="_blank" href="maps.php?subtopic=salazart" width="300" height="300"><img border="0" src="images/salazart.jpg" alt="Thorn City details." width="240" height="220" /></a></td></tr></table>
<br><b>Salazart</b><br>Antigamente no Darghos existiu um pequeno deserto chamado Salazart, com o tempo nosso mapa se desenvolveu e foi necessario remeve-lo para expanção correta do mapa (antigamente ele se situava proximo aonde hoje é a cidade de Thorn). Porem o grande deserto de Salazart está de volta e é tema de nosso ultimo update, o deserto é um previlegio de jogadores premium accounts e conta com novos e perigosos desafios como suas Dragons lairs e as Tumbas alem de criaturas exclusivas como os Sand Dragon e os temiveis Mirage Guardians.</td></tr>
</table><br>
<table border="0" width="95%" CELLSPACING="1" CELLPADDING="4">
<tr class=rank2><td><b>Personangens não-jogadores (non-player character ou NPC's)</a></td></tr>
<tr class=rank3><td>Dentro do jogo existe uma série de personagens com a função de interagir com os jogadores, estes personagens são conhecidos como NPCs.<br>
<table cellspacing="1" cellpadding="4" width="10%" align="left" border="0">
<td><td><img src="images/others/npc.jpg" alt="Green Djinn NPC"/></td></tr></table>
<br>O Darghos possui mais de 80 NPC's unicos espalhados pelo mapa, em cidades, montanhas, cavernas, planicies e cada um deles exerce um papel no roteiro do jogo, alguns são negociantes de armas e equipamentos, outros de artigos magicos, alguns vendendores de comestiveis, e ainda existe NPC's sabios ou exploradores que podem lhe dar uma importante informação sobre uma missão entre outras funções. Para falar com um NPC você deve começar dizendo um "hi", após isso você pode ter uma série de novas palavras que um NPC pode lhe responder como "job","offer","mission" e "addons" entre outros.<br><br>
Para facilitar a vida dos jogadores nos elaboramos uma lista com os todos equipamentos que cada NPC dentro do jogo compra de você, assim você pode fazer uma caçada e guardar os equipamentos mais valiosos obtidos e vender a um NPC e conseguir algum dinheiro, os jogadores mais experientes ainda usam a tecnica de "loot-bag" para coletar a maior quantidade dos items que os monstros "dropam" e assim conseguir mais dinheiro vendendo aos NPCs. Para checar a nossa lista clique <a href="darghopedia.php?subtopic=sell_tableList">aqui</a>.</td></tr>
</table><br>
<?php
}
elseif($_GET['subtopic'] == 'quendor')
{
?>
	<tr><td class=newbar><center><b>:: Darghopédia ::</td></tr>
	<tr><td class=newtext>
	<center>
<table border="0" width="95%" CELLSPACING="1" CELLPADDING="4">
<tr class=rank2><td><b>Quendor City</a></td></tr>
<tr class=rank3><td><img src="images/quendor.jpg"><br>
</table>
<?
}
elseif($_GET['subtopic'] == 'sell_tableList')
{
	echo '<tr><td class=newbar><center><b>:: Selling Table List ::</td></tr>
	<tr><td class=newtext><center>';
	
	echo 'Pagina em manutenção.';
/*	echo '

<br><table border="0" width="95%" CELLSPACING="1" CELLPADDING="4">

	<tr>
		<td colspan="6" class=rank2>Weapons Table List
	</tr>
	
	<tr>
		<td class=rank1><b>Nome</td>
		<td class=rank1><b>Quendor</b><br> NPC Sylvia</td>
		<td class=rank1><b>Thorn</b><br> NPC Mae</td>
		<td class=rank1><b>Aracura</b><br> Thomaz</td>
		<td class=rank1><b>Salazart</b><br> NPC Memech</td>
		<td class=rank1><b>Rookgaard</b><br> NPC Berner</td>
	</tr>	';	
	
	echo '
	<tr>
		<td colspan="6" class=rank1><center>Swords
	</tr>	';	
	
	$swords_query = mysql_query("SELECT * FROM darghopedia.loot_npcs WHERE item_type = 1 AND (quendor_sell != '-' OR thorn_sell != '-' OR aracura_sell != '-' OR salazart_sell != '-' OR rook_sell != '-')");
	$clubs_query = mysql_query("SELECT * FROM darghopedia.loot_npcs WHERE item_type = 2 AND (quendor_sell != '-' OR thorn_sell != '-' OR aracura_sell != '-' OR salazart_sell != '-' OR rook_sell != '-')");
	$axes_query = mysql_query("SELECT * FROM darghopedia.loot_npcs WHERE item_type = 3 AND (quendor_sell != '-' OR thorn_sell != '-' OR aracura_sell != '-' OR salazart_sell != '-' OR rook_sell != '-')");
	
	while($swords_fetch = mysql_fetch_object($swords_query))
	{
		echo'
		<tr>';
			echo '<td class=rank3>'.$swords_fetch->item_name.'</td>';	
			
			if($swords_fetch->quendor_sell != '-')
				echo '<td class=rank3>'.$swords_fetch->quendor_sell.' gps</td>';	
			else
				echo '<td class=rank3>n/a</td>';
				
			if($swords_fetch->thorn_sell != '-')
				echo '<td class=rank3>'.$swords_fetch->thorn_sell.' gps</td>';	
			else
				echo '<td class=rank3>n/a</td>';
			
			if($swords_fetch->aracura_sell != '-')
				echo '<td class=rank3>'.$swords_fetch->aracura_sell.' gps</td>';	
			else
				echo '<td class=rank3>n/a</td>';	

			if($swords_fetch->salazart_sell != '-')
				echo '<td class=rank3>'.$swords_fetch->salazart_sell.' gps</td>';	
			else
				echo '<td class=rank3>n/a</td>';	

			if($swords_fetch->rook_sell != '-')
				echo '<td class=rank3>'.$swords_fetch->rook_sell.' gps</td>';	
			else
				echo '<td class=rank3>n/a</td>';					
				
		echo '</tr>';		
	}

	echo '
	<tr>
		<td colspan="6" class=rank1><center>Clubs
	</tr>	';	
	
	while($clubs_fetch = mysql_fetch_object($clubs_query))
	{
		echo'
		<tr>';
			echo '<td class=rank3>'.$clubs_fetch->item_name.'</td>';
			
			if($clubs_fetch->quendor_sell != '-')
				echo '<td class=rank3>'.$clubs_fetch->quendor_sell.' gps</td>';
			else
				echo '<td class=rank3>n/a</td>';
			
			if($clubs_fetch->thorn_sell != '-')		
				echo '<td class=rank3>'.$clubs_fetch->thorn_sell.' gps</td>';
			else
				echo '<td class=rank3>n/a</td>';
				
			if($clubs_fetch->aracura_sell != '-')	
				echo '<td class=rank3>'.$clubs_fetch->aracura_sell.' gps</td>';
			else
				echo '<td class=rank3>n/a</td>';
				
			if($clubs_fetch->salazart_sell != '-')	
				echo '<td class=rank3>'.$clubs_fetch->salazart_sell.' gps</td>';
			else
				echo '<td class=rank3>n/a</td>';	
				
			if($clubs_fetch->rook_sell != '-')	
				echo '<td class=rank3>'.$clubs_fetch->rook_sell.' gps</td>';
			else
				echo '<td class=rank3>n/a</td>';					
				
		echo '</tr>';		
	}

	echo '
	<tr>
		<td colspan="6" class=rank1><center>Axes
	</tr>	';	
	
	while($axes_fetch = mysql_fetch_object($axes_query))
	{
		echo'
		<tr>';
			echo '<td class=rank3>'.$axes_fetch->item_name.'</td>';
			
			if($axes_fetch->quendor_sell != '-')
				echo '<td class=rank3>'.$axes_fetch->quendor_sell.' gps</td>';
			else
				echo '<td class=rank3>n/a</td>';			
			
			if($axes_fetch->thorn_sell != '-')	
				echo '<td class=rank3>'.$axes_fetch->thorn_sell.' gps</td>';
			else
				echo '<td class=rank3>n/a</td>';
				
			if($axes_fetch->aracura_sell != '-')	
				echo '<td class=rank3>'.$axes_fetch->aracura_sell.' gps</td>';
			else
				echo '<td class=rank3>n/a</td>';
				
			if($axes_fetch->salazart_sell != '-')	
				echo '<td class=rank3>'.$axes_fetch->salazart_sell.' gps</td>';
			else
				echo '<td class=rank3>n/a</td>';
				
			if($axes_fetch->rook_sell != '-')	
				echo '<td class=rank3>'.$axes_fetch->rook_sell.' gps</td>';
			else
				echo '<td class=rank3>n/a</td>';					
				
		echo '</tr>';		
	}	
	echo '</table><br>';
	
	echo '

<br><table border="0" width="95%" CELLSPACING="1" CELLPADDING="4">

	<tr>
		<td colspan="6" class=rank2>Equipments Table List
	</tr>
	
	<tr>
		<td class=rank1><b>Nome</td>
		<td class=rank1><b>Quendor</b><br> NPC Brown</td>
		<td class=rank1><b>Thorn</b><br> NPC Finner</td>
		<td class=rank1><b>Aracura</b><br> NPC Richard</td>
		<td class=rank1><b>Salazart</b><br> NPC Memech</td>
		<td class=rank1><b>Rookgaard</b><br> NPC Berner</td>
	</tr>	';	
	
	echo '
	<tr>
		<td colspan="6" class=rank1><center>Armors
	</tr>	';		
	
	$armors_query = mysql_query("SELECT * FROM darghopedia.loot_npcs WHERE item_type = 4 AND (quendor_sell != '-' OR thorn_sell != '-' OR aracura_sell != '-' OR salazart_sell != '-' OR rook_sell != '-')");
	$shields_query = mysql_query("SELECT * FROM darghopedia.loot_npcs WHERE item_type = 5 AND (quendor_sell != '-' OR thorn_sell != '-' OR aracura_sell != '-' OR salazart_sell != '-' OR rook_sell != '-')");
	$legs_query = mysql_query("SELECT * FROM darghopedia.loot_npcs WHERE item_type = 6 AND (quendor_sell != '-' OR thorn_sell != '-' OR aracura_sell != '-' OR salazart_sell != '-' OR rook_sell != '-')");
	$helmets_query = mysql_query("SELECT * FROM darghopedia.loot_npcs WHERE item_type = 7 AND (quendor_sell != '-' OR thorn_sell != '-' OR aracura_sell != '-' OR salazart_sell != '-' OR rook_sell != '-')");
	$boots_query = mysql_query("SELECT * FROM darghopedia.loot_npcs WHERE item_type = 8 AND (quendor_sell != '-' OR thorn_sell != '-' OR aracura_sell != '-' OR salazart_sell != '-' OR rook_sell != '-')");
	
	while($armors_fetch = mysql_fetch_object($armors_query))
	{
		echo'
		<tr>';
			echo '<td class=rank3>'.$armors_fetch->item_name.'</td>';
			
			if($armors_fetch->quendor_sell != '-')
				echo '<td class=rank3>'.$armors_fetch->quendor_sell.' gps</td>';
			else
				echo '<td class=rank3>n/a</td>';			
			
			if($armors_fetch->thorn_sell != '-')	
				echo '<td class=rank3>'.$armors_fetch->thorn_sell.' gps</td>';
			else
				echo '<td class=rank3>n/a</td>';
				
			if($armors_fetch->aracura_sell != '-')	
				echo '<td class=rank3>'.$armors_fetch->aracura_sell.' gps</td>';
			else
				echo '<td class=rank3>n/a</td>';
				
			if($armors_fetch->salazart_sell != '-')	
				echo '<td class=rank3>'.$armors_fetch->salazart_sell.' gps</td>';
			else
				echo '<td class=rank3>n/a</td>';				
				
			if($armors_fetch->rook_sell != '-')	
				echo '<td class=rank3>'.$armors_fetch->rook_sell.' gps</td>';
			else
				echo '<td class=rank3>n/a</td>';					
				
		echo '</tr>';		
	}	
	
	echo '
	<tr>
		<td colspan="6" class=rank1><center>Shields
	</tr>	';		
	
	while($shields_fetch = mysql_fetch_object($shields_query))
	{
		echo'
		<tr>';
			echo '<td class=rank3>'.$shields_fetch->item_name.'</td>';
			
			if($shields_fetch->quendor_sell != '-')
				echo '<td class=rank3>'.$shields_fetch->quendor_sell.' gps</td>';
			else
				echo '<td class=rank3>n/a</td>';			
			
			if($shields_fetch->thorn_sell != '-')	
				echo '<td class=rank3>'.$shields_fetch->thorn_sell.' gps</td>';
			else
				echo '<td class=rank3>n/a</td>';
				
			if($shields_fetch->aracura_sell != '-')	
				echo '<td class=rank3>'.$shields_fetch->aracura_sell.' gps</td>';
			else
				echo '<td class=rank3>n/a</td>';
				
			if($shields_fetch->salazart_sell != '-')	
				echo '<td class=rank3>'.$shields_fetch->salazart_sell.' gps</td>';
			else
				echo '<td class=rank3>n/a</td>';		
				
			if($shields_fetch->rook_sell != '-')	
				echo '<td class=rank3>'.$shields_fetch->rook_sell.' gps</td>';
			else
				echo '<td class=rank3>n/a</td>';						
				
		echo '</tr>';		
	}		
	
	echo '
	<tr>
		<td colspan="6" class=rank1><center>Legs
	</tr>	';		
	
	while($legs_fetch = mysql_fetch_object($legs_query))
	{
		echo'
		<tr>';
			echo '<td class=rank3>'.$legs_fetch->item_name.'</td>';
			
			if($legs_fetch->quendor_sell != '-')
				echo '<td class=rank3>'.$legs_fetch->quendor_sell.' gps</td>';
			else
				echo '<td class=rank3>n/a</td>';			
			
			if($legs_fetch->thorn_sell != '-')	
				echo '<td class=rank3>'.$legs_fetch->thorn_sell.' gps</td>';
			else
				echo '<td class=rank3>n/a</td>';
				
			if($legs_fetch->aracura_sell != '-')	
				echo '<td class=rank3>'.$legs_fetch->aracura_sell.' gps</td>';
			else
				echo '<td class=rank3>n/a</td>';
				
			if($legs_fetch->salazart_sell != '-')	
				echo '<td class=rank3>'.$legs_fetch->salazart_sell.' gps</td>';
			else
				echo '<td class=rank3>n/a</td>';	
				
			if($legs_fetch->rook_sell != '-')	
				echo '<td class=rank3>'.$legs_fetch->rook_sell.' gps</td>';
			else
				echo '<td class=rank3>n/a</td>';					
				
		echo '</tr>';	
	}
	
	echo '
	<tr>
		<td colspan="6" class=rank1><center>Helmets
	</tr>	';		
	
	while($helmets_fetch = mysql_fetch_object($helmets_query))
	{
		echo'
		<tr>';
			echo '<td class=rank3>'.$helmets_fetch->item_name.'</td>';
			
			if($helmets_fetch->quendor_sell != '-')
				echo '<td class=rank3>'.$helmets_fetch->quendor_sell.' gps</td>';
			else
				echo '<td class=rank3>n/a</td>';			
			
			if($helmets_fetch->thorn_sell != '-')	
				echo '<td class=rank3>'.$helmets_fetch->thorn_sell.' gps</td>';
			else
				echo '<td class=rank3>n/a</td>';
				
			if($helmets_fetch->aracura_sell != '-')	
				echo '<td class=rank3>'.$helmets_fetch->aracura_sell.' gps</td>';
			else
				echo '<td class=rank3>n/a</td>';
				
			if($helmets_fetch->salazart_sell != '-')	
				echo '<td class=rank3>'.$helmets_fetch->salazart_sell.' gps</td>';
			else
				echo '<td class=rank3>n/a</td>';		

			if($helmets_fetch->rook_sell != '-')	
				echo '<td class=rank3>'.$helmets_fetch->rook_sell.' gps</td>';
			else
				echo '<td class=rank3>n/a</td>';					
				
		echo '</tr>';			
	}		

	echo '
	<tr>
		<td colspan="6" class=rank1><center>Boots
	</tr>	';		
	
	while($boots_fetch = mysql_fetch_object($boots_query))
	{
		echo'
		<tr>';
			echo '<td class=rank3>'.$boots_fetch->item_name.'</td>';
			
			if($boots_fetch->quendor_sell != '-')
				echo '<td class=rank3>'.$boots_fetch->quendor_sell.' gps</td>';
			else
				echo '<td class=rank3>n/a</td>';			
			
			if($boots_fetch->thorn_sell != '-')	
				echo '<td class=rank3>'.$boots_fetch->thorn_sell.' gps</td>';
			else
				echo '<td class=rank3>n/a</td>';
				
			if($boots_fetch->aracura_sell != '-')	
				echo '<td class=rank3>'.$boots_fetch->aracura_sell.' gps</td>';
			else
				echo '<td class=rank3>n/a</td>';
				
			if($boots_fetch->salazart_sell != '-')	
				echo '<td class=rank3>'.$boots_fetch->salazart_sell.' gps</td>';
			else
				echo '<td class=rank3>n/a</td>';			

		if($boots_fetch->rook_sell != '-')	
				echo '<td class=rank3>'.$boots_fetch->rook_sell.' gps</td>';
			else
				echo '<td class=rank3>n/a</td>';						
				
		echo '</tr>';			
	}	
	
	echo '</table><br>';
	
	echo '

<br><table border="0" width="95%" CELLSPACING="1" CELLPADDING="4">

	<tr>
		<td colspan="6" class=rank2>Djinns Table List
	</tr>
	
	<tr>
		<td class=rank1><b>Nome</td>
		<td class=rank1><b>Blue Djinn</b><br> NPC Lo\'Snaif</td>
		<td class=rank1><b>Green Djinn</b><br> NPC Abul</td>
	</tr>	';		
	
	$djinn_query = mysql_query("SELECT * FROM darghopedia.loot_npcs WHERE (djinn1_sell != '-' OR djinn2_sell != '-') ORDER by item_name ASC");
	
	while($djinn_fetch = mysql_fetch_object($djinn_query))
	{
		echo'
		<tr>';
			echo '<td class=rank3>'.$djinn_fetch->item_name.'</td>';
			
			if($djinn_fetch->djinn1_sell != '-')
				echo '<td class=rank3>'.$djinn_fetch->djinn1_sell.' gps</td>';
			else
				echo '<td class=rank3>n/a</td>';			
			
			if($djinn_fetch->djinn2_sell != '-')	
				echo '<td class=rank3>'.$djinn_fetch->djinn2_sell.' gps</td>';
			else
				echo '<td class=rank3>n/a</td>';					
				
		echo '</tr>';			
	}	
	
	echo '</table><br>';*/	
	
}
elseif($_GET['subtopic'] == 'npcs_equipments')
{
	echo '
	';
}
include "footer.php";
?>