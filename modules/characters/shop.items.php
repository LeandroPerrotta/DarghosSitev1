<?
if($engine->loggedIn())
{
	if(Account::isPremium($account) AND SHOW_ITEMSHOP == 1)
	{	
		echo '<tr><td class=newbar><center><b>:: Item Shop List ::</td></tr>
		<tr><td class=newtext>';
		
		if ($_SERVER['REQUEST_METHOD'] == "POST")
		{
			$item_array = Shop::getItemShop($_POST['item_shop']);
			$item_price = $item_array['price'];	
			$item_name = $item_array['name'];
			
			if(filtreString(md5($_POST['pass']),1) == 0)
			{
				$condition = 'Error';
				$conteudo = 'Character does not exist or uses syntaxes reserved.';		
				$error++;
			}			
			elseif(!Account::passCheck($account,md5($_POST['pass'])))
			{
				$condition = 'Error';
				$conteudo = 'This password is not correct.';
				$error++;
			}
			elseif(Account::getType($account) > 2 and Account::getType($account) < 6)
			{
				$condition = 'Error';
				$conteudo = 'Illegal account type.';
				$error++;
			}				
			elseif($_POST['item_shop'] == "" or $_POST['item_shop'] == null)
			{
				$condition = 'Select!';
				$conteudo = 'Please, select a one item.';			
				$error++;
			}					
			elseif(Player::isOnline(Player::getPlayerNameById($_POST['player_id'])) == 1)
			{
				$condition = 'Character as loged in!';
				$conteudo = 'Please, log out you character to use item shop.';			
				$error++;
			}		
			elseif(Account::getPremDays($account) < $item_price)
			{
				$condition = 'Few days of Premium.';
				$conteudo = 'To receive a marked item you need '.$item_price.' days of premium account.';
				$error++;
			}
			elseif(!Shop::giveItemToDepot($_POST['item_shop'],$_POST['player_id'],$_POST['depot_id'],$account))
			{
				$condition = 'Depot não ativo.';
				$conteudo = 'O depot desta cidade não está ativo, para ativa-lo apenas entre em seu personagem e deixe ao menos um item neste depot.';
				$error++;
			}	
			else
			{
				Account::removePremium($item_price,$account);

				$condition = 'Compra concluida!';
				$conteudo = 'O item '.$item_name.' foi enviado ao depot da cidade de '.Tolls::getTown($_POST['depot_id']).' com sucesso!';			
			}			
			
			echo '<br><center><table width="95%" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
			echo '<tr><td class=rank2>'.$condition.'</td></tr>';
			echo '<tr><td class=rank1>'.$conteudo.'</td></tr>';
			echo '</table>';						
		}
		
		echo '<br><center><table border="0" width="95%" CELLSPACING="1" CELLPADDING="2">';
		echo 'Seja bem vindo ao Darghos Item Shop List, aqui você pode ver todos items disponiveis e sua descrição e preço. Marque todos itens que desejar, lembre-se que o valor sera somado de cada item, mais abaixo entre com a senha de sua conta, e selecione o personagem e o depot da cidade na qual os itens devem ser enviados e então clique em "Confirm" para concluir sua compra.';
		echo '</table>';

		echo '<form method="post" action="?page=character.itemShop">';
		echo '<br><center><table width="95%" border="0" cellpadding="4" cellspacing="1">';
		echo '<tr class="rank2"><td colspan="4"><b>Equipments</td></tr>';
		echo '<tr class="rank1"><td width="3%"></td><td width="20%"><b>Item</td><td width="25%"><b>Descrição</td><td width="10%"><b>premDays</td></tr>';
		
		echo '<tr class="rank3"><td><img src="images/items/haunted_blade.gif" border="0"></td><td><input type="radio" name="item_shop" value="1"> Haunted Blade</td><td>Atk: 40, Def: 12, Lvl: 30</td><td>5</td></tr>';
		echo '<tr class="rank3"><td><img src="images/items/orcish_maul.gif" border="0"></td><td><input type="radio" name="item_shop" value="2"> Orcish Maul</td><td>Atk: 42, Def: 18, Lvl: 35</td><td>5</td></tr>';
		echo '<tr class="rank3"><td><img src="images/items/headchopper.gif" border="0"></td><td><input type="radio" name="item_shop" value="3"> Headchopper</td><td>Atk: 42, Def: 20, Lvl: 35</td><td>5</td></tr>';	
		echo '<tr class="rank3"><td><img src="images/items/giant_sword.gif" border="0"></td><td><input type="radio" name="item_shop" value="4"> Giant Sword</td><td>Atk: 46, Def: 22, Lvl: 55</td><td>7</td></tr>';
		echo '<tr class="rank3"><td><img src="images/items/dragon_lance.gif" border="0"></td><td><input type="radio" name="item_shop" value="5"> Dragon Lance</td><td>Atk: 47, Def: 16, Lvl: 60</td><td>7</td></tr>';	
		
		echo '<tr class="rank3"><td><img src="images/items/blue_robe.gif" border="0"></td><td><input type="radio" name="item_shop" value="20"> Blue Robe</td><td>Arm: 11</td><td>4</td></tr>';
		echo '<tr class="rank3"><td><img src="images/items/golden_armor.gif" border="0"></td><td><input type="radio" name="item_shop" value="6"> Golden Armor</td><td>Arm: 14</td><td>8</td></tr>';
		echo '<tr class="rank3"><td><img src="images/items/dragon_scale_mail.gif" border="0"></td><td><input type="radio" name="item_shop" value="7"> Dragon Scale Mail</td><td>Arm: 15</td><td>15</td></tr>';	
		echo '<tr class="rank3"><td><img src="images/items/magic_plate_armor.gif" border="0"></td><td><input type="radio" name="item_shop" value="8"> Magic Plate Armor</td><td>Arm: 17</td><td>25</td></tr>';
		
		echo '<tr class="rank3"><td><img src="images/items/vampire_shield.gif" border="0"></td><td><input type="radio" name="item_shop" value="9"> Vampire Shield</td><td>Def: 34</td><td>5</td></tr>';
		echo '<tr class="rank3"><td><img src="images/items/demon_shield.gif" border="0"></td><td><input type="radio" name="item_shop" value="10"> Demon Shield</td><td>Def: 35</td><td>12</td></tr>';	
		echo '<tr class="rank3"><td><img src="images/items/mastermind_shield.gif" border="0"></td><td><input type="radio" name="item_shop" value="11"> Mastermind Shield</td><td>Def: 37</td><td>18</td></tr>';	
		
		echo '<tr class="rank3"><td><img src="images/items/crown_legs.gif" border="0"></td><td><input type="radio" name="crown_legs" value="12"> Crown Legs</td><td>Arm: 8</td><td>5</td></tr>';
		echo '<tr class="rank3"><td><img src="images/items/golden_legs.gif" border="0"></td><td><input type="radio" name="golden_legs" value="13"> Golden Legs</td><td>Arm: 9</td><td>15</td></tr>';	
		
		echo '<tr class="rank3"><td><img src="images/items/boots_of_haste.gif" border="0"></td><td><input type="radio" name="item_shop" value="14"> Boots of Haste</td><td>Faz andar mais rápidamente</td><td>10</td></tr>';		
		echo '<tr class="rank3"><td><img src="images/items/royal_helmet.gif" border="0"></td><td><input type="radio" name="item_shop" value="15"> Royal Helmet</td><td>Arm: 9</td><td>10</td></tr>';
		
		echo '<tr class="rank3"><td><img src="images/items/ring_of_healing.gif" border="0"></td><td><input type="radio" name="item_shop" value="16"> BP Ring of Healing</td><td>Recupera a Mana e Life mais rápidamente</td><td>10</td></tr>';
		echo '<tr class="rank3"><td><img src="images/items/stone_skin_amulet.gif" border="0"></td><td><input type="radio" name="item_shop" value="17"> BP Stone Skin Amulet</td><td>Absorve 80% dos danos recebidos</td><td>20</td></tr>';
		echo '<tr class="rank3"><td><img src="images/items/amulet_of_loss.gif" border="0"></td><td><input type="radio" name="item_shop" value="18"> Amulet of Loss</td><td>Não perca nenhum item ao morrer</td><td>10</td></tr>';
		
		echo '<tr class="rank3"><td><img src="images/items/infernal_bolt.gif" border="0"></td><td><input type="radio" name="item_shop" value="19"> 100 Infernal Bolt</td><td>Uma das mais poderosas munições do jogo</td><td>2</td></tr>';
		echo '<tr class="rank3"><td><img src="images/items/infernal_bolt.gif" border="0"></td><td><input type="radio" name="item_shop" value="21"> BP Infernal Bolts</td><td>BP de uma das mais poderosas munições do jogo</td><td>20</td></tr>';
		echo '<tr class="rank3"><td><img src="images/items/assassin_star.gif" border="0"></td><td><input type="radio" name="item_shop" value="38"> 100 Assassin Star\'s</td><td>Munição com dano extremamente alto</td><td>5</td></tr>';			
		
		echo '<tr class="rank3"><td><img src="images/items/platinum_coin.gif" border="0"></td><td><input type="radio" name="item_shop" value="22"> 5,000 gps</td><td>Compre o que quiser</td><td>1</td></tr>';
		echo '<tr class="rank3"><td><img src="images/items/crystal_coin.gif" border="0"></td><td><input type="radio" name="item_shop" value="23"> 50,000 gps</td><td>Compre o que quiser e um pouco mais</td><td>10</td></tr>';
		echo '<tr class="rank3"><td><img src="images/items/crystal_coin.gif" border="0"></td><td><input type="radio" name="item_shop" value="24"> 100,000 gps</td><td>Compre o que quiser e muito mais</td><td>15</td></tr>';

		echo '<tr class="rank3"><td><img src="images/items/sudden_death.gif" border="0"></td><td><input type="radio" name="item_shop" value="25"> BP 100x sudden death rune</td><td>Runa mais poderosa do game</td><td>20</td></tr>';
		echo '<tr class="rank3"><td><img src="images/items/ultimate_healing_rune.gif" border="0"></td><td><input type="radio" name="item_shop" value="26"> BP 100x ultimate healing rune</td><td>Runa com maior poder de regeneração</td><td>15</td></tr>';
		echo '<tr class="rank3"><td><img src="images/items/explosion.gif" border="0"></td><td><input type="radio" name="item_shop" value="27"> BP 100x explosion rune</td><td>Runa com um grande campo de dano</td><td>12</td></tr>';			
		//echo '<tr class="rank3"><td><img src="images/items/lottery_ticket.gif" border="0"></td><td><input type="radio" name="item_shop" value="28"> Teleport Scroll</td><td>Seja teleportado ao Templo a hora em que quiser. (1 carga)</td><td>3</td></tr>';	

		echo '</table>';

		echo '<br><center><table width="95%" border="0" cellpadding="4" cellspacing="1">';
		echo '<tr class="rank2"><td colspan="4"><b>Items nescessarios para addons</td></tr>';
		echo '<tr class="rank1"><td width="3%"></td><td width="20%"><b>Item</td><td width="25%"><b>Descrição</td><td width="10%"><b>premDays</td></tr>';
		
		echo '<tr class="rank3"><td><img src="images/items/iron_ore.gif" border="0"></td><td><input type="radio" name="item_shop" value="29"> 5x Iron Ore\'s</td><td>Item muito raro, necessario para addon quest.</td><td>5</td></tr>';	
		echo '<tr class="rank3"><td><img src="images/items/ape_fur.gif" border="0"></td><td><input type="radio" name="item_shop" value="30"> 5x Ape Fur\'s</td><td>Item muito raro, necessario para addon quest.</td><td>7</td></tr>';	
		echo '<tr class="rank3"><td><img src="images/items/vampire_dust.gif" border="0"></td><td><input type="radio" name="item_shop" value="31"> 5x Vampires Dust\'s</td><td>Item muito raro, necessario para addon quest.</td><td>10</td></tr>';	
		echo '<tr class="rank3"><td><img src="images/items/demon_dust.gif" border="0"></td><td><input type="radio" name="item_shop" value="32"> 5x Demons Dust\'s</td><td>Item muito raro, necessario para addon quest.</td><td>10</td></tr>';	
		echo '<tr class="rank3"><td><img src="images/items/spool_of_yarn.gif" border="0"></td><td><input type="radio" name="item_shop" value="33"> 1x Spool of Yarn</td><td>Item muito raro, necessario para addon quest.</td><td>10</td></tr>';	
		echo '<tr class="rank3"><td><img src="images/items/piece_of_royal_steel.gif" border="0"></td><td><input type="radio" name="item_shop" value="39"> 1x Royal Steel</td><td>Item muito raro, necessario para addon quest.</td><td>10</td></tr>';	
		echo '<tr class="rank3"><td><img src="images/items/giant_spider_silk.gif" border="0"></td><td><input type="radio" name="item_shop" value="34"> 10x Giant Spider Silk</td><td>Item muito raro, necessario para addon quest.</td><td>5</td></tr>';	
		echo '<tr class="rank3"><td><img src="images/items/minotaur_leather.gif" border="0"></td><td><input type="radio" name="item_shop" value="35"> 100x Minotaur Leather\'s</td><td>Item muito raro, necessario para addon quest.</td><td>5</td></tr>';	
		echo '<tr class="rank3"><td><img src="images/items/chicken_feather.gif" border="0"></td><td><input type="radio" name="item_shop" value="36"> 100x Chicken Feather\'s</td><td>Item muito raro, necessario para addon quest.</td><td>12</td></tr>';	
		echo '<tr class="rank3"><td><img src="images/items/honeycomb.gif" border="0"></td><td><input type="radio" name="item_shop" value="37"> 50x Honeycombs</td><td>Item muito raro, necessario para addon quest.</td><td>3</td></tr>';	
		echo '<tr class="rank3"><td><img src="images/items/Blue_Piece.gif" border="0"></td><td><input type="radio" name="item_shop" value="45"> 50x Blue Piece of Cloth</td><td>Item muito raro, necessario para addon quest.</td><td>15</td></tr>';
		echo '<tr class="rank3"><td><img src="images/items/Green_Piece.gif" border="0"></td><td><input type="radio" name="item_shop" value="44"> 50x Green Piece of Cloth</td><td>Item muito raro, necessario para addon quest.</td><td>15</td></tr>';			
		echo '<tr class="rank3"><td><img src="images/items/White_Piece.gif" border="0"></td><td><input type="radio" name="item_shop" value="40"> 50x White Piece of Cloth</td><td>Item muito raro, necessario para addon quest.</td><td>15</td></tr>';			
		echo '<tr class="rank3"><td><img src="images/items/Yellow_Piece.gif" border="0"></td><td><input type="radio" name="item_shop" value="41"> 50x Yellow Piece of Cloth</td><td>Item muito raro, necessario para addon quest.</td><td>15</td></tr>';
		echo '<tr class="rank3"><td><img src="images/items/Red_Piece.gif" border="0"></td><td><input type="radio" name="item_shop" value="42"> 50x Red Piece of Cloth</td><td>Item muito raro, necessario para addon quest.</td><td>15</td></tr>';			
		echo '<tr class="rank3"><td><img src="images/items/Brown_Piece.gif" border="0"></td><td><input type="radio" name="item_shop" value="43"> 50x Brown Piece of Cloth</td><td>Item muito raro, necessario para addon quest.</td><td>15</td></tr>';
		echo '<tr class="rank3"><td><img src="images/items/Hell_Steel.gif" border="0"></td><td><input type="radio" name="item_shop" value="46"> 1 Piece of Hell Steel</td><td>Item muito raro, necessario para addon quest.</td><td>30</td></tr>';
		echo '<tr class="rank3"><td><img src="images/items/Mandrake.gif" border="0"></td><td><input type="radio" name="item_shop" value="47"> 1 Mandrake</td><td>Item muito raro, necessario para addon quest.</td><td>40</td></tr>';
		echo '<tr class="rank3"><td><img src="images/items/Huge_Chunk.gif" border="0"></td><td><input type="radio" name="item_shop" value="48"> 1 Huge Chunk of Crude Iron</td><td>Item muito raro, necessario para addon quest.</td><td>30</td></tr>';
		echo '<tr class="rank3"><td><img src="images/items/Piece_of_Draconian.gif" border="0"></td><td><input type="radio" name="item_shop" value="49"> 1 Piece of Draconian Steel</td><td>Item muito raro, necessario para addon quest.</td><td>30</td></tr>';
		echo '<tr class="rank3"><td><img src="images/items/Voodoo1.gif" border="0"></td><td><input type="radio" name="item_shop" value="51"> 1 Dworc Voodoo Doll</td><td>Item muito raro, necessario para addon quest.</td><td>5</td></tr>';
		echo '<tr class="rank3"><td><img src="images/items/Shard.gif" border="0"></td><td><input type="radio" name="item_shop" value="50"> 1 Shard</td><td>Item muito raro, necessario para addon quest.</td><td>3</td></tr>';
		echo '<tr class="rank3"><td><img src="images/items/Banana_Staff.gif" border="0"></td><td><input type="radio" name="item_shop" value="52"> 1 Banana Staff</td><td>Item muito raro, necessario para addon quest.</td><td>5</td></tr>';
		echo '<tr class="rank3"><td><img src="images/items/Tribal_Mask.gif" border="0"></td><td><input type="radio" name="item_shop" value="53"> 1 Tribal Mask</td><td>Item muito raro, necessario para addon quest.</td><td>5</td></tr>';
		echo '<tr class="rank3"><td><img src="images/items/Simon.gif" border="0"></td><td><input type="radio" name="item_shop" value="54"> 1 Simon the Beggars Favorite Staff</td><td>Item muito raro, necessario para addon quest.</td><td>40</td></tr>';
		echo '<tr class="rank3"><td><img src="images/items/Holy_Orchid.gif" border="0"></td><td><input type="radio" name="item_shop" value="55"> 10x Holy Orchid</td><td>Item muito raro, necessario para addon quest.</td><td>10</td></tr>';
		echo '<tr class="rank3"><td><img src="images/items/Hook.gif" border="0"></td><td><input type="radio" name="item_shop" value="56"> 10x Hook</td><td>Item muito raro, necessario para addon quest.</td><td>10</td></tr>';
		echo '<tr class="rank3"><td><img src="images/items/Peg_Leg.gif" border="0"></td><td><input type="radio" name="item_shop" value="57"> 10x Peg Leg</td><td>Item muito raro, necessario para addon quest.</td><td>10</td></tr>';
		echo '<tr class="rank3"><td><img src="images/items/Eye_Patch.gif" border="0"></td><td><input type="radio" name="item_shop" value="58"> 10x Eye Patch</td><td>Item muito raro, necessario para addon quest.</td><td>10</td></tr>';
		echo '<tr class="rank3"><td><img src="images/items/Crossbow.gif" border="0"></td><td><input type="radio" name="item_shop" value="59"> 1 Elanes Crossbow (Engraved Crossbow)</td><td>Item muito raro, necessario para addon quest.</td><td>40</td></tr>';
		echo '<tr class="rank3"><td><img src="images/items/Turtle_Shell.gif" border="0"></td><td><input type="radio" name="item_shop" value="62"> 100 Turtle Shells</td><td>Item muito raro, necessario para addon quest.</td><td>30</td></tr>';
		
		echo '<br><center><table width="95%" border="0" cellpadding="4" cellspacing="1">';
		echo '<tr class="rank2"><td colspan="4"><b>Pacote de Addons</td></tr>';
		echo '<tr class="rank1"><td width="3%"></td><td width="20%"><b>Item</td><td width="25%"><b>Descrição</td><td width="10%"><b>premDays</td></tr>';

		echo '<tr class="rank3"><td><img src="images/items/nightmare1.gif" border="0"></td><td><input type="radio" name="item_shop" value="60"> First Nightmare Addon</td><td>Dando Use neste item você irá obter o primeiro addon do outfit Nightmare.</td><td>40</td></tr>';
		echo '<tr class="rank3"><td><img src="images/items/nightmare2.gif" border="0"></td><td><input type="radio" name="item_shop" value="61"> Second Nightmare Addon</td><td>Dando Use neste item você irá obter o segundo addon do outfit Nightmare.</td><td>40</td></tr>';
	
		echo '<br><center><table width="95%" border="0" cellpadding="4" cellspacing="1">';
		echo '<br><tr class="rank2"><td colspan="4"></b>Itens incrementadores de atributos e defesa.<font size=1><br>Para informações sobre os itens visite http://tibia.erig.net  <br>Lembre-se: Alguns itens desses requerem level para serem usados.</td></tr>';
		echo '<br><tr class="rank2"><td colspan="4"><b>Armors(Update 8.31)</td></tr>';
		echo '<tr class="rank1"><td width="3%"></td><td width="20%"><b>Item</td><td width="25%"><b>Descrição</td><td width="10%"><b>premDays</td></tr>';

		
		echo '<tr class="rank3"><td><img src="images/items/Spirit_Cloak.gif" border="0"></td><td><input type="radio" name="item_shop" value="63"> Spirit Cloak</td><td>Magic Level +1</td><td>10</td></tr>';
		echo '<tr class="rank3"><td><img src="images/items/Focus_Cape.gif" border="0"></td><td><input type="radio" name="item_shop" value="64"> Focus Cape</td><td>Magic Level +1</td><td>10</td></tr>';
		echo '<tr class="rank3"><td><img src="images/items/Lord_Cape.gif" border="0"></td><td><input type="radio" name="item_shop" value="65"> Dark Lord\'s Cape</td><td>Protection death +8%, holy -8%</td><td>12</td></tr>';
		echo '<tr class="rank3"><td><img src="images/items/Robe_of_the_Underworld.gif" border="0"></td><td><input type="radio" name="item_shop" value="67"> Robe of the Underworld</td><td>Protection death +12%, holy -12%<td>12</td></tr>';
		echo '<tr class="rank3"><td><img src="images/items/Paladin_Armor.gif" border="0"></td><td><input type="radio" name="item_shop" value="66">Paladin Armor</td><td>Distance Skills +2</td><td>20</td></tr>';
		echo '<tr class="rank3"><td><img src="images/items/Dragon_Robe.gif" border="0"></td><td><input type="radio" name="item_shop" value="68"> Dragon Robe</td><td>Protection fire +12%, ice -12%</td><td>12</td></tr>';
		echo '<tr class="rank3"><td><img src="images/items/Greenwood_Coat.gif" border="0"></td><td><input type="radio" name="item_shop" value="69"> Greenwood Coat</td><td>Protection earth +12%, fire -12%</td><td>12</td></tr>';	
		echo '<tr class="rank3"><td><img src="images/items/Frozen_Plate.gif" border="0"></td><td><input type="radio" name="item_shop" value="70"> Frozen Plate</td><td>Protection ice +7%, energy -7%</td><td>12</td></tr>';	
		echo '<tr class="rank3"><td><img src="images/items/Lavos_Armor.gif" border="0"></td><td><input type="radio" name="item_shop" value="71"> Lavos Armor</td><td>Protection fire +3%, ice -3%</td><td>12</td></tr>';	
		echo '<tr class="rank3"><td><img src="images/items/Crystalline_Armor.gif" border="0"></td><td><input type="radio" name="item_shop" value="71"> Crystalline Armor</td><td>Ice Protection +3%, Energy Protection -3%</td><td>12</td></tr>';	
		echo '<tr class="rank3"><td><img src="images/items/Voltage_Armor.gif" border="0"></td><td><input type="radio" name="item_shop" value="72">Voltage Armor</td><td>Protection energy +3%, earth -3%</td><td>12</td></tr>';	
		echo '<tr class="rank3"><td><img src="images/items/Skullcracker_Armor.gif" border="0"></td><td><input type="radio" name="item_shop" value="74">Skullcracker Armor</td><td>Protection death +5%, holy -5%</td><td>15</td></tr>';	
		echo '<tr class="rank3"><td><img src="images/items/Earthborn_Titan_Armor.gif" border="0"></td><td><input type="radio" name="item_shop" value="75">Earthborn Titan Armor</td><td>Protection earth +5%, fire -5%</td><td>15</td></tr>';	
		echo '<tr class="rank3"><td><img src="images/items/Windborn_Colossus_Armor.gif" border="0"></td><td><input type="radio" name="item_shop" value="76">Windborn Colossus Armor</td><td>Club fighting +2, protection energy +5%, earth -5%</td><td>20</td></tr>';	
		echo '<tr class="rank3"><td><img src="images/items/Oceanborn_Leviathan_Armor.gif" border="0"></td><td><input type="radio" name="item_shop" value="77">Oceanborn Leviathan Armor </td><td>Protection ice +5%, energy -5%</td><td>20</td></tr>';	
		echo '<tr class="rank3"><td><img src="images/items/Master_Archers_Armor.gif" border="0"></td><td><input type="radio" name="item_shop" value="78">Master Archer\'s Armor</td><td>Arm:15, Distance fighting +3</td><td>20</td></tr>';	
		echo '<tr class="rank3"><td><img src="images/items/Fireborn_Giant_Armor.gif" border="0"></td><td><input type="radio" name="item_shop" value="79">Fireborn Giant Armor</td><td>Arm:15, ,sword fighting +2, protection fire +5%, ice -5%</td><td>25</td></tr>';	


		echo '<tr class="rank2"><td colspan="4"><b>Spellbooks(Update 8.31) (Sómente para Druids/Sorcerers)</td></tr>';

		echo '<tr class="rank3"><td><img src="images/items/Spellbook_of_Mind_Control.gif" border="0"></td><td><input type="radio" name="item_shop" value="80">Spellbook of Mind Control</td><td>Def:16<br>Magic level +2 </td><td>20</td></tr>';	
		echo '<tr class="rank3"><td><img src="images/items/Spellbook_of_Enlightenment.gif" border="0"></td><td><input type="radio" name="item_shop" value="81">Spellbook of Enlightenment</td><td>Def:18<br> Magic level +1</td><td>15</td></tr>';	
		echo '<tr class="rank3"><td><img src="images/items/Spellbook_of_Dark_Mysteries.gif" border="0"></td><td><input type="radio" name="item_shop" value="82">Spellbook of Dark Mysteries</td><td>Def:16<br>Magic level +3</td><td>25</td></tr>';	
		echo '<tr class="rank3"><td><img src="images/items/Spellscroll_of_Prophecies.gif" border="0"></td><td><input type="radio" name="item_shop" value="83">Spellscroll of Prophecies</td><td>Def:12<br>Magic level +3</td><td>25</td></tr>';	
		echo '<tr class="rank3"><td><img src="images/items/Spellbook_of_Warding.gif" border="0"></td><td><input type="radio" name="item_shop" value="84">Spellbook of Warding</td><td>Def:22<br>Magic level +1</td><td>15</td></tr>';	
		echo '<tr class="rank3"><td><img src="images/items/Spellbook_of_Lost_Souls.gif" border="0"></td><td><input type="radio" name="item_shop" value="85">Spellbook of Lost Souls</td><td>Def:20<br>Magic level +2</td><td>15</td></tr>';	
	
		echo '<tr class="rank2"><td colspan="4"><b>Novos Weapons de Distancia (Sómente para Paladinos)</td></tr>';
	
		echo '<tr class="rank3"><td><img src="images/items/Modified_Crossbow.gif" border="0"></td><td><input type="radio" name="item_shop" value="86">Modified Crossbow</td><td>Range:5<br> Hit% +1</td><td>12</td></tr>';	
		echo '<tr class="rank3"><td><img src="images/items/Elethriel.gif" border="0"></td><td><input type="radio" name="item_shop" value="87">Elethriel\'s Elemental Bow </td><td>Range:4<br> Hit% +7</td><td>12</td></tr>';	
		echo '<tr class="rank3"><td><img src="images/items/Royal_Crossbow.gif" border="0"></td><td><input type="radio" name="item_shop" value="88">Royal Crossbow</td><td>Range:6, Atk +5, Hit% +3</td><td>20</td></tr>';	
	
		echo '<br><center><table width="95%" border="0" cellpadding="4" cellspacing="1">';
		echo '<tr class="rank2"><td colspan="4"><b>Itenes Leves/ageis</td></tr>';
		echo '<tr class="rank1"><td width="3%"></td><td width="20%"><b>Item</td><td width="25%"><b>Descrição</td><td width="10%"><b>premDays</td></tr>';
		
		echo '<tr class="rank3"><td><img src="images/items/Blue_Legs.gif" border="0"></td><td><input type="radio" name="item_shop" value="89"> Blue Legs</td><td>Item normal e leve.</td><td>15</td></tr>';	
		echo '<tr class="rank3"><td><img src="images/items/Mammoth_Fur_Cape.gif" border="0"></td><td><input type="radio" name="item_shop" value="90"> Mammoth Fur Cape</td><td>Item normal e leve.</td><td>10</td></tr>';	
				

	
	
		echo '</table>';

		echo '<br><center><table width="70%" border="0" cellpadding="4" cellspacing="1">';
		echo '<tr class="rank2"><td colspan="2">Informações do Personagem</td></td></tr>';
		echo '<tr class="rank1"><td width="15%">Password</td><td><input name="pass" type="password" value="" class="login"/><br><font size=1>(Confirme sua senha por segurança)</td></tr>';
		echo '<tr class="rank1"><td>Personagem</td><td><select name="player_id">';
		
		$query = mysql_query("SELECT * FROM `players` WHERE (`account_id` = '$account')");	
		while($fetch = mysql_fetch_object($query))
			echo '<option value="'.$fetch->id.'">'.$fetch->name.'</option>';	
			
		echo '</select><br><font size=1>(Personagem que deve receber os itens)</td></tr>';
		echo '<tr class="rank1"><td>Depot City</td><td><select name="depot_id"><option value="0">(choose city)</option><option value="1">Quendor</option><option value="4">Thorn</option><option value="2">Aracura</option></select><br><font size=1>(Depot da cidade que deve ser enviado os itens)</td></tr>';
		echo '</table>';
		echo '<br><center><input type="image" value="submit" src="images/confirm.gif"/> <a href="?page=account.main"><img src="images/back.gif" border="0"></a>';			
		echo '</form>';	
	}	
}	
?>