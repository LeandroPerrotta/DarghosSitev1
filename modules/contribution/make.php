<?
if($engine->loggedIn())
{	
	if($_GET['step'] == '2')
	{
		echo '<tr><td class=newbar><center><b>:: Contribute Step 1 ::</td></tr>
		<tr><td class=newtext>';

		if($_POST['agreeClauses'] != "true")
		{
			echo '<br><center><table width="95%" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
			echo '<tr><td class=rank2>Clausulas e Regras de Contribui��o</td></tr>';
			echo '</table>';
			echo '<center><table border="0" width="95%" CELLSPACING="1" CELLPADDING="2">';
			echo '<tr><td class=rank1>Infelizmente voc� s� est� permitido a efetuar uma contribui��o com a UltraxSoft se aceitar nossas clausulas e regras para este servi�o.</td></tr>';
			echo '</table>';
			echo '<br><a href="?page=contribute.make&step=1"><img src="images/back.gif" border="0"></a>';				
		}
		else
		{
			echo '<br><center><table border="0" width="95%" CELLSPACING="1" CELLPADDING="2">';
			echo 'No Darghos voc� pode fazer uma contribui��o e a recompensa ser ativa para voc� mesmo, ou para um outro jogador (um amigo por exemplo). Selecione abaixo para quem deve ser ativado a recomensa de sua doa��o.';
			echo '</table>';	
			
			echo '<br><form method="post" action="?page=contribute.make&step=3">';
			echo '<br><center><table width="90%" border="0" cellpadding="4" cellspacing="1">';
			echo '<tr class="rank2"><td colspan="2"><b>Conta a receber a Premium Account</td></tr>';
			echo '<tr class="rank1"><td width="20%"><b>Destino</td><td><input type="radio" name="destiny" value="me" style="border: 0;" /> Eu quero adquirir a premium account para minha propria conta<br>
			<input type="radio" name="destiny" value="other" style="border: 0;" /> Eu quero adquirir a premium account para outro jogador.
			</td></tr>';	
			echo '</table>';		
			echo '<br><center><input type="image" value="submit" src="images/continue.gif"/> <a href="?page=contribute.informations"><img src="images/back.gif" border="0"></a>';	
			echo '</form>';
		}
	}	
	elseif($_GET['step'] == '3')
	{
		echo '<tr><td class=newbar><center><b>:: Contribute Step 2 ::</td></tr>
		<tr><td class=newtext>';

		echo '<br><center><table border="0" width="95%" CELLSPACING="1" CELLPADDING="2">';
		echo 'Select bellow the payment form. PagSeguro is only if you live in Brazil. If you live out Brasil select PayPal.';
		echo '</table>';	
		
		echo '<br><form method="post" action="?page=contribute.make&step=4">';
		echo '<br><center><table width="90%" border="0" cellpadding="4" cellspacing="1">';
		echo '<tr class="rank2"><td colspan="2"><b>Payment Form</td></tr>';
		echo '<tr class="rank1"><td width="20%"><b>Form</td><td><input type="radio" name="form" value="pagseguro" style="border: 0;" /> PagSeguro<br>
		<input type="radio" name="form" value="paypal" style="border: 0;" /> PayPal
		</td></tr>';	
		echo '</table>';
		echo '<input type="hidden" name="destiny" value="'.$_POST['destiny'].'">';			
		echo '<br><center><input type="image" value="submit" src="images/continue.gif"/> <a href="?page=contribute.informations"><img src="images/back.gif" border="0"></a>';	
		echo '</form>';
	}	
	elseif($_GET['step'] == '4')
	{
		if($_POST['form'] == "pagseguro")
		{
			if($_POST['destiny'] == "me")
			{
				echo '<tr><td class=newbar><center><b>:: Contribute Step 3 ::</td></tr>
				<tr><td class=newtext>';

				echo '<br><center><table border="0" width="95%" CELLSPACING="1" CELLPADDING="2">';
				echo 'Entre com a senha de sua conta, ela � necesaria para a autentica��o. Depois selecione o modo de ativa��o, e por fim, selecione a dura��o de sua contribui��o e clique no bot�o "Continue".';
				echo '</table>';	
				
				echo '<br><form method="post" action="?page=contribute.make&step=5">';
				echo '<br><center><table width="90%" border="0" cellpadding="4" cellspacing="1">';
				echo '<tr class="rank2"><td colspan="2"><b>Informa��es da Contribui��o</td></tr>';
				echo '<tr class="rank1" width="25%"><td><b>Password</td><td><input name="pass" type="password" value="" class="login"/></td></tr>';	
				echo '<tr class="rank1"><td><b>Ativa��o</td><td><select name="activation"><option value="0">Normal</option></select></td></tr>';	
				echo '<tr class="rank1"><td><b>Dura��o</td><td>
				<input type="radio" name="duration" value="30" style="border: 0;" /> <b>R$ 10,90</b> Contribui��o para 1 m�s (30 dias).<br>
				<input type="radio" name="duration" value="60" style="border: 0;" /> <b>R$ 21,80</b> Contribui��o para 2 m�ses (60 dias).<br>
				<input type="radio" name="duration" value="90" style="border: 0;" /> <b>R$ 32,70</b> Contribui��o para 3 m�ses (90 dias).<br>
				<input type="radio" name="duration" value="180" style="border: 0;" /> <b>R$ 55,90</b> Contribui��o para 6 m�ses (180 dias).<br>
				<input type="radio" name="duration" value="360" style="border: 0;" /> <b>R$ 99,90</b> Contribui��o para 1 ano (360 dias).<br>	</td></tr>';	
				echo '</table>';		
				echo '<input type="hidden" name="destiny" value="'.$_POST['destiny'].'">';	
				echo '<input type="hidden" name="form" value="'.$_POST['form'].'">';	
				echo '<br><center><input type="image" value="submit" src="images/continue.gif"/> <a href="?page=contribute.informations"><img src="images/back.gif" border="0"></a>';	
				echo '</form>';
			}
			elseif($_POST['destiny'] == "other")
			{
				echo '<tr><td class=newbar><center><b>:: Contribute Step 2 ::</td></tr>
				<tr><td class=newtext>';

				echo '<br><center><table border="0" width="95%" CELLSPACING="1" CELLPADDING="2">';
				echo 'Preencha abaixo o seu nome real e um comentario, estes dados ir�o aparecer ao dono da conta quando esta premium account for ser ativada. Ent�o selecione a dura��o que voc� desejar e clique em "Continue".';
				echo '</table>';	
				
				echo '<br><form method="post" action="?page=contribute.make&step=5">';
				echo '<br><center><table width="90%" border="0" cellpadding="4" cellspacing="1">';
				echo '<tr class="rank2"><td colspan="2"><b>Informa��es da Contribui��o</td></tr>';
				echo '<tr class="rank1" width="25%"><td><b>Nome Real</td><td><input name="rl_name" type="text" SIZE=30 MAXLENGTH=50/> <br><font size=1>(seu nome real)</td></tr>';	
				echo '<tr class="rank1" width="25%"><td><b>Comentario</td><td><input name="comment" type="text"  SIZE=45 MAXLENGTH=200/> <br><font size=1>(escreva aqui seu comentario)</td></tr>';	
				echo '<tr class="rank1"><td><b>Nome do Personagem</td><td><input name="name" type="text" value=""/> <br><font size=1>(nome do personagem que deve receber a premium account)</td></tr>';	
				echo '<tr class="rank1"><td><b>Dura��o</td><td>
				<input type="radio" name="duration" value="30" style="border: 0;" /> <b>R$ 10,90</b> Contribui��o para 1 m�s (30 dias).<br>
				<input type="radio" name="duration" value="60" style="border: 0;" /> <b>R$ 21,80</b> Contribui��o para 2 m�ses (60 dias).<br>
				<input type="radio" name="duration" value="90" style="border: 0;" /> <b>R$ 32,70</b> Contribui��o para 3 m�ses (90 dias).<br>
				<input type="radio" name="duration" value="180" style="border: 0;" /> <b>R$ 55,90</b> Contribui��o para 6 m�ses (180 dias).<br>
				<input type="radio" name="duration" value="360" style="border: 0;" /> <b>R$ 99,90</b> Contribui��o para 1 ano (360 dias).<br>	</td></tr>';
				echo '</table>';
				echo '<input type="hidden" name="destiny" value="'.$_POST['destiny'].'">';
				echo '<input type="hidden" name="form" value="'.$_POST['form'].'">';		
				echo '<br><center><input type="image" value="submit" src="images/continue.gif"/> <a href="?page=contribute.informations"><img src="images/back.gif" border="0"></a>';	
				echo '</form>';		
			}
		}
		elseif($_POST['form'] == "paypal")
		{
			if($_POST['destiny'] == "me")
			{
				echo '<tr><td class=newbar><center><b>:: Contribute Step 3 ::</td></tr>
				<tr><td class=newtext>';

				echo '<br><center><table border="0" width="95%" CELLSPACING="1" CELLPADDING="2">';
				echo 'Entre com a senha de sua conta, ela � necesaria para a autentica��o. Depois selecione o modo de ativa��o, e por fim, selecione a dura��o de sua contribui��o e clique no bot�o "Continue".';
				echo '</table>';	
				
				echo '<br><form method="post" action="?page=contribute.make&step=5">';
				echo '<br><center><table width="90%" border="0" cellpadding="4" cellspacing="1">';
				echo '<tr class="rank2"><td colspan="2"><b>Informa��es da Contribui��o</td></tr>';
				echo '<tr class="rank1" width="25%"><td><b>Password</td><td><input name="pass" type="password" value="" class="login"/></td></tr>';	
				echo '<tr class="rank1"><td><b>Activation Mode</td><td><select name="activation"><option value="0">Normal</option></select></td></tr>';	
				echo '<tr class="rank1"><td><b>Duration</td><td>
				<input type="radio" name="duration" value="30" style="border: 0;" /> <b>7.90 USD</b> Contribute for one month (30 days).<br>
				<input type="radio" name="duration" value="60" style="border: 0;" /> <b>15.80 USD</b> Contribute for two months (60 days).<br>
				<input type="radio" name="duration" value="90" style="border: 0;" /> <b>23.70 USD</b> Contribute for three months (90 days).<br>
				<input type="radio" name="duration" value="180" style="border: 0;" /> <b>35.90 USD</b> Contribute for six months (180 days).<br>
				<input type="radio" name="duration" value="360" style="border: 0;" /> <b>62.90 USD</b> Contribute for one year (360 days).<br>		</td></tr>';	
				echo '</table>';		
				echo '<input type="hidden" name="destiny" value="'.$_POST['destiny'].'">';	
				echo '<input type="hidden" name="form" value="'.$_POST['form'].'">';	
				echo '<br><center><input type="image" value="submit" src="images/continue.gif"/> <a href="?page=contribute.informations"><img src="images/back.gif" border="0"></a>';	
				echo '</form>';
			}
			elseif($_POST['destiny'] == "other")
			{
				echo '<tr><td class=newbar><center><b>:: Contribute Step 2 ::</td></tr>
				<tr><td class=newtext>';

				echo '<br><center><table border="0" width="95%" CELLSPACING="1" CELLPADDING="2">';
				echo 'Preencha abaixo o seu nome real e um comentario, estes dados ir�o aparecer ao dono da conta quando esta premium account for ser ativada. Ent�o selecione a dura��o que voc� desejar e clique em "Continue".';
				echo '</table>';	
				
				echo '<br><form method="post" action="?page=contribute.make&step=5">';
				echo '<br><center><table width="90%" border="0" cellpadding="4" cellspacing="1">';
				echo '<tr class="rank2"><td colspan="2"><b>Informa��es da Contribui��o</td></tr>';
				echo '<tr class="rank1" width="25%"><td><b>Nome Real</td><td><input name="rl_name" type="text" SIZE=30 MAXLENGTH=50/> <br><font size=1>(seu nome real)</td></tr>';	
				echo '<tr class="rank1" width="25%"><td><b>Comentario</td><td><input name="comment" type="text"  SIZE=45 MAXLENGTH=200/> <br><font size=1>(escreva aqui seu comentario)</td></tr>';	
				echo '<tr class="rank1"><td><b>Nome do Personagem</td><td><input name="name" type="text" value=""/> <br><font size=1>(nome do personagem que deve receber a premium account)</td></tr>';	
				echo '<tr class="rank1"><td><b>Duration</td><td>
				<input type="radio" name="duration" value="30" style="border: 0;" /> <b>7.90 USD</b> Contribute for one month (30 days).<br>
				<input type="radio" name="duration" value="60" style="border: 0;" /> <b>15.80 USD</b> Contribute for two months (60 days).<br>
				<input type="radio" name="duration" value="90" style="border: 0;" /> <b>23.70 USD</b> Contribute for three months (90 days).<br>
				<input type="radio" name="duration" value="180" style="border: 0;" /> <b>35.90 USD</b> Contribute for six months (180 days).<br>
				<input type="radio" name="duration" value="360" style="border: 0;" /> <b>62.90 USD</b> Contribute for one year (360 days).<br>		</td></tr>';					echo '</table>';
				echo '<input type="hidden" name="destiny" value="'.$_POST['destiny'].'">';	
				echo '<input type="hidden" name="form" value="'.$_POST['form'].'">';		
				echo '<br><center><input type="image" value="submit" src="images/continue.gif"/> <a href="?page=contribute.informations"><img src="images/back.gif" border="0"></a>';	
				echo '</form>';		
			}		
		}
	}
	elseif($_GET['step'] == '5')
	{
		if ($_SERVER['REQUEST_METHOD'] == "POST")
		{
			echo '<tr><td class=newbar><center><b>:: Contribute Step 3 ::</td></tr>
			<tr><td class=newtext>';		
			
			if($_POST['destiny'] == "me")
			{
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
				
				$destiny = "Minha propria conta.";
			}
			else
			{
				if(filtreString($_POST['name'],1) == 0 or filtreString($_POST['rl_name'],1) == 0 or filtreString($_POST['comment'],1) == 0)
				{
					$condition = 'Error';
					$conteudo = 'Character does not exist or uses syntaxes reserved.';		
					$error++;
				}					
				elseif(Player::playerExists($_POST['name']) == 0)
				{
					$condition = 'Error';
					$conteudo = 'This character not exists.';
					$error++;			
				}
				elseif($_POST['rl_name'] == "" or $_POST['comment'] == "")
				{
					$condition = 'Error';
					$conteudo = 'Please, fill all the fields.';
					$error++;					
				}
				
				$destiny = "Conta do personagem ".$_POST['name']."";
			}
			
			if($error == 0)
			{
				if($_POST['form'] == "pagseguro")
				{				
					if($_POST['duration'] == 30)
					{
						$duration = '1 mes (30 dias)';
						$price = 'R$ 10,90';
						$priceValue = 1090;
					}	
					elseif($_POST['duration'] == 60)
					{
						$duration = '2 meses (60 dias)';
						$price = 'R$ 21,80';
						$priceValue = 2180;
					}					
					elseif($_POST['duration'] == 90)
					{
						$duration = '3 meses (90 dias)';
						$price = 'R$ 32,70';
						$priceValue = 3270;
					}	
					elseif($_POST['duration'] == 180)
					{
						$duration = '6 meses (180 dias)';
						$price = 'R$ 55,90';
						$priceValue = 5590;
					}		
					elseif($_POST['duration'] == 360)
					{
						$duration = '1 ano (360 dias)';
						$price = 'R$ 99,90';
						$priceValue = 9990;
					}						
				}
				elseif($_POST['form'] == "paypal")
				{
					if($_POST['duration'] == 30)
					{
						$duration = '1 month (30 days)';
						$price = '7.90 USD';
						$priceValue = "7.90";
					}	
					elseif($_POST['duration'] == 60)
					{
						$duration = '2 months (60 days)';
						$price = '14.80 USD';
						$priceValue = "14.80";
					}						
					elseif($_POST['duration'] == 90)
					{
						$duration = '3 months (90 days)';
						$price = '21.70 USD';
						$priceValue = "21.70";
					}	
					elseif($_POST['duration'] == 180)
					{
						$duration = '6 months (180 days)';
						$price = '35.90 USD';
						$priceValue = "35.90";
					}		
					elseif($_POST['duration'] == 360)
					{
						$duration = '1 year (360 days)';
						$price = '62.90 USD';
						$priceValue = "62.90";
					}						
				}				
				
				if($_POST['activation'] == 0 or $_POST['activation'] == null or $_POST['activation'] == "")
					$activation = 'Normal';
				else
					$activation = 'Instant�nea';

				echo '<br><center><table border="0" width="95%" CELLSPACING="1" CELLPADDING="2">';
				echo 'Leia atentamente os dados abaixos referentes a sua contribui��o, caso tudo esteja correto, clique em "Confirm". Note que ao clicar no bot�o, o pagamento ser� processado imediatamente, portanto somente clique se tiver certeza que est� tudo certo.';
				echo '</table>';	

				echo '<br><center><table width="90%" border="0" cellpadding="4" cellspacing="1">';
				echo '<tr class="rank2"><td colspan="2"><b>Resumo da Contribui��o</td></tr>';
				echo '<tr class="rank1"><td>Destino: <b>'.$destiny.'</b>.<br>
				Tipo de ativa��o: <b>'.$activation.'</b>.<br>
				Dura��o: <b>'.$duration.'</b>.<br>
				Valor total: <b>'.$price.'</b>.
				</td></tr>';	
				echo '</table>';	
				
				if($_POST['form'] == "paypal")
				{
					echo '<form action="https://www.paypal.com/cgi-bin/webscr" method="post">';
					echo '<input type="hidden" name="cmd" value="_xclick">';
					echo '<input type="hidden" name="business" value="premium@darghos.com">';
					echo '<input type="hidden" name="no_shipping" value="0">';
					echo '<input type="hidden" name="no_note" value="1">';
					echo '<input type="hidden" name="currency_code" value="USD">';
					echo '<input type="hidden" name="item_name" value="'.$duration.'">';
					echo '<input type="hidden" name="amount" value="'.$priceValue.'">';
					if($_POST['destiny'] == "me")
						echo '<input type="hidden" name="on0" value="Por: '.$account.'">';
					else
						echo '<input type="hidden" name="on0" value="Por: '.$account.' para: '.$_POST['name'].'">';					
				}
				elseif($_POST['form'] == "pagseguro")
				{
					echo '<form target="pagseguro" action="https://pagseguro.uol.com.br/security/webpagamentos/webpagto.aspx" method="post">';
					echo '<input type="hidden" name="email_cobranca" value="premium@darghos.com">';
					echo '<input type="hidden" name="tipo" value="CP">';
					echo '<input type="hidden" name="moeda" value="BRL">';
					echo '<input type="hidden" name="item_id_1" value="1">';
					echo '<input type="hidden" name="item_descr_1" value="'.$duration.'">';
					echo '<input type="hidden" name="item_quant_1" value="1">';
					echo '<input type="hidden" name="item_valor_1" value="'.$priceValue.'">';
					echo '<input type="hidden" name="item_frete_1" value="000">';		
					if($_POST['destiny'] == "me")
						echo '<input type="hidden" name="ref_transacao" value="Por: '.$account.'">';
					else
						echo '<input type="hidden" name="ref_transacao" value="Por: '.$account.' para: '.$_POST['name'].'">';					
				}
				echo '<br><center><input type="image" value="submit" src="images/confirm.gif"/> <a href="?page=contribute.informations"><img src="images/back.gif" border="0"></a>';	
				echo '</form>';
			}
			else
			{
				echo '<br><center><table width="95%" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
				echo '<tr><td class=rank2>'.$condition.'</td></tr>';
				echo '<tr><td class=rank1>'.$conteudo.'</td></tr>';
				echo '</table>';
				echo '<br><a href="?page=contribute.informations"><img src="'.$back_button.'" border="0"></a>';				
			}
		}
	}
	else
	{
		echo '<tr><td class=newbar><center><b>:: Contribute Step 1 ::</td></tr>
		<tr><td class=newtext>';

		echo '<br><center><table border="0" width="95%" CELLSPACING="1" CELLPADDING="2">';
		echo 'Antes de comprar sua premium account, � necessario ler, e aceitar as clausulas de servi�o listadas abaixo:';
		echo '</table>';	
		
		echo '<br><form method="post" action="?page=contribute.make&step=2">';
		echo '<br><center><table width="90%" border="0" cellpadding="4" cellspacing="1">';
		echo '<tr class="rank2"><td colspan="2"><b>Clausulas e Regras de Contribui��o</td></tr>';
		echo '<tr class="rank1">
				<td width="20%"><b>Aceitando e(ou) efetuando a contribui��o com o servi�o voc� est� de acordo que:</b><br>
				<center>			
	<textarea rows="10" wrap="physical" cols="55" readonly="true">Este � um documento informativo das clausulas e regras referente ao funcionamento, deveres e limita��es entre outros referente aos jogadores contribuintes com o Darghos. Leia abaixo todas clausulas e regras atentamente e, somente no caso de aceitar e seguir respeitando todos os termos, assinalar a caixa "Eu li, e aceito as clausulas e regras de contribui��es." e assim dar continuidade ao sistema de contribui��o.

	1. A estabilidade e mantimento do servidor no ar.
	� A UltraxSoft e(ou) Darghos n�o tem a obriga��o de manter o servidor sempre ligado, podendo o mesmo ser desligado a qualquer momento e por qualquer motivo, sem pr�vio aviso, devolu��o de quantias em dinheiro ou danos morais.

	2. Conectividade.
	� A UltraxSoft e(ou) Darghos n�o s�o respons�veis por qualquer problema de conectividade entre o jogador e o "game-server", tanto por parte do jogador, provedor de internet ou "datacenter" (empresa que hospeda o nosso game-server).

	3. Seguir regras sem exce��es.
	� Caso voc� contribua com o servi�o voc� estar� sujeito a todas as regras do jogo, n�o possuindo nenhum direito ou vantagem extra dentro ou fora do jogo.

	4. Vantagens da contribui��o.
	� Caso voc� contribua com o servi�o, cabe a n�s decidirmos sobre as vantagens recebidas, podendo as mesmas serem retiradas a qualquer momento sem pr�vio aviso nem devolu��o em dinheiro.

	5. Direitos autorais.
	� O Darghos n�o ap�ia a modifica��o de "softwares" sem autoriza��o dos fabricantes, e n�o cobre nenhum tipo de dano a seu computador que os programas podem causar.

	6. Recompensas dentro do jogo.
	� Perdas de itens, contas, ou caracter�sticas de personagens somente ser�o devolvidos se o problema foi de causa interna em nossos "game-servers" e em forma de ponto de restaura��o (a��o que efetua uma volta no tempo todo o servidor para um momento ou dia aonde a problem�tica n�o havia acontecido), e somente caso a UltraxSoft assim julgue necess�rio, perdas causadas por qualqueis outras causas (como problemas de conex�o, desastres naturais, cuidados n�o eficientes com a sua conta (Hacking), entre outros) n�o s�o recompensados de maneira alguma.

	7. Devolu��es e troca de destino de contribui��es.
	� A devolu��o do dinheiro, ou mudan�a da conta na qual o contribuinte ir� receber os benef�cios, s� � ocorrida enquanto o contribuinte n�o aceita a libera��o do servi�o. Caso algum dos recursos seja solicitado pelo contribuinte, a mudan�a de conta para contribui��o tem um prazo de 5 a 30 dias ap�s solicitada para ser conclu�da e a devolu��o do dinheiro em um prazo de 30 a 90 dias ap�s solicitado. 

	IMPORTANTE: Ap�s aceitar o servi�o, receber e come�ar a desfrutar dos beneficio em sua conta os recursos de mudan�a de conta e devolu��o do dinheiro n�o s�o mais poss�veis em hip�tese alguma.

	A mudan�a deste documento pode ser efetuada sem aviso, ou pr�vio aviso, cabendo a voc� se manter atualizado �s regras e ao contrato.</textarea>
				</center><br><br>
				<input type="checkbox" name="agreeClauses" value="true">Eu li, e aceito as clausulas e regras de contribui��es.
				</td>
			</tr>';	
		echo '</table>';		
		echo '<br><center><input type="image" value="submit" src="images/continue.gif"/> <a href="?page=contribute.informations"><img src="images/back.gif" border="0"></a>';	
		echo '</form>';
	}		
}	
?>