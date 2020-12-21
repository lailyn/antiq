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
		if($set=="insert"){
			if($mode == 'insert'){
				$read = "";
				$read2 = "";
				$form = "save";
				$vis  = "";
				$form_id = "";
				$row = "";
			}elseif($mode == 'detail'){
				$row  = $dt_jenis->row();              
				$read = "readonly";
				$read2 = "disabled";
				$vis  = "style='display:none;'";
				$form = "save";              
				$form_id = "";
			}elseif($mode == 'edit'){
				$row  = $dt_jenis->row();
				$read = "";
				$read2 = "";
				$form = "update";              
				$vis  = "";
				$form_id = "<input type='hidden' name='id' value='$row->id_jenis'>";              
			}
			?>

      <div class="row">
        <div class="col-12 grid-margin">
          <div class="card">
            <div class="card-header">
                <h4 class="card-title"><a href="master/jenis" class="btn btn-warning btn-sm"><i class="mdi mdi-eye"></i> View</a></h4>
            </div>
            <div class="card-body">
              <div class="col-12">                
                <form action="master/jenis/<?php echo $form ?>" method="POST" class="form-sample">                  
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Jenis Transaksi</label>
                        <div class="col-sm-4">
                          <?php echo $form_id ?>
                          <input type="text" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $row->jenis : "" ; ?>" name="jenis" placeholder="Jenis Transaksi" class="form-control" />
                        </div>
                      </div>
                      <!-- <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Operator</label>
                        <div class="col-sm-8">
                          <?php 
                          $sql = $this->m_admin->getByID("md_bayar","status",1);
                          foreach ($sql->result() as $isi) {   
                            $se="";
                            if($row!=""){
                              $dt = explode(",", $row->id_bayar);
                              foreach ($dt as $am) {
                                if($isi->id_bayar==$am) $se="checked";
                              }
                            }
                            echo "<div class='form-check form-check-flat form-check-primary'><label class='form-check-label'><input $read2 $se class='form-check-input' type='checkbox' name='id_bayar[]' value='$isi->id_bayar'> $isi->bayar </label></div>";                            
                          }
                          ?>
                        </div>
                      </div> -->
                    </div>                    
                  </div>   
                  <hr>
                  <div class="row" <?php echo $vis ?> >
                    <div class="col-md-6">                    
                      <button type="submit" class="btn btn-gradient-primary mr-2">Save</button>
                      <button type="reset" class="btn btn-light">Cancel</button>               
                    </div>
                  </div>
                </form>                  
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <?php }else{ ?>


    <div class="row">
      <div class="col-12 grid-margin">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title"><a href="master/jenis/add" class="btn btn-primary btn-sm"><i class="mdi mdi-plus"></i> Tambah</a></h4>
          </div>
          <div class="card-body">            
            <div class="box">                            
              <div class="table-responsive">
                <table id="example" class="table" style="width:100%">
                  <thead>
                    <tr>
                      <th width="5%">No</th>
                      <th>ID Jenis Transaksi</th>
                      <th>Jenis Transaksi</th>                      
                      <th width="10%"></th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php 
                  $no=1;
                  foreach ($dt_jenis->result() as $isi) {
                    echo "
                    <tr>
                      <td>$no</td>
                      <td><a href='master/jenis/detail?id=$isi->id_jenis'>$isi->id_jenis</a></td>
                      <td>$isi->jenis</td>
                      <td>";?>
                        <a href="master/jenis/delete?id=<?php echo $isi->id_jenis ?>" onclick="return confirm('Anda yakin?')" class="btn btn-danger btn-sm">hapus</a>                          
                        <a href="master/jenis/edit?id=<?php echo $isi->id_jenis ?>" class="btn btn-primary btn-sm">ubah</a>                                                      
                      <?php
                      echo "</td>
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

  <?php } ?>