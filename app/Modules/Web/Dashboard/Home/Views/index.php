<?=$this->extend('layouts/dashboard/layout')?>

<?=$this->section('custom-css')?>
<style>
div.overlay.dark i {
    animation-name: spin;
    animation-duration: 2000ms;
    animation-iteration-count: infinite;
    animation-timing-function: linear; 
}

@keyframes spin {
    from {
        transform:rotate(0deg);
    }
    to {
        transform:rotate(360deg);
    }
}
</style>
<?=$this->endSection()?>

<?=$this->section('content')?>
<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="overlay dark">
                        <i class="fas fa-3x fa-sync-alt"></i>
                    </div>
                    <div class="inner">
                        <h3>-</h3>

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
                    <div class="overlay dark">
                        <i class="fas fa-3x fa-sync-alt"></i>
                    </div>
                    <div class="inner">
                        <h3>-</h3>

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
                    <div class="overlay dark">
                        <i class="fas fa-3x fa-sync-alt"></i>
                    </div>
                    <div class="inner">
                        <h3>-</h3>

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
                    <div class="overlay dark">
                        <i class="fas fa-3x fa-sync-alt"></i>
                    </div>
                    <div class="inner">
                        <h3>-</h3>

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
            <div class="col">
                <div id="list_jenis_sarana_widget" class="card card-widget widget-user-2">
                    <!-- Add the bg color to the header using any of the bg-* classes -->
                    <div class="widget-user-header bg-primary">
                        <h3 style="margin-left: 0px;" class="widget-user-username">List Sarana</h3>
                        <h5 style="margin-left: 0px;" class="widget-user-desc">Berdasarkan Jenis Saranas</h5>
                    </div>
                    <div class="card-footer p-0">
                        <ul class="nav flex-column"></ul>
                    </div>
                </div>
            </div>
            <div class="col">
                <div id="list_dipinjam_widget" class="card card-widget widget-user-2">
                    <!-- Add the bg color to the header using any of the bg-* classes -->
                    <div class="widget-user-header bg-success">
                        <h3 style="margin-left: 0px;" class="widget-user-username">Total Dipinjam</h3>
                        <h5 style="margin-left: 0px;" class="widget-user-desc">Berdasarkan jenis sarana</h5>
                    </div>
                    <div class="card-footer p-0">
                        <ul class="nav flex-column"></ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="card">
                    <div class="card-header border-0">
                        <div class="d-flex justify-content-between">
                            <h3 class="card-title">Grafik Jenis Inventaris</h3>
                            <a href="javascript:void(0);">Lihat laporan</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="position-relative mb-4">
                            <canvas id="chart-jenis-inventaris" height="400"></canvas>
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

    var $summaryWidget = $('.col-lg-3 .small-box .overlay.dark');
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

    var $chartInventoryTypes = $('#chart-jenis-inventaris')

    $.ajax({
        type: 'GET',
        url: '<?=site_url('api/v1/dashboard/stok_by_jenis_inventaris')?>',
        dataType: 'json',
        headers: {
            'Authorization': 'Bearer ' + accessToken,
            'X-Requested-With': 'XMLHttpRequest'
        },
        success: function(res) {
            // console.log(res);

            var labels = [];
            var data = [];

            if (res.data) {

                res.data.forEach(function(item) {
                    labels.push(item.jenis_inventaris);
                    data.push(item.jumlah);
                });

                var chartInventoryTypes = new Chart($chartInventoryTypes, {
                    type: 'bar',
                    data: {
                    labels: labels,
                    datasets: [{
                            backgroundColor: ['#B71C1C', '#880E4F', '#4A148C', '#311B92', '#1A237E'],
                            borderColor: '#007bff',
                            data: data
                        }]
                    },
                    options: optionsConfig
                });
            }
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
        url: '<?=site_url('api/v1/dashboard/summary_data')?>',
        dataType: 'json',
        headers: {
            'Authorization': 'Bearer ' + accessToken,
            'X-Requested-With': 'XMLHttpRequest'
        },
        success: function(res) {
            $summaryWidget.hide();
            
            if (res.data !== null) {
                $('.col-lg-3 .bg-info .inner h3').text(res.data.stok);
                $('.col-lg-3 .bg-success .inner h3').text(res.data.pinjam);
                $('.col-lg-3 .bg-warning .inner h3').text(res.data.distribusi);
                $('.col-lg-3 .bg-danger .inner h3').text(res.data.users);
            }
        },
        error: function(err) {
            console.log(err);
            $summaryWidget.hide();
        }
    });

    $.ajax({
        type: 'GET',
        url: '<?=site_url('api/v1/dashboard/listStok')?>',
        dataType: 'json',
        headers: {
            'Authorization': 'Bearer ' + accessToken,
            'X-Requested-With': 'XMLHttpRequest'
        },
        success: function(res) {
            // console.log(res);

            if (res.data !== null) {
                res.data.forEach(function(item, index) {
                    $('#list_jenis_sarana_widget .flex-column').append(
                        `
                        <li class="nav-item">
                            <a href="#" class="nav-link">${item.jenis_sarana}
                                <span class="float-right badge bg-${index % 2 === 0 ? 'primary' : index % 3 === 0 ? 'warning' : 'danger'}">${item.jumlah}</span>
                            </a>
                        </li>
                        `
                    );
                });
            }
        },
        error: function(err) {
            console.log(err);
        }
    });

    $.ajax({
        type: 'GET',
        url: '<?=site_url('api/v1/dashboard/listDipinjam')?>',
        dataType: 'json',
        headers: {
            'Authorization': 'Bearer ' + accessToken,
            'X-Requested-With': 'XMLHttpRequest'
        },
        success: function(res) {
            // console.log(res.data);
            if (res.data !== null) {
                res.data.forEach(function(item, index) {
                    // console.log(item);
                    $('#list_dipinjam_widget .flex-column').append(
                        `
                        <li class="nav-item">
                            <a href="#" class="nav-link">${item.jenis_sarana}
                                <span class="float-right badge bg-${index % 2 === 0 ? 'primary' : 'warning'}">${item.jumlah}</span>
                            </a>
                        </li>
                        `
                    );
                });
            }
        },
        error: function(err) {
            console.log(err);
        }
    });
});
</script>
<?=$this->endSection()?>