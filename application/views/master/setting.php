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
				$row  = $dt_setting->row();              
				$read = "readonly";
				$read2 = "disabled";
				$vis  = "style='display:none;'";
				$form = "save";              
				$form_id = "";
			}elseif($mode == 'edit'){
				$row  = $dt_setting->row();
				$read = "";
				$read2 = "";
				$form = "update";              
				$vis  = "";
				$form_id = "<input type='hidden' name='id' value='$row->id_setting'>";              
			}
			?>

      <div class="row">
        <div class="col-12 grid-margin">
          <div class="card">
            <div class="card-header">
                <h4 class="card-title"><a href="master/setting" class="btn btn-warning btn-sm"><i class="mdi mdi-eye"></i> View</a></h4>
            </div>
            <div class="card-body">
              <form action="master/setting/<?php echo $form ?>" method="POST" enctype="multipart/form-data" class="form-sample">                  
                <div class="row">
                  <div class="col-12">                
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label">Nama Pimpinan</label>
                      <div class="col-sm-4">                        
                        <input type="text" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $row->nama_pimpinan : "" ; ?>" name="nama_pimpinan" placeholder="Nama Pimpinan" class="form-control" />
                      </div>                                          
                      <label class="col-sm-2 col-form-label">Nama Perusahaan</label>
                      <div class="col-sm-4">                        
                        <input type="text" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $row->perusahaan : "" ; ?>" name="perusahaan" placeholder="Nama Perusahaan" class="form-control" />
                      </div>                                          
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label">Email</label>
                      <div class="col-sm-4">
                        <?php echo $form_id ?>
                        <input type="email" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $row->email : "" ; ?>" name="email" placeholder="Email" class="form-control" />
                      </div>                    
                      <label class="col-sm-2 col-form-label">No Telp</label>
                      <div class="col-sm-4">                          
                        <input type="text" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $row->no_telp : "" ; ?>" name="no_telp" placeholder="No Telp" class="form-control" />                                                                        
                      </div>
                    </div>
                    <div class="form-group row">
                                        
                      <label class="col-sm-2 col-form-label">No HP</label>
                      <div class="col-sm-4">                          
                        <input type="text" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $row->no_hp : "" ; ?>" name="no_hp" placeholder="No HP" class="form-control" />                                                                        
                      </div>
                    </div>
                    
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label">Alamat Perusahaan</label>
                      <div class="col-sm-10">
                        <input type="text" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $row->alamat : "" ; ?>" name="alamat" placeholder="Alamat Perusahaan" class="form-control" />
                      </div>                                          
                    </div>
                    

                    

                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label">Logo</label>
                      <?php 
                      $rt = "style=display:none";
                      $logo="";
                      if($mode!="insert"){ 
                        $rt = "";
                        if(!isset($row->logo) OR $row->logo==""){
                          $logo = "user.png";
                        }else{
                          $logo = $row->logo;
                        }
                      }
                      ?>
                        <div class='col-sm-3'>
                        <input type="file" name="logo" class="form-control">                          
                        </div>                        
                        <div <?php echo $rt ?> class='col-sm-1'><img width="80px" src="assets/im493/<?php echo $logo ?>">                                              
                      </div>                                                                
                    
                      <label class="col-sm-2 col-form-label">Favicon</label>
                      <?php 
                      $rt = "style=display:none";
                      $fav="";
                      if($mode!="insert"){ 
                        $rt = "";
                        if(!isset($row->fav) OR $row->fav==""){
                          $fav = "user.png";
                        }else{
                          $fav = $row->fav;
                        }
                      }
                      ?>
                        <div class='col-sm-3'>
                        <input type="file" name="fav" class="form-control">                          
                        </div>
                        <div <?php echo $rt ?> class='col-sm-1'><img width="80px" src="assets/im493/<?php echo $fav ?>">                                              
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
    
    <?php } ?>



