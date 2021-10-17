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
                        <button id="getqrcode-data">Find</button>
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
    var currentSecret = '';

    $('#getqrcode-data').hide();

    $('#getqrcode-data').click(function(e) {
        $('#scan-result').html('Silahkan tunggu...');
        $.ajax({
            type: 'GET',
            url: `${urlSaranaKeamanan}/qrcode?qrsecret=${currentSecret}`,
            dataType: 'json',
            headers: {
                'Authorization': 'Bearer ' + accessToken,
                'X-Requested-With': 'XMLHttpRequest'
            },
            success: function(res) {
                console.log(res);

                if (res.data != null) {
                    $('#scan-result').html(
                        `
                        <dl class="row">
                            <dt class="col-sm-4">Jenis Sarana : </dt>
                            <dd class="col-sm-8">${res.data.nama_jenis_sarana}</dd>
                        </dl>
                        ${res.data}
                        `
                    );
                }
            },
            error: function(err) {
                console.log(err);
            }
        });
    });

    function onScanSuccess(decodedText, decodedResult) {
        if (currentSecret !== decodedText) {
            currentSecret = decodedText;
            $('#getqrcode-data').trigger('click');
        }
    }

    function onScanFailure(error) {}

    let html5QrcodeScanner = new Html5QrcodeScanner(
        "reader",
        { fps: 10, qrbox: {width: 250, height: 250} },
        /* verbose= */ false);

    html5QrcodeScanner.render(onScanSuccess, onScanFailure);
});
</script>
<?=$this->endSection()?>