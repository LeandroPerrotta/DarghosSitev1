<?
	echo '<tr><td class=newbar><center><b>:: Contribute ::</td></tr>
	<tr><td class=newtext>';
	
	echo '<br><center><table border="0" width="95%" CELLSPACING="1" CELLPADDING="2">';
	echo 'Aqui voc� pode contribuir com o Darghos. Quando voc� contribui, voc� recebe uma s�rie de beneficios dentro e fora do jogo durante um periodo, para saber mais sobre os beneficios por favor visite a se��o <a href="?page=contribute.beneficts">vantagens premium</a>. <br><br>';
	echo '<br><font size=3><b>Pre�os</b></font>';
	echo '</table>';	
	
	echo '<center><table width="90%" border="0" cellpadding="4" cellspacing="1">';
	echo '<tr class="rank2"><td colspan="3"><b>Contribui��es</td></tr>';
	echo '<tr class="rank1"><td><b>Dura��o</td><td width="45%"><b>PagSeguro</td><td width="25%"><b>PayPal</td></tr>';	
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
	echo '<br><br>Caso voc� possua alguma duvida, ainda pode tentar exclarece-la em nosso <a href="?page=faq">FAQ</a> ou ainda em nosso email de suporte sobre duvidas em contribui��es <a href="mailto:premium@darghos.com">premium@darghos.com</a>.';

	echo '<br><br>Caso voc� deseje prosseguir em sua contribui��o, por favor clique em "Continue" para avan�ar ao proximo passo (login necessario).';
	
	if (!Account::isLogged($account,$password))
		echo '<br><br><a href="?page=account.login"><img src="images/login.gif" border="0"></a>';
	else		
	echo '<br><br><center><a href="?page=contribute.make"><img src="images/continue.gif" border="0"></a>';
	echo '</table><br>';
?>