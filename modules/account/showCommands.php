<?
if($engine->loggedIn())
{
	echo '<tr><td class=newbar><center><b>:: Comandos ::</td></tr>';
	echo '<tr><td class=newtext><br><center>';	

	echo '<center><table border="0" width="95%" CELLSPACING="1" CELLPADDING="2">';
	echo 'O Darghos possui alguns comandos com o fim de facilitar o jogo ou efetuar alguma ação especial, veja abaixo a lista de comandos disponiveis e sua descrição.';
	echo '</table><br>';		
	
	echo '<table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
	echo '<tr class=rank2><td colspan=2>Lista de comandos </td></tr>';
	echo '<tr class=rank1><td width="20%"><b>Comando:</b></td><td><b>Descrição:</b></td></tr>';
	echo '<tr class=rank1><td>!buyhouse</td><td>Compra uma casa. (necessita ficar de frente para a porta da casa desejada)</td></tr>';
	echo '<tr class=rank1><td>!sellhouse</td><td>Vende sua casa. (ex: !sellhouse CM Slash)</td></tr>';
	echo '<tr class=rank1><td>!leavehouse</td><td>Abandona sua casa.</td></tr>';
	echo '<tr class=rank1><td>!serverinfo</td><td>Exibe as informações do Darghos.</td></tr>';
	echo '<tr class=rank1><td>!kills</td><td>Exibe quantas mortes injustificadas você tem.</td></tr>';
	echo '<tr class=rank1><td>!mortes</td><td>Exibe as mortes de um jogador. (ex: !mortes "CM Slash)</td></tr>';
	if(Account::isPremium($account))
	{
		echo '<tr class=rank1><td>!createguild</td><td>Cria uma nova guilda. (ex: !createguild Darghos Powers)</td></tr>';
		echo '<tr class=rank1><td>!joinguild</td><td>Aceita um convite de uma guilda. (apos invitado, ex: !joinguild Darghos Powers)</td></tr>';
	}
	echo '</table><br>';

	if(Account::isGM($account) or Account::isAdmin($account) or Account::isCM($account))
	{
		echo '<table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
		echo '<tr class=rank2><td colspan=2>Lista de Gamemaster Comandos </td></tr>';
		echo '<tr class=rank1><td width="20%"><b>Comando:</b></td><td><b>Descrição:</b></td></tr>';
		echo '<tr class=rank1><td>Control + Y</td><td>Abre o painel de violações.</td></tr>';
		echo '<tr class=rank1><td>/B</td><td>Faz um broadcast. (ex: /B Boa tarde a todos)</td></tr>';
		echo '<tr class=rank1><td>/pos</td><td>Obtem as cordenadas do jogador. (ex: /pos CM Slash)</td></tr>';
		echo '<tr class=rank1><td>/t</td><td>Teletransporte para o seu templo.</td></tr>';
		echo '<tr class=rank1><td>/town</td><td>Se teletransporta para o templo de uma cidade. (ex: /town Aracura)</td></tr>';
		echo '<tr class=rank1><td>/tp</td><td>Se teletransporta para um local predefinido. (ex: /tp "dp_aracura)</td></tr>';
		echo '</table><br>';
	
		echo '<table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
		echo '<tr class=rank2><td colspan=2> Guia para um Gamemaster</td></tr>';
		echo '<tr class=rank1><td> Usando o comando de teleport pre-definido (<b>/tp "</b>):<br>Para usar este comando, existe uma lista com definidos lugares no mapa para qual os GMS podem se auto-teletransportar.<br><br> Para ultilizar o mesmo voce ira ter parametros(complementos) para serem usados depois do /tp ", por exemplo:<br><br>Sou um gm e quero saber quais lugares eu posso ir?<br>Para isso digite <b>/tp "*get</b><br><br> Agora eu to em tal local, e quero marcar aqui, para quando eu quiser vir aqui so digitar o comando?<br>Voce usara o comando da seguinte forma: <b>/tp"*set NOMEDOLOCAL</b><br> E para se teleportar basta digitar /tp "nomedolocal<br><br>Voce podera tambem promover e despromover tutores, mais pediremos que para promover algum tutor, consulte antes algum administrador da equipe.<br><br>Voce tem ciencia de que qualquer descuido, mal uso do cargo, ou coisa do tipo, voce perdera seu cargo definitivamente, sem direito a desculpa ou explicacao alguma. A equipe de administradores tem controle total de suas acoes. Portanto siga seu cargo de modo exato, como a regra define. Voce sendo um GM, nao sera impedido de jogar ou participar de guerras, contando que nao use o GM para beneficio proprio, ou beneficio do time. <br><br> <b>A UltraXSoft deseja a voce toda sorte do mundo, e que voce siga seu cargo mantendo a ordem e o suporte dentro do Darghos.</b></td></tr>';
		echo '</table><br>';
	}	

	if(Account::isCM($account) or Account::isAdmin($account))
	{
		echo '<table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
		echo '<tr class=rank2><td colspan=2>Lista de Comunity Manager Comandos </td></tr>';
		echo '<tr class=rank1><td width="20%"><b>Comando:</b></td><td><b>Descrição:</b></td></tr>';
		echo '<tr class=rank1><td>/save</td><td>Salva o server.</td></tr>';
		echo '<tr class=rank1><td>/reload</td><td>Recarrega um sistema. (ex: /reload actions)</td></tr>';
		echo '<tr class=rank1><td>/closeserver</td><td>Fecha o server para jogadores.</td></tr>';
		echo '<tr class=rank1><td>/openserver</td><td>Abre o server para jogadores (caso esteja fechado).</td></tr>';
		echo '<tr class=rank1><td>/kick</td><td>Desconecta um jogador. (ex: /kick CM Slash)</td></tr>';
		echo '<tr class=rank1><td>/b</td><td>Bani o IP de um jogador. (ex: /b CM Slash)</td></tr>';
		echo '<tr class=rank1><td>/info</td><td>Obtem informações do personagem. (ex: /info CM Slash)</td></tr>';
		echo '<tr class=rank1><td>/raid</td><td>Inicia uma invasão. (ex: /raid aracura_demodras)</td></tr>';
		echo '<tr class=rank1><td>/clean</td><td>Limpa o chão do server.</td></tr>';
		echo '<tr class=rank1><td>/s</td><td>Sumona um NPC. (ex: /s rook_oracle)</td></tr>';
		echo '</table><br>';
	}
}	
?>	