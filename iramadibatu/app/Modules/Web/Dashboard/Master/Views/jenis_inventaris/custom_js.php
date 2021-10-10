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
    const table = $('#data_jenis_inventaris').DataTable({
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
            const dataUrl = '<?=site_url('api/v1/dashboard/master/jenis_inventaris/datatables')?>';

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

    if ($('#form_added_data').find('tbody').children().length == 0) {
        $('#form_added_data').append(`<tr><td class="text-center" colspan="5">tidak ada data.</td></tr>`);
    }

    // add data
    let addedData = [];

    $('#form_added_data tbody').on('click', 'tr td button.btn-danger', function(e) {
        e.preventDefault();

        if ($(this).parent().parent().parent().children().length == 1) {
            $(this).parent().parent().parent().append(`<tr><td class="text-center" colspan="5">tidak ada data.</td></tr>`);
        }

        $(this).parent().parent().remove();
    });

    $('#form_add_jenis_inventaris').validate({
        submitHandler: function(form, event) {
            event.preventDefault();

            if ($($('#form_added_data').find('tbody').children()[0]).children().length == 1) {
                $('#form_added_data').find('tbody').empty();
            }
            
            let number = $('#form_added_data').find('tbody').children().length;
            const newData = {
                "number": number,
                "name": $(form).find('input#name').val(),
                "desc": $(form).find('textarea#desc').val(),
                "is_active": $(form).find('input#is_active').is(':checked')
            };

            $('#form_added_data tbody').append(
                `
                <tr>
                    <td>${number+1}.</td>
                    <td>${newData.name}</td>
                    <td>${newData.desc}</td>
                    <td>${newData.is_active ? 'Aktif' : 'Tidak Aktif'}</td>
                    <td class="text-center"><button type="button" data-number="${number}" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button></td>
                </tr>
                `
            );

            addedData.push(newData);

            console.log(addedData);
            return;

            const createUrl = '<?=site_url('api/dashboard/inventory-types')?>';
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

    $('#form_add_jenis_inventaris').find('#section-table-added').hide();
    $('#form_add_jenis_inventaris').find('#btn-submit-all').hide();
    $('input#is_single_insert').on('change', function(e) {
        if ($(this).is(':checked')) {
            $('#form_add_jenis_inventaris').find('#section-table-added').show();
            $('#form_add_jenis_inventaris').find('#btn-submit-all').show();
            $(this).next().text('Multi-Insert');
        } else {
            $('#form_add_jenis_inventaris').find('#section-table-added').hide();
            $('#form_add_jenis_inventaris').find('#btn-submit-all').hide();
            $(this).next().text('Single-Insert');
        }
    });

    $('#btn-submit-all').click(function(e) {
        e.preventDefault();

        console.log('clicked');
    });
});
</script>
<?=$this->endSection()?>