
<footer class="footer">
      <div class="d-sm-flex justify-content-center justify-content-sm-between">
        <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © <?php echo date("Y") ?> 
        <?php $setting = $this->m_admin->getByID("md_setting","id_setting",1)->row();?>
        <?php echo $setting->perusahaan ?> All rights reserved.</span>
        <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center"></span>
      </div>
    </footer>
    <!-- partial -->
  </div>
  <!-- main-panel ends -->
  </div>
    <script src="assets/vendors/js/vendor.bundle.base.js"></script>    
    <script src="assets/vendors/chart.js/Chart.min.js"></script>    
    <script src="assets/js/off-canvas.js"></script>
    <script src="assets/js/hoverable-collapse.js"></script>
    <script src="assets/js/misc.js"></script>    
    <script src="assets/js/dashboard.js"></script>
    <script src="assets/js/todolist.js"></script>   
    <script src="assets/js/center.js"></script>   
    <script src="//cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>    
    <script src="assets/panel/datatables/jquery.dataTables.min.js"></script>
    <script>
    $("input[data-type='currency']").on({
        keyup: function() {
          formatCurrency($(this));
        },
        blur: function() { 
          formatCurrency($(this), "blur");
        }
    });


    function formatNumber(n) {
      // format number 1000000 to 1,234,567
      return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
    }


    function formatCurrency(input, blur) {
      // appends $ to value, validates decimal side
      // and puts cursor back in right position.
      
      // get input value
      var input_val = input.val();
      
      // don't validate empty input
      if (input_val === "") { return; }
      
      // original length
      var original_len = input_val.length;

      // initial caret position 
      var caret_pos = input.prop("selectionStart");
        
      // check for decimal
      if (input_val.indexOf(".") >= 0) {

        // get position of first decimal
        // this prevents multiple decimals from
        // being entered
        var decimal_pos = input_val.indexOf(".");

        // split number by decimal point
        var left_side = input_val.substring(0, decimal_pos);
        var right_side = input_val.substring(decimal_pos);

        // add commas to left side of number
        left_side = formatNumber(left_side);

        // validate right side
        right_side = formatNumber(right_side);
        
        // On blur make sure 2 numbers after decimal
        if (blur === "blur") {
          right_side += "00";
        }
        
        // Limit decimal to only 2 digits
        right_side = right_side.substring(0, 2);

        // join number by .
        input_val = left_side + "." + right_side;

      } else {
        // no decimal entered
        // add commas to number
        // remove all non-digits
        input_val = formatNumber(input_val);
        input_val = input_val;
        
        // final formatting
        
      }
      
      // send updated string to input
      input.val(input_val);

      // put caret back in the right position
      var updated_len = input_val.length;
      caret_pos = updated_len - original_len + caret_pos;
      input[0].setSelectionRange(caret_pos, caret_pos);
    }
    </script>
    <script type="text/javascript">
    $(document).ready(function() {
      $("#example").DataTable();  
      $("#kelurahan_dt").DataTable( {
        serverSide: true,
        ajax: {
            url: "<?php echo site_url("master/kelurahan/ajax_list")?>",
            type: "POST"
        }
      } );
      $("#kecamatan_dt").DataTable( {
        serverSide: true,
        ajax: {
            url: "<?php echo site_url("master/kecamatan/ajax_list")?>",
            type: "POST"
        }
      } );
      $("#kabupaten_dt").DataTable( {
        serverSide: true,
        ajax: {
            url: "<?php echo site_url("master/kabupaten/ajax_list")?>",
            type: "POST"
        }
      } );
      $("#provinsi_dt").DataTable( {
        serverSide: true,
        ajax: {
            url: "<?php echo site_url("master/provinsi/ajax_list")?>",
            type: "POST"
        }
      } );
      $("#dokter_dt").DataTable( {
        serverSide: true,
        ajax: {
            url: "<?php echo site_url("master/dokter/ajax_list")?>",
            type: "POST"
        }
      } );
      $("#karyawan_dt").DataTable( {
        serverSide: true,
        ajax: {
            url: "<?php echo site_url("master/karyawan/ajax_list")?>",
            type: "POST"
        }
      } );
      $("#instansi_dt").DataTable( {
        serverSide: true,
        ajax: {
            url: "<?php echo site_url("master/instansi/ajax_list")?>",
            type: "POST"
        }
      } );
      $("#penyakit_dt").DataTable( {
        serverSide: true,
        ajax: {
            url: "<?php echo site_url("master/penyakit/ajax_list")?>",
            type: "POST"
        }
      } );
      $("#obat_dt").DataTable( {
        serverSide: true,
        ajax: {
            url: "<?php echo site_url("master/obat/ajax_list")?>",
            type: "POST"
        }
      } );
      $("#user_dt").DataTable( {
        serverSide: true,
        ajax: {
            url: "<?php echo site_url("master/user/ajax_list")?>",
            type: "POST"
        }
      } );
      $("#artikel_dt").DataTable( {
        serverSide: true,
        ajax: {
            url: "<?php echo site_url("front/artikel/ajax_list")?>",
            type: "POST"
        }
      } );
      $("#slide_dt").DataTable( {
        serverSide: true,
        ajax: {
            url: "<?php echo site_url("front/slide/ajax_list")?>",
            type: "POST"
        }
      } );
      $("#galeri_dt").DataTable( {
        serverSide: true,
        ajax: {
            url: "<?php echo site_url("front/galeri/ajax_list")?>",
            type: "POST"
        }
      } );
      $("#faq_dt").DataTable( {
        serverSide: true,
        ajax: {
            url: "<?php echo site_url("front/faq/ajax_list")?>",
            type: "POST"
        }
      } );
      $("#profil_dt").DataTable( {
        serverSide: true,
        ajax: {
            url: "<?php echo site_url("front/profil/ajax_list")?>",
            type: "POST"
        }
      } );
      $("#promo_dt").DataTable( {
        serverSide: true,
        ajax: {
            url: "<?php echo site_url("front/promo/ajax_list")?>",
            type: "POST"
        }
      } );
      $("#pesan_dt").DataTable( {
        serverSide: true,
        ajax: {
            url: "<?php echo site_url("front/pesan/ajax_list")?>",
            type: "POST"
        }
      } );
      $("#layanan_dt").DataTable( {
        serverSide: true,
        ajax: {
            url: "<?php echo site_url("trans/layanan/ajax_list")?>",
            type: "POST"
        }
      } );
      $("#layanan_sub_dt").DataTable( {
        serverSide: true,
        ajax: {
            url: "<?php echo site_url("trans/layanan_sub/ajax_list")?>",
            type: "POST"
        }
      } );
      $("#layanan_sub2_dt").DataTable( {
        serverSide: true,
        ajax: {
            url: "<?php echo site_url("trans/layanan_sub2/ajax_list")?>",
            type: "POST"
        }
      } );
      $("#transaksi_dt").DataTable( {
        serverSide: true,
        ajax: {
            url: "<?php echo site_url("transaksi/ajax_list")?>",
            type: "POST"
        }
      } );
    });
    </script>


    
  </body>
</html>