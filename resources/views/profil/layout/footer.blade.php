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
                <div class="modal-footer"><button class="btn btn-light" type="submit" data-dismiss="modal">Close</button><button class="btn btn-primary" type="button">Search</button></div>
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