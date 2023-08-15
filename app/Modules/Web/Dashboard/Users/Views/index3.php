<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>IRAMADIBATU - <?=$page_title?></title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="<?=site_url('themes/AdminLTE/plugins/fontawesome-free/css/all.min.css')?>">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?=site_url('themes/AdminLTE/dist/css/adminlte.min.css')?>">
    <!-- pace-progress -->
    <link rel="stylesheet" href="<?=site_url('themes/AdminLTE/plugins/pace-progress/themes/blue/pace-theme-flat-top.css')?>">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="<?=site_url('themes/AdminLTE/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')?>">
    <style>
    [class*=sidebar-dark-] .nav-treeview>.nav-item>.nav-link.active-btn,
    [class*=sidebar-dark-] .nav-treeview>.nav-item>.nav-link.active-btn:focus,
    [class*=sidebar-dark-] .nav-treeview>.nav-item>.nav-link.active-btn:hover {
        background-color: #ffc107;
        color: #343a40;
    }
    </style>
    <!-- Custom Style -->
    <!-- DataTables -->
    <link rel="stylesheet" href="<?=site_url('themes/AdminLTE/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')?>">
    <link rel="stylesheet" href="<?=site_url('themes/AdminLTE/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')?>">
    <link rel="stylesheet" href="<?=site_url('themes/AdminLTE/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')?>">
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

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a id="btn-logout" href="javascript:void(0)" class="nav-link">
                        <i class="fas fa-sign-out-alt nav-icon"></i>&nbsp;&nbsp;Logout
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="<?=route_to('dashboard')?>" class="brand-link">
            <img src="<?=site_url('assets/images/logo3.png')?>" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light"><strong>IRAMADIBATU</strong></span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <!-- <img src="" class="img-circle elevation-2" alt="User Image"> -->
                        <div style="width: 35px; height: 35px; background-color:#bfbfbf; border-radius: 100%; padding-top: .3rem;" class="image-circle text-center">
                            AA
                        </div>
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">testuser18</a>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
                            with font-awesome or any other icon font library -->
                        <li class="nav-item">
                            <a href="<?=route_to('dashboard')?>" class="nav-link <?=service('uri')->getSegment(2) == '' ? 'active' : ''?>">
                            <i class="fas fa-home nav-icon"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-header text-primary">Master Data</li>
                        <li class="nav-item <?=service('uri')->getSegment(2) == 'master' ? 'menu-open' : ''?>">
                            <a href="#" class="nav-link <?=service('uri')->getSegment(2) == 'master' ? 'active' : ''?>">
                                <i class="nav-icon fas fa-desktop"></i>
                                <p>
                                    Master Data
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="<?=route_to('jenis_inventaris')?>" class="nav-link <?=service('uri')->getSegment(2) == 'master' ? (service('uri')->getSegment(3) == 'jenis_inventaris' ? 'active' : '') : ''?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Data Jenis Inventaris</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?=route_to('jenis_sarana')?>" class="nav-link <?=service('uri')->getSegment(2) == 'master' ? (service('uri')->getSegment(3) == 'jenis_sarana' ? 'active' : '') : ''?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Data Jenis Sarana</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?=route_to('merk_sarana')?>" class="nav-link <?=service('uri')->getSegment(2) == 'master' ? (service('uri')->getSegment(3) == 'merk_sarana' ? 'active' : '') : ''?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Data Merk Sarana</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="<?=route_to('users')?>" class="nav-link <?=service('uri')->getSegment(2) == 'users' ? 'active' : ''?>">
                                <i class="fas fa-users nav-icon"></i>
                                <p>Data User</p>
                            </a>
                        </li>
                        <li class="nav-header text-success">Movement Sarana Kemanan</li>
                        <li class="nav-item <?=service('uri')->getSegment(2) == 'sarana_keamanan' ? 'menu-open' : ''?>">
                            <a href="#" class="nav-link <?=service('uri')->getSegment(2) == 'sarana_keamanan' ? 'active' : ''?>">
                                <i class="nav-icon fas fa-box"></i>
                                <p>
                                    Sarana Keamanan
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="<?=route_to('senjata_api')?>" class="nav-link <?=service('uri')->getSegment(2) == 'sarana_keamanan' ? (service('uri')->getSegment(3) == 'senjata_api' ? 'active' : '') : ''?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Senjata Api</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?=route_to('non_organik')?>" class="nav-link <?=service('uri')->getSegment(2) == 'sarana_keamanan' ? (service('uri')->getSegment(3) == 'non_organik' ? 'active' : '') : ''?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Non Organik</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?=route_to('lainnya')?>" class="nav-link <?=service('uri')->getSegment(2) == 'sarana_keamanan' ? (service('uri')->getSegment(3) == 'lainnya' ? 'active' : '') : ''?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Lainnya</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item <?=service('uri')->getSegment(2) == 'bon_pinjam_sarana' ? 'menu-open' : ''?>">
                            <a href="#" class="nav-link <?=service('uri')->getSegment(2) == 'bon_pinjam_sarana' ? 'active' : ''?>">
                                <i class="nav-icon fas fa-desktop"></i>
                                <p>
                                    Bon Pinjam Sarana
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="<?=route_to('pinjam')?>" class="nav-link <?=service('uri')->getSegment(2) == 'bon_pinjam_sarana' ? (service('uri')->getSegment(3) == 'pinjam' ? 'active' : '') : ''?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Pinjam</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?=route_to('kembalikan')?>" class="nav-link <?=service('uri')->getSegment(2) == 'bon_pinjam_sarana' ? (service('uri')->getSegment(3) == 'kembalikan' ? 'active' : '') : ''?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Kembalikan</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="<?=route_to('distribusi')?>" class="nav-link <?=service('uri')->getSegment(2) == 'distribusi' ? 'active' : ''?>">
                                <i class="fas fa-undo nav-icon"></i>
                                <p>Distribusi Sarana</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?=route_to('berita_acara')?>" class="nav-link <?=service('uri')->getSegment(2) == 'berita_acara' ? 'active' : ''?>">
                                <i class="fas fa-file-signature nav-icon"></i>
                                <p>Berita Acara</p>
                            </a>
                        </li>
                        <li class="nav-header text-warning">Perkembangan</li>
                        <li class="nav-item">
                            <a href="<?=route_to('stok')?>" class="nav-link <?=service('uri')->getSegment(2) == 'stok' ? 'active' : ''?>">
                                <i class="fas fa-boxes nav-icon"></i>
                                <p>Data Stok</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?=route_to('laporan')?>" class="nav-link <?=service('uri')->getSegment(2) == 'laporan' ? 'active' : ''?>">
                                <i class="fas fa-chart-line nav-icon"></i>
                                <p>Laporan</p>
                            </a>
                        </li>
                        <li class="nav-header text-danger">Tools</li>
                        <li class="nav-item">
                            <a href="<?=route_to('qr_scanner')?>" class="nav-link <?=service('uri')->getSegment(2) == 'qr_scanner' ? 'active' : ''?>">
                                <i class="fas fa-qrcode nav-icon"></i>
                                <p>QR Scanner</p>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0"><?=$page_header_title?></h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <?php foreach($pages_path as $key => $val): ?>
                                    <li class="breadcrumb-item <?=$val['active'] ? 'active' : ''?>">
                                        <?php if(!$val['active']): ?>
                                            <a href="<?=$val['url']?>"><?=ucwords($key)?></a>
                                        <?php else: ?>
                                            <?=ucwords($key)?>
                                        <?php endif; ?>
                                    </li>
                                <?php endforeach; ?>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->
            
            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-6">
                            <div class="card card-outline card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Filter</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <form class="form-horizontal">
                                        <div class="form-group row">
                                            <label for="searchQuery" class="col-sm-2 offset-sm-2 col-form-label">Keyword : </label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="searchQuery" placeholder="Masukkan Keyword Pencarian...">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-2 offset-sm-2"></div>
                                            <div class="col-8">
                                                <button type="submit" class="btn btn-primary btn-sm">Cari Data</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                    <!-- <div class="row">
                        <div class="col-12">
                            <div class="card card-outline card-primary">
                                <div class="card-header">
                                    <button type="button" class="btn btn-primary btn-xs mr-2" data-toggle="modal" data-target="#modal_add_user">
                                        <i class="fas fa-plus"></i>&nbsp;&nbsp;Tambah Data
                                    </button>
                                    <button type="button" class="btn btn-danger btn-xs" id="btn-delete-multiple">
                                        <i class="fas fa-trash"></i>&nbsp;&nbsp;Hapus banyak
                                    </button>
                                </div>
                                <div class="card-body">
                                    <table id="data_users" class="table table-bordered table-hover table-sm" width="100%">
                                        <thead>
                                            <tr>
                                                <th><div class="text-center"><input id="checkAll" type="checkbox" name="multi_delete"></div></th>
                                                <th>No.</th>
                                                <th>Nama Lengkap</th>
                                                <th>Username</th>
                                                <th>Email</th>
                                                <th>Level</th>
                                                <th>Terakhir Login</th>
                                                <th>Tanggal Dibuat</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div> -->
            </section>
            <!-- <section class="content">

            </section> -->
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        
        <!-- Main Footer -->
        <footer class="main-footer">
            <!-- To the right -->
            <div class="float-right d-none d-sm-inline">
                Iramadibatukkkkkkkkkkkkk
            </div>
            <!-- Default to the left -->
            <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">iramadibatuASDFDF.com</a>.</strong> All rights reserved.
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
            <div class="p-3">
                <h5>Title</h5>
                <p>Sidebar content</p>
            </div>
        </aside>
        <!-- /.control-sidebar -->
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
    <!-- SweetAlert2 -->
    <script src="<?=site_url('themes/AdminLTE/plugins/sweetalert2/sweetalert2.min.js')?>"></script>
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

    <!-- DataTables  & Plugins -->
