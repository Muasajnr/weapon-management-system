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

<!-- jquery-validation -->
<script src="<?=site_url('themes/AdminLTE/plugins/jquery-validation/jquery.validate.min.js')?>"></script>
<script src="<?=site_url('themes/AdminLTE/plugins/jquery-validation/additional-methods.min.js')?>"></script>

<script>
$(function() {
    const accessToken = localStorage.getItem(ACCESS_TOKEN_KEY);

    // checkAll
    $('#checkAll').click(function(e) {
        if ($(this).is(":checked")) {
            $('.multi_delete').prop('checked', true);
        } else {
            $('.multi_delete').prop('checked', false);
        }
    });

    // handles datatable
    const table = $('#data-inventory-types').DataTable({
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
            const inventoryTypesDataUrl = '<?=site_url('api/dashboard/inventory-types/datatables')?>';
            let result = null;

            $.ajax({
                type: 'POST',
                url: inventoryTypesDataUrl,
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
            }
        ],
    });
    
    // handles update status
    $('#data-inventory-types tbody').on('change', 'tr input[type="checkbox"][name="is_active"]', function(e) {
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
                const updateUrl = '<?=site_url('api/dashboard/inventory-types/')?>' + itemId + '/update/status';

                $.ajax({
                    type: 'PUT',
                    url: updateUrl,
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

    // handle create data
    $('#form-add-inventory-type').validate({
        submitHandler: function(form, event) {
            event.preventDefault();
            const newInventoryType = {
                "name": $(form).find('input#name').val(),
                "desc": $(form).find('textarea#desc').val(),
                "is_active": $(form).find('input#is_active').is(':checked')
            };
            
            const createNewInventoryTypeUrl = '<?=site_url('api/dashboard/inventory-types')?>';

            $.ajax({
                type: 'POST',
                url: createNewInventoryTypeUrl,
                dataType: 'json',
                data: newInventoryType,
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
                        $('#modal-add-new-inventory-type').modal('toggle');

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
            name: {
                required: true
            },
            desc: {
                required: true
            }
        },
        messages: {
            name: {
                required: 'Nama tidak boleh kosong!'
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

    // handle update data
    $('#form-edit-inventory-type').validate({
        submitHandler: function(form, event) {
            event.preventDefault();
            const itemId = $(form).find('input#edit_id').val();
            const newData = {
                "name": $(form).find('input#edit_name').val(),
                "desc": $(form).find('textarea#edit_desc').val(),
                "is_active": $(form).find('input#edit_is_active').is(':checked')
            };
            
            const updateUrl = '<?=site_url('api/dashboard/inventory-types/')?>' + itemId + '/update';

            $.ajax({
                type: 'PUT',
                url: updateUrl,
                dataType: 'json',
                data: JSON.stringify(newData),
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
                        $('#modal-edit-inventory-type').modal('toggle');
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
            name: {
                required: true
            },
            desc: {
                required: true
            }
        },
        messages: {
            name: {
                required: 'Nama tidak boleh kosong!'
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

    // handle show detail
    $('#data-inventory-types tbody').on('click', 'tr td button.btn-primary', function(e) {
        e.preventDefault();

        Swal.fire({
            icon: 'warning',
            title: 'Fitur belum tersedia!',
            showConfirmButton: true,
            timer: 2000
        });
    });

    // handle update data
    $('#data-inventory-types tbody').on('click', 'tr td button.btn-info', function(e) {
        e.preventDefault();

        const itemId = $(this).data().itemId;
        const rowData = table.row($(this).parent().parent()).data();

        $('#edit_id').val(parseInt($(rowData[1].substring(0, rowData[1].indexOf('>')+1)).val()));
        $('#edit_name').val(rowData[2]);
        $('#edit_desc').val(rowData[3]);
        $('#edit_is_active').prop('checked', $(rowData[4]).find('input').is(':checked'));

        $('#modal-edit-inventory-type').modal('toggle');
    });

    // handle delete data
    $('#data-inventory-types tbody').on('click', 'tr td button.btn-danger', function(e) {
        e.preventDefault();

        const inventoryTypeId = $(this).data().itemId;

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
                const deleteUrl = '<?=site_url('api/dashboard/inventory-types/')?>' + inventoryTypeId + '/delete';

                $.ajax({
                    type: 'DELETE',
                    url: deleteUrl,
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

    // handle multi delete
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
                    const deleteUrl = '<?=site_url('api/dashboard/inventory-types/delete/multiple')?>';
                    const ids = [];

                    selectedRows.each(function(index, item) {
                        ids.push($(item).data().itemId);
                    });

                    const idsData = {"ids": ids};

                    $.ajax({
                        type: 'DELETE',
                        url: deleteUrl,
                        data: JSON.stringify(idsData),
                        contentType: 'application/json',
                        headers: {
                            'Authorization': 'Bearer ' + accessToken
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
});
</script>
<?=$this->endSection()?>