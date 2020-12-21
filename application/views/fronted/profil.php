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
  
  ?>
  <section class="inner-page">
    <div class="container">
      <div class="row">
        <div class="col-lg-8">          
          <p>
            
            <?php echo str_replace("---batas---","",$row->deskripsi) ?>
          </p>
        </div>
        <?php $this->load->view("fronted/aside"); ?>
      </div>
    </div>
  </section>

  </main><!-- End #main -->