<script src="<?=site_url('themes/AdminLTE/plugins/datatables/jquery.dataTables.min.js')?>"></script>
<script src="<?=site_url('themes/AdminLTE/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')?>"></script>
<script src="<?=site_url('themes/AdminLTE/plugins/datatables-responsive/js/dataTables.responsive.min.js')?>"></script>
<script src="<?=site_url('themes/AdminLTE/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')?>"></script>
<script src="<?=site_url('themes/AdminLTE/plugins/datatables-buttons/js/dataTables.buttons.min.js')?>"></script>
<script src="<?=site_url('themes/AdminLTE/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')?>"></script>
<script src="<?=site_url('themes/AdminLTE/plugins/datatables-buttons/js/buttons.html5.min.js')?>"></script>
<script src="<?=site_url('themes/AdminLTE/plugins/datatables-buttons/js/buttons.print.min.js')?>"></script>
<script src="<?=site_url('themes/AdminLTE/plugins/datatables-buttons/js/buttons.colVis.min.js')?>"></script>

<!-- Select2 -->
<script src="<?=site_url('themes/AdminLTE/plugins/select2/js/select2.full.min.js')?>"></script>

<!-- jquery-validation -->
<script src="<?=site_url('themes/AdminLTE/plugins/jquery-validation/jquery.validate.min.js')?>"></script>
<script src="<?=site_url('themes/AdminLTE/plugins/jquery-validation/additional-methods.min.js')?>"></script>

