<?
include "top.php";

$account = $_SESSION['account'];
$password = $_SESSION['password'];

if($_GET['subtopic'] == 'about')
{
	echo '<tr><td class=newbar><center><b>:: '.$lang['about_title'].' ::</td></tr>
	<tr><td class=newtext>
	<center>
	<br><table width=95% border=0>
	'.obtainText("ABOUT", $lang['lang']).'
	</table>
	<br>';
	if(Account::isAdmin($account))
		echo '<a href="admin.php?subtopic=editText&id=1"><img src="images/edit.gif" border="0"></a>';	
}

elseif($_GET['subtopic'] == 'faq')
{
	echo '<tr><td class=newbar><center><b>:: Darghos FAQ ::</td></tr>
	<tr><td class=newtext>
	<center>
	<br><table border="0" width="95%" CELLSPACING="1" CELLPADDING="2">
	'.obtainText("FAQ_DESC", $lang['lang']).'
	</table><br>
	<center><table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="4">
	<tr><td class=rank2>'.$lang['faqs'].'</td></tr>';
	
	$query = mysql_query("SELECT * FROM site.faq ORDER by position ASC");	
	while ($fetch = mysql_fetch_object($query))
	{
		if($lang['lang'] == 'pt_br')
		{
			$ask = $fetch->pt_ask;
			$answer = $fetch->pt_answer;
		}	
		else
		{
			$ask = $fetch->en_ask;
			$answer = $fetch->en_answer;
		}	
		
		echo '<tr><td class=rank1><b>'.$fetch->position.') '.$ask.'</b><br>
		'.$answer.'</td></tr>';
	}
	echo '</table><br>';
}

elseif($_GET['subtopic'] == 'featurespremium')
{
	
	echo '<tr><td class=newbar><center><b>:: '.$lang['contribute_title'].' ::</td></tr>
	<tr><td class=newtext><center>
	<br><table width="95%" border="0"><tr><td></td><tr>
	<center>'.obtainText("CONTRIBUTE_DESC", $lang['lang']).'
	</table><center>
	<a href="about.php?subtopic=getpremium"><img src="images/contribute.gif" border="0"></a><br><br>';
	if(Account::isAdmin($account))
		echo '<a href="admin.php?subtopic=editText&id=3"><img src="images/edit.gif" border="0"></a>';
}

elseif($_GET['subtopic'] == 'support')
{
	echo '<tr><td class=newbar><center><b>:: '.$lang['support_title'].' ::</td></tr>
	<tr><td class=newtext><br>';
	echo '<center><table width=95% border=0>';
	echo ''.obtainText("SUPPORT_DESC", $lang['lang']).'';
	echo '</table>';
	
	$getAdminquery = mysql_query("SELECT * FROM `players` WHERE `group_id` = '6' and `special_hide` = '0' ORDER BY name asc") or die(mysql_error());
	echo '<br><center><table width="85%" border="0" bgcolor="black" cellpadding="2" cellspacing="1">';
	echo '<tr class="rank2"><td colspan="3"><b>'.$lang['administrator'].'</td></tr>';
	echo '<tr class="rank3"><td><b>'.$lang['member_name'].':</td><td width="15%"></td></tr>';
	
	while($fetch = mysql_fetch_object($getAdminquery))
	{
		if (Player::isOnline($fetch->name))
			$status = '<font color="green"><b>Online</b></font>';
		else
			$status = null;
		echo '<tr class="rank1"><td><a href="community.php?subtopic=details&char='.$fetch->name.'">'.$fetch->name.'</a></td><td>'.$status.'</td></tr>';
	}
	
	echo '</table>';		
	
	$getCMquery = mysql_query("SELECT * FROM `players` WHERE `group_id` = '5' and `special_hide` = '0' ORDER BY name asc") or die(mysql_error());
	echo '<br><center><table width="85%" border="0" bgcolor="black" cellpadding="2" cellspacing="1">';
	echo '<tr class="rank2"><td colspan="3"><b>'.$lang['community_manager'].'</td></tr>';
	echo '<tr class="rank3"><td><b>'.$lang['member_name'].':</td><td width="15%"></td></tr>';
	
	while($fetch = mysql_fetch_object($getCMquery))
	{
		if (Player::isOnline($fetch->name))
			$status = '<font color="green"><b>Online</b></font>';
		else
			$status = null;
		echo '<tr class="rank1"><td><a href="community.php?subtopic=details&char='.$fetch->name.'">'.$fetch->name.'</a></td><td>'.$status.'</td></tr>';
	}
	
	echo '</table>';	
	
	$getGMquery = mysql_query("SELECT * FROM `players` WHERE `group_id` = '4' and `special_hide` = '0' ORDER BY name asc") or die(mysql_error());
	echo '<br><center><table width="85%" border="0" bgcolor="black" cellpadding="2" cellspacing="1">';
	echo '<tr class="rank2"><td colspan="3"><b>'.$lang['game_master'].':</td></tr>';
	echo '<tr class="rank3"><td><b>'.$lang['member_name'].':</td><td width="15%"></td></tr>';
	
	while($fetch = mysql_fetch_object($getGMquery))
	{
		if (Player::isOnline($fetch->name))
			$status = '<font color="green"><b>Online</b></font>';
		else
			$status = null;
		echo '<tr class="rank1"><td><a href="community.php?subtopic=details&char='.$fetch->name.'">'.$fetch->name.'</a></td><td>'.$status.'</td></tr>';
	}
	
	echo '</table>';
	if(Account::isCM($account) or Account::isAdmin($account))
		echo '<br><a href="admin.php?subtopic=gmAccount"><img src="images/newMember.gif" border="0"></a>';						
}

