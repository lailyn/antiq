<!DOCTYPE html>
<html lang="en">
<base href="<?php echo base_url(); ?>" />
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title><?php echo $setting->perusahaan ?></title>
  <meta content="" name="descriptison">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link rel="shortcut icon" href="assets/images/favicon.png" />
  <link href="assets/front/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/front/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/front/vendor/icofont/icofont.min.css" rel="stylesheet">
  <link href="assets/front/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/front/vendor/venobox/venobox.css" rel="stylesheet">
  <link href="assets/front/vendor/animate.css/animate.min.css" rel="stylesheet">
  <link href="assets/front/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/front/vendor/owl.carousel/assets/owl.carousel.min.css" rel="stylesheet">
  <link href="assets/front/vendor/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">
  
  
  <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

  <!-- Template Main CSS File -->
  <link href="assets/front/css/style.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: Medilab - v2.0.0
  * Template URL: https://bootstrapmade.com/medilab-free-medical-bootstrap-theme/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
  <style type="text/css">
    .MultiCarousel { float: left; overflow: hidden; padding: 15px; width: 100%; position:relative; }
    .MultiCarousel .MultiCarousel-inner { transition: 1s ease all; float: left; }
        .MultiCarousel .MultiCarousel-inner .item { float: left;}
        .MultiCarousel .MultiCarousel-inner .item > div { text-align: center; padding:10px; margin:10px; background:#f1f1f1; color:#666;}
    .MultiCarousel .leftLst, .MultiCarousel .rightLst { position:absolute; border-radius:50%;top:calc(50% - 20px); }
    .MultiCarousel .leftLst { left:0; }
    .MultiCarousel .rightLst { right:0; }
    
        .MultiCarousel .leftLst.over, .MultiCarousel .rightLst.over { pointer-events: none; background:#ccc; }
  </style>
  <script type="text/javascript">
    var BrowserDetect = function() {
      var nav = window.navigator,
        ua = window.navigator.userAgent.toLowerCase();
      // detect browsers (only the ones that have some kind of quirk we need to work around)
      if (ua.match(/ipad/i) !== null)
        return "iPod";
      if (ua.match(/iphone/i) !== null)
        return "iPhone";
      if (ua.match(/android/i) !== null)
        return "Android";
      if ((nav.appName.toLowerCase().indexOf("microsoft") != -1 || nav.appName.toLowerCase().match(/trident/gi) !== null))
        return "IE";
      if (ua.match(/chrome/gi) !== null)
        return "Chrome";
      if (ua.match(/firefox/gi) !== null)
        return "Firefox";
      if (ua.match(/webkit/gi) !== null)
        return "Webkit";
      if (ua.match(/gecko/gi) !== null)
        return "Gecko";
      if (ua.match(/opera/gi) !== null)
        return "Opera";
      //If any case miss we will return null
      return null
    }
    var hasil = BrowserDetect();

  </script>
<?php 
function mata_uang($a){      
  if(is_numeric($a) AND $a != 0 AND $a != ""){
    return number_format($a, 0, ',', '.');
  }else{
    return $a;
  }
}
?>
</head>

<body>
  <!-- ======= Top Bar ======= -->
  <div id="topbar" class="d-none d-lg-flex align-items-center fixed-top">
    <div class="container d-flex">
      <div class="contact-info mr-auto">
        <i class="icofont-envelope"></i> <a href="mailto:<?php echo $setting->email ?>"><?php echo $setting->email ?></a>
        <i class="icofont-phone"></i> <?php echo $setting->no_telp ?>        
      </div>
      <div class="social-links">
        <a href="<?php echo $setting->twitter ?>" class="twitter"><i class="icofont-twitter"></i></a>
        <a href="<?php echo $setting->facebook ?>" class="facebook"><i class="icofont-facebook"></i></a>
        <a href="<?php echo $setting->instagram ?>" class="instagram"><i class="icofont-instagram"></i></a>        
        <a href="<?php echo $setting->youtube ?>" class="youtube"><i class="icofont-youtube"></i></i></a>
      </div>
    </div>
  </div>

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top">
    <div class="container d-flex align-items-center">

      <h1 class="logo mr-auto"><a href="w3b"><?php echo $setting->perusahaan ?></a></h1>
      <!-- Uncomment below if you prefer to use an image logo -->
      <!-- <a href="index.html" class="logo mr-auto"><img src="assets/front/img/logo.png" alt="" class="img-fluid"></a>-->

      <nav class="nav-menu d-none d-lg-block">
        <ul>
          <li class="<?php if($set=='home') echo 'active'; ?>"><a href="w3b">Home</a></li>
          <li><a href="w3b#tentang">Tentang Kami</a></li>
          <li><a href="w3b#promo">Promo</a></li>
          <li><a href="w3b#layanan">Layanan</a></li>
          <li><a href="w3b#dokter">Dokter</a></li>
          <li class="<?php if($set=='blog') echo 'active'; ?>"><a href="w3b#blog">Blog</a></li>
          <!-- <li class="drop-down"><a href="">Drop Down</a>
            <ul>
              <li><a href="#">Drop Down 1</a></li>
              <li class="drop-down"><a href="#">Deep Drop Down</a>
                <ul>
                  <li><a href="#">Deep Drop Down 1</a></li>
                  <li><a href="#">Deep Drop Down 2</a></li>
                  <li><a href="#">Deep Drop Down 3</a></li>
                  <li><a href="#">Deep Drop Down 4</a></li>
                  <li><a href="#">Deep Drop Down 5</a></li>
                </ul>
              </li>
              <li><a href="#">Drop Down 2</a></li>
              <li><a href="#">Drop Down 3</a></li>
              <li><a href="#">Drop Down 4</a></li>
            </ul>
          </li> -->
          <li><a href="w3b#kontak">Kontak</a></li>

        </ul>
      </nav><!-- .nav-menu -->

      <a class="appointment-btn scrollto">Download Aplikasi</a>

    </div>
  </header><!-- End Header -->