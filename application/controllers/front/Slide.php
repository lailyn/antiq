<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Slide extends CI_Controller {

	var $tables =   "md_slide";		
	var $page		=		"front/slide";
	var $pk     =   "id_slide";
	var $title  =   "Slide";
	var $bread	=   "<ol class='breadcrumb'>
	<li class='breadcrumb-item'><a>Master</a></li>										
	<li class='breadcrumb-item active'><a href='front/slide'>Slide</a></li>										
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
		$this->load->model('m_slide');		

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
		$list = $this->m_slide->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $isi) {						

			if(!isset($isi->gambar) AND $isi->gambar==""){
        $foto = "user.png";
      }else{
        $foto = $isi->gambar;
      }

      if($isi->status=="draft"){      
      	$status = "<label class='badge badge-gradient-danger'>Draft</label>";
      }else{
      	$status = "<label class='badge badge-gradient-success'>Published</label>";
      }

			$no++;
			$row = array();
			$row[] = $no;
			$row[] = "<a href='front/slide/detail?id=$isi->id_slide'>$isi->judul</a> $status";			
			$row[] = $isi->isi;
			$row[] = "<img src='assets/art1kel/$foto' class='mb-6 mw-100 rounded'>";
			$row[] = "
						<a href=\"front/slide/delete?id=$isi->id_slide\" onclick=\"return confirm('Anda yakin?')\" class=\"btn btn-danger btn-sm\">hapus</a>                          
            <a href=\"front/slide/edit?id=$isi->id_slide\" class=\"btn btn-primary btn-sm\">ubah</a>";	
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->m_slide->count_all(),
						"recordsFiltered" => $this->m_slide->count_filtered(),
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
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."front/slide'>";
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
    if(!empty($_FILES['gambar']['name'])){
			$this->upload->initialize($config);
			if(!$this->upload->do_upload('gambar')){
				$err = $this->upload->display_errors();				
			}else{				
				$data['gambar']	= $this->upload->file_name;
			}
		}
		
		$data['judul'] 			= $this->input->post('judul');						
		$data['isi'] 			= $this->input->post('isi');				
		$data['status'] 			= $this->input->post('status');						
		$data['permalink'] 			= set_permalink($this->input->post('judul'));				
		$data['created_at'] 			= $waktu;		
		if($err==""){
			$this->m_admin->insert($tabel,$data);					
			$_SESSION['pesan'] 		= "Data berhasil disimpan";
			$_SESSION['tipe'] 		= "success";						
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."front/slide'>";					
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
    if(!empty($_FILES['gambar']['name'])){
			$this->upload->initialize($config);
			if(!$this->upload->do_upload('gambar')){
				$err = $this->upload->display_errors();				
			}else{
				$err = "";
				$row = $this->m_admin->getByID("md_slide","id_slide",$id)->row();
	    	if(isset($row->gambar)){
	    		unlink('assets/art1kel/'.$row->gambar);         	    		
	    	}
				$data['gambar']	= $this->upload->file_name;
			}
		}

		$data['judul'] 			= $this->input->post('judul');						
		$data['isi'] 			= $this->input->post('isi');				
		$data['status'] 			= $this->input->post('status');				
		$data['permalink'] 			= set_permalink($this->input->post('judul'));				
		$data['updated_at'] 			= $waktu;		
		if($err==""){
			$this->m_admin->update($tabel,$data,$pk,$id);					
			$_SESSION['pesan'] 		= "Data berhasil diubah";
			$_SESSION['tipe'] 		= "success";						
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."front/slide'>";					
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
		$data['dt_slide'] = $this->m_admin->getByID($tabel,$pk,$id);		
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
		$data['dt_slide'] = $this->m_admin->getByID($tabel,$pk,$id);
		$data['mode']		= "detail";				
		$this->template($data);	
	}
}
