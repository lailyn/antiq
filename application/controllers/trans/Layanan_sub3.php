<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Layanan_sub3 extends CI_Controller {

	var $tables =   "md_layanan_sub3";		
	var $page		=		"trans/layanan_sub3";
	var $pk     =   "id_layanan_sub3";
	var $title  =   "Layanan Sub 3";
	var $bread	=   "<ol class='breadcrumb'>
	<li class='breadcrumb-item'><a>Master</a></li>										
	<li class='breadcrumb-item active'><a href='trans/layanan_sub3'>Layanan Sub 3</a></li>										
	</ol>";				          


	public function __construct()
	{		
		parent::__construct();
		//---- cek session -------//		

		//===== Load Database =====
		$this->load->database();
		$this->load->helper('url', 'string');
		$this->load->helper('permalink_helper');				
		//===== Load Model =====
		$this->load->model('m_admin');		
		$this->load->model('m_layanan_sub3');		

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
		$list = $this->m_layanan_sub3->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $isi) {						
      $cek = $this->m_admin->getByID("md_layanan_sub2","id_layanan_sub2",$isi->id_layanan_sub2);
      $layanan_sub2 = ($cek->num_rows() > 0) ? $cek->row()->layanan_sub2 : "";

      if($isi->status=="draft"){      
      	$status = "<label class='badge badge-gradient-danger'>Draft</label>";
      }else{
      	$status = "<label class='badge badge-gradient-success'>Published</label>";
      }

			$no++;
			$row = array();
			$row[] = $no;
			$row[] = "<a href='trans/layanan_sub3/detail?id=$isi->id_layanan_sub3'>$isi->layanan_sub3</a> $status";
			$row[] = $isi->kode;		
			$row[] = $isi->deskripsi;			
			$row[] = $layanan_sub2;			
			$row[] = "
						<a href=\"trans/layanan_sub3/delete?id=$isi->id_layanan_sub3\" onclick=\"return confirm('Anda yakin?')\" class=\"btn btn-danger btn-sm\">hapus</a>                          
            <a href=\"trans/layanan_sub3/edit?id=$isi->id_layanan_sub3\" class=\"btn btn-primary btn-sm\">ubah</a>";	
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->m_layanan_sub3->count_all(),
						"recordsFiltered" => $this->m_layanan_sub3->count_filtered(),
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
		$data['set']		= "insert";	
		$data['dt_layanan'] = $this->m_admin->getAll("md_layanan_sub2");		
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
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."trans/layanan_sub3'>";
	}	

	public function save()
	{		
		$waktu 		= gmdate("Y-m-d H:i:s", time()+60*60*7);		
		$tabel		= $this->tables;		
    $pk				= $this->pk;
    				
		$data['layanan_sub3'] 			= $this->input->post('layanan_sub3');						
		$data['deskripsi'] 			= $this->input->post('deskripsi');				
		$data['status'] 			= $this->input->post('status');						
		$data['tarif'] 			= $this->input->post('tarif');						
		$data['id_layanan_sub2'] 			= $this->input->post('id_layanan_sub2');						
		$data['kode'] 			= $this->input->post('kode');						
		$data['created_at'] 			= $waktu;		
		
    $this->m_admin->insert($tabel,$data);					
    $_SESSION['pesan'] 		= "Data berhasil diubah";
    $_SESSION['tipe'] 		= "success";						
    echo "<meta http-equiv='refresh' content='0; url=".base_url()."trans/layanan_sub3'>";					
				
	}	
	public function update()
	{		
		$waktu 		= gmdate("Y-m-d H:i:s", time()+60*60*7);		
		$tgl 		= gmdate("Y-m-d H:i:s", time()+60*60*7);		
		$tabel		= $this->tables;		
		$pk				= $this->pk;				

		$id 			= $this->input->post('id');						
		$data['layanan_sub3'] 			= $this->input->post('layanan_sub3');						
		$data['deskripsi'] 			= $this->input->post('deskripsi');				
		$data['status'] 			= $this->input->post('status');						
		$data['tarif'] 			= $this->input->post('tarif');						
		$data['kode'] 			= $this->input->post('kode');						
		$data['id_layanan_sub2'] 			= $this->input->post('id_layanan_sub2');						
		$data['updated_at'] 			= $waktu;		
		
    $this->m_admin->update($tabel,$data,$pk,$id);					
    $_SESSION['pesan'] 		= "Data berhasil diubah";
    $_SESSION['tipe'] 		= "success";						
    echo "<meta http-equiv='refresh' content='0; url=".base_url()."trans/layanan_sub3'>";													
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
		$data['dt_layanan_sub3'] = $this->m_admin->getByID($tabel,$pk,$id);				
		$data['dt_layanan'] = $this->m_admin->getAll("md_layanan_sub2");
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
		$data['dt_layanan_sub3'] = $this->m_admin->getByID($tabel,$pk,$id);
		$data['dt_layanan'] = $this->m_admin->getAll("md_layanan_sub2");
		$data['mode']		= "detail";				
		$this->template($data);	
	}	
}
