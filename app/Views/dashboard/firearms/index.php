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
                <h1 class="m-0">Data Senjata Api</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active">Data Senjata Api</li>
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
                <button type="button" class="btn btn-primary btn-sm mr-2" data-toggle="modal" data-target="#modal-add-firearms-types">
                    <i class="fas fa-plus"></i>&nbsp;&nbsp;Tambah Data
                </button>
                <button type="button" class="btn btn-danger btn-sm" id="btn-delete-multiple">
                    <i class="fas fa-trash"></i>&nbsp;&nbsp;Hapus banyak
                </button>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
            <table id="data-firearms" class="table table-bordered table-hover table-sm">
                <thead>
                    <tr>
                        <th><div class="text-center"><input id="checkAll" type="checkbox" name="multi_delete"></div></th>
                        <th>No.</th>
                        <th>Jenis Inventaris</th>
                        <th>Jenis Senjata Api</th>
                        <th>Merk Senjata Api</th>
                        <th>No. Senjata Api</th>
                        <th>No. BPSA</th>
                        <th>Kondisi</th>
                        <th>Status</th>
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

<?php echo view('dashboard/firearms/custom_js') ?>