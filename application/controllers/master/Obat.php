<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Obat extends CI_Controller {

	var $tables =   "md_obat";		
	var $page		=		"master/obat";
	var $pk     =   "id_obat";
	var $title  =   "Obat";
	var $bread	=   "<ol class='breadcrumb'>
	<li class='breadcrumb-item'><a>Master</a></li>										
	<li class='breadcrumb-item active'><a href='master/obat'>Obat</a></li>										
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
		$this->load->model('m_obat');		

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
	
	public function index()
	{								
		$data['isi']    = $this->page;		
		$data['title']	= $this->title;	
		$data['bread']	= $this->bread;																													
		$data['set']		= "view";		
		$data['mode']		= "view";				
		$this->template($data);	
	}
	public function ajax_list()
	{
		$list = $this->m_obat->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $isi) {
			$r = $this->m_admin->getByID("md_obat_gol","id_obat_gol",$isi->id_obat_gol);
			$golongan = ($r->num_rows() > 0) ? $r->row()->golongan : "" ;					
			
			
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = "<a href='master/obat/detail?id=$isi->id_obat'>$isi->id_obat</a>";
			$row[] = $isi->nama_obat;
			$row[] = $isi->kode_obat;
			$row[] = $golongan;
			$row[] = $isi->sat_kecil;
			$row[] = $isi->sat_besar;
			$row[] = $isi->singkatan;
			$row[] = $isi->generik;												
			$row[] = "
						<a href=\"master/obat/delete?id=$isi->id_obat\" onclick=\"return confirm('Anda yakin?')\" class=\"btn btn-danger btn-sm\">hapus</a>                          
            <a href=\"master/obat/edit?id=$isi->id_obat\" class=\"btn btn-primary btn-sm\">ubah</a>";	
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->m_obat->count_all(),
						"recordsFiltered" => $this->m_obat->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}
	public function add()
	{								
		$data['isi']    = $this->page;		
		$data['title']	= "Tambah ".$this->title;	
		$data['bread']	= $this->bread;																													
		$data['dt_obat_gol'] = $this->m_admin->getAll('md_obat_gol');		
		$data['dt_obat_satuan'] = $this->m_admin->getAll('md_obat_satuan');		
		$data['set']		= "insert";	
		$data['mode']		= "insert";									
		$this->template($data);	
	}
	public function delete()
	{		
		$tabel			= $this->tables;
		$pk 				= $this->pk;
		$id 				= $this->input->get('id');		
		$this->m_admin->delete($tabel,$pk,$id);
		$_SESSION['pesan'] 	= "Data berhasil dihapus";
		$_SESSION['tipe'] 	= "success";
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."master/obat'>";
	}	
	public function save()
	{		
		$waktu 		= gmdate("Y-m-d H:i:s", time()+60*60*7);		
		$tabel		= $this->tables;		
		$pk				= $this->pk;
		$data['kode_obat'] 			= $this->input->post('kode_obat');				
		$data['nama_obat'] 			= $this->input->post('nama_obat');						
		$data['singkatan'] 			= $this->input->post('singkatan');				
		$data['sat_besar'] 			= $this->input->post('sat_besar');				
		$data['sat_kecil'] 			= $this->input->post('sat_kecil');		
		$data['generik'] 			= $this->input->post('generik');						
		$data['id_obat_gol'] 			= $this->input->post('id_obat_gol');						
		$data['created_at'] 			= $waktu;
		
		$this->m_admin->insert($tabel,$data);					
		$_SESSION['pesan'] 		= "Data berhasil diubah";
		$_SESSION['tipe'] 		= "success";						
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."master/obat'>";							
	}	
	public function update()
	{		
		$waktu 		= gmdate("Y-m-d H:i:s", time()+60*60*7);		
		$tabel		= $this->tables;		
		$pk				= $this->pk;				

		$id 			= $this->input->post('id');				
		$data['kode_obat'] 			= $this->input->post('kode_obat');				
		$data['nama_obat'] 			= $this->input->post('nama_obat');						
		$data['singkatan'] 			= $this->input->post('singkatan');				
		$data['sat_besar'] 			= $this->input->post('sat_besar');				
		$data['generik'] 			= $this->input->post('generik');				
		$data['sat_kecil'] 			= $this->input->post('sat_kecil');				
		$data['id_obat_gol'] 			= $this->input->post('id_obat_gol');						
		$data['updated_at'] 			= $waktu;
		
		$this->m_admin->update($tabel,$data,$pk,$id);					
		$_SESSION['pesan'] 		= "Data berhasil diubah";
		$_SESSION['tipe'] 		= "success";						
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."master/obat'>";					
		
	}	
	public function edit()
	{								
		$data['isi']    = $this->page;		
		$data['title']	= "Ubah ".$this->title;	
		$data['bread']	= $this->bread;
		$tabel	= $this->tables;
		$pk			= $this->pk;
		$id 		= $this->input->get('id');																															
		$data['set']		= "insert";		
		$data['mode']		= "edit";		
		$data['dt_obat_gol'] = $this->m_admin->getAll('md_obat_gol');		
		$data['dt_obat_satuan'] = $this->m_admin->getAll('md_obat_satuan');		
		$data['dt_obat'] = $this->m_admin->getByID($tabel,$pk,$id);		
		$this->template($data);	
	}
	public function detail()
	{								
		$data['isi']    = $this->page;		
		$data['title']	= "Detail ".$this->title;	
		$data['bread']	= $this->bread;
		$tabel	= $this->tables;
		$pk			= $this->pk;
		$id 		= $this->input->get('id');																															
		$data['set']		= "insert";		
		$data['dt_obat_gol'] = $this->m_admin->getAll('md_obat_gol');		
		$data['dt_obat_satuan'] = $this->m_admin->getAll('md_obat_satuan');		
		$data['dt_obat'] = $this->m_admin->getByID($tabel,$pk,$id);
		$data['mode']		= "detail";				
		$this->template($data);	
	}
}
