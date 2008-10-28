<?
if($engine->accountAccess() >= GROUP_GOD)
{
	echo "<tr><td class=newbar><center><b>:: Nova enquete ::</td></tr>
	<tr><td class=newtext><center><br>";
		
	if ($_SERVER['REQUEST_METHOD'] == "POST")
	{
		POLL::createPoll($_POST[detail],$_POST[option_1],$_POST[option_2],$_POST[option_3],$_POST[option_4],$_POST[option_5],$_POST[detail_1],$_POST[detail_2],$_POST[detail_3],$_POST[detail_4],$_POST[detail_5],$_POST[end],$_POST[tittle]);
		
		$stat = 'Enquete criada com sucesso!';
		$msg = 'A sua enquete foi criada com sucesso!';
		
		echo '<center><table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
		echo '<tr><td class=rank2>'.$stat.'</td></tr>';
		echo '<tr><td class=rank1>'.$msg.'';
		echo '</table>';
		echo '<br><a href="?page=account.main"><img src="images/back.gif" border="0"></a>';		
	}

	else
	{	

		echo '<center><table border="0" width="95%" CELLSPACING="1" CELLPADDING="2">
	Campos em branco serão ignorados pela enquete!<br>
	</table><br>';
		echo '<center><table border="0" width="90%" bgcolor="black" CELLSPACING="1" CELLPADDING="4">';
		echo '<form action="?page=admin.newPoll" method="POST">';
		echo '<tr><td width="70%" class=rank1 colspan=3><center>Titulo:<br><TEXTAREA class="login" NAME="tittle" ROWS=2 COLS=45 WRAP="virtual"></textarea></td></tr>';	
		echo '<tr><td width="70%" class=rank1 colspan=3><center>Detalhe da enquete:<br><TEXTAREA class="login" NAME="detail" ROWS=5 COLS=45 WRAP="virtual"></textarea></td></tr>';	
		echo '<tr class=rank1><td>Opção 1:<br><input name="option_1" type="text" value="" class="login" size="25" MAXLENGTH="45"/></td><td>Detalhes:<br><TEXTAREA class="login" NAME="detail_1" ROWS=2 COLS=30 WRAP="virtual"></textarea></td></tr>';
		echo '<tr class=rank1><td>Opção 2:<br><input name="option_2" type="text" value="" class="login" size="25" MAXLENGTH="45"/></td><td>Detalhes:<br><TEXTAREA class="login" NAME="detail_2" ROWS=2 COLS=30 WRAP="virtual"></textarea></td></tr>';
		echo '<tr class=rank1><td>Opção 3:<br><input name="option_3" type="text" value="" class="login" size="25" MAXLENGTH="45"/></td><td>Detalhes:<br><TEXTAREA class="login" NAME="detail_3" ROWS=2 COLS=30 WRAP="virtual"></textarea></td></tr>';
		echo '<tr class=rank1><td>Opção 4:<br><input name="option_4" type="text" value="" class="login" size="25" MAXLENGTH="45"/></td><td>Detalhes:<br><TEXTAREA class="login" NAME="detail_4" ROWS=2 COLS=30 WRAP="virtual"></textarea></td></tr>';
		echo '<tr class=rank1><td>Opção 5:<br><input name="option_5" type="text" value="" class="login" size="25" MAXLENGTH="45"/></td><td>Detalhes:<br><TEXTAREA class="login" NAME="detail_5" ROWS=2 COLS=30 WRAP="virtual"></textarea></td></tr>';	
		echo '<tr><td width="70%" class=rank1 colspan=3>Termino:<br><select name="end" class=login><option value="5">5 dias</option><option value="10">10 dias</option><option value="15">15 dias</option><option value="20">20 dias</option><option value="30">30 dias</option><</select></td></tr>';	
		echo '</table>';
		echo '<br><input type="image" value="submit" src="images/submit.gif"/>';
		echo '</form>';
	}	
}
?>