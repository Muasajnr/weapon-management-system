<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Login - Inventory Barang</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?=site_url('themes/AdminLTE/plugins/fontawesome-free/css/all.min.css')?>">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="<?=site_url('themes/AdminLTE/plugins/icheck-bootstrap/icheck-bootstrap.min.css')?>">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?=site_url('themes/AdminLTE/dist/css/adminlte.min.css')?>">
  <!-- View Style -->
  <?=$this->renderSection('custom-style')?>
</head>
<body class="hold-transition login-page">

  <?=$this->renderSection('content')?>

<!-- jQuery -->
<script src="<?=site_url('themes/AdminLTE/plugins/jquery/jquery.min.js')?>"></script>
<!-- Bootstrap 4 -->
<script src="<?=site_url('themes/AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js')?>"></script>
<!-- AdminLTE App -->
<script src="<?=site_url('themes/AdminLTE/dist/js/adminlte.min.js')?>"></script>
<!-- View Scripts -->
<?=$this->renderSection('custom-js')?>

</body>
</html>
