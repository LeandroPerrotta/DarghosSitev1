<?
echo '<tr><td class=newbar><center><b>:: '.$page['subTitle'].' ::</td></tr>
<tr><td class=newtext><br>';	

$account = $engine->loadClass('Accounts');
$account->loadByNumber($_SESSION['account']);	

if($_REQUEST['step'] == 2)
{
	echo '
	<center>
	<table border="0" width="95%" CELLSPACING="1" CELLPADDING="2">
	Nesta etapa voc� iremos cofigurar as caracteristicas de seu novo personagem.<br>
	<br>
	Escolha um nome para seu personagem, note que o nome deste personagem deve seguir as regras de nomes rigorosamente ou ser� impossivel criar um novo personagem.<br>
	<br>
	Ap�s escolher o nome voc� dever� escolher se seu personagem ser� do genero Masculino ou Feminino. Ap�s isto ir� selecionar a voca��o e a cidade na qual voc� deseja iniciar sua jornada. Ap�s isto basta selecionar o servidor na qual ser� criado o seu novo personagem e clique em Submit (de preferencia a servidores localizados perto de voc� pois isto aumenta a perfomance e rapidez na comunica��o).
	</table>
	<br>';	

	if($_POST['start_mode'] == 'rookgaard')
	{
		$vocations = '<select name="vocation"><option value="none">Sem voca��o</option></select>';
		$residence = '<select name="residence"><option value="rookgaard">Rookgaard</option></select>';
	}	
	else
	{
		$vocations = '<select name="vocation"><option value="sorcerer">Sorcerer</option><option value="druid">Druid</option><option value="paladin">Paladin</option><option value="knight">Knight</option></select>';
		
		if($account->getData('premdays') == 0)
			$residence = '<select name="residence"><option value="quendor">Quendor</option><option value="thorn">Thorn</option></select>';
		else
			$residence = '<select name="residence"><option value="quendor">Quendor</option><option value="thorn">Thorn</option><option value="aracura">Aracura</option><option value="salazart">Salazart</option><option value="northrend">Northrend</option></select>';
	}
	
	echo '<form method="POST" action="?page=character.create&step=3">
	<table width="95%" BORDER="0" CELLSPACING="1" CELLPADDING="4">
		<tr>
			<td class="rank2" colspan="2">Caracteristicas do Personagem</td>
		</tr>
		<tr>
			<td colspan="2" class="rank3">
				<table width="95%" BORDER="0" CELLSPACING="0" CELLPADDING="4">
					<tr>
						<td width="30%" class="rank3">Nome do Personagem:</td> <td class="rank3"><input name="character_name" type="text" value="" class="login"/></td>
					</tr>
				</table>	
			</td>
		</tr>
		<tr>
			<td class="rank3" width="25%">G�nero:</td><td class="rank3"><select name="genre"><option value="male">Masculino</option><option value="female">Feminino</option></select></td>
		</tr>	
		<tr>
			<td class="rank3" width="25%">Voca��o:</td><td class="rank3">'.$vocations.'</td>
		</tr>	
		<tr>
			<td class="rank3" width="25%">Residencia:</td><td class="rank3">'.$residence.'</td>
		</tr>						
	</table><br>
	<a href="?page=character.create"><img src="images/back.gif" border="0"></a>	
	<input type="image" value="Entrar" src="images/submit.gif"/> 
	</form>	 
	';		
}
elseif($_REQUEST['step'] == 3)
{
	$player = $engine->loadClass("Players");
	$success = false;

	if(!$_POST['character_name'])
	{
		$condition['title'] = 'Campos vazios';
		$condition['details'] = "Para prosseguir � necessario preencher todos campos corretamente.";			
	}
	elseif(!$engine->filtreString($_POST['character_name']))
	{
		$condition['title'] = 'Sintaxes reservadas';
		$condition['details'] = "O seu formulario contem o uso de sintaxes reservadas ao sistema interno. Por favor tente novamente com outros valores.";
	}		
	elseif(!$engine->canUseName($_POST['character_name']))
	{
		$condition['title'] = 'Formato de nome Invalido';
		$condition['details'] = "O nome escolhido para seu personagem possui um modelo de formata��o n�o permitida, tente novamente seguindo estas regras:<br><br> 
					<li>Seu nome n�o pode come�ar ou terminar com um 'espa�o'.</li>
					<li>N�o use mais de um 'espa�os' entre as palavras.</li>
					<li>N�o � permitido mais que tr�s palavras em seu nome.</li>
					<li>Somente s�o permitidos os caracteres: a-z, A-Z, espa�o, hifen (-) e aspas simples.</li>
					<li>O seu nome n�o deve possuir mais que 30 caracteres.</li>
					<li>O seu nome n�o deve possuir menos que 3 caracteres.</li>
					<li>A terceira palavra de seu nome n�o deve possuir menos que 3 caracteres.</li>
					<li>A primeira letra da primeira palavra de seu nome deve ser maiuscula.</li>
					<li>A primeira letra da terceira palavra de seu nome deve ser maiuscula.</li>";				
	}
	elseif($player->loadByName($_POST['character_name']))
	{
		$condition['title'] = 'Nome j� em uso';
		$condition['details'] = "Este nome j� est� em uso por outro personagem no jogo. Por favor tente novamente com um nome diferente.";		
	}	
	elseif($engine->isFromBlackList($_POST['character_name']))
	{
		$condition['title'] = 'Nome Irregular';
		$condition['details'] = "Este nome � reservado para uso interno ou proibido. Por favor tente outro nome.";		
	}
	else
	{
		$success = true;
	
		if($_POST['vocation'] == "none")
		{
			$statusChar = array(
				'level' => 1, 
				'experience' => 0,
				'cap' => 400,
				'health' => 150,
				'mana' => 0,
			);
			
			$itemsChar = array(
				//Inventario
				array(SLOT_BACKPACK, 101, 1987, 1),
				array(SLOT_ARMOR, 102, 2467, 1),
				array(SLOT_LEFTHAND, 103, 2382, 1),
				
				//backpack
				array(101, 102, 2666, 2),
			);
		}
		else
		{
			if($_POST['vocation'] == "sorcerer")
			{
				$itemsChar = array(
					//Inventario
					array(SLOT_HEAD, 101, 2480, 1),
					array(SLOT_BACKPACK, 102, 1988, 1),
					array(SLOT_ARMOR, 103, 2464, 1),
					array(SLOT_RIGHTHAND, 104, 2530, 1),
					array(SLOT_LEFTHAND, 105, 2190, 1),
					array(SLOT_LEGS, 106, 2468, 1),
					array(SLOT_FEET, 107, 2643, 1),
					array(SLOT_AMMO, 108, 2120, 1),
					
					//backpack
					array(102, 109, 2666, 2),
				);				
			}
			elseif($_POST['vocation'] == "druid")
			{
				$itemsChar = array(
					//Inventario
					array(SLOT_HEAD, 101, 2480, 1),
					array(SLOT_BACKPACK, 102, 1988, 1),
					array(SLOT_ARMOR, 103, 2464, 1),
					array(SLOT_RIGHTHAND, 104, 2530, 1),
					array(SLOT_LEFTHAND, 105, 2182, 1),
					array(SLOT_LEGS, 106, 2468, 1),
					array(SLOT_FEET, 107, 2643, 1),
					array(SLOT_AMMO, 108, 2120, 1),
					
					//backpack
					array(102, 109, 2666, 2),
				);						
			}
			elseif($_POST['vocation'] == "paladin")
			{
				$itemsChar = array(
					//Inventario
					array(SLOT_HEAD, 101, 2480, 1),
					array(SLOT_BACKPACK, 102, 1988, 1),
					array(SLOT_ARMOR, 103, 2464, 1),
					array(SLOT_RIGHTHAND, 104, 2530, 1),
					array(SLOT_LEFTHAND, 105, 2389, 5),
					array(SLOT_LEGS, 106, 2468, 1),
					array(SLOT_FEET, 107, 2643, 1),
					array(SLOT_AMMO, 108, 2120, 1),
					
					//backpack
					array(102, 109, 2666, 2),
				);						
			}
			elseif($_POST['vocation'] == "knight")
			{
				$itemsChar = array(
					//Inventario
					array(SLOT_HEAD, 101, 2480, 1),
					array(SLOT_BACKPACK, 102, 1988, 1),
					array(SLOT_ARMOR, 103, 2464, 1),
					array(SLOT_RIGHTHAND, 104, 2530, 1),
					array(SLOT_LEFTHAND, 105, 2412, 1),
					array(SLOT_LEGS, 106, 2468, 1),
					array(SLOT_FEET, 107, 2643, 1),
					array(SLOT_AMMO, 108, 2120, 1),
					
					//backpack
					array(102, 109, 2666, 2),
					array(102, 110, 2388, 1),
					array(102, 111, 2398, 1),
				);					
			}				
			
			$statusChar = array(
				'level' => 8, 
				'experience' => 4200,
				'cap' => 470,
				'health' => 185,
				'mana' => 35,
			);	
		}
		
		$player->setData("name", $_POST['character_name']);
		$player->setData("account_id", $_SESSION['account']);
		$player->setData("sex", $g_genre[$_POST['genre']]);
		$player->setData("vocation", $g_vocation[$_POST['vocation']]);
		$player->setData("experience", $statusChar['experience']);
		$player->setData("level", $statusChar['level']);
		$player->setData("health", $statusChar['health']);
		$player->setData("healthmax", $statusChar['health']);
		$player->setData("mana", $statusChar['mana']);	
		$player->setData("manamax", $statusChar['mana']);	
		$player->setData("cap", $statusChar['cap']);
		$player->setData("town_id", $g_residence[$_POST['residence']]);	
		$player->setData("created", time());		
		
		$player->setLook("default");
		
		$player->saveNew();
	
		$player->getPlayerId();
	
		foreach($itemsChar as $item)
		{
			$player->addItem($item[0], $item[1], $item[2], $item[3]);
		}

		$condition['title'] = 'Personagem criado com sucesso!';
		$condition['details'] = "O personagem ".$_POST['character_name']." foi criado com sucesso! Voc� j� pode acessa-lo no jogo e come�ar a se divertir! <br>
		<br>
		Boa divers�o em sua jornada!<br>
		Equipe UltraxSoft.";				
	}
	
	echo '<center><table width="95%" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
	echo '<tr><td class=rank2>'.$condition['title'].'</td></tr>';
	echo '<tr><td class=rank3>'.$condition['details'].'';
	echo '</table><br>';

	if($success)
		echo '<a href="?page=account.main"><img src="images/back.gif" border="0"></a>';	
	else
		echo '<a href="?page=character.create"><img src="images/back.gif" border="0"></a>';				
}
else
{
	echo '
	<center>
	<table border="0" width="95%" CELLSPACING="1" CELLPADDING="2">
	Bem vindo a interface de cria��o de novos personagens!<br>
	<br>
	Atr�vez deste recurso voc� pode criar um novo personagem e come�ar a se divertir no Darghos, ou iniciar um novo personagem em sua conta.<br>
	<br>
	Neste passo voc� dever� escolher abaixo o modo como ir� come�ar a sua jornada. Escolhendo Rookgaard voc� ir� iniciar sua jornada em uma ilha isolada, desenvolvida para iniciantes, aonde o objetivo � ganhar o conhecimento basico do jogo atingindo nivel 8 e assim viajar para o continente principal. Escolhendo Main Land voc� j� ir� come�ar o jogo no continente principal, portanto "pulando" a ilha de Rookgaard. Esta op��o � recomendavel aos que j� possuem o conhecimento basico do funcionamento do jogo.
	</table>
	<br>
	
	<form method="POST" action="?page=character.create&step=2">
	<table width="95%" BORDER="0" CELLSPACING="1" CELLPADDING="4">
		<tr>
			<td class="rank2" colspan="2">Modo de Inicio da Jornada</td>
		</tr>
		<tr>
			<td class="rank3" width="25%"><input type="radio" name="start_mode" value="rookgaard"> Modo Rookgaard</td>
		</tr>
		<tr>
			<td class="rank3" width="25%"><input type="radio" name="start_mode" value="mainland"> Modo MainLand</td>
		</tr>			
	</table><br>
	<a href="?page=account.main"><img src="images/back.gif" border="0"></a>	
	<input type="image" value="Entrar" src="images/submit.gif"/> 
	</form>	 
	';	
}	
?>