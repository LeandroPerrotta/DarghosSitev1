<?
echo '<tr><td class=newbar><center><b>:: '.$lang['support_title'].' ::</td></tr>
<tr><td class=newtext><br>';
echo '<center><table width=95% border=0>';
echo ''.obtainText("SUPPORT_DESC", $lang['lang']).'';
echo '</table>';

$getAdminquery = mysql_query("SELECT * FROM `players` WHERE `group_id` = '6' ORDER BY name asc") or die(mysql_error());
echo '<br><center><table width="85%" border="0" bgcolor="black" cellpadding="2" cellspacing="1">';
echo '<tr class="rank2"><td colspan="3"><b>'.$lang['administrator'].'</td></tr>';
echo '<tr class="rank3"><td><b>'.$lang['member_name'].':</td><td width="15%"></td></tr>';

while($fetch = mysql_fetch_object($getAdminquery))
{
	if (Player::isOnline($fetch->name))
		$status = '<font color="green"><b>Online</b></font>';
	else
		$status = null;
	echo '<tr class="rank1"><td><a href="?page=character.details&char='.$fetch->name.'">'.$fetch->name.'</a></td><td>'.$status.'</td></tr>';
}

echo '</table>';		

$getCMquery = mysql_query("SELECT * FROM `players` WHERE `group_id` = '5' ORDER BY name asc") or die(mysql_error());
echo '<br><center><table width="85%" border="0" bgcolor="black" cellpadding="2" cellspacing="1">';
echo '<tr class="rank2"><td colspan="3"><b>'.$lang['community_manager'].'</td></tr>';
echo '<tr class="rank3"><td><b>'.$lang['member_name'].':</td><td width="15%"></td></tr>';

while($fetch = mysql_fetch_object($getCMquery))
{
	if (Player::isOnline($fetch->name))
		$status = '<font color="green"><b>Online</b></font>';
	else
		$status = null;
	echo '<tr class="rank1"><td><a href="?page=character.details&char='.$fetch->name.'">'.$fetch->name.'</a></td><td>'.$status.'</td></tr>';
}

echo '</table>';	

$getGMquery = mysql_query("SELECT * FROM `players` WHERE `group_id` = '4' ORDER BY name asc") or die(mysql_error());
echo '<br><center><table width="85%" border="0" bgcolor="black" cellpadding="2" cellspacing="1">';
echo '<tr class="rank2"><td colspan="3"><b>'.$lang['game_master'].':</td></tr>';
echo '<tr class="rank3"><td><b>'.$lang['member_name'].':</td><td width="15%"></td></tr>';

while($fetch = mysql_fetch_object($getGMquery))
{
	if (Player::isOnline($fetch->name))
		$status = '<font color="green"><b>Online</b></font>';
	else
		$status = null;
	echo '<tr class="rank1"><td><a href="?page=character.details&char='.$fetch->name.'">'.$fetch->name.'</a></td><td>'.$status.'</td></tr>';
}

echo '</table>';
if(Account::isCM($account) or Account::isAdmin($account))
	echo '<br><a href="?page=admin.newMember"><img src="images/newMember.gif" border="0"></a>';	
?>