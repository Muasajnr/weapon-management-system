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
    // checkAll
    $('#checkAll').click(function(e) {
        if ($(this).is(":checked")) {
            $('.multi_delete').prop('checked', true);
        } else {
            $('.multi_delete').prop('checked', false);
        }
    });

    // handles datatable
    const table = $('#data-merk-sarana').DataTable({
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
            const dataUrl = '<?=site_url('api/v1/dashboard/master/merk_sarana/datatables')?>';

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
            }
        ],
    });

    $('#form-add-merk-sarana').validate({
        submitHandler: function(form, event) {
            event.preventDefault();

            // if ($($('#form_added_data').find('tbody').children()[0]).children().length == 1) {
            //     $('#form_added_data').find('tbody').empty();
            // }
            
            const newData = {
                "name": $(form).find('input#name').val(),
                "desc": $(form).find('textarea#desc').val(),
                "is_active": $(form).find('input#is_active').is(':checked') ? 1 : 0
            };

            // let number = $('#form_added_data').find('tbody').children().length;
            // $('#form_added_data tbody').append(
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
            // console.log(newData)
            // return;

            const createUrl = '<?=site_url('api/v1/dashboard/master/merk_sarana')?>';
            $.ajax({
                type: 'POST',
                url: createUrl,
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
                        $('#modal-add-merk-sarana').modal('toggle');

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

    // $('#form_add_jenis_inventaris').find('#section-table-added').hide();
    // $('#form_add_jenis_inventaris').find('#btn-submit-all').hide();
    // $('input#is_single_insert').on('change', function(e) {
    //     if ($(this).is(':checked')) {
    //         $('#form_add_jenis_inventaris').find('#section-table-added').show();
    //         $('#form_add_jenis_inventaris').find('#btn-submit-all').show();
    //         $(this).next().text('Multi-Insert');
    //     } else {
    //         $('#form_add_jenis_inventaris').find('#section-table-added').hide();
    //         $('#form_add_jenis_inventaris').find('#btn-submit-all').hide();
    //         $(this).next().text('Single-Insert');
    //     }
    // });

    // $('#btn-submit-all').click(function(e) {
    //     e.preventDefault();

    //     console.log('clicked');
    // });
    /** end of add stuff */

    /** start of show stuff */
    $('#modal-show-merk-sarana').on('hidden.bs.modal', function (e) {
        $('#data-detail').html('');
    })
    $('#data-merk-sarana tbody').on('click', 'tr td button.btn-primary', function(e) {
        e.preventDefault();

        const rowData = table.row($(this).parent().parent()).data();
        const itemId = parseInt($(rowData[1].substring(0, rowData[1].indexOf('>')+1)).val());
        
        $.ajax({
            type: 'GET',
            url: '<?=site_url('api/v1/dashboard/master/merk_sarana/')?>'+itemId,
            dataType: 'json',
            headers: {
                'Authorization': 'Bearer ' + accessToken
            },
            success: function(res) {
                console.log(res);

                if (res.data) {
                    for (const [key, value] of Object.entries(res.data)) {
                        $('#data-detail').append(
                            `
                            <dt class="col-sm-4">${key}</dt>
                            <dd id="show-name" class="col-sm-8">${value == null ? '-' : value}</dd>
                            `
                        );
                    }
                }

                $('#modal-show-merk-sarana').modal('toggle');
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
    /** end of show stuff */

    /** start of edit stuff */
    $('#data-merk-sarana tbody').on('click', 'tr td button.btn-info', function(e) {
        e.preventDefault();

        const itemId = $(this).data().itemId;
        const rowData = table.row($(this).parent().parent()).data();

        $('#edit_id').val(parseInt($(rowData[1].substring(0, rowData[1].indexOf('>')+1)).val()));
        $('#edit_name').val(rowData[2]);
        $('#edit_desc').val(rowData[3]);
        $('#edit_is_active').prop('checked', $(rowData[4]).find('input').is(':checked'));

        $('#modal-edit-merk-sarana').modal('toggle');
    });

    $('#data-jenis-sarana tbody').on('change', 'tr input[type="checkbox"][name="is_active"]', function(e) {
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
                const updateUrl = '<?=site_url('api/v1/dashboard/master/merk_sarana/')?>' + itemId + '/set_status';

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

    $('#form-edit-merk-sarana').validate({
        submitHandler: function(form, event) {
            event.preventDefault();
            const itemId = $(form).find('input#edit-id').val();
            const updateData = {
                "name": $(form).find('input#edit-name').val(),
                "desc": $(form).find('textarea#edit-desc').val(),
                "is_active": $(form).find('input#edit-is-active').is(':checked') ? 1 : 0
            };
            
            const updateUrl = '<?=site_url('api/v1/dashboard/master/merk_sarana/')?>' + itemId + '/update';

            $.ajax({
                type: 'PUT',
                url: updateUrl,
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
                        $('#modal-edit-merk-sarana').modal('toggle');
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
    /** end of edit stuff */

    /** start of delete stuff */
    $('#data-merk-sarana tbody').on('click', 'tr td button.btn-danger', function(e) {
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
                const deleteUrl = '<?=site_url('api/v1/dashboard/master/merk_sarana/')?>' + itemId + '/delete';

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
                    const deleteUrl = '<?=site_url('api/v1/dashboard/master/merk_sarana/delete/multiple')?>';
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
    /** end of delete stuff */
});
</script>
<?=$this->endSection()?>