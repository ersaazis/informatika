<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>{{$page_title}}</title>
    <meta property="og:type" content="website">
    <meta name="twitter:card" content="summary">
    <meta name="twitter:description" content="Information Department in Informatics Engineering, Sunan Gunung Djati State Islamic University, Bandung.">
    <meta property="og:image" content="assets/img/icon.png">
    <meta name="description" content="Information Department in Informatics Engineering, Sunan Gunung Djati State Islamic University, Bandung.">
    <meta name="twitter:title" content="Informatics Engineering Department Profile">
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
    @stack('head')
</head>

<body>
    <nav class="navbar navbar-light navbar-expand-lg fixed-top bg-white clean-navbar">
        <div class="container"><a class="navbar-brand logo" href="{{url('/')}}/">&nbsp;<img src="{{url('/')}}/assets/img/h4.png" width="200"></a><button data-toggle="collapse" class="navbar-toggler" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div
                class="collapse navbar-collapse" id="navcol-1">
                <ul class="nav navbar-nav ml-auto">
                    <li class="nav-item" role="presentation"><a class="nav-link" href="{{url('/')}}/">Home</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link" href="{{url('/semua-dosen')}}/">All Lecturers</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link" href="#caridosen" data-toggle="modal" data-target="#caridosen">Find a Lecturer</a></li>
                    @if (cb()->session()->id())
                    <li class="nav-item" role="presentation"><a class="nav-link" href="{{url('/admin')}}/">Admin</a></li>
                    @else
                    <li class="nav-item" role="presentation"><a class="nav-link" href="{{url('/admin/login')}}/">Login</a></li>
                    @endif
                </ul>
        </div>
        </div>
    </nav>

    @yield('header')

    <!-- Start: Footer Basic -->
    <div class="footer-basic" style="background-color: rgba(145,196,72,1);">
        <footer>
            <!-- Start: Links -->
            <ul class="list-inline" style="color: rgb(255,255,255);">
                <li class="list-inline-item"><a href="{{url('/')}}">Home</a></li>
                <li class="list-inline-item"><a href="https://uinsgd.ac.id">Website UIN Bandung</a></li>
                <li class="list-inline-item"><a href="https://if.uinsgd.ac.id/">Website Informatika</a></li>
            </ul>
            <!-- End: Links -->
            <!-- Start: Copyright -->
            <p class="copyright" style="color: rgb(255,255,255);">{{date('Y')}} &copy; <a class="text-light" target="_blank" href="https://digitalisasidata.com">Digitalisai Data</a></p>
            <!-- End: Copyright -->
        </footer>
    </div>
    <!-- End: Footer Basic -->
    <div class="modal fade" role="dialog" tabindex="-1" id="caridosen">
        <form action="{{url('cari')}}" method="GET">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Find a Lecturer</h4><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button></div>
                <div class="modal-body"><input type="search" name="cari" value="{{request('cari')}}" class="form-control" placeholder="Search By Name / NIP / NIDN"></div>
                <div class="modal-footer"><button class="btn btn-light" type="submit" data-dismiss="modal">Close</button><input class="btn btn-primary" type="submit" value="Search"></div>
            </div>
        </div>
        </form>
    </div>
    <script src="{{url('/')}}/assets/js/jquery.min.js"></script>
    <script src="{{url('/')}}/assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.10.0/baguetteBox.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
    <script src="{{url('/')}}/assets/js/smoothproducts.min.js"></script>
    <script src="{{url('/')}}/assets/js/theme.js"></script>
    @yield('script')
    @stack('bottom')
</body>

</html>