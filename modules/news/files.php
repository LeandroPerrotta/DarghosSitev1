<?
echo '<tr><td class=newbar><center><b>:: '.$lang['newsarchive_title'].' ::</td></tr>
<tr><td class=newtext><br>';

$news= trim($_REQUEST['shownew']);

if($news)
{
	$getNews = mysql_query("SELECT * FROM `news` WHERE (`ID` = '$news')");
	$fetch_news = mysql_fetch_object($getNews);

	if($fetch_news->ID < 255)
		$post = nl2br($fetch_news->post);
	else	
		$post = $fetch_news->post;
	
	echo '<TABLE CELLSPACING=0 CELLPADDING="4" BORDER=0 WIDTH=95% align=center>
	<tr><td class=newtittle width="20%"><font size=1>'.date('d/m/Y',$fetch_news->post_data).'</font> - <b>'.$fetch_news->post_title.'</b></td></tr>
	<tr><td colspan=2><br><font size=2>'.$post.'</td></tr>
	</table>';	
	
	if(Account::isAdmin($account))
		echo '<br><center><a href="?page=admin.newsManager&edit='.$fetch_news->id.'"><img src="'.$imagedir.'edit.gif" border="0"></a> <a href="?page=admin.newsManager&del='.$fetch_news->ID.'"><img src="'.$imagedir.'del.gif" border="0"></a>';	
	
}	
else
{
	if(Account::isAdmin($account))
		$getNews = mysql_query("SELECT * FROM `news` order by post_data desc");
	else
		$getNews = mysql_query("SELECT * FROM `news` WHERE new_status = 0 order by post_data desc");
		
	echo '<center><table border="0" width="95%" CELLSPACING="1" CELLPADDING="4">';
	echo ''.obtainText("NEWSARCHIVE_DESC", $lang['lang']).'';
	echo '</table><br>';		
	echo '<center><table width="95%" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
	echo '<tr class=rank2><td colspan="2">'.$lang['newsarchive'].'</td></tr>';
	echo '<tr class=rank3><td><b>'.$lang['title'].'</td><td><b>'.$lang['date'].'</td></tr>';
	
	
	while($fetch_news = mysql_fetch_array($getNews)	)
	{
		$t++;
		$style = rotateStyle($t);			
		
		echo '<tr class='.$style.'><td><a href="?page=news.files&shownew='.$fetch_news['id'].'">'.$fetch_news['post_title'].'</a></td><td>'.date('d/m/Y',$fetch_news['post_data']).'</td></tr>';
	}
	echo '</table><br>';
}
?>