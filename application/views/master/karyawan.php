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
				$row  = $dt_karyawan->row();              
				$read = "readonly";
				$read2 = "disabled";
				$vis  = "style='display:none;'";
				$form = "save";              
				$form_id = "";
			}elseif($mode == 'edit'){
				$row  = $dt_karyawan->row();
				$read = "";
				$read2 = "";
				$form = "update";              
				$vis  = "";
				$form_id = "<input type='hidden' name='id' value='$row->id_karyawan'>";              
			}
			?>

      <div class="row">
        <div class="col-12 grid-margin">
          <div class="card">
            <div class="card-header">
                <h4 class="card-title"><a href="master/karyawan" class="btn btn-warning btn-sm"><i class="mdi mdi-eye"></i> View</a></h4>
            </div>
            <div class="card-body">
              <form action="master/karyawan/<?php echo $form ?>" method="POST" enctype="multipart/form-data" class="form-sample">                  
                <div class="row">
                  <div class="col-12">                
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label">Nama Lengkap</label>
                      <div class="col-sm-10">                        
                        <input type="text" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $row->nama_lengkap : "" ; ?>" name="nama_lengkap" placeholder="Nama Lengkap" class="form-control" />
                      </div>                                          
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label">NIK</label>
                      <div class="col-sm-4">
                        <?php echo $form_id ?>
                        <input type="text" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $row->nik : "" ; ?>" name="nik" placeholder="NIK" class="form-control" />
                      </div>                    
                      <label class="col-sm-2 col-form-label">TMT</label>
                      <div class="col-sm-4">                          
                        <input type="date" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $row->tmt : "" ; ?>" name="tmt" placeholder="TMT" class="form-control" />                                                                        
                      </div>
                    </div> 

                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label">Bagian</label>
                      <div class="col-sm-4">
                        <select class="form-control" <?php echo $read2 ?> name="id_bagian">
                          <?php $tampil = ($row!='') ? $row->id_bagian : "" ; ?>                          
                          <option <?php if($tampil=="") echo 'selected' ?> value="">- choose -</option>
                          <?php                           
                          foreach ($dt_bagian->result() as $isi) {
                            $id_bagian = ($row!='') ? $row->id_bagian : "";
                            if($id_bagian!='' && $id_bagian==$isi->id_bagian){
                             $se = "selected";
                            }else{
                              $se="";
                            }
                            echo "<option $se value='$isi->id_bagian'>$isi->bagian</option>";
                          }
                          ?>
                        </select>
                      </div>                    
                      <label class="col-sm-2 col-form-label">Jabatan</label>
                      <div class="col-sm-4">                          
                        <select class="form-control" <?php echo $read2 ?> name="id_jabatan">
                          <?php $tampil = ($row!='') ? $row->id_jabatan : "" ; ?>                          
                          <option <?php if($tampil=="") echo 'selected' ?> value="">- choose -</option>
                          <?php                           
                          foreach ($dt_jabatan->result() as $isi) {
                            $id_jabatan = ($row!='') ? $row->id_jabatan : "";
                            if($id_jabatan!='' && $id_jabatan==$isi->id_jabatan){
                             $se = "selected";
                            }else{
                              $se="";
                            }
                            echo "<option $se value='$isi->id_jabatan'>$isi->jabatan</option>";
                          }
                          ?>
                        </select>
                      </div>
                    </div>                                                            
                    

                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label">No HP</label>
                      <div class="col-sm-4">                        
                        <input type="text" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $row->no_hp : "" ; ?>" name="no_hp" placeholder="No HP" class="form-control" />                                                
                      </div>                                          
                      <label class="col-sm-2 col-form-label">Email</label>
                      <div class="col-sm-4">                        
                        <input type="email" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $row->email : "" ; ?>" name="email" placeholder="Email" class="form-control" />                        
                      </div>                                          
                    </div>
                  

                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label">Foto</label>
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
                        <div class='col-sm-4'>
                        <input type="file" name="foto" class="form-control">                          
                        </div>
                        <div class='col-sm-2'></div>
                        <div <?php echo $rt ?> class='col-sm-4'><img width="300px" src="assets/im493/<?php echo $foto ?>">                                              
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
            <h4 class="card-title"><a href="master/karyawan/add" class="btn btn-primary btn-sm"><i class="mdi mdi-plus"></i> Tambah</a></h4>
          </div>
          <div class="card-body">            
            <div class="box">                            
              <div class="table-responsive">
                <table id="karyawan_dt" class="table" style="width:100%">
                  <thead>
                    <tr>
                      <th width="5%">No</th>
                      <th>ID Karyawan</th>
                      <th>Nama</th>     
                      <th>NIK</th>                                       
                      <th>Kontak</th>                 
                      <th>Bagian</th>                 
                      <th>Jabatan</th>                 
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

