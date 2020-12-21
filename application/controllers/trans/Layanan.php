<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Layanan extends CI_Controller {

	var $tables =   "md_layanan";		
	var $page		=		"trans/layanan";
	var $pk     =   "id_layanan";
	var $title  =   "Layanan";
	var $bread	=   "<ol class='breadcrumb'>
	<li class='breadcrumb-item'><a>Master</a></li>										
	<li class='breadcrumb-item active'><a href='trans/layanan'>Layanan</a></li>										
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
		$this->load->model('m_layanan');		

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
		$list = $this->m_layanan->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $isi) {						
		
			if(!isset($isi->foto) AND $isi->foto==""){
        $foto = "user.png";
      }else{
        $foto = $isi->foto;
      }

      if($isi->status=="draft"){      
      	$status = "<label class='badge badge-gradient-danger'>Draft</label>";
      }else{
      	$status = "<label class='badge badge-gradient-success'>Published</label>";
      }

			$no++;
			$row = array();
			$row[] = $no;
			$row[] = "<a href='trans/layanan/detail?id=$isi->id_layanan'>$isi->layanan</a> $status";
			$row[] = $isi->menu;		
			$row[] = $isi->kode;		
			$row[] = $isi->deskripsi;			
			$row[] = "
						<a href=\"trans/layanan/delete?id=$isi->id_layanan\" onclick=\"return confirm('Anda yakin?')\" class=\"btn btn-danger btn-sm\">hapus</a>                          
            <a href=\"trans/layanan/edit?id=$isi->id_layanan\" class=\"btn btn-primary btn-sm\">ubah</a>";	
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->m_layanan->count_all(),
						"recordsFiltered" => $this->m_layanan->count_filtered(),
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
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."trans/layanan'>";
	}	

	public function save()
	{		
		$waktu 		= gmdate("Y-m-d H:i:s", time()+60*60*7);		
		$tabel		= $this->tables;		
		$pk				= $this->pk;
		$config['upload_path'] 		= './assets/art1kel/';
		$config['allowed_types'] 	= 'jpg|png|bmp';
		$config['max_size']				= '1000';		
    $config['encrypt_name'] 	= TRUE; 				

    $err = "";
    if(!empty($_FILES['foto']['name'])){
			$this->upload->initialize($config);
			if(!$this->upload->do_upload('foto')){
				$err = $this->upload->display_errors();				
			}else{				
				$data['foto']	= $this->upload->file_name;
			}
		}		
    if(!empty($_FILES['icon']['name'])){
			$this->upload->initialize($config);
			if(!$this->upload->do_upload('icon')){
				$err .= $this->upload->display_errors();				
			}else{				
				$data['icon']	= $this->upload->file_name;
			}
		}		
		$data['layanan'] 			= $this->input->post('layanan');						
		$data['menu'] 			= $this->input->post('menu');						
		$data['deskripsi'] 			= $this->input->post('deskripsi');				
		$data['status'] 			= $this->input->post('status');						
		$data['tarif'] 			= $this->input->post('tarif');						
		$data['kode'] 			= $this->input->post('kode');						
		$data['created_at'] 			= $waktu;		
		if($err==""){
			$this->m_admin->insert($tabel,$data);					
			$_SESSION['pesan'] 		= "Data berhasil diubah";
			$_SESSION['tipe'] 		= "success";						
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."trans/layanan'>";					
		}else{
			$_SESSION['pesan'] 		= $err;
			$_SESSION['tipe'] 		= "danger";						
			echo "<script>history.go(-1)</script>";			
		}
		
	}	
	public function update()
	{		
		$waktu 		= gmdate("Y-m-d H:i:s", time()+60*60*7);		
		$tgl 		= gmdate("Y-m-d H:i:s", time()+60*60*7);		
		$tabel		= $this->tables;		
		$pk				= $this->pk;		
		$config['upload_path'] 		= './assets/art1kel/';
		$config['allowed_types'] 	= 'jpg|png|bmp';
		$config['max_size']				= '1000';		
    $config['encrypt_name'] 	= TRUE; 				
		$id 	= $this->input->post('id');		

    $err = "";
    if(!empty($_FILES['foto']['name'])){
			$this->upload->initialize($config);
			if(!$this->upload->do_upload('foto')){
				$err = $this->upload->display_errors();				
			}else{
				$err = "";
				$row = $this->m_admin->getByID("md_layanan","id_layanan",$id)->row();
	    	if(isset($row->foto)){
	    		unlink('assets/art1kel/'.$row->foto);         	    		
	    	}
				$data['foto']	= $this->upload->file_name;
			}
		}
		if(!empty($_FILES['icon']['name'])){
			$this->upload->initialize($config);
			if(!$this->upload->do_upload('icon')){
				$err .= $this->upload->display_errors();				
			}else{
				$err = "";
				$row = $this->m_admin->getByID("md_layanan","id_layanan",$id)->row();
	    	if(isset($row->icon)){
	    		unlink('assets/art1kel/'.$row->icon);         	    		
	    	}
				$data['icon']	= $this->upload->file_name;
			}
		}

		$data['layanan'] 			= $this->input->post('layanan');						
		$data['deskripsi'] 			= $this->input->post('deskripsi');
		$data['menu'] 			= $this->input->post('menu');											
		$data['status'] 			= $this->input->post('status');						
		$data['tarif'] 			= $this->input->post('tarif');						
		$data['kode'] 			= $this->input->post('kode');						
		$data['updated_at'] 			= $waktu;		
		if($err==""){
			$this->m_admin->update($tabel,$data,$pk,$id);					
			$_SESSION['pesan'] 		= "Data berhasil diubah";
			$_SESSION['tipe'] 		= "success";						
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."trans/layanan'>";					
		}else{
			$_SESSION['pesan'] 		= $err;
			$_SESSION['tipe'] 		= "danger";						
			echo "<script>history.go(-1)</script>";			
		}					
		
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
		$data['dt_layanan'] = $this->m_admin->getByID($tabel,$pk,$id);				
		$data['dt_layanan_sub'] = $this->m_admin->getAll("md_layanan_sub");
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
		$data['dt_layanan'] = $this->m_admin->getByID($tabel,$pk,$id);
		$data['dt_layanan_sub'] = $this->m_admin->getAll("md_layanan_sub");
		$data['mode']		= "detail";				
		$this->template($data);	
	}	
}
