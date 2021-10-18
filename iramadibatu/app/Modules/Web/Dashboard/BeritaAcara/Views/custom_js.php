<?=$this->section('custom-js')?>
<script>
$(function() {
    const baseApiUrl = '<?=site_url('api/v1/dashboard/berita_acara')?>';

    bsCustomFileInput.init()

    $('#tanggal').datetimepicker({
        format: 'YYYY-MM-DD'
    });

    $('#edit_tanggal').datetimepicker({
        format: 'YYYY-MM-DD'
    });

    const dateObj = new Date();
    const currMonth = dateObj.getMonth()+1 < 10 ? '0'+(dateObj.getMonth()+1) : dateObj.getMonth()+1;
    const currDate = dateObj.getDate() < 10 ? '0'+dateObj.getDate() : dateObj.getDate();
    const currYear = dateObj.getFullYear();
    const nowTime = currYear + '-' + currMonth + '-' + currDate;
    $('#tanggal').find('input[name="tanggal"]').val(nowTime);
    $('#edit_tanggal').find('input[name="edit_tanggal"]').val(nowTime);

    // datatable
    const table = $('#data-berita-acara').DataTable({
        "pageLength": 25,
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
            const dataUrl = '<?=site_url('api/v1/dashboard/berita_acara/datatables')?>';

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
            { "targets": 0, "orderable": false, "searchable": false },
            { "targets": 1, "orderable": false, "searchable": false },
            { "targets": 2, "orderable": true, "searchable": true },
            { "targets": 3, "orderable": true, "searchable": true },
            { "targets": 4, "orderable": false, "searchable": false },
            { "targets": 5, "orderable": false, "searchable": false },
            { "targets": 6, "orderable": true, "searchable": true },
            { "targets": 7, "orderable": false },
            { "targets": 8, "orderable": false }
        ],
    });

    // load all penanggung_jawab data to select2 pihak 1
    $('#select2-data-pihak-1').select2({
        placeholder: 'Pilih Pihak 1',
        theme: 'bootstrap4',
        escapeMarkup: function (markup) { return markup; },
        ajax: {
            url: `${baseApiUrl}/penanggung_jawab/all`,
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
                        text: `<strong>${item.nip}</strong> - ${item.nama}`,
                        id: item.id
                    });
                });

                return {
                    results: results
                }
            }
        }
    });

    // load all penanggung_jawab data to select2 pihak 2
    $('#select2-data-pihak-2').select2({
        placeholder: 'Pilih Pihak 2',
        theme: 'bootstrap4',
        escapeMarkup: function (markup) { return markup; },
        ajax: {
            url: `${baseApiUrl}/penanggung_jawab`,
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
                        text: `<strong>${item.nip}</strong> - ${item.nama}`,
                        id: item.id
                    });
                });

                return {
                    results: results
                }
            }
        }
    });

    // load all penanggung_jawab data to select2 pihak 1 edit
    $('#select2-data-pihak-1-edit').select2({
        placeholder: 'Pilih Pihak 1',
        theme: 'bootstrap4',
        escapeMarkup: function (markup) { return markup; },
        ajax: {
            url: `${baseApiUrl}/penanggung_jawab`,
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
                        text: `<strong>${item.nip}</strong> - ${item.nama}`,
                        id: item.id
                    });
                });

                return {
                    results: results
                }
            }
        }
    });

    // load all penanggung_jawab data to select2 pihak 2 edit
    $('#select2-data-pihak-2-edit').select2({
        placeholder: 'Pilih Pihak 2',
        theme: 'bootstrap4',
        escapeMarkup: function (markup) { return markup; },
        ajax: {
            url: `${baseApiUrl}/penanggung_jawab`,
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
                        text: `<strong>${item.nip}</strong> - ${item.nama}`,
                        id: item.id
                    });
                });

                return {
                    results: results
                }
            }
        }
    });

    // handle adding data
    $('#form-add-berita-acara').validate({
        submitHandler: function(form, event) {
            event.preventDefault();

            const beritaAcara = new FormData();
            beritaAcara.append('nama', $(form).find('input#nama').val());
            beritaAcara.append('nomor', $(form).find('input#nomor').val());
            beritaAcara.append('tanggal', $(form).find('#tanggal input[name="tanggal"]').val());
            beritaAcara.append('id_pihak_1', $(form).find('#select2-data-pihak-1 option:selected').val());
            beritaAcara.append('id_pihak_2', $(form).find('#select2-data-pihak-2 option:selected').val());
            beritaAcara.append('media', $(form).find('#media').get(0).files[0]);
            beritaAcara.append('keterangan', $(form).find('textarea#keterangan').val());

            // beritaAcara.forEach(function(value, index) {
            //     console.log(index + ' => ' + value);
            // });

            // return;
            if ((beritaAcara.get('media').size / 1000) > 1600) {
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
                url: baseApiUrl,
                data: beritaAcara,
                dataType: 'json',
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
                        window.location.href = '<?=route_to('berita_acara')?>';
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
            nomor: { required: true },
            nama: { required: true },
            tanggal: { required: true },
            pihak_1: { required: true },
            pihak_2: { required: true },
            media: {
                accept: 'image/png,image/jpeg,application/pdf'
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

    // set data to modal edit when clicked
    $('#data-berita-acara tbody').on('click', 'tr td button.btn-info', function(e) {
        e.preventDefault();

        const rowData = table.row($(this).parent().parent()).data();
        const itemId = parseInt($(rowData[1]).find('input[name="id"]').val());
        const keterangan = $(rowData[1]).find('input[name="keterangan"]').val();
        const idPihak1 = $(rowData[1]).find('input[name="id_pihak_1"]').val();
        const idPihak1Nama = $(rowData[1]).find('input[name="id_pihak_1_nama"]').val();
        const idPihak1Nip = $(rowData[1]).find('input[name="id_pihak_1_nip"]').val();
        const idPihak2 = $(rowData[1]).find('input[name="id_pihak_2"]').val();
        const idPihak2Nama = $(rowData[1]).find('input[name="id_pihak_2_nama"]').val();
        const idPihak2Nip = $(rowData[1]).find('input[name="id_pihak_2_nip"]').val();

        const mediaFileFullPath = $(rowData[1]).find('input[name="media_file_full_path"]').val();
        const mediaFileExtension = $(rowData[1]).find('input[name="media_file_extension"]').val();

        $('input#edit_id').val(itemId);
        $('input#edit_nomor').val(rowData[2]);
        $('input#edit_nama').val(rowData[3]);
        $('#edit_tanggal input').val(rowData[4]);
        $("select#select2-data-pihak-1-edit").select2("trigger", "select", {
            data: { id: idPihak1, text: `<strong>${idPihak1Nip}</strong> - ${idPihak1Nama}` }
        });
        $("select#select2-data-pihak-2-edit").select2("trigger", "select", {
            data: { id: idPihak1, text: `<strong>${idPihak2Nip}</strong> - ${idPihak2Nama}` }
        });
        $('textarea#edit_keterangan').val(keterangan);
        $('#modal_edit_berita_acara .col-6 .media-area').html(
            mediaFileExtension == 'pdf' ? 
            `
                <embed src="<?=site_url()?>/${mediaFileFullPath}" type="application/pdf" width="100%" height="400">
            `
            : 
            `
                <img src="<?=site_url()?>/${mediaFileFullPath}" alt="${rowData[3]}" width="100%">
            `
        );
        $('#modal_edit_berita_acara').modal('toggle');
    });

    // handle editing data
    $('#form_edit_berita_acara').validate({
        submitHandler: function(form, event) {
            event.preventDefault();

            const itemId = $(form).find('input#edit_id').val();

            const editedBeritaAcara = new FormData();
            editedBeritaAcara.append('nama', $(form).find('input#edit_nama').val());
            editedBeritaAcara.append('nomor', $(form).find('input#edit_nomor').val());
            editedBeritaAcara.append('tanggal', $(form).find('#edit_tanggal input[name="edit_tanggal"]').val());
            editedBeritaAcara.append('id_pihak_1', $(form).find('select#select2-data-pihak-1-edit option:selected').val());
            editedBeritaAcara.append('id_pihak_2', $(form).find('select#select2-data-pihak-2-edit option:selected').val());
            editedBeritaAcara.append('media', $(form).find('#edit_media').get(0).files[0]);
            editedBeritaAcara.append('keterangan', $(form).find('textarea#edit_keterangan').val());
            
            editedBeritaAcara.forEach(function(value, index) {
                console.log(index + ' => ' + value);
            });

            if ((editedBeritaAcara.get('media').size / 1000) > 1600) {
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
                url: `${baseApiUrl}/${itemId}/update`,
                dataType: 'json',
                data: editedBeritaAcara,
                contentType: 'application/json',
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
                        title: 'Data telah diubah!',
                        showConfirmButton: true,
                        timer: 2000
                    });

                    setTimeout(() => {
                        $('#modal_edit_berita_acara').modal('toggle');
                        table.ajax.reload();
                    }, 2000);
                },
                error: function(err) {
                    console.log(err.responseJSON);

                    Swal.fire({
                        icon: 'error',
                        title: 'Data gagal diubah!',
                        text: err.responseJSON.message,
                        showConfirmButton: true,
                        timer: 2000
                    });
                }
            })
        },
        rules: {
            nomor: { required: true },
            nama: { required: true },
            tanggal: { required: true },
            pihak_1: { required: true },
            pihak_2: { required: true },
            media: {
                accept: 'image/png,image/jpeg,application/pdf'
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

    // show confirmation to delete a clicked row
    $('#data-berita-acara tbody').on('click', 'tr td button.btn-danger', function(e) {
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
                    url: `${baseApiUrl}/${itemId}/delete`,
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
                        url: `${baseApiUrl}/delete/multiple`,
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