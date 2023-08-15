<?=$this->section('custom-js')?>
<script>
$(function() {
    const baseApiUrl = '<?=site_url('api/v1/dashboard/berita_acara/penanggung_jawab')?>';
    // datatable
    const table = $('#data-penanggung-jawab').DataTable({
        "pageLength": 25,
        "dom": 'lrtip',
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
                url: `${baseApiUrl}/datatable`,
                dataType: 'json',
                data: data,
                headers: { 'Authorization': 'Bearer ' + accessToken, 'X-Requested-With': 'XMLHttpRequest' },
                success: function(res) { callback(res); },
                error: function(err) { console.log(err); }
            });
        },
        "columns": [
            { "targets": 0, "orderable": false, "searchable": false },
            { "targets": 1, "orderable": false, "searchable": false },
            { "targets": 2, "orderable": true, "searchable": true },
            { "targets": 3, "orderable": true, "searchable": true },
            { "targets": 4, "orderable": true, "searchable": true },
            { "targets": 5, "orderable": true, "searchable": true },
            { "targets": 6, "orderable": true, "searchable": true },
            { "targets": 7, "orderable": false }
        ],
    });

    // reset show modal when the model dismissed
    $('#modal-show-penanggung-jawab').on('hidden.bs.modal', function (e) {
        $('#data-detail').html('');
    })
    // show detail modal when detail button clicked
    $('#data-penanggung-jawab tbody').on('click', 'tr td button.btn-primary', function(e) {
        e.preventDefault();

        const rowData = table.row($(this).parent().parent()).data();
        const itemId = parseInt($(rowData[1].substring(0, rowData[1].indexOf('>')+1)).val());
        
        $.ajax({
            type: 'GET',
            url: baseApiUrl+'/'+itemId,
            dataType: 'json',
            headers: {
                'Authorization': 'Bearer ' + accessToken,
                'X-Requested-With': 'XMLHttpRequest'
            },
            success: function(res) {
                // console.log(res);
                if (res.data) {
                    for (const [key, value] of Object.entries(res.data)) {
                        // console.log(key, value)
                        $('#data-detail').append(
                            `
                            <dt class="col-sm-4">${key}</dt>
                            <dd id="show-name" class="col-sm-8">${value == null ? '-' : value}</dd>
                            `
                        );
                    }
                }

                $('#modal-show-penanggung-jawab').modal('toggle');
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

    // create
    $('#form-add-penanggung-jawab').validate({
        submitHandler: function(form, event) {
            event.preventDefault();

            const newData = {
                "nama": $(form).find('input#nama').val(),
                "nip": $(form).find('input#nip').val(),
                "pangkat_golongan": $(form).find('input#pangkat_golongan').val(),
                "jabatan": $(form).find('input#jabatan').val()
            };
            
            $.ajax({
                type: 'POST',
                url: baseApiUrl,
                dataType: 'json',
                contentType: 'application/json',
                data: JSON.stringify(newData),
                headers: { 'Authorization': 'Bearer ' + accessToken, 'X-Requested-With': 'XMLHttpRequest' },
                success: function(res) {
                    console.log(res);

                    Swal.fire({
                        icon: 'success',
                        title: 'Data telah ditambahkan!',
                        showConfirmButton: true,
                        timer: 2000
                    });

                    setTimeout(() => {
                        $('#modal-add-penanggung-jawab').modal('toggle');

                        $(form).find('input#nama').val('');
                        $(form).find('input#nip').val('');
                        $(form).find('input#pangkat_golongan').val('');
                        $(form).find('input#jabatan').val('');

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
            nama: { required: true },
            nip: { required: true },
            pangkat_golongan: { required: true },
            jabatan: { required: true }
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

    // send edit data to modal edit after this button clicked
    $('#data-penanggung-jawab tbody').on('click', 'tr td button.btn-info', function(e) {
        e.preventDefault();

        const itemId = $(this).data().itemId;
        const rowData = table.row($(this).parent().parent()).data();
        console.log(rowData);
        $('input#edit_id').val(parseInt($(rowData[1].substring(0, rowData[1].indexOf('>')+1)).val()));
        $('input#edit_nama').val(rowData[2]);
        $('input#edit_nip').val(rowData[3]);
        $('input#edit_pangkat_golongan').val(rowData[4]);
        $('input#edit_jabatan').val(rowData[5]);

        $('#modal-edit-penanggung-jawab').modal('toggle');
    });

    // edit
    $('#form-edit-penanggung-jawab').validate({
        submitHandler: function(form, event) {
            event.preventDefault();
            const itemId = $(form).find('input#edit_id').val();
            const updatedData = {
                "nama": $(form).find('input#edit_nama').val(),
                "nip": $(form).find('input#edit_nip').val(),
                "pangkat_golongan": $(form).find('input#edit_pangkat_golongan').val(),
                "jabatan": $(form).find('input#edit_jabatan').val()
            };
            
            $.ajax({
                type: 'PUT',
                url: baseApiUrl + '/' + itemId + '/update',
                dataType: 'json',
                contentType: 'application/json',
                data: JSON.stringify(updatedData),
                headers: { 'Authorization': 'Bearer ' + accessToken, 'X-Requested-With': 'XMLHttpRequest' },
                success: function(res) {
                    console.log(res);

                    Swal.fire({
                        icon: 'success',
                        title: 'Data telah diubah!',
                        showConfirmButton: true,
                        timer: 2000
                    });

                    setTimeout(() => {
                        $('#modal-edit-penanggung-jawab').modal('toggle');
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
            });
        },
        rules: { 
            nama: { required: true },
            nip: { required: true },
            pangkat_golongan: { required: true },
            jabatan: { required: true }
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

    // delete - show confirmation to delete the selected row
    $('#data-penanggung-jawab tbody').on('click', 'tr td button.btn-danger', function(e) {
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

    // delete - show confirmation to delete all selected user
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