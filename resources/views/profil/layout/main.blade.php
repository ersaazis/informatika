@extends('profil.layout.header')
    <main class="page landing-page">
        <section class="clean-block clean-hero" style="background-image: url('{{url('/')}}/assets/img/saintek.jpg');color: rgba(145,196,72,0.85);">
            <div class="text">
                <h2>Profil Dosen Informatika</h2>
                <p>Informasi profil dosen di Teknik Informatika Universitas Islam Negeri Sunan Gunung Djati Bandung.</p>
            </div>
        </section>
    </main>
    @yield('content')
@extends('profil.layout.footer')
