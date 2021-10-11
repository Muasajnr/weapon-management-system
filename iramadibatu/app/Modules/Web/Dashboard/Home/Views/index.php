<?=$this->extend('layouts/dashboard/layout')?>

<?=$this->section('content')?>
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

                        <p>Total Stok</p>
                    </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                <a href="#" class="small-box-footer">Detail <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>53</h3>

                        <p>Total Dipinjam</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="#" class="small-box-footer">Detail <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>44</h3>

                        <p>Total Didistribusi</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="#" class="small-box-footer">Detail <i class="fas fa-arrow-circle-right"></i></a>
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
                    <a href="#" class="small-box-footer">Detail <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
        </div>
        <div class="row">
            <div class="col-lg-4">
                <div class="card card-widget widget-user-2">
                    <!-- Add the bg color to the header using any of the bg-* classes -->
                    <div class="widget-user-header bg-primary">
                        <h3 style="margin-left: 0px;" class="widget-user-username">Total Stok</h3>
                        <h5 style="margin-left: 0px;" class="widget-user-desc">Berdasarkan jenis sarana</h5>
                    </div>
                    <div class="card-footer p-0">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a href="#" class="nav-link">Projects<span class="float-right badge bg-primary">31</span></a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">Tasks <span class="float-right badge bg-info">5</span></a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">Completed Projects <span class="float-right badge bg-success">12</span></a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">Followers <span class="float-right badge bg-danger">842</span></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card card-widget widget-user-2">
                    <!-- Add the bg color to the header using any of the bg-* classes -->
                    <div class="widget-user-header bg-success">
                        <h3 style="margin-left: 0px;" class="widget-user-username">Total Dipinjam</h3>
                        <h5 style="margin-left: 0px;" class="widget-user-desc">Berdasarkan jenis sarana</h5>
                    </div>
                    <div class="card-footer p-0">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    Projects <span class="float-right badge bg-primary">31</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    Tasks <span class="float-right badge bg-info">5</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    Completed Projects <span class="float-right badge bg-success">12</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    Followers <span class="float-right badge bg-danger">842</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header border-0">
                        <div class="d-flex justify-content-between">
                            <h3 class="card-title">Stok Berdasarkan Jenis Sarana</h3>
                            <a href="javascript:void(0);">Lihat laporan</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="position-relative mb-4">
                            <canvas id="chart-inventory-types" height="400"></canvas>
                        </div>
                    </div>
                </div>
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
    var optionsConfig = {
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
    };

    var $chartInventoryTypes = $('#chart-inventory-types')




    $.ajax({
        type: 'GET',
        url: '<?=site_url('api/dashboard/stock-by-inventory-type')?>',
        dataType: 'json',
        headers: {
            'Authorization': 'Bearer ' + accessToken,
            'X-Requested-With': 'XMLHttpRequest'
        },
        success: function(res) {
            console.log(res)
            var chartInventoryTypes = new Chart($chartInventoryTypes, {
                type: 'bar',
                data: {
                labels: ['Senjata Api', 'Non Organik', 'Gudang', 'Regu Pengamanan', 'Tidak Diketahui'],
                datasets: [{
                        backgroundColor: ['#B71C1C', '#880E4F', '#4A148C', '#311B92', '#1A237E'],
                        borderColor: '#007bff',
                        data: [59, 20, 11, 80, 30]
                    }]
                },
                options: optionsConfig
            });
        },
        error: function(err) {
            console.log(err)
            var chartInventoryTypes = new Chart($chartInventoryTypes, {
                type: 'bar',
                data: {
                labels: ['Senjata Api', 'Non Organik', 'Gudang', 'Regu Pengamanan', 'Tidak Diketahui'],
                datasets: [
                    {
                        backgroundColor: ['#B71C1C', '#880E4F', '#4A148C', '#311B92', '#1A237E'],
                        borderColor: '#007bff',
                        data: [59, 20, 11, 80, 30]
                    },
                ]
                },
                options: optionsConfig
            });
        }
    });
    $.ajax({
        type: 'GET',
        url: '<?=site_url('api/dashboard/stock-by-firearm-type')?>',
        dataType: 'json',
        headers: {
            'Authorization': 'Bearer ' + accessToken,
            'X-Requested-With': 'XMLHttpRequest'
        },
        success: function(res) {

        },
        error: function(err) {

        }
    });
    $.ajax({
        type: 'GET',
        url: '<?=site_url('api/dashboard/stock-by-firearm-brand')?>',
        dataType: 'json',
        headers: {
            'Authorization': 'Bearer ' + accessToken,
            'X-Requested-With': 'XMLHttpRequest'
        },
        success: function(res) {

        },
        error: function(err) {

        }
    });









    

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