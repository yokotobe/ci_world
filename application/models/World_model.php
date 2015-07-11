<?php
class World_model extends CI_model {
	public function __construct()
	{
		// Call the CI_Model constructor
		parent::__construct();
	}

	public  function get_all_continent() {
		$this->load->database();
		$query = "SELECT continent FROM `Country` GROUP BY continent ORDER BY continent ASC";
		$data = $this->db->query($query);
		
		return $data->result_array();
		
	}
	
	public  function get_countries($continent_name,$start=NULL,$limit=NULL) {
		$this->load->database();
		$camelContinentName =  ucwords(strtolower($continent_name));
		$LIMIT = "";
		if(is_numeric($start)&&is_numeric($limit)){
			$LIMIT = "LIMIT {$start},{$limit}";
		}
		$query = "SELECT name FROM `Country` WHERE continent='{$camelContinentName}' ORDER BY name ASC {$LIMIT}";
		$data = $this->db->query($query);
		
		return $data->result_array();
		
	}
	
	public function count_countires($continent_name) {
		$this->load->database();
		$camelContinentName =  ucwords(strtolower($continent_name));
		$query = "SELECT COUNT(*) AS total FROM `Country` WHERE continent='{$camelContinentName}'";
		//echo $query;
		$data = $this->db->query($query);
		$total = $data->result_array();
		$total = $total[0]['total'];
	
		return $total;
	
	}
	
	public function search_countires($query_name) {
		$this->load->database();
		$query_name = strtolower($query_name);
		$query = "SELECT name,continent,region FROM `Country` WHERE name LIKE '%{$query_name}%'";
		//$query = "SELECT COUNT(*) AS total FROM `Country` WHERE continent='{$camelContinentName}'";
		echo $query;
		$data = $this->db->query($query);
	
		return $data;
	
	}
	
	public function get_country($country_name) {
		$this->load->database();
		
		$query_name = strtolower($country_name);
		$country_name = str_replace('-',' ',$country_name);
		$query = "SELECT * FROM `country` WHERE name = '{$country_name}'";
	
		$data = $this->db->query($query);
		$data = $data->result_array();
		
		return $data;
	
	}
}
?>