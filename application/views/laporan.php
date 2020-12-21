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

    <?php                       
		if (isset($_SESSION['pesan']) && $_SESSION['pesan'] <> '') {                    
			?>                  
			<div class="alert alert-<?php echo $_SESSION['tipe'] ?> alert-dismissable">
				<strong><?php echo $_SESSION['pesan'] ?></strong>                    
			</div>
			<?php
		}
		$_SESSION['pesan'] = '';                        

		?>

		<?php 
		if($set=="filter"){			
			?>

      <div class="row">
        <div class="col-12 grid-margin">
          <div class="card">
            <div class="card-header">
              <form action="laporan/filter" method="POST" enctype="multipart/form-data" class="form-sample">                              
              <h4 class="card-title"><button type="submit" class="btn btn-primary btn-sm"><i class="mdi mdi-filter"></i> Filter</button></h4>
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
                        $sql = $this->m_admin->getByID("md_jenis","status",1);
                        foreach ($sql->result() as $isi) {
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
                            <th>000</th>
                            ";
                          }
                        }
                        ?>                        
                      </tr>
                      <tr>
                        <?php 
                        foreach ($sql->result() as $isi) {
                          if($isi->jenis=="Pospay"){
                            echo "                          
                            <th>Debet</th>
                            <th>000</th>
                            ";
                          }elseif($isi->jenis!='Dana Tunai'){                            
                            echo "                          
                            <th colspan='2'>Debet</th>
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
                            $debet = ($cek_debet->num_rows() > 0) ? $cek_debet->row()->nominal : "" ;
                            $admin = ($cek_debet->num_rows() > 0) ? $cek_debet->row()->admin : "" ;
                            $piutang = ($cek_debet->num_rows() > 0) ? $cek_debet->row()->piutang : "" ;

                            $cek_kredit = $this->db->query("SELECT * FROM md_transaksi WHERE bayar='kredit' AND id_jenis = '$isi->id_jenis' ORDER BY id_transaksi ASC LIMIT $i,1");
                            $kredit = ($cek_kredit->num_rows() > 0) ? $cek_kredit->row()->nominal : "" ;
                            if($isi->jenis!="Pospay" AND $isi->jenis!="Dana Tunai"){
                              echo "                              
                              <td>$no</td>
                              <td>$debet</td>
                              <td>$ket</td>
                              <td>$kredit</td>
                              <td></td>
                              <td>$piutang</td>
                              <td>$admin</td>
                              <td>Saldo</td>
                              ";
                            }elseif($isi->jenis=="Pospay"){
                              echo "                              
                              <td>$no</td>
                              <td>Debet</td>
                              <td>Kredit</td>
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
                </div>
              </div>                                 
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <?php }else{ ?>


    <div class="row">
      <div class="col-12 grid-margin">
        <form action="laporan/filter" method="POST" enctype="multipart/form-data" class="form-sample">                              
          <div class="card">
            <div class="card-header">
              <h4 class="card-title"><button type="submit" class="btn btn-primary btn-sm"><i class="mdi mdi-filter"></i> Filter</button></h4>
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

