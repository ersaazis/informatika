<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>{{$page_title}}</title>
    <meta property="og:type" content="website">
    <meta name="twitter:card" content="summary">
    <meta name="twitter:description" content="Informasi profil dosen di Teknik Informatika Universitas Islam Negeri Sunan Gunung Djati Bandung.">
    <meta property="og:image" content="assets/img/icon.png">
    <meta name="description" content="Informasi profil dosen di Teknik Informatika Universitas Islam Negeri Sunan Gunung Djati Bandung.">
    <meta name="twitter:title" content="Profile Dosen Jurusan Teknik Informatika">
    <link rel="icon" type="image/png" sizes="170x170" href="{{url('/')}}/assets/img/icon.png">
    <link rel="icon" type="image/png" sizes="170x170" href="{{url('/')}}/assets/img/icon.png">
    <link rel="icon" type="image/png" sizes="170x170" href="{{url('/')}}/assets/img/icon.png">
    <link rel="icon" type="image/png" sizes="170x170" href="{{url('/')}}/assets/img/icon.png">
    <link rel="icon" type="image/png" sizes="170x170" href="{{url('/')}}/assets/img/icon.png">
    <link rel="stylesheet" href="{{url('/')}}/assets/bootstrap/css/bootstrap.min.css">
    <link rel="manifest" href="{{url('/')}}/manifest.json">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,400i,700,700i,600,600i">
    <link rel="stylesheet" href="{{url('/')}}/assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="{{url('/')}}/assets/css/Article-List.css">
    <link rel="stylesheet" href="{{url('/')}}/assets/css/Footer-Basic.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.10.0/baguetteBox.min.css">
    <link rel="stylesheet" href="{{url('/')}}/assets/css/smoothproducts.css">
    <link rel="stylesheet" href="{{url('/')}}/assets/css/untitled.css">
</head>

<body>
    <nav class="navbar navbar-light navbar-expand-lg fixed-top bg-white clean-navbar">
        <div class="container"><a class="navbar-brand logo" href="{{url('/')}}/">&nbsp;<img src="{{url('/')}}/assets/img/h4.png" width="200"></a><button data-toggle="collapse" class="navbar-toggler" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div
                class="collapse navbar-collapse" id="navcol-1">
                <ul class="nav navbar-nav ml-auto">
                    <li class="nav-item" role="presentation"><a class="nav-link" href="{{url('/')}}/">Home</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link" href="{{url('/semua-dosen')}}/">Semua Dosen</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link" href="#caridosen" data-toggle="modal" data-target="#caridosen">CARI DOSEN</a></li>
                    @if (cb()->session()->id())
                    <li class="nav-item" role="presentation"><a class="nav-link" href="{{url('/admin')}}/">Admin</a></li>
                    @else
                    <li class="nav-item" role="presentation"><a class="nav-link" href="{{url('/admin/login')}}/">Login</a></li>
                    @endif
                </ul>
        </div>
        </div>
    </nav>
