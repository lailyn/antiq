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
				$row  = $dt_dokter->row();              
				$read = "readonly";
				$read2 = "disabled";
				$vis  = "style='display:none;'";
				$form = "save";              
				$form_id = "";
			}elseif($mode == 'edit'){
				$row  = $dt_dokter->row();
				$read = "";
				$read2 = "";
				$form = "update";              
				$vis  = "";
				$form_id = "<input type='hidden' name='id' value='$row->id_dokter'>";              
			}
			?>

      <div class="row">
        <div class="col-12 grid-margin">
          <div class="card">
            <div class="card-header">
                <h4 class="card-title"><a href="master/dokter" class="btn btn-warning btn-sm"><i class="mdi mdi-eye"></i> View</a></h4>
            </div>
            <div class="card-body">
              <form action="master/dokter/<?php echo $form ?>" method="POST" enctype="multipart/form-data" class="form-sample">                  
                <div class="row">
                  <div class="col-12">                

                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label">No STR</label>
                      <div class="col-sm-4">
                        <?php echo $form_id ?>
                        <input type="text" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $row->nip : "" ; ?>" name="nip" placeholder="No STR" class="form-control" />
                      </div>                    
                      <label class="col-sm-2 col-form-label">Kategori</label>
                      <div class="col-sm-4">                          
                        <select class="form-control" <?php echo $read2 ?> name="id_kategori">
                          <?php $tampil = ($row!='') ? $row->id_kategori : "" ; ?>                          
                          <option <?php if($tampil=="") echo 'selected' ?> value="">- choose -</option>
                          <?php                           
                          foreach ($dt_kategori->result() as $isi) {
                            $id_kategori = ($row!='') ? $row->id_kategori : "";
                            if($id_kategori!='' && $id_kategori==$isi->id_kategori){
                             $se = "selected";
                            }else{
                              $se="";
                            }
                            echo "<option $se value='$isi->id_kategori'>$isi->kategori</option>";
                          }
                          ?>
                        </select>
                      </div>
                    </div>                      
                  
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label">Nama Lengkap</label>
                      <div class="col-sm-10">                        
                        <input type="text" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $row->nama : "" ; ?>" name="nama" placeholder="Nama Lengkap" class="form-control" />
                      </div>                                          
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label">Biografi</label>
                      <div class="col-sm-10">                        
                        <textarea id="textarea_plus" name="biografi" class="form-control"><?php echo $tampil = ($row!='') ? $row->biografi : "<br><br>---batas---" ; ?></textarea>                        
                      </div>                                          
                    </div> 

                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label">Jenis Kelamin</label>
                      <div class="col-sm-4">                        
                        <select class="form-control" <?php echo $read2 ?> name="jk">
                          <?php echo $tampil = ($row!='') ? $row->jk : "" ; ?>                          
                          <option <?php if($tampil=="") echo 'selected' ?> value="">- choose -</option>
                          <option <?php if($tampil=="Laki-laki") echo 'selected' ?>>Laki-laki</option>
                          <option <?php if($tampil=="Perempuan") echo 'selected' ?>>Perempuan</option>
                        </select>
                      </div>                                          
                      <label class="col-sm-2 col-form-label">Agama</label>
                      <div class="col-sm-4">                        
                        <select class="form-control" <?php echo $read2 ?> name="agama">
                          <?php echo $tampil = ($row!='') ? $row->agama : "" ; ?>                          
                          <option <?php if($tampil=="") echo 'selected' ?> value="">- choose -</option>
                          <option <?php if($tampil=="Islam") echo 'selected' ?>>Islam</option>
                          <option <?php if($tampil=="Kristen") echo 'selected' ?>>Kristen</option>
                          <option <?php if($tampil=="Katolik") echo 'selected' ?>>Katolik</option>
                          <option <?php if($tampil=="Hindu") echo 'selected' ?>>Hindu</option>
                          <option <?php if($tampil=="Budha") echo 'selected' ?>>Budha</option>
                          <option <?php if($tampil=="Kong Hu Chu") echo 'selected' ?>>Kong Hu Chu</option>
                        </select>
                      </div>                                          
                    </div>

                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label">Tempat/Tgl Lahir</label>
                      <div class="col-sm-3">                        
                        <input type="text" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $row->tempat_lahir : "" ; ?>" name="tempat_lahir" placeholder="Tempat Lahir" class="form-control" />                                                
                      </div>                                                                
                      <div class="col-sm-3">                        
                        <input type="date" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $row->tgl_lahir : "" ; ?>" name="tgl_lahir" placeholder="Tanggal Lahir" class="form-control" />                        
                      </div>                      
                      <label class="col-sm-1 col-form-label">Status</label>
                      <div class="col-sm-3">                        
                        <select class="form-control" <?php echo $read2 ?> name="status">
                          <?php echo $tampil = ($row!='') ? $row->status : "" ; ?>                          
                          <option <?php if($tampil=="") echo 'selected' ?> value="">- choose -</option>
                          <option <?php if($tampil=="1") echo 'selected' ?> value="1">Aktif</option>
                          <option <?php if($tampil=="0") echo 'selected' ?> value="0">Non-Aktif</option>
                        </select>
                      </div>                  
                    </div>

                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label">Jenis ID</label>
                      <div class="col-sm-4">                        
                        <select class="form-control" <?php echo $read2 ?> name="jenis_id">
                          <?php echo $tampil = ($row!='') ? $row->jenis_id : "" ; ?>                          
                          <option <?php if($tampil=="") echo 'selected' ?> value="">- choose -</option>
                          <option <?php if($tampil=="KTP") echo 'selected' ?>>KTP</option>
                          <option <?php if($tampil=="SIM") echo 'selected' ?>>SIM</option>
                          <option <?php if($tampil=="Passport") echo 'selected' ?>>Passport</option>
                          <option <?php if($tampil=="Lainnya") echo 'selected' ?>>Lainnya</option>
                        </select>
                      </div>                                          
                      <label class="col-sm-2 col-form-label">No ID</label>
                      <div class="col-sm-4">                        
                        <input type="text" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $row->no_id : "" ; ?>" name="no_id" placeholder="No ID" class="form-control" />                        
                      </div>                                          
                    </div> 

                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label">Pendidikan Terakhir</label>
                      <div class="col-sm-4">                        
                        <input type="text" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $row->pendidikan : "" ; ?>" name="pendidikan" placeholder="Pendidikan" class="form-control" />                                                
                      </div>                                          
                      <label class="col-sm-2 col-form-label">Tahun Lulus</label>
                      <div class="col-sm-4">                        
                        <input type="number" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $row->tahun_lulus : "" ; ?>" name="tahun_lulus" placeholder="Tahun Lulus" class="form-control" />                        
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
                      <label class="col-sm-2 col-form-label">Tarif</label>
                      <div class="col-sm-4">                        
                        <input type="text" id="currency-field" data-type="currency" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $row->tarif : "" ; ?>" name="tarif" placeholder="Tarif" class="form-control" />                                                
                      </div>                                          
                      <label class="col-sm-2 col-form-label">Durasi (Menit)</label>
                      <div class="col-sm-2">                        
                        <input type="number" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $row->durasi : "" ; ?>" name="durasi" placeholder="Durasi" class="form-control" />                        
                      </div>                                    
                      <div class="form-check mx-sm-2">
                        <label class="form-check-label">
                          <?php $on = ($row!='') ? $row->online : "" ; ?>                                                    
                          <input type="checkbox" <?php if($on==1) echo 'checked' ?> name="online" class="form-check-input" value='1'> Online </label>                      
                      </div>                            
                    </div>

                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label">TMT</label>
                      <div class="col-sm-4">                        
                        <input type="date" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $row->tmt : "" ; ?>" name="tmt" placeholder="TMT" class="form-control" />                                                
                      </div>                                          
                      <label class="col-sm-2 col-form-label">Foto</label>
                      <div class="col-sm-4">                        
                        <input type="file" name="foto" class="form-control">
                      </div>                                          
                    </div>

                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label">Alamat</label>
                      <?php 
                      $rt = "style=display:none";
                      $foto="";
                      if($mode!="insert"){ 
                        $rt = "";
                        if(!isset($row->foto)){
                          $foto = "user.png";
                        }else{
                          $foto = $row->foto;
                        }
                      }
                      ?>
                        <div class='col-sm-4'>
                          <textarea class="form-control" <?php echo $read ?> name="alamat"><?php echo $tampil = ($row!='') ? $row->alamat : "" ; ?></textarea>
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
            <h4 class="card-title"><a href="master/dokter/add" class="btn btn-primary btn-sm"><i class="mdi mdi-plus"></i> Tambah</a></h4>
          </div>
          <div class="card-body">            
            <div class="box">                            
              <div class="table-responsive">
                <table id="dokter_dt" class="table" style="width:100%">
                  <thead>
                    <tr>
                      <th width="5%">No</th>
                      <th>Nama</th>     
                      <th>No STR</th>                 
                      <th>Jenis Kelamin</th>                 
                      <th>Kontak</th>                 
                      <th>TMT</th>                 
                      <th>Kategori</th>                 
                      <th>Status</th>                 
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

