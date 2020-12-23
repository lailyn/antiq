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
		if($set=="insert"){
			if($mode == 'insert'){
				$read = "";
				$read2 = "";
				$form = "save";
				$vis  = "";
				$form_id = "";
				$row = "";
			}elseif($mode == 'detail'){
				$row  = $dt_transaksi->row();              
				$read = "readonly";
				$read2 = "disabled";
				$vis  = "style='display:none;'";
				$form = "save";              
				$form_id = "";
			}elseif($mode == 'edit'){
				$row  = $dt_transaksi->row();
				$read = "";
				$read2 = "";
				$form = "update";              
				$vis  = "";
				$form_id = "<input type='hidden' id='id_transaksi' name='id' value='$row->id_transaksi'>";              
			}

      if($mode!="insert"){
        if($row->kredit==0){
          $bayar = "debit";
          $nominal = $row->debit;
          $admin = $row->admin1;
        }else{
          $bayar = "kredit";
          $nominal = $row->kredit;
          $admin = $row->admin2;
        }
      }
			?>

      <div class="row">
        <div class="col-12 grid-margin">
          <div class="card">
            <div class="card-header">
                <h4 class="card-title"><a href="transaksi" class="btn btn-warning btn-sm"><i class="mdi mdi-eye"></i> View</a></h4>
            </div>
            <div class="card-body">
              <form action="transaksi/<?php echo $form ?>" method="POST" enctype="multipart/form-data" class="form-sample">                  
                <div class="row">
                  <div class="col-12">                                                      
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label">Jenis Transaksi</label>
                      <div class="col-sm-2">
                        <?php echo $form_id ?>
                        <select class="form-control" <?php echo $read2 ?> onchange="cek_jenis()" name="id_jenis" id="id_jenis">
                          <?php $tampil = ($row!='') ? $row->id_jenis : "" ; ?>                          
                          <option <?php if($tampil=="") echo 'selected' ?> value="">- choose -</option>
                          <?php                           
                          foreach ($dt_jenis->result() as $isi) {
                            $id_jenis = ($row!='') ? $row->id_jenis : "";
                            if($id_jenis!='' && $id_jenis==$isi->id_jenis){
                             $se = "selected";
                            }else{
                              $se="";
                            }
                            echo "<option $se value='$isi->id_jenis'>$isi->jenis</option>";
                          }
                          ?>
                        </select>
                      </div>    
                      <label class="col-sm-1 col-form-label">Tanggal</label>
                      <div class="col-sm-3">                        
                        <input type="date" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $row->tanggal : date("Y-m-d") ; ?>" name="tanggal" placeholder="Tanggal" class="form-control" />
                      </div>                
                      <div class="col-sm-2">
                        <div class="form-check">
                          <label class="form-check-label">
                            <input type="radio" <?php echo $read2 ?> class="form-check-input" name="bayar" id="membershipRadios1" value="kredit" <?php echo $tampil = ($row!='' AND $bayar=='kredit') ? "checked" : "" ; ?>> Kredit </label>
                        </div>
                      </div>
                      <div class="col-sm-2">
                        <div class="form-check">
                          <label class="form-check-label">
                            <input type="radio" <?php echo $read2 ?> class="form-check-input" name="bayar" <?php echo $tampil = ($row!='' AND $bayar=='debit') ? "checked" : "" ; ?> id="membershipRadios2" value="debit"> Debit </label>
                        </div>
                      </div>                      
                    </div> 
                    <div class="form-group row">                    
                      <label class="col-sm-2 col-form-label">Nominal</label>
                      <div class="col-sm-2">                        
                        <input type="text" id="currency-field" data-type="currency" autocomplete="off" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $nominal : "" ; ?>" name="nominal" placeholder="Nominal" class="form-control" />
                      </div>                                          
                      <label class="col-sm-1 col-form-label">Piutang</label>
                      <div class="col-sm-2">                        
                        <input type="text" id="currency-field" data-type="currency" autocomplete="off" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $row->piutang : "" ; ?>" name="piutang" placeholder="Piutang" class="form-control" />
                      </div> 
                      <label class="col-sm-1 col-form-label">Admin</label>
                      <div class="col-sm-2">                        
                        <input type="text" id="currency-field" data-type="currency" autocomplete="off" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $admin : "" ; ?>" name="admin" placeholder="Admin" class="form-control" />
                      </div>                                          
                    </div>
                    <div class="form-group row">                      
                      <label class="col-sm-2 col-form-label">Keterangan</label>
                      <div class="col-sm-10">                        
                        <input type="text" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $row->keterangan : "" ; ?>" name="keterangan" placeholder="Keterangan" class="form-control" />
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
            <h4 class="card-title"><a href="transaksi/add" class="btn btn-primary btn-sm"><i class="mdi mdi-plus"></i> Tambah</a></h4>
          </div>
          <div class="card-body">            
            <div class="box">                            
              <div class="table-responsive">
                <table id="transaksi_dt" class="table" style="width:100%">
                  <thead>
                    <tr>
                      <th width="5%">No</th>
                      <th>ID</th>
                      <th>Tanggal</th>
                      <th>Jenis Transaksi</th>     
                      <th>Kredit</th>                                       
                      <th>Debit</th>                 
                      <th>Keterangan</th>                 
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

<script type="text/javascript">
function cek_jenis(){  
    var id_jenis  = $("#id_jenis").val();   
    var id_transaksi  = $("#id_transaksi").val();   
    $.ajax({
      url : "<?php echo site_url('transaksi/cek_jenis')?>",
      type:"POST",
      data:"id_jenis="+id_jenis,
      cache:false,   
      success:function(msg){            
        $("#id_bayar").html(msg);           
      }
    })
}
</script>