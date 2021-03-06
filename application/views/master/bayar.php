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
				$row  = $dt_bayar->row();              
				$read = "readonly";
				$read2 = "disabled";
				$vis  = "style='display:none;'";
				$form = "save";              
				$form_id = "";
			}elseif($mode == 'edit'){
				$row  = $dt_bayar->row();
				$read = "";
				$read2 = "";
				$form = "update";              
				$vis  = "";
				$form_id = "<input type='hidden' name='id' value='$row->id_bayar'>";              
			}
			?>

      <div class="row">
        <div class="col-12 grid-margin">
          <div class="card">
            <div class="card-header">
                <h4 class="card-title"><a href="master/bayar" class="btn btn-warning btn-sm"><i class="mdi mdi-eye"></i> View</a></h4>
            </div>
            <div class="card-body">
              <div class="col-12">                
                <form action="master/bayar/<?php echo $form ?>" method="POST" class="form-sample">                  
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Jenis Pembayaran</label>
                        <div class="col-sm-4">
                          <?php echo $form_id ?>
                          <input type="text" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $row->bayar : "" ; ?>" name="bayar" placeholder="Jenis Pembayaran" class="form-control" />
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Operator</label>
                        <div class="col-sm-2">
                          <select class="form-control" name="operator">
                            <option <?php echo $tampil = ($row!='' AND $row->operator=="+") ? "selected" : "" ; ?> value="+">Tambah</option>
                            <option <?php echo $tampil = ($row!='' AND $row->operator=="-") ? "selected" : "" ; ?> value="-">Kurang</option>
                          </select>
                        </div>
                      </div>
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
            <h4 class="card-title"><a href="master/bayar/add" class="btn btn-primary btn-sm"><i class="mdi mdi-plus"></i> Tambah</a></h4>
          </div>
          <div class="card-body">            
            <div class="box">                            
              <div class="table-responsive">
                <table id="example" class="table" style="width:100%">
                  <thead>
                    <tr>
                      <th width="5%">No</th>
                      <th>ID Jenis Pembayaran</th>
                      <th>Jenis Pembayaran</th>                      
                      <th width="10%"></th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php 
                  $no=1;
                  foreach ($dt_bayar->result() as $isi) {
                    echo "
                    <tr>
                      <td>$no</td>
                      <td><a href='master/bayar/detail?id=$isi->id_bayar'>$isi->id_bayar</a></td>
                      <td>$isi->bayar</td>
                      <td>";?>
                        <a href="master/bayar/delete?id=<?php echo $isi->id_bayar ?>" onclick="return confirm('Anda yakin?')" class="btn btn-danger btn-sm">hapus</a>                          
                        <a href="master/bayar/edit?id=<?php echo $isi->id_bayar ?>" class="btn btn-primary btn-sm">ubah</a>                                                      
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