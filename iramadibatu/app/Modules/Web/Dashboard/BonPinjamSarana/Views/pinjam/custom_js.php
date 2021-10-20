<?=$this->section('custom-js')?>
<!-- <script src="<?=site_url('assets/js/vendor/vuejs/vue.global.js')?>"></script> -->
<script>
// Vue.createApp({
//     data() {
//         return {
//             items: [
//                 { id: 1, nomor: '123456789', nama: 'Test Senjata', merk: '2020-GUN', total: 1 }
//             ]
//         }
//     }
// }).mount('#section_pinjam_sarana');
</script>
<script>
$(function() {
    const baseApiURL = '<?=site_url('api/v1/dashboard/bon_simpan_pinjam/pinjam')?>';
    const urlBeritaAcara = '<?=site_url('api/v1/dashboard/berita_acara')?>';
    const urlSaranaKeamanan = '<?=site_url('api/v1/dashboard/sarana_keamanan')?>';
    var lastNomorPeminjaman = '';

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
        "dom": 'lrtip',
        "pageLength": 25,
        "ajax": function(data, callback, settings) {
            $.ajax({
                type: 'POST',
                url: `${baseApiURL}/datatables`,
                dataType: 'json',
                data: data,
                headers: {
                    'Authorization': 'Bearer ' + accessToken,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                success: function(res) {
                    console.log(res);
                    callbackLastPeminjaman(res.lastNomorPeminjaman);
                    callback(res);
                },
                error: function(err) {
                    console.log(err);
                }
            });
        },
        "columns": [
            { "targets": 0, "orderable": false, "searchable": false },
            { "targets": 1, "orderable": false, "searchable": false },
            { "targets": 2, "orderable": true, "searchable": true },
            { "targets": 3, "orderable": false, "searchable": false },
            { "targets": 4, "orderable": false, "searchable": false },
            { "targets": 5, "orderable": true, "searchable": true },
            { "targets": 6, "orderable": false },
            { "targets": 7, "orderable": false },
            { "targets": 8, "orderable": false },
            { "targets": 9, "orderable": false }
        ],
    });

    // handle list berita acara
    $('#select2-data-berita-acara').select2({
        // allowClear: true,
        // minimumResultsForSearch: Infinity,
        placeholder: 'Pilih berita acara',
        theme: 'bootstrap4',
        escapeMarkup: function (markup) { return markup; },
        language: {
            noResults: function () {
                return `<button type="button" class="btn btn-sm btn-default" href="http://google.com/"><i class="fas fa-plus"></i>&nbsp;&nbsp;Tambah Berita Acara</button>`;
            }
        },
        ajax: {
            url: urlBeritaAcara,
            headers: {
                'Authorization': 'Bearer ' + accessToken,
                'X-Requested-With': 'XMLHttpRequest'
            },
            dataType: 'json',
            cache: true,
            processResults: function(data, params) {
                const results = [];
                data.data.forEach(function(item) {
                    results.push({
                        text: `<strong>${item.nomor}</strong> - ${item.nama}`,
                        id: item.id
                    });
                });

                return {
                    results: results
                }
            }
        }
    });

    // get all sarana_keamanan and put it on table adding form
    $.ajax({
        type: 'GET',
        url: urlSaranaKeamanan,
        dataType: 'json',
        headers: {
            'Authorization': 'Bearer ' + accessToken,
            'X-Requested-With': 'XMLHttpRequest',
        },
        success: function(res) {
            // console.log(res);

            if (res.data != null && res.data.length > 0) {
                res.data.forEach(function(item, index) {
                    $('#data_choose_pinjam tbody').append(
                        `
                        <tr style="display:table; width:100%; table-layout:fixed;">
                            <td width="40px">${index+1}</td>
                            <td width="120px">${item.nomor_sarana}</td>
                            <td>${item.tipe}</td>
                            <td>${item.nama} ${item.merk != null ? '<span class="text-bold">-</span> ' + item.merk : ''}</td>
                            <td>
                                <div>
                                    <input type="hidden" value="${item.id}">
                                    <input type="number" class="mr-1" value="0">
                                    <strong>of ${item.jumlah}</strong>
                                </div>
                            </td>
                            <td width="100px">
                                <button type="button" class="btn btn-warning btn-sm text-bold" 
                                    data-item-id="${item.id}" 
                                    data-item-jumlah="${item.jumlah}"
                                    data-item-nama="${item.nama}"
                                    data-item-merk="${item.merk}"
                                    data-item-tipe="${item.tipe}"
                                    data-item-nomor-sarana="${item.nomor_sarana}"
                                    >
                                    Pinjam
                                </button>
                            </td>
                        </tr>
                        `
                    );
                });
            }
        },
        error: function(err) {
            console.log(err);
        }
    })

    var recordedIds = [];
    // get event button click inside table #data_choose_pinjam rows
    $('#data_choose_pinjam tbody').on('click', 'tr td button.btn-warning', function(e) {
        var itemId = $(this).data('itemId');
        var itemJumlah = $(this).data('itemJumlah');
        var itemNama = $(this).data('itemNama');
        var itemMerk = $(this).data('itemMerk');
        var itemTipe = $(this).data('itemTipe');
        var itemNomorSarana = $(this).data('itemNomorSarana');
        var borrowCount = $(this).parent().prev().find('input[type="number"]').val();
        
        if (borrowCount == 0) {
            return;
        }

        if (borrowCount > itemJumlah) {
            Swal.fire({
                icon: 'error',
                title: 'Input Error',
                text: 'Jumlah terlalu besar!',
                showConfirmButton: true,
                timer: 2000
            });

            $(this).parent().prev().find('input[type="number"]').val(itemJumlah);
            return;
        }

        if (recordedIds.indexOf(itemId) !== -1) {
            Swal.fire({
                icon: 'error',
                title: 'Input Error',
                text: 'Data sudah ada!',
                showConfirmButton: true,
                timer: 2000
            });
            $(this).parent().prev().find('input[type="number"]').val(0);
            return;
        }

        var $recordArea = $('#form_add_pinjam').find('textarea[name="record_data_pinjam"]');
        var currentRecord = $recordArea.val();
        var newRecord = `${itemTipe} - ${itemNomorSarana} - ${itemNama} ${itemMerk != null ? itemMerk : ''} x ${borrowCount}\n`
        $recordArea.val(currentRecord + newRecord)

        // format (id, jumlah)
        var $hiddenIdsPinjam = $('#form_add_pinjam').find('input[name="ids_pinjam"]');
        var currentIds = $hiddenIdsPinjam.val();
        var newIds = `(${itemId}, ${borrowCount})`;
    
        if (currentIds.length != 0) {
            $hiddenIdsPinjam.val(currentIds + '|' + newIds);
        } else {
            $hiddenIdsPinjam.val(newIds);
        }
        recordedIds.push(itemId);
    });

    // clear pinjam records
    $('#form_add_pinjam').find('button.btn.btn-danger').click(function(e) {
        $(this).prev().val('');
        $('#form_add_pinjam').find('input[name="ids_pinjam"]').val('');
        recordedIds = [];
    });

    // handle adding form
    $('#form_add_pinjam').validate({
        submitHandler: function(form, event) {
            event.preventDefault();
            
            const newData = {
                "id_berita_acara": $(form).find('#select2-data-berita-acara option:selected').val(),
                "ids_pinjam": $(form).find('input[name="ids_pinjam"]').val(),
                "nomor_peminjaman": $(form).find('input[name="nomor_peminjaman"]').val(),
                "kode_peminjaman": $(form).find('input[name="kode_peminjaman"]').val()
            };
            // console.log(newData);
            // return;
            $.ajax({
                type: 'POST',
                url: baseApiURL,
                dataType: 'json',
                contentType: 'application/json',
                data: JSON.stringify(newData),
                headers: {
                    'Authorization': 'Bearer ' + accessToken,
                    'X-Requested-With': 'XMLHttpRequest'
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
                        $('#modal_add_pinjam').modal('toggle');

                        $(form).find('textarea[name="record_data_pinjam"]').val('');
                        $('#form_add_pinjam').find('input[name="ids_pinjam"]').val('');
                        recordedIds = [];

                        // table.ajax.reload();
                        location.reload();
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
            berita_acara: { required: true }, 
            ids_pinjam: { required: true } 
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

    /** start of handle edit */
    // $('#data_pinjam tbody').on('click', 'tr td button.btn-info', function(e) {
    //     e.preventDefault();

    //     const rowData = table.row($(this).parent().parent()).data();
    //     const itemId = parseInt($(rowData[1].substring(0, rowData[1].indexOf('>')+1)).val());
    //     console.log(itemId);
    //     // $.ajax({
    //     //     type: 'GET',
    //     //     url: '<?=site_url('api/v1/dashboard/berita_acara/')?>'+itemId,
    //     //     dataType: 'json',
    //     //     headers: {
    //     //         'Authorization': 'Bearer ' + accessToken
    //     //     },
    //     //     success: function(res) {
    //     //         console.log(res);

    //     //         if (res.data) {
                    
    //     //         }

    //             $('#modal_edit_pinjam').modal('toggle');
    //     //     },
    //     //     error: function(err) {
    //     //         console.log(err);

    //     //         Swal.fire({
    //     //             icon: 'error',
    //     //             title: 'Data gagal ditampilkan!',
    //     //             text: err.responseJSON.message,
    //     //             showConfirmButton: true,
    //     //             timer: 2000
    //     //         });
    //     //     }
    //     // });
    // });
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
                $.ajax({
                    type: 'DELETE',
                    url: `${baseApiURL}/${itemId}/delete`,
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
                    const ids = [];

                    selectedRows.each(function(index, item) {
                        ids.push($(item).data().itemId);
                    });

                    const idsData = {"ids": ids};

                    $.ajax({
                        type: 'DELETE',
                        url: `${baseApiURL}/delete/multiple`,
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
    /** end of handle delete */

    function callbackLastPeminjaman(lastPeminjaman)
    {
        if (lastPeminjaman != null) {
            lastPeminjaman = parseInt(lastPeminjaman) + 1;
            $('#nomor_peminjaman').val(lastPeminjaman);
            var countDigit = lastPeminjaman.toString().length;
            var kodePrefix = '';
            if (countDigit == 1) {
                kodePrefix = '000000';
            } else if (countDigit == 2) {
                kodePrefix = '00000';
            } else if (countDigit == 3) {
                kodePrefix = '0000';
            } else if (countDigit == 4) {
                kodePrefix = '000';
            } else if (countDigit == 5) {
                kodePrefix = '00';
            } else if (countDigit == 6) {
                kodePrefix = '0';
            } else if (countDigit == 7) {
                kodePrefix = '';
            }

            $('#kode_peminjaman').val(kodePrefix+lastPeminjaman);
        } else {
            $('#nomor_peminjaman').val(1);
            $('#kode_peminjaman').val('0000001');
        }
    }
});
</script>

<?=$this->endSection()?>