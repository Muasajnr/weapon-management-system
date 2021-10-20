<?=$this->extend('layouts/dashboard/layout')?>

<?=$this->section('content')?>
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
                        <form id="filter_data" class="form-horizontal">
                            <div class="form-group row">
                                <label for="searchQuery" class="col-sm-2 offset-sm-2 col-form-label">Keyword : </label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="searchQuery" placeholder="Masukkan Keyword Pencarian...">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-2 offset-sm-2"></div>
                                <div class="col-8">
                                    <button type="submit" class="btn btn-primary btn-xs">Cari Data</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <button type="button" class="btn btn-primary btn-xs mr-2" data-toggle="modal" data-target="#modal-add-senjata-api">
                            <i class="fas fa-plus"></i>&nbsp;&nbsp;Tambah Data
                        </button>
                        <!-- <button type="button" class="btn btn-info btn-xs mr-2" data-toggle="modal" data-target="#modal-add-senjata-api-multi">
                            <i class="fas fa-plus"></i>&nbsp;&nbsp;Tambah Banyak
                        </button> -->
                        <button type="button" class="btn btn-danger btn-xs" id="btn-delete-multiple">
                            <i class="fas fa-trash"></i>&nbsp;&nbsp;Hapus Banyak
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
                                    <th>Jumlah</th>
                                    <th>Satuan</th>
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
<!-- <?php //echo view($moduleViewPath.'senjata_api/add_multi') ?> -->
<?php echo view($moduleViewPath.'senjata_api/edit') ?>
<?php echo view($moduleViewPath.'senjata_api/qrcode') ?>

<?=$this->endSection()?>

<?php echo view($moduleViewPath.'senjata_api/custom_js') ?>