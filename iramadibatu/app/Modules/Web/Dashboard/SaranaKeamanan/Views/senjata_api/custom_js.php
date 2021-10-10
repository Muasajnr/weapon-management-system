<?=$this->section('custom-js')?>

<!-- DataTables  & Plugins -->
<script src="<?=site_url('themes/AdminLTE/plugins/datatables/jquery.dataTables.min.js')?>"></script>
<script src="<?=site_url('themes/AdminLTE/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')?>"></script>
<script src="<?=site_url('themes/AdminLTE/plugins/datatables-responsive/js/dataTables.responsive.min.js')?>"></script>
<script src="<?=site_url('themes/AdminLTE/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')?>"></script>
<script src="<?=site_url('themes/AdminLTE/plugins/datatables-buttons/js/dataTables.buttons.min.js')?>"></script>
<script src="<?=site_url('themes/AdminLTE/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')?>"></script>
<script src="<?=site_url('themes/AdminLTE/plugins/datatables-buttons/js/buttons.html5.min.js')?>"></script>
<script src="<?=site_url('themes/AdminLTE/plugins/datatables-buttons/js/buttons.print.min.js')?>"></script>
<script src="<?=site_url('themes/AdminLTE/plugins/datatables-buttons/js/buttons.colVis.min.js')?>"></script>

<!-- Select2 -->
<script src="<?=site_url('themes/AdminLTE/plugins/select2/js/select2.full.min.js')?>"></script>

<!-- jquery-validation -->
<script src="<?=site_url('themes/AdminLTE/plugins/jquery-validation/jquery.validate.min.js')?>"></script>
<script src="<?=site_url('themes/AdminLTE/plugins/jquery-validation/additional-methods.min.js')?>"></script>

<script>
$(function() {
    bsCustomFileInput.init()

    // handles datatable
    const table = $('#data_senjata_api').DataTable({
        "responsive": true,
        "drawCallback": function(settings) {
            if ($('#checkAll').is(":checked")) {
                $('.multi_delete').prop('checked', true);
            } else {
                $('.multi_delete').prop('checked', false);
            }
        },
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": function(data, callback, settings) {
            const dataUrl = '<?=site_url('api/v1/dashboard/sarana_keamanan/datatables/1')?>';

            $.ajax({
                type: 'POST',
                url: dataUrl,
                dataType: 'json',
                data: data,
                headers: {
                    'Authorization': 'Bearer ' + accessToken
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
            {
                "targets": 0,
                "orderable": false,
                "searchable": false
            },
            {
                "targets": 1,
                "orderable": false,
                "searchable": false
            },
            {
                "targets": 2,
                "orderable": true,
                "searchable": true
            },
            {
                "targets": 3,
                "orderable": false,
                "searchable": false
            },
            {
                "targets": 4,
                "orderable": false,
                "searchable": false
            },
            {
                "targets": 5,
                "orderable": true,
                "searchable": true,
            },
            {
                "targets": 6,
                "orderable": false,
            },
            {
                "targets": 7,
                "orderable": false,
            },
            {
                "targets": 8,
                "orderable": false,
            }
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

    // add data
    // let addedData = [];
    // $('#form-add-senjata-api tbody').on('click', 'tr td button.btn-danger', function(e) {
    //     e.preventDefault();

    //     if ($(this).parent().parent().parent().children().length == 1) {
    //         $(this).parent().parent().parent().append(`<tr><td class="text-center" colspan="5">tidak ada data.</td></tr>`);
    //     }

    //     $(this).parent().parent().remove();
    // });

    $('#form-add-senjata-api').validate({
        submitHandler: function(form, event) {
            event.preventDefault();

            // if ($($('#form-add-senjata-api').find('tbody').children()[0]).children().length == 1) {
            //     $('#form-add-senjata-api').find('tbody').empty();
            // }
            
            let number = $('#form-add-senjata-api').find('tbody').children().length;
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

            // newData.forEach(function(key, val) {
            //     console.log(key + ' => ' + val);
            // });

            // return;
            // $('#form-add-senjata-api tbody').append(
            //     `
            //     <tr>
            //         <td>${number+1}.</td>
            //         <td>${newData.name}</td>
            //         <td>${newData.desc}</td>
            //         <td>${newData.is_active ? 'Aktif' : 'Tidak Aktif'}</td>
            //         <td class="text-center"><button type="button" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button></td>
            //     </tr>
            //     `
            // );

            // addedData.push(newData);

            // console.log(addedData);
            // return;

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
            berita_acara: {
                required: true
            },
            jenis_senjata: {
                required: true
            },
            merk_senjata: {
                required: true
            },
            no_senjata: {
                required: true
            },
            no_bpsa: {
                required: true
            },
            media_senjata: {
                accept: 'image/png,image/jpeg'
            },
            kondisi: {
                required: true
            },
        },
        messages: {
            berita_acara: {
                required: 'Pilih salah satu!'
            },
            jenis_senjata: {
                required: 'Pilih salah satu!'
            },
            merk_senjata: {
                required: 'Pilih salah satu!'
            },
            no_senjata: {
                required: 'No. Senjata tidak boleh kosong!'
            },
            no_bpsa: {
                required: 'No. BPSA tidak boleh kosong!'
            },
            kondisi: {
                required: 'Pilih salah satu!'
            },
            media_senjata: {
                accept: 'Gambar tidak support.'
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

    $('#form-add-senjata-api').find('#section-table-added').hide();
    $('#form-add-senjata-api').find('#btn-submit-all').hide();
    $('input#is_single_insert').on('change', function(e) {
        if ($(this).is(':checked')) {
            $('#form-add-senjata-api').find('#section-table-added').show();
            $('#form-add-senjata-api').find('#btn-submit-all').show();
            $(this).next().text('Multi-Insert');
        } else {
            $('#form-add-senjata-api').find('#section-table-added').hide();
            $('#form-add-senjata-api').find('#btn-submit-all').hide();
            $(this).next().text('Single-Insert');
        }
    });
});
</script>

<?=$this->endSection()?>