<?=$this->extend('layouts/dashboard/layout')?>

<?=$this->section('custom-css')?>
<!-- DataTables -->
<link rel="stylesheet" href="<?=site_url('themes/AdminLTE/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')?>">
<link rel="stylesheet" href="<?=site_url('themes/AdminLTE/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')?>">
<link rel="stylesheet" href="<?=site_url('themes/AdminLTE/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')?>">
<?=$this->endSection()?>

<?=$this->section('content')?>
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <!-- <div class="card-header">
                        <button type="button" class="btn btn-primary btn-sm mr-2" data-toggle="modal" data-target="#modal-add-user">
                            <i class="fas fa-plus"></i>&nbsp;&nbsp;Tambah Data
                        </button>
                        <button type="button" class="btn btn-danger btn-sm" id="btn-delete-multiple">
                            <i class="fas fa-trash"></i>&nbsp;&nbsp;Hapus banyak
                        </button>
                    </div> -->
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="data-stok" class="table table-bordered table-hover table-sm" width="100%">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Tipe Sarana</th>
                                    <th>Jumlah Stok</th>
                                    <th>Sedang dipinjam</th>
                                    <th>Sudah didistrubsi</th>
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

<?php echo view($moduleViewPath.'custom_js') ?>