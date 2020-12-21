<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dokter extends CI_Controller {

	var $tables =   "md_dokter";		
	var $page		=		"master/dokter";
	var $pk     =   "id_dokter";
	var $title  =   "Dokter";
	var $bread	=   "<ol class='breadcrumb'>
	<li class='breadcrumb-item'><a>Master</a></li>										
	<li class='breadcrumb-item active'><a href='master/dokter'>Dokter</a></li>										
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
		$this->load->model('m_dokter');		

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
		//$data['dt_dokter'] = $this->db->query("SELECT md_dokter.*,md_kategori.kategori FROM md_dokter LEFT JOIN md_kategori ON md_dokter.id_kategori = md_kategori.id_kategori ORDER BY md_dokter.id_dokter DESC");
		$this->template($data);	
	}
	public function ajax_list()
	{
		$list = $this->m_dokter->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $isi) {
			$r = $this->m_admin->getByID("md_kategori","id_kategori",$isi->id_kategori);
			$kategori = ($r->num_rows() > 0) ? $r->row()->kategori : "" ;					
			if($isi->status==1){
				$status = "aktif";
			}else{
				$status = "Non-Aktif";
			}

			if(!isset($isi->foto) AND $isi->foto==""){
        $foto = "user.png";
      }else{
        $foto = $isi->foto;
      }

			$no++;
			$row = array();
			$row[] = $no;
			$row[] = "<a href='master/dokter/detail?id=$isi->id_dokter'><img src='assets/im493/$foto' class='mr-2'> $isi->nama </td></a>";						
			$row[] = $isi->nip;
			$row[] = $isi->jk;
			$row[] = $isi->email."|".$isi->no_hp;
			$row[] = $isi->tmt;
			$row[] = $kategori;			
			$row[] = $status;			
			$row[] = "
						<a href=\"master/dokter/delete?id=$isi->id_dokter\" onclick=\"return confirm('Anda yakin?')\" class=\"btn btn-danger btn-sm\">hapus</a>                          
            <a href=\"master/dokter/edit?id=$isi->id_dokter\" class=\"btn btn-primary btn-sm\">ubah</a>
            <a href=\"master/dokter/akun?id=$isi->id_dokter\" onclick=\"return confirm('Anda yakin?')\" class=\"btn btn-success btn-sm\">set akun</a>";	
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->m_dokter->count_all(),
						"recordsFiltered" => $this->m_dokter->count_filtered(),
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
		$data['dt_kategori'] = $this->m_admin->getAll('md_kategori');		
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
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."master/dokter'>";
	}	
	public function akun()
	{		
		$waktu 		= gmdate("Y-m-d H:i:s", time()+60*60*7);		
		$tabel		= $this->tables;		
		$pk				= $this->pk;		
		$id = $this->input->get("id");
		$row = $this->m_admin->getByID("md_dokter","id_dokter",$id)->row();
		$data['id_dokter'] 			= $row->id_dokter;
		$data['nama_lengkap'] 			= $row->nama;
		$data['email'] 		= $row->email;
		$data['no_hp'] 			= $row->no_hp;
		$data['tgl_daftar'] = $waktu;
		$pass = $this->m_admin->getByID("md_setting","id_setting","1")->row()->pass_dokter;		
		$data['password'] = md5($pass);
		$data['status'] 			= 1;
		$data['jenis'] 			= "dokter";
		$data['foto'] 			= $row->foto;		
		$data['created_at'] 			= $waktu;
		$sql = $this->m_admin->getByID("md_user","email",$row->email);
		if($sql->num_rows() == 0){
			$this->m_admin->insert("md_user",$data);					
			$_SESSION['pesan'] 		= "Akun berhasil dibuat";
			$_SESSION['tipe'] 		= "success";						
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."master/dokter'>";					
		}else{
			$this->m_admin->update("md_user",$data,"email",$row->email);							
			$_SESSION['pesan'] 		= "Akun berhasil direset";
			$_SESSION['tipe'] 		= "success";						
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."master/dokter'>";					
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

		$data['nip'] 			= $this->input->post('nip');				
		$data['nama'] 			= $this->input->post('nama');				
		$data['jk'] 			= $this->input->post('jk');				
		$data['tgl_lahir'] 			= $this->input->post('tgl_lahir');				
		$data['tempat_lahir'] 			= $this->input->post('tempat_lahir');				
		$data['biografi'] 			= $this->input->post('biografi');				
		$data['agama'] 			= $this->input->post('agama');				
		$data['jenis_id'] 			= $this->input->post('jenis_id');				
		$data['no_id'] 			= $this->input->post('no_id');				
		$data['alamat'] 			= $this->input->post('alamat');				
		$data['email'] 			= $this->input->post('email');				
		$data['id_kategori'] 			= $this->input->post('id_kategori');				
		$data['no_hp'] 			= $this->input->post('no_hp');				
		$data['tmt'] 			= $this->input->post('tmt');				
		$data['pendidikan'] 			= $this->input->post('pendidikan');		
		$data['tahun_lulus'] 			= $this->input->post('tahun_lulus');						
		$data['status'] 			= $this->input->post('status');				
		$data['durasi'] 			= $this->input->post('durasi');				
		$data['tarif'] 			= $this->m_admin->ubah_rupiah($this->input->post('tarif'));				
		$data['online'] 			= $this->input->post('online');				
		$data['created_at'] 			= $waktu;
		if($err==""){
			$this->m_admin->insert($tabel,$data);					
			$_SESSION['pesan'] 		= "Data berhasil diubah";
			$_SESSION['tipe'] 		= "success";						
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."master/dokter'>";					
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
				$row = $this->m_admin->getByID("md_dokter","id_dokter",$id)->row();
	    	if(isset($row->foto)){
	    		unlink('assets/im493/'.$row->foto);         	    		
	    	}
				$data['foto']	= $this->upload->file_name;
			}
		}

		$data['nip'] 			= $this->input->post('nip');				
		$data['nama'] 			= $this->input->post('nama');				
		$data['jk'] 			= $this->input->post('jk');				
		$data['tgl_lahir'] 			= $this->input->post('tgl_lahir');			
		$data['biografi'] 			= $this->input->post('biografi');					
		$data['tempat_lahir'] 			= $this->input->post('tempat_lahir');				
		$data['agama'] 			= $this->input->post('agama');				
		$data['jenis_id'] 			= $this->input->post('jenis_id');				
		$data['no_id'] 			= $this->input->post('no_id');				
		$data['alamat'] 			= $this->input->post('alamat');				
		$data['email'] 			= $this->input->post('email');				
		$data['no_hp'] 			= $this->input->post('no_hp');				
		$data['tmt'] 			= $this->input->post('tmt');				
		$data['pendidikan'] 			= $this->input->post('pendidikan');				
		$data['tahun_lulus'] 			= $this->input->post('tahun_lulus');				
		$data['id_kategori'] 			= $this->input->post('id_kategori');				
		$data['status'] 			= $this->input->post('status');	
		$data['durasi'] 			= $this->input->post('durasi');				
		$data['tarif'] 			= $this->m_admin->ubah_rupiah($this->input->post('tarif'));				
		$data['online'] 			= $this->input->post('online');							
		$data['updated_at'] 			= $waktu;
		if($err==""){
			$this->m_admin->update($tabel,$data,$pk,$id);					
			$_SESSION['pesan'] 		= "Data berhasil diubah";
			$_SESSION['tipe'] 		= "success";						
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."master/dokter'>";					
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
		$data['dt_kategori'] = $this->m_admin->getAll('md_kategori');
		$data['dt_dokter'] = $this->m_admin->getByID($tabel,$pk,$id);		
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
		$data['dt_kategori'] = $this->m_admin->getAll('md_kategori');
		$data['dt_dokter'] = $this->m_admin->getByID($tabel,$pk,$id);
		$data['mode']		= "detail";				
		$this->template($data);	
	}
}
