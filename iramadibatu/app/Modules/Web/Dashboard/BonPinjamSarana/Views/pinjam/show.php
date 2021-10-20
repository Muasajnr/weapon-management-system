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
                <div class="card-body">
                    <h5 class="text-bold text-primary">List sarana yang dipinjam</h5>
                    <table id="list_pinjam" class="table table-sm mb-3">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nomor</th>
                                <th>BPSA</th>
                                <th>Nama</th>
                                <th>Merk</th>
                                <th>Tipe</th>
                                <th>Jumlah</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                    <h5 class="text-bold text-primary">Gambar Berita Acara</h5>
                    <div class="media-area"></div>
                </div>
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
        url: '<?=site_url('api/v1/dashboard/bon_simpan_pinjam/pinjam/get/detailByKode?kode_peminjaman='.$kodePeminjaman)?>',
        dataType: 'json',
        headers: {
            'Authorization': 'Bearer ' + accessToken,
            'X-Requested-With': 'XMLHttpRequest'
        },
        success: function(res) {
            console.log(res);
            if (res.data != null) {
                $('.col-12 .card h3').text(res.data[0].judul_berita_acara);

                $('.col-12 .card dl').append(`<dt>No.</dt><dd>${res.data[0].nomor_berita_acara}</dd>`);
                $('.col-12 .card dl').append(
                    `
                    <dt>Pihak 1</dt>
                    <dd>
                        <span class="ml-3">Nama</span> : ${res.data[0].pihak_1_nama}<br>
                        <span class="ml-3">NIP</span>  : ${res.data[0].pihak_1_nip}
                    </dd>
                    `
                );
                $('.col-12 .card dl').append(
                    `
                    <dt>Pihak 2</dt>
                    <dd>
                        <span class="ml-3">Nama</span> : ${res.data[0].pihak_2_nama}<br>
                        <span class="ml-3">NIP</span> : ${res.data[0].pihak_2_nip}
                    </dd>
                    `
                );
                // $('.col-12 .card dl').append(`<dt>Keterangan</dt><dd>${res.data[0].keterangan}</dd>`);

                res.data.forEach(function(item, index) {
                    $('#list_pinjam tbody').append(
                        `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${item.nomor}</td>
                            <td>${item.bpsa}</td>
                            <td>${item.nama}</td>
                            <td>${item.merk}</td>
                            <td>${item.tipe}</td>
                            <td>${item.jumlah}</td>
                        </tr>
                        `
                    );
                });

                $('.col-12 .card .card-body .media-area').html(
                    res.data[0].file_extension == 'pdf' ? 
                    `
                        <embed src="<?=site_url()?>/${res.data[0].file_full_path}" type="application/pdf" width="100%" height="1200">
                    `
                    : 
                    `
                        <img src="<?=site_url()?>/${res.data[0].file_full_path}" alt="${res.data[0].nama}" width="100%">
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