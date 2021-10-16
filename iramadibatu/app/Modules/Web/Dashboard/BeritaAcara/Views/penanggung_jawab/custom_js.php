<?=$this->section('custom-js')?>
<script>
$(function() {
    const baseApiUrl = '<?=site_url('api/v1/dashboard/berita_acara/penanggung_jawab')?>';
    // datatable
    const table = $('#data-penanggung-jawab').DataTable({
        "pageLength": 25,
        "responsive": true,
        "processing": true,
        "serverSide": true,
        "order": [],
        "drawCallback": function(settings) {
            if ($('#checkAll').is(":checked")) {
                $('.multi_delete').prop('checked', true);
            } else {
                $('.multi_delete').prop('checked', false);
            }
        },
        "ajax": function(data, callback, settings) {
            $.ajax({
                type: 'POST',
                url: `${baseApiUrl}/datatable`,
                dataType: 'json',
                data: data,
                headers: { 'Authorization': 'Bearer ' + accessToken, 'X-Requested-With': 'XMLHttpRequest' },
                success: function(res) { callback(res); },
                error: function(err) { console.log(err); }
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

    // show

    // create

    // edit

    // delete
});
</script>
<?=$this->endSection()?>