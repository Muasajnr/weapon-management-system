<?=$this->extend('layouts/dashboard/layout')?>

<?=$this->section('custom-css')?>
<!-- DataTables -->
<link rel="stylesheet" href="<?=site_url('themes/AdminLTE/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')?>">
<link rel="stylesheet" href="<?=site_url('themes/AdminLTE/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')?>">
<link rel="stylesheet" href="<?=site_url('themes/AdminLTE/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')?>">
<?=$this->endSection()?>

<?=$this->section('content')?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Berita Acara</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active">Berita Acara</li>
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
        <div class="col-12">
        <div class="card">
            <div class="card-header">
                <!-- <h3 class="card-title">DataTable with minimal features & hover style</h3> -->
                <a href="<?=route_to('documents_add')?>" class="btn btn-primary btn-sm mr-2">
                    <i class="fas fa-plus"></i>&nbsp;&nbsp;Tambah Data
                </a>
                <button type="button" class="btn btn-danger btn-sm" id="btn-delete-multiple">
                    <i class="fas fa-trash"></i>&nbsp;&nbsp;Hapus banyak
                </button>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="data-documents" class="table table-bordered table-hover table-sm" width="100%">
                    <thead>
                        <tr>
                            <th><div class="text-center"><input id="checkAll" type="checkbox" name="multi_delete"></div></th>
                            <th>No.</th>
                            <th>No. Berita Acara</th>
                            <th>Judul</th>
                            <th>Tanggal Berita Acara</th>
                            <th>Tipe</th>
                            <th>Tanggal Dibuat</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</section>

<!-- /.content -->
<?=$this->endSection()?>

<?php echo view('dashboard/documents/custom_js'); ?>