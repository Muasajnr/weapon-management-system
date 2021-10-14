<?=$this->section('custom-js')?>
<!-- bs-custom-file-input -->
<script src="<?=site_url('themes/AdminLTE/plugins/bs-custom-file-input/bs-custom-file-input.min.js')?>"></script>
<script>
$(function() {
    const baseUrl = '<?=site_url('api/v1/dashboard/sarana_keamanan')?>';

    bsCustomFileInput.init()

    // handles datatable
    const table = $('#data_senjata_api').DataTable({
        "responsive": true,
        "processing": true,
        "serverSide": true,
        "order": [],
        "drawCallback": function(settings) {
            if ($('#checkAll').is(":checked")) {
                $('.multi_delete').prop('checked', true);
            } else {
                $('.multi_delete').prop('checked', false);
            }
        },
        "ajax": function(data, callback, settings) {
            $.ajax({
                type: 'POST',
                url: `${baseUrl}/datatables/1`,
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

    $('#select2-data-berita-acara').select2({
        // allowClear: true,
        minimumResultsForSearch: Infinity,
        placeholder: 'Pilih berita acara',
        theme: 'bootstrap4',
        escapeMarkup: function (markup) { return markup; },
        language: {
            noResults: function () {
                return `<button type="button" class="btn btn-sm btn-default" href="http://google.com/"><i class="fas fa-plus"></i>&nbsp;&nbsp;Tambah Berita Acara</button>`;
            }
        },
        matcher: function(params, data)
        {
            if ($.trim(params.term) === '') {
                return data;
            }

            if (typeof data.text === 'undefined') {
                return null;
            }

            if (data.text.indexOf(params.term) > -1) {
                var modifiedData = $.extend({}, data, true);
                // modifiedData.text += ' (matched)';

                return modifiedData;
            }

            return null;
        },
        ajax: {
            url: '<?=site_url('api/v1/dashboard/berita_acara')?>',
            headers: {
                'Authorization': 'Bearer ' + accessToken
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

    $('#select2-data-jenis-sarana').select2({
        // allowClear: true,
        minimumResultsForSearch: Infinity,
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
    
    $('#select2-data-merk-sarana').select2({
        // allowClear: true,
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
                newData.append("media_sarana", $(form).find('#media_senjata').get(0).files[0]);

                if ((newData.get('media_sarana').size / 1000) > 512) {
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

            const createUrl = '<?=site_url('api/v1/dashboard/sarana_keamanan/create/1')?>';
            $.ajax({
                type: 'POST',
                url: createUrl,
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

    
});
</script>

<?=$this->endSection()?>