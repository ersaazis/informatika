<div class="col-md-6">
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Graph of Department</h3>
        </div>
        <div class="box-body">
            {{-- <div class="row"> --}}
                {{-- <div class="col-md-6"> --}}
                    <canvas id="jurusan_dokumen" height="200px"></canvas>
                {{-- </div> --}}
                {{-- <div class="col-md-6">
                    <canvas id="jurusan_kutipan" height="200px"></canvas>
                </div> --}}
            {{-- </div> --}}
        </div>
        <div class="box-footer">
            <center>
            Data from 
            <input width="50px" type="number" id="tahun_awal_jurusan" value="{{$tahun_awal_jurusan}}" class="form-control" style="width:100px;display:inline">
            to 
            <input width="50px" type="number" id="tahun_akhir_jurusan" value="{{$tahun_akhir_jurusan}}" class="form-control" style="width:100px;display:inline">
            <input type="submit" class="btn btn-sm btn-primary" value="Update" onclick="ganti_tahun_jurusab()">
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
    var tahun_awal_jurusan = {{$tahun_awal_jurusan}};
    var tahun_akhir_jurusan = {{$tahun_akhir_jurusan}};

    var jurusan_dokumen = document.getElementById("jurusan_dokumen").getContext("2d");
    // var jurusan_kutipan = document.getElementById("jurusan_kutipan").getContext("2d");
    var jurusanDokumen = new Chart(jurusan_dokumen, {
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
            tooltips: {
                mode: 'index',
                intersect: false
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
    // var jurusanKutipan = new Chart(jurusan_kutipan, {
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

    ajax_chart(jurusanDokumen, '{{cb()->getAdminUrl("chart/jurusan/dokumen/")}}/'+tahun_awal_jurusan+'/'+tahun_akhir_jurusan+'');
    // ajax_chart(jurusanKutipan, '{{cb()->getAdminUrl("chart/jurusan/kutipan/")}}/'+tahun_awal_jurusan+'/'+tahun_akhir_jurusan+'');
    function ajax_chart(chart, url, data) {
        var data = data || {};

        $.getJSON(url, data).done(function(response) {
            chart.data.labels = response.labels;
            chart.data.datasets[0].data = response.data.quantity;
            chart.update();
        });
    }
    function ganti_tahun_jurusab() {
        var awal = $('#tahun_awal_jurusan').val();
        var akhir = $('#tahun_akhir_jurusan').val();
        tahun_awal_jurusan=awal;
        tahun_akhir_jurusan=akhir;
        ajax_chart(jurusanDokumen, '{{cb()->getAdminUrl("chart/jurusan/dokumen/")}}/'+tahun_awal_jurusan+'/'+tahun_akhir_jurusan+'');
        // ajax_chart(jurusanKutipan, '{{cb()->getAdminUrl("chart/jurusan/kutipan/")}}/'+tahun_awal_jurusan+'/'+tahun_akhir_jurusan+'');
        console.log(tahun_awal_jurusan+' - '+tahun_akhir_jurusan);
    }
    </script>
@endpush