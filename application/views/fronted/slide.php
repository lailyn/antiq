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
  if(!isset($row->gambar) AND $row->gambar==""){
    $foto = "alt-tag.png";
  }else{
    $foto = $row->gambar;
  }
  ?>
  <section class="inner-page">
    <div class="container">
      <div class="row">
        <div class="col-lg-8">
          <h3><?php echo $row->judul ?></h3>          
          <img class="img-fluid pt-3 pb-5" src="assets/art1kel/<?php echo $foto ?>" width="100%">
          <p>
            <?php echo str_replace("---batas---","",$row->isi) ?>
          </p>
        </div>
        <?php $this->load->view("fronted/aside"); ?>
      </div>
    </div>
  </section>

  </main><!-- End #main -->