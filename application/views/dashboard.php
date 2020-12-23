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
      <div class="col-12 grid-margin">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Transaksi Terbaru</h4>
            
          </div> 
                        