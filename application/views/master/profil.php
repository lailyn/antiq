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
        $row  = $dt_profil->row();              
        $read = "readonly";
        $read2 = "disabled";
        $vis  = "style='display:none;'";
        $form = "save";              
        $form_id = "";
      }elseif($mode == 'edit'){
        $row  = $dt_profil->row();
        $read = "";
        $read2 = "";
        $form = "update";              
        $vis  = "";
        $form_id = "<input type='hidden' name='id' value='$row->id_user'>";              
      }
      ?>

      <div class="row">
        <div class="col-12 grid-margin">
          <div class="card">            
            <div class="card-body">
              <form action="master/profil/<?php echo $form ?>" method="POST" enctype="multipart/form-data" class="form-sample">                  
                <div class="row">
                  <div class="col-12">                
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label">Nama Lengkap</label>
                      <div class="col-sm-4">                        
                        <input type="text" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $row->nama_lengkap : "" ; ?>" name="nama_lengkap" placeholder="Nama Lengkap" class="form-control" />
                      </div>                                          
                      <label class="col-sm-2 col-form-label">Password</label>
                      <div class="col-sm-4">                        
                        <input type="password" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? "" : "" ; ?>" name="password" placeholder="Kosongkan jika tidak diubah" class="form-control" />
                      </div>                                          
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label">Email</label>
                      <div class="col-sm-4">
                        <?php echo $form_id ?>
                        <input type="email" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $row->email : "" ; ?>" name="email" placeholder="Email" class="form-control" />
                      </div>                    
                      <label class="col-sm-2 col-form-label">No HP</label>
                      <div class="col-sm-4">                          
                        <input type="text" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $row->no_hp : "" ; ?>" name="no_hp" placeholder="No HP" class="form-control" />                                                                        
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label">Foto</label>
                      <div class="col-sm-4">                        
                        <input type="file" name="foto" class="form-control" />
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



