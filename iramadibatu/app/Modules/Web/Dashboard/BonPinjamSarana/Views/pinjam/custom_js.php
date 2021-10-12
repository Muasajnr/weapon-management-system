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
    // checkAll
    $('#checkAll').click(function(e) {
        if ($(this).is(":checked")) {
            $('.multi_delete').prop('checked', true);
        } else {
            $('.multi_delete').prop('checked', false);
        }
    });

    // handles datatable
    const table = $('#data_pinjam').DataTable({
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
            const dataUrl = '<?=site_url('api/v1/dashboard/bon_simpan_pinjam/pinjam/datatables')?>';

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

    /** start of handle edit */
    $('#data_pinjam tbody').on('click', 'tr td button.btn-info', function(e) {
        e.preventDefault();

        const rowData = table.row($(this).parent().parent()).data();
        const itemId = parseInt($(rowData[1].substring(0, rowData[1].indexOf('>')+1)).val());
        console.log(itemId);
        // $.ajax({
        //     type: 'GET',
        //     url: '<?=site_url('api/v1/dashboard/berita_acara/')?>'+itemId,
        //     dataType: 'json',
        //     headers: {
        //         'Authorization': 'Bearer ' + accessToken
        //     },
        //     success: function(res) {
        //         console.log(res);

        //         if (res.data) {
                    
        //         }

                $('#modal_edit_pinjam').modal('toggle');
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
    /** end of handle edit */

    /** start of handle delete */
    $('#data_pinjam tbody').on('click', 'tr td button.btn-danger', function(e) {
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

                // $.ajax({
                //     type: 'DELETE',
                //     url: deleteUrl,
                //     headers: {
                //         'Authorization': 'Bearer ' + accessToken
                //     },
                //     success: function(res) {
                //         console.log(res);
                //         Swal.fire(
                //             'Terhapus!',
                //             'Data telah terhapus!',
                //             'success'
                //         )
                //         table.ajax.reload();
                //     },
                //     error: function(err) {
                //         console.log(err.responseJSON);
                //         Swal.fire(
                //             'Gagal!',
                //             'Data gagal terhapus!',
                //             'error'
                //         )
                //     }
                // })
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

                    // $.ajax({
                    //     type: 'DELETE',
                    //     url: deleteUrl,
                    //     data: JSON.stringify(idsData),
                    //     contentType: 'application/json',
                    //     headers: {
                    //         'Authorization': 'Bearer ' + accessToken
                    //     },
                    //     success: function(res) {
                    //         console.log(res);
                    //         Swal.fire(
                    //             'Terhapus!',
                    //             selectedRows.length + ' data telah terhapus!',
                    //             'success'
                    //         )
                    //         table.ajax.reload();
                    //     },
                    //     error: function(err) {
                    //         console.log(err.responseJSON);
                    //         Swal.fire(
                    //             'Gagal!',
                    //             'Data menghapus '+selectedRows.length+' data!',
                    //             'error'
                    //         )
                    //     }
                    // })
                }
            });
        }
    });
    /** end of handle delete */
});
</script>

<?=$this->endSection()?>