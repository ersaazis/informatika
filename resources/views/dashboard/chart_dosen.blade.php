<div class="col-md-6">
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Your chart</h3>
        </div>
        <div class="box-body">
            {{-- <div class="row"> --}}
                {{-- <div class="col-md-6"> --}}
                    <canvas id="dosen_dokumen" height="200px"></canvas>
                {{-- </div> --}}
                {{-- <div class="col-md-6">
                    <canvas id="dosen_kutipan" height="200px"></canvas>
                </div> --}}
            {{-- </div> --}}
        </div>
        <div class="box-footer">
            <center>
            Data from 
            <input width="50px" type="number" id="tahun_awal_dosen" value="{{$tahun_awal_dosen}}" class="form-control" style="width:100px;display:inline">
             to 
            <input width="50px" type="number" id="tahun_akhir_dosen" value="{{$tahun_akhir_dosen}}" class="form-control" style="width:100px;display:inline">
            <input type="submit" class="btn btn-sm btn-primary" value="Update" onclick="ganti_tahun_dosen()">
            </center>
        </div>
    </div>
</div>
@push('head')
<link rel="stylesheet" type="text/css" href="{{url('assets/chartjs/Chart.min.css')}}">
@endpush
@push('bottom')
<script src="{{url('assets/chartjs/Chart.min.js')}}"></script>
<script>
    var tahun_awal_dosen = {{$tahun_awal_dosen}};
    var tahun_akhir_dosen = {{$tahun_akhir_dosen}};

    var dosen_dokumen = document.getElementById("dosen_dokumen").getContext("2d");
    // var dosen_kutipan = document.getElementById("dosen_kutipan").getContext("2d");
    var dosenDokumen = new Chart(dosen_dokumen, {
        type: 'bar',
        data: {
            labels: [],
            datasets: [
                {
                    label: "Documents",
                    backgroundColor: 'rgba(0, 166, 90, 0.5)',
                    data: [],
                    order: 2
                }
            ]
        },
        options: {
            hover: {
                animationDuration: 0
            },
            animation: {
                duration: 1,
                onComplete: function() {
                    var chartInstance = this.chart,
                    ctx = chartInstance.ctx;

                    ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
                    ctx.textAlign = 'center';
                    ctx.textBaseline = 'bottom';

                    this.data.datasets.forEach(function(dataset, i) {
                    var meta = chartInstance.controller.getDatasetMeta(i);
                    meta.data.forEach(function(bar, index) {
                        var data = dataset.data[index];
                        ctx.fillText(data, bar._model.x, bar._model.y - 5);
                    });
                    });
                }
            },
            tooltips: {
                enabled: false,
            },
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero:true
                    }
                }]
            }
        }
    });
    // var dosenKutipan = new Chart(dosen_kutipan, {
    //     type: 'bar',
    //     data: {
    //         labels: [],
    //         datasets: [
    //             {
    //                 label: "Citations",
    //                 backgroundColor: 'rgba(60, 141, 188, 0.5)',
    //                 data: [],
    //                 order: 1
    //             }
    //         ]
    //     },
    //     options: {
    //         tooltips: {
    //             mode: 'index',
    //             intersect: false
    //         },
    //         scales: {
    //             yAxes: [{
    //                 ticks: {
    //                     beginAtZero:true
    //                 }
    //             }]
    //         }
    //     }
    // });

    ajax_chart(dosenDokumen, '{{cb()->getAdminUrl("chart/dosen/dokumen/")}}/'+tahun_awal_dosen+'/'+tahun_akhir_dosen+'');
    // ajax_chart(dosenKutipan, '{{cb()->getAdminUrl("chart/dosen/kutipan/")}}/'+tahun_awal_dosen+'/'+tahun_akhir_dosen+'');
    function ajax_chart(chart, url, data) {
        var data = data || {};

        $.getJSON(url, data).done(function(response) {
            chart.data.labels = response.labels;
            chart.data.datasets[0].data = response.data.quantity;
            chart.update();
        });
    }
    function ganti_tahun_dosen() {
        var awal = $('#tahun_awal_dosen').val();
        var akhir = $('#tahun_akhir_dosen').val();
        tahun_awal_dosen=awal;
        tahun_akhir_dosen=akhir;
        ajax_chart(dosenDokumen, '{{cb()->getAdminUrl("chart/dosen/dokumen/")}}/'+tahun_awal_dosen+'/'+tahun_akhir_dosen+'');
        // ajax_chart(dosenKutipan, '{{cb()->getAdminUrl("chart/dosen/kutipan/")}}/'+tahun_awal_dosen+'/'+tahun_akhir_dosen+'');
        console.log(tahun_awal_dosen+' - '+tahun_akhir_dosen);
    }
    </script>
@endpush