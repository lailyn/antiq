<?php  
function mata_uang($a){      
  if(is_numeric($a) AND $a != 0 AND $a != ""){
    return number_format($a, 0, ',', '.');
  }else{
    return $a;
  }
}
function manipulasiTanggal($tgl,$jumlah=-1,$format='days'){
  $currentDate = new DateTime($tgl);
  $currentDate -> modify($jumlah.' '.$format);
  return $currentDate -> format('Y-m-d');
}
?>
<div class="main-panel">
  <div class="content-wrapper">    

    <div class="row">
      <div class="col-md-4 stretch-card grid-margin">
        <div class="card bg-gradient-danger card-img-holder text-white">
          <div class="card-body">
            <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
            <h4 class="font-weight-normal mb-3">User Terdaftar <i class="mdi mdi-account-multiple mdi-24px float-right"></i>
            </h4>
            <h2 class="mb-5"><?php echo $this->m_admin->getAll("md_user")->num_rows(); ?> orang</h2>
          </div>
        </div>
      </div>
      <div class="col-md-4 stretch-card grid-margin">
        <div class="card bg-gradient-info card-img-holder text-white">
          <div class="card-body">
            <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
            <h4 class="font-weight-normal mb-3">Saldo Kemarin <i class="mdi mdi-shopping mdi-24px float-right"></i>
            </h4>
            <?php 
            $hari = date("Y-m-d"); 
            $kemarin = manipulasiTanggal($hari);             
            ?>
            <h2 class="mb-5">Debit: <?php echo mata_uang($this->db->query("SELECT SUM(debit) AS jum FROM md_transaksi WHERE tanggal = '$kemarin'")->row()->jum); ?></h2>              
            <h2 class="mb-5">Kredit: <?php echo mata_uang($this->db->query("SELECT SUM(kredit) AS jum FROM md_transaksi WHERE tanggal = '$kemarin'")->row()->jum); ?></h2>              
          </div>
        </div>
      </div>
      <div class="col-md-4 stretch-card grid-margin">
        <div class="card bg-gradient-success card-img-holder text-white">
          <div class="card-body">
            <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
            <h4 class="font-weight-normal mb-3">Saldo Hari Ini <i class="mdi mdi-animation mdi-24px float-right"></i>
            </h4>
            <h2 class="mb-5">Debit: <?php echo mata_uang($this->db->query("SELECT SUM(debit) AS jum FROM md_transaksi WHERE tanggal = '$hari'")->row()->jum); ?></h2>              
            <h2 class="mb-5">Kredit: <?php echo mata_uang($this->db->query("SELECT SUM(kredit) AS jum FROM md_transaksi WHERE tanggal = '$hari'")->row()->jum); ?></h2>              
          </div>
        </div>
      </div>
    </div>      
    <div class="row">
      <div class="col-md-6 grid-margin">
        <div class="card">
          <div class="card-body">            
            <h4 class="card-title">Transaksi Tanggal <?php echo date("d F Y") ?></h4>
            <div id="diagram2"></div>
          </div>
        </div>      
      </div>
      <div class="col-md-6 grid-margin">
        <div class="card">
          <div class="card-body">            
            <h4 class="card-title">Transaksi Bulan <?php echo date("F Y") ?></h4>
            <div id="diagram1"></div>
          </div>
        </div>      
      </div>
    </div>


<base href="<?php echo base_url(); ?>" />
<script src="assets/js_chart/jquery-1.9.1.min.js" type="text/javascript"></script>
<script src="assets/js_chart/highcharts.js" type="text/javascript"></script>
<script src="assets/js_chart/exporting.js" type="text/javascript"></script>

<script type="text/javascript">
    var chart1; // globally available
    $(document).ready(function() {
      chart1 = new Highcharts.Chart({
       chart: {
        renderTo: 'diagram2',
        type: 'column'
      },   
      title: {
        text: 'Jumlah Transaksi'
      },
      xAxis: {
        categories: ['Tanggal']
      },
      yAxis: {
        title: {
         text: ''
       }
     },
     series:             
     [
     <?php     
     $g = date('Y-m-d');  
     $h = date('Y-m');
     $r = $h.'-01';
    
      $sql   = "SELECT md_jenis.jenis, COUNT(md_transaksi.id_transaksi) AS jumlah FROM md_transaksi
      INNER JOIN md_jenis ON md_transaksi.id_jenis = md_jenis.id_jenis 
      WHERE md_transaksi.tanggal BETWEEN '$r' AND '$g'
      GROUP BY md_jenis.id_jenis ORDER BY md_jenis.jenis ASC";
    
    $cek = $this->db->query($sql);
    foreach ($cek->result() as $r) {    
      // $tg=substr($r->tgl,0,5);
      // $tgl = str_replace("-", "/", $tg);
      $jenis=$r->jenis;                    
      $jumlah=$r->jumlah;                    
      ?>
      {
        name: '<?php echo $jenis; ?>',
        data: [<?php echo $jumlah; ?>]
      },
    <?php } ?>
    ]
  });
    }); 
  </script>  
  <script type="text/javascript">
    var chart1; // globally available
    $(document).ready(function() {
      chart1 = new Highcharts.Chart({
       chart: {
        renderTo: 'diagram1',
        type: 'column'
      },   
      title: {
        text: 'Nominal Transaksi'
      },
      xAxis: {
        categories: ['Tanggal']
      },
      yAxis: {
        title: {
         text: ''
       }
     },
     series:             
     [
     <?php     
     $g = date('Y-m-d');  
     $h = date('Y-m');
     $r = $h.'-01';
    
      $sql   = "SELECT md_jenis.jenis, SUM(md_transaksi.kredit) AS kredit, SUM(md_transaksi.debit) AS debit FROM md_transaksi
      INNER JOIN md_jenis ON md_transaksi.id_jenis = md_jenis.id_jenis 
      WHERE LEFT(md_transaksi.tanggal,7) = '$h'
      GROUP BY md_jenis.id_jenis ORDER BY md_jenis.jenis ASC";
    
    $cek = $this->db->query($sql);
    foreach ($cek->result() as $r) {    
      // $tg=substr($r->tgl,0,5);
      // $tgl = str_replace("-", "/", $tg);
      $jenis=$r->jenis;                    
      $kredit=$r->kredit;
      $debit=$r->debit;
      //$cek = $this->db->query("SLEECT SUM(kredit) FROM ")                    
      ?>
      {
        name: '<?php echo $jenis; ?>',
        data: [<?php echo $debit; ?>,<?php echo $kredit; ?>]
      },
    <?php } ?>
    ]
  });
    }); 
  </script>                    
                        