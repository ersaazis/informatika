@extends(getThemePath('layout.layout'))
@section('content')
<div class="row">
    @include('dashboard.chart_jurusan')
    @if (cb()->session()->roleId() != 1)
        @include('dashboard.chart_dosen')
    @endif
</div>
<div class="row">
    <div class="col-md-6">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Wordcloud</h3>
            </div>
            <div class="box-body">
              <img src="{{cb()->getAdminUrl('wordcloud')}}" width="100%">
            </div>
        </div>
    </div>
</div>
@endsection