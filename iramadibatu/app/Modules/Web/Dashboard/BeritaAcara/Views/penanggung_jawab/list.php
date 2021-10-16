<?=$this->extend('layouts/dashboard/layout')?>

<?=$this->section('content')?>
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <button type="button" class="btn btn-primary btn-sm mr-2" data-toggle="modal" data-target="#modal-add-penanggung-jawab">
                            <i class="fas fa-plus"></i>&nbsp;&nbsp;Tambah Data
                        </button>
                        <button type="button" class="btn btn-danger btn-sm" id="btn-delete-multiple">
                            <i class="fas fa-trash"></i>&nbsp;&nbsp;Hapus banyak
                        </button>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="data-penanggung-jawab" class="table table-bordered table-hover table-sm" width="100%">
                            <thead>
                                <tr>
                                    <th><div class="text-center"><input id="checkAll" type="checkbox" name="multi_delete"></div></th>
                                    <th class="text-center">No.</th>
                                    <th>Nama</th>
                                    <th>Nip</th>
                                    <th>Pangkat/Golongan</th>
                                    <th>Jabatan</th>
                                    <th>Tanggal Dibuat</th>
                                    <th class="text-center">Actions</th>
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

<?php echo view($moduleViewPath.'penanggung_jawab/add') ?>
<?php echo view($moduleViewPath.'penanggung_jawab/edit') ?>
<?php echo view($moduleViewPath.'penanggung_jawab/show') ?>

<?=$this->endSection()?>

<?php echo view($moduleViewPath.'penanggung_jawab/custom_js') ?>