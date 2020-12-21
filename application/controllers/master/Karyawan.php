<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Karyawan extends CI_Controller {

	var $tables =   "md_karyawan";		
	var $page		=		"master/karyawan";
	var $pk     =   "id_karyawan";
	var $title  =   "Karyawan";
	var $bread	=   "<ol class='breadcrumb'>
	<li class='breadcrumb-item'><a>Master</a></li>										
	<li class='breadcrumb-item active'><a href='master/karyawan'>Karyawan</a></li>										
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
		$this->load->model('m_karyawan');		

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
		$list = $this->m_karyawan->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $isi) {
			$r = $this->m_admin->getByID("md_bagian","id_bagian",$isi->id_bagian);
			$bagian = ($r->num_rows() > 0) ? $r->row()->bagian : "" ;					
			$s = $this->m_admin->getByID("md_jabatan","id_jabatan",$isi->id_jabatan);
			$jabatan = ($s->num_rows() > 0) ? $s->row()->jabatan : "" ;					
			
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = "<a href='master/karyawan/detail?id=$isi->id_karyawan'>$isi->id_karyawan</a>";
			$row[] = $isi->nama_lengkap;
			$row[] = $isi->nik;
			$row[] = $isi->email."|".$isi->no_hp;
			$row[] = $bagian;			
			$row[] = $jabatan;						
			$row[] = "
						<a href=\"master/karyawan/delete?id=$isi->id_karyawan\" onclick=\"return confirm('Anda yakin?')\" class=\"btn btn-danger btn-sm\">hapus</a>                          
            <a href=\"master/karyawan/edit?id=$isi->id_karyawan\" class=\"btn btn-primary btn-sm\">ubah</a>	
            <a href=\"master/karyawan/akun?id=$isi->id_karyawan\" onclick=\"return confirm('Anda yakin?')\" class=\"btn btn-success btn-sm\">set akun</a>";	
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->m_karyawan->count_all(),
						"recordsFiltered" => $this->m_karyawan->count_filtered(),
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
		$data['dt_bagian'] = $this->m_admin->getAll('md_bagian');		
		$data['dt_jabatan'] = $this->m_admin->getAll('md_jabatan');		
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
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."master/karyawan'>";
	}	
	public function akun()
	{		
		$waktu 		= gmdate("Y-m-d H:i:s", time()+60*60*7);		
		$tabel		= $this->tables;		
		$pk				= $this->pk;		
		$id = $this->input->get("id");
		$row = $this->m_admin->getByID("md_karyawan","id_karyawan",$id)->row();
		$data['id_karyawan'] 			= $row->id_karyawan;
		$data['nama_lengkap'] 			= $row->nama_lengkap;
		$data['email'] 		= $row->email;
		$data['no_hp'] 			= $row->no_hp;
		$data['tgl_daftar'] = $waktu;
		$data['status'] 			= 1;
		$pass = $this->m_admin->getByID("md_setting","id_setting","1")->row()->pass_karyawan;		
		$data['password'] = md5($pass);
		$data['jenis'] 			= "karyawan";
		$data['foto'] 			= $row->foto;		
		$data['created_at'] 			= $waktu;
		$sql = $this->m_admin->getByID("md_user","email",$row->email);
		if($sql->num_rows() == 0){
			$this->m_admin->insert("md_user",$data);					
			$_SESSION['pesan'] 		= "Akun berhasil dibuat";
			$_SESSION['tipe'] 		= "success";						
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."master/karyawan'>";					
		}else{
			$this->m_admin->update("md_user",$data,"email",$row->email);							
			$_SESSION['pesan'] 		= "Akun berhasil direset";
			$_SESSION['tipe'] 		= "success";						
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."master/karyawan'>";					
		}				
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

		$data['nik'] 			= $this->input->post('nik');				
		$data['nama_lengkap'] 			= $this->input->post('nama_lengkap');						
		$data['email'] 			= $this->input->post('email');				
		$data['no_hp'] 			= $this->input->post('no_hp');				
		$data['id_bagian'] 			= $this->input->post('id_bagian');				
		$data['id_jabatan'] 			= $this->input->post('id_jabatan');				
		$data['tmt'] 			= $this->input->post('tmt');				
		$data['created_at'] 			= $waktu;
		if($err==""){
			$this->m_admin->insert($tabel,$data);					
			$_SESSION['pesan'] 		= "Data berhasil diubah";
			$_SESSION['tipe'] 		= "success";						
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."master/karyawan'>";					
		}else{
			$_SESSION['pesan'] 		= $err;
			$_SESSION['tipe'] 		= "danger";						
			echo "<script>history.go(-1)</script>";			
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

		$data['nik'] 			= $this->input->post('nik');				
		$data['nama_lengkap'] 			= $this->input->post('nama_lengkap');						
		$data['email'] 			= $this->input->post('email');				
		$data['no_hp'] 			= $this->input->post('no_hp');				
		$data['id_bagian'] 			= $this->input->post('id_bagian');				
		$data['id_jabatan'] 			= $this->input->post('id_jabatan');				
		$data['tmt'] 			= $this->input->post('tmt');				
		$data['status'] 			= $this->input->post('status');				
		$data['updated_at'] 			= $waktu;
		if($err==""){
			$this->m_admin->update($tabel,$data,$pk,$id);					
			$_SESSION['pesan'] 		= "Data berhasil diubah";
			$_SESSION['tipe'] 		= "success";						
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."master/karyawan'>";					
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
		$data['dt_bagian'] = $this->m_admin->getAll('md_bagian');		
		$data['dt_jabatan'] = $this->m_admin->getAll('md_jabatan');		
		$data['dt_karyawan'] = $this->m_admin->getByID($tabel,$pk,$id);		
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
		$data['dt_bagian'] = $this->m_admin->getAll('md_bagian');		
		$data['dt_jabatan'] = $this->m_admin->getAll('md_jabatan');		
		$data['dt_karyawan'] = $this->m_admin->getByID($tabel,$pk,$id);
		$data['mode']		= "detail";				
		$this->template($data);	
	}
}
