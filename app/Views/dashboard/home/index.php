<?=$this->extend('layouts/dashboard/layout')?>
<?=$this->section('content')?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Dashboard</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <!-- <li class="breadcrumb-item active">Dashboar</li> -->
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                <div class="inner">
                    <h3>150</h3>

                    <p>Stok Senjata Api</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>53</h3>

                        <p>Total Senjata Api Dipinjam</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>44</h3>

                        <p>Total Senjata Api Dikembalikan</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>65</h3>

                        <p>Total User</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
        </div>
        <div class="row justify-content-md-center">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header border-0">
                        <div class="d-flex justify-content-between">
                            <h3 class="card-title">Stok Berdasarkan Jenis Inventaris</h3>
                            <a href="javascript:void(0);">Lihat laporan</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="position-relative mb-4">
                            <canvas id="sales-chart" height="400"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header border-0">
                        <div class="d-flex justify-content-between">
                            <h3 class="card-title">Stok Berdasarkan Jenis Senjata Api</h3>
                            <a href="javascript:void(0);">Lihat laporan</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="position-relative mb-4">
                            <canvas id="chart-jenis-senpi" height="350"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card -->
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header border-0">
                        <div class="d-flex justify-content-between">
                            <h3 class="card-title">Stok Berdasarkan Merk Senjata Api</h3>
                            <a href="javascript:void(0);">Lihat laporan</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="position-relative mb-4">
                            <canvas id="chart-merk-senpi" height="350"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header border-transparent">
                        <h3 class="card-title">Top 10 Senjata Api</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                        <div class="table-responsive">
                        <table class="table m-0">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Stok</th>
                                    <th>Nama</th>
                                    <th>Deskripsi</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1.</td>
                                    <td>40</td>
                                    <td>Pistol</td>
                                    <td>Senjata api</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>2.</td>
                                    <td>40</td>
                                    <td>Pistol</td>
                                    <td>Senjata api</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>3.</td>
                                    <td>40</td>
                                    <td>Pistol</td>
                                    <td>Senjata api</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>4.</td>
                                    <td>40</td>
                                    <td>Pistol</td>
                                    <td>Senjata api</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>5.</td>
                                    <td>40</td>
                                    <td>Pistol</td>
                                    <td>Senjata api</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>5.</td>
                                    <td>40</td>
                                    <td>Pistol</td>
                                    <td>Senjata api</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>5.</td>
                                    <td>40</td>
                                    <td>Pistol</td>
                                    <td>Senjata api</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>5.</td>
                                    <td>40</td>
                                    <td>Pistol</td>
                                    <td>Senjata api</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>5.</td>
                                    <td>40</td>
                                    <td>Pistol</td>
                                    <td>Senjata api</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>5.</td>
                                    <td>40</td>
                                    <td>Pistol</td>
                                    <td>Senjata api</td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                        </div>
                        <!-- /.table-responsive -->
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer clearfix"></div>
                    <!-- /.card-footer -->
                </div>
                <!-- /.card -->
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header border-transparent">
                        <h3 class="card-title">Top 10 Senjata Api Paling Sering Dipinjam</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                        <div class="table-responsive">
                        <table class="table m-0">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Stok</th>
                                    <th>Nama</th>
                                    <th>Deskripsi</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1.</td>
                                    <td>40</td>
                                    <td>Pistol</td>
                                    <td>Senjata api</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>2.</td>
                                    <td>40</td>
                                    <td>Pistol</td>
                                    <td>Senjata api</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>3.</td>
                                    <td>40</td>
                                    <td>Pistol</td>
                                    <td>Senjata api</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>4.</td>
                                    <td>40</td>
                                    <td>Pistol</td>
                                    <td>Senjata api</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>5.</td>
                                    <td>40</td>
                                    <td>Pistol</td>
                                    <td>Senjata api</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>5.</td>
                                    <td>40</td>
                                    <td>Pistol</td>
                                    <td>Senjata api</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>5.</td>
                                    <td>40</td>
                                    <td>Pistol</td>
                                    <td>Senjata api</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>5.</td>
                                    <td>40</td>
                                    <td>Pistol</td>
                                    <td>Senjata api</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>5.</td>
                                    <td>40</td>
                                    <td>Pistol</td>
                                    <td>Senjata api</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>5.</td>
                                    <td>40</td>
                                    <td>Pistol</td>
                                    <td>Senjata api</td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                        </div>
                        <!-- /.table-responsive -->
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer clearfix"></div>
                    <!-- /.card-footer -->
                </div>
                <!-- /.card -->
            </div>
        </div>
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->
<?=$this->endSection()?>

