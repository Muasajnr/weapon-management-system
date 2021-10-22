<?=$this->section('custom-js')?>
<script src="<?=site_url('assets/js/vendor/qrcode.min.js')?>"></script>
<script>
$(function() {
    const urlSaranaKeamanan = '<?=site_url('api/v1/dashboard/sarana_keamanan')?>';
    const urlBeritaAcara = '<?=site_url('api/v1/dashboard/berita_acara')?>';
    const urlJenisSarana = '<?=site_url('api/v1/dashboard/jenis_sarana')?>';
    const urlMerkSarana = '<?=site_url('api/v1/dashboard/merk_sarana')?>';

    bsCustomFileInput.init()

    // handles datatable
    const table = $('#data_non_organik').DataTable({
        "responsive": true,
        "drawCallback": function(settings) {
            if ($('#checkAll').is(":checked")) {
                $('.multi_delete').prop('checked', true);
            } else {
                $('.multi_delete').prop('checked', false);
            }
        },
        "dom": 'lrtip',
        "pageLength": 25,
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": function(data, callback, settings) {
            data.id_jenis_inventaris = 2;
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
            { "targets": 8, "orderable": false },
            { "targets": 9, "orderable": false },
            { "targets": 10, "orderable": false }
        ],
    });

    // clear show modal
    $('#modal_show_detail').on('hidden.bs.modal', function (e) {
        $('#data_detail').html('');
    })

    // handle show detail
    $('#data_non_organik tbody').on('click', 'tr td button.btn-primary', function(e) {
        e.preventDefault();

        const rowData = table.row($(this).parent().parent()).data();
        const itemId = parseInt($(rowData[1]).find('input[name="id"]').val());
        
        $.ajax({
            type: 'GET',
            url: `${urlSaranaKeamanan}/${itemId}`,
            dataType: 'json',
            headers: {
                'Authorization': 'Bearer ' + accessToken,
                'X-Requested-With': 'XMLHttpRequest'
            },
            success: function(res) {
                console.log(res);

                if (res.data) {
                    for (const [key, value] of Object.entries(res.data)) {
                        $('#data_detail').append(
                            key !== 'media_file_full_path' ? `
                            <dt class="col-sm-4">${key}</dt>
                            <dd class="col-sm-8">${value == null ? '-' : value}</dd>
                            ` : `<dt class="col-sm-4">${key}</dt><dd class="col-sm-8"><img src="/${value}" alt="Nothing" width="100%"></dd>`
                        );
                    }
                }

                $('#modal_show_detail').modal('toggle');
            },
            error: function(err) {
                console.log(err);

                Swal.fire({
                    icon: 'error',
                    title: 'Data gagal ditampilkan!',
                    text: err.responseJSON.message,
                    showConfirmButton: true,
                    timer: 2000
                });
            }
        });
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
    $('#form-add-non-organik').validate({
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
            newData.append("id_jenis_inventaris", 2);
            newData.append("jumlah", 1);
            newData.append("satuan", "unit");

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
                        $('#modal-add-non-organik').modal('toggle');

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

    // handle editing form
    $('#form-edit-non-organik').validate({
        submitHandler: function(form, event) {
            event.preventDefault();

            const itemId = $(form).find('input[name="edit_id"]').val();

            const updatedData = new FormData();
            updatedData.append("id_berita_acara", $(form).find('#select2-data-berita-acara-edit option:selected').val());
            updatedData.append("id_jenis_sarana", $(form).find('#select2-data-jenis-sarana-edit option:selected').val());
            updatedData.append("id_merk_sarana", $(form).find('#select2-data-merk-sarana-edit option:selected').val());
            updatedData.append("nomor_sarana",$(form).find('input#edit_no_senjata').val());
            updatedData.append("nomor_bpsa", $(form).find('input#edit_no_bpsa').val());
            updatedData.append("kondisi", $(form).find('input[name="edit_kondisi"]:checked').val());

            if ($(form).find('#edit_media_senjata').get(0).files[0] !== undefined) {
                updatedData.append("media", $(form).find('#edit_media_senjata').get(0).files[0]);

                if ((updatedData.get('media').size / 1000) > 512) {
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
            
            updatedData.append("keterangan", $(form).find('textarea#edit_keterangan').val());
            updatedData.append("id_jenis_inventaris", 2);
            updatedData.append("jumlah", 1);
            updatedData.append("satuan", "unit");

            // updatedData.forEach(function(value, index) {
            //     console.log(index + ' => ' + value);
            // });


            $.ajax({
                type: 'POST',
                url: `${urlSaranaKeamanan}/${itemId}/update`,
                dataType: 'json',
                data: updatedData,
                mimeType: 'multipart/form-data',
                contentType: false,
                cache: false,
                processData: false,
                headers: {
                    'Authorization': 'Bearer ' + accessToken,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                success: function(res) {
                    console.log(res);

                    Swal.fire({
                        icon: 'success',
                        title: 'Data telah diperbaharui!',
                        showConfirmButton: true,
                        timer: 2000
                    });

                    setTimeout(() => {
                        $('#modal-edit-non-organik').modal('toggle');
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
    $('#data_non_organik tbody').on('click', 'tr td button.btn-info', function(e) {
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

        $('#form-edit-non-organik').find('input[name="edit_id"]').val(itemId);
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

        if ($(rowData[6]).text() === 'baik')
            $('input[name="edit_kondisi"][value="baik"]').prop('checked', true);
        else
            $('input[name="edit_kondisi"][value="rusak"]').prop('checked', true);
        
        $('#modal-edit-non-organik').modal('toggle');
    });

    // generate qrcode
    var qrcode = new QRCode(document.getElementById('qrcode-senjata-api'), "init_value");

    // qrcode button clicked
    $('#data_non_organik tbody').on('click', 'tr td button.btn-warning', function(e) {
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

    // show confirmation to delete a clicked row
    $('#data_non_organik tbody').on('click', 'tr td button.btn-danger', function(e) {
        e.preventDefault();

        const itemId = $(this).data().itemId;

        Swal.fire({
            title: 'Anda yakin?',
            text: `Anda akan menghapus data ini.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Iya, hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'DELETE',
                    url: `${urlSaranaKeamanan}/${itemId}/delete`,
                    headers: {
                        'Authorization': 'Bearer ' + accessToken,
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    success: function(res) {
                        console.log(res);
                        Swal.fire(
                            'Terhapus!',
                            'Data telah terhapus!',
                            'success'
                        )
                        table.ajax.reload();
                    },
                    error: function(err) {
                        console.log(err.responseJSON);
                        Swal.fire(
                            'Gagal!',
                            'Data gagal terhapus!',
                            'error'
                        )
                    }
                })
            }
        });
    });

    $('#btn-delete-multiple').click(function(e) {
        e.preventDefault();

        const selectedRows = $('.multi_delete:checked');
        
        if (selectedRows.length > 0) {
            Swal.fire({
                title: 'Anda yakin?',
                text: `Anda akan menghapus ke-${selectedRows.length} data ini.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Iya, hapus semua!'
            }).then((result) => {
                if (result.isConfirmed) {
                    const ids = [];

                    selectedRows.each(function(index, item) {
                        ids.push($(item).data().itemId);
                    });

                    const idsData = {"ids": ids};

                    $.ajax({
                        type: 'DELETE',
                        url: `${urlSaranaKeamanan}/delete/multiple`,
                        data: JSON.stringify(idsData),
                        contentType: 'application/json',
                        headers: {
                            'Authorization': 'Bearer ' + accessToken,
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        success: function(res) {
                            console.log(res);
                            Swal.fire(
                                'Terhapus!',
                                selectedRows.length + ' data telah terhapus!',
                                'success'
                            )
                            table.ajax.reload();
                        },
                        error: function(err) {
                            console.log(err.responseJSON);
                            Swal.fire(
                                'Gagal!',
                                'Data menghapus '+selectedRows.length+' data!',
                                'error'
                            )
                        }
                    })
                }
            });
        }
    });

    // fitler data
    $('#filter_data').submit(function(e) {
        e.preventDefault();

        let searchQuery = $('input#searchQuery').val();
        
        table.search(searchQuery).draw();
    });
});
</script>

<?=$this->endSection()?>