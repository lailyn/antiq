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
				$row  = $dt_layanan->row();              
				$read = "readonly";
				$read2 = "disabled";
				$vis  = "style='display:none;'";
				$form = "save";              
				$form_id = "";
			}elseif($mode == 'edit'){
				$row  = $dt_layanan->row();
				$read = "";
				$read2 = "";
				$form = "update";              
				$vis  = "";
				$form_id = "<input type='hidden' name='id' value='$row->id_layanan'>";              
			}
			?>

      <div class="row">
        <div class="col-12 grid-margin">
          <div class="card">
            <div class="card-header">
                <h4 class="card-title"><a href="trans/layanan" class="btn btn-warning btn-sm"><i class="mdi mdi-eye"></i> View</a></h4>
            </div>
            <div class="card-body">
              <form action="trans/layanan/<?php echo $form ?>" method="POST" enctype="multipart/form-data" class="form-sample">                  
                <div class="row">
                  <div class="col-12">                
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label">Layanan</label>
                      <div class="col-sm-10">  
                        <?php echo $form_id ?>
                        <input type="text" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $row->layanan : "" ; ?>" name="layanan" placeholder="Layanan" class="form-control" />
                      </div>                                          
                    </div>                                        
                    <div class="form-group row">                                        
                      <label class="col-sm-2 col-form-label">Gambar</label>
                      <div class="col-sm-3">                          
                        <input class="form-control" type="file" name="foto">
                      </div>
                      <?php 
                      $rt = "style=display:none";
                      $foto="";
                      if($mode!="insert"){ 
                        $rt = "";
                        if(!isset($row->foto) OR $row->foto==""){
                          $foto = "user.png";
                        }else{
                          $foto = $row->foto;
                        }
                      }
                      ?>
                      <div <?php echo $rt ?> class="col-sm-1">                          
                        <a href="assets/art1kel/<?php echo $foto ?>" class="btn btn-danger btn-sm"><i class="mdi mdi-eye"></i></a>                        
                      </div>

                      <label class="col-sm-2 col-form-label">Icon Menu</label>
                      <div class="col-sm-3">                          
                        <input class="form-control" type="file" name="icon">
                      </div>
                      <?php 
                      $rt = "style=display:none";
                      $icon="";
                      if($mode!="insert"){ 
                        $rt = "";
                        if(!isset($row->icon) OR $row->icon==""){
                          $icon = "user.png";
                        }else{
                          $icon = $row->icon;
                        }
                      }
                      ?>
                      <div <?php echo $rt ?> class="col-sm-1">                          
                        <a href="assets/art1kel/<?php echo $icon ?>" class="btn btn-danger btn-sm"><i class="mdi mdi-eye"></i></a>                        
                      </div>                    
                    </div> 
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label">Menu</label>
                      <div class="col-sm-2">                                              
                        <select class="form-control" <?php echo $read2 ?> name="menu">
                          <?php echo $tampil = ($row!='') ? $row->status : "" ; ?>                          
                          <option <?php if($tampil=="") echo 'selected' ?> value="">- choose -</option>
                          <option <?php if($tampil=="ya") echo 'selected' ?>>Ya</option>
                          <option <?php if($tampil=="tidak") echo 'selected' ?>>Tidak</option>
                        </select>
                      </div>
                      <label class="col-sm-1 col-form-label">Kode</label>
                      <div class="col-sm-2">                        
                        <input type="text" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $row->kode : "" ; ?>" name="kode" placeholder="Kode" class="form-control" />
                      </div>                                          
                      <label class="col-sm-1 col-form-label">Status</label>
                      <div class="col-sm-2">                                              
                        <select class="form-control" <?php echo $read2 ?> name="status">
                          <?php echo $tampil = ($row!='') ? $row->status : "" ; ?>                          
                          <option <?php if($tampil=="") echo 'selected' ?> value="">- choose -</option>
                          <option <?php if($tampil=="draft") echo 'selected' ?>>draft</option>
                          <option <?php if($tampil=="publish") echo 'selected' ?>>publish</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label">Deskripsi</label>
                      <div class="col-sm-10">                        
                        <textarea id="textarea_plus" name="deskripsi" id="exampleTextarea1" class="form-control" rows="15">
                          <?php echo $tampil = ($row!='') ? $row->deskripsi : "" ; ?>
                        </textarea>
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
            <h4 class="card-title"><a href="trans/layanan/add" class="btn btn-primary btn-sm"><i class="mdi mdi-plus"></i> Tambah</a></h4>
          </div>
          <div class="card-body">            
            <div class="box">                            
              <div class="table-responsive">
                <table id="layanan_dt" class="table" style="width:100%">
                  <thead>
                    <tr>
                      <th width="5%">No</th>
                      <th>Layanan</th>
                      <th>Menu</th>
                      <th>Kode</th>                      
                      <th>Deskripsi</th>     
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

