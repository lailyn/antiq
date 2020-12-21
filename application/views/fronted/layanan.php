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
          <h3><?php echo $row->layanan ?></h3>          
          <img class="img-fluid pt-3 pb-5" src="assets/art1kel/<?php echo $foto ?>" width="100%">
          <p>
            <?php echo $row->deskripsi ?>

            <?php 
            $cek = $this->m_admin->getByID("md_layanan_sub","id_layanan",$row->id_layanan);
            if($cek->num_rows() > 0){              
              echo "<table class='table table-bordered table-striped'>
              <tr>
                <th>Detail Layanan</th>
              </tr>";
              foreach ($cek->result() as $isi) {
                if($isi->deskripsi==''){
                  $deskripsi = "<blockquote>$isi->deskripsi</blockquote>";
                }else{
                  $deskripsi = "";
                }
                echo "              
                  <tr>
                    <td>
                      $isi->layanan_sub 
                      $deskripsi";
                    $cek2 = $this->m_admin->getByID("md_layanan_sub2","id_layanan_sub",$isi->id_layanan_sub);
                    if($cek2->num_rows() > 0){              
                      echo "<ul>";
                      foreach ($cek2->result() as $amb) {
                        echo "<li>$amb->layanan_sub2 ($amb->tarif)</li>";
                        $cek3 = $this->m_admin->getByID("md_layanan_sub3","id_layanan_sub2",$amb->id_layanan_sub2);
                        if($cek3->num_rows() > 0){              
                          echo "<ul>";
                          foreach ($cek3->result() as $amc) {
                            echo "<li>$amc->layanan_sub3 ($amc->tarif)</li>";
                          }
                          echo "</ul>";
                        }
                      }
                      echo "</ul>";
                    }else{
                      echo "(".mata_uang($isi->tarif).")";
                    }
                    echo "</td>
                  </tr>
                ";
              }
              echo "</table>";
            }
            ?>
          </p>
        </div>
        <?php $this->load->view("fronted/aside2"); ?>
      </div>
    </div>
  </section>

  </main><!-- End #main -->