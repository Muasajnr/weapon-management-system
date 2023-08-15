<?=$this->extend('layouts/dashboard/layout')?>

<?=$this->section('custom-css')?>
<!-- Select2 -->
<link rel="stylesheet" href="<?=site_url('themes/AdminLTE/plugins/select2/css/select2.min.css')?>">
<link rel="stylesheet" href="<?=site_url('themes/AdminLTE/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')?>">
<?=$this->endSection()?>

<?=$this->section('content')?>

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Pinjam Senjata</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?=route_to('firearms')?>">Data Senjata Api</a></li>
                    <li class="breadcrumb-item active">Pinjam Senjata</li>
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
                        <form id="form-add-borrowing">
                            <div class="form-group">
                                <label>Senjata Api</label>
                                <select id="select2-data-firearms" name="firearm_id" class="form-control select2" style="width: 100%;"></select>
                            </div>
                            <div class="form-group">
                                <label>Berita Acara</label>
                                <select id="select2-data-documents" name="document_id" class="form-control select2" style="width: 100%;"></select>
                            </div>
                            <div class="form-group">
                                <label for="borrowing_number">Nomor Peminjaman</label>
                                <input type="text" name="borrowing_number" class="form-control" id="borrowing_number" placeholder="Masukkan Nomor Peminjaman...">
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
<!-- Select2 -->
<script src="<?=site_url('themes/AdminLTE/plugins/select2/js/select2.full.min.js')?>"></script>
<!-- jquery-validation -->
<script src="<?=site_url('themes/AdminLTE/plugins/jquery-validation/jquery.validate.min.js')?>"></script>
<script src="<?=site_url('themes/AdminLTE/plugins/jquery-validation/additional-methods.min.js')?>"></script>

<script>
$(function() {

    $('#select2-data-firearms').select2({
        placeholder: 'Pilih Senjata Api',
        theme: 'bootstrap4',
        ajax: {
            delay: 250,
            url: '<?=site_url('api/dashboard/firearms')?>',
            headers: {
                'Authorization': 'Bearer ' + accessToken
            },
            dataType: 'json',
            cache: true,
            processResults: function(data, params) {
                const results = [];
                data.data.forEach(function(item) {
                    results.push({
                        text: item.firearm_number,
                        id: item.firearm_id,
                        firearm_type: item.firearm_type,
                        firearm_brand: item.firearm_brand,
                    });
                });
                return {
                    results: results
                }
            }
        },
        templateResult: function(item) {
            if (!item.id) {
                return item.text;
            }

            var $container = $('<span><strong style="color: #000088;">'+item.firearm_type+'</strong> - <strong>'+item.firearm_brand+'</strong> - '+item.text+'</span>');

            return $container;
        },
        templateSelection: function(item) {
            return item.text;
        }
    });

    $('#select2-data-documents').select2({
        placeholder: 'Pilih Dokumen',
        theme: 'bootstrap4',
        ajax: {
            url: '<?=site_url('api/dashboard/documents')?>',
            headers: {
                'Authorization': 'Bearer ' + accessToken
            },
            dataType: 'json',
            cache: true,
            processResults: function(data, params) {
                const results = [];
                data.data.forEach(function(item) {
                    results.push({
                        text: item.doc_name,
                        id: item.id
                    });
                });

                return {
                    results: results
                }
            }
        }
    });

    $('#form-add-borrowing').validate({
        submitHandler: function(form, event) {
            event.preventDefault();
            
            const newBorrowing = {
                "firearm_id": $(form).find('#select2-data-firearms option:selected').val(),
                "document_id": $(form).find('#select2-data-documents option:selected').val(),
                "borrowing_number": $(form).find('input#borrowing_number').val(),
                "desc": $(form).find('textarea#desc').val(),
            };
            // console.log(newBorrowing);
            // return;
            const createUrl = '<?=site_url('api/dashboard/borrowings')?>';

            $.ajax({
                type: 'POST',
                url: createUrl,
                dataType: 'json',
                data: JSON.stringify(newBorrowing),
                contentType: 'application/json',
                headers: {
                    'Authorization': 'Bearer ' + accessToken,
                    'X-Requested-With': 'XMLHttpRequest'
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
                        window.location.href = '<?=route_to('borrowings_ongoing')?>';
                    }, 2000);
                },
                error: function(err) {
                    console.log(err.responseJSON);

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
            firearm_id: {
                required: true
            },
            document_id: {
                required: true
            },
            borrowing_number: {
                required: true
            },
            desc: {
                required: true
            },
        },
        messages: {
            firearm_id: {
                required: 'Pilih salah satu!'
            },
            document_id: {
                required: 'Pilih salah satu!'
            },
            borrowing_number: {
                required: 'Pilih salah satu!'
            },
            desc: {
                required: 'Deskripsi tidak boleh kosong!'
            },
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