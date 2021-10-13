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

    /** start of add */
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
    /** end of add */

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
        console.log(itemId);

        $('#modal_edit_password_user').modal('toggle');
        // $.ajax({
        //     type: 'GET',
        //     url: '<?=site_url('api/v1/dashboard/users/')?>'+itemId+'/change_password',
        //     dataType: 'json',
        //     headers: {
        //         'Authorization': 'Bearer ' + accessToken
        //     },
        //     success: function(res) {
        //         console.log(res);

        //         $('#modal-show-jenis-sarana').modal('toggle');
        //     },
        //     error: function(err) {
        //         console.log(err);

        //         Swal.fire({
        //             icon: 'error',
        //             title: 'Data gagal ditampilkan!',
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

        // $('#edit_id').val(parseInt($(rowData[1].substring(0, rowData[1].indexOf('>')+1)).val()));
        // $('#edit_name').val(rowData[2]);
        // $('#edit_desc').val(rowData[3]);
        // $('#edit_is_active').prop('checked', $(rowData[4]).find('input').is(':checked'));

        $('#modal_edit_user').modal('toggle');
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