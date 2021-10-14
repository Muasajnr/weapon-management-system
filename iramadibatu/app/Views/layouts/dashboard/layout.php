<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Iramadibatu - <?=$page_title?></title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="<?=site_url('themes/AdminLTE/plugins/fontawesome-free/css/all.min.css')?>">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?=site_url('themes/AdminLTE/dist/css/adminlte.min.css')?>">
    <!-- pace-progress -->
    <link rel="stylesheet" href="<?=site_url('themes/AdminLTE/plugins/pace-progress/themes/blue/pace-theme-flat-top.css')?>">

    <?php if (in_array('sweetalert', $contentIncludeData)): ?>
        <!-- SweetAlert2 -->
        <link rel="stylesheet" href="<?=site_url('themes/AdminLTE/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')?>">
    <?php endif; ?>

    <?php if (in_array('datatable', $contentIncludeData)): ?>
        <!-- DataTables -->
        <link rel="stylesheet" href="<?=site_url('themes/AdminLTE/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')?>">
        <link rel="stylesheet" href="<?=site_url('themes/AdminLTE/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')?>">
        <link rel="stylesheet" href="<?=site_url('themes/AdminLTE/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')?>">
    <?php endif; ?>

    <!-- Custom Style -->
    <style>
    [class*=sidebar-dark-] .nav-treeview>.nav-item>.nav-link.active-btn,
    [class*=sidebar-dark-] .nav-treeview>.nav-item>.nav-link.active-btn:focus,
    [class*=sidebar-dark-] .nav-treeview>.nav-item>.nav-link.active-btn:hover {
        background-color: #ffc107;
        color: #343a40;
    }
    </style>
    <?=$this->renderSection('custom-css')?>

    <!-- JS Header Constants -->
    <script src="<?=site_url('assets/js/constants.js')?>"></script>
    <!-- JS Header Global Helper -->
    <script src="<?=site_url('assets/js/global_helpers.js')?>"></script>
    <script>
    const accessToken = localStorage.getItem(ACCESS_TOKEN_KEY);
    const refreshToken = localStorage.getItem(REFRESH_TOKEN_KEY);
    if (!accessToken || !refreshToken || isTokenExpired(accessToken)) {
        window.location.href = '<?=site_url('/login')?>';
    }
    </script>
</head>
<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        <?=$this->include('layouts/dashboard/nav')?>
        
        <?=$this->include('layouts/dashboard/sidebar')?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">

            <?=$this->include('layouts/dashboard/page_header')?>

            <?=$this->renderSection('content')?>
            
        </div>
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
            <div class="p-3">
                <h5>Title</h5>
                <p>Sidebar content</p>
            </div>
        </aside>
        <!-- /.control-sidebar -->

        <?=$this->include('layouts/dashboard/footer')?>
    </div>
    <!-- ./wrapper -->
    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src="<?=site_url('themes/AdminLTE/plugins/jquery/jquery.min.js')?>"></script>
    <!-- Bootstrap 4 -->
    <script src="<?=site_url('themes/AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js')?>"></script>
    <!-- AdminLTE App -->
    <script src="<?=site_url('themes/AdminLTE/dist/js/adminlte.min.js')?>"></script>
    <!-- pace-progress -->
    <script src="<?=site_url('themes/AdminLTE/plugins/pace-progress/pace.min.js')?>"></script>

    <?php if (in_array('sweetalert', $contentIncludeData)): ?>
        <?=$this->include('layouts/dashboard/content_inc/sweetalert_js.php')?>
    <?php endif; ?>

    <?php if (in_array('datatable', $contentIncludeData)): ?>
        <?=$this->include('layouts/dashboard/content_inc/datatable_js.php')?>
    <?php endif; ?>

    <?php if (in_array('select2', $contentIncludeData)): ?>
        <?=$this->include('layouts/dashboard/content_inc/select2_js.php')?>
    <?php endif; ?>

    <?php if (in_array('jquery_validation', $contentIncludeData)): ?>
        <?=$this->include('layouts/dashboard/content_inc/jquery_validation_js.php')?>
    <?php endif; ?>

    <!-- Custom JS -->
    <script>
    $(document).ajaxStart(function() {
        Pace.restart();
    });
    
    $(function() {
        const refreshToken = localStorage.getItem(REFRESH_TOKEN_KEY);

        $('#btn-logout').click(function(e) {
            const logoutUrl = '<?=site_url('/api/v1/logout')?>';
            const logoutData = {
                'token': refreshToken
            };

            $.ajax({
                type: 'POST',
                url: logoutUrl,
                dataType: 'json',
                data: logoutData,
                success: function(res) {
                    localStorage.removeItem(ACCESS_TOKEN_KEY);
                    localStorage.removeItem(REFRESH_TOKEN_KEY);
                    window.location.href = '<?=site_url('/login')?>';
                },
                error: function(err) {
                }
            });
        });
    });
    </script>
    <?=$this->renderSection('custom-js')?>
</body>
</html>
