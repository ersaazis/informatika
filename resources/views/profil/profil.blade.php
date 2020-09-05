@extends('profil.layout.main2')
@section('content')
<div class="article-list p-3">
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col col-lg-3 col-md-3 col-12">
                @if ($dosen->photo)
                <img class="w-100" src="{{url('/'.$dosen->photo)}}">
                @else
                <img class="w-100" src="http://placehold.it/192x256">
                @endif

            </div>
            <div class="col col-md-6 col-lg-6 col-12">
                <p>NIP. {{$dosen->nip}}<br>NIDN. {{$dosen->nidn}}</p>
                <p><i class="fa fa-envelope"></i>&nbsp;Email : {{$dosen->email}}</p>
                <p>Areas of expertise : {{$dosen->bidang_keahlian}}</p>
                <a href="#detail" data-toggle="modal" data-target="#detail" target="_blank" class="btn btn-light btn-block btn-sm text-left border rounded">Detailed Profile</a>
                @if ($dosen->id_dikti)
                <a href="https://forlap.ristekdikti.go.id/dosen/detail/{{$dosen->id_dikti}}" target="_blank" class="btn btn-secondary btn-block btn-sm text-left border rounded">Forlap Dikti</a>
                @endif
                @if ($dosen->id_schollar)
                <a href="https://scholar.google.co.id/citations?hl=id&user={{$dosen->id_schollar}}" target="_blank" class="btn btn-secondary btn-block btn-sm text-left border rounded">Scholar</a>
                @endif
                @if ($dosen->id_scopus)
                <a href="https://scholar.google.co.id/citations?hl=id&user={{$dosen->id_scopus}}" target="_blank" class="btn btn-secondary btn-block btn-sm text-left border rounded">Scopus</a>
                @endif
                @if ($dosen->id_orchid)
                <a href="https://orcid.org/{{$dosen->id_orchid}}" target="_blank" class="btn btn-secondary btn-block btn-sm text-left border rounded">Orcid</a>
                @endif
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col col-md-9 col-lg-9 col-12">
                <div>
                    <ul class="nav nav-pills nav-fill mb-3">
                        <li class="nav-item"><a class="nav-link text-secondary" role="tab" data-toggle="pill" href="#tab-1" aria-selected="false">Educational History</a></li>
                        <li class="nav-item"><a class="nav-link text-secondary active" role="tab" data-toggle="pill" href="#tab-2" aria-selected="true">Teaching History</a></li>
                        <li class="nav-item"><a class="nav-link text-secondary" role="tab" data-toggle="pill" href="#tab-3" aria-selected="false">Research</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade" role="tabpanel" id="tab-1">
                            <table class="datatable table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>College</th>
                                        <th>Academic Degree</th>
                                        <th>Date of Diploma</th>
                                        <th>Educational Stage</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i=1;
                                    @endphp
                                    @foreach ($riwayat_pendidikan as $item)
                                    <tr>
                                        <td>{{$i++}}</td>
                                        <td>{{$item->nm_sp_formal}}</td>
                                        <td>{{$item->singkat_gelar}}</td>
                                        <td>{{$item->thn_lulus}}</td>
                                        <td>{{$item->namajenjang}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>No</th>
                                        <th>College</th>
                                        <th>Academic Degree</th>
                                        <th>Date of Diploma</th>
                                        <th>Educational Stage</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="tab-pane fade active show" role="tabpanel" id="tab-2">
                            <table class="datatable table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Semester</th>
                                        <th>Course Code</th>
                                        <th>Course Name</th>
                                        <th>Class</th>
                                        <th>College</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i=1;
                                    @endphp
                                    @foreach ($riwayat_mengajar as $item)
                                    <tr>
                                        <td>{{$i++}}</td>
                                        <td>{{$item->id_smt}}</td>
                                        <td>{{$item->kode_mk}}</td>
                                        <td>{{$item->nm_mk}}</td>
                                        <td>{{$item->nm_kls}}</td>
                                        <td>{{$item->namapt}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>No</th>
                                        <th>Semester</th>
                                        <th>Course Code</th>
                                        <th>Course Name</th>
                                        <th>Class</th>
                                        <th>College</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="tab-pane fade" role="tabpanel" id="tab-3">
                            <table class="datatable table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Title</th>
                                        <th>Citations</th>
                                        <th>Year</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i=1;
                                    @endphp
                                    @foreach ($riwayat_penelitian as $item)
                                    <tr>
                                        <td>{{$i++}}</td>
                                        <td><a href="{{$item->url}}" class="preview" data-id="{{$item->id}}" target="_blank">{!! htmlspecialchars_decode($item->judul) !!}</a><br><small>{{$item->penulis}} <br> {{$item->publis}}</small></td>
                                        <td><a href="{{$item->url}}" class="preview" data-id="{{$item->id}}" target="_blank">{{$item->titasi}}</a></td>
                                        <td>{{$item->tahun}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>No</th>
                                        <th>Title</th>
                                        <th>Citations</th>
                                        <th>Year</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" role="dialog" tabindex="-1" id="detail">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{$dosen->name}}</h4><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button></div>
            <div class="modal-body p-0">
                <table class="table">
                    <tr>
                        <th>NIP</th>
                        <td>{{$dosen->nip}}</td>
                    </tr>
                    <tr>
                        <th>NIDN</th>
                        <td>{{$dosen->nidn}}</td>
                    </tr>
                    <tr>
                        <th>Gender</th>
                        <td>{{$dosen->jenis_kelamin}}</td>
                    </tr>
                    <tr>
                        <th>Date of birth</th>
                        <td>{{$dosen->tanggal_lahir}}</td>
                    </tr>
                    <tr>
                    <tr>
                        <th>Place of birth</th>
                        <td>{{$dosen->tmpt_lahir}}</td>
                    </tr>
                    <tr>
                        <th>Active Status</th>
                        <td>{{$dosen->statuskeaktifan}}</td>
                    </tr>
                    <tr>
                        <th>Highest Education</th>
                        <td>{{$dosen->pend_tinggi}}</td>
                    </tr>
                    <tr>
                        <th>Functional</th>
                        <td>{{$dosen->fungsional}}</td>
                    </tr>
                    <tr>
                        <th>Work Bonds</th>
                        <td>{{$dosen->ikatankerja}}</td>
                    </tr>
                    <tr>
                        <th>Areas of Expertise</th>
                        <td>{{$dosen->bidang_keahlian}}</td>
                    </tr>
                    <tr>
                        <th colspan="2">Address</th>
                    </tr>
                    <tr>
                        <td colspan="2">{{$dosen->alamat}}</td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer"><button class="btn btn-light" type="button" data-dismiss="modal">Close</button></div>
        </div>
    </div>
</div>
<div class="modal fade" id="previewTitasi">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Document Preview</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
            <div id="dataHTMLTitasi">
                <center><div class="spinner-grow" role="status"><span class="sr-only">Loading...</span></div></center>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    $(document).ready(function() {
        $('.preview').click(function(e){
            var id = $(this).attr('data-id');
            $.get("{{url('/titasi-dosen')}}/"+id, function(data, status){
                $('#dataHTMLTitasi').html(data);
            });
            $('#previewTitasi').modal('show');
            return false;
        });
        $('#previewTitasi').on('hidden.bs.modal', function (e) {
            $('#dataHTMLTitasi').html('<center><div class="spinner-grow" role="status"><span class="sr-only">Loading...</span></div></center>');
        })

        $('.datatable').DataTable({
            "language":{
                "url" : "//cdn.datatables.net/plug-ins/1.10.9/i18n/Indonesian.json",
                "sEmptyTable":"Tidads"
            }
        });
    } );
</script>
@endsection
