<!DOCTYPE html>
<html lang="en">
<base href="<?php echo base_url(); ?>" />
  <head>    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin Login</title>    
    <link rel="stylesheet" href="assets/vendors/mdi/css/materialdesignicons.min.css">    
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="https://apis.google.com/js/platform.js" async defer></script>
    <meta name="google-signin-client_id" content="220878944341-1ng59k6udpmhbcmi0297pqmjun2afmv4.apps.googleusercontent.com">
    
  </head>
  <body>
    <div class="container-scroller">
      <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth">
          <div class="row flex-grow">
            <div class="col-lg-4 mx-auto">
              <div class="auth-form-light text-left p-5">
                <div class="brand-logo">
                  <?php $st = $this->m_admin->getByID("md_setting","id_setting",1)->row(); ?>
                  <h2><?php echo $st->perusahaan ?> Administrator</h2>
                </div>                
                <form class="pt-3" method="POST" action="adm1n/login">
                  <div class="form-group">
                    <input name="username" type="text" class="form-control form-control-lg" id="exampleInputEmail1" placeholder="Username">
                  </div>
                  <div class="form-group">
                    <input name="password" type="password" class="form-control form-control-lg" id="exampleInputEmail1" placeholder="Password">
                  </div>
                  <div class="form-group">                    
                    <span id="captImg"><?php echo $captchaImg; ?> </span>               
                    <input autocomplete="off" name="kode" type="text" class="form-control form-control-lg" id="exampleInputPassword1" placeholder="Kode Captcha">                                      
                  </div>
                  <div class="mt-3">
                    <button type="submit" class="btn btn-gradient-primary btn-lg font-weight-medium auth-form-btn">Sign In</button>                                  
                    <button type="reset" class="btn btn-gradient-danger btn-lg font-weight-medium auth-form-btn">Reset</button>                                  
                    
<div class="g-signin2" data-onsuccess="onSignIn"></div>

                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    
    
<script>

function checkLoginState() {
  FB.getLoginStatus(function(response) {
    statusChangeCallback(response);
  });
}

  FB.getLoginStatus(function(response) {
      statusChangeCallback(response);
  });

  window.fbAsyncInit = function() {
    FB.init({
      appId      : '2751083721823162',
      cookie     : true,
      xfbml      : true,
      version    : 'v9.0'
    });
      
    FB.AppEvents.logPageView();   
      
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "https://connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
  </script>

  </body>
</html>