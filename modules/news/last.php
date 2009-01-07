<?
echo'<center>
<tr><td class=newbar><center><b>:: '.$lang['news_title'].' ::</td></tr>
<tr><td class=newtext><center>
<script type="text/javascript" src="functions.js"></script>';
	
	$query = $db_mysql->query('SELECT * FROM fastnews ORDER BY date DESC LIMIT 5');
	$number_of_tickers = 0;
	
	while($ticker = $query->fetch()) 
	{
		if(is_int($number_of_tickers / 2)) 
		{
			$class = "rank1";
		}
		else
		{
			$class = "rank3";
		}
			
		$tickers_to_add .= '
		<tr id="TickerEntry-'.$number_of_tickers.'" class="'.$class.'" onclick=\'TickerAction("TickerEntry-'.$number_of_tickers.'")\'>
		<td>
		
		<div id="TickerEntry-'.$number_of_tickers.'-ShortText">
		<img onclick="TickerAction("TickerEntry-'.$number_of_tickers.'")" src="images/plus.gif">
		<b>'.date("j M Y", $ticker->date).' -</b> '.stripslashes(short_text($ticker->new_br, 60)).'</div>
		
		<div id="TickerEntry-'.$number_of_tickers.'-FullText" style="display:none;">				
		<img onclick="TickerAction("TickerEntry-'.$number_of_tickers.'")" src="images/minus.gif">
		<b>'.date("j M Y", $ticker->date).' -</b> '.stripslashes($ticker->new_br).'</div></td></tr>';
		
		$number_of_tickers++;
	}
	
	echo '<br><table width="95%" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
	echo '<tr id="newsticker" class="rank2"><td>News Ticker</td></tr>';
	echo ''.$tickers_to_add.'';
	echo '</table><br>';
	
	$bannerChance = rand(1, 200000);
	
	if($bannerChance < 200000)
		echo '<a href="?page=contribute.beneficts"><img border=0 src="images/others/premium.gif"></a>';
	else	
		echo '<a href="?page=account.getTickets"><img border=0 src="images/others/tickets.gif"></a>';
		
	$query = $db_mysql->query("SELECT * FROM news ORDER by date DESC LIMIT 2");
	while($post_fetch = $query->fetch())
	{
	
	$date = date("j/m/Y", ($post_fetch->date + 3600 * $Timezone));
	if($info->ID < 255)
		$post = nl2br($post_fetch->post);
	else	
		$post = $post_fetch->post;

	echo '<br><br><TABLE CELLSPACING=0 CELLPADDING=2 BORDER=0 WIDTH=95% align=center>
	<tr><td class=newtittle width="20%"><font size=1>'.$date.'</font> - <b>'.$post_fetch->title.'</b></td></tr>
	<tr class=table><td colspan=2><br><font size=2>';
$ads = false;	
if(rand(1, 100000) < 250)
{	
	$ads = true;
echo '<center><script type="text/javascript"><!--
google_ad_client = "pub-1060239820601185";
/* 468x60, criado 20/02/08 */
google_ad_slot = "6415369621";
google_ad_width = 468;
google_ad_height = 60;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script></center>';
}
	
echo ''.$post_fetch->post.'';

if(rand(1,100) < 15 and !$ads)
{	
echo '<center><script type="text/javascript"><!--
google_ad_client = "pub-1060239820601185";
/* 468x60, criado 20/02/08 */
google_ad_slot = "6415369621";
google_ad_width = 468;
google_ad_height = 60;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script></center><br>';
}
	echo '</td></tr>
	</table>';
	}

//Status::updateViews();
Agendamentos::changeAllEmail();
Agendamentos::guildsClear();
Agendamentos::deletePlayers();
Agendamentos::changeScreenshot();	
?>