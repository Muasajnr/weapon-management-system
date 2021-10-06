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

<!-- moment js -->
<script src="<?=site_url('themes/AdminLTE/plugins/moment/moment.min.js')?>"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="<?=site_url('themes/AdminLTE/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')?>"></script>
<!-- jquery-validation -->
<script src="<?=site_url('themes/AdminLTE/plugins/jquery-validation/jquery.validate.min.js')?>"></script>
<script src="<?=site_url('themes/AdminLTE/plugins/jquery-validation/additional-methods.min.js')?>"></script>
<!-- bs-custom-file-input -->
<script src="<?=site_url('themes/AdminLTE/plugins/bs-custom-file-input/bs-custom-file-input.min.js')?>"></script>

<script>
$(function() {
    bsCustomFileInput.init()

    // checkAll
    $('#checkAll').click(function(e) {
        if ($(this).is(":checked")) {
            $('.multi_delete').prop('checked', true);
        } else {
            $('.multi_delete').prop('checked', false);
        }
    });

    // handles datatable
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
            const dtUrl = '<?=site_url('api/dashboard/beritaacara/datatables')?>';
            let result = null;

            $.ajax({
                type: 'POST',
                url: dtUrl,
                dataType: 'json',
                data: data,
                headers: {
                    'Authorization': 'Bearer ' + accessToken
                },
                success: function(res) {
                    console.log(res);
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
                "orderable": true,
                "searchable": true
            },
            {
                "targets": 4,
                "orderable": true,
                "searchable": true
            },
            {
                "targets": 5,
                "orderable": true,
                "searchable": true,
            },
            {
                "targets": 6,
                "orderable": true,
                "searchable": true,
            },
            {
                "targets": 8,
                "orderable": false,
                "orderable": false,
            }
        ],
    });

    $('#tanggal').datetimepicker({
        format: 'YYYY-MM-DD'
    });

    const dateObj = new Date();
    const currMonth = dateObj.getMonth()+1 < 10 ? '0'+(dateObj.getMonth()+1) : dateObj.getMonth()+1;
    const currDate = dateObj.getDate() < 10 ? '0'+dateObj.getDate() : dateObj.getDate();
    const currYear = dateObj.getFullYear();
    const nowTime = currYear + '-' + currMonth + '-' + currDate;
    $('#tanggal').find('input[name="tanggal"]').val(nowTime);

    $('#form-add-berita-acara').validate({
        submitHandler: function(form, event) {
            event.preventDefault();

            const newDoc = new FormData();
            newDoc.append('nama', $(form).find('#nama').val());
            newDoc.append('nomor', $(form).find('#nomor').val());
            newDoc.append('tanggal', $(form).find('#tanggal input[name="tanggal"]').val());
            newDoc.append('media', $(form).find('#media').get(0).files[0]);
            newDoc.append('keterangan', $(form).find('textarea[name="keterangan"]').val());

            newDoc.forEach(function(key, val) {
                console.log(key + ' => ' + val);
            });

            if ((newDoc.get('media').size / 1000) > 1600) {
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
                url: '<?=site_url('api/dashboard/beritaacara')?>',
                data: newDoc,
                dataType: 'json',
                mimeType: 'multipart/form-data',
                contentType: false,
                cache: false,
                processData: false,
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
                        $('#modal-add-berita-acara').modal('toggle');

                        $(form).find('input#nama').val('');
                        $(form).find('input#nomor').val('');
                        $(form).find('input#tanggal').val(nowTime);
                        $(form).find('#tanggal input[name="tanggal"]').val('');
                        $(form).find('textarea#deskripsi').val('');

                        table.ajax.reload();
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
            nama: {
                required: true
            },
            nomor: {
                required: true
            },
            tanggal: {
                required: true
            },
            media: {
                required: true,
                accept: 'image/png,image/jpeg,application/pdf'
            },
            keterangan: {
                required: true
            }
        },
        messages: {
            nama: {
                required: 'Nama berita acara tidak boleh kosong!'
            },
            nomor: {
                required: 'Nomor berita acara tidak boleh kosong!'
            },
            tanggal: {
                required: 'Tanggal berita acara tidak boleh kosong!'
            },
            media: {
                required: 'Media berita acara tidak boleh kosong!'
            },
            keterangan: {
                required: 'Keterangan tidak boleh kosong!'
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

    // handle delete data
    $('#data-documents tbody').on('click', 'tr td button.btn-danger', function(e) {
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
                const deleteUrl = '<?=site_url('api/dashboard/documents/')?>' + itemId + '/delete';

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
                    const deleteUrl = '<?=site_url('api/dashboard/documents/delete/multiple')?>';
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