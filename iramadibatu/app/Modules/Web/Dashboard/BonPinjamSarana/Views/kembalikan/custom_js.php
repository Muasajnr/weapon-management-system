<?=$this->section('custom-js')?>

<script>
$(function() {
    const baseApiURL = '<?=site_url('api/v1/dashboard/bon_simpan_pinjam/kembalikan')?>';
    const urlBeritaAcara = '<?=site_url('api/v1/dashboard/berita_acara')?>';

    // handles datatable
    const table = $('#data_kembalikan').DataTable({
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
        "dom": 'lrtip',
        "pageLength": 25,
        "order": [],
        "ajax": function(data, callback, settings) {
            $.ajax({
                type: 'POST',
                url: `${baseApiURL}/datatables`,
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
            { "targets": 0, "orderable": false, "searchable": false },
            { "targets": 1, "orderable": false, "searchable": false },
            { "targets": 2, "orderable": true, "searchable": true },
            { "targets": 3, "orderable": false, "searchable": false },
            { "targets": 4, "orderable": false, "searchable": false },
            { "targets": 5, "orderable": true, "searchable": true },
            { "targets": 6, "orderable": false },
            { "targets": 7, "orderable": false },
            { "targets": 8, "orderable": false }
        ],
    });

    // handle list berita acara
    $('#select2_berita_acara').select2({
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

    $('#form_add_kembalikan').find('button.btn.btn-info').click(function(e) {
        var kode = $('#kode_peminjaman').val();
        
        if (kode.length == 0) return;

        $.ajax({
            url: `<?=site_url('api/v1/dashboard/bon_simpan_pinjam/pinjam/get/byKode')?>?kode=${kode}`, 
            headers: {
                'Authorization': 'Bearer ' + accessToken,
                'X-Requested-With': 'XMLHttpRequest'
            },
            success: function(res) {
                console.log(res);

                if (res.data.length > 0) {
                    var allText = '';
                    res.data.forEach(function(item) {
                        var newText = `${item.tipe} - ${item.nomor} - ${item.merk} x ${item.jumlah}\n`;
                        allText += newText;
                    });
                    $('#record_data_pinjam').val(allText);
                }
            },
            error: function(err) {
                console.log(err);
            }
        });
    });

    // handle adding form
    $('#form_add_kembalikan').validate({
        submitHandler: function(form, event) {
            event.preventDefault();
            
            const newData = {
                "id_berita_acara": $(form).find('#select2_berita_acara option:selected').val(),
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
                        $('#modal_add_kembalikan').modal('toggle');

                        $(form).find('textarea#record_data_pinjam').val('');

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
            record_data_pinjam: { required: true } 
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
});
</script>

<?=$this->endSection()?>