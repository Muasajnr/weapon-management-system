<?=$this->extend('layouts/dashboard/layout')?>

<?=$this->section('content')?>
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col col-sm-12 col-md-12 col-lg-6">
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
                                    <button type="submit" class="btn btn-primary btn-sm">Cari Data</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <?php if ($userLevel === 'admin'): ?>
                            <button type="button" class="btn btn-primary btn-xs mr-2" data-toggle="modal" data-target="#modal-add-penanggung-jawab">
                                <i class="fas fa-plus"></i>&nbsp;&nbsp;Tambah Data
                            </button>
                            <button type="button" class="btn btn-danger btn-xs" id="btn-delete-multiple">
                                <i class="fas fa-trash"></i>&nbsp;&nbsp;Hapus banyak
                            </button>
                        <?php endif; ?>
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