elseif($_GET['subtopic'] == 'getpremium')
{
	echo '<tr><td class=newbar><center><b>:: Contribute ::</td></tr>
	<tr><td class=newtext>';

	echo '<br><center><table border="0" width="95%" CELLSPACING="1" CELLPADDING="2">';
	echo 'Aqui voc� pode contribuir com o Darghos. Quando voc� contribui, voc� recebe uma s�rie de beneficios dentro e fora do jogo durante um periodo, para saber mais sobre os beneficios por favor visite a se��o <a href="about.php?subtopic=featurespremium">vantagens premium</a>. <br><br>';
	echo 'Obtendo sua premium account por este sistema, voc� pode optar por usufruir das vantagens instantaneamente, isto caso voc� possua um personagem ativo (com level 50 ou superior em sua conta) ou j� tenha feito uma contribui��o anteriormente.';
	echo '<br><br> <font size=3><b>Pre�os</b></font>';
	echo '</table>';	

	echo '<br><center><table width="90%" border="0" cellpadding="4" cellspacing="1">';
	echo '<tr class="rank2"><td colspan="3"><b>Contribui��es</td></tr>';
	echo '<tr class="rank1"><td><b>Dura��o</td><td width="40%"><b>PagSeguro</td><td width="25%"><b>PayPal</td></tr>';	
	echo '<tr class="rank3"><td>30 dias</td><td><del>R$ 19,90</del> <b>R$ 10,90</b> <font size=1>(R$ 0,39/dia)</font></td><td>7.90 USD</td></tr>';	
	echo '<tr class="rank1"><td>60 dias <font size="1" color=green><b>(novo!)</b></font></td><td>R$ 21,80 <font size=1>(R$ 0,39/dia)</font></td><td>15.80 USD</td></tr>';	
	echo '<tr class="rank3"><td>90 dias</td><td>R$ 32,70 <font size=1>(R$ 0,39/dia)</font></td><td>23.70 USD</td></tr>';	
	echo '<tr class="rank1"><td>180 dias</td><td><del>R$ 71,90</del> <b>R$ 55,90</b> <font size=1>(R$ 0,31/dia)</font></td><td>35.90 USD</td></tr>';	
	echo '<tr class="rank3"><td>360 dias <font size="1" color=green><b>(novo!)</b></font></td><td>R$ 99,90 <font size=1>(R$ 0,27/dia)</font></td><td>62.90 USD</td></tr>';	
	echo '</table>';

	echo '<br><center><table border="0" width="95%" CELLSPACING="1" CELLPADDING="2">';
	echo '<font size=3><b>Metodos de Pagamentos</b></font>';
	echo '<br><br>N�s processamos os pagamentos ultilizando o PagSeguros, esta � uma conceituada, segura e tradicional empresa no setor de pagamentos virtuais a anos, note que a PagSeguro � parte integrande do grupo UOL (Universo Online). Abaixo segue uma pequena instru��o de cada m�todo de pagamento (caso ainda tenha duvidas, o PagSeguro tambem possui uma lista de instru��es).';
	echo '<br><br><li><b>Boleto Banc�rio</b></li><br>';
	echo 'Este � o metodo mais simples, e n�o necessita de ter uma conta em banco. Voc� s�ra direcionado para o site do PagSeguro, aonde deve entrar com o sua conta do site deles. Caso voc� n�o possua uma conta no PagSeguro, voc� poder� criar uma na pagina direcionada deles, ou clicando aqui.<br>Ent�o ap�s completar seu pagamento, ser� gerado um boleto. � s� imprimir-lo ou anotar a linha digit�vel e pagar em qualquer fila de caixa de banco ou lot�rica (caixas eletronicos n�o s�o validos), ou ainda no site do seu banco. O pagamento ser� efetivado no proximo dia �til seguinte no metodo convencional.';
	echo '<br><br><li><b>Transferencia Eletronica</b> - valida��o do pagamento online (instant�nea)</li><br>';
	echo 'Na tela "Formas de Pagamento" selecione o banco em que voc� tem conta corrente, e clique em "continuar". O valor total de sua compra aparecer� em uma tela de confirma��o, clique em continuar e voc� ser� redirecionado ao site do banco escolhido para finalizar o pagamento. Ap�s entrar no banco com seus dados e senhas, ao concluir o processo a valida��o e autoriza��o dos pagamentos atrav�s dos bancos � on-line e instant�nea, ou seja, � realizada e liberada em tempo real.';
	
	echo '<br><br><big><b><font color="red">Aten��o:</font></b></big> Todo processo de contribui��o deve ser feito seguindo rigorosamente as instru��es do passo a passo (inclusive as instru��es do site do PagSeguro). N�s n�o possuimos formas de pagamento convencionais, como <b><font color="red">deposito direto em conta</b></font>. O n�o cumprimento de qualquer etapa, ou qualquer tentativa de pagamento diferente das informadas acima resultar� em <b><font color="red">n�o valida��o do pagamento</b></font>, <b><font color="red">sem op��o de reembolso</b></font>. Em caso de qualquer sombra duvida entre em contato conosco ou solicite orienta��o de seu responsavel.';
	
	echo '<br><br>Caso voc� possua alguma duvida, ainda pode tentar exclarece-la em nosso <a href="about.php?subtopic=faq">FAQ</a> ou ainda em nosso email de suporte sobre duvidas em contribui��es <a href="mailto:premium@darghos.com">premium@darghos.com</a>.';
	echo '<br><br>Caso voc� deseje prosseguir em sua contribui��o, por favor clique em "Continue" para avan�ar ao proximo passo (login necessario).';

	if (!Account::isLogged($account,$password))
		echo '<br><br><center><a href="account.php?subtopic=login"><img src="images/login.gif" border="0"></a>';
	else		
	echo '<br><br><center><a href="main.php?subtopic=payments&step=1"><img src="images/continue.gif" border="0"></a>';
	echo '</table><br>';
}
elseif($_GET['subtopic'] == 'item_shop')
{
	echo '<tr><td class=newbar><center><b>:: Item Shop List ::</td></tr>
	<tr><td class=newtext>';

	echo '<br><center><table border="0" width="95%" CELLSPACING="1" CELLPADDING="2">';
	echo 'Welcome to demo Item Shop List, here you can see all available items and yours image, description and price. Remember that the items only can be obtained "trading" him for days of your premium account. This system is completely automated and is not necessary any person (GM, CM or GOD) to receive the items. The item is automatically send to your city depot. See below the full list of available items.';
	echo '</table>';

	echo '<br><center><table width="95%" border="0" cellpadding="4" cellspacing="1">';
	echo '<tr class="rank2"><td colspan="4"><b>Item Shop List</td></tr>';
	echo '<tr class="rank1"><td width="3%"></td><td width="20%"><b>Item</td><td width="25%"><b>Description</td><td width="10%"><b>Premium Days</td></tr>';
	
	echo '<tr class="rank3"><td><img src="images/items/haunted_blade.gif" border="0"></td><td>Haunted Blade</td><td>Atk: 40, Def: 12, Lvl: 30</td><td>5</td></tr>';
	echo '<tr class="rank3"><td><img src="images/items/orcish_maul.gif" border="0"></td><td>Orcish Maul</td><td>Atk: 42, Def: 18, Lvl: 35</td><td>5</td></tr>';
	echo '<tr class="rank3"><td><img src="images/items/headchopper.gif" border="0"></td><td>Headchopper</td><td>Atk: 42, Def: 20, Lvl: 35</td><td>5</td></tr>';	
	echo '<tr class="rank3"><td><img src="images/items/giant_sword.gif" border="0"></td><td>Giant Sword</td><td>Atk: 46, Def: 22, Lvl: 55</td><td>7</td></tr>';
	echo '<tr class="rank3"><td><img src="images/items/dragon_lance.gif" border="0"></td><td>Dragon Lance</td><td>Atk: 47, Def: 16, Lvl: 60</td><td>7</td></tr>';	
	
	echo '<tr class="rank3"><td><img src="images/items/blue_robe.gif" border="0"></td><td>Blue Robe</td><td>Arm: 11</td><td>4</td></tr>';
	echo '<tr class="rank3"><td><img src="images/items/golden_armor.gif" border="0"></td><td>Golden Armor</td><td>Arm: 14</td><td>8</td></tr>';
	echo '<tr class="rank3"><td><img src="images/items/dragon_scale_mail.gif" border="0"></td><td>Dragon Scale Mail</td><td>Arm: 15</td><td>15</td></tr>';	
	echo '<tr class="rank3"><td><img src="images/items/magic_plate_armor.gif" border="0"></td><td>Magic Plate Armor</td><td>Arm: 17</td><td>25</td></tr>';
	
	echo '<tr class="rank3"><td><img src="images/items/vampire_shield.gif" border="0"></td><td>Vampire Shield</td><td>Def: 34</td><td>5</td></tr>';
	echo '<tr class="rank3"><td><img src="images/items/demon_shield.gif" border="0"></td><td>Demon Shield</td><td>Def: 35</td><td>12</td></tr>';	
	echo '<tr class="rank3"><td><img src="images/items/mastermind_shield.gif" border="0"></td><td>Mastermind Shield</td><td>Def: 37</td><td>18</td></tr>';	
	
	echo '<tr class="rank3"><td><img src="images/items/crown_legs.gif" border="0"></td><td>Crown Legs</td><td>Arm: 8</td><td>5</td></tr>';
	echo '<tr class="rank3"><td><img src="images/items/golden_legs.gif" border="0"></td><td>Golden Legs</td><td>Arm: 9</td><td>15</td></tr>';	
	
	echo '<tr class="rank3"><td><img src="images/items/boots_of_haste.gif" border="0"></td><td>Boots of Haste</td><td>You can moving more fast</td><td>10</td></tr>';		
	echo '<tr class="rank3"><td><img src="images/items/royal_helmet.gif" border="0"></td><td>Royal Helmet</td><td>Arm: 9</td><td>10</td></tr>';
	
	echo '<tr class="rank3"><td><img src="images/items/ring_of_healing.gif" border="0"></td><td>BP Ring of Healing</td><td>Recovery Mana and Life more fast</td><td>10</td></tr>';
	echo '<tr class="rank3"><td><img src="images/items/stone_skin_amulet.gif" border="0"></td><td>BP Stone Skin Amulet</td><td>Absorv 80% of damages</td><td>20</td></tr>';
	echo '<tr class="rank3"><td><img src="images/items/amulet_of_loss.gif" border="0"></td><td>Amulet of Loss</td><td>Not drop any item on die</td><td>10</td></tr>';
	
	echo '<tr class="rank3"><td><img src="images/items/infernal_bolt.gif" border="0"></td><td>100 Infernal Bolt</td><td>Best ammunition of game</td><td>2</td></tr>';
	echo '<tr class="rank3"><td><img src="images/items/infernal_bolt.gif" border="0"></td><td>BP Infernal Bolt</td><td>BP of best ammunition of game</td><td>20</td></tr>';
	
	echo '<tr class="rank3"><td><img src="images/items/platinum_coin.gif" border="0"></td><td>5,000</td><td>Buy all that your need</td><td>1</td></tr>';
	echo '<tr class="rank3"><td><img src="images/items/crystal_coin.gif" border="0"></td><td>50,000</td><td>Buy all and little more</td><td>10</td></tr>';	
	echo '<tr class="rank3"><td><img src="images/items/crystal_coin.gif" border="0"></td><td>100,000</td><td>Buy all more</td><td>15</td></tr>';
	
	echo '</table><br>';
	
	echo '<br><table width="95%" border="0" cellpadding="4" cellspacing="1">';
	echo '<tr class="rank2"><td colspan="4"><b>Special Tenerian Item Shop</td></tr>';
	echo '<tr class="rank1"><td width="3%"></td><td width="20%"><b>Item</td><td width="25%"><b>Descri��o</td><td width="10%"><b>premDays</td></tr>';			

	echo '<tr class="rank3"><td><img src="images/items/sudden_death.gif" border="0"></td><td> BP 100x sudden death rune</td><td>Runa mais poderosa do game</td><td>20</td></tr>';
	echo '<tr class="rank3"><td><img src="images/items/ultimate_healing_rune.gif" border="0"></td><td> BP 100x ultimate healing rune</td><td>Runa com maior poder de regenera��o</td><td>15</td></tr>';
	echo '<tr class="rank3"><td><img src="images/items/explosion.gif" border="0"></td><td> BP 100x explosion rune</td><td>Runa com um grande campo de dano</td><td>12</td></tr>';			
	echo '<tr class="rank3"><td><img src="images/items/lottery_ticket.gif" border="0"></td><td>Teleport Scroll</td><td>Seja teleportado ao Templo a hora em que quiser.</td><td>10</td></tr>';	
	
	echo '</table><br>';	
}
include "footer.php"; ?>