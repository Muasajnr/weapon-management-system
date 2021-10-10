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
                <h1 class="m-0">Tambah Senjata Api</h1>
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
                                <select id="select2-data-inventory-types" name="inventory_type" class="form-control select2" style="width: 100%;"></select>
                            </div>
                            <div class="form-group">
                                <label>Jenis Senjata</label>
                                <select id="select2-data-firearms-types" name="firearm_type" class="form-control select2" style="width: 100%;"></select>
                            </div>
                            <div class="form-group">
                                <label>Merk Senjata</label>
                                <select id="select2-data-firearms-brands" name="firearm_brand" class="form-control select2" style="width: 100%;"></select>
                            </div>
                            <div class="form-group">
                                <label for="firearm_number">Nomor Senjata</label>
                                <input type="text" name="firearm_number" class="form-control" id="firearm_number" placeholder="Masukkan Nomor Senjata...">
                            </div>
                            <div class="form-group">
                                <label for="bpsa_number">Nomor BPSA</label>
                                <input type="text" name="bpsa_number" class="form-control" id="bpsa_number" placeholder="Masukkan Nomor BPSA...">
                            </div>
                            <div class="form-group">
                                <label for="condition">Kondisi</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="condition" value="normal" checked>
                                    <label class="form-check-label">Normal</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="condition" value="damaged">
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
<!-- Select2 -->
<script src="<?=site_url('themes/AdminLTE/plugins/select2/js/select2.full.min.js')?>"></script>
<!-- jquery-validation -->
<script src="<?=site_url('themes/AdminLTE/plugins/jquery-validation/jquery.validate.min.js')?>"></script>
<script src="<?=site_url('themes/AdminLTE/plugins/jquery-validation/additional-methods.min.js')?>"></script>

<script>
$(function() {

    $('#select2-data-inventory-types').select2({
        placeholder: 'Pilih Jenis Inventaris',
        theme: 'bootstrap4',
        ajax: {
            url: '<?=site_url('api/dashboard/inventory-types')?>',
            headers: {
                'Authorization': 'Bearer ' + accessToken
            },
            dataType: 'json',
            cache: true,
            processResults: function(data, params) {
                const results = [];
                data.data.forEach(function(item) {
                    results.push({
                        text: item.name,
                        id: item.id
                    });
                });
                return {
                    results: results
                }
            }
        }
    });

    $('#select2-data-firearms-types').select2({
        placeholder: 'Pilih Jenis Senjata Api',
        theme: 'bootstrap4',
        ajax: {
            url: '<?=site_url('api/dashboard/firearms-types')?>',
            headers: {
                'Authorization': 'Bearer ' + accessToken
            },
            dataType: 'json',
            cache: true,
            processResults: function(data, params) {
                const results = [];
                data.data.forEach(function(item) {
                    results.push({
                        text: item.name,
                        id: item.id
                    });
                });
                return {
                    results: results
                }
            }
        }
    });

    $('#select2-data-firearms-brands').select2({
        placeholder: 'Pilih Merk Senjata Api',
        theme: 'bootstrap4',
        ajax: {
            url: '<?=site_url('api/dashboard/firearms-brands')?>',
            headers: {
                'Authorization': 'Bearer ' + accessToken
            },
            dataType: 'json',
            cache: true,
            processResults: function(data, params) {
                const results = [];
                data.data.forEach(function(item) {
                    results.push({
                        text: item.name,
                        id: item.id
                    });
                });
                return {
                    results: results
                }
            }
        }
    });

    $('#form-add-firearm').validate({
        submitHandler: function(form, event) {
            event.preventDefault();
            
            const newFirearm = {
                "inventory_type_id": $(form).find('#select2-data-inventory-types option:selected').val(),
                "firearms_type_id": $(form).find('#select2-data-firearms-types option:selected').val(),
                "firearms_brand_id": $(form).find('#select2-data-firearms-brands option:selected').val(),
                "firearms_number": $(form).find('input#firearm_number').val(),
                "bpsa_number": $(form).find('input#bpsa_number').val(),
                "condition": $(form).find('input[name="condition"]:checked').val(),
                "description": $(form).find('textarea#desc').val()
            };

            const createNewFirearmUrl = '<?=site_url('api/dashboard/firearms')?>';

            $.ajax({
                type: 'POST',
                url: createNewFirearmUrl,
                dataType: 'json',
                data: JSON.stringify(newFirearm),
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
                        window.location.href = '<?=route_to('firearms')?>';
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
            inventory_type_id: {
                required: true
            },
            firearm_type: {
                required: true
            },
            firearm_brand: {
                required: true
            },
            firearm_number: {
                required: true
            },
            bpsa_number: {
                required: true
            },
            condition: {
                required: true
            },
            desc: {
                required: true
            },
        },
        messages: {
            inventory_type: {
                required: 'Pilih salah satu!'
            },
            firearm_type: {
                required: 'Pilih salah satu!'
            },
            firearm_brand: {
                required: 'Pilih salah satu!'
            },
            firearm_number: {
                required: 'Nomor senjata tidak boleh kosong!'
            },
            bpsa_number: {
                required: 'Nomor BPSA tidak boleh kosong!'
            },
            condition: {
                required: 'Kondisi tidak boleh kosong!'
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