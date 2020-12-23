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
      
                  
      <table id="example" border="1" class="table table-bordered" style="width:100%">
        <thead>
          <tr>
            <?php 
            $tanggal = date("Y-m-d");
            $kemarin = manipulasiTanggal($tgl,-1);                        
            $sql = $this->m_admin->getByID("md_jenis","status",1);
            foreach ($sql->result() as $isi) {
              $cek_kemarin = $this->db->get_where("md_transaksi",array("id_jenis"=>$isi->id_jenis,"tanggal"=>$kemarin));
              if($cek_kemarin->num_rows() > 0){
                $saldo_awal = $cek_kemarin->row()->saldo_awal;
              }else{
                $saldo_awal = $this->db->get_where("md_jenis",array("id_jenis"=>$isi->id_jenis))->row()->saldo_awal;                            
              }

              if($isi->jenis=="Pospay"){
                echo "
                <td bgcolor='yellow' align='center' valign='middle' colspan='3' rowspan='4'>$isi->jenis</th>
                <th>Saldo Awal</th>
                <th>000</th>
                ";
              }elseif($isi->jenis=="Dana Tunai"){
                echo "
                <td bgcolor='yellow' align='center' valign='middle' colspan='3' rowspan='4'>$isi->jenis</th>                            
                <th>000</th>
                ";
              }else{
                echo "
                <td bgcolor='yellow' align='center' valign='middle' colspan='5' rowspan='4'>$isi->jenis</th>
                <th colspan='2'>Saldo Awal</th>
                <th>".mata_uang($saldo_awal)."</th>
                ";
              }
            }
            ?>                        
          </tr>
          <tr>
            <?php 
            foreach ($sql->result() as $isi) {
              $amb_debet = $this->db->query("SELECT SUM(nominal) as jum From md_transaksi WHERE id_jenis = '$isi->id_jenis' AND bayar = 'debit'");
              if($isi->jenis=="Pospay"){
                echo "                          
                <th>Debet</th>
                <th>000</th>
                ";
              }elseif($isi->jenis!='Dana Tunai'){                            
                echo "                          
                <th colspan='2'>Debet</th>
                <th>".$amb_debet->row()->jum."</th>
                ";                          
              }else{
                echo "<th>000</th>";
              }
            }
            ?>                        
          </tr>
          <tr>
            <?php 
            foreach ($sql->result() as $isi) {
              if($isi->jenis=="Pospay"){
                echo "                          
                <th>Kredit</th>
                <th>000</th>
                ";
              }elseif($isi->jenis!='Dana Tunai'){                            
                echo "                          
                <th colspan='2'>Kredit</th>
                <th>000</th>
                ";                          
              }else{
                echo "<th>000</th>";
              }
            }
            ?>                        
          </tr>
          <tr>
            <?php 
            foreach ($sql->result() as $isi) {
              if($isi->jenis=="Pospay"){
                echo "                          
                <th>Tunai</th>
                <th>000</th>
                ";
              }elseif($isi->jenis!='Dana Tunai'){                            
                echo "                          
                <th colspan='2'>Tunai</th>
                <th>000</th>
                ";                          
              }else{
                echo "<th>000</th>";
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
                <td>No</td>
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
                <td>No</td>
                <td>Debet</td>
                <td>Kredit</td>
                <td>Admin</td>
                <td>Saldo</td>
                ";
              }elseif($isi->jenis=="Dana Tunai"){
                echo "
                <td>No</td>
                <td>Lain-lain</td>
                <td>Tujuan</td>                            
                ";
              }
            }
            ?>
          </tr>
          <?php 
          $no=1;
          $cek_maks = $this->db->query("SELECT COUNT(kode) AS jum FROM md_transaksi WHERE tanggal = '$tgl' GROUP BY id_jenis ORDER BY jum DESC LIMIT 0,1");
          $maks = ($cek_maks->num_rows() > 0) ? $cek_maks->row()->jum : 0 ;
          for ($i=0; $i <= $maks; $i++) {                      
            echo "
            <tr>";                          
              foreach ($sql->result() as $isi) {
                $cek_ket = $this->db->query("SELECT * FROM md_transaksi WHERE id_jenis = '$isi->id_jenis' ORDER BY id_transaksi ASC LIMIT $i,1");
                $ket = ($cek_ket->num_rows() > 0) ? $cek_ket->row()->keterangan : "" ;
                

                $cek_debet = $this->db->query("SELECT * FROM md_transaksi WHERE bayar='debit' AND id_jenis = '$isi->id_jenis' ORDER BY id_transaksi ASC LIMIT $i,1");
                $debet = ($cek_debet->num_rows() > 0) ? $cek_debet->row()->nominal : 0 ;
                $admin = ($cek_debet->num_rows() > 0) ? $cek_debet->row()->admin : 0 ;
                $piutang = ($cek_debet->num_rows() > 0) ? $cek_debet->row()->piutang : 0 ;

                $cek_kredit = $this->db->query("SELECT * FROM md_transaksi WHERE bayar='kredit' AND id_jenis = '$isi->id_jenis' ORDER BY id_transaksi ASC LIMIT $i,1");
                $kredit = ($cek_kredit->num_rows() > 0) ? $cek_kredit->row()->nominal : 0 ;
                if($isi->jenis!="Pospay" AND $isi->jenis!="Dana Tunai"){
                  echo "                              
                  <td>$no</td>
                  <td align='right'>".mata_uang($debet)."</td>
                  <td></td>
                  <td align='right'>".mata_uang($kredit)."</td>
                  <td></td>
                  <td align='right'>".mata_uang($piutang)."</td>
                  <td align='right'>".mata_uang($admin)."</td>
                  <td align='right'>".mata_uang($saldo = $debet + $kredit)."</td>
                  ";
                }elseif($isi->jenis=="Pospay"){
                  echo "                              
                  <td>$no</td>
                  <td>$debet</td>
                  <td>$kredit</td>
                  <td>Admin</td>                              
                  <td>Saldo</td>
                  ";
                }elseif($isi->jenis=="Dana Tunai"){
                  echo "                              
                  <td>$no</td>
                  <td>Debet</td>
                  <td>Keterangan</td>                              
                  <td>Saldo</td>                              
                  ";
                }
              }
              echo "
            </tr>
            ";
            $no++;
          }
          ?>   
        </tbody>
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
                        $tanggal = date("Y-m-d");
                        $kemarin = manipulasiTanggal($tgl,-1);                        
                        $sql = $this->m_admin->getByID("md_jenis","status",1);
                        foreach ($sql->result() as $isi) {
                          $cek_kemarin = $this->db->get_where("md_transaksi",array("id_jenis"=>$isi->id_jenis,"tanggal"=>$kemarin));
                          if($cek_kemarin->num_rows() > 0){
                            $saldo_awal = 0;
                          }else{
                            $saldo_awal = $this->db->get_where("md_jenis",array("id_jenis"=>$isi->id_jenis))->row()->saldo_awal;                            
                          }

                          if($isi->jenis=="Pospay"){
                            echo "
                            <td bgcolor='yellow' align='center' valign='middle' colspan='3' rowspan='4'><font size='18px'>$isi->jenis</font></th>
                            <th>Saldo Awal</th>
                            <th>".mata_uang($saldo_awal)."</th>                            
                            ";
                          }elseif($isi->jenis=="Dana Tunai"){
                            echo "
                            <td bgcolor='yellow' align='center' valign='middle' colspan='4' rowspan='4'><font size='18px'>$isi->jenis</font></th>                            
                            ";
                          }else{
                            echo "
                            <td bgcolor='yellow' align='center' valign='middle' colspan='5' rowspan='4'><font size='18px'>$isi->jenis</font></th>
                            <th colspan='2'>Saldo Awal</th>
                            <th>".mata_uang($saldo_awal)."</th>
                            ";
                          }
                        }
                        ?>                        
                      </tr>
                      <tr>
                        <?php 
                        foreach ($sql->result() as $isi) {
                          $amb_debit = $this->db->query("SELECT SUM(debit) as jum From md_transaksi WHERE id_jenis = '$isi->id_jenis'");
                          if($isi->jenis=="Pospay"){
                            echo "                          
                            <th>Debet</th>
                            <th>".mata_uang($sum_debit = $amb_debit->row()->jum)."</th>
                            ";
                          }elseif($isi->jenis!='Dana Tunai'){                            
                            echo "                          
                            <th colspan='2'>Debet</th>
                            <th>".mata_uang($sum_debit = $amb_debit->row()->jum)."</th>
                            ";                          
                          }
                        }
                        ?>                        
                      </tr>
                      <tr>
                        <?php 
                        foreach ($sql->result() as $isi) {
                          $amb_kredit = $this->db->query("SELECT SUM(kredit) as jum From md_transaksi WHERE id_jenis = '$isi->id_jenis'");                          
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
                        foreach ($sql->result() as $isi) {
                          $sum_admin = $this->db->query("SELECT SUM(admin1) as jum From md_transaksi WHERE id_jenis = '$isi->id_jenis'")->row()->jum;                          
                          $sum_debit = $this->db->query("SELECT SUM(debit) as jum From md_transaksi WHERE id_jenis = '$isi->id_jenis'")->row()->jum;                          
                          $sum_piutang = $this->db->query("SELECT SUM(piutang) as jum From md_transaksi WHERE id_jenis = '$isi->id_jenis'")->row()->jum;                          
                          $tunai = $sum_admin + $sum_debit - $sum_piutang;
                          $tunai_2 = $sum_admin + $sum_debit;
                          if($isi->jenis=="Pospay"){
                            echo "                          
                            <th>Tunai</th>
                            <th>".mata_uang($tunai_2)."</th>
                            ";
                          }elseif($isi->jenis!='Dana Tunai'){                            
                            echo "                          
                            <th colspan='2'>Tunai</th>
                            <th>".mata_uang($tunai)."</th>
                            ";                          
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
                            <td width='3%'>No</td>
                            <td>Lain-lain</td>
                            <td>Tujuan</td>                            
                            ";
                          }
                        }
                        ?>
                      </tr>
                      <?php 
                      $no=1;$t_debit=0;$t_kredit=0;$t_admin1=0;$t_admin2=0;$t_piutang=0;$t_saldo=0;
                      $cek_maks = $this->db->query("SELECT COUNT(kode) AS jum FROM md_transaksi WHERE tanggal = '$tgl' GROUP BY id_jenis ORDER BY jum DESC LIMIT 0,1");
                      $maks = ($cek_maks->num_rows() > 0) ? $cek_maks->row()->jum : 0 ;
                      for ($i=0; $i <= $maks; $i++) {                      
                        echo "
                        <tr>";                                                   
                          foreach ($sql->result() as $isi) {
                            $cek_debet = $this->db->query("SELECT * FROM md_transaksi WHERE id_jenis = '$isi->id_jenis' ORDER BY id_transaksi ASC LIMIT $i,1");
                            $debit = ($cek_debet->num_rows() > 0) ? $cek_debet->row()->debit : 0 ;                            
                            $kredit = ($cek_debet->num_rows() > 0) ? $cek_debet->row()->kredit : 0 ;                            
                            $piutang = ($cek_debet->num_rows() > 0) ? $cek_debet->row()->piutang : 0 ;                            
                            $admin1 = ($cek_debet->num_rows() > 0) ? $cek_debet->row()->admin1 : 0 ;                            
                            $admin2 = ($cek_debet->num_rows() > 0) ? $cek_debet->row()->admin2 : 0 ;  
                            $ket = ($cek_debet->num_rows() > 0) ? $cek_debet->row()->keterangan : "" ;                          


                            $cek_kemarin = $this->db->get_where("md_transaksi",array("id_jenis"=>$isi->id_jenis,"tanggal"=>$kemarin));
                            if($cek_kemarin->num_rows() > 0){
                              $saldo_awal = 0;
                            }else{
                              $saldo_awal = $this->db->get_where("md_jenis",array("id_jenis"=>$isi->id_jenis))->row()->saldo_awal;                            
                            }                         
                            
                            if($no==1){
                              $saldo = ($saldo_awal - $debit) + $kredit;
                            }else{
                              $saldo = ($t_saldo - $debit) + $kredit;
                            }
                          
                            if($isi->jenis!="Pospay" AND $isi->jenis!="Dana Tunai"){
                              echo "                              
                              <th>$no</th>
                              <td align='right'>".mata_uang($debit)."</td>
                              <td></td>
                              <td align='right'>".mata_uang($kredit)."</td>
                              <td align='right'>".mata_uang($admin1)."</td>
                              <td align='right'>".mata_uang($piutang)."</td>
                              <td align='right'>".mata_uang($admin2)."</td>
                              <td align='right'>".mata_uang($saldo)."</td>
                              ";
                            }elseif($isi->jenis=="Pospay"){
                              echo "                              
                              <td>$no</td>
                              <td align='right'>".mata_uang($debit)."</td>
                              <td align='right'>".mata_uang($kredit)."</td>
                              <td align='right'>".mata_uang($admin1)."</td>
                              <td align='right'>".mata_uang($saldo)."</td>
                              ";
                            }elseif($isi->jenis=="Dana Tunai"){
                              echo "                              
                              <td>$no</td>
                              <td></td>
                              <td></td>                              
                              <td></td>                              
                              ";
                            }
                            $t_debit += $debit;
                            $t_kredit += $kredit;
                            $t_admin1 += $admin1;
                            $t_admin2 += $admin2;
                            $t_piutang += $piutang;
                            if($no==1){
                              $t_saldo += $saldo;
                            }else{
                              $t_saldo = $saldo;
                            }
                          }
                          echo "
                        </tr>
                        ";
                        $no++;
                      }
                      ?>   
                    </tbody>
                    <tfoot>                      
                        <?php 
                        echo "
                        <tr>"; 
                          foreach ($sql->result() as $isi) {                            
                            if($isi->jenis!="Pospay" AND $isi->jenis!="Dana Tunai"){
                              echo "                              
                              <th>Total</th>
                              <td align='right'>".mata_uang($t_debit)."</td>
                              <td></td>
                              <td align='right'>".mata_uang($t_kredit)."</td>
                              <td align='right'>".mata_uang($t_admin1)."</td>
                              <td align='right'>".mata_uang($t_piutang)."</td>
                              <td align='right'>".mata_uang($t_admin2)."</td>
                              <td align='right'>".mata_uang($t_saldo)."</td>
                              ";
                            }elseif($isi->jenis=="Pospay"){
                              echo "                              
                              <td>$no</td>
                              <td>$debit</td>
                              <td>$kredit</td>
                              <td>Admin</td>                              
                              <td>Saldo</td>
                              ";
                            }elseif($isi->jenis=="Dana Tunai"){
                              echo "                              
                              <td>$no</td>
                              <td>Debet</td>
                              <td>Keterangan</td>                              
                              <td>Saldo</td>                              
                              ";
                            }
                          }
                          echo "
                        </tr>
                        ";
                        $t_debit=0;$t_kredit=0;$t_admin1=0;$t_admin2=0;$t_piutang=0;$t_saldo=0;                                                 
                        ?>
                      
                    </tfoot>
                  </table>                     

                </div>
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

