@extends('profil.layout.header')
    <main class="page landing-page">
        <section class="clean-block clean-hero" style="background-image: url('{{url('/')}}/assets/img/saintek.jpg');color: rgba(145,196,72,0.85);min-height:200px">
            <div class="text">
                <h2 style="margin: 0px;">{{$header}}</h2>
                <p><b>{{$subheader}}</b></p>
            </div>
        </section>
    </main>
    @yield('content')

@extends('profil.layout.footer')
