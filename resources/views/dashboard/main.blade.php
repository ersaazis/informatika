@extends(getThemePath('layout.layout'))
@section('content')
<div class="row">
    @include('dashboard.chart_jurusan')
    @if (cb()->session()->roleId() != 1)
        @include('dashboard.chart_dosen')
    @endif
</div>
@endsection