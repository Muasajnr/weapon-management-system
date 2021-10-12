<?=$this->extend('layouts/window_popup/layout')?>

<?=$this->section('content')?>
<!-- Main content -->
<section class="content mt-5">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="mb-0">Data Stok</h3>
                    <!-- <p class="text-muted mb-0"><strong>Nomor : </strong>/p> -->
                    <p class="text-muted mb-0">Data stok untuk jenis sarana Rifle</p>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <h5>{Nama Jenis Sarana} - (Data  tersedia)</h5>
                    <table id="data-stok" class="table table-sm">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>No. Sarana</th>
                                <th>No. BPSA</th>
                                <th>Nama</th>
                                <th>Merk</th>
                                <th>Jenis</th>
                                <th>Satuan</th>
                                <th>Jumlah</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- <tr>
                                <td class="text-center" colspan="9"><p>Tidak ada data.</p></td>
                            </tr> -->
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->

                <div class="card-body">
                    <h5>{Nama Jenis Sarana} - (Sedang dipinjam)</h5>
                    <table id="data-pinjam" class="table table-sm">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>No. Sarana</th>
                                <th>No. BPSA</th>
                                <th>Nama</th>
                                <th>Merk</th>
                                <th>Jenis</th>
                                <th>Satuan</th>
                                <th>Jumlah</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- <tr>
                                <td class="text-center" colspan="9"><p>Tidak ada data.</p></td>
                            </tr> -->
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->

                <div class="card-body">
                    <h5>{Nama Jenis Sarana} - Sudah didistribusikan</h5>
                    <table id="data-distribusi" class="table table-sm">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>No. Sarana</th>
                                <th>No. BPSA</th>
                                <th>Nama</th>
                                <th>Merk</th>
                                <th>Jenis</th>
                                <th>Satuan</th>
                                <th>Jumlah</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- <tr>
                                <td class="text-center" colspan="9"><p>Tidak ada data.</p></td>
                            </tr> -->
                        </tbody>
                    </table>
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
        url: '<?=site_url('api/v1/dashboard/stok/sarana_keamanan?id_jenis_sarana='.$id_jenis_sarana)?>',
        dataType: 'json',
        headers: {
            'Authorization': 'Bearer ' + accessToken
        },
        success: function(res) {
            console.log(res);
            if (res.data != null) {
                if (res.data.stok_data.length > 0) {
                    res.data.stok_data.forEach(function(item, index) {
                        $('#data-stok tbody').append(
                            `
                            <tr>
                                <td>${index+1}</td>
                                <td>${item.nomor_sarana}</td>
                                <td>${item.nomor_bpsa}</td>
                                <td>${item.nama}</td>
                                <td>${item.merk}</td>
                                <td>${item.tipe}</td>
                                <td>${item.satuan}</td>
                                <td>${item.jumlah}</td>
                                <td>${item.keterangan}</td>
                            </tr>
                            `
                        );
                    });
                } else {
                    $('#data-stok tbody').append(
                        `
                        <td class="text-center" colspan="9"><p>Tidak ada data.</p></td>
                        `
                    );
                }

                if (res.data.sedang_dipinjam.length > 0) {
                    res.data.sedang_dipinjam.forEach(function(item, index) {
                        $('#data-stok tbody').append(
                            `
                            <tr>
                                <td>${index+1}</td>
                                <td>${item.nomor_sarana}</td>
                                <td>${item.nomor_bpsa}</td>
                                <td>${item.nama}</td>
                                <td>${item.merk}</td>
                                <td>${item.tipe}</td>
                                <td>${item.satuan}</td>
                                <td>${item.jumlah}</td>
                                <td>${item.keterangan}</td>
                            </tr>
                            `
                        );
                    });
                } else {
                    $('#data-pinjam tbody').append(
                        `
                        <td class="text-center" colspan="9"><p>Tidak ada data.</p></td>
                        `
                    );
                }

                if (res.data.didistribusi.length > 0) {
                    res.data.didistribusi.forEach(function(item, index) {
                        $('#data-distribusi tbody').append(
                            `
                            <tr>
                                <td>${index+1}</td>
                                <td>${item.nomor_sarana}</td>
                                <td>${item.nomor_bpsa}</td>
                                <td>${item.nama}</td>
                                <td>${item.merk}</td>
                                <td>${item.tipe}</td>
                                <td>${item.satuan}</td>
                                <td>${item.jumlah}</td>
                                <td>${item.keterangan}</td>
                            </tr>
                            `
                        );
                    });
                } else {
                    $('#data-distribusi tbody').append(
                        `
                        <td class="text-center" colspan="9"><p>Tidak ada data.</p></td>
                        `
                    );
                }
            }
        },
        error: function(err) {
            console.log(err);
        }
    })
});
</script>
<?=$this->endSection()?>