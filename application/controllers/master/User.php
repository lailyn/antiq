<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	var $tables =   "md_user";		
	var $page		=		"master/user";
	var $pk     =   "id_user";
	var $title  =   "User";
	var $bread	=   "<ol class='breadcrumb'>
	<li class='breadcrumb-item'><a>Master</a></li>										
	<li class='breadcrumb-item active'><a href='master/user'>User</a></li>										
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
		$list = $this->m_user->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $isi) {
					
			if($isi->status==1){
        $status = "<label class='badge badge-gradient-success'>aktif</label>";
      }else{
        $status = "";
      }
			
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = "<a href='master/user/detail?id=$isi->id_user'>$isi->id_user</a>";
			$row[] = $isi->nama_lengkap." ".$status;
			$row[] = $isi->email;
			$row[] = $isi->no_hp;
			$row[] = "
						<a href=\"master/user/delete?id=$isi->id_user\" onclick=\"return confirm('Anda yakin?')\" class=\"btn btn-danger btn-sm\">hapus</a>                          
            <a href=\"master/user/edit?id=$isi->id_user\" class=\"btn btn-primary btn-sm\">ubah</a>";	
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->m_user->count_all(),
						"recordsFiltered" => $this->m_user->count_filtered(),
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
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."master/user'>";
	}	
	public function save()
	{		
		$waktu 		= gmdate("Y-m-d H:i:s", time()+60*60*7);		
		$tabel		= $this->tables;		
		$pk				= $this->pk;
		$config['upload_path'] 		= './assets/im493/';
		$config['allowed_types'] 	= 'jpg|png|bmp';
		$config['max_size']				= '1000';		
    $config['encrypt_name'] 	= TRUE; 				
		

    $err = "";
    if(!empty($_FILES['foto']['name'])){
			$this->upload->initialize($config);
			if(!$this->upload->do_upload('foto')){
				$err = $this->upload->display_errors();				
			}else{
				$err = "";				
				$data['foto']	= $this->upload->file_name;
			}
		}
		$data['nama_lengkap'] 			= $this->input->post('nama_lengkap');						
		$data['email'] 			= $this->input->post('email');				
		$data['no_hp'] 			= $this->input->post('no_hp');				
		$data['status'] 			= $this->input->post('status');				
		$data['password'] 			= md5($this->input->post('password'));				
		$data['created_at'] 			= $waktu;
		
		$this->m_admin->insert($tabel,$data);					
		$_SESSION['pesan'] 		= "Data berhasil diubah";
		$_SESSION['tipe'] 		= "success";						
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."master/user'>";							
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
		$id 	= $this->input->post('id');		

    $err = "";
    if(!empty($_FILES['foto']['name'])){
			$this->upload->initialize($config);
			if(!$this->upload->do_upload('foto')){
				$err = $this->upload->display_errors();				
			}else{
				$err = "";
				$row = $this->m_admin->getByID("md_karyawan","id_karyawan",$id)->row();
	    	if(isset($row->foto)){
	    		unlink('assets/im493/'.$row->foto);         	    		
	    	}
				$data['foto']	= $this->upload->file_name;
			}
		}			

		$data['nama_lengkap'] 			= $this->input->post('nama_lengkap');						
		$data['email'] 			= $this->input->post('email');				
		$data['no_hp'] 			= $this->input->post('no_hp');				
		$password 			= $this->input->post('password');
		$data['status'] 			= $this->input->post('status');				
		if($password!=""){				
			$data['password'] 			= md5($this->input->post('password'));				
		}
		$data['updated_at'] 			= $waktu;
		
		$this->m_admin->update($tabel,$data,$pk,$id);					
		$_SESSION['pesan'] 		= "Data berhasil diubah";
		$_SESSION['tipe'] 		= "success";						
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."master/user'>";					
		
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
		$data['dt_user'] = $this->m_admin->getByID($tabel,$pk,$id);		
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
		$data['dt_user'] = $this->m_admin->getByID($tabel,$pk,$id);
		$data['mode']		= "detail";				
		$this->template($data);	
	}
}
