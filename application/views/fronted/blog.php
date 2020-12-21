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
  $baca = $row->baca + 1;
  $this->db->query("UPDATE md_artikel SET baca = '$baca' WHERE id_artikel = '$row->id_artikel'");
  if(!isset($row->gambar1) AND $row->gambar1==""){
    $foto = "alt-tag.png";
  }else{
    $foto = $row->gambar1;
  }
  ?>
  <section class="inner-page">
    <div class="container">
      <div class="row">
        <div class="col-lg-8">
          <h3><?php echo $row->judul ?></h3>
          <div class="text-left"><font size="2px">Ditinjau oleh: <a href="blog/user/<?php echo $row->nama_lengkap ?>"> <?php echo $row->nama_lengkap ?></a> | <?php echo date('d F Y', strtotime(substr($row->created_at, 0,10))) ?> | <a href="blog/kategori/<?php echo $row->id_artikel_kategori ?>"><?php echo $row->kategori ?></a> | Dibaca: <?php echo $row->baca ?> x </font></div>
          <img class="img-fluid pt-3 pb-5" src="assets/art1kel/<?php echo $foto ?>" width="100%">
          <p>
            <?php echo $row->isi ?>
          </p>
        </div>
        <?php $this->load->view("fronted/aside"); ?>
      </div>
    </div>
  </section>

  </main><!-- End #main -->