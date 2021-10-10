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
                <h1 class="m-0">Tambah Berita Acara</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?=route_to('documents')?>">Berita Acara</a></li>
                    <li class="breadcrumb-item active">Tambah Berita Acara</li>
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
                        <form id="form-add-document">
                            <div class="form-group">
                                <label for="doc_name">Judul Berita Acara</label>
                                <input type="text" name="doc_name" class="form-control" id="doc_name" placeholder="Masukkan Judul...">
                            </div>
                            <div class="form-group">
                                <label for="doc_number">No. Berita Acara</label>
                                <input type="text" name="doc_number" class="form-control" id="doc_number" placeholder="Masukkan Nomor...">
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
                                <label for="doc_media">Unggah File ( .png | .jpeg | .pdf ) , Max : <strong>1.5MB</strong></label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" name="doc_media" class="custom-file-input" id="doc_media">
                                        <label class="custom-file-label" for="doc_media">Pilih file</label>
                                    </div>
                                    <div class="input-group-append">
                                        <span class="input-group-text">Upload</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name">Tipe Berita Acara</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="doc_type" value="borrowing" checked>
                                    <label class="form-check-label">Peminjaman</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="doc_type" value="returning">
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
<!-- jquery-validation -->
<script src="<?=site_url('themes/AdminLTE/plugins/jquery-validation/jquery.validate.min.js')?>"></script>
<script src="<?=site_url('themes/AdminLTE/plugins/jquery-validation/additional-methods.min.js')?>"></script>
<!-- bs-custom-file-input -->
<script src="<?=site_url('themes/AdminLTE/plugins/bs-custom-file-input/bs-custom-file-input.min.js')?>"></script>

<script>
$(function() {
    bsCustomFileInput.init()

    $('#doc_date').datetimepicker({
        format: 'YYYY-MM-DD'
    });

    const dateObj = new Date();
    const currMonth = dateObj.getMonth()+1 < 10 ? '0'+(dateObj.getMonth()+1) : dateObj.getMonth()+1;
    const currDate = dateObj.getDate() < 10 ? '0'+dateObj.getDate() : dateObj.getDate();
    const currYear = dateObj.getFullYear();
    const nowTime = currYear + '-' + currMonth + '-' + currDate;
    $('#doc_date').find('input[name="doc_date"]').val(nowTime);

    $('#form-add-document').validate({
        submitHandler: function(form, event) {
            event.preventDefault();

            const newDoc = new FormData();
            newDoc.append('doc_name', $(form).find('#doc_name').val());
            newDoc.append('doc_number', $(form).find('#doc_number').val());
            newDoc.append('doc_date', $(form).find('#doc_date input[name="doc_date"]').val());
            newDoc.append('doc_media', $(form).find('#doc_media').get(0).files[0]);
            newDoc.append('doc_type', $(form).find('input[name="doc_type"]:checked').val());

            // newDoc.forEach(function(key, val) {
            //     console.log(key + ' => ' + val);
            // });

            if ((newDoc.get('doc_media').size / 1000) > 1600) {
                Swal.fire({
                    icon: 'error',
                    title: 'Terjadi error!',
                    text: 'Ukuran file terlalu besar!',
                    showConfirmButton: true,
                    timer: 2000
                });
                return;
            }

            $.ajax({
                type: 'POST',
                url: '<?=site_url('api/dashboard/documents')?>',
                data: newDoc,
                dataType: 'json',
                mimeType: 'multipart/form-data',
                contentType: false,
                cache: false,
                processData: false,
                headers: {
                    'Authorization': 'Bearer ' + accessToken
                },
                success: function(res) {
                    console.log(res);
                    Swal.fire({
                        icon: 'success',
                        title: 'Data telah ditambahkan!',
                        showConfirmButton: true,
                        timer: 2000
                    });

                    setTimeout(() => {
                        window.location.href = '<?=route_to('documents')?>';
                    }, 2000);
                },
                error: function(err) {
                    console.log(err);
                    Swal.fire({
                        icon: 'error',
                        title: 'Data gagal ditambahkan!',
                        text: err.responseJSON.message,
                        showConfirmButton: true,
                        timer: 2000
                    });
                }
            });
        },
        rules: {
            doc_name: {
                required: true
            },
            doc_number: {
                required: true
            },
            doc_date: {
                required: true
            },
            doc_media: {
                required: true,
                accept: 'image/png,image/jpeg,application/pdf'
            },
            doc_type: {
                required: true
            }
        },
        messages: {
            doc_name: {
                required: 'Nama dokumen tidak boleh kosong!'
            },
            doc_number: {
                required: 'Nomor dokumen tidak boleh kosong!'
            },
            doc_date: {
                required: 'Tanggal dokumen tidak boleh kosong!'
            },
            doc_media: {
                required: 'Media dokumen tidak boleh kosong!'
            },
            doc_type: {
                required: 'Pilih salah satu!'
            }
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        }
    });
});
</script>
<?=$this->endSection()?>