<?=$this->section('custom-js')?>
<script src="<?=site_url('themes/AdminLTE/plugins/chart.js/Chart.min.js')?>"></script>
<script>
    $(function () {
    'use strict'

    var ticksStyle = {
        fontColor: '#495057',
        fontStyle: 'bold'
    }

    var mode = 'index'
    var intersect = true

    var $salesChart = $('#sales-chart')
    // eslint-disable-next-line no-unused-vars
    var salesChart = new Chart($salesChart, {
        type: 'bar',
        data: {
        labels: ['Senjata Api', 'Non Organik', 'Gudang', 'Regu Pengamanan', 'Tidak Diketahui'],
        datasets: [
            {
                backgroundColor: ['#007bff', '#00ff00', '#ffff00', '#ff3399', '#ff0000'],
                borderColor: '#007bff',
                data: [59, 20, 11, 80, 30]
            },
        ]
        },
        options: {
        maintainAspectRatio: false,
        tooltips: {
            mode: mode,
            intersect: intersect
        },
        hover: {
            mode: mode,
            intersect: intersect
        },
        legend: {
            display: false
        },
        scales: {
            yAxes: [{
            // display: false,
            gridLines: {
                display: true,
                lineWidth: '4px',
                color: 'rgba(0, 0, 0, .2)',
                zeroLineColor: 'transparent'
            },
            ticks: $.extend({
                beginAtZero: true,

                // Include a dollar sign in the ticks
                callback: function (value) {
                    return value
                }
            }, ticksStyle)
            }],
            xAxes: [{
            display: true,
            gridLines: {
                display: false
            },
            ticks: ticksStyle
            }]
        }
        }
    })

    var $chartJenisSenpi = $('#chart-jenis-senpi')
    // eslint-disable-next-line no-unused-vars
    var chartJenisSenpi = new Chart($chartJenisSenpi, {
        type: 'bar',
        data: {
        labels: ['Bahu', 'Pistol', 'Gudang', 'Revolver', 'Gas Air Mata', 'Flas Ball'],
        datasets: [
            {
                backgroundColor: ['#007bff', '#00ff00', '#ffff00', '#ff3399', '#ff0000', '#555555'],
                borderColor: '#007bff',
                data: [59, 20, 11, 80, 30, 12]
            },
        ]
        },
        options: {
        maintainAspectRatio: false,
        tooltips: {
            mode: mode,
            intersect: intersect
        },
        hover: {
            mode: mode,
            intersect: intersect
        },
        legend: {
            display: false
        },
        scales: {
            yAxes: [{
            // display: false,
            gridLines: {
                display: true,
                lineWidth: '4px',
                color: 'rgba(0, 0, 0, .2)',
                zeroLineColor: 'transparent'
            },
            ticks: $.extend({
                beginAtZero: true,

                // Include a dollar sign in the ticks
                callback: function (value) {
                    return value
                }
            }, ticksStyle)
            }],
            xAxes: [{
            display: true,
            gridLines: {
                display: false
            },
            ticks: ticksStyle
            }]
        }
        }
    })

    var $chartMerkSenpi = $('#chart-merk-senpi')
    // eslint-disable-next-line no-unused-vars
    var chartMerkSenpi = new Chart($chartMerkSenpi, {
        type: 'bar',
        data: {
        labels: ['Bahu', 'Pistol', 'Gudang', 'Revolver', 'Gas Air Mata', 'Flas Ball'],
        datasets: [
            {
                backgroundColor: ['#007bff', '#00ff00', '#ffff00', '#ff3399', '#ff0000', '#555555'],
                borderColor: '#007bff',
                data: [59, 20, 11, 80, 30, 12]
            },
        ]
        },
        options: {
        maintainAspectRatio: false,
        tooltips: {
            mode: mode,
            intersect: intersect
        },
        hover: {
            mode: mode,
            intersect: intersect
        },
        legend: {
            display: false
        },
        scales: {
            yAxes: [{
            // display: false,
            gridLines: {
                display: true,
                lineWidth: '4px',
                color: 'rgba(0, 0, 0, .2)',
                zeroLineColor: 'transparent'
            },
            ticks: $.extend({
                beginAtZero: true,

                // Include a dollar sign in the ticks
                callback: function (value) {
                    return value
                }
            }, ticksStyle)
            }],
            xAxes: [{
            display: true,
            gridLines: {
                display: false
            },
            ticks: ticksStyle
            }]
        }
        }
    })
})
</script>
<?=$this->endSection()?>