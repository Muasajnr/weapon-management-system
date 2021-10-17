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
        // handle the scanned code as you like, for example:
        console.log(`Code matched = ${decodedText}`, decodedResult);
    }

    function onScanFailure(error) {
        // handle scan failure, usually better to ignore and keep scanning.
        // for example:
        console.warn(`Code scan error = ${error}`);
    }

    let html5QrcodeScanner = new Html5QrcodeScanner(
        "reader",
        { fps: 10, qrbox: {width: 250, height: 250} },
        /* verbose= */ false);

    html5QrcodeScanner.render(onScanSuccess, onScanFailure);
});
</script>
<?=$this->endSection()?>