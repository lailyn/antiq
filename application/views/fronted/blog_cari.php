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
  <section class="inner-page">
    <div class="container">
      <div class="row">
        <div class="col-lg-8 entries">
          <?php if($mode=='cari'){ ?>
          <h4>Hasil Pencarian: <b><?php echo $cari ?></b> </h4> <br>
          <?php } ?>
          <article class="entry">
            <?php 
            $no=1;          
            foreach ($dt_artikel->result() as $isi) {           
            ?>
            <div class="row">
              <div class="col-md-3">
                <a href="blog/detail/<?php echo $isi->permalink ?>"><img src="assets/art1kel/<?php echo $isi->gambar1 ?>" alt="" width="100%" class="img-fluid"></a>
              </div>
              <div class="col-md-9">
                <a href="blog/detail/<?php echo $isi->permalink ?>"><h4><?php echo $isi->judul ?></h4></a>
                <div class="text-left"><font size="2px"><?php echo date('d F Y', strtotime(substr($isi->created_at, 0,10))) ?> | <a href="blog/kategori/<?php echo $isi->id_artikel_kategori ?>"><?php echo $isi->kategori ?></a> </font></div>
              </div>                          
            </div>
            <hr>
            <?php } ?>
          </article><!-- End blog entry -->          
        </div>
        <?php $this->load->view("fronted/aside"); ?>
      </div>
    </div>
  </section>

  </main><!-- End #main -->