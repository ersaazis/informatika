@extends(getThemePath('layout.layout'))
@section('content')
        <style>
            .files input{outline:2px dashed #3c8dbc;outline-offset:-10px;-webkit-transition:outline-offset .15s ease-in-out,background-color .15s linear;transition:outline-offset .15s ease-in-out,background-color .15s linear;padding:120px 0 85px 35%;text-align:center!important;margin:0;width:100%!important}.files input:focus{outline:2px dashed #3c8dbc;outline-offset:-10px;-webkit-transition:outline-offset .15s ease-in-out,background-color .15s linear;transition:outline-offset .15s ease-in-out,background-color .15s linear;border:1px solid #3c8dbc}.files{position:relative}.files:after{pointer-events:none;position:absolute;top:60px;left:0;width:50px;right:0;height:56px;content:"";background-image:url(https://image.flaticon.com/icons/png/128/109/109612.png);display:block;margin:0 auto;background-size:100%;background-repeat:no-repeat}.color input{background-color:#3c8dbc}.files:before{position:absolute;bottom:5px;left:0;pointer-events:none;width:100%;right:0;height:57px;content:" Click or drag here. ";display:block;margin:0 auto;color:#3c8dbc;font-weight:600;text-transform:capitalize;text-align:center}
        </style>
        @if(verifyReferalUrl())
            <p>
                <a href="{{ getReferalUrl("url") }}"><i class="fa fa-arrow-left"></i> Back To {{ getReferalUrl("name")?:cbLang("data") }} List</a>
            </p>
            @else
            <p>
                <a href="{{ module()->url() }}"><i class="fa fa-arrow-left"></i> &nbsp; {{cbLang('back_to_list')}}</a>
            </p>
        @endif


        <div class="box box-default">
            <div class="box-header with-border">
                <h1 class="box-title"><i class="fa fa-file"></i> {{ cbLang("add")." ".cbLang("data") }}</h1>
            </div>

            <form method='post' id="form" enctype="multipart/form-data" action='{{ $action_url }}'>
                {!! csrf_field() !!}
                <input type="hidden" name="ref" value="{{ verifyReferalUrl()?request("ref"):null }}">
                <div class="box-body" id="parent-form-area">
                    @php $column=columnSingleton()->getAddColumns()[1]; @endphp
                    @include('types::'.$column->getType().'.component')
                    @if (!empty(columnSingleton()->getAddColumns()[2]))
                    @php $column=columnSingleton()->getAddColumns()[2]; @endphp
                    @include('types::'.$column->getType().'.component')
                    @endif

                    <div class="form-group files" id="form-group-file" style="max-width:500px">
                        <label>
                            File <span class="text-danger" title="crud.this_field_is_required">*</span>
                        </label>
                        <input onchange="cekSize()" type="file" name="file[]" title="File" required="" class="form-control" multiple="" accept="application/pdf">
                        <div class="help-block">File support pdf. Max size 50mb</div>
                    </div>
                </div><!-- /.box-body -->

                <div class="box-footer">
                    <div style="text-align: right">
                        @if(module()->canCreate() && module()->getData("button_add_more") && cb()->getCurrentMethod()=="getAdd")
                            <input type="submit" name="submit" value='{{ cbLang("save")." & ".cbLang("add")." ".cbLang("more") }}' class='btn btn-default'>
                        @endif

                        @if(cb()->getCurrentMethod()=="getAdd")
                            @if(module()->canCreate() && module()->getData("button_save"))
                                <input type="submit" name="submit" value='{{ cbLang("add")." ".cbLang("data") }}' class='btn btn-success'>
                            @endif
                        @endif
                    </div>
                </div><!-- /.box-footer-->
            </form>
        </div>
@endsection