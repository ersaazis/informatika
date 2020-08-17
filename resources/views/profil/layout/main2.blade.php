@extends('profil.layout.header')
    <main class="page landing-page">
        <section class="clean-block clean-hero" style="background-image: url('{{url('/')}}/assets/img/saintek.jpg');color: rgba(145,196,72,0.85);">
            <div class="text">
                <h2>Profil Dosen Informatika</h2>
                <p>Informasi profil dosen di Teknik Informatika Universitas Islam Negeri Sunan Gunung Djati Bandung.</p>
            </div>
        </section>
    </main>
    <!-- Start: Article List -->
    <div class="article-list">
        <div class="container">
            <!-- Start: Articles -->
            <div class="row articles">
                <div class="col-sm-6 col-md-4 item"><a href="#"><img class="img-fluid" src="{{url('/')}}/assets/img/desk.jpg"></a>
                    <h3 class="name">Article Title</h3>
                    <p class="description">Aenean tortor est, vulputate quis leo in, vehicula rhoncus lacus. Praesent aliquam in tellus eu gravida. Aliquam varius finibus est, interdum justo suscipit id.</p><a class="action" href="#"><i class="fa fa-arrow-circle-right"></i></a></div>
                <div
                    class="col-sm-6 col-md-4 item"><a href="#"><img class="img-fluid" src="{{url('/')}}/assets/img/desk.jpg"></a>
                    <h3 class="name">Article Title</h3>
                    <p class="description">Aenean tortor est, vulputate quis leo in, vehicula rhoncus lacus. Praesent aliquam in tellus eu gravida. Aliquam varius finibus est, interdum justo suscipit id.</p><a class="action" href="#"><i class="fa fa-arrow-circle-right"></i></a></div>
            <div
                class="col-sm-6 col-md-4 item"><a href="#"><img class="img-fluid" src="{{url('/')}}/assets/img/desk.jpg"></a>
                <h3 class="name">Article Title</h3>
                <p class="description">Aenean tortor est, vulputate quis leo in, vehicula rhoncus lacus. Praesent aliquam in tellus eu gravida. Aliquam varius finibus est, interdum justo suscipit id.</p><a class="action" href="#"><i class="fa fa-arrow-circle-right"></i></a></div>
    </div>
    <!-- End: Articles -->
    </div>
    </div>
    <!-- End: Article List -->
@extends('profil.layout.footer')
