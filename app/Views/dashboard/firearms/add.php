<?=$this->extend('layouts/dashboard/layout')?>

<?=$this->section('custom-css')?>
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
                    <li class="breadcrumb-item"><a href="<?=route_to('firearms')?>">Data Senjata Api</a></li>
                    <li class="breadcrumb-item active">Tambah Senjata Api</li>
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
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form id="form-add-firearm">
                            <div class="form-group">
                                <label>Jenis Inventaris</label>
                                <select class="form-control select2" style="width: 100%;">
                                    <option selected="selected">Alabama</option>
                                    <option>Alaska</option>
                                    <option>California</option>
                                    <option>Delaware</option>
                                    <option>Tennessee</option>
                                    <option>Texas</option>
                                    <option>Washington</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Jenis Senjata Api</label>
                                <select class="form-control select2" style="width: 100%;">
                                    <option selected="selected">Alabama</option>
                                    <option>Alaska</option>
                                    <option>California</option>
                                    <option>Delaware</option>
                                    <option>Tennessee</option>
                                    <option>Texas</option>
                                    <option>Washington</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Merk Senjata Api</label>
                                <select class="form-control select2" style="width: 100%;">
                                    <option selected="selected">Alabama</option>
                                    <option>Alaska</option>
                                    <option>California</option>
                                    <option>Delaware</option>
                                    <option>Tennessee</option>
                                    <option>Texas</option>
                                    <option>Washington</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="name">Nomor Senjata Api</label>
                                <input type="text" name="name" class="form-control" id="name" placeholder="Masukkan Nama...">
                            </div>
                            <div class="form-group">
                                <label for="name">Nomor BPSA</label>
                                <input type="text" name="name" class="form-control" id="name" placeholder="Masukkan Nama...">
                            </div>
                            <div class="form-group">
                                <label for="name">Kondisi</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="radio1">
                                    <label class="form-check-label">Normal</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="radio1" checked>
                                    <label class="form-check-label">Rusak</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="desc">Deskripsi</label>
                                <textarea id="desc" name="desc" class="form-control" rows="3" placeholder="Masukkan Deskripsi..."></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>
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

<?=$this->section('custom-js')?>
<?=$this->endSection()?>