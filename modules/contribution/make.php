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
			echo '<tr><td class=rank2>Clausulas e Regras de Contribuição</td></tr>';
			echo '</table>';
			echo '<center><table border="0" width="95%" CELLSPACING="1" CELLPADDING="2">';
			echo '<tr><td class=rank1>Infelizmente você só está permitido a efetuar uma contribuição com a UltraxSoft se aceitar nossas clausulas e regras para este serviço.</td></tr>';
			echo '</table>';
			echo '<br><a href="?page=contribute.make&step=1"><img src="images/back.gif" border="0"></a>';				
		}
		else
		{
			echo '<br><center><table border="0" width="95%" CELLSPACING="1" CELLPADDING="2">';
			echo 'No Darghos você pode fazer uma contribuição e a recompensa ser ativa para você mesmo, ou para um outro jogador (um amigo por exemplo). Selecione abaixo para quem deve ser ativado a recomensa de sua doação.';
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
				echo 'Entre com a senha de sua conta, ela é necesaria para a autenticação. Depois selecione o modo de ativação, e por fim, selecione a duração de sua contribuição e clique no botão "Continue".';
				echo '</table>';	
				
				echo '<br><form method="post" action="?page=contribute.make&step=5">';
				echo '<br><center><table width="90%" border="0" cellpadding="4" cellspacing="1">';
				echo '<tr class="rank2"><td colspan="2"><b>Informações da Contribuição</td></tr>';
				echo '<tr class="rank1" width="25%"><td><b>Password</td><td><input name="pass" type="password" value="" class="login"/></td></tr>';	
				echo '<tr class="rank1"><td><b>Ativação</td><td><select name="activation"><option value="0">Normal</option></select></td></tr>';	
				echo '<tr class="rank1"><td><b>Duração</td><td>
				<input type="radio" name="duration" value="30" style="border: 0;" /> <b>R$ 10,90</b> Contribuição para 1 mês (30 dias).<br>
				<input type="radio" name="duration" value="60" style="border: 0;" /> <b>R$ 21,80</b> Contribuição para 2 mêses (60 dias).<br>
				<input type="radio" name="duration" value="90" style="border: 0;" /> <b>R$ 32,70</b> Contribuição para 3 mêses (90 dias).<br>
				<input type="radio" name="duration" value="180" style="border: 0;" /> <b>R$ 55,90</b> Contribuição para 6 mêses (180 dias).<br>
				<input type="radio" name="duration" value="360" style="border: 0;" /> <b>R$ 99,90</b> Contribuição para 1 ano (360 dias).<br>	</td></tr>';	
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
				echo 'Preencha abaixo o seu nome real e um comentario, estes dados irão aparecer ao dono da conta quando esta premium account for ser ativada. Então selecione a duração que você desejar e clique em "Continue".';
				echo '</table>';	
				
				echo '<br><form method="post" action="?page=contribute.make&step=5">';
				echo '<br><center><table width="90%" border="0" cellpadding="4" cellspacing="1">';
				echo '<tr class="rank2"><td colspan="2"><b>Informações da Contribuição</td></tr>';
				echo '<tr class="rank1" width="25%"><td><b>Nome Real</td><td><input name="rl_name" type="text" SIZE=30 MAXLENGTH=50/> <br><font size=1>(seu nome real)</td></tr>';	
				echo '<tr class="rank1" width="25%"><td><b>Comentario</td><td><input name="comment" type="text"  SIZE=45 MAXLENGTH=200/> <br><font size=1>(escreva aqui seu comentario)</td></tr>';	
				echo '<tr class="rank1"><td><b>Nome do Personagem</td><td><input name="name" type="text" value=""/> <br><font size=1>(nome do personagem que deve receber a premium account)</td></tr>';	
				echo '<tr class="rank1"><td><b>Duração</td><td>
				<input type="radio" name="duration" value="30" style="border: 0;" /> <b>R$ 10,90</b> Contribuição para 1 mês (30 dias).<br>
				<input type="radio" name="duration" value="60" style="border: 0;" /> <b>R$ 21,80</b> Contribuição para 2 mêses (60 dias).<br>
				<input type="radio" name="duration" value="90" style="border: 0;" /> <b>R$ 32,70</b> Contribuição para 3 mêses (90 dias).<br>
				<input type="radio" name="duration" value="180" style="border: 0;" /> <b>R$ 55,90</b> Contribuição para 6 mêses (180 dias).<br>
				<input type="radio" name="duration" value="360" style="border: 0;" /> <b>R$ 99,90</b> Contribuição para 1 ano (360 dias).<br>	</td></tr>';
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
				echo 'Entre com a senha de sua conta, ela é necesaria para a autenticação. Depois selecione o modo de ativação, e por fim, selecione a duração de sua contribuição e clique no botão "Continue".';
				echo '</table>';	
				
				echo '<br><form method="post" action="?page=contribute.make&step=5">';
				echo '<br><center><table width="90%" border="0" cellpadding="4" cellspacing="1">';
				echo '<tr class="rank2"><td colspan="2"><b>Informações da Contribuição</td></tr>';
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
				echo 'Preencha abaixo o seu nome real e um comentario, estes dados irão aparecer ao dono da conta quando esta premium account for ser ativada. Então selecione a duração que você desejar e clique em "Continue".';
				echo '</table>';	
				
				echo '<br><form method="post" action="?page=contribute.make&step=5">';
				echo '<br><center><table width="90%" border="0" cellpadding="4" cellspacing="1">';
				echo '<tr class="rank2"><td colspan="2"><b>Informações da Contribuição</td></tr>';
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
					$activation = 'Instantânea';

				echo '<br><center><table border="0" width="95%" CELLSPACING="1" CELLPADDING="2">';
				echo 'Leia atentamente os dados abaixos referentes a sua contribuição, caso tudo esteja correto, clique em "Confirm". Note que ao clicar no botão, o pagamento será processado imediatamente, portanto somente clique se tiver certeza que está tudo certo.';
				echo '</table>';	

				echo '<br><center><table width="90%" border="0" cellpadding="4" cellspacing="1">';
				echo '<tr class="rank2"><td colspan="2"><b>Resumo da Contribuição</td></tr>';
				echo '<tr class="rank1"><td>Destino: <b>'.$destiny.'</b>.<br>
				Tipo de ativação: <b>'.$activation.'</b>.<br>
				Duração: <b>'.$duration.'</b>.<br>
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
		echo 'Antes de comprar sua premium account, é necessario ler, e aceitar as clausulas de serviço listadas abaixo:';
		echo '</table>';	
		
		echo '<br><form method="post" action="?page=contribute.make&step=2">';
		echo '<br><center><table width="90%" border="0" cellpadding="4" cellspacing="1">';
		echo '<tr class="rank2"><td colspan="2"><b>Clausulas e Regras de Contribuição</td></tr>';
		echo '<tr class="rank1">
				<td width="20%"><b>Aceitando e(ou) efetuando a contribuição com o serviço você está de acordo que:</b><br>
				<center>			
	<textarea rows="10" wrap="physical" cols="55" readonly="true">Este é um documento informativo das clausulas e regras referente ao funcionamento, deveres e limitações entre outros referente aos jogadores contribuintes com o Darghos. Leia abaixo todas clausulas e regras atentamente e, somente no caso de aceitar e seguir respeitando todos os termos, assinalar a caixa "Eu li, e aceito as clausulas e regras de contribuições." e assim dar continuidade ao sistema de contribuição.

	1. A estabilidade e mantimento do servidor no ar.
	• A UltraxSoft e(ou) Darghos não tem a obrigação de manter o servidor sempre ligado, podendo o mesmo ser desligado a qualquer momento e por qualquer motivo, sem prévio aviso, devolução de quantias em dinheiro ou danos morais.

	2. Conectividade.
	• A UltraxSoft e(ou) Darghos não são responsáveis por qualquer problema de conectividade entre o jogador e o "game-server", tanto por parte do jogador, provedor de internet ou "datacenter" (empresa que hospeda o nosso game-server).

	3. Seguir regras sem exceções.
	• Caso você contribua com o serviço você estará sujeito a todas as regras do jogo, não possuindo nenhum direito ou vantagem extra dentro ou fora do jogo.

	4. Vantagens da contribuição.
	• Caso você contribua com o serviço, cabe a nós decidirmos sobre as vantagens recebidas, podendo as mesmas serem retiradas a qualquer momento sem prévio aviso nem devolução em dinheiro.

	5. Direitos autorais.
	• O Darghos não apóia a modificação de "softwares" sem autorização dos fabricantes, e não cobre nenhum tipo de dano a seu computador que os programas podem causar.

	6. Recompensas dentro do jogo.
	• Perdas de itens, contas, ou características de personagens somente serão devolvidos se o problema foi de causa interna em nossos "game-servers" e em forma de ponto de restauração (ação que efetua uma volta no tempo todo o servidor para um momento ou dia aonde a problemática não havia acontecido), e somente caso a UltraxSoft assim julgue necessário, perdas causadas por qualqueis outras causas (como problemas de conexão, desastres naturais, cuidados não eficientes com a sua conta (Hacking), entre outros) não são recompensados de maneira alguma.

	7. Devoluções e troca de destino de contribuições.
	• A devolução do dinheiro, ou mudança da conta na qual o contribuinte irá receber os benefícios, só é ocorrida enquanto o contribuinte não aceita a liberação do serviço. Caso algum dos recursos seja solicitado pelo contribuinte, a mudança de conta para contribuição tem um prazo de 5 a 30 dias após solicitada para ser concluída e a devolução do dinheiro em um prazo de 30 a 90 dias após solicitado. 

	IMPORTANTE: Após aceitar o serviço, receber e começar a desfrutar dos beneficio em sua conta os recursos de mudança de conta e devolução do dinheiro não são mais possíveis em hipótese alguma.

	A mudança deste documento pode ser efetuada sem aviso, ou prévio aviso, cabendo a você se manter atualizado às regras e ao contrato.</textarea>
				</center><br><br>
				<input type="checkbox" name="agreeClauses" value="true">Eu li, e aceito as clausulas e regras de contribuições.
				</td>
			</tr>';	
		echo '</table>';		
		echo '<br><center><input type="image" value="submit" src="images/continue.gif"/> <a href="?page=contribute.informations"><img src="images/back.gif" border="0"></a>';	
		echo '</form>';
	}		
}	
?>