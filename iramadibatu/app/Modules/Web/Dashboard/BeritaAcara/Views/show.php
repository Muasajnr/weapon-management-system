<?=$this->extend('layouts/window_popup/layout')?>

<?=$this->section('content')?>
<!-- Main content -->
<section class="content mt-5">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="mb-0"></h3>
                    <hr>
                    <dl></dl>
                </div>
                <!-- /.card-header -->
                <div class="card-body"></div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</section>
<!-- /.content -->
<?=$this->endSection()?>

<?=$this->section('custom-js')?>
<script>
$(function() {
    $.ajax({
        type: 'GET',
        url: '<?=site_url('api/v1/dashboard/berita_acara/'.$id_berita_acara)?>',
        dataType: 'json',
        headers: {
            'Authorization': 'Bearer ' + accessToken,
            'X-Requested-With': 'XMLHttpRequest'
        },
        success: function(res) {
            console.log(res);
            if (res.data != null) {
                $('.col-12 .card h3').text(res.data.nama);

                $('.col-12 .card dl').append(`<dt>No.</dt><dd>${res.data.nomor}</dd>`);
                $('.col-12 .card dl').append(
                    `
                    <dt>Pihak 1</dt>
                    <dd>
                        <span class="ml-3">Nama</span> : ${res.data.pihak_1_nama}<br>
                        <span class="ml-3">NIP</span>  : ${res.data.pihak_1_nip}
                    </dd>
                    `
                );
                $('.col-12 .card dl').append(
                    `
                    <dt>Pihak 2</dt>
                    <dd>
                        <span class="ml-3">Nama</span> : ${res.data.pihak_2_nama}<br>
                        <span class="ml-3">NIP</span> : ${res.data.pihak_2_nip}
                    </dd>
                    `
                );
                $('.col-12 .card dl').append(`<dt>Keterangan</dt><dd>${res.data.keterangan}</dd>`);

                $('.col-12 .card .card-body').html(
                    res.data.media_file_extension == 'pdf' ? 
                    `
                        <embed src="<?=site_url()?>/${res.data.media_file_full_path}" type="application/pdf" width="100%" height="1200">
                    `
                    : 
                    `
                        <img src="<?=site_url()?>/${res.data.media_file_full_path}" alt="${res.data.nama}" width="100%">
                    `
                )
            }
        },
        error: function(err) {
            console.log(err);
        }
    })
});
</script>
<?=$this->endSection()?>