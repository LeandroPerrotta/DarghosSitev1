<?
class Status
{
	/*private $data = array(
		'status' => null,
		'players' => null,
		'monsters' => null,
		'uptime' => null,
		'record' => null,
		'recordIn' => null,
		'server_ip' => null,
		'server_port' => null,
		'lastUpdate' => null,
	);

	public function __construct()
	{	
		$this->DB = DB::getInstance();
	}	
	
	function updateViews()
	{
		$query = mysql_query("SELECT * FROM `status`") or die(mysql_error());
		$fetch = mysql_fetch_object($query);
		$newpv = $fetch->pageviews;
		$newpv++;
		mysql_query("UPDATE status SET pageviews = '$newpv'") or die(mysql_error());	
	}
	
	function load($server_id)
	{
		$this->DB->query("SELECT status, players, monsters, uptime, record, recordIn, server_ip, server_port, lastUpdate FROM site.server_status WHERE server_id = ".$server_id."");
		
		$fetch = $this->DB->fetch();
		
		$this->data['status'] = $fetch->status;
		$this->data['players'] = $fetch->players;
		$this->data['monsters'] = $fetch->monsters;
		$this->data['uptime'] = $fetch->uptime;
		$this->data['record'] = $fetch->record;
		$this->data['recordIn'] = $fetch->recordIn;
		$this->data['server_ip'] = $fetch->server_ip;
		$this->data['server_port'] = $fetch->server_port;
		$this->data['lastUpdate'] = $fetch->lastUpdate;
	}
	
	function save()
	{
		$query = "UPDATE site.server_status SET ";
		
		if($this->data['status'] != null)
			$query .= "status = ".$this->data['status'].",";

		if($this->data['players'] != null)
			$query .= "players = '".$this->data['players']."',";
			
		if($this->data['monsters'] != null)
			$query .= "monsters = '".$this->data['monsters']."',";	

		if($this->data['uptime'] != null)
			$query .= "uptime = '".$this->data['uptime']."',";		

		if($this->data['record'] != null)
			$query .= "record = '".$this->data['record']."',";	

		if($this->data['record'] != null)
			$query .= "record = '".$this->data['record']."',";						
		
		$this->DB->query("UPDATE site.server_status SET")
	}
	
	function getInfo($data)
	{
		return $this->data[$data];
	}
	
	function setInfo($data, $value)
	{
		$this->data[$data] = $value;
	}*/
}
?>