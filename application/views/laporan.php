<?php  
function mata_uang($a){      
  if(is_numeric($a) AND $a != 0 AND $a != ""){
    return number_format($a, 0, ',', '.');
  }else{
    return $a;
  }
}
function manipulasiTanggal($tgl,$jumlah=-1,$format='days',$bentuk="Y-m-d"){
  $currentDate = new DateTime($tgl);
  $currentDate -> modify($jumlah.' '.$format);
  return $currentDate -> format('Y-m-d');
}
?>
     

		<?php 
    if($set=="download"){
      $no = date("his");
      header("Content-type: application/octet-stream");
      header("Content-Disposition: attachment; filename=".$no."rekap.xls");
      header("Pragma: no-cache");
      header("Expires: 0");         
      ?>
      
                  
      <table id="example" class="table table-bordered" style="width:100%">
        <thead>
          <tr>
            <?php     
            $dana_tunai = 0;                    
            $kemarin = manipulasiTanggal($tgl,-1);                        
            $sql = $this->m_admin->getByID("md_jenis","status",1);
            foreach ($sql->result() as $isi) {
              $id = $isi->id_jenis;
              $cek_kemarin = $this->db->get_where("md_transaksi",array("id_jenis"=>$isi->id_jenis,"tanggal"=>$kemarin));
              if($cek_kemarin->num_rows() > 0){
                $am = $this->db->query("SELECT * FROM md_rekap WHERE tgl = '$kemarin' AND id_jenis = '$isi->id_jenis'");
                $saldo_awal[$id] = $am->row()->tunai + $am->row()->saldo;
              }else{
                $saldo_awal[$id] = $this->db->get_where("md_jenis",array("id_jenis"=>$isi->id_jenis))->row()->saldo_awal;                            
              }

              if($isi->jenis=="Pospay"){
                echo "
                <td bgcolor='yellow' align='center' valign='middle' colspan='3' rowspan='4'><font size='18px'>$isi->jenis</font></th>
                <th>Saldo Awal</th>
                <th>".mata_uang($saldo_awal[$id])."</th>                            
                ";
              }elseif($isi->jenis=="Dana Tunai"){
                echo "
                <td bgcolor='yellow' align='center' valign='middle' colspan='3' rowspan='4'><font size='18px'>$isi->jenis</font></th>                            
                ";
              }else{
                echo "
                <td bgcolor='yellow' align='center' valign='middle' colspan='5' rowspan='4'><font size='18px'>$isi->jenis</font></th>
                <th colspan='2'>Saldo Awal</th>
                <th>".mata_uang($saldo_awal[$id])."</th>
                ";
              }
            }
            ?>                        
          </tr>
          <tr>
            <?php 
            foreach ($sql->result() as $isi) {
              $id = $isi->id_jenis;
              $cek_tgl = date('d', strtotime($tgl)); 
              $amb_debit = $this->db->query("SELECT SUM(debit) as jum From md_transaksi WHERE tanggal = '$tgl' AND id_jenis = '$isi->id_jenis'");
              if($cek_tgl>1){
                $am = $this->db->query("SELECT * FROM md_rekap WHERE tgl = '$kemarin' AND id_jenis = '$isi->id_jenis'");
                $tunai_kemarin[$id] = ($am->num_rows()>0) ? $am->row()->tunai: 0 ;                                                                                        
                $sum_debit = $amb_debit->row()->jum + $tunai_kemarin[$id];
              }else{
                $sum_debit = $amb_debit->row()->jum;
              }
              if($isi->jenis=="Pospay"){
                echo "                          
                <th>Debet</th>
                <th>".mata_uang($sum_debit)."</th>
                ";
              }elseif($isi->jenis!='Dana Tunai'){                            
                echo "                          
                <th colspan='2'>Debet</th>
                <th>".mata_uang($sum_debit)."</th>
                ";                          
              }
            }
            ?>                        
          </tr>
          <tr>
            <?php 
            foreach ($sql->result() as $isi) {
              $amb_kredit = $this->db->query("SELECT SUM(kredit) as jum From md_transaksi WHERE tanggal = '$tgl' AND id_jenis = '$isi->id_jenis'");                          
              if($isi->jenis=="Pospay"){
                echo "                          
                <th>Kredit</th>
                <th>".mata_uang($sum_kredit = $amb_kredit->row()->jum)."</th>
                ";
              }elseif($isi->jenis!='Dana Tunai'){                            
                echo "                          
                <th colspan='2'>Kredit</th>
                <th>".mata_uang($sum_kredit = $amb_kredit->row()->jum)."</th>
                ";                          
              }
            }
            ?>                        
          </tr>
          <tr>
            <?php 
            $dana_tunai = 0;
            foreach ($sql->result() as $isi) {
              $cek_tgl = date('d', strtotime($tgl)); 

              $id = $isi->id_jenis;
              $amb_debit = $this->db->query("SELECT SUM(debit) as jum From md_transaksi WHERE tanggal = '$tgl' AND id_jenis = '$isi->id_jenis'");                          
              if($cek_tgl>1){
                $am = $this->db->query("SELECT * FROM md_rekap WHERE tgl = '$kemarin' AND id_jenis = '$isi->id_jenis'");
                $tunai_kemarin[$id] = ($am->num_rows()>0) ? $am->row()->tunai: 0 ;                                                                                        
                $sum_debit = $amb_debit->row()->jum + $tunai_kemarin[$id];
              }else{
                $sum_debit = $amb_debit->row()->jum;
              }
              $sum_admin = $this->db->query("SELECT SUM(admin1) as jum From md_transaksi WHERE tanggal = '$tgl' AND id_jenis = '$isi->id_jenis'")->row()->jum;                                                  
              $sum_piutang = $this->db->query("SELECT SUM(piutang) as jum From md_transaksi WHERE tanggal = '$tgl' AND id_jenis = '$isi->id_jenis'")->row()->jum;                          
              if($isi->jenis=="Pospay"){
                $tunai[$id] = $sum_admin + $sum_debit;
                $dana_tunai+=$tunai[$id];
                echo "                          
                <th>Tunai</th>
                <th>".mata_uang($tunai[$id])."</th>
                ";
              }elseif($isi->jenis!='Dana Tunai'){                            
                $tunai[$id] = $sum_admin + $sum_debit - $sum_piutang;                          
                $dana_tunai+=$tunai[$id];
                echo "                          
                <th colspan='2'>Tunai</th>
                <th>".mata_uang($tunai[$id])."</th>
                ";                          
              }else{
                $tunai[$id] = 0;
              }
            }
            ?>                        
          </tr>                     
        </thead>
        <tbody>                      
          <tr>
            <?php 
            foreach ($sql->result() as $isi) {
              if($isi->jenis!="Pospay" AND $isi->jenis!="Dana Tunai"){
                echo "
                <th width='3%'>No</th>
                <td>Debet</td>
                <td></td>
                <td>Kredit</td>
                <td>Admin</td>
                <td>Piutang</td>
                <td>Admin</td>
                <td>Saldo</td>
                ";
              }elseif($isi->jenis=="Pospay"){
                echo "
                <td width='3%'>No</td>
                <td>Debet</td>
                <td>Kredit</td>
                <td>Admin</td>
                <td>Saldo</td>
                ";
              }elseif($isi->jenis=="Dana Tunai"){
                echo "
                <td>Lain-lain</td>
                <td>Tujuan</td>                            
                <td align='right'><b>".mata_uang($dana_tunai)."</b></td>                            
                ";
              }
            }
            ?>
          </tr>
          <?php      
          $no=1;                                                 
          foreach ($sql->result() as $key) {                        
            $id = $key->id_jenis;
            $t_debit[$id]=0;                        
            $t_kredit[$id]=0;                        
            $t_admin1[$id]=0;                        
            $t_admin2[$id]=0;                        
            $t_piutang[$id]=0;                        
            $t_saldo[$id]=0;                        
          }
          foreach ($sql->result() as $isi) {
            $cek_tgl = date('d', strtotime($tgl)); 
            if($cek_tgl>1){
              $id = $isi->id_jenis;
              $am = $this->db->query("SELECT * FROM md_rekap WHERE tgl = '$kemarin' AND id_jenis = '$isi->id_jenis'");
              $tunai_kemarin[$id] = ($am->num_rows()>0) ? $am->row()->tunai: 0 ;
              $saldo[$id] = $saldo_awal[$id] - $tunai_kemarin[$id];
              if($isi->jenis!="Pospay" AND $isi->jenis!="Dana Tunai"){
                echo "                          
                  <td></td>
                  <td align='right'>".mata_uang($tunai_kemarin[$id])."</td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td align='right'>".mata_uang($saldo[$id])."</td>
                ";
              }elseif($isi->jenis=="Pospay"){
                echo "                          
                  <td></td>
                  <td align='right'>".mata_uang($tunai_kemarin[$id])."</td>                                                            
                  <td></td>
                  <td></td>
                  <td align='right'>".mata_uang($saldo[$id])."</td>
                ";
              }else{
                echo "                                                        
                  <td align='right'></td>                                                                                          
                  <td></td>
                  <td align='right'>".mata_uang($dana_tunai)."</td>
                ";
              }
            }
          }                 
                                
          $cek_maks = $this->db->query("SELECT COUNT(kode) AS jum FROM md_transaksi WHERE tanggal = '$tgl' GROUP BY id_jenis ORDER BY jum DESC LIMIT 0,1");
          $maks = ($cek_maks->num_rows() > 0) ? $cek_maks->row()->jum : 0 ;
          for ($i=0; $i <= $maks; $i++) {                      
            echo "
            <tr>";   
              $kredit_dana_t=0;                                              
              foreach ($sql->result() as $isi) {
                $id = $isi->id_jenis;        
                $cek_tgl = date('d', strtotime($tgl)); 


                $cek_debet = $this->db->query("SELECT * FROM md_transaksi WHERE id_jenis = '$isi->id_jenis' AND tanggal = '$tgl' ORDER BY id_transaksi ASC LIMIT $i,1");
                $debit[$id] = ($cek_debet->num_rows() > 0) ? $cek_debet->row()->debit : 0 ;                            
                $kredit[$id] = ($cek_debet->num_rows() > 0) ? $cek_debet->row()->kredit : 0 ;                            
                $piutang[$id] = ($cek_debet->num_rows() > 0) ? $cek_debet->row()->piutang : 0 ;                            
                $admin1[$id] = ($cek_debet->num_rows() > 0) ? $cek_debet->row()->admin1 : 0 ;                            
                $admin2[$id] = ($cek_debet->num_rows() > 0) ? $cek_debet->row()->admin2 : 0 ;  
                $ket = ($cek_debet->num_rows() > 0) ? $cek_debet->row()->keterangan : "" ;                          

                $cek_dana = $this->db->query("SELECT * FROM md_transaksi INNER JOIN md_jenis ON md_transaksi.id_jenis = md_jenis.id_jenis 
                    WHERE jenis = 'Dana Tunai' AND tanggal = '$tgl' ORDER BY id_transaksi ASC LIMIT $i,1");
                $kredit_dana = ($cek_dana->num_rows() > 0) ? $cek_dana->row()->kredit : 0 ;                            

                $cek_kemarin = $this->db->get_where("md_transaksi",array("id_jenis"=>$isi->id_jenis,"tanggal"=>$kemarin));
                if($cek_kemarin->num_rows() > 0){
                  $am = $this->db->query("SELECT * FROM md_rekap WHERE tgl = '$kemarin' AND id_jenis = '$isi->id_jenis'");
                  $saldo_awal[$id] = $am->row()->tunai + $am->row()->saldo;
                  $saldo_1[$id] = $saldo_awal[$id];
                }else{
                  $saldo_awal[$id] = $this->db->get_where("md_jenis",array("id_jenis"=>$isi->id_jenis))->row()->saldo_awal;                            
                  $saldo_1[$id] = 0;
                }                         
                                                                    
                

                if($cek_tgl>1){
                  $am = $this->db->query("SELECT * FROM md_rekap WHERE tgl = '$kemarin' AND id_jenis = '$isi->id_jenis'");
                  $tunai_kemarin[$id] = ($am->num_rows()>0) ? $am->row()->tunai: 0 ;
                  $saldo[$id] = $saldo_awal[$id] - $tunai_kemarin[$id];
                  if($no==1) $saldo[$id] = ($saldo[$id] - $debit[$id]) + $kredit[$id];                              
                    else $saldo[$id] = ($t_saldo[$id] - $debit[$id]) + $kredit[$id];                              
                  $dana_tunai += $saldo[$id];
                }else{
                  if($no==1) $saldo[$id] = ($saldo_awal[$id] - $debit[$id]) + $kredit[$id];
                    else $saldo[$id] = ($t_saldo[$id] - $debit[$id]) + $kredit[$id];                              
                  $dana_tunai += $saldo[$id];
                }

                if($no==1) $t_saldo[$id] += $saldo[$id];
                  else $t_saldo[$id] = $saldo[$id];   

                if($no==1) $saldo_dana = $dana_tunai;
                  else $saldo_dana += $kredit_dana;   
                           
                //$kredit_dana_t += $kredit_dana;                  
              
                if($isi->jenis!="Pospay" AND $isi->jenis!="Dana Tunai"){
                  echo "                              
                  <th>$no</th>
                  <td align='right'>".mata_uang($debit[$id])."</td>
                  <td></td>
                  <td align='right'>".mata_uang($kredit[$id])."</td>
                  <td align='right'>".mata_uang($admin1[$id])."</td>
                  <td align='right'>".mata_uang($piutang[$id])."</td>
                  <td align='right'>".mata_uang($admin2[$id])."</td>
                  <td align='right'>".mata_uang($saldo[$id])."</td>
                  ";
                }elseif($isi->jenis=="Pospay"){
                  echo "                              
                  <td>$no</td>
                  <td align='right'>".mata_uang($debit[$id])."</td>
                  <td align='right'>".mata_uang($kredit[$id])."</td>
                  <td align='right'>".mata_uang($admin1[$id])."</td>
                  <td align='right'>".mata_uang($saldo[$id])."</td>
                  ";
                }elseif($isi->jenis=="Dana Tunai"){
                  echo "                              
                  <td align='right'>".mata_uang($kredit[$id])."</td>
                  <td align='right'></td>
                  <td align='right'>".mata_uang($saldo_dana)."</td>                                                                                      
                  ";
                }
                

                $t_debit[$id] += $debit[$id];
                $t_kredit[$id] += $kredit[$id];
                $t_admin1[$id] += $admin1[$id];
                $t_admin2[$id] += $admin2[$id];
                $t_piutang[$id] += $piutang[$id];
                
                $data['id_jenis'] = $isi->id_jenis; 
                $data['tgl'] = $tgl;        
                if($cek_tgl>1){
                  $am = $this->db->query("SELECT * FROM md_rekap WHERE tgl = '$kemarin' AND id_jenis = '$isi->id_jenis'");
                  $tunai_kemarin[$id] = ($am->num_rows()>0) ? $am->row()->tunai: 0 ;                                                                                        
                  $data['debit'] = $t_debit[$id] + $tunai_kemarin[$id];                            
                }else{                               
                  $data['debit'] = $t_debit[$id];                            
                }
                if($isi->jenis=="Dana Tunai"){
                  $data['saldo'] = $saldo_dana;                            
                }else{                                               
                  $data['saldo'] = $t_saldo[$id];                            
                }
                $data['kredit'] = $t_kredit[$id]; 
                $data['admin1'] = $t_admin1[$id]; 
                $data['admin2'] = $t_admin2[$id]; 
                $data['tunai'] = $tunai[$id]; 
                $cek = $this->db->query("SELECT * FROM md_rekap WHERE id_jenis = '$isi->id_jenis' AND tgl = '$tgl'");
                if($cek->num_rows() > 0){
                  $this->m_admin->update("md_rekap",$data,"id_rekap",$cek->row()->id_rekap);
                }else{
                  $this->m_admin->insert("md_rekap",$data);
                }                            
              
              }
                $no++;

              echo "
            </tr>
            ";

          }
          ?>   
        </tbody>
        <tfoot>                      
            <?php 
            echo "
            <tr>"; 
              foreach ($sql->result() as $isi) {  
                $id = $isi->id_jenis;            
                if($cek_tgl>1){
                  $am = $this->db->query("SELECT * FROM md_rekap WHERE tgl = '$kemarin' AND id_jenis = '$isi->id_jenis'");
                  $tunai_kemarin[$id] = ($am->num_rows()>0) ? $am->row()->tunai: 0 ;                                                                                        
                  $t_debit[$id] = $t_debit[$id] + $tunai_kemarin[$id];
                }else{
                  $t_debit[$id] = $t_debit[$id];
                }              
                if($isi->jenis!="Pospay" AND $isi->jenis!="Dana Tunai"){
                  echo "                              
                  <th>Total</th>
                  <td align='right'>".mata_uang($t_debit[$id])."</td>
                  <td></td>
                  <td align='right'>".mata_uang($t_kredit[$id])."</td>
                  <td align='right'>".mata_uang($t_admin1[$id])."</td>
                  <td align='right'>".mata_uang($t_piutang[$id])."</td>
                  <td align='right'>".mata_uang($t_admin2[$id])."</td>
                  <td align='right'>".mata_uang($t_saldo[$id])."</td>
                  ";
                }elseif($isi->jenis=="Pospay"){
                  echo "                              
                  <th>Total</th>
                  <td align='right'>".mata_uang($t_debit[$id])."</td>
                  <td align='right'>".mata_uang($t_kredit[$id])."</td>
                  <td align='right'>".mata_uang($t_admin1[$id])."</td>
                  <td align='right'>".mata_uang($t_saldo[$id])."</td>
                  ";
                }elseif($isi->jenis=="Dana Tunai"){
                  echo "                                                            
                  <td align='right'></td>
                  <td align='right'></td>                                                      
                  <td align='right'></td>
                  ";
                }
            

              }
              echo "
            </tr>
            ";
            ?>
          
        </tfoot>                    
      </table>                                   
        
    <?php }elseif($set=="filter"){ ?>

<body onload="<?php echo $ec = (isset($_GET['id'])) ? "cek_jenis()" : "" ; ?>">
<div class="main-panel" style="margin-top:-30px;">
  <div class="content-wrapper">    
    <div class="page-header">
      <h3 class="page-title">
        </span> <?php echo $title ?> </h3>
        <nav aria-label="breadcrumb">
            <?php echo $bread ?>
        </nav>
      </div>

      <div class="row">
        <div class="col-12 grid-margin">
          <div class="card">
            <div class="card-header">
              <form action="laporan/filter" method="POST" enctype="multipart/form-data" class="form-sample">                              
              <h4 class="card-title">
                <button type="submit" name="filter" value="filter" class="btn btn-primary btn-sm"><i class="mdi mdi-filter"></i> Filter</button>
                <button type="submit" name="download" value="download" class="btn btn-success btn-sm"><i class="mdi mdi-download"></i> Download</button>
              </h4>
            </div>
            <div class="card-body">
              <div class="box">                            
                <div class="row">
                  <div class="col-12">  
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label">Tanggal</label>
                      <div class="col-sm-4">
                        <input type="date" name="tanggal" value="<?php echo $tgl = ($tgl!="") ? $tgl : date("Y-m-d") ; ?>" class="form-control">
                      </div>                                                          
                    </div>
                  </div>
                  </form>
                </div>  
                <div class="table-responsive">
                  
                  <table id="example" class="table table-bordered" style="width:100%">
                    <thead>
                      <tr>
                        <?php     
                        $dana_tunai = 0;                    
                        $kemarin = manipulasiTanggal($tgl,-1);                        
                        $sql = $this->m_admin->getByID("md_jenis","status",1);
                        foreach ($sql->result() as $isi) {
                          $id = $isi->id_jenis;
                          $cek_kemarin = $this->db->get_where("md_transaksi",array("id_jenis"=>$isi->id_jenis,"tanggal"=>$kemarin));
                          if($cek_kemarin->num_rows() > 0){
                            $am = $this->db->query("SELECT * FROM md_rekap WHERE tgl = '$kemarin' AND id_jenis = '$isi->id_jenis'");
                            $saldo_awal[$id] = $am->row()->tunai + $am->row()->saldo;
                          }else{
                            $saldo_awal[$id] = $this->db->get_where("md_jenis",array("id_jenis"=>$isi->id_jenis))->row()->saldo_awal;                            
                          }

                          if($isi->jenis=="Pospay"){
                            echo "
                            <td bgcolor='yellow' align='center' valign='middle' colspan='3' rowspan='4'><font size='18px'>$isi->jenis</font></th>
                            <th>Saldo Awal</th>
                            <th>".mata_uang($saldo_awal[$id])."</th>                            
                            ";
                          }elseif($isi->jenis=="Dana Tunai"){
                            echo "
                            <td bgcolor='yellow' align='center' valign='middle' colspan='3' rowspan='4'><font size='18px'>$isi->jenis</font></th>                            
                            ";
                          }else{
                            echo "
                            <td bgcolor='yellow' align='center' valign='middle' colspan='5' rowspan='4'><font size='18px'>$isi->jenis</font></th>
                            <th colspan='2'>Saldo Awal</th>
                            <th>".mata_uang($saldo_awal[$id])."</th>
                            ";
                          }
                        }
                        ?>                        
                      </tr>
                      <tr>
                        <?php 
                        foreach ($sql->result() as $isi) {
                          $id = $isi->id_jenis;
                          $cek_tgl = date('d', strtotime($tgl)); 
                          $amb_debit = $this->db->query("SELECT SUM(debit) as jum From md_transaksi WHERE tanggal = '$tgl' AND id_jenis = '$isi->id_jenis'");
                          if($cek_tgl>1){
                            $am = $this->db->query("SELECT * FROM md_rekap WHERE tgl = '$kemarin' AND id_jenis = '$isi->id_jenis'");
                            $tunai_kemarin[$id] = ($am->num_rows()>0) ? $am->row()->tunai: 0 ;                                                                                        
                            $sum_debit = $amb_debit->row()->jum + $tunai_kemarin[$id];
                          }else{
                            $sum_debit = $amb_debit->row()->jum;
                          }
                          if($isi->jenis=="Pospay"){
                            echo "                          
                            <th>Debet</th>
                            <th>".mata_uang($sum_debit)."</th>
                            ";
                          }elseif($isi->jenis!='Dana Tunai'){                            
                            echo "                          
                            <th colspan='2'>Debet</th>
                            <th>".mata_uang($sum_debit)."</th>
                            ";                          
                          }
                        }
                        ?>                        
                      </tr>
                      <tr>
                        <?php 
                        foreach ($sql->result() as $isi) {
                          $amb_kredit = $this->db->query("SELECT SUM(kredit) as jum From md_transaksi WHERE tanggal = '$tgl' AND id_jenis = '$isi->id_jenis'");                          
                          if($isi->jenis=="Pospay"){
                            echo "                          
                            <th>Kredit</th>
                            <th>".mata_uang($sum_kredit = $amb_kredit->row()->jum)."</th>
                            ";
                          }elseif($isi->jenis!='Dana Tunai'){                            
                            echo "                          
                            <th colspan='2'>Kredit</th>
                            <th>".mata_uang($sum_kredit = $amb_kredit->row()->jum)."</th>
                            ";                          
                          }
                        }
                        ?>                        
                      </tr>
                      <tr>
                        <?php 
                        $dana_tunai = 0;
                        foreach ($sql->result() as $isi) {
                          $cek_tgl = date('d', strtotime($tgl)); 

                          $id = $isi->id_jenis;
                          $amb_debit = $this->db->query("SELECT SUM(debit) as jum From md_transaksi WHERE tanggal = '$tgl' AND id_jenis = '$isi->id_jenis'");                          
                          if($cek_tgl>1){
                            $am = $this->db->query("SELECT * FROM md_rekap WHERE tgl = '$kemarin' AND id_jenis = '$isi->id_jenis'");
                            $tunai_kemarin[$id] = ($am->num_rows()>0) ? $am->row()->tunai: 0 ;                                                                                        
                            $sum_debit = $amb_debit->row()->jum + $tunai_kemarin[$id];
                          }else{
                            $sum_debit = $amb_debit->row()->jum;
                          }
                          $sum_admin = $this->db->query("SELECT SUM(admin1) as jum From md_transaksi WHERE tanggal = '$tgl' AND id_jenis = '$isi->id_jenis'")->row()->jum;                                                  
                          $sum_piutang = $this->db->query("SELECT SUM(piutang) as jum From md_transaksi WHERE tanggal = '$tgl' AND id_jenis = '$isi->id_jenis'")->row()->jum;                          
                          if($isi->jenis=="Pospay"){
                            $tunai[$id] = $sum_admin + $sum_debit;
                            $dana_tunai+=$tunai[$id];
                            echo "                          
                            <th>Tunai</th>
                            <th>".mata_uang($tunai[$id])."</th>
                            ";
                          }elseif($isi->jenis!='Dana Tunai'){                            
                            $tunai[$id] = $sum_admin + $sum_debit - $sum_piutang;                          
                            $dana_tunai+=$tunai[$id];
                            echo "                          
                            <th colspan='2'>Tunai</th>
                            <th>".mata_uang($tunai[$id])."</th>
                            ";                          
                          }else{
                            $tunai[$id] = 0;
                          }
                        }
                        ?>                        
                      </tr>                     
                    </thead>
                    <tbody>                      
                      <tr>
                        <?php 
                        foreach ($sql->result() as $isi) {
                          if($isi->jenis!="Pospay" AND $isi->jenis!="Dana Tunai"){
                            echo "
                            <th width='3%'>No</th>
                            <td>Debet</td>
                            <td></td>
                            <td>Kredit</td>
                            <td>Admin</td>
                            <td>Piutang</td>
                            <td>Admin</td>
                            <td>Saldo</td>
                            ";
                          }elseif($isi->jenis=="Pospay"){
                            echo "
                            <td width='3%'>No</td>
                            <td>Debet</td>
                            <td>Kredit</td>
                            <td>Admin</td>
                            <td>Saldo</td>
                            ";
                          }elseif($isi->jenis=="Dana Tunai"){
                            echo "
                            <td>Lain-lain</td>
                            <td>Tujuan</td>                            
                            <td align='right'><b>".mata_uang($dana_tunai)."</b></td>                            
                            ";
                          }
                        }
                        ?>
                      </tr>
                      <?php      
                      $no=1;                                                 
                      foreach ($sql->result() as $key) {                        
                        $id = $key->id_jenis;
                        $t_debit[$id]=0;                        
                        $t_kredit[$id]=0;                        
                        $t_admin1[$id]=0;                        
                        $t_admin2[$id]=0;                        
                        $t_piutang[$id]=0;                        
                        $t_saldo[$id]=0;                        
                      }
                      foreach ($sql->result() as $isi) {
                        $cek_tgl = date('d', strtotime($tgl)); 
                        if($cek_tgl>1){
                          $id = $isi->id_jenis;
                          $am = $this->db->query("SELECT * FROM md_rekap WHERE tgl = '$kemarin' AND id_jenis = '$isi->id_jenis'");
                          $tunai_kemarin[$id] = ($am->num_rows()>0) ? $am->row()->tunai: 0 ;
                          $saldo[$id] = $saldo_awal[$id] - $tunai_kemarin[$id];
                          if($isi->jenis!="Pospay" AND $isi->jenis!="Dana Tunai"){
                            echo "                          
                              <td></td>
                              <td align='right'>".mata_uang($tunai_kemarin[$id])."</td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td align='right'>".mata_uang($saldo[$id])."</td>
                            ";
                          }elseif($isi->jenis=="Pospay"){
                            echo "                          
                              <td></td>
                              <td align='right'>".mata_uang($tunai_kemarin[$id])."</td>                                                            
                              <td></td>
                              <td></td>
                              <td align='right'>".mata_uang($saldo[$id])."</td>
                            ";
                          }else{
                            echo "                                                        
                              <td align='right'></td>                                                                                          
                              <td></td>
                              <td align='right'>".mata_uang($dana_tunai)."</td>
                            ";
                          }
                        }
                      }                 
                                            
                      $cek_maks = $this->db->query("SELECT COUNT(kode) AS jum FROM md_transaksi WHERE tanggal = '$tgl' GROUP BY id_jenis ORDER BY jum DESC LIMIT 0,1");
                      $maks = ($cek_maks->num_rows() > 0) ? $cek_maks->row()->jum : 0 ;
                      for ($i=0; $i <= $maks; $i++) {                      
                        echo "
                        <tr>";   
                          $kredit_dana_t=0;                                              
                          foreach ($sql->result() as $isi) {
                            $id = $isi->id_jenis;        
                            $cek_tgl = date('d', strtotime($tgl)); 


                            $cek_debet = $this->db->query("SELECT * FROM md_transaksi WHERE id_jenis = '$isi->id_jenis' AND tanggal = '$tgl' ORDER BY id_transaksi ASC LIMIT $i,1");
                            $debit[$id] = ($cek_debet->num_rows() > 0) ? $cek_debet->row()->debit : 0 ;                            
                            $kredit[$id] = ($cek_debet->num_rows() > 0) ? $cek_debet->row()->kredit : 0 ;                            
                            $piutang[$id] = ($cek_debet->num_rows() > 0) ? $cek_debet->row()->piutang : 0 ;                            
                            $admin1[$id] = ($cek_debet->num_rows() > 0) ? $cek_debet->row()->admin1 : 0 ;                            
                            $admin2[$id] = ($cek_debet->num_rows() > 0) ? $cek_debet->row()->admin2 : 0 ;  
                            $ket = ($cek_debet->num_rows() > 0) ? $cek_debet->row()->keterangan : "" ;                          

                            $cek_dana = $this->db->query("SELECT * FROM md_transaksi INNER JOIN md_jenis ON md_transaksi.id_jenis = md_jenis.id_jenis 
                                WHERE jenis = 'Dana Tunai' AND tanggal = '$tgl' ORDER BY id_transaksi ASC LIMIT $i,1");
                            $kredit_dana = ($cek_dana->num_rows() > 0) ? $cek_dana->row()->kredit : 0 ;                            

                            $cek_kemarin = $this->db->get_where("md_transaksi",array("id_jenis"=>$isi->id_jenis,"tanggal"=>$kemarin));
                            if($cek_kemarin->num_rows() > 0){
                              $am = $this->db->query("SELECT * FROM md_rekap WHERE tgl = '$kemarin' AND id_jenis = '$isi->id_jenis'");
                              $saldo_awal[$id] = $am->row()->tunai + $am->row()->saldo;
                              $saldo_1[$id] = $saldo_awal[$id];
                            }else{
                              $saldo_awal[$id] = $this->db->get_where("md_jenis",array("id_jenis"=>$isi->id_jenis))->row()->saldo_awal;                            
                              $saldo_1[$id] = 0;
                            }                         
                                                                                
                            

                            if($cek_tgl>1){
                              $am = $this->db->query("SELECT * FROM md_rekap WHERE tgl = '$kemarin' AND id_jenis = '$isi->id_jenis'");
                              $tunai_kemarin[$id] = ($am->num_rows()>0) ? $am->row()->tunai: 0 ;
                              $saldo[$id] = $saldo_awal[$id] - $tunai_kemarin[$id];
                              if($no==1) $saldo[$id] = ($saldo[$id] - $debit[$id]) + $kredit[$id];                              
                                else $saldo[$id] = ($t_saldo[$id] - $debit[$id]) + $kredit[$id];                              
                              $dana_tunai += $saldo[$id];
                            }else{
                              if($no==1) $saldo[$id] = ($saldo_awal[$id] - $debit[$id]) + $kredit[$id];
                                else $saldo[$id] = ($t_saldo[$id] - $debit[$id]) + $kredit[$id];                              
                              $dana_tunai += $saldo[$id];
                            }

                            if($no==1) $t_saldo[$id] += $saldo[$id];
                              else $t_saldo[$id] = $saldo[$id];   

                            if($no==1) $saldo_dana = $dana_tunai;
                              else $saldo_dana += $kredit_dana;   
                                       
                            //$kredit_dana_t += $kredit_dana;                  
                          
                            if($isi->jenis!="Pospay" AND $isi->jenis!="Dana Tunai"){
                              echo "                              
                              <th>$no</th>
                              <td align='right'>".mata_uang($debit[$id])."</td>
                              <td></td>
                              <td align='right'>".mata_uang($kredit[$id])."</td>
                              <td align='right'>".mata_uang($admin1[$id])."</td>
                              <td align='right'>".mata_uang($piutang[$id])."</td>
                              <td align='right'>".mata_uang($admin2[$id])."</td>
                              <td align='right'>".mata_uang($saldo[$id])."</td>
                              ";
                            }elseif($isi->jenis=="Pospay"){
                              echo "                              
                              <td>$no</td>
                              <td align='right'>".mata_uang($debit[$id])."</td>
                              <td align='right'>".mata_uang($kredit[$id])."</td>
                              <td align='right'>".mata_uang($admin1[$id])."</td>
                              <td align='right'>".mata_uang($saldo[$id])."</td>
                              ";
                            }elseif($isi->jenis=="Dana Tunai"){
                              echo "                              
                              <td align='right'>".mata_uang($kredit[$id])."</td>
                              <td align='right'></td>
                              <td align='right'>".mata_uang($saldo_dana)."</td>                                                                                      
                              ";
                            }
                            

                            $t_debit[$id] += $debit[$id];
                            $t_kredit[$id] += $kredit[$id];
                            $t_admin1[$id] += $admin1[$id];
                            $t_admin2[$id] += $admin2[$id];
                            $t_piutang[$id] += $piutang[$id];
                            
                            $data['id_jenis'] = $isi->id_jenis; 
                            $data['tgl'] = $tgl;        
                            if($cek_tgl>1){
                              $am = $this->db->query("SELECT * FROM md_rekap WHERE tgl = '$kemarin' AND id_jenis = '$isi->id_jenis'");
                              $tunai_kemarin[$id] = ($am->num_rows()>0) ? $am->row()->tunai: 0 ;                                                                                        
                              $data['debit'] = $t_debit[$id] + $tunai_kemarin[$id];                            
                            }else{                               
                              $data['debit'] = $t_debit[$id];                            
                            }
                            if($isi->jenis=="Dana Tunai"){
                              $data['saldo'] = $saldo_dana;                            
                            }else{                                               
                              $data['saldo'] = $t_saldo[$id];                            
                            }
                            $data['kredit'] = $t_kredit[$id]; 
                            $data['admin1'] = $t_admin1[$id]; 
                            $data['admin2'] = $t_admin2[$id]; 
                            $data['tunai'] = $tunai[$id]; 
                            $cek = $this->db->query("SELECT * FROM md_rekap WHERE id_jenis = '$isi->id_jenis' AND tgl = '$tgl'");
                            if($cek->num_rows() > 0){
                              $this->m_admin->update("md_rekap",$data,"id_rekap",$cek->row()->id_rekap);
                            }else{
                              $this->m_admin->insert("md_rekap",$data);
                            }                            
                          
                          }
                            $no++;

                          echo "
                        </tr>
                        ";

                      }
                      ?>   
                    </tbody>
                    <tfoot>                      
                        <?php 
                        echo "
                        <tr>"; 
                          foreach ($sql->result() as $isi) {  
                            $id = $isi->id_jenis;            
                            if($cek_tgl>1){
                              $am = $this->db->query("SELECT * FROM md_rekap WHERE tgl = '$kemarin' AND id_jenis = '$isi->id_jenis'");
                              $tunai_kemarin[$id] = ($am->num_rows()>0) ? $am->row()->tunai: 0 ;                                                                                        
                              $t_debit[$id] = $t_debit[$id] + $tunai_kemarin[$id];
                            }else{
                              $t_debit[$id] = $t_debit[$id];
                            }              
                            if($isi->jenis!="Pospay" AND $isi->jenis!="Dana Tunai"){
                              echo "                              
                              <th>Total</th>
                              <td align='right'>".mata_uang($t_debit[$id])."</td>
                              <td></td>
                              <td align='right'>".mata_uang($t_kredit[$id])."</td>
                              <td align='right'>".mata_uang($t_admin1[$id])."</td>
                              <td align='right'>".mata_uang($t_piutang[$id])."</td>
                              <td align='right'>".mata_uang($t_admin2[$id])."</td>
                              <td align='right'>".mata_uang($t_saldo[$id])."</td>
                              ";
                            }elseif($isi->jenis=="Pospay"){
                              echo "                              
                              <th>Total</th>
                              <td align='right'>".mata_uang($t_debit[$id])."</td>
                              <td align='right'>".mata_uang($t_kredit[$id])."</td>
                              <td align='right'>".mata_uang($t_admin1[$id])."</td>
                              <td align='right'>".mata_uang($t_saldo[$id])."</td>
                              ";
                            }elseif($isi->jenis=="Dana Tunai"){
                              echo "                                                            
                              <td align='right'></td>
                              <td align='right'></td>                                                      
                              <td align='right'></td>
                              ";
                            }
                        

                          }
                          echo "
                        </tr>
                        ";
                        ?>
                      
                    </tfoot>                    
                  </table>                     

                </div>
              </div>                                            
              <div class="col-12">                                                      
              
                <?php 
                $trans = $this->db->query("SELECT sum(saldo) as jum FROM md_rekap WHERE tgl = '$tgl'")->row()->jum;
                $laba = $this->db->query("SELECT sum(admin1+admin2) as jum FROM md_rekap WHERE tgl = '$tgl'")->row()->jum;
                ?>
                <p>
                  <h3>Tunai: <?php echo mata_uang($trans) ?></h3>
                  <h3>Laba Hari Ini: <?php echo mata_uang($laba) ?></h3>
                </p>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <?php }else{ ?>

<body onload="<?php echo $ec = (isset($_GET['id'])) ? "cek_jenis()" : "" ; ?>">
<div class="main-panel" style="margin-top:-30px;">
  <div class="content-wrapper">    
    <div class="page-header">
      <h3 class="page-title">
        </span> <?php echo $title ?> </h3>
        <nav aria-label="breadcrumb">
            <?php echo $bread ?>
        </nav>
      </div> 
    <div class="row">
      <div class="col-12 grid-margin">
        <form action="laporan/filter" method="POST" enctype="multipart/form-data" class="form-sample">                              
          <div class="card">
            <div class="card-header">
              <h4 class="card-title"><button type="submit" name="filter" class="btn btn-primary btn-sm"><i class="mdi mdi-filter"></i> Filter</button></h4>
            </div>
            <div class="card-body">            
              <div class="box">                            
                <div class="row">
                  <div class="col-12">                                                      
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label">Tanggal</label>
                      <div class="col-sm-4">
                        <input type="date" name="tanggal" value="<?php echo $tgl = ($tgl!="") ? $tgl : date("Y-m-d") ; ?>" class="form-control">
                      </div>                                                          
                    </div>
                  </div>
                </div>              
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <?php } ?>

