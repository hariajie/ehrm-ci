<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Class Mwilayah extends CI_Model {

	
	public function __construct() 
	{
		
		parent::__construct();
	}

	function get_province() {
		$this->db->from("m_province");
		$query = $this->db->get();
		if ( is_object($query) ) 
			return $query->result();
		return array();
	}
	function get_regency($province_code = "") {
		$this->db->from("m_regency");
		if ( !empty($province_code) ) 
			$this->db->where("province_code", $province_code);
		$query = $this->db->get();
		if ( is_object($query) ) 
			return $query->result();
		return array();
	}
	function get_district($regency_code = "") {
		$this->db->from("m_district");
		if ( !empty($regency_code) ) 
			$this->db->where("regency_code", $regency_code);
		$query = $this->db->get();
		if ( is_object($query) ) 
			return $query->result();
		return array();
	}
	function get_village($district_code = "") {
		$this->db->from("m_village");
		if ( !empty($district_code) ) 
			$this->db->where("district_code", $district_code);
		$query = $this->db->get();
		if ( is_object($query) ) 
			return $query->result();
		return array();
	}
}