<?=$this->section('custom-js')?>
<script>
$(function() {
    $('#checkAll').click(function(e) {
        if ($(this).is(":checked")) {
            $('.multi_delete').prop('checked', true);
        } else {
            $('.multi_delete').prop('checked', false);
        }
    });
    
    // handles datatable
    const table = $('#data_users').DataTable({
        // "dom": '<"top"i>rt<"bottom"><"clear">',
        "searching": false,
        "responsive": true,
        "drawCallback": function(settings) {
            if ($('#checkAll').is(":checked")) {
                $('.multi_delete').prop('checked', true);
            } else {
                $('.multi_delete').prop('checked', false);
            }
        },
        "pageLength": 25,
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": function(data, callback, settings) {
            const dataUrl = '<?=site_url('api/v1/dashboard/users/datatables')?>';

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





    /*************************************************
    *             START OF HANDLE ADD
    *************************************************/
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

            const createUrl = '<?=site_url('api/v1/dashboard/users')?>';
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
            fullname: {
                required: true
            },
            username: {
                required: true
            },
            email: {
                required: true
            },
            password: {
                required: true
            },
            repassword: {
                required: true,
                equalTo: '#password'
            },
            level: {
                required: true
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
    /*************************************************
    *             END OF HANDLE ADD
    *************************************************/




    /*************************************************
    *             START OF HANDLE SHOW
    *************************************************/
    $('#modal-show-jenis-sarana').on('hidden.bs.modal', function (e) {
        $('#data-detail').html('');
    })
    $('#data-jenis-sarana tbody').on('click', 'tr td button.btn-primary', function(e) {
        e.preventDefault();

        const rowData = table.row($(this).parent().parent()).data();
        const itemId = parseInt($(rowData[1].substring(0, rowData[1].indexOf('>')+1)).val());
        
        $.ajax({
            type: 'GET',
            url: '<?=site_url('api/v1/dashboard/master/jenis_sarana/')?>'+itemId,
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

                $('#modal-show-jenis-sarana').modal('toggle');
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
    /*************************************************
    *             END OF HANDLE SHOW
    *************************************************/






    /*************************************************
    *             START OF HANDLE EDIT
    *************************************************/

    /** edit password */
    $('#data_users tbody').on('click', 'tr td button.btn-warning', function(e) {
        e.preventDefault();

        const rowData = table.row($(this).parent().parent()).data();
        const itemId = parseInt($(rowData[1].substring(0, rowData[1].indexOf('>')+1)).val());

        // $.ajax({
        //     type: 'GET',
        //     url: '<?=site_url('api/v1/dashboard/users/')?>'+itemId+'/change_password',
        //     dataType: 'json',
        //     headers: {
        //         'Authorization': 'Bearer ' + accessToken
        //     },
        //     success: function(res) {
        //         console.log(res);

        //         $('#modal_edit_password_user').modal('toggle');
        //     },
        //     error: function(err) {
        //         console.log(err);

        //         Swal.fire({
        //             icon: 'error',
        //             title: 'Gagal ditampilkan!',
        //             text: err.responseJSON.message,
        //             showConfirmButton: true,
        //             timer: 2000
        //         });
        //     }
        // });
    });

    /** send edit data to modal edit after this button clicked*/
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

    $('#form-edit-merk-sarana').validate({
        submitHandler: function(form, event) {
            event.preventDefault();
            const itemId = $(form).find('input#edit_id').val();
            const updateData = {
                "fullname": $(form).find('input#edit_fullname').val(),
                "username": $(form).find('input#edit_username').val(),
                "email": $(form).find('input#edit_email').val(),
                "level": $(form).find('select#edit_level option:selected').val()
            };
            
            const updateUrl = '<?=site_url('api/v1/dashboard/users/')?>' + itemId + '/update';

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
            fullname: {
                required: true
            },
            username: {
                required: true
            },
            email: {
                required: true
            },
            level: {
                required: true
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
    /** handle form edit submission */

    /*************************************************
    *             END OF HANDLE EDIT
    *************************************************/

    /** start of delete */

    /** end of delete */
});
</script>

<?=$this->endSection()?>