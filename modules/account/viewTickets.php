<?
if(SHOW_TICKETS == 1)
{
	$DB->query("SELECT * FROM site.account_tickets WHERE account_id = '".$_SESSION['account']."' ORDER by date DESC");

	echo '
	<tr><td class=newbar><center><b>:: Meus Bilhetes ::</td></tr>
	<tr><td class=newtext><br>

	<center>
	<table border="0" width="95%" CELLSPACING="1" CELLPADDING="2">
	Abaixo você pode obter informações de todos bilhetes de sua conta, como a chave de identificação, que é o elemento que será ultilizado para identificar o ganhador do sorteio.<br><br>
	</table>


	<table width="95%" BORDER="0" CELLSPACING="1" CELLPADDING="4">
		<tr>
			<td class="rank2" colspan="2">Lista de bilhetes</td>
		</tr>
		<tr>
			<td class="rank1" width="70%"><b>Chave de Identificação</td>
			<td class="rank1" width="30%"><b>Gerada em</td>
		</tr>';
		
	if($DB->num_rows() != 0)	
	{
		while($fetch = $DB->fetch())	
		{
		echo '<tr>
				<td class="rank3" width="25%">'.$fetch->key.'</td>
				<td class="rank3" width="75%">'.date('M d Y, H:i:s', $fetch->date).'</td>
			</tr>';
		}	
	}
	else
	{
	echo '<tr>
			<td colspan="2" class="rank3" width="25%">Você ainda não obteve um bilhete.</td>
		</tr>';	
	}
		
	echo '</table>
	<br>';
	if(SHOW_BUYTICKET == 1)
	{
		echo '<a href="?page=account.getTickets"><img src="images/getTicket.gif" border="0"></a>
		<br>';	
	}
}
?>