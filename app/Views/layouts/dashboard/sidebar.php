<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
    <img src="<?=site_url('themes/AdminLTE/dist/img/AdminLTELogo.png')?>" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">Inventaris Senjata Api</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <!-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
        <img src="<?=site_url('themes/AdminLTE/dist/img/user2-160x160.jpg')?>" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
        <a href="#" class="d-block">Alexander Pierce</a>
        </div>
    </div> -->

    <!-- SidebarSearch Form -->
    <!-- <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
        <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
            <button class="btn btn-sidebar">
            <i class="fas fa-search fa-fw"></i>
            </button>
        </div>
        </div>
    </div> -->

    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
            with font-awesome or any other icon font library -->
            <li class="nav-item">
                <a href="<?=route_to('home')?>" class="nav-link <?=service('uri')->getSegment(2) == 'home' ? 'active' : ''?>">
                <i class="fas fa-home nav-icon"></i>
                    <p>Dashboard</p>
                </a>
            </li>
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
                        <a href="<?=route_to('inventory_types')?>" class="nav-link <?=service('uri')->getSegment(2) == 'master' ? (service('uri')->getSegment(3) == 'jenis-inventaris' ? 'active' : '') : ''?>">
                            <i style="font-size: 14px;" class="far fa-circle nav-icon"></i>
                            <p style="font-size: 14px;">Data Jenis Inventaris</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?=route_to('firearms_types')?>" class="nav-link <?=service('uri')->getSegment(2) == 'master' ? (service('uri')->getSegment(3) == 'jenis-senjata-api' ? 'active' : '') : ''?>">
                            <i style="font-size: 14px;" class="far fa-circle nav-icon"></i>
                            <p style="font-size: 14px;">Data Jenis Senjata Api</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?=route_to('firearms_brands')?>" class="nav-link <?=service('uri')->getSegment(2) == 'master' ? (service('uri')->getSegment(3) == 'merk-senjata-api' ? 'active' : '') : ''?>">
                            <i style="font-size: 14px;" class="far fa-circle nav-icon"></i>
                            <p style="font-size: 14px;">Data Merk Senjata Api</p>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="<?=route_to('stocks')?>" class="nav-link <?=service('uri')->getSegment(2) == 'stok' ? 'active' : ''?>">
                    <i class="fas fa-boxes nav-icon"></i>
                    <p>Data Stok Senjata</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?=route_to('firearms')?>" class="nav-link <?=service('uri')->getSegment(2) == 'senjata-api' ? 'active' : ''?>">
                    <i class="fas fa-box nav-icon"></i>
                    <p>Data Senjata Api</p>
                </a>
            </li>
            <!-- <li class="nav-item">
                <a href="<?=route_to('borrowings')?>" class="nav-link <?=service('uri')->getSegment(2) == 'peminjaman' ? 'active' : ''?>">
                    <i class="fas fa-hand-holding nav-icon"></i>
                    <p>Peminjaman Senjata</p>
                </a>
            </li> -->
            <li class="nav-item <?=service('uri')->getSegment(2) == 'peminjaman' ? 'menu-open' : ''?>">
                <a href="#" class="nav-link <?=service('uri')->getSegment(2) == 'peminjaman' ? 'active' : ''?>">
                    <i class="nav-icon fas fa-desktop"></i>
                    <p>
                        Peminjaman Senjata
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="<?=route_to('borrowings_ongoing')?>" class="nav-link <?=service('uri')->getSegment(2) == 'peminjaman' ? (service('uri')->getSegment(3) == 'sedang-dipinjam' ? 'active' : '') : ''?>">
                            <i style="font-size: 14px;" class="far fa-circle nav-icon"></i>
                            <p style="font-size: 14px;">Sedang dipinjam</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?=route_to('borrowings_histori')?>" class="nav-link <?=service('uri')->getSegment(2) == 'peminjaman' ? (service('uri')->getSegment(3) == 'histori' ? 'active' : '') : ''?>">
                            <i style="font-size: 14px;" class="far fa-circle nav-icon"></i>
                            <p style="font-size: 14px;">Histori</p>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="<?=route_to('returnings')?>" class="nav-link <?=service('uri')->getSegment(2) == 'pengembalian' ? 'active' : ''?>">
                    <i class="fas fa-undo nav-icon"></i>
                    <p>Pengembalian Senjata</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?=route_to('documents')?>" class="nav-link <?=service('uri')->getSegment(2) == 'berita-acara' ? 'active' : ''?>">
                    <i class="fas fa-file-signature nav-icon"></i>
                    <p>Berita Acara</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?=route_to('reports')?>" class="nav-link <?=service('uri')->getSegment(2) == 'laporan' ? 'active' : ''?>">
                    <i class="fas fa-chart-line nav-icon"></i>
                    <p>Laporan</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?=route_to('users')?>" class="nav-link <?=service('uri')->getSegment(2) == 'users' ? 'active' : ''?>">
                    <i class="fas fa-users nav-icon"></i>
                    <p>Data User</p>
                </a>
            </li>
            <!-- <li class="nav-item">
                <a href="#" class="nav-link">
                <i class="fas fa-sign-out-alt nav-icon"></i>
                <p>Logout</p>
                </a>
            </li> -->
            <!-- <li class="nav-item menu-open">
                <a href="#" class="nav-link active">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                    Dashboard
                    <i class="right fas fa-angle-left"></i>
                </p>
                </a>
                <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="#" class="nav-link active">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Active Page</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Inactive Page</p>
                    </a>
                </li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                <i class="nav-icon fas fa-th"></i>
                <p>
                    Simple Link
                    <span class="right badge badge-danger">New</span>
                </p>
                </a>
            </li> -->
        </ul>
    </nav>
    <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>