@extends('crud::themes.adminlte.layout.layout')
@section('content')

    <form enctype="multipart/form-data" method="post" action="{{ route('AdminProfileControllerPostUpdate') }}">
        {!! csrf_field() !!}
    <div class="row">
        <div class="col-sm-3">
            <div class="form-group">

                @if(auth()->user()->photo)
                    <p align="center">
                        <img src="{{ asset(auth()->user()->photo) }}" width="230px" class="img-thumbnail" alt="Photo">
                    </p>
                @endif

                <input type="file" class="form-control" accept="image/*" name="photo" id="photo">
                <div class="help-block">Support jpg and png extensions. Maximum size of 500 KB</div>
            </div>
        </div>
        <div class="col-sm-9">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h1 class="box-title">Profile Data</h1>
                </div>

                <div class="box-body">
                    <div class="form-group">
                        <label>Name *</label>
                        <input type="text" class="form-control" name="name" id="name" value="{{ auth()->user()->name }}" required placeholder="Enter your full name here">
                    </div>

                    <div class="form-group">
                        <label>E-mail *</label>
                        <input type="email" class="form-control" name="email" id="email" value="{{ auth()->user()->email }}" required placeholder="Enter a valid email here">
                    </div>

                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" class="form-control" placeholder="If you don't want to replace it, leave it blank" name="password" id="password">
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h1 class="box-title">Lecturer Information</h1>
                </div>

                <div class="box-body">
                    <div class="form-group">
                        <label>NIP</label>
                        <input type="text" class="form-control" name="nip" id="nip" value="{{ auth()->user()->nip }}">
                    </div>
                    <div class="form-group">
                        <label>NIDN</label>
                        <input type="text" class="form-control" name="nidn" id="nidn" value="{{ auth()->user()->nidn }}">
                    </div>
                    <div class="form-group">
                        <label>Gender</label>
                        <select name="jenis_kelamin" id="jenis_kelamin" class="form-control">
                            <option value="Laki-Laki"
                            @if (auth()->user()->jenis_kelamin == "Laki-Laki")
                                selected=""
                            @endif
                            >Male</option>
                            <option value="Perempuan"
                            @if (auth()->user()->jenis_kelamin == "Perempuan")
                                selected=""
                            @endif
                            >Female</option>
                        </select>
                    </div>
                    {{-- <div class="form-group">
                        <label>Date of birth</label>
                        <input type="date" class="form-control" name="tanggal_lahir" id="tanggal_lahir" value="{{ auth()->user()->tanggal_lahir }}">
                    </div> --}}
                    <div class="form-group">
                        <label>Place of birth</label>
                        <input type="text" class="form-control" name="tmpt_lahir" id="tmpt_lahir" value="{{ auth()->user()->tmpt_lahir }}">
                    </div>
                    {{-- <div class="form-group">
                        <label>Nama Perguruan Tinggi</label>
                        <input type="text" class="form-control" name="namapt" id="namapt" value="{{ auth()->user()->namapt }}"  placeholder="Masukan Nama Perguruan Tinggi Anda">
                    </div>
                    <div class="form-group">
                        <label>Nama Program Studi</label>
                        <input type="text" class="form-control" name="namaprodi" id="namaprodi" value="{{ auth()->user()->namaprodi }}"  placeholder="Masukan Nama Program Studi Anda">
                    </div> --}}
                    <div class="form-group">
                        <label>Active Status</label>
                        <select name="statuskeaktifan" id="statuskeaktifan" class="form-control">
                            <option value="Tidak Aktif"
                            @if (auth()->user()->statuskeaktifan != "Aktif")
                                selected=""
                            @endif
                            >Not Active</option>
                            <option value="Aktif"
                            @if (auth()->user()->statuskeaktifan == "Aktif")
                                selected=""
                            @endif
                            >Active</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Highest Education</label>
                        <input type="text" class="form-control" name="pend_tinggi" id="pend_tinggi" value="{{ auth()->user()->pend_tinggi }}">
                    </div>
                    <div class="form-group">
                        <label>Functional</label>
                        <input type="text" class="form-control" name="fungsional" id="fungsional" value="{{ auth()->user()->fungsional }}">
                    </div>
                    <div class="form-group">
                        <label>Work Bonds</label>
                        <input type="text" class="form-control" name="ikatankerja" id="ikatankerja" value="{{ auth()->user()->ikatankerja }}">
                    </div>
                    <div class="form-group">
                        <label>Areas of expertise</label>
                        <input type="text" class="form-control" name="bidang_keahlian" id="bidang_keahlian" value="{{ auth()->user()->bidang_keahlian }}">
                    </div>
                    <div class="form-group">
                        <label>Address</label>
                        <textarea name="alamat" id="alamat" class="form-control" rows="10">{{ auth()->user()->alamat }}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h1 class="box-title">Data Center</h1>
                </div>

                <div class="box-body">
                    <div class="form-group">
                        <label>ID Dikti</label>
                        <input type="text" class="form-control" name="id_dikti" id="id_dikti" value="{{ auth()->user()->id_dikti }}">
                        <span class="help-block">https://forlap.ristekdikti.go.id/dosen/detail/<b class="text-red">INPUT-THIS-CODE</b></span>
                    </div>
                    <div class="form-group">
                        <label>ID Scholar</label>
                        <input type="text" class="form-control" name="id_schollar" id="id_schollar" value="{{ auth()->user()->id_schollar }}">
                        <span class="help-block">https://scholar.google.co.id/citations?hl=id&user=<b class="text-red">INPUT-THIS-CODE</b></span>
                    </div>
                    <div class="form-group">
                        <label>ID Scopus</label>
                        <input type="text" class="form-control" name="id_scopus" id="id_scopus" value="{{ auth()->user()->id_scopus }}">
                        <span class="help-block">https://www.scopus.com/authid/detail.uri?authorId=<b class="text-red">INPUT-THIS-CODE</b></span>
                    </div>
                    <div class="form-group">
                        <label>ID Orcid</label>
                        <input type="text" class="form-control" name="id_orchid" id="id_orchid" value="{{ auth()->user()->id_orchid }}">
                        <span class="help-block">https://orcid.org/<b class="text-red">INPUT-THIS-CODE</b></span>
                    </div>
                </div>
                <div class="box-footer">
                    <div align="center">
                        <button class="btn btn-success" type="submit"><i class="fa fa-save"></i> {{ cbLang("update") }} {{ cbLang("profile") }}</button>
                        <a class="btn btn-danger" href="javascript:;" onclick="goToUrlWithConfirmation('{{cb()->getAdminUrl('/profile/resetdata')}}','Data anda akan direset berdasarkan ID yang tersimpan di PUSAT DATA')"><i class="fa fa-refresh"></i> Reset Data</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </form>

@endsection