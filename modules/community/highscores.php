<?
echo '<tr><td class=newbar><center><b>:: '.$lang['highscores_title'].' ::</td></tr>
<tr><td class=newtext>';

$serverId = 1;

?>
<br>
<center>
<p>
<?
$cfg['rank'] = 100;

if(!isset($_POST['value']))
{
	if(!isset($_SESSION['value']))
		$_POST['value'] = "Level";
	else
		$_POST['value'] = $_SESSION['value'];
}	
	
$_SESSION['value'] = $_POST['value'];
$skill = $_SESSION['value'];

if(!isset($_GET['pg'])) 
{
	$pg = 1;
} 
else 
{
	$pg = $_GET['pg'];
}

if($pg > 5)
{
	$inicio = 5;
}
else
{
	$inicio = $pg - 1;
}

$ini = $inicio * $cfg['rank'];
$prox = $cfg['rank'] * $pg + 1;
$prox_ = $cfg['rank'] * $pg + $cfg['rank'];

if($pg == 2)
{
	$ante = "1-".$cfg['rank'];
}
elseif($pg > 2)
{
	$aa = $pg - 1;
	$b = $pg - 2;
	$a = $cfg['rank'] * $b;
	$ante = $a+'1'."-".$cfg['rank']*$aa;
}
if($pg == 1 or $pg == "")
{
	$asd = " ";
}
else
{
	$asd = " | ";
}

echo '<form action="?page=community.highscores" method="post">
<table width="40%" border="0" cellspacing="1" CELLPADDING="4">
<tr class="rank2"><td>Choose a Skill</td></tr>
<tr class="rank1"><td><select name="value">
<option value="Level">Level</option>
<option value="ExpRook">Level on Rookguard</option>
<option value="Magic">Magic Level</option>
<option value="Fist">First Fighting</option>
<option value="Club">Club Fighting</option>
<option value="Sword">Sword Fighting</option>
<option value="Axe">Axe Fighting</option>
<option value="Distance">Distance Fighting</option>
<option value="Shield">Shield</option>
<option value="Fish">Fishing</option></select><input type="image" value="Entrar" src="images/submit.gif"/>
</td></tr>
</table></form>

<center><font size="4" color="#4F2700"><b>'.$skill.' Top 500</b></font></center><br>


<table width="100%" border="0" cellspacing="1" CELLPADDING="4">
<tr>
<td width="87%" valign="top"><table width="100%" border="0" cellpadding="4" cellspacing="1">
<tr class="rank2">
<td width="10%"><font size=2>'.$lang['rank_number'].'</td>
<td width="40%"><font size=2>'.$lang['name'].'</td>
<td width="20%"><font size=2>'.$lang['level'].'</td>';

				if($skill == "Level" or $skill == "ExpRook")
				{
					echo '<td width="30%"><font size=2>'.$lang['points'].'</td>';
 				}
 				
 	 echo '</tr>';
 
 switch($skill)
{
	case "Fist":
		$id = 0;
		break;
	case "Club":
		$id = 1;
		break;
	case "Sword":
		$id = 2;
		break;
	case "Axe":
		$id = 3;
		break;
	case "Distance":
		$id = 4;
		break;
	case "Shield":
		$id = 5;
		break;
	case "Fish":
		$id = 6;
		break;
 }

