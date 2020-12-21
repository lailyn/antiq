<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setting extends CI_Controller {

	var $tables =   "md_setting";		
	var $page		=		"master/setting";
	var $pk     =   "id_setting";
	var $title  =   "Setting";
	var $bread	=   "<ol class='breadcrumb'>
	<li class='breadcrumb-item'><a>Master</a></li>										
	<li class='breadcrumb-item active'><a href='master/setting'>Setting</a></li>										
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
		$this->load->model('m_user');		

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
		
	public function update()
	{		
		$waktu 		= gmdate("Y-m-d H:i:s", time()+60*60*7);		
		$tabel		= $this->tables;		
		$pk				= $this->pk;	
		$config['upload_path'] 		= './assets/im493/';
		$config['allowed_types'] 	= 'jpg|png|bmp';
		$config['max_size']				= '1000';		
    $config['encrypt_name'] 	= TRUE; 						


    $err = "";
    if(!empty($_FILES['logo']['name'])){
			$this->upload->initialize($config);
			if(!$this->upload->do_upload('logo')){
				$err = $this->upload->display_errors();				
			}else{
				$err = "";
				$row = $this->m_admin->getByID("md_setting","id_setting",1)->row();
	    	if(isset($row->logo)){
	    		unlink('assets/im493/'.$row->logo);         	    		
	    	}
				$data['logo']	= $this->upload->file_name;
			}
		}

		$err2 = "";
    if(!empty($_FILES['fav']['name'])){
			$this->upload->initialize($config);
			if(!$this->upload->do_upload('fav')){
				$err2 = $this->upload->display_errors();				
			}else{
				$err2 = "";
				$row = $this->m_admin->getByID("md_setting","id_setting",1)->row();
	    	if(isset($row->fav)){
	    		unlink('assets/im493/'.$row->fav);         	    		
	    	}
				$data['fav']	= $this->upload->file_name;
			}
		}

		$data['nama_pimpinan'] 			= $this->input->post('nama_pimpinan');				
		$data['alamat'] 			= $this->input->post('alamat');						
		$data['email'] 			= $this->input->post('email');				
		$data['no_hp'] 			= $this->input->post('no_hp');				
		$data['perusahaan'] 			= $this->input->post('perusahaan');				
		$data['no_telp'] 			= $this->input->post('no_telp');						
		if($err=="" AND $err2==""){
			$this->m_admin->update($tabel,$data,$pk,1);					
			$_SESSION['pesan'] 		= "Data berhasil diubah";
			$_SESSION['tipe'] 		= "success";						
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."master/Setting'>";					
		}else{
			$_SESSION['pesan'] 		= $err."<br>".$err2;
			$_SESSION['tipe'] 		= "danger";						
			echo "<script>history.go(-1)</script>";
		}
		
	}	
	public function index()
	{								
		$data['isi']    = $this->page;		
		$data['title']	= "Ubah ".$this->title;	
		$data['bread']	= $this->bread;
		$tabel	= $this->tables;
		$pk			= $this->pk;
		$id 		= 1;
		$data['set']		= "insert";		
		$data['mode']		= "edit";				
		$data['dt_setting'] = $this->m_admin->getByID($tabel,$pk,$id);		
		$this->template($data);	
	}	
}
