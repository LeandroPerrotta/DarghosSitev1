<?
	echo '<tr><td class=newbar><center><b>:: Contribute ::</td></tr>
	<tr><td class=newtext>';
	
	echo '<br><center><table border="0" width="95%" CELLSPACING="1" CELLPADDING="2">';
	echo 'Aqui você pode contribuir com o Darghos. Quando você contribui, você recebe uma série de beneficios dentro e fora do jogo durante um periodo, para saber mais sobre os beneficios por favor visite a seção <a href="?page=contribute.beneficts">vantagens premium</a>. <br><br>';
	echo '<br><font size=3><b>Preços</b></font>';
	echo '</table>';	
	
	echo '<center><table width="90%" border="0" cellpadding="4" cellspacing="1">';
	echo '<tr class="rank2"><td colspan="3"><b>Contribuições</td></tr>';
	echo '<tr class="rank1"><td><b>Duração</td><td width="45%"><b>PagSeguro</td><td width="25%"><b>PayPal</td></tr>';	
	echo '<tr class="rank3"><td>30 dias</td><td><del>R$ 19,90</del> <b>R$ 10,90</b> <font size=1>(R$ 0,39/dia)</font></td><td>7.90 USD</td></tr>';	
	echo '<tr class="rank1"><td>60 dias <font size="1" color=green><b>(novo!)</b></font></td><td>R$ 21,80 <font size=1>(R$ 0,39/dia)</font></td><td>15.80 USD</td></tr>';	
	echo '<tr class="rank3"><td>90 dias</td><td>R$ 32,70 <font size=1>(R$ 0,39/dia)</font></td><td>23.70 USD</td></tr>';	
	echo '<tr class="rank1"><td>180 dias</td><td><del>R$ 71,90</del> <b>R$ 55,90</b> <font size=1>(R$ 0,31/dia)</font></td><td>35.90 USD</td></tr>';	
	echo '<tr class="rank3"><td>360 dias <font size="1" color=green><b>(novo!)</b></font></td><td>R$ 99,90 <font size=1>(R$ 0,27/dia)</font></td><td>62.90 USD</td></tr>';	
	echo '</table>';
	
	echo '<br><center><table border="0" width="95%" CELLSPACING="1" CELLPADDING="2">';
	echo '<font size=3><b>Metodos de Pagamentos</b></font>';
	echo '<br><br>Nós processamos os pagamentos ultilizando o PagSeguros, esta é uma conceituada, segura e tradicional empresa no setor de pagamentos virtuais a anos, note que a PagSeguro é parte integrande do grupo UOL (Universo Online). Abaixo segue uma pequena instrução de cada método de pagamento (caso ainda tenha duvidas, o PagSeguro tambem possui uma lista de instruções).';
	echo '<br><br><li><b>Boleto Bancário</b></li><br>';
	echo 'Este é o metodo mais simples, e não necessita de ter uma conta em banco. Você séra direcionado para o site do PagSeguro, aonde deve entrar com o sua conta do site deles. Caso você não possua uma conta no PagSeguro, você poderá criar uma na pagina direcionada deles, ou clicando aqui.<br>Então após completar seu pagamento, será gerado um boleto. É só imprimir-lo ou anotar a linha digitável e pagar em qualquer fila de caixa de banco ou lotérica (caixas eletronicos não são validos), ou ainda no site do seu banco. O pagamento será efetivado no proximo dia útil seguinte no metodo convencional.';
	echo '<br><br><li><b>Transferencia Eletronica</b> - validação do pagamento online (instantânea)</li><br>';
	echo 'Na tela "Formas de Pagamento" selecione o banco em que você tem conta corrente, e clique em "continuar". O valor total de sua compra aparecerá em uma tela de confirmação, clique em continuar e você será redirecionado ao site do banco escolhido para finalizar o pagamento. Após entrar no banco com seus dados e senhas, ao concluir o processo a validação e autorização dos pagamentos através dos bancos é on-line e instantânea, ou seja, é realizada e liberada em tempo real.';
	echo '<br><br><big><b><font color="red">Atenção:</font></b></big> Todo processo de contribuição deve ser feito seguindo rigorosamente as instruções do passo a passo (inclusive as instruções do site do PagSeguro). Nós não possuimos formas de pagamento convencionais, como <b><font color="red">deposito direto em conta</b></font>. O não cumprimento de qualquer etapa, ou qualquer tentativa de pagamento diferente das informadas acima resultará em <b><font color="red">não validação do pagamento</b></font>, <b><font color="red">sem opção de reembolso</b></font>. Em caso de qualquer sombra duvida entre em contato conosco ou solicite orientação de seu responsavel.';
	echo '<br><br>Caso você possua alguma duvida, ainda pode tentar exclarece-la em nosso <a href="?page=faq">FAQ</a> ou ainda em nosso email de suporte sobre duvidas em contribuições <a href="mailto:premium@darghos.com">premium@darghos.com</a>.';

	echo '<br><br>Caso você deseje prosseguir em sua contribuição, por favor clique em "Continue" para avançar ao proximo passo (login necessario).';
	
	if (!Account::isLogged($account,$password))
		echo '<br><br><a href="?page=account.login"><img src="images/login.gif" border="0"></a>';
	else		
	echo '<br><br><center><a href="?page=contribute.make"><img src="images/continue.gif" border="0"></a>';
	echo '</table><br>';
?>