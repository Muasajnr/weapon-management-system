<?=$this->section('custom-js')?>
<script>
$(function() {
    const baseApiUrl = '<?=site_url('api/v1/dashboard/master/jenis_inventaris')?>';
    const datatableColumns = [
        { "targets": 0, "orderable": false, "searchable": false },
        { "targets": 1, "orderable": false, "searchable": false },
        { "targets": 2, "orderable": true, "searchable": true },
        { "targets": 3, "orderable": false, "searchable": false },
        { "targets": 4, "orderable": false, "searchable": false },
        { "targets": 5, "orderable": true, "searchable": true, },
        { "targets": 6, "orderable": false, }
    ];

    // handles datatable
    const table = $('#data_jenis_inventaris').DataTable({
        "dom": 'lrtip',
        "responsive": true,
        "searching": true,
        "pageLength": 25,
        "processing": true,
        "serverSide": true,
        "order": [],
        "columns": datatableColumns,
        "drawCallback": function(settings) {
            if ($('#checkAll').is(":checked")) {
                $('.multi_delete').prop('checked', true);
            } else {
                $('.multi_delete').prop('checked', false);
            }
        },
        "ajax": function(data, callback, settings) {
            const dataUrl = `${baseApiUrl}/datatables`;

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
        }
    });

    // validate & submit new jenis_inventaris
    $('#form_add_jenis_inventaris').validate({
        submitHandler: function(form, event) {
            event.preventDefault();
            
            const newData = {
                "name": $(form).find('input#name').val(),
                "desc": $(form).find('textarea#desc').val(),
                "is_active": $(form).find('input#is_active').is(':checked') ? 1 : 0
            };

            $.ajax({
                type: 'POST',
                url: baseApiUrl,
                dataType: 'json',
                data: newData,
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
                        $('#modal_add_jenis_inventaris').modal('toggle');

                        $(form).find('input#name').val('');
                        $(form).find('textarea#desc').val('');
                        $(form).find('input#is_active').prop('checked', false);

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
            name: { required: true },
            desc: { required: true }
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

    // clear detail modal when modal dismissed
    $('#modal_show_jenis_inventaris').on('hidden.bs.modal', function (e) {
        $('#data_detail').html('');
    })

    // show modal & the data
    $('#data_jenis_inventaris tbody').on('click', 'tr td button.btn-primary', function(e) {
        e.preventDefault();

        const rowData = table.row($(this).parent().parent()).data();
        const itemId = parseInt($(rowData[1].substring(0, rowData[1].indexOf('>')+1)).val());
        
        $.ajax({
            type: 'GET',
            url: `${baseApiUrl}/${itemId}`,
            dataType: 'json',
            headers: {
                'Authorization': 'Bearer ' + accessToken
            },
            success: function(res) {
                console.log(res);

                if (res.data) {
                    for (const [key, value] of Object.entries(res.data)) {
                        $('#data_detail').append(
                            `
                            <dt class="col-sm-4">${key}</dt>
                            <dd id="show-name" class="col-sm-8">${value == null ? '-' : value}</dd>
                            `
                        );
                    }
                }

                $('#modal_show_jenis_inventaris').modal('toggle');
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

    // change active status of the row
    $('#data_jenis_inventaris tbody').on('change', 'tr input[type="checkbox"][name="is_active"]', function(e) {
        e.preventDefault();
        
        const checkedValue = this.checked;
        const $currChecked = $(this);

        const itemId = $(this).data().itemId;

        Swal.fire({
            title: 'Anda yakin?',
            text: `Anda akan mengubah data ini menjadi ${checkedValue ? 'Aktif' : 'Non-Aktif'}.`,
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Iya, ganti!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'PUT',
                    url: `${baseApiUrl}/${itemId}/set_status`,
                    dataType: 'json',
                    data: JSON.stringify({
                        "is_active": this.checked ? 1 : 0
                    }),
                    contentType: 'application/json',
                    headers: {
                        'Authorization': 'Bearer ' + accessToken,
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    success: function(res) {
                        console.log(res);
                        Swal.fire(
                            'Terupdate!',
                            'Status telah diperbaharui!',
                            'success'
                        )
                        table.ajax.reload()
                    },
                    error: function(err) {
                        console.log(err);
                        $currChecked.prop('checked', !checkedValue);
                        Swal.fire(
                            'Gagal!',
                            'Status gagal diubah!',
                            'error'
                        )
                    }
                })
            } else {
                $currChecked.prop('checked', !checkedValue);
            }
        });
    });

    // set edit data to modal form when the button row clicked & open the modal 
    $('#data_jenis_inventaris tbody').on('click', 'tr td button.btn-info', function(e) {
        e.preventDefault();

        const itemId = $(this).data().itemId;
        const rowData = table.row($(this).parent().parent()).data();

        $('#edit-id').val(parseInt($(rowData[1].substring(0, rowData[1].indexOf('>')+1)).val()));
        $('#edit-name').val(rowData[2]);
        $('#edit-desc').val(rowData[3]);
        $('#edit-is-active').prop('checked', $(rowData[4]).find('input').is(':checked'));

        $('#modal_edit_jenis_inventaris').modal('toggle');
    });

    // validate & submit edit form data
    $('#form_edit_jenis_inventaris').validate({
        submitHandler: function(form, event) {
            event.preventDefault();
            const itemId = $(form).find('input#edit-id').val();
            const updateData = {
                "name": $(form).find('input#edit-name').val(),
                "desc": $(form).find('textarea#edit-desc').val(),
                "is_active": $(form).find('input#edit-is-active').is(':checked') ? 1 : 0
            };

            $.ajax({
                type: 'PUT',
                url: `${baseApiUrl}/${itemId}/update`,
                dataType: 'json',
                data: JSON.stringify(updateData),
                contentType: 'application/json',
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
                        $('#modal_edit_jenis_inventaris').modal('toggle');
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
            name: { required: true },
            desc: { required: true }
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

    // confirm a row deletion
    $('#data_jenis_inventaris tbody').on('click', 'tr td button.btn-danger', function(e) {
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
                        'Authorization': 'Bearer ' + accessToken
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

    // check all rows
    $('#checkAll').click(function(e) {
        if ($(this).is(":checked")) {
            $('.multi_delete').prop('checked', true);
        } else {
            $('.multi_delete').prop('checked', false);
        }
    });

    // deleted selected rows
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
                            'X-Requested-With': 'XMLHttpRequest',
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
        
        if (searchQuery !== '') {
            table.search(searchQuery).draw();
        }
    });
});
</script>
<?=$this->endSection()?>