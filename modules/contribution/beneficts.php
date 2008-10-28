<?
echo '<tr><td class=newbar><center><b>:: '.$lang['contribute_title'].' ::</td></tr>
<tr><td class=newtext><center>
<br><table width="95%" border="0"><tr><td></td><tr>
<center>'.obtainText("CONTRIBUTE_DESC", $lang['lang']).'
</table><center>
<a href="?page=contribute.informations"><img src="images/contribute.gif" border="0"></a><br><br>';
if(Account::isAdmin($account))
	echo '<a href="?page=admin.editText&id=3"><img src="images/edit.gif" border="0"></a>';
?>