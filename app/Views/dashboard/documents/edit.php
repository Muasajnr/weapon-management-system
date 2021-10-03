<?=$this->extend('layouts/dashboard/layout')?>

<?=$this->section('custom-css')?>
<!-- Tempusdominus Bootstrap 4 -->
<link rel="stylesheet" href="<?=site_url('themes/AdminLTE/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')?>">
<?=$this->endSection()?>

<?=$this->section('content')?>

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Edit Berita Acara</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?=route_to('documents')?>">Berita Acara</a></li>
                    <li class="breadcrumb-item active">Edit Berita Acara</li>
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
                        <form id="form-edit-document">
                            <div class="form-group">
                                <label for="doc_name">Judul Berita Acara</label>
                                <input type="text" name="doc_name" class="form-control" id="doc_name" placeholder="Masukkan Judul...">
                            </div>
                            <div class="form-group">
                                <label for="doc_num">No. Berita Acara</label>
                                <input type="text" name="doc_num" class="form-control" id="doc_num" placeholder="Masukkan Nomor...">
                            </div>
                            <!-- Date -->
                            <div class="form-group">
                            <label for="doc_date">Tanggal:</label>
                                <div class="input-group date" id="doc_date" data-target-input="nearest">
                                    <input type="text" name="doc_date" class="form-control datetimepicker-input" data-target="#doc_date"/>
                                    <div class="input-group-append" data-target="#doc_date" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="doc_media">Unggah File ( .png | .jpeg | .pdf )</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" name="doc_media" class="custom-file-input" id="doc_media">
                                        <label class="custom-file-label" for="doc_media">Choose file</label>
                                    </div>
                                    <div class="input-group-append">
                                        <span class="input-group-text">Upload</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name">Tipe Berita Acara</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="doc_type" checked>
                                    <label class="form-check-label">Peminjaman</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="doc_type">
                                    <label class="form-check-label">Pengembalian</label>
                                </div>
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
<!-- moment js -->
<script src="<?=site_url('themes/AdminLTE/plugins/moment/moment.min.js')?>"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="<?=site_url('themes/AdminLTE/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')?>"></script>

<script>
$(function() {
    $('#doc_date').datetimepicker({
        format: 'L'
    });
});
</script>
<?=$this->endSection()?>