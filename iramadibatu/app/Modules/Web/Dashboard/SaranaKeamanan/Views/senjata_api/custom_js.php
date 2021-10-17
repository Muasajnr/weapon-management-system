<?=$this->section('custom-js')?>
<!-- bs-custom-file-input -->
<script src="<?=site_url('assets/js/vendor/qrcode.min.js')?>"></script>
<script>
$(function() {
    const urlSaranaKeamanan = '<?=site_url('api/v1/dashboard/sarana_keamanan')?>';
    const urlBeritaAcara = '<?=site_url('api/v1/dashboard/berita_acara')?>';
    const urlJenisSarana = '<?=site_url('api/v1/dashboard/jenis_sarana')?>';
    const urlMerkSarana = '<?=site_url('api/v1/dashboard/merk_sarana')?>';

    bsCustomFileInput.init()

    // handles datatable
    const table = $('#data_senjata_api').DataTable({
        "responsive": true,
        "processing": true,
        "serverSide": true,
        "pageLength": 25,
        "dom": 'lrtip',
        "order": [],
        "drawCallback": function(settings) {
            if ($('#checkAll').is(":checked")) {
                $('.multi_delete').prop('checked', true);
            } else {
                $('.multi_delete').prop('checked', false);
            }
        },
        "ajax": function(data, callback, settings) {
            data.id_jenis_inventaris = 1;

            $.ajax({
                type: 'POST',
                url: `${urlSaranaKeamanan}/datatable`,
                dataType: 'json',
                data: data,
                headers: {
                    'Authorization': 'Bearer ' + accessToken,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                success: function(res) {
                    callback(res);
                },
                error: function(err) {
                    console.log(err);
                }
            });
        },
        "columns": [
            { "targets": 0, "orderable": false, "searchable": false },
            { "targets": 1, "orderable": false, "searchable": false },
            { "targets": 2, "orderable": true, "searchable": true },
            { "targets": 3, "orderable": false, "searchable": false },
            { "targets": 4, "orderable": false, "searchable": false },
            { "targets": 5, "orderable": true, "searchable": true },
            { "targets": 6, "orderable": false },
            { "targets": 7, "orderable": false },
            { "targets": 8, "orderable": false }
        ],
    });

    // handle list berita acara
    $('#select2-data-berita-acara').select2({
        // allowClear: true,
        // minimumResultsForSearch: Infinity,
        placeholder: 'Pilih berita acara',
        theme: 'bootstrap4',
        escapeMarkup: function (markup) { return markup; },
        language: {
            noResults: function () {
                return `<button type="button" class="btn btn-sm btn-default" href="http://google.com/"><i class="fas fa-plus"></i>&nbsp;&nbsp;Tambah Berita Acara</button>`;
            }
        },
        ajax: {
            url: urlBeritaAcara,
            headers: {
                'Authorization': 'Bearer ' + accessToken,
                'X-Requested-With': 'XMLHttpRequest'
            },
            dataType: 'json',
            cache: true,
            processResults: function(data, params) {
                const results = [];
                data.data.forEach(function(item) {
                    results.push({
                        text: `<strong>${item.nomor}</strong> - ${item.nama}`,
                        id: item.id
                    });
                });

                return {
                    results: results
                }
            }
        }
    });

    // handle list jenis sarana
    $('#select2-data-jenis-sarana').select2({
        // allowClear: true,
        // minimumResultsForSearch: Infinity,
        placeholder: 'Pilih jenis sarana',
        theme: 'bootstrap4',
        escapeMarkup: function (markup) { return markup; },
        language: {
            noResults: function () {
                return `<button type="button" class="btn btn-sm btn-default" href="http://google.com/"><i class="fas fa-plus"></i>&nbsp;&nbsp;Tambah</button>`;
            }
        },
        ajax: {
            url: '<?=site_url('api/v1/dashboard/master/jenis_sarana')?>',
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
    
    // handle list merk sarana
    $('#select2-data-merk-sarana').select2({
        // allowClear: true,
        // minimumResultsForSearch: Infinity,
        theme: 'bootstrap4',
        placeholder: 'Pilih merk sarana',
        escapeMarkup: function (markup) { return markup; },
        language: {
            noResults: function () {
                return `<button type="button" class="btn btn-sm btn-default" href="http://google.com/"><i class="fas fa-plus"></i>&nbsp;&nbsp;Tambah</button>`;
            }
        },
        ajax: {
            url: '<?=site_url('api/v1/dashboard/master/merk_sarana')?>',
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

    // handle list berita acara edit
    $('#select2-data-berita-acara-edit').select2({
        // allowClear: true,
        // minimumResultsForSearch: Infinity,
        placeholder: 'Pilih berita acara',
        theme: 'bootstrap4',
        escapeMarkup: function (markup) { return markup; },
        language: {
            noResults: function () {
                return `<button type="button" class="btn btn-sm btn-default" href="http://google.com/"><i class="fas fa-plus"></i>&nbsp;&nbsp;Tambah Berita Acara</button>`;
            }
        },
        ajax: {
            url: urlBeritaAcara,
            headers: {
                'Authorization': 'Bearer ' + accessToken,
                'X-Requested-With': 'XMLHttpRequest'
            },
            dataType: 'json',
            cache: true,
            processResults: function(data, params) {
                const results = [];
                data.data.forEach(function(item) {
                    results.push({
                        text: `<strong>${item.nomor}</strong> - ${item.nama}`,
                        id: item.id
                    });
                });

                return {
                    results: results
                }
            }
        }
    });

    // handle list jenis sarana edit
    $('#select2-data-jenis-sarana-edit').select2({
        // allowClear: true,
        // minimumResultsForSearch: Infinity,
        placeholder: 'Pilih jenis sarana',
        theme: 'bootstrap4',
        escapeMarkup: function (markup) { return markup; },
        language: {
            noResults: function () {
                return `<button type="button" class="btn btn-sm btn-default" href="http://google.com/"><i class="fas fa-plus"></i>&nbsp;&nbsp;Tambah</button>`;
            }
        },
        ajax: {
            url: '<?=site_url('api/v1/dashboard/master/jenis_sarana')?>',
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
    
    // handle list merk sarana edit
    $('#select2-data-merk-sarana-edit').select2({
        // allowClear: true,
        // minimumResultsForSearch: Infinity,
        theme: 'bootstrap4',
        placeholder: 'Pilih merk sarana',
        escapeMarkup: function (markup) { return markup; },
        language: {
            noResults: function () {
                return `<button type="button" class="btn btn-sm btn-default" href="http://google.com/"><i class="fas fa-plus"></i>&nbsp;&nbsp;Tambah</button>`;
            }
        },
        ajax: {
            url: '<?=site_url('api/v1/dashboard/master/merk_sarana')?>',
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

    // handle adding form
    $('#form-add-senjata-api').validate({
        submitHandler: function(form, event) {
            event.preventDefault();
            
            const newData = new FormData();
            newData.append("id_berita_acara", $(form).find('#select2-data-berita-acara option:selected').val());
            newData.append("id_jenis_sarana", $(form).find('#select2-data-jenis-sarana option:selected').val());
            newData.append("id_merk_sarana", $(form).find('#select2-data-merk-sarana option:selected').val());
            newData.append("nomor_sarana",$(form).find('input#no_senjata').val());
            newData.append("nomor_bpsa", $(form).find('input#no_bpsa').val());
            newData.append("kondisi", $(form).find('input[name="kondisi"]:checked').val());

            if ($(form).find('#media_senjata').get(0).files[0] !== undefined) {
                newData.append("media", $(form).find('#media_senjata').get(0).files[0]);

                if ((newData.get('media').size / 1000) > 512) {
                Swal.fire({
                        icon: 'error',
                        title: 'Terjadi error!',
                        text: 'Ukuran file terlalu besar!',
                        showConfirmButton: true,
                        timer: 2000
                    });
                    return;
                }
            }
            
            newData.append("keterangan", $(form).find('textarea#keterangan').val());
            newData.append("id_jenis_inventaris", 1);
            newData.append("jumlah", 1);
            newData.append("satuan", "unit");

            const createUrl = '<?=site_url('api/v1/dashboard/sarana_keamanan')?>';
            $.ajax({
                type: 'POST',
                url: urlSaranaKeamanan,
                dataType: 'json',
                data: newData,
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
                        $('#modal-add-senjata-api').modal('toggle');

                        $(form).find('#select2-data-berita-acara').val('').trigger('change');
                        $(form).find('#select2-data-jenis-sarana').val('').trigger('change');
                        $(form).find('#select2-data-merk-sarana').val('').trigger('change');
                        $(form).find('input#no_senjata').val('');
                        $(form).find('input#no_bpsa').val('');
                        $(form).find('input[name="kondisi"][value="baik"]').prop('checked', true);
                        $(form).find('input#media_senjata').next().text('')
                        $(form).find('textarea#keterangan').val('')

                        table.ajax.reload();
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
            berita_acara: { required: true },
            jenis_senjata: { required: true },
            merk_senjata: { required: true },
            no_senjata: { required: true },
            no_bpsa: { required: true },
            media_senjata: { accept: 'image/png,image/jpeg' },
            kondisi: { required: true },
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

    // set edit data to modal
    $('#data_senjata_api tbody').on('click', 'tr td button.btn-info', function(e) {
        e.preventDefault();
        
        const rowData = table.row($(this).parent().parent()).data();
        const itemId = parseInt($(rowData[1]).find('input[name="id"]').val());
        
        const idBeritaAcara = $(rowData[1]).find('input[name="id_berita_acara"]').val();
        const judulBeritaAcara = $(rowData[1]).find('input[name="judul_berita_acara"]').val();
        const nomorBeritaAcara = $(rowData[1]).find('input[name="nomor_berita_acara"]').val();

        const idJenisSarana = $(rowData[1]).find('input[name="id_jenis_sarana"]').val();
        const namaJenisSarana = $(rowData[1]).find('input[name="nama_jenis_sarana"]').val();

        const idMerkSarana = $(rowData[1]).find('input[name="id_merk_sarana"]').val();
        const namaMerkSarana = $(rowData[1]).find('input[name="nama_merk_sarana"]').val();

        const mediaFileFullPath = $(rowData[1]).find('input[name="media_file_full_path"]').val();
        const mediaFileExtension = $(rowData[1]).find('input[name="media_file_extension"]').val();

        $('input#edit_id').val(itemId);
        $("select#select2-data-berita-acara-edit").select2("trigger", "select", {
            data: { id: idBeritaAcara, text: `<strong>${nomorBeritaAcara}</strong> - ${judulBeritaAcara}` }
        });
        $("select#select2-data-jenis-sarana-edit").select2("trigger", "select", {
            data: { id: idJenisSarana, text: `${namaJenisSarana}` }
        });
        $("select#select2-data-merk-sarana-edit").select2("trigger", "select", {
            data: { id: idMerkSarana, text: `${namaMerkSarana}` }
        });

        $('#modal-edit-senjata-api .col-6 .media-area').html(
            mediaFileExtension == 'pdf' ? 
            `
                <embed src="<?=site_url()?>/${mediaFileFullPath}" type="application/pdf" width="100%" height="400">
            `
            : 
            `
                <img src="<?=site_url()?>/${mediaFileFullPath}" alt="${rowData[3]}" width="100%">
            `
        );

        $('input#edit_no_senjata').val(rowData[2]);
        $('input#edit_no_bpsa').val(rowData[3]);
        $('textarea#edit_keterangan').val(rowData[7]);
        
        if (rowData[6] === 'baik')
            $('input[name="edit_kondisi"][value="baik"]').prop('checked', true);
        else
            $('input[name="edit_kondisi"][value="rusak"]').prop('checked', true);
        
        $('#modal-edit-senjata-api').modal('toggle');
    });

    // generate qrcode
    var qrcode = new QRCode(document.getElementById('qrcode-senjata-api'), "init_value");

    // qrcode button clicked
    $('#data_senjata_api tbody').on('click', 'tr td button.btn-warning', function(e) {
        const rowData = table.row($(this).parent().parent()).data();
        const itemId = parseInt($(rowData[1]).find('input[name="id"]').val());
        const qrCodeSecret = $(rowData[1]).find('input[name="qrcode_secret"]').val();

        qrcode.clear();
        qrcode.makeCode(qrCodeSecret)

        $('#modal-qrcode-senjata-api').modal('toggle');
    });

    // print qr code
    $('#print-qrcode').click(function(e) {
        var prntPage = window.open('', '', 'height=1200,width=800');
        var qrCodeDiv = $('#qrcode-senjata-api').html();
        prntPage.document.write(
            `
            ${qrCodeDiv}
            `
        );
        prntPage.document.close();
        prntPage.focus();
        prntPage.print();
        prntPage.close();
    });
});
</script>

<?=$this->endSection()?>