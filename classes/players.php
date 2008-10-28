<?
class Players
{
	private $data = array();
	
	public function __construct()
	{	
		$this->DB = Database::getInstance();
	}	
	
	function loadByName($name)
	{
		$this->DB->query("SELECT id, account_id FROM players WHERE name = '".$name."'");
		
		if($this->DB->num_rows() != 0)
		{
			$fetch = $this->DB->fetch();
			
			$this->data['account_id'] = $fetch->account_id;
			
			return true;
		}
		else
			return false;
	}
	
	function getData($data)
	{
		return $this->data[$data];
	}
	
	function setData($data, $value)
	{
		$this->data[$data] = $value;
	}
	
	function setLook($lookname = "default")
	{
		switch($this->data['sex'])
		{
			case $GLOBALS['g_genre']['female']:
				$looktype = 136;
			break;	
			
			case $GLOBALS['g_genre']['male']:
				$looktype = 128;
			break;				
		}
	
		switch($lookname) 
		{
			case 'default': 
				$look = array(
					'lookbody' => 116,
					'lookfeet' => 116,
					'lookhead' => 116,
					'looklegs' => 116,
					'looktype' => $looktype,
				); 
			break;	
		}
	
		$this->data['lookbody'] = $look['lookbody'];
		$this->data['lookfeet'] = $look['lookfeet'];
		$this->data['lookhead'] = $look['lookhead'];
		$this->data['looklegs'] = $look['looklegs'];
		$this->data['looktype'] = $look['looktype'];
	}

	function getPlayerId()
	{	
		$this->DB->query("SELECT id FROM players WHERE name = '".$this->data['name']."'");
		$fetch = $this->DB->fetch();
		
		$this->data['id'] = $fetch->id;
		return $fetch->id;
	}	
	
	function saveNew()
	{	
		//Insere o personagem na DB do mundo escolhido
		$this->DB->query("INSERT INTO `players`(`name`,`account_id`,`sex`,`vocation`,`experience`,`level`,`health`,`healthmax`,`mana`,`manamax`, `lookbody`,`lookfeet`,`lookhead`,`looklegs`,`looktype`,`cap`,`town_id`,`created`) VALUES('".$this->data['name']."','".$this->data['account_id']."','".$this->data['sex']."','".$this->data['vocation']."','".$this->data['experience']."','".$this->data['level']."','".$this->data['health']."','".$this->data['healthmax']."','".$this->data['mana']."','".$this->data['manamax']."','".$this->data['lookbody']."','".$this->data['lookfeet']."',".$this->data['lookhead'].",'".$this->data['looklegs']."','".$this->data['looktype']."','".$this->data['cap']."','".$this->data['town_id']."','".$this->data['created']."')");
	}

	function addItem($slot, $slot_pid, $itemid, $count) 
	{	
		$this->DB->query("INSERT INTO `player_items` VALUES ('".$this->data['id']."', '".$slot_pid."', '".$slot."', '".$itemid."', '".$count."', '', '', '0')");
	}	
}
?>