@extends('profil.layout.main2')
@section('content')
    <div class="article-list">
        <div class="container">
            <div class="row articles">
            @php
            $x=4;
            $i=1;
            @endphp
            @foreach ($dosen as $item)
                <div class="col-sm-6 col-md-3 item">
                    <a href="{{url('/dosen/'.$item->id.'/'.Str::slug($item->name,'-'))}}">
                        @if ($item->photo)
                        <img class="img-fluid" src="{{url('/'.$item->photo)}}">
                        @else
                        <img class="img-fluid" src="http://placehold.it/192x256">
                        @endif
                    </a>
                    <h3 class="name">{{$item->name}}</h3>
                    <p class="description">NIP.{{$item->nip}} <br>NIDN.{{$item->nidn}}</p>
                    <a class="btn btn-sm btn-success mt-2" style="background: rgba(145,196,72,1);border:0" href="{{url('/dosen/'.$item->id.'/'.Str::slug($item->name,'-'))}}">Detail <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            @endforeach
            </div>
            {{$dosen->links()}}
        </div>
    </div>
@endsection