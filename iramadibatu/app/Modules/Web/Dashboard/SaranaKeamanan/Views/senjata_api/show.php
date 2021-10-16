<?=$this->extend('layouts/window_popup/layout')?>

<?=$this->section('content')?>
<!-- Main content -->
<section class="content mt-5">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="mb-0">jenis inventaris</h3>
                    <p class="text-muted mb-0"><strong>Nomor : </strong>jenis sarana</p>
                    <p class="text-muted mb-0"><strong>Keterangan : </strong>merk sarana</p>
                    <p class="text-muted mb-0"><strong>Tanggal dibuat : </strong>no sarana</p>
                    <p class="text-muted mb-0"><strong>Tanggal dibuat : </strong>no bpsa</p>
                    <p class="text-muted mb-0"><strong>Tanggal dibuat : </strong>jumlah</p>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                <?php
                    // switch($data['file_extension']):
                        // case 'pdf':
                            // echo "<embed src=\"".site_url($data['file_full_path'])."\" type=\"application/pdf\" width=\"100%\" height=\"1200\">";
                            // break;
                        // case 'jpeg':
                        // case 'jpg':
                        // case 'png':
                            // echo "<img src=\"".site_url($data['file_full_path'])."\" alt=\"".$data['nama']."\" width=\"100%\">";
                            // break;
                        // default:
                            echo "<p>Terjadi kesalahan!</p>";
                            // break;
                    // endswitch;
                ?>
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