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
				$row  = $dt_obat->row();              
				$read = "readonly";
				$read2 = "disabled";
				$vis  = "style='display:none;'";
				$form = "save";              
				$form_id = "";
			}elseif($mode == 'edit'){
				$row  = $dt_obat->row();
				$read = "";
				$read2 = "";
				$form = "update";              
				$vis  = "";
				$form_id = "<input type='hidden' name='id' value='$row->id_obat'>";              
			}
			?>

      <div class="row">
        <div class="col-12 grid-margin">
          <div class="card">
            <div class="card-header">
                <h4 class="card-title"><a href="master/obat" class="btn btn-warning btn-sm"><i class="mdi mdi-eye"></i> View</a></h4>
            </div>
            <div class="card-body">
              <form action="master/obat/<?php echo $form ?>" method="POST" enctype="multipart/form-data" class="form-sample">                  
                <div class="row">
                  <div class="col-12">                
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label">Nama Obat</label>
                      <div class="col-sm-10">                        
                        <input type="text" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $row->nama_obat : "" ; ?>" name="nama_obat" placeholder="Nama Obat" class="form-control" />
                      </div>                                          
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label">Kode Obat</label>
                      <div class="col-sm-4">
                        <?php echo $form_id ?>
                        <input type="text" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $row->kode_obat : "" ; ?>" name="kode_obat" placeholder="Kode Obat" class="form-control" />
                      </div>                    
                      <label class="col-sm-2 col-form-label">Singkatan</label>
                      <div class="col-sm-4">                          
                        <input type="text" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $row->singkatan : "" ; ?>" name="saingkatan" placeholder="Singkatan" class="form-control" />                                                                        
                      </div>
                    </div> 

                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label">Golongan</label>
                      <div class="col-sm-4">
                        <select class="form-control" <?php echo $read2 ?> name="id_obat_gol">
                          <?php $tampil = ($row!='') ? $row->id_obat_gol : "" ; ?>                          
                          <option <?php if($tampil=="") echo 'selected' ?> value="">- choose -</option>
                          <?php                           
                          foreach ($dt_obat_gol->result() as $isi) {
                            $id_obat_gol = ($row!='') ? $row->id_obat_gol : "";
                            if($id_obat_gol!='' && $id_obat_gol==$isi->id_obat_gol){
                             $se = "selected";
                            }else{
                              $se="";
                            }
                            echo "<option $se value='$isi->id_obat_gol'>$isi->golongan</option>";
                          }
                          ?>
                        </select>
                      </div>                    
                      <label class="col-sm-2 col-form-label">Generik</label>
                      <div class="col-sm-4">                          
                        <select class="form-control" <?php echo $read2 ?> name="generik">
                          <?php echo $tampil = ($row!='') ? $row->generik : "" ; ?>                          
                          <option <?php if($tampil=="") echo 'selected' ?> value="">- choose -</option>
                          <option <?php if($tampil=="Ya") echo 'selected' ?>>Ya</option>
                          <option <?php if($tampil=="Tidak") echo 'selected' ?>>Tidak</option>
                        </select>
                      </div>
                    </div>                                                            
                    

                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label">Satuan Kecil</label>
                      <div class="col-sm-4">                        
                        <select class="form-control" <?php echo $read2 ?> name="sat_kecil">
                          <?php $tampil = ($row!='') ? $row->sat_kecil : "" ; ?>                          
                          <option <?php if($tampil=="") echo 'selected' ?> value="">- choose -</option>
                          <?php                           
                          foreach ($dt_obat_satuan->result() as $isi) {
                            $sat_kecil = ($row!='') ? $row->sat_kecil : "";
                            if($sat_kecil!='' && $sat_kecil==$isi->satuan){
                             $se = "selected";
                            }else{
                              $se="";
                            }
                            echo "<option $se value='$isi->satuan'>$isi->satuan</option>";
                          }
                          ?>
                        </select>
                      </div>                                          
                      <label class="col-sm-2 col-form-label">Satuan Besar</label>
                      <div class="col-sm-4">                        
                        <select class="form-control" <?php echo $read2 ?> name="sat_besar">
                          <?php $tampil = ($row!='') ? $row->sat_kecil : "" ; ?>                          
                          <option <?php if($tampil=="") echo 'selected' ?> value="">- choose -</option>
                          <?php                           
                          foreach ($dt_obat_satuan->result() as $isi) {
                            $sat_besar = ($row!='') ? $row->sat_besar : "";
                            if($sat_besar!='' && $sat_besar==$isi->satuan){
                             $se = "selected";
                            }else{
                              $se="";
                            }
                            echo "<option $se value='$isi->satuan'>$isi->satuan</option>";
                          }
                          ?>
                        </select>
                      </div>                                          
                    </div>
                  

                    
                                       

                  </div>   
                </div>
                <div class="row">
                  <div class="col-12">                
                    <hr>
                    <div class="row" <?php echo $vis ?> >
                      <div class="col-md-6">                    
                        <button type="submit" class="btn btn-gradient-primary mr-2">Save</button>
                        <button type="reset" class="btn btn-light">Cancel</button>               
                      </div>
                    </div>
                  </div>
                </div>
              </form>                                
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
            <h4 class="card-title"><a href="master/obat/add" class="btn btn-primary btn-sm"><i class="mdi mdi-plus"></i> Tambah</a></h4>
          </div>
          <div class="card-body">            
            <div class="box">                            
              <div class="table-responsive">
                <table id="obat_dt" class="table" style="width:100%">
                  <thead>
                    <tr>
                      <th width="5%">No</th>
                      <th>ID Obat</th>
                      <th>Nama Obat</th>     
                      <th>Kode Obat</th>                                       
                      <th>Golongan</th>                 
                      <th>Satuan Kecil</th>                 
                      <th>Satuan Besar</th>                 
                      <th>Singkatan</th>                 
                      <th>Generik</th>                 
                      <th width="10%"></th>
                    </tr>
                  </thead>
                  <tbody>                  
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

