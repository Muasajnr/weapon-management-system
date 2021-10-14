<?=$this->section('custom-js')?>

<script>
const baseApiUrl = '<?=site_url('api/v1/dashboard/users')?>';
const datatableColumns = [
    { "targets": 0, "orderable": false, "searchable": false },
    { "targets": 1, "orderable": false, "searchable": false },
    { "targets": 2, "orderable": true, "searchable": true },
    { "targets": 3, "orderable": true, "searchable": true },
    { "targets": 4, "orderable": true, "searchable": true },
    { "targets": 5, "orderable": true, "searchable": true },
    { "targets": 6, "orderable": true },
    { "targets": 7, "orderable": true },
    { "targets": 8, "orderable": false }
];
</script>

<script>
$(function() {
    // handles datatable
    const table = $('#data_users').DataTable({
        "dom": 'lrtip',
        "searching": true,
        "responsive": true,
        "pageLength": 25,
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": function (data, callback, settings) {
            const dataUrl = baseApiUrl + '/datatables';

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
        "columns": datatableColumns,
        "drawCallback": function(settings) {
            if ($('#checkAll').is(":checked")) {
                $('.multi_delete').prop('checked', true);
            } else {
                $('.multi_delete').prop('checked', false);
            }
        }
    });

    // multi delete checkboxes
    $('#checkAll').click(function(e) {
        if ($(this).is(":checked")) {
            $('.multi_delete').prop('checked', true);
        } else {
            $('.multi_delete').prop('checked', false);
        }
    });

    // handle adding data
    $('#form_add_user').validate({
        submitHandler: function(form, event) {
            event.preventDefault();

            const newData = {
                "fullname": $(form).find('input#fullname').val(),
                "username": $(form).find('input#username').val(),
                "email": $(form).find('input#email').val(),
                "password": $(form).find('input#password').val(),
                "level": $(form).find('select#level option:selected').val()
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
                        $('#modal_add_user').modal('toggle');

                        $(form).find('input#fullname').val(''),
                        $(form).find('input#username').val(''),
                        $(form).find('input#email').val(''),
                        $(form).find('input#password').val(''),
                        $(form).find('input#repassword').val('')

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
            fullname: { required: true },
            username: { required: true },
            email: { required: true },
            password: { required: true },
            repassword: { required: true, equalTo: '#password' },
            level: { required: true },
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

    // reset show modal when the model dismissed
    $('#modal_show_user').on('hidden.bs.modal', function (e) {
        $('#data-detail tbody').html('');
    })

    // show detail modal when detail button clicked
    $('#data_users tbody').on('click', 'tr td button.btn-primary', function(e) {
        e.preventDefault();

        const rowData = table.row($(this).parent().parent()).data();
        const itemId = parseInt($(rowData[1].substring(0, rowData[1].indexOf('>')+1)).val());
        
        $.ajax({
            type: 'GET',
            url: baseApiUrl+'/'+itemId,
            dataType: 'json',
            headers: {
                'Authorization': 'Bearer ' + accessToken
            },
            success: function(res) {
                if (res.data) {
                    for (const [key, value] of Object.entries(res.data)) {
                        console.log(key, value)
                        $('#data_detail').append(
                            `
                            <dt class="col-sm-4">${key}</dt>
                            <dd id="show-name" class="col-sm-8">${value == null ? '-' : value}</dd>
                            `
                        );
                    }
                }

                $('#modal_show_user').modal('toggle');
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

    // show edit password modal when password edit button clicked
    $('#data_users tbody').on('click', 'tr td button.btn-warning', function(e) {
        e.preventDefault();

        const rowData = table.row($(this).parent().parent()).data();
        $('input#edit_password_id').val(parseInt($(rowData[1].substring(0, rowData[1].indexOf('>')+1)).val()));

        $('#modal_edit_password_user').modal('toggle');
    });

    // validate & submit edit password form
    $('#form_edit_password_user').validate({
        submitHandler: function(form, event) {
            event.preventDefault();

            const itemId = $(form).find('input#edit_password_id').val();

            const updateData = {
                "password": $(form).find('input#edit_password_baru').val(),
                "confirm_password": $(form).find('input#edit_repassword_baru').val(),
            };

            $.ajax({
                type: 'PUT',
                url: baseApiUrl + '/' + itemId + '/update_password',
                dataType: 'json',
                data: JSON.stringify(updateData),
                contentType: 'application/json',
                headers: { 'Authorization': 'Bearer ' + accessToken, 'X-Requested-With': 'XMLHttpRequest' },
                success: function(res) {
                    console.log(res);

                    Swal.fire({
                        icon: 'success',
                        title: 'Password telah diubah!',
                        showConfirmButton: true,
                        timer: 2000
                    });

                    setTimeout(() => {

                        $('input#edit_password_baru').val('');
                        $('input#edit_repassword_baru').val('');

                        $('#modal_edit_password_user').modal('toggle');
                        table.ajax.reload();
                    }, 2000);
                },
                error: function(err) {
                    console.log(err);

                    Swal.fire({
                        icon: 'error',
                        title: 'Password gagal diubah!',
                        text: err.responseJSON.message,
                        showConfirmButton: true,
                        timer: 2000
                    });
                }
            });
        },
        rules: {
            fullname: { required: true },
            username: { required: true },
            email: { required: true },
            level: { required: true }
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
    $('#data_users tbody').on('click', 'tr td button.btn-info', function(e) {
        e.preventDefault();

        const itemId = $(this).data().itemId;
        const rowData = table.row($(this).parent().parent()).data();
        
        $('input#edit_id').val(parseInt($(rowData[1].substring(0, rowData[1].indexOf('>')+1)).val()));
        $('input#edit_fullname').val(rowData[2]);
        $('input#edit_username').val(rowData[3]);
        $('input#edit_email').val(rowData[4]);
        $('select#edit_level').val(rowData[5].substring(rowData[5].indexOf('>')+1));

        $('#modal_edit_user').modal('toggle');
    });

    // validate & submit the edit form
    $('#form_edit_user').validate({
        submitHandler: function(form, event) {
            event.preventDefault();

            const itemId = $(form).find('input#edit_id').val();

            const updateData = {
                "fullname": $(form).find('input#edit_fullname').val(),
                "username": $(form).find('input#edit_username').val(),
                "email": $(form).find('input#edit_email').val(),
                "level": $(form).find('select#edit_level option:selected').val()
            };

            $.ajax({
                type: 'PUT',
                url: baseApiUrl + '/' + itemId + '/update',
                dataType: 'json',
                data: JSON.stringify(updateData),
                contentType: 'application/json',
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
                        $('#modal_edit_user').modal('toggle');
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
            fullname: { required: true },
            username: { required: true },
            email: { required: true },
            level: { required: true }
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

    // show confirmation to delete the selected row
    $('#data_users tbody').on('click', 'tr td button.btn-danger', function(e) {
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

    // show confirmation to delete all selected user
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
        
        if (searchQuery !== '') {
            table.search(searchQuery).draw();
        }
    });
});
</script>

<?=$this->endSection()?>