<?
echo '<tr><td class=newbar><center><b>:: '.$lang['about_title'].' ::</td></tr>
<tr><td class=newtext>
<center>
<br><table width=95% border=0>
'.obtainText("ABOUT", $lang['lang']).'
</table>
<br>';
if(Account::isAdmin($account))
	echo '<a href="?page=admin.editText&id=1"><img src="images/edit.gif" border="0"></a>';	
?>