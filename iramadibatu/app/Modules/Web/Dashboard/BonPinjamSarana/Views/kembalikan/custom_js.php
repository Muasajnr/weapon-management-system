<?=$this->section('custom-js')?>

<script>
$(function() {
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
            const dataUrl = '<?=site_url('api/v1/dashboard/bon_simpan_pinjam/kembalikan/datatables')?>';

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
});
</script>

<?=$this->endSection()?>