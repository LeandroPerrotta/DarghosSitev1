<?
if($engine->accountAccess() >= GROUP_COMMUNITYMANAGER)
{
	echo '<tr><td class=newbar><center><b>:: All to temple ::</td></tr>
	<tr><td class=newtext><center><br>';
	Other::allToTemple();
	echo 'Todos jogadores foram enviados ao templo de sua cidade!';
}	
?>