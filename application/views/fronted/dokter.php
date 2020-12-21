<main id="main">

  <!-- ======= Breadcrumbs Section ======= -->
  <section class="breadcrumbs">
    <div class="container">

      <div class="d-flex justify-content-between align-items-center">
        <h2><?php echo $title ?></h2>
        <ol>
          <li><a href="w3b">Home</a></li>
          <li><?php echo $title ?></li>
        </ol>
      </div>

    </div>
  </section><!-- End Breadcrumbs Section -->
  <?php 
  $row = $dt_artikel->row();     
  if(!isset($row->foto) AND $row->foto==""){
    $foto = "alt-tag.png";
  }else{
    $foto = $row->foto;
  }
  ?>
  <section class="inner-page">
    <div class="container">
      <div class="row">
        <div class="col-lg-8">
          <h3><b><?php echo $row->nama ?></b></h3>          
          <img class="img-fluid pt-3 pb-5" src="assets/im493/<?php echo $foto ?>" width="100%">
          <p>
            <?php echo str_replace("---batas---","",$row->biografi) ?>
          </p>
        </div>
        <?php $this->load->view("fronted/aside"); ?>
      </div>
    </div>
  </section>

  </main><!-- End #main -->