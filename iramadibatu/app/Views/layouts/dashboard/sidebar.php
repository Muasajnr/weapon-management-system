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
                <!-- <li class="nav-item">
                    <a href="<?=route_to('berita_acara')?>" class="nav-link <?=service('uri')->getSegment(2) == 'berita_acara' ? 'active' : ''?>">
                        <i class="fas fa-file-signature nav-icon"></i>
                        <p>Berita Acara</p>
                    </a>
                </li> -->
                <li class="nav-item <?=service('uri')->getSegment(2) == 'berita_acara' ? 'menu-open' : ''?>">
                    <a href="#" class="nav-link <?=service('uri')->getSegment(2) == 'berita_acara' ? 'active' : ''?>">
                        <i class="nav-icon fas fa-file-signature"></i>
                        <p>
                            Berita Acara
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?=route_to('berita_acara')?>" class="nav-link <?=service('uri')->getSegment(2) == 'berita_acara' ? (service('uri')->getSegment(3) == 'list' ? 'active' : '') : ''?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>List</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?=route_to('penanggung_jawab')?>" class="nav-link <?=service('uri')->getSegment(2) == 'berita_acara' ? (service('uri')->getSegment(3) == 'penanggung_jawab' ? 'active' : '') : ''?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Penanggung Jawab</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-header text-warning">Perkembangan</li>
                <li class="nav-item">
                    <a href="<?=route_to('stok')?>" class="nav-link <?=service('uri')->getSegment(2) == 'stok' ? 'active' : ''?>">
                        <i class="fas fa-boxes nav-icon"></i>
                        <p>Data Stok</p>
                    </a>
                </li>
                <!-- <li class="nav-item">
                    <a href="<?=route_to('laporan')?>" class="nav-link <?=service('uri')->getSegment(2) == 'laporan' ? 'active' : ''?>">
                        <i class="fas fa-chart-line nav-icon"></i>
                        <p>Laporan</p>
                    </a>
                </li> -->
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