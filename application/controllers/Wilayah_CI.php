<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Wilayah_CI extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	public function index()
	{
		$this->load->model("mwilayah");

		$province_list = $this->mwilayah->get_province();
		$regency_list = $district_list = $village_list = array();

		if ( !empty($province) ) 
			$regency_list = $this->mwilayah->get_regency($province);
		if ( !empty($regency) )
			$district_list = $this->mwilayah->get_district($regency);
		if ( !empty($district) ) 
			$village_list = $this->mwilayah->get_village($district);

		$data = array(
			'province_list'	=> $province_list,
			'regency_list' => $regency_list,
			'district_list' => $district_list,
			'village_list' => $village_list,
		);
		$this->load->view('wilayah-ci', $data);
	}
}
