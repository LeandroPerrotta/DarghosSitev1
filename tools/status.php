<?
class Status
{
	public function updateViews()
	{
		$query = mysql_query("SELECT * FROM `status`") or die(mysql_error());
		$fetch = mysql_fetch_object($query);
		$newpv = $fetch->pageviews;
		$newpv++;
		mysql_query("UPDATE status SET pageviews = '$newpv'") or die(mysql_error());	
	}
}
?>