if($skill == "Level") 
{
	$total = mysql_query("SELECT * FROM players WHERE server = '$serverId' ORDER BY level");
	$tr = mysql_num_rows($total);
	$tp = $tr / $cfg['rank'];
	$tp = ceil($tp);
	$ant = $pg-1;
	$pro = $pg+1;
	$verifica = mysql_query("SELECT account_id, vocation, name,group_id,level,experience FROM players WHERE group_id < '3' and server = '$serverId' ORDER BY experience DESC LIMIT ".$ini.",".$cfg['rank']."");
	if($pg == 1 or $pg == 0)
	{
		$i = 1;
	}
	elseif($pg > 1)
	{
		$i = $ini+1;
	}
	
	while($dados = mysql_fetch_array($verifica)) 
	{
		if(Account::getType($dados['account_id']) < 3)
		{	
			$t++;
			$style = rotateStyle($t);	
			
			echo ' <tr>
				 <td class="'.$style.'">'.$i.'</center></td>
				 <td class="'.$style.'"><a href="?page=character.details&char='.urlencode($dados['name']).'">'.$dados['name'].'</a><br>'.Tolls::getVocation($dados['vocation']).'</td>
				 <td class="'.$style.'">'.$dados['level'].'</center></td>
				 <td class="'.$style.'">'.$dados['experience'].'</center></td>
				</tr>';
			$i++;
		}	
	}
	
	if($tr > $cfg['rank'])
	{
		echo '<tr class="rank2">
<td colspan=4><div align="right">';
		if($pg > 1)
		{
			$anterior = '<a href="?page=community.highscores&server='.$servername.'&pg='.$ant.'"><font color=white size=2><b>Rank '.$ante.'</a>';
		}
		if($pg != 5)
		{
			if($pg < $tp)
			{
				$proxima = '<a href="?page=community.highscores&server='.$servername.'&pg='.$pro.'"><font color=white size=2><b>Rank '.$prox.'-'.$prox_.'</a>';
				$tt = true;
			}
		}
		
		echo $anterior;
		if($tt == true) echo $asd;
		echo $proxima;
		echo '</div></td><tr>';
	}
}
elseif($skill == "ExpRook") 
{
$total = mysql_query("SELECT * FROM players WHERE server = '$serverId' and vocation = '0' ORDER BY level");
$tr = mysql_num_rows($total);
$tp = $tr / $cfg['rank'];
$tp = ceil($tp);
$ant = $pg-1;
$pro = $pg+1;
$verifica = mysql_query("SELECT account_id, name,group_id,level,experience FROM players WHERE server = '$serverId' and group_id < '3' and vocation = '0' ORDER BY experience DESC LIMIT ".$ini.",".$cfg['rank']."");
if($pg == 1 or $pg == 0){
 $i = 1;
}elseif($pg > 1){
 $i = $ini+1;
}

while($dados = mysql_fetch_array($verifica)) 
{
	if(Account::getType($dados['account_id']) < 3)
	{	
		$t++;
		$style = rotateStyle($t);	
		
 echo ' <tr>
 <td class="'.$style.'">'.$i.'</center></td>
 <td class="'.$style.'"><a href="?page=character.details&char='.urlencode($dados['name']).'">'.$dados['name'].'</a><br>'.Tolls::getVocation($dados['vocation']).'</td>
 <td class="'.$style.'">'.$dados['level'].'</center></td>
		 <td class="'.$style.'">'.$dados['experience'].'</center></td>
</tr>';
$i++;
}
}
if($tr > $cfg['rank']){
 echo '<tr class="rank2">
<td colspan=4><div align="right">';
 if($pg > 1){
$anterior = '<a href="?page=community.highscores&server='.$servername.'&pg='.$ant.'"><font color=white size=2><b>Rank '.$ante.'</a>';
 }
 if($pg != 5){
if($pg < $tp){
 $proxima = '<a href="?page=community.highscores&server='.$servername.'&&pg='.$pro.'"><font color=white size=2><b>Rank '.$prox.'-'.$prox_.'</a>';
 $tt = true;
}
 }
 echo $anterior;
 if($tt == true) echo $asd;
 echo $proxima;
 echo '</div></td><tr>';
}
}
 elseif($skill == "Magic") {
$total = mysql_query("SELECT * FROM players WHERE server = '$serverId' ORDER BY maglevel");
$tr = mysql_num_rows($total);
$tp = $tr / $cfg['rank'];
$tp = ceil($tp);
$ant = $pg-1;
$pro = $pg+1;
$verifica = mysql_query("SELECT account_id, vocation, name,group_id,maglevel FROM players WHERE server = '$serverId' and group_id < '3' ORDER BY maglevel DESC LIMIT ".$ini.",".$cfg['rank']."");
if($pg == 1 or $pg == 0){
 $i = 1;
}elseif($pg > 1){
 $i = $ini+1;
}

while($dados = mysql_fetch_array($verifica)) 
{
	if(Account::getType($dados['account_id']) < 3)
	{	
	$t++;
	$style = rotateStyle($t);	
echo ' <tr>
 <td class="'.$style.'">'.$i.'</center></td>
 <td class="'.$style.'"><a href="?page=character.details&char='.urlencode($dados['name']).'">'.$dados['name'].'</a><br>'.Tolls::getVocation($dados['vocation']).'</td>
 <td class="'.$style.'">'.$dados['maglevel'].'</center></td>
</tr>';
$i++;
}
}
if($tr > $cfg['']){
 echo '<tr class="rank2">
<td colspan=3><div align="right">';
 if($pg > 1){
$anterior = '<a href="?page=community.highscores&server='.$servername.'&pg='.$ant.'"><font color=white size=2><b>Rank '.$ante.'</a>';
 }
 if($pg != 5){
if($pg < $tp){
 $proxima = '<a href="?page=community.highscores&server='.$servername.'&pg='.$pro.'"><font color=white size=2><b>Rank '.$prox.'-'.$prox_.'</a>';
 $tt = true;
}
 }
 echo $anterior;
 if($tt == true) echo $asd;
 echo $proxima;
 echo '</div></td><tr>';
} 
 }
 else {
$total = mysql_query("SELECT name,group_id,value FROM players, player_skills WHERE server = '$serverId' and players.id = player_skills.player_id AND player_skills.skillid = ".$id." ORDER BY value DESC");
$tr = mysql_num_rows($total);
$tp = $tr / $cfg['rank'];
$tp = ceil($tp);
$ant = $pg-1;
$pro = $pg+1;
$verifica = mysql_query("SELECT account_id, vocation, name,group_id,value FROM players, player_skills WHERE server = '$serverId' and group_id < '3' AND players.id = player_skills.player_id AND player_skills.skillid = ".$id." ORDER BY value DESC LIMIT ".$ini.",".$cfg['rank']."");
if($pg == 1 or $pg == 0){
 $i = 1;
}elseif($pg > 1){
 $i = $ini+1;
}

while($dados = mysql_fetch_array($verifica)) 
	{
	if(Account::getType($dados['account_id']) < 3)
	{		
		$t++;
		$style = rotateStyle($t);	
echo ' <tr>
 <td class='.$style.'>'.$i.'</center></td>
 <td class='.$style.'><a href="?page=character.details&char='.urlencode($dados['name']).'">'.$dados['name'].'</a><br>'.Tolls::getVocation($dados['vocation']).'</td>
 <td class='.$style.'>'.$dados['value'].'</center></td>
</tr>';
$i++;
}
}
if($tr > $cfg['rank']){
 echo '<tr class="rank2">
<td colspan=3><div align="right">';
 if($pg > 1){
$anterior = '<a href="?page=community.highscores&server='.$servername.'&pg='.$ant.'"><font color=white size=2><b>Ranks '.$ante.'</a>';
 }
 if($pg != 5){
if($pg < $tp){
 $proxima = '<a href="?page=community.highscores&server='.$servername.'&pg='.$pro.'"><font color=white size=2><b>Ranks '.$prox.'-'.$prox_.'</a>';
 $tt = true;
}
 }
 echo $anterior;
 if($tt == true) echo $asd;
 echo $proxima;
 echo '</div></td><tr>';
} 
 } 

echo'</table></td>
</td>
</tr>
</table>
<br>';
?>