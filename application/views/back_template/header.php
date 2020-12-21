<!DOCTYPE html>
<base href="<?php echo base_url(); ?>" />
<html lang="en">
  <head>    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $setting = $this->m_admin->getByID("md_setting","id_setting",1)->row();?>
    <title><?php echo $setting->perusahaan ?></title>    
    <link rel="stylesheet" href="assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css">    
    <link rel="stylesheet" href="assets/css/style.css">    
    <link rel="shortcut icon" href="assets/images/favicon.png" />
    <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet"/>    
    <link href="https://www.tiny.cloud/css/codepen.min.css" rel="stylesheet"/>    

    <script src="https://cdn.tiny.cloud/1/qagffr3pkuv17a8on1afax661irst1hbr4e6tbv888sz91jc/tinymce/5.5.1-99/tinymce.min.js"></script>
    <script>
    tinymce.init({
      selector: '#textarea_plus',            
      toolbar_mode: 'floating'
    });
  </script>
  <script>
    tinymce.init({
      selector: '#textarea_plus2',            
      toolbar_mode: 'floating'
    });
  </script>
    
  </head>
  