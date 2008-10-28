<?
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
?>