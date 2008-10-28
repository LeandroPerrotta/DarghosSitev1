<?
$editbutton = '<img src="'.$imagedir.'login.gif" border="0">';
if (!isset($_SESSION['account']))
{ ?>
<tr><td class=newbar><center><b>:: Login ::</td></tr>
<tr><td class=newtext>	
<form action="login.php" method="post">

<br><center><table border="0" width="95%" CELLSPACING="1" CELLPADDING="2">
Please enter your account number and password.<br>
If you don't have an account, you can create an account clicking <a href="?page=account.register">here</a>.<br>
</table>

<br><center><table width="95%" BORDER="0" CELLSPACING="1" CELLPADDING="4">
<tr><td class=rank2 colspan=2>Account Login</td></tr>
<tr class=rank3><td width="25%"><b>Account Number</td><td width="75%"><input class="login" name="account" type="password" value="" class="login" size="10"/></td></tr>
<tr class=rank3><td width="25%"><b>Password</td><td width="75%"><input class="login" name="password" type="password" value="" class="login"/></td></tr>
</table>
<br />
<input type="image" value="Entrar" src="images/login.gif">
</form>
<? 

}
else
{
	echo '<META HTTP-EQUIV="Refresh" CONTENT="3; URL=index.php?page=account.maiin">';
}	
?>	