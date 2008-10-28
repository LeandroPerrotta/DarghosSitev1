<?
class Database
{
	private $query_temp, $query_error;
	
	public static $instance;
	
	public function query($sql, $link = 'site')
	{			
		/*	$this->query_temp = mysql_query($sql, $GLOBALS['g_linkResource'][$link]);	*/
		$this->query_temp = mysql_query($sql);
		
		if(!$this->query_temp)
		{
			echo "".mysql_errno().mysql_error()."";
		}
	}	
	
	public static function getInstance() 
	{
		if(self::$instance == null) 
		{
			self::$instance = new Database();
		}
		
		return self::$instance;
	}	

	public function fetch()
	{
		return ($this->query_temp) ? @mysql_fetch_object($this->query_temp) : false;
	}	
	
	public function num_rows()
	{
		return ($this->query_temp) ? @mysql_num_rows($this->query_temp) : false;
	}			
}
?>