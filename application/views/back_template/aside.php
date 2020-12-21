<div class="container-scroller">
  <!-- partial:partials/_navbar.html -->
  <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
      <a class="navbar-brand brand-logo" href="adm1n"><h3><?php echo $this->m_admin->getByID("md_setting","id_setting",1)->row()->perusahaan ?></h3></a>
      <a class="navbar-brand brand-logo-mini" href="adm1n"><h3>BR</h3></a>
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-stretch">
      <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
        <span class="mdi mdi-menu"></span>
      </button>      
      <ul class="navbar-nav navbar-nav-right">
        <li class="nav-item nav-profile dropdown">
          <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
            <div class="nav-profile-img">
              <?php     
              $foto = $this->session->userdata('foto');        
              if($foto==""){
                $foto = "user.png";
              }else{
                $foto = $foto;
              }              
              ?>
              <img src="assets/im493/<?php echo $foto ?>" alt="image">
              <span class="availability-status online"></span>
            </div>
            <div class="nav-profile-text">
              <p class="mb-1 text-black">Halo, <?php echo $this->session->userdata("nama"); ?></p>
            </div>
          </a>
          <div class="dropdown-menu navbar-dropdown" aria-labelledby="profileDropdown">
            <a class="dropdown-item" href="master/profil">
              <i class="mdi mdi-cached mr-2 text-success"></i> Profil </a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="adm1n/logout">
                <i class="mdi mdi-logout mr-2 text-primary"></i> Sign Out </a>
              </div>
            </li>
            <li class="nav-item d-none d-lg-block full-screen-link">
              <a class="nav-link">
                <i class="mdi mdi-fullscreen" id="fullscreen-button"></i>
              </a>
            </li>            
          </ul>
          <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
            <span class="mdi mdi-menu"></span>
          </button>
        </div>
      </nav>
      <!-- partial -->                
      <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_sidebar.html -->
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
          <ul class="nav">            
            <li class="nav-item">
              <a class="nav-link" href="adm1n/dashboard">
                <span class="menu-icon menu-title"><i class="mdi mdi-home"></i> Dashboard</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#master" aria-expanded="false" aria-controls="master">
                <span class="menu-title"><i class="mdi mdi-arrange-bring-forward"></i> Master</span>
                <i class="menu-arrow"></i>                
              </a>
              <div class="collapse" id="master">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item"> <a class="nav-link" href="master/jenis">Jenis Transaksi</a></li>                                                                    
                  <li class="nav-item"> <a class="nav-link" href="master/user">User</a></li>                  
                  <li class="nav-item"> <a class="nav-link" href="master/setting">Setting</a></li>                  
                </ul>
              </div>
            </li> 
            <li class="nav-item">
              <a class="nav-link" href="transaksi">
                <span class="menu-icon menu-title"><i class="mdi mdi-database"></i> Transaksi</span>
              </a>
            </li> 
            <li class="nav-item">
              <a class="nav-link" href="laporan">
                <span class="menu-icon menu-title"><i class="mdi mdi-printer"></i> Laporan</span>
              </a>
            </li>                                   
          </ul>
        </nav>
        <!-- partial -->
        