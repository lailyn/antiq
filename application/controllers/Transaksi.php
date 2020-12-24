<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaksi extends CI_Controller {

	var $tables =   "md_transaksi";		
	var $page		=		"transaksi";
	var $pk     =   "id_transaksi";
	var $title  =   "Transaksi";
	var $bread	=   "<ol class='breadcrumb'>
	<li class='breadcrumb-item active'><a href='transaksi'>Transaksi</a></li>										
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
		$this->template($data);	
	}
	public function ajax_list()
	{
		$list = $this->m_transaksi->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $isi) {			
			
			$cek1 = $this->m_admin->getByID("md_jenis","id_jenis",$isi->id_jenis);
			$jenis = ($cek1->num_rows() > 0) ? $cek1->row()->jenis : '' ;
			
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = "<a href='transaksi/detail?id=$isi->id_transaksi'>$isi->kode</a>";
			$row[] = $isi->tanggal;
			$row[] = $jenis;
			$row[] = $this->mata_uang($isi->kredit);						
			$row[] = $this->mata_uang($isi->debit);						
			$row[] = "
						<a href=\"transaksi/delete?id=$isi->id_transaksi\" onclick=\"return confirm('Anda yakin?')\" class=\"btn btn-danger btn-sm\">hapus</a>                          
            <a href=\"transaksi/edit?id=$isi->id_transaksi\" class=\"btn btn-primary btn-sm\">ubah</a>";	
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->m_transaksi->count_all(),
						"recordsFiltered" => $this->m_transaksi->count_filtered(),
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
		$data['id_jenis_simpan']		= "";
		$data['tanggal_simpan']		= "";
		$data['bayar_simpan']		= "";
		$data['dt_jenis'] = $this->m_admin->getByID("md_jenis","status",1);									
		$data['dt_bayar'] = $this->m_admin->getByID("md_bayar","status",1);									
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
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."transaksi'>";
	}	
	public function cari_id(){							
		$tgl = gmdate("d", time()+60*60*7);
		$ra = rand(10,99);
		$pr_num = $this->db->query("SELECT * FROM md_transaksi ORDER BY id_transaksi DESC LIMIT 0,1");							
		if($pr_num->num_rows() > 0){		
			$row 	= $pr_num->row();					
			$pan  = strlen($row->kode)-4;
			$id 	= substr($row->kode,$pan,7)+1;	
			if($id < 10){
				$kode1 = "0000".$id;          					
			}elseif($id>9 && $id<=99){
				$kode1 = "000".$id;          					
			}elseif($id>99 && $id<=999){
				$kode1 = "00".$id;          					
			}elseif($id>999){
				$kode1 = "0".$id;          					
			}
			$kode = "AN".$ra.$kode1;
		}else{
			$kode = "AN".$ra."00001";
		}						
		return $kode;
	}
	public function save()
	{		
		$waktu 		= gmdate("Y-m-d H:i:s", time()+60*60*7);		
		$tabel		= $this->tables;		
		$pk				= $this->pk;
		$data['created_by'] = $this->session->userdata("id_user");
		$data['id_jenis'] 	= $data2['id_jenis_simpan']		= $this->input->post('id_jenis');				
		$data['kode'] 			= $this->cari_id();
		$data['keterangan'] 			= $this->input->post('keterangan');		
		$bayar 			= $this->input->post('bayar');						
		if($bayar=="kredit"){
			$data2['bayar_simpan'] = "kredit";
			$data['kredit'] 			= $this->m_admin->ubah_rupiah($this->input->post("nominal"));
			$data['admin2'] 			= $this->m_admin->ubah_rupiah($this->input->post("admin"));
		}else{
			$data2['bayar_simpan'] = "debit";
			$data['debit'] 			= $this->m_admin->ubah_rupiah($this->input->post("nominal"));			
			$data['admin1'] 			= $this->m_admin->ubah_rupiah($this->input->post("admin"));			
		}
		$data['piutang'] 			= $this->m_admin->ubah_rupiah($this->input->post("piutang"));
		$data['tanggal'] 	= $data2['tanggal_simpan']		= $this->input->post('tanggal');									
		$data['created_at'] 			= $waktu;
		
		$this->m_admin->insert($tabel,$data);					
		$_SESSION['pesan'] 		= "Data berhasil disimpan";
		$_SESSION['tipe'] 		= "success";				
		
		$data2['isi']    = $this->page;		
		$data2['title']	= "Tambah ".$this->title;	
		$data2['bread']	= $this->bread;																															
		$data2['set']		= "insert";	
		$data2['mode']		= "insert";		
		$data2['dt_jenis'] = $this->m_admin->getByID("md_jenis","status",1);									
		$data2['dt_bayar'] = $this->m_admin->getByID("md_bayar","status",1);									
		$this->template($data2);			
		
	}	
	public function update()
	{		
		$waktu 		= gmdate("Y-m-d H:i:s", time()+60*60*7);		
		$tabel		= $this->tables;		
		$pk				= $this->pk;		
		
		$id 			= $this->input->post('id');				
		$data['id_jenis'] 			= $this->input->post('id_jenis');						
		$data['keterangan'] 			= $this->input->post('keterangan');						
		$bayar 			= $this->input->post('bayar');						
		if($bayar=="kredit"){
			$data['kredit'] 			= $this->m_admin->ubah_rupiah($this->input->post("nominal"));
			$data['admin2'] 			= $this->m_admin->ubah_rupiah($this->input->post("admin"));
		}else{
			$data['debit'] 			= $this->m_admin->ubah_rupiah($this->input->post("nominal"));			
			$data['admin1'] 			= $this->m_admin->ubah_rupiah($this->input->post("admin"));			
		}
		$data['piutang'] 			= $this->m_admin->ubah_rupiah($this->input->post("piutang"));
		$data['tanggal'] 			= $this->input->post('tanggal');									
		$data['updated_at'] 			= $waktu;
		$data['updated_by'] = $id_user = $this->session->userdata("id_user");
		
		$this->m_admin->update($tabel,$data,$pk,$id);					
		$_SESSION['pesan'] 		= "Data berhasil diubah";
		$_SESSION['tipe'] 		= "success";						
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."transaksi'>";					
		
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
		$data['dt_jenis'] = $this->m_admin->getByID("md_jenis","status",1);									
		$data['dt_bayar'] = $this->m_admin->getByID("md_bayar","status",1);									
		$data['dt_transaksi'] = $this->m_admin->getByID($tabel,$pk,$id);		
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
		$data['dt_jenis'] = $this->m_admin->getByID("md_jenis","status",1);									
		$data['dt_bayar'] = $this->m_admin->getByID("md_bayar","status",1);											
		$data['dt_transaksi'] = $this->m_admin->getByID($tabel,$pk,$id);
		$data['mode']		= "detail";				
		$this->template($data);	
	}
	public function cek_jenis()
	{
		$id_jenis	= $this->input->post('id_jenis');		
		$dt_kab = $this->db->query("SELECT * FROM md_jenis WHERE id_jenis='1'");
		$dt = ($dt_kab->num_rows() > 0) ? $dt_kab->row()->id_bayar : "" ;
		if($dt!=""){
			$hasil = explode(",", $dt);
			foreach ($hasil as $isi) {
				$cek = $this->m_admin->getByID("md_bayar","id_bayar",$isi)->row();
				echo "<option value='$cek->id_bayar'>$cek->bayar</option>";
			}
		}		
		echo $data;				
	}
}
