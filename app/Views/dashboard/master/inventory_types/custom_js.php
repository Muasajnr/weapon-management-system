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
$(document).ajaxStart(function() {
    Pace.restart();
});
$(function() {
    const accessToken = localStorage.getItem(ACCESS_TOKEN_KEY);
    const table = $('#data-inventory-types').DataTable({
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": function(data, callback, settings) {
            const inventoryTypesDataUrl = '<?=site_url('api/dashboard/inventory-types/datatables')?>';
            let result = null;

            $.ajax({
                type: 'POST',
                url: inventoryTypesDataUrl,
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
                "orderable": true,
                "searchable": true
            },
            {
                "targets": 2,
                "orderable": false,
                "searchable": false
            },
            {
                "targets": 3,
                "orderable": false,
                "searchable": false
            },
            {
                "targets": 4,
                "orderable": true,
                "searchable": true,
            },
            {
                "targets": 4,
                "orderable": false,
            }
        ],
    });
    
    $('#data-inventory-types tbody').on('change', 'tr input[type="checkbox"]', function(e) {
        e.preventDefault();

        const inventoryTypeId = $(this).data().inventoryTypeId;
        const updateStatusUrl = '<?=site_url('api/dashboard/inventory-types/')?>' + inventoryTypeId + '/update/status';
        
        // todo: show modal
        let confirmUpdate = confirm('Yakin untuk mengubah status ?');
        if (confirmUpdate) {
            $.ajax({
                type: 'PUT',
                url: updateStatusUrl,
                dataType: 'json',
                data: {
                    is_active: this.checked
                },
                headers: {
                    'Authorization': 'Bearer ' + accessToken
                },
                success: function(res) {
                    console.log(res);
                },
                error: function(err) {
                    console.log(err);
                }
            })
        } else {
            this.checked = !this.checked
        }
    });
});
</script>
<?=$this->endSection()?>