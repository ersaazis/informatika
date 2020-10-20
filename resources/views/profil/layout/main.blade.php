@php
    $tahun_awal_jurusan=date('Y')-10;
    $tahun_akhir_jurusan=date('Y');
@endphp
@extends('profil.layout.layout')
@section('header')
    <main class="page landing-page">
        <section class="clean-block clean-hero" style="color: rgba(145,196,72,0.8);">
            <div class="text">
                <h3 class="text-light">Documents per Year</h3>
                <canvas id="jurusan_dokumen"></canvas>
                Data from 
                <input width="50px" type="number" id="tahun_awal_jurusan" value="{{$tahun_awal_jurusan}}" class="form-control" style="width:100px;display:inline">
                to 
                <input width="50px" type="number" id="tahun_akhir_jurusan" value="{{$tahun_akhir_jurusan}}" class="form-control" style="width:100px;display:inline">
                <input type="submit" class="btn btn-sm btn-default bg-light" value="Update" onclick="ganti_tahun_jurusab()">
            </div>
        </section>
    </main>
    @yield('content')
@endsection
@push('head')
<link rel="stylesheet" type="text/css" href="{{url('assets/chartjs/Chart.min.css')}}">
@endpush
@push('bottom')
<script src="{{url('assets/chartjs/Chart.min.js')}}"></script>
<script>
    var tahun_awal_jurusan = {{$tahun_awal_jurusan}};
    var tahun_akhir_jurusan = {{$tahun_akhir_jurusan}};

    var jurusan_dokumen = document.getElementById("jurusan_dokumen").getContext("2d");
    var jurusanDokumen = new Chart(jurusan_dokumen, {
        type: 'bar',
        data: {
            labels: [],
            datasets: [
                {
                    label: "Documents",
                    backgroundColor: '#f8f9fa',
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
    ajax_chart(jurusanDokumen, '{{cb()->getAdminUrl("chart/jurusan/dokumen/")}}/'+tahun_awal_jurusan+'/'+tahun_akhir_jurusan+'');
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
        console.log(tahun_awal_jurusan+' - '+tahun_akhir_jurusan);
    }
    </script>
@endpush