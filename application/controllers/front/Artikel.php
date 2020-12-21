<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Artikel extends CI_Controller {

	var $tables =   "md_artikel";		
	var $page		=		"front/artikel";
	var $pk     =   "id_artikel";
	var $title  =   "Artikel";
	var $bread	=   "<ol class='breadcrumb'>
	<li class='breadcrumb-item'><a>Master</a></li>										
	<li class='breadcrumb-item active'><a href='front/artikel'>Artikel</a></li>										
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
		$this->load->model('m_artikel');		

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
		$list = $this->m_artikel->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $isi) {			
			$r = $this->m_admin->getByID("md_artikel_kategori","id_artikel_kategori",$isi->id_artikel_kategori);
			$kategori = ($r->num_rows() > 0) ? $r->row()->kategori : "" ;					
			

			if(!isset($isi->gambar1) AND $isi->gambar1==""){
        $foto = "user.png";
      }else{
        $foto = $isi->gambar1;
      }

      if($isi->status=="draft"){      
      	$status = "<label class='badge badge-gradient-danger'>Draft</label>";
      }else{
      	$status = "<label class='badge badge-gradient-success'>Published</label>";
      }

			$no++;
			$row = array();
			$row[] = $no;
			$row[] = "<a href='front/artikel/detail?id=$isi->id_artikel'>$isi->judul</a> $status";
			$row[] = $kategori;
			$row[] = substr($isi->isi,0,100);
			$row[] = "<img src='assets/art1kel/$foto' class='mb-6 mw-100 rounded'>";
			$row[] = "
						<a href=\"front/artikel/delete?id=$isi->id_artikel\" onclick=\"return confirm('Anda yakin?')\" class=\"btn btn-danger btn-sm\">hapus</a>                          
            <a href=\"front/artikel/edit?id=$isi->id_artikel\" class=\"btn btn-primary btn-sm\">ubah</a>";	
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->m_artikel->count_all(),
						"recordsFiltered" => $this->m_artikel->count_filtered(),
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
		$data['dt_kategori'] = $this->m_admin->getAll("md_artikel_kategori");
		$data['mode']		= "insert";									
		$this->template($data);	
	}
	public function kategori()
	{								
		$data['isi']    = $this->page;		
		$data['title']	= "Tambah Kategori ".$this->title;	
		$data['bread']	= $this->bread;																															
		$data['set']		= "insert2";	
		$data['dt_kategori'] = $this->m_admin->getAll("md_artikel_kategori");
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
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."front/artikel'>";
	}	
	public function delete_kategori()
	{		
		$tabel			= "md_artikel_kategori";
		$pk 				= "id_artikel_kategori";
		$id 				= $this->input->get('id');		
		$this->m_admin->delete($tabel,$pk,$id);
		$_SESSION['pesan'] 	= "Data berhasil dihapus";
		$_SESSION['tipe'] 	= "success";
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."front/artikel/kategori'>";
	}	
	public function save()
	{		
		$waktu 		= gmdate("Y-m-d H:i:s", time()+60*60*7);		
		$tgl 		= gmdate("Y-m-d", time()+60*60*7);		
		$login_id		= $this->session->userdata("id_user");		
		$tabel		= $this->tables;		
		$pk				= $this->pk;
		$config['upload_path'] 		= './assets/art1kel/';
		$config['allowed_types'] 	= 'jpg|png|bmp';
		$config['max_size']				= '1000';		
    $config['encrypt_name'] 	= TRUE; 				

    $err = "";
    if(!empty($_FILES['gambar1']['name'])){
			$this->upload->initialize($config);
			if(!$this->upload->do_upload('gambar1')){
				$err = $this->upload->display_errors();				
			}else{
				$err = "";				
				$data['gambar1']	= $this->upload->file_name;
			}
		}

		$data['id_artikel_kategori'] 			= $this->input->post('id_artikel_kategori');				
		$data['judul'] 			= $this->input->post('judul');						
		$data['isi'] 			= $this->input->post('isi');				
		$data['preview'] 			= $this->input->post('preview');				
		$data['status'] 			= $this->input->post('status');				
		$data['tgl_buat'] 			= $tgl;
		$data['permalink'] 			= set_permalink($this->input->post('judul'));				
		$data['created_at'] 			= $waktu;		
		$data['created_by'] 			= $login_id;		
		if($err==""){
			$this->m_admin->insert($tabel,$data);					
			$_SESSION['pesan'] 		= "Data berhasil diubah";
			$_SESSION['tipe'] 		= "success";						
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."front/artikel'>";					
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
    if(!empty($_FILES['gambar1']['name'])){
			$this->upload->initialize($config);
			if(!$this->upload->do_upload('gambar1')){
				$err = $this->upload->display_errors();				
			}else{
				$err = "";
				$row = $this->m_admin->getByID("md_artikel","id_artikel",$id)->row();
	    	if(isset($row->gambar1)){
	    		unlink('assets/art1kel/'.$row->gambar1);         	    		
	    	}
				$data['gambar1']	= $this->upload->file_name;
			}
		}

		$data['id_artikel_kategori'] 			= $this->input->post('id_artikel_kategori');				
		$data['judul'] 			= $this->input->post('judul');						
		$data['isi'] 			= $this->input->post('isi');				
		$data['preview'] 			= $this->input->post('preview');				
		$data['status'] 			= $this->input->post('status');				
		$data['tgl_buat'] 			= $tgl;
		$data['permalink'] 			= set_permalink($this->input->post('judul'));				
		$data['updated_at'] 			= $waktu;		
		if($err==""){
			$this->m_admin->update($tabel,$data,$pk,$id);					
			$_SESSION['pesan'] 		= "Data berhasil diubah";
			$_SESSION['tipe'] 		= "success";						
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."front/artikel'>";					
		}else{
			$_SESSION['pesan'] 		= $err;
			$_SESSION['tipe'] 		= "danger";						
			echo "<script>history.go(-1)</script>";			
		}					
		
	}	
	public function save_kategori()
	{		
		$waktu 		= gmdate("Y-m-d H:i:s", time()+60*60*7);		
		$tabel		= "md_artikel_kategori";		
		$pk				= "id_artikel_kategori";		
		$data['kategori'] 			= $this->input->post('kategori');								
		$data['created_at'] 			= $waktu;				
		$this->m_admin->insert($tabel,$data);					
		$_SESSION['pesan'] 		= "Data berhasil disimpan";
		$_SESSION['tipe'] 		= "success";						
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."front/artikel/kategori'>";							
		
	}
	public function update_kategori()
	{		
		$waktu 		= gmdate("Y-m-d H:i:s", time()+60*60*7);		
		$tabel		= "md_artikel_kategori";		
		$pk				= "id_artikel_kategori";		
		$id 			= $this->input->post('id');								
		$data['kategori'] 			= $this->input->post('kategori');								
		$data['updated_at'] 			= $waktu;				
		$this->m_admin->update($tabel,$data,$pk,$id);					
		$_SESSION['pesan'] 		= "Data berhasil diubah";
		$_SESSION['tipe'] 		= "success";						
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."front/artikel/kategori'>";							
		
	}
	public function edit_kategori()
	{								
		$data['isi']    = $this->page;		
		$data['title']	= "Ubah Kategori ".$this->title;	
		$data['bread']	= $this->bread;
		$tabel	= "md_artikel_kategori";
		$pk			= "id_artikel_kategori";
		$id 		= $this->input->get('id');																															
		$data['set']		= "insert2";		
		$data['mode']		= "edit";				
		$data['dt_artikel'] = $this->m_admin->getByID($tabel,$pk,$id);		
		$data['dt_kategori'] = $this->m_admin->getAll("md_artikel_kategori");
		$this->template($data);	
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
		$data['dt_artikel'] = $this->m_admin->getByID($tabel,$pk,$id);		
		$data['dt_kategori'] = $this->m_admin->getAll("md_artikel_kategori");
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
		$data['dt_artikel'] = $this->m_admin->getByID($tabel,$pk,$id);
		$data['dt_kategori'] = $this->m_admin->getAll("md_artikel_kategori");
		$data['mode']		= "detail";				
		$this->template($data);	
	}
}
