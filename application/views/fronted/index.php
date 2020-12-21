  <link rel="stylesheet" href="assets/flex/flexslider.css" type="text/css" media="screen" />

  <!-- ======= Hero Section ======= -->
  <section id="hero" class="col-lg-12 col-sm-4 d-flex align-items-center">     
      <div id="carouselExampleIndicators" class="col-lg-12 col-sm-12 carousel slide" data-ride="carousel"  style="margin: -70px 0 -140px 0;">
        
        <div class="carousel-inner">
          <?php           
          $no=1;
          $sql = $this->m_admin->getByID("md_slide","status","publish");
          foreach ($sql->result() as $isi) {            
            if($no==1) $s = 'active';
              else $s="";
          ?>
          <div class="carousel-item <?php echo $s ?>">
            <a href='slide/detail/<?php echo $isi->permalink ?>'><img class="d-block w-100" src="assets/art1kel/<?php echo $isi->gambar ?>" alt="<?php echo $isi->permalink ?>"></a>            
            <div class="carousel-caption d-none d-md-block text-right" style="margin-bottom:300px;">
              <a href='slide/detail/<?php echo $isi->permalink ?>'><h4><?php echo $isi->judul ?></h4></a>            
              <p>
                <?php 
                $mb = explode("---batas---", $isi->isi);
                echo $mb[0]; 
                if($mb[0]==""){
                  $st = "style=display:none;";
                }else{
                  $st = "";
                }
                ?>
              </p>
              <div <?php echo $st ?> class="text-right">
                <a href='slide/detail/<?php echo $isi->permalink ?>' class="btn btn-sm btn-primary">Selengkapnya <i class="bx bx-chevron-right"></i></a>
              </div>
            </div>            
          </div>
          <?php $no++; } ?>                    

        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>
    </div>
  </section><!-- End Hero -->

  <main id="main">

    <!-- ======= Why Us Section ======= -->
    <section id="why-us" class="col-lg-8 col-sm-12 why-us" style="margin-top: -200px; margin-bottom: -90px;"><!--  style="margin-top:-180px;"> -->
      <div class="container">

        <div class="row">
          <div class="col-lg-8 d-flex align-items-stretch">
            <div class="content">
              <?php 
              $sql = $this->m_admin->getByID("md_profil","id_profil",2)->row();      
              $mb = explode("---batas---", $sql->deskripsi);
              echo $mb[0];
              ?>              
              <div class="text-left">
                <a href="profil/detail/2" class="more-btn">Selengkapnya <i class="bx bx-chevron-right"></i></a>
              </div>
            </div>
          </div>          
        </div>

      </div>
    </section><!-- End Why Us Section -->

    <!-- ======= About Section ======= -->
    <section id="tentang" class="about">
      <div class="container-fluid">

        <div class="row">
          <div class="col-xl-5 col-lg-6 video-box d-flex justify-content-center align-items-stretch">
            <a href="<?php echo $sql = $this->m_admin->getByID("md_profil","id_profil",7)->row()->deskripsi; ?>" class="venobox play-btn mb-4" data-vbtype="video" data-autoplay="true"></a>
          </div>

          <div class="col-xl-7 col-lg-6 icon-boxes d-flex flex-column align-items-stretch justify-content-center py-5 px-lg-5">
            <?php 
            $sql = $this->m_admin->getByID("md_profil","id_profil",3)->row();                  
            echo $sql->deskripsi;
            ?>              

            <div class="icon-box">
              <div class="icon"><i class="bx bx-fingerprint"></i></div>
              <?php 
              $sql = $this->m_admin->getByID("md_profil","id_profil",4)->row();      
              echo $sql->deskripsi;
              ?>              
            </div>

            <div class="icon-box">
              <div class="icon"><i class="bx bx-gift"></i></div>
              <?php 
              $sql = $this->m_admin->getByID("md_profil","id_profil",5)->row();      
              echo $sql->deskripsi;
              ?>              
            </div>

            <div class="icon-box">
              <div class="icon"><i class="bx bx-atom"></i></div>
              <?php 
              $sql = $this->m_admin->getByID("md_profil","id_profil",6)->row();      
              echo $sql->deskripsi;
              ?>              
            </div>

          </div>
        </div>

      </div>
    </section><!-- End About Section -->

    <!-- ======= Counts Section ======= -->
    <section id="promo">          
      <div class="container">
        <div class="section-title">
          <h2>Promo</h2>
          <p>Kami menyediakan berbagai macam promo yang bisa anda manfaatkan.</p>
        </div>                
        <div class="flexslider carousel">
          <ul class="slides">
            <?php 
            $no=1;
            $sql = $this->m_admin->getByID("md_promo","status","publish");
            foreach ($sql->result() as $isi) {            
              if($no==1) $s = 'active';
                else $s="";
            ?>
            <li>
              <a href="promo/detail/<?php echo $isi->permalink ?>"><img src="assets/art1kel/<?php echo $isi->gambar ?>"/></a>
            </li>
            <?php } ?>
            <!-- items mirrored twice, total of 12 -->
          </ul>
        </div>
      </div>
      </div>
    </section>
  

    

   

    <!-- ======= Departments Section ======= -->
    <section id="layanan" class="departments">
      <div class="container">

        <div class="section-title">
          <h2>Layanan</h2>
          <p>Kami menyediakan berbagai macam layanan yang dapat anda manfaatkan.</p>
        </div>

        <div class="row">
          <div class="col-lg-3">
            <ul class="nav nav-tabs flex-column">
              <?php 
              $sql = $this->m_admin->getByID("md_layanan","status","publish");
              foreach ($sql->result() as $amb) {                
              ?>
              <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#tab-<?php echo $amb->id_layanan ?>"><?php echo $amb->layanan ?></a>
              </li>
              <?php } ?>              
            </ul>
          </div>
          <div class="col-lg-9 mt-4 mt-lg-0">
            <div class="tab-content">
              <?php 
              $sql = $this->m_admin->getByID("md_layanan","status","publish");
              foreach ($sql->result() as $amb) {                
                if(!isset($amb->foto) AND $amb->foto==""){
                  $foto = "alt-tag.png";
                }else{
                  $foto = $amb->foto;
                }
              ?>
              <div class="tab-pane <?php if($amb->id_layanan==1) echo 'show active'; ?>" id="tab-<?php echo $amb->id_layanan ?>">
                <div class="row">
                  <div class="col-lg-8 details order-2 order-lg-1">
                    <h3><?php echo $amb->layanan ?></h3>                    
                    <p><?php echo $amb->deskripsi ?></p>
                    <a href="layanan/detail/<?php echo $amb->id_layanan ?>" class="btn btn-primary">Baca Selengkapnya <i class="bx bx-chevron-right"></i></a>
                  </div>
                  <div class="col-lg-4 text-center order-1 order-lg-2">
                    <img src="assets/art1kel/<?php echo $foto ?>" alt="" class="img-fluid">
                  </div>
                </div>
              </div>
              <?php } ?>

              
            </div>
          </div>
        </div>

      </div>
    </section><!-- End Departments Section -->
    <section id="dokter" class="testimonials">
      <div class="container">
        <div class="section-title">
          <h2>Dokter</h2>
          <p>Kami didukung oleh banyak dokter yang berkompeten di bidangnya. Berikut beberapa diantaranya.</p>
        </div>

        <div class="owl-carousel testimonials-carousel">
          <?php  
          $sql = $this->db->query("SELECT md_dokter.*,md_kategori.kategori FROM md_dokter INNER JOIN md_kategori ON md_dokter.id_kategori = md_kategori.id_kategori 
             WHERE md_dokter.status = 1 ORDER BY rand() LIMIT 0,4");
          foreach ($sql->result() as $isi) {            
            if(!isset($isi->foto) AND $isi->foto==""){
              $foto = "user.png";
            }else{
              $foto = $isi->foto;
            }
            $link = encrypt_url($isi->id_dokter); 
          ?>
          <div class="testimonial-wrap">
            <div class="testimonial-item">
              <a href="dokter/detail/<?php echo $link ?>"><img src="assets/im493/<?php echo $foto ?>" class="testimonial-img" alt=""></a>
              <a href="dokter/detail/<?php echo $link ?>"><h3><?php echo $isi->nama ?></h3></a>
              <h4><?php echo $isi->kategori ?></h4>
              <p>
                <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                <?php 
                $mb = explode("---batas---", $isi->biografi);
                echo $mb[0]; 
                ?>
                <i class="bx bxs-quote-alt-right quote-icon-right"></i>
              </p>
            </div>
          </div>
          <?php } ?>

          

        </div>

      </div>
    </section><!-- End Testimonials Section -->    

    <!-- ======= Frequently Asked Questions Section ======= -->
    <section id="faq" class="faq section-bg">
      <div class="container">

        <div class="section-title">
          <h2>Frequently Asked Questions</h2>
          <p>Berikut ini adalah beberapa pertanyaan yang sering muncul berkaitan dengan <?php echo $setting->perusahaan ?></p>
        </div>

        <div class="faq-list">
          <ul>
            <?php  
            $sql = $this->m_admin->getByID("md_faq","status","publish");
            foreach ($sql->result() as $isi) {                          
            ?>
            <li data-aos="fade-up" data-aos-delay="100">
              <i class="bx bx-help-circle icon-help"></i> <a data-toggle="collapse" class="collapse" href="#faq-list-<?php echo $isi->id_faq ?> "><?php echo $isi->judul ?> <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
              <div id="faq-list-<?php echo $isi->id_faq ?>" class="collapse" data-parent=".faq-list">
                <p>
                  <?php echo $isi->isi ?>
                </p>
              </div>
            </li>

          

            <?php } ?>

          </ul>
        </div>

      </div>
    </section><!-- End Frequently Asked Questions Section -->    

    <!-- ======= Gallery Section ======= -->
    <section id="blog" class="gallery">
      <div class="container">

        <div class="section-title">
          <h2>Blog</h2>
          <p>Temukan berbagai informasi kesehatan terkini dari sumber terpercaya</p>
        </div>
      </div>

      <div class="container-fluid m-4">
        <div class="row">
          <?php  
          $sql = $this->db->query("SELECT * FROM md_artikel WHERE status = 'publish' ORDER BY md_artikel.id_artikel DESC LIMIT 0,4");
          foreach ($sql->result() as $row) { 
            if(!isset($row->gambar1) AND $row->gambar1==""){
              $foto = "alt-tag.png";
            }else{
              $foto = $row->gambar1;
            }                         
          ?>
          <div class="col-lg-3 col-md-4 mb-2">
            <div class="card" style="width: 18rem; height: 28rem;">
              <a href="blog/detail/<?php echo $row->permalink ?>">
                <img class="card-img-top" src="assets/art1kel/<?php echo $foto ?>" alt="Card image cap">
              </a>
              <div class="card-header">
                <a href="blog/detail/<?php echo $row->permalink ?>"><?php echo $row->judul ?></a>
              </div>
              <div class="card-body">
                <p class="card-text"><?php echo $row->preview ?></p>
              </div>
            </div>
          </div>
          <?php } ?>
          
          <div class="col-lg-12 col-md-12">          
            <br>
            <div class="text-center"><a href="blog" class="btn btn-primary pl-5 pr-5">Selengkapnya</a></div>
          </div>
        </div>
      </div>
    </section><!-- End Gallery Section -->

    <!-- ======= Contact Section ======= -->
    <section id="kontak" class="contact">
      <div class="container">

        <div class="section-title">
          <h2>Kontak</h2>
          <p>Anda bisa langsung hubungi kami di alamat sesuai map, atau bisa juga melalui email dan no telepon yang sudah kami sediakan.</p>
        </div>
      </div>

      <div>
        <?php 
        $lat = $this->m_admin->getByID("md_setting","id_setting",1)->row()->lat;
        $lang = $this->m_admin->getByID("md_setting","id_setting",1)->row()->lang;
        ?>

        <iframe src="https://maps.google.com/maps?q=<?php echo $lat ?>,<?php echo $lang ?>&hl=en&z=14&amp;output=embed" width="100%" height="350px" frameborder="0" style="border:0" allowfullscreen></iframe>            
        
      </div>

      <div class="container">
        <div class="row mt-5">

          <div class="col-lg-4">
            <div class="info">
              <div class="address">
                <i class="icofont-google-map"></i>
                <h4>Location:</h4>
                <p><?php echo $setting->alamat ?></p>
              </div>

              <div class="email">
                <i class="icofont-envelope"></i>
                <h4>Email:</h4>
                <p><?php echo $setting->email ?></p>
              </div>

              <div class="phone">
                <i class="icofont-phone"></i>
                <h4>Call:</h4>
                <p><?php echo $setting->no_telp ?></p>
              </div>

            </div>

          </div>

          <div class="col-lg-8 mt-5 mt-lg-0">
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
            <form action="w3b/kirim" method="post" role="form" class="php-email-form">
              <div class="form-row">
                <div class="col-md-6 form-group">
                  <input type="text" name="nama" class="form-control" id="name" placeholder="Nama" data-rule="minlen:4" data-msg="Please enter at least 4 chars" />
                  <div class="validate"></div>
                </div>
                <div class="col-md-6 form-group">
                  <input type="email" class="form-control" name="email" id="email" placeholder="Email" data-rule="email" data-msg="Please enter a valid email" />
                  <div class="validate"></div>
                </div>
              </div>
              <div class="form-group">
                <input type="text" class="form-control" name="subjek" id="subject" placeholder="Subjek" data-rule="minlen:4" data-msg="Please enter at least 8 chars of subject" />
                <div class="validate"></div>
              </div>
              <div class="form-group">
                <textarea class="form-control" name="pesan" rows="5" data-rule="required" data-msg="Please write something for us" placeholder="Pesan"></textarea>
                <div class="validate"></div>
              </div>
              <div class="mb-3">
                <div class="loading">Loading</div>
                <div class="error-message"></div>
                <div class="sent-message">Your message has been sent. Thank you!</div>
              </div>
              <div class="text-center"><button type="submit">Kirim Pesan</button></div>
            </form>

          </div>

        </div>

      </div>
    </section><!-- End Contact Section -->

  </main><!-- End #main -->

  

  <!-- FlexSlider -->
  <script defer src="assets/flex/jquery.flexslider.js"></script>

  <script type="text/javascript">
    $(function(){
      SyntaxHighlighter.all();
    });    
    $(window).load(function(){
      $('.flexslider').flexslider({
        animation: "slide",
        animationLoop: false,
        itemWidth: 400,
        itemMargin: 15,        
        start: function(slider){
          $('body').removeClass('loading');
        }
      });
    });
  </script>