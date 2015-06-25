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
	
	public  function get_countries($continent_name) {
		$this->load->database();
		$camelContinentName =  ucwords(strtolower($continent_name)); 
		$query = "SELECT name FROM `Country` WHERE continent='{$camelContinentName}' ORDER BY name ASC";
		$data = $this->db->query($query);
		
		return $data->result_array();
		
	}
}
?>