<script>
$(function() {
    $('#checkAll').click(function(e) {
        if ($(this).is(":checked")) {
            $('.multi_delete').prop('checked', true);
        } else {
            $('.multi_delete').prop('checked', false);
        }
    });
    
    // handles datatable
    const table = $('#data_users').DataTable({
        // "dom": '<"top"i>rt<"bottom"><"clear">',
        "searching": false,
        "responsive": true,
        "drawCallback": function(settings) {
            if ($('#checkAll').is(":checked")) {
                $('.multi_delete').prop('checked', true);
            } else {
                $('.multi_delete').prop('checked', false);
            }
        },
        "pageLength": 25,
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": function(data, callback, settings) {
            const dataUrl = '<?=site_url('api/v1/dashboard/users/datatables')?>';

            $.ajax({
                type: 'POST',
                url: dataUrl,
                dataType: 'json',
                data: data,
                headers: {
                    'Authorization': 'Bearer ' + accessToken
                },
                success: function(res) {
                    callback(res);
                },
                error: function(err) {
                    console.log(err);
                }
            });
        },
        "columns": [
            {
                "targets": 0,
                "orderable": false,
                "searchable": false
            },
            {
                "targets": 1,
                "orderable": false,
                "searchable": false
            },
            {
                "targets": 2,
                "orderable": true,
                "searchable": true
            },
            {
                "targets": 3,
                "orderable": false,
                "searchable": false
            },
            {
                "targets": 4,
                "orderable": false,
                "searchable": false
            },
            {
                "targets": 5,
                "orderable": true,
                "searchable": true,
            },
            {
                "targets": 6,
                "orderable": false,
            },
            {
                "targets": 7,
                "orderable": false,
            },
            {
                "targets": 8,
                "orderable": false,
            }
        ],
    });

    /*************************************************
    *             START OF HANDLE ADD
    *************************************************/
    $('#form_add_user').validate({
        submitHandler: function(form, event) {
            event.preventDefault();

            const newData = {
                "fullname": $(form).find('input#fullname').val(),
                "username": $(form).find('input#username').val(),
                "email": $(form).find('input#email').val(),
                "password": $(form).find('input#password').val(),
                "level": $(form).find('select#level option:selected').val()
            };

            const createUrl = '<?=site_url('api/v1/dashboard/users')?>';
            $.ajax({
                type: 'POST',
                url: createUrl,
                dataType: 'json',
                data: newData,
                headers: {
                    'Authorization': 'Bearer ' + accessToken
                },
                success: function(res) {
                    console.log(res);

                    Swal.fire({
                        icon: 'success',
                        title: 'Data telah ditambahkan!',
                        showConfirmButton: true,
                        timer: 2000
                    });

                    setTimeout(() => {
                        $('#modal_add_user').modal('toggle');

                        $(form).find('input#fullname').val(''),
                        $(form).find('input#username').val(''),
                        $(form).find('input#email').val(''),
                        $(form).find('input#password').val(''),
                        $(form).find('input#repassword').val('')

                        table.ajax.reload();
                    }, 2000);
                },
                error: function(err) {
                    console.log(err.responseJSON);

                    Swal.fire({
                        icon: 'error',
                        title: 'Data gagal ditambahkan!',
                        text: err.responseJSON.message,
                        showConfirmButton: true,
                        timer: 2000
                    });
                }
            });
        },
        rules: { 
            fullname: {
                required: true
            },
            username: {
                required: true
            },
            email: {
                required: true
            },
            password: {
                required: true
            },
            repassword: {
                required: true,
                equalTo: '#password'
            },
            level: {
                required: true
            },
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        }
    });
    /*************************************************
    *             END OF HANDLE ADD
    *************************************************/




    /*************************************************
    *             START OF HANDLE SHOW
    *************************************************/
    $('#modal-show-jenis-sarana').on('hidden.bs.modal', function (e) {
        $('#data-detail').html('');
    })
    $('#data-jenis-sarana tbody').on('click', 'tr td button.btn-primary', function(e) {
        e.preventDefault();

        const rowData = table.row($(this).parent().parent()).data();
        const itemId = parseInt($(rowData[1].substring(0, rowData[1].indexOf('>')+1)).val());
        
        $.ajax({
            type: 'GET',
            url: '<?=site_url('api/v1/dashboard/master/jenis_sarana/')?>'+itemId,
            dataType: 'json',
            headers: {
                'Authorization': 'Bearer ' + accessToken
            },
            success: function(res) {
                console.log(res);

                if (res.data) {
                    for (const [key, value] of Object.entries(res.data)) {
                        $('#data-detail').append(
                            `
                            <dt class="col-sm-4">${key}</dt>
                            <dd id="show-name" class="col-sm-8">${value == null ? '-' : value}</dd>
                            `
                        );
                    }
                }

                $('#modal-show-jenis-sarana').modal('toggle');
            },
            error: function(err) {
                console.log(err);

                Swal.fire({
                    icon: 'error',
                    title: 'Data gagal ditampilkan!',
                    text: err.responseJSON.message,
                    showConfirmButton: true,
                    timer: 2000
                });
            }
        });
    });
    /*************************************************
    *             END OF HANDLE SHOW
    *************************************************/






    /*************************************************
    *             START OF HANDLE EDIT
    *************************************************/

    /** edit password */
    $('#data_users tbody').on('click', 'tr td button.btn-warning', function(e) {
        e.preventDefault();

        const rowData = table.row($(this).parent().parent()).data();
        const itemId = parseInt($(rowData[1].substring(0, rowData[1].indexOf('>')+1)).val());

        // $.ajax({
        //     type: 'GET',
        //     url: '<?=site_url('api/v1/dashboard/users/')?>'+itemId+'/change_password',
        //     dataType: 'json',
        //     headers: {
        //         'Authorization': 'Bearer ' + accessToken
        //     },
        //     success: function(res) {
        //         console.log(res);

        //         $('#modal_edit_password_user').modal('toggle');
        //     },
        //     error: function(err) {
        //         console.log(err);

        //         Swal.fire({
        //             icon: 'error',
        //             title: 'Gagal ditampilkan!',
        //             text: err.responseJSON.message,
        //             showConfirmButton: true,
        //             timer: 2000
        //         });
        //     }
        // });
    });

    /** send edit data to modal edit after this button clicked*/
    $('#data_users tbody').on('click', 'tr td button.btn-info', function(e) {
        e.preventDefault();

        const itemId = $(this).data().itemId;
        const rowData = table.row($(this).parent().parent()).data();
        // console.log(rowData);
        $('input#edit_id').val(parseInt($(rowData[1].substring(0, rowData[1].indexOf('>')+1)).val()));
        $('input#edit_fullname').val(rowData[2]);
        $('input#edit_username').val(rowData[3]);
        $('input#edit_email').val(rowData[4]);
        $('select#edit_level').val(rowData[5].substring(rowData[5].indexOf('>')+1));

        $('#modal_edit_user').modal('toggle');
    });

    $('#form-edit-merk-sarana').validate({
        submitHandler: function(form, event) {
            event.preventDefault();
            const itemId = $(form).find('input#edit_id').val();
            const updateData = {
                "fullname": $(form).find('input#edit_fullname').val(),
                "username": $(form).find('input#edit_username').val(),
                "email": $(form).find('input#edit_email').val(),
                "level": $(form).find('select#edit_level option:selected').val()
            };
            
            const updateUrl = '<?=site_url('api/v1/dashboard/users/')?>' + itemId + '/update';

            $.ajax({
                type: 'PUT',
                url: updateUrl,
                dataType: 'json',
                data: JSON.stringify(updateData),
                contentType: 'application/json',
                headers: {
                    'Authorization': 'Bearer ' + accessToken,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                success: function(res) {
                    console.log(res);

                    Swal.fire({
                        icon: 'success',
                        title: 'Data telah diubah!',
                        showConfirmButton: true,
                        timer: 2000
                    });

                    setTimeout(() => {
                        $('#modal_edit_user').modal('toggle');
                        table.ajax.reload();
                    }, 2000);
                },
                error: function(err) {
                    console.log(err.responseJSON);

                    Swal.fire({
                        icon: 'error',
                        title: 'Data gagal diubah!',
                        text: err.responseJSON.message,
                        showConfirmButton: true,
                        timer: 2000
                    });
                }
            })
        },
        rules: {
            fullname: {
                required: true
            },
            username: {
                required: true
            },
            email: {
                required: true
            },
            level: {
                required: true
            }
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        }
    });
    /** handle form edit submission */

    /*************************************************
    *             END OF HANDLE EDIT
    *************************************************/

    /** start of delete */

    /** end of delete */
});
</script>
</body>
</html>
