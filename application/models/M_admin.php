<?php				
class M_admin extends CI_Model{
	 
		// Menampilkan data dari sebuah tabel dengan pagination.
		public function getList($tables,$limit,$page,$by,$sort){
				$this->db->order_by($by,$sort);
				$this->db->limit($limit,$page);
				return $this->db->get($tables);
		}
		
		// menampilkan semua data dari sebuah tabel.
		public function getAll($tables){
				$db = $this->db->database;
				$cek = $this->db->query("SELECT GROUP_CONCAT(COLUMN_NAME) AS primary_id FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE
								WHERE TABLE_SCHEMA = '$db' AND CONSTRAINT_NAME='PRIMARY' AND TABLE_NAME = '$tables'");
				if($cek->num_rows() > 0){
						$f = $cek->row();
						$id = $f->primary_id;
						$this->db->order_by($id,"DESC");        
				}
				return $this->db->get($tables);
		}
		
		// menghitun jumlah record dari sebuah tabel.
		public function countAll($tables){
				return $this->db->get($tables)->num_rows();
		}
		public function ubah_rupiah($nominal)
		{
			$rupiah = str_replace(',', '', $nominal);		
			return $rupiah;
		}
		
		// menghitun jumlah record dari sebuah query.
		public function countQuery($query){
				return $this->db->get($query)->num_rows();
		}
		
		//enampilkan satu record brdasarkan parameter.
		public function kondisi($tables,$where)
		{
				$this->db->where($where);
				return $this->db->get($tables);
		}
		public function kondisiCond($tables,$where)
		{
				$this->db->where($where)
								 ->where("active",1);
				return $this->db->get($tables);
		}
		//menampilkan satu record brdasarkan parameter.
		public  function getByID($tables,$pk,$id){
				$this->db->where($pk,$id);
				return $this->db->get($tables);
		}
		
		// Menampilkan data dari sebuah query dengan pagination.
		public function queryList($query,$limit,$page){
			 
				return $this->db->query($query." limit ".$page.",".$limit."");
		}
		
		public function getSortCond($tables,$by,$sort){
			 $this->db->select('*')
								->from($tables)								
								->order_by($by,$sort);
				return $this->db->get();
		}		
		//
		public function getSort($tables,$by,$sort){
			 $this->db->select('*')
								->from($tables)                
								->order_by($by,$sort);
				return $this->db->get();
		}
		// memasukan data ke database.
		public function insert($tables,$data){
				$this->db->insert($tables,$data);
		}
		
		// update data kedalalam sebuah tabel
		public function update($tables,$data,$pk,$id){
				$this->db->where($pk,$id);
				$this->db->update($tables,$data);
		}
		
		// menghapus data dari sebuah tabel
		public function delete($tables,$pk,$id){
				$this->db->where($pk,$id);
				$this->db->delete($tables);
		}
		
		function login($username,$password)
		{
				$sql =  "SELECT * FROM md_user WHERE email=? AND password = ? AND status = 1";        				
				return $this->db->query($sql, array($username, $password));
		}
		function login_user($username)
		{
				$sql =  "SELECT * FROM md_user WHERE email=? AND status = 1";        				
				return $this->db->query($sql, array($username));
		}	

		function guest()
		{
			$user_type = $this->session->userdata("user_type");
			if($user_type == 7){
				$data = "style='display:none;'";
			}else{
				$data = "";
			}
			return $data;
		}
		function set_notif($user_id,$notif,$tipe=null,$order_id=null)
		{
			$waktu   = gmdate("Y-m-d H:i:s", time() + 60 * 60 * 7);		
			$data['user_id'] = $user_id;
			$data['notif'] = $notif;
			$data['created_at'] = $waktu;
			if($tipe != null OR $order_id != null) {
				$data['tipe'] = $tipe;
				$data['order_id'] = $order_id;
			}
			$this->insert("ind_notif",$data);			
		}		
		function get_token($panjang){
        $token = array(
            range(1,9)
        );

        $karakter = array();
        foreach($token as $key=>$val){
            foreach($val as $k=>$v){
                $karakter[] = $v;
            }
        }

        $token = null;
        for($i=1; $i<=$panjang; $i++){
            // mengambil array secara acak
            $token .= $karakter[rand($i, count($karakter) - 1)];
        }

        return $token;
    }
}	

?>
