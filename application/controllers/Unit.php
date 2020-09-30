<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Unit extends CI_Controller {

	
	private $url = "https://ehrm.pu.go.id/pupr/api/index.php";
	private $key = "fnaifh84659290";

	public function __construct()
	{
		parent::__construct();
		$this->load->library("Ehrm");
		
	}
	public function index()
	{
		//$this->load->model("mwilayah");
		$data =array();
		$data['cmb_es1'] = $this->get_es1();
		
		//echo json_encode($data['cmb_es1']);
		
		$this->load->view('unit_view', $data);
	}

	function get_es1()
	{
		$url = $this->url; //sesuaikan dengan url api
		$private_key = $this->key; //jangan diganti
		$kdunit = "0";
		$params = array(
			    'kdunit' => $kdunit,
			    'action' => 'pusdatinunit'
			 );

 		
  		$result = $this->ehrm->trf_send_request($url, $private_key, $params, $params['action']);
		$data = $result['unit'];
		return $data;
	}

	function get_ehrm_unit() 
	{

		$url = $this->url; //sesuaikan dengan url api
		$private_key = $this->key; //jangan diganti

		//set Kdunit
		if($_POST["es3"] != '') {
			$kdunit = $_POST["es3"];
		}
		else if($_POST["es2"] != '') {
			$kdunit = $_POST["es2"];
		}
		else if($_POST["es1"] != '') {
			$kdunit = $_POST["es1"];
		}
		else { $kdunit = "0";}
		
		$params = array(
			    'kdunit' => $kdunit,
			    'action' => 'pusdatinunit'
			 );
		$data = array();
  		$result = $this->ehrm->trf_send_request($url, $private_key, $params, $params['action']);
		$res = $result["unit"];
		$no = $_POST['start'];
		foreach ($res as $list) {
			if(substr($list["kdunit"], -2) != "00") {
				$no++;
				$row = array();
				$row['no'] = $no;
				$row['kdunit'] = $list["kdunit"];
				$row['keterangan'] = $list["keterangan"];
				$row['pns'] = $list["pns/cpns"];
				$row['nonpns'] = $list["nonpns"];
				$row['jumlah'] = $row['pns'] + $row['nonpns'];

				$data[] = $row;
			}
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => count($data),
						"recordsFiltered" => count($data),
						"data" => $data
				);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_get_es2($es1='')
	{
		
			$url = $this->url; //sesuaikan dengan url api
			$private_key = $this->key; //jangan diganti

			$kdunit = $es1;
			$params = array(
					'kdunit' => $kdunit,
					'action' => 'pusdatinunit'
				);
			$data = array();

			
			$result = $this->ehrm->trf_send_request($url, $private_key, $params, $params['action']);

			$data = $result['unit'];
			$this->output
				->set_content_type('application/json')
				->set_output(json_encode($data));
		
	}

	public function ajax_get_es3($es2='')
	{
		$url = $this->url; //sesuaikan dengan url api
		$private_key = $this->key; //jangan diganti

		$kdunit = $es2;
		$params = array(
			    'kdunit' => $kdunit,
			    'action' => 'pusdatinunit'
			 );
		$data = array();

 		
  		$result = $this->ehrm->trf_send_request($url, $private_key, $params, $params['action']);

		$data = $result['unit'];
		$this->output
		 	 ->set_content_type('application/json')
		  	 ->set_output(json_encode($data));
	}
}
