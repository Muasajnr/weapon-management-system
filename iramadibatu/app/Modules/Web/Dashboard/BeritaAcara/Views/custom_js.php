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

<!-- moment js -->
<script src="<?=site_url('themes/AdminLTE/plugins/moment/moment.min.js')?>"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="<?=site_url('themes/AdminLTE/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')?>"></script>
<!-- bs-custom-file-input -->
<script src="<?=site_url('themes/AdminLTE/plugins/bs-custom-file-input/bs-custom-file-input.min.js')?>"></script>

<script>
$(function() {
    bsCustomFileInput.init()

    $('#tanggal').datetimepicker({
        format: 'YYYY-MM-DD'
    });

    const dateObj = new Date();
    const currMonth = dateObj.getMonth()+1 < 10 ? '0'+(dateObj.getMonth()+1) : dateObj.getMonth()+1;
    const currDate = dateObj.getDate() < 10 ? '0'+dateObj.getDate() : dateObj.getDate();
    const currYear = dateObj.getFullYear();
    const nowTime = currYear + '-' + currMonth + '-' + currDate;
    $('#tanggal').find('input[name="tanggal"]').val(nowTime);

    /** datatable */
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
    $('#form-add-berita-acara').validate({
        submitHandler: function(form, event) {
            event.preventDefault();

            const berita_acara = new FormData();
            berita_acara.append('nomor', $(form).find('input#nomor').val());
            berita_acara.append('judul', $(form).find('input#judul').val());
            berita_acara.append('tanggal', $(form).find('#tanggal input[name="tanggal"]').val());
            berita_acara.append('pihak_1_nama', $(form).find('input#pihak_1_nama').val());
            berita_acara.append('pihak_2_nama', $(form).find('input#pihak_2_nama').val());
            berita_acara.append('pihak_1_nip', $(form).find('input#pihak_1_nip').val());
            berita_acara.append('pihak_2_nip', $(form).find('input#pihak_2_nip').val());
            berita_acara.append('pihak_1_pangkat', $(form).find('input#pihak_1_pangkat').val());
            berita_acara.append('pihak_2_pangkat', $(form).find('input#pihak_2_pangkat').val());
            berita_acara.append('pihak_1_jabatan', $(form).find('input#pihak_1_jabatan').val());
            berita_acara.append('pihak_2_jabatan', $(form).find('input#pihak_2_jabatan').val());
            berita_acara.append('media', $(form).find('#media').get(0).files[0]);
            berita_acara.append('keterangan', $(form).find('textarea#keterangan').val());

            // berita_acara.forEach(function(key, val) {
            //     console.log(key + ' => ' + val);
            // });

            // return;
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
                url: '<?=site_url('api/v1/dashboard/berita_acara')?>',
                data: berita_acara,
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
            nomor: {
                required: true
            },
            judul: {
                required: true
            },
            tanggal: {
                required: true
            },
            pihak_1_nama: {
                required: true
            },
            pihak_2_nama: {
                required: true
            },
            pihak_1_nip: {
                required: true
            },
            pihak_2_nip: {
                required: true
            },
            pihak_1_pangkat: {
                required: true
            },
            pihak_2_pangkat: {
                required: true
            },
            pihak_1_jabatan: {
                required: true
            },
            pihak_2_jabatan: {
                required: true
            },
            media: {
                accept: 'image/png,image/jpeg,application/pdf'
            }
        },
        messages: {
            nomor: {
                required: 'Nomor berita acara tidak boleh kosong!'
            },
            judul: {
                required: 'Judul tidak boleh kosong!'
            },
            tanggal: {
                required: 'Tanggal harus diisi!'
            },
            pihak_1_nama: {
                required: 'Nama pihak 1 tidak boleh kosong!'
            },
            pihak_2_nama: {
                required: 'Nama pihak 2 tidak boleh kosong!'
            },
            pihak_1_nip: {
                required: 'Nip pihak 1 tidak boleh kosong!'
            },
            pihak_2_nip: {
                required: 'Nip pihak 1 tidak boleh kosong!'
            },
            pihak_1_pangkat: {
                required: 'Pangkat/Golongan pihak 1 tidak boleh kosong!'
            },
            pihak_2_pangkat: {
                required: 'Pangkat/Golongan pihak 1 tidak boleh kosong!'
            },
            pihak_1_jabatan: {
                required: 'Jabatan pihak 1 tidak boleh kosong!'
            },
            pihak_2_jabatan: {
                required: 'Jabatan pihak 1 tidak boleh kosong!'
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

    /** start of edit */
    $('#data-berita-acara tbody').on('click', 'tr td button.btn-info', function(e) {
        e.preventDefault();

        const rowData = table.row($(this).parent().parent()).data();
        const itemId = parseInt($(rowData[1].substring(0, rowData[1].indexOf('>')+1)).val());
        
        $.ajax({
            type: 'GET',
            url: '<?=site_url('api/v1/dashboard/berita_acara/')?>'+itemId,
            dataType: 'json',
            headers: {
                'Authorization': 'Bearer ' + accessToken
            },
            success: function(res) {
                console.log(res);

                if (res.data) {
                    
                }

                $('#modal_edit_berita_acara').modal('toggle');
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

    $('#form_edit_berita_acara').validate({
        submitHandler: function(form, event) {
            event.preventDefault();
            const itemId = $(form).find('input#edit_id').val();
            const updateData = {
                "name": $(form).find('input#edit_name').val(),
                "desc": $(form).find('textarea#edit_desc').val(),
                "is_active": $(form).find('input#edit_is_active').is(':checked') ? 1 : 0
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
            nomor: {
                required: true
            },
            judul: {
                required: true
            },
            tanggal: {
                required: true
            },
            pihak_1_nama: {
                required: true
            },
            pihak_2_nama: {
                required: true
            },
            pihak_1_nip: {
                required: true
            },
            pihak_2_nip: {
                required: true
            },
            pihak_1_pangkat: {
                required: true
            },
            pihak_2_pangkat: {
                required: true
            },
            pihak_1_jabatan: {
                required: true
            },
            pihak_2_jabatan: {
                required: true
            },
            media: {
                accept: 'image/png,image/jpeg,application/pdf'
            },
            keterangan: {
                required: true
            }
        },
        messages: {
            nomor: {
                required: 'Nomor berita acara tidak boleh kosong!'
            },
            judul: {
                required: 'Judul tidak boleh kosong!'
            },
            tanggal: {
                required: 'Tanggal harus diisi!'
            },
            pihak_1_nama: {
                required: 'Nama pihak 1 tidak boleh kosong!'
            },
            pihak_2_nama: {
                required: 'Nama pihak 2 tidak boleh kosong!'
            },
            pihak_1_nip: {
                required: 'Nip pihak 1 tidak boleh kosong!'
            },
            pihak_2_nip: {
                required: 'Nip pihak 1 tidak boleh kosong!'
            },
            pihak_1_pangkat: {
                required: 'Pangkat/Golongan pihak 1 tidak boleh kosong!'
            },
            pihak_2_pangkat: {
                required: 'Pangkat/Golongan pihak 1 tidak boleh kosong!'
            },
            pihak_1_jabatan: {
                required: 'Jabatan pihak 1 tidak boleh kosong!'
            },
            pihak_2_jabatan: {
                required: 'Jabatan pihak 1 tidak boleh kosong!'
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
    /** end of edit */

    /** start of delete */
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
                const deleteUrl = '<?=site_url('api/v1/dashboard/berita_acara/')?>' + itemId + '/delete';

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
                    const deleteUrl = '<?=site_url('api/v1/dashboard/berita_acara/delete/multiple')?>';
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
    /** end of delete */
});
</script>

<?=$this->endSection()?>