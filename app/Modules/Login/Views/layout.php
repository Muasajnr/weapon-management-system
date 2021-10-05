<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>IRAMADIBATU - Login</title>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?=site_url('assets/css/login.css')?>">
    <!-- JS Header Constants -->
    <script src="<?=site_url('assets/js/constants.js')?>"></script>
    <!-- JS Header Global Helper -->
    <script src="<?=site_url('assets/js/global_helpers.js')?>"></script>
    <script>
    const accessToken = localStorage.getItem(ACCESS_TOKEN_KEY);
    if (accessToken && !isTokenExpired(accessToken)) {
        window.location.href = '<?=site_url('/dashboard')?>';
    } else {
        localStorage.removeItem(ACCESS_TOKEN_KEY);
        localStorage.removeItem(REFRESH_TOKEN_KEY);
    }
    </script>
</head>
<body>
    
    <?=$this->renderSection('content')?>

    <!-- jQuery -->
    <script src="<?=site_url('themes/AdminLTE/plugins/jquery/jquery.min.js')?>"></script>
    <!-- Bootstrap 4 -->
    <script src="<?=site_url('themes/AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js')?>"></script>

    <?=$this->renderSection('custom_js')?>
</body>
</html>