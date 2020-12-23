<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends CI_Controller {

	var $tables =   "md_transaksi";		
	var $page		=		"laporan";
	var $pk     =   "id_transaksi";
	var $title  =   "Laporan";
	var $bread	=   "<ol class='breadcrumb'>
	<li class='breadcrumb-item active'><a href='laporan'>Laporan</a></li>										
	</ol>";				          


	public function __construct()
	{		
		parent::__construct();
		//---- cek session -------//		

		//===== Load Database =====
		$this->load->database();
		$this->load->helper('url', 'string');
		//===== Load Model =====
		$this->load->model('m_admin');		
		$this->load->model('m_transaksi');		

		//===== Load Library =====
		$this->load->library('upload');
	}
	protected function template($data)
	{
		$name = $this->session->userdata('nama');
		if($name=="")
		{
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."adm1n?denied'>";
		}else{								
			$this->load->view('back_template/header',$data);
			$this->load->view('back_template/aside');			
			$this->load->view($this->page);		
			$this->load->view('back_template/footer');
		}
	}
	function mata_uang($a){      
		if(is_numeric($a) AND $a != 0 AND $a != ""){
			return number_format($a, 0, ',', '.');
		}else{
			return $a;
		}
	}
	public function index()
	{								
		$data['isi']    = $this->page;		
		$data['title']	= $this->title;	
		$data['bread']	= $this->bread;																													
		$data['set']		= "view";		
		$data['mode']		= "view";
		$data['tgl'] 		= "";				
		$data['submit'] 		= "";				
		$this->template($data);	
	}
	public function filter()
	{								
		$data['isi']    = $this->page;		
		$data['title']	= $this->title;	
		$data['bread']	= $this->bread;																															
		$data['tgl'] 		= $this->input->post("tanggal");						
		if(isset($_POST["filter"])){
			$data['set']		= "filter";
			$this->template($data);		
		}else{
			$data['set']		= "download";		
			$this->load->view("laporan",$data);	

		}
	}
}
