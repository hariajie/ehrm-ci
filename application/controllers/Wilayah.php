<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Wilayah extends CI_Controller {

	public function __construct() 
	{
		parent::__construct();
		$this->load->model("mwilayah");
	}

	public function province() {
		$province = $this->mwilayah->get_province();
		$this->output
        	 ->set_content_type('application/json')
        	 ->set_output(json_encode($province));
	}
	public function regency($province = NULL) {
		$regency = empty($province) ? array(): $this->mwilayah->get_regency($province);
		$this->output
        	 ->set_content_type('application/json')
        	 ->set_output(json_encode($regency));
	}
	public function district($regency = NULL) {
		$district = empty($regency) ? array(): $this->mwilayah->get_district($regency);
		$this->output
        	 ->set_content_type('application/json')
        	 ->set_output(json_encode($district));
	}
	public function village($district = NULL) {
		$village = empty($district) ? array(): $this->mwilayah->get_village($district);
		$this->output
        	 ->set_content_type('application/json')
        	 ->set_output(json_encode($village));
	}
}