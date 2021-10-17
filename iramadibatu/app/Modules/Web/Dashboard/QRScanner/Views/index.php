<?=$this->extend('layouts/dashboard/layout')?>

<?=$this->section('content')?>
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-outline card-primary">
                    <div class="card-body">
                        <div id="reader" width="600px"></div>
                        <div id="scan-result"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /.content -->

<?=$this->endSection()?>

<?=$this->section('custom-js')?>
<script src="<?=site_url('assets/js/vendor/html5-qrcode.min.js')?>"></script>
<script>
$(function() {
    function onScanSuccess(decodedText, decodedResult) {
        $('#scan-result').html('Mantap');

        // $.ajax({
        //     type: 'GET',
        //     url: `${urlSaranaKeamanan}/qrcode?qrsecret=${decodedText}`,
        //     dataType: 'json',
        //     headers: {
        //         'Authorization': 'Bearer ' + accessToken,
        //         'X-Requested-With': 'XMLHttpRequest'
        //     },
        //     success: function(res) {
        //         console.log(res);

        //         if (res.data != null) {
        //             $('#scan-result').html(
        //                 `
        //                 <dl class="row">
        //                     <dt class="col-sm-4">Jenis Sarana : </dt>
        //                     <dd class="col-sm-8">${res.data.nama_jenis_sarana}</dd>
        //                 </dl>
        //                 `
        //             );
        //         }
        //     },
        //     error: function(err) {
        //         console.log(err);
        //     }
        // });
    }

    function onScanFailure(error) {
        console.warn(`Code scan error = ${error}`);
        $('#scan-result').html(`<p>QQ Code tidak terbaca!</p>`);
    }

    let html5QrcodeScanner = new Html5QrcodeScanner(
        "reader",
        { fps: 10, qrbox: {width: 250, height: 250} },
        /* verbose= */ false);

    html5QrcodeScanner.render(onScanSuccess, onScanFailure);
});
</script>
<?=$this->endSection()?>