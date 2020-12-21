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
				$row  = $dt_layanan_sub->row();              
				$read = "readonly";
				$read2 = "disabled";
				$vis  = "style='display:none;'";
				$form = "save";              
				$form_id = "";
			}elseif($mode == 'edit'){
				$row  = $dt_layanan_sub->row();
				$read = "";
				$read2 = "";
				$form = "update";              
				$vis  = "";
				$form_id = "<input type='hidden' name='id' value='$row->id_layanan_sub'>";              
			}
			?>

      <div class="row">
        <div class="col-12 grid-margin">
          <div class="card">
            <div class="card-header">
                <h4 class="card-title"><a href="trans/layanan_sub" class="btn btn-warning btn-sm"><i class="mdi mdi-eye"></i> View</a></h4>
            </div>
            <div class="card-body">
              <form action="trans/layanan_sub/<?php echo $form ?>" method="POST" enctype="multipart/form-data" class="form-sample">                  
                <div class="row">
                  <div class="col-12">                
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label">Layanan Sub</label>
                      <div class="col-sm-10">  
                        <?php echo $form_id ?>
                        <input type="text" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $row->layanan_sub : "" ; ?>" name="layanan_sub" placeholder="Layanan Sub" class="form-control" />
                      </div>                                          
                    </div>                                        
                    <div class="form-group row">                    
                      <label class="col-sm-2 col-form-label">Layanan</label>
                      <div class="col-sm-4">                          
                        <select class="form-control" <?php echo $read2 ?> name="id_layanan">
                          <?php $tampil = ($row!='') ? $row->id_layanan : "" ; ?>                          
                          <option <?php if($tampil=="") echo 'selected' ?> value="">- choose -</option>
                          <?php                           
                          foreach ($dt_layanan->result() as $isi) {
                            $id_layanan = ($row!='') ? $row->id_layanan : "";
                            if($id_layanan!='' && $id_layanan==$isi->id_layanan){
                             $se = "selected";
                            }else{
                              $se="";
                            }
                            echo "<option $se value='$isi->id_layanan'>$isi->layanan</option>";
                          }
                          ?>
                        </select>
                      </div>
                      <label class="col-sm-2 col-form-label">Tarif</label>
                      <div class="col-sm-4">                        
                        <input type="text" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $row->tarif : "" ; ?>" name="tarif" placeholder="Tarif" class="form-control" />
                      </div>                                          
                    </div>                                          
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label">Kode</label>
                      <div class="col-sm-4">                        
                        <input type="text" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $row->kode : "" ; ?>" name="kode" placeholder="Kode" class="form-control" />
                      </div>                                          
                      <label class="col-sm-2 col-form-label">Status</label>
                      <div class="col-sm-4">                                              
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
            <h4 class="card-title"><a href="trans/layanan_sub/add" class="btn btn-primary btn-sm"><i class="mdi mdi-plus"></i> Tambah</a></h4>
          </div>
          <div class="card-body">            
            <div class="box">                            
              <div class="table-responsive">
                <table id="layanan_sub_dt" class="table" style="width:100%">
                  <thead>
                    <tr>
                      <th width="5%">No</th>
                      <th>Layanan Sub</th>
                      <th>Kode</th>                      
                      <th>Deskripsi</th>     
                      <th>Layanan</th>     
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

