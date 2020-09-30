<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Nip extends CI_Controller {

	
	public function __construct()
	{
		parent::__construct();
		$this->load->library("Ehrm");
	}
	public function index()
	{
		//$this->load->model("mwilayah");
		$data =array();
		
		$this->load->view('nip_view', $data);
	}

	function get_ehrm_nip() 
	{

		$url = "https://ehrm.pu.go.id/pupr/api/index.php"; //sesuaikan dengan url api
		$private_key ='fnaifh84659290'; //jangan diganti

		$nip = $_POST["nip"];
		$params = array(
			    'nip' => $nip,
			    'action' => 'pusdatinnip'
			 );
		$data = array();

 		
  		$result = $this->ehrm->trf_send_request($url, $private_key, $params, $params['action']);

		if (isset($result['info'])) {
			$data['hasil'] = 'nothing';
		}
		else {
			$data['hasil'] = "ada";
			$data["nama"] = $result[0]['pegawai']['nama'];
			$data["jabatan"] = $result[0]['pegawai']['jabatan'];
			$data["unor"] = $result[0]['pegawai']['es1'];
			$data["unker"] = $result[0]['pegawai']['es2'];
			$data["foto"] = $result[0]['pegawai']['foto_baru'];
			$data["nip"] = $nip;

			//$this->session->unset_tempdata("id_unker");
			//$this->session->set_tempdata("id_unker", $data["unker"]);
			
		}

		$this->output
		 	 ->set_content_type('application/json')
		  	 ->set_output(json_encode($data));
	}
}
