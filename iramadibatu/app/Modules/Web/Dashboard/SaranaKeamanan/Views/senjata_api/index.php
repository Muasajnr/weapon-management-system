<?=$this->extend('layouts/dashboard/layout')?>

<?=$this->section('custom-css')?>
<!-- Select2 -->
<link rel="stylesheet" href="<?=site_url('themes/AdminLTE/plugins/select2/css/select2.min.css')?>">
<link rel="stylesheet" href="<?=site_url('themes/AdminLTE/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')?>">
<!-- DataTables -->
<link rel="stylesheet" href="<?=site_url('themes/AdminLTE/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')?>">
<link rel="stylesheet" href="<?=site_url('themes/AdminLTE/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')?>">
<link rel="stylesheet" href="<?=site_url('themes/AdminLTE/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')?>">
<!-- bs-custom-file-input -->
<script src="<?=site_url('themes/AdminLTE/plugins/bs-custom-file-input/bs-custom-file-input.min.js')?>"></script>
<?=$this->endSection()?>

<?=$this->section('content')?>
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <button type="button" class="btn btn-primary btn-sm mr-2" data-toggle="modal" data-target="#modal-add-senjata-api">
                            <i class="fas fa-plus"></i>&nbsp;&nbsp;Tambah Data
                        </button>
                        <button type="button" class="btn btn-danger btn-sm" id="btn-delete-multiple">
                            <i class="fas fa-trash"></i>&nbsp;&nbsp;Hapus banyak
                        </button>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="data_senjata_api" class="table table-bordered table-hover table-sm" width="100%">
                            <thead>
                                <tr>
                                    <th><div class="text-center"><input id="checkAll" type="checkbox" name="multi_delete"></div></th>
                                    <th>No.</th>
                                    <th>No. Senjata</th>
                                    <th>No. BPSA</th>
                                    <th>Nama</th>
                                    <th>Merk</th>
                                    <th>Kondisi</th>
                                    <th>Keterangan</th>
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

<?php echo view($moduleViewPath.'senjata_api/add') ?>

<?=$this->endSection()?>

<?php echo view($moduleViewPath.'senjata_api/custom_js') ?>