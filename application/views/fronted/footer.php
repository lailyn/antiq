  

<!-- ======= Footer ======= -->
  <footer id="footer">

    <div class="footer-top">
      <div class="container">
        <div class="row">

          <div class="col-lg-3 col-md-6 footer-contact">
            <h3><?php echo $setting->perusahaan ?> </h3>            
          </div>

          <div class="col-lg-3 col-md-6 footer-links">
            <h4>Hubungi Kami</h4>
            <p>
              <?php echo $setting->alamat ?>
               <br><br>
              <strong>Phone:</strong> <?php echo $setting->no_telp ?><br>
              <strong>Email:</strong> <?php echo $setting->email ?><br>
            </p>
          </div>          

          <div class="col-lg-3 col-md-6 footer-links">
            <h4>Site Map</h4>
            <ul>
              <li><i class="bx bx-chevron-right"></i> <a href="w3b">Beranda</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#tentang">Tentang Kami</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#layanan">Layanan</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#dokter">Dokter</a></li>              
              <li><i class="bx bx-chevron-right"></i> <a href="term">Terms of service</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="privacy">Privacy policy</a></li>
            </ul>
          </div>          

          <div class="col-lg-3 col-md-6 footer-newsletter">
            <h4>Download App di</h4>            
            <img src="assets/images/en_badge_web_generic.png" width="60%">                        

          </div>

          

        </div>
      </div>
    </div>

    <div class="container d-md-flex py-4">

      <div class="mr-md-auto text-center text-md-left">
        <div class="copyright">
          &copy; Copyright <strong><span><?php echo $setting->perusahaan ?></span></strong>. All Rights Reserved
        </div>
        <div class="credits">
          <!-- All the links in the footer should remain intact. -->
          <!-- You can delete the links only if you purchased the pro version. -->
          <!-- Licensing information: https://bootstrapmade.com/license/ -->
          <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/medilab-free-medical-bootstrap-theme/ -->
          Developed by exmud</a>
        </div>
      </div>
      <div class="social-links text-center text-md-right pt-3 pt-md-0">
        <a href="<?php echo $setting->twitter ?>" class="twitter"><i class="bx bxl-twitter"></i></a>
        <a href="<?php echo $setting->facebook ?>" class="facebook"><i class="bx bxl-facebook"></i></a>
        <a href="<?php echo $setting->instagram ?>" class="instagram"><i class="bx bxl-instagram"></i></a>        
        <a href="<?php echo $setting->youtube ?>" class="youtube"><i class="bx bxl-youtube"></i></a>
      </div>
    </div>
    <a style="padding-bottom: 95px; padding-right:15px; " href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>

  </footer><!-- End Footer -->

  <script type="text/javascript">
    $(document).ready(function () {
    var itemsMainDiv = ('.MultiCarousel');
    var itemsDiv = ('.MultiCarousel-inner');
    var itemWidth = "";

    $('.leftLst, .rightLst').click(function () {
        var condition = $(this).hasClass("leftLst");
        if (condition)
            click(0, this);
        else
            click(1, this)
    });

    ResCarouselSize();




    $(window).resize(function () {
        ResCarouselSize();
    });

    //this function define the size of the items
    function ResCarouselSize() {
        var incno = 0;
        var dataItems = ("data-items");
        var itemClass = ('.item');
        var id = 0;
        var btnParentSb = '';
        var itemsSplit = '';
        var sampwidth = $(itemsMainDiv).width();
        var bodyWidth = $('body').width();
        $(itemsDiv).each(function () {
            id = id + 1;
            var itemNumbers = $(this).find(itemClass).length;
            btnParentSb = $(this).parent().attr(dataItems);
            itemsSplit = btnParentSb.split(',');
            $(this).parent().attr("id", "MultiCarousel" + id);


            if (bodyWidth >= 1200) {
                incno = itemsSplit[3];
                itemWidth = sampwidth / incno;
            }
            else if (bodyWidth >= 992) {
                incno = itemsSplit[2];
                itemWidth = sampwidth / incno;
            }
            else if (bodyWidth >= 768) {
                incno = itemsSplit[1];
                itemWidth = sampwidth / incno;
            }
            else {
                incno = itemsSplit[0];
                itemWidth = sampwidth / incno;
            }
            $(this).css({ 'transform': 'translateX(0px)', 'width': itemWidth * itemNumbers });
            $(this).find(itemClass).each(function () {
                $(this).outerWidth(itemWidth);
            });

            $(".leftLst").addClass("over");
            $(".rightLst").removeClass("over");

        });
    }


    //this function used to move the items
    function ResCarousel(e, el, s) {
        var leftBtn = ('.leftLst');
        var rightBtn = ('.rightLst');
        var translateXval = '';
        var divStyle = $(el + ' ' + itemsDiv).css('transform');
        var values = divStyle.match(/-?[\d\.]+/g);
        var xds = Math.abs(values[4]);
        if (e == 0) {
            translateXval = parseInt(xds) - parseInt(itemWidth * s);
            $(el + ' ' + rightBtn).removeClass("over");

            if (translateXval <= itemWidth / 2) {
                translateXval = 0;
                $(el + ' ' + leftBtn).addClass("over");
            }
        }
        else if (e == 1) {
            var itemsCondition = $(el).find(itemsDiv).width() - $(el).width();
            translateXval = parseInt(xds) + parseInt(itemWidth * s);
            $(el + ' ' + leftBtn).removeClass("over");

            if (translateXval >= itemsCondition - itemWidth / 2) {
                translateXval = itemsCondition;
                $(el + ' ' + rightBtn).addClass("over");
            }
        }
        $(el + ' ' + itemsDiv).css('transform', 'translateX(' + -translateXval + 'px)');
    }

    //It is used to get some elements from btn
    function click(ell, ee) {
        var Parent = "#" + $(ee).parent().attr("id");
        var slide = $(Parent).attr("data-slide");
        ResCarousel(ell, Parent, slide);
    }

});
  </script>
  <!--Start of Tawk.to Script-->
  <script type="text/javascript">
  var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
  (function(){
  var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
  s1.async=true;
  s1.src='https://embed.tawk.to/5fb5da5ca1d54c18d8eb133d/default';
  s1.charset='UTF-8';
  s1.setAttribute('crossorigin','*');
  s0.parentNode.insertBefore(s1,s0);
  })();
  </script>
  <!--End of Tawk.to Script-->
  <!-- Vendor JS Files -->
  <script src="assets/front/vendor/jquery/jquery.min.js"></script>
  <script src="assets/front/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/front/vendor/jquery.easing/jquery.easing.min.js"></script>
  <script src="assets/front/vendor/php-email-form/validate.js"></script>
  <script src="assets/front/vendor/venobox/venobox.min.js"></script>
  <script src="assets/front/vendor/waypoints/jquery.waypoints.min.js"></script>
  <script src="assets/front/vendor/counterup/counterup.min.js"></script>
  <script src="assets/front/vendor/owl.carousel/owl.carousel.min.js"></script>
  <script src="assets/front/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/front/js/main.js"></script>

</body>

</html>