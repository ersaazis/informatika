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
                <div class="help-block">Support extensi jpg dan png. Ukuran maksimal 500 KB</div>
            </div>
        </div>
        <div class="col-sm-9">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h1 class="box-title">Profile Data</h1>
                </div>

                <div class="box-body">
                    <div class="form-group">
                        <label>Nama *</label>
                        <input type="text" class="form-control" name="name" id="name" value="{{ auth()->user()->name }}" required placeholder="Masukan nama lengkap disini">
                    </div>

                    <div class="form-group">
                        <label>E-mail *</label>
                        <input type="email" class="form-control" name="email" id="email" value="{{ auth()->user()->email }}" required placeholder="Masukan email valid disini">
                    </div>

                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" class="form-control" placeholder="Kosongkan jika tidak ingin diganti" name="password" id="password">
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h1 class="box-title">Informasi Dosen</h1>
                </div>

                <div class="box-body">
                    <div class="form-group">
                        <label>Nip</label>
                        <input type="text" class="form-control" name="nip" id="nip" value="{{ auth()->user()->nip }}"  placeholder="Masukan Nip Anda">
                    </div>
                    <div class="form-group">
                        <label>Nidn</label>
                        <input type="text" class="form-control" name="nidn" id="nidn" value="{{ auth()->user()->nidn }}"  placeholder="Masukan Nidn Anda">
                    </div>
                    <div class="form-group">
                        <label>Jenis Kelamin</label>
                        <select name="jenis_kelamin" id="jenis_kelamin" class="form-control">
                            <option value="Laki-Laki"
                            @if (auth()->user()->jenis_kelamin == "Laki-Laki")
                                selected=""
                            @endif
                            >Laki-Laki</option>
                            <option value="Perempuan"
                            @if (auth()->user()->jenis_kelamin == "Perempuan")
                                selected=""
                            @endif
                            >Perempuan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Tanggal Lahir</label>
                        <input type="date" class="form-control" name="tanggal_lahir" id="tanggal_lahir" value="{{ auth()->user()->tanggal_lahir }}"  placeholder="Masukan Tanggal Lahir Anda">
                    </div>
                    <div class="form-group">
                        <label>Tempat Lahir</label>
                        <input type="text" class="form-control" name="tmpt_lahir" id="tmpt_lahir" value="{{ auth()->user()->tmpt_lahir }}"  placeholder="Masukan Tempat Lahir Anda">
                    </div>
                    <div class="form-group">
                        <label>Nama Perguruan Tinggi</label>
                        <input type="text" class="form-control" name="namapt" id="namapt" value="{{ auth()->user()->namapt }}"  placeholder="Masukan Nama Perguruan Tinggi Anda">
                    </div>
                    <div class="form-group">
                        <label>Nama Program Studi</label>
                        <input type="text" class="form-control" name="namaprodi" id="namaprodi" value="{{ auth()->user()->namaprodi }}"  placeholder="Masukan Nama Program Studi Anda">
                    </div>
                    <div class="form-group">
                        <label>Status Keaktifan</label>
                        <select name="statuskeaktifan" id="statuskeaktifan" class="form-control">
                            <option value="Tidak Aktif"
                            @if (auth()->user()->statuskeaktifan != "Aktif")
                                selected=""
                            @endif
                            >Tidak Aktif</option>
                            <option value="Aktif"
                            @if (auth()->user()->statuskeaktifan == "Aktif")
                                selected=""
                            @endif
                            >Aktif</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Pendidikan Tertinggi</label>
                        <input type="text" class="form-control" name="pend_tinggi" id="pend_tinggi" value="{{ auth()->user()->pend_tinggi }}"  placeholder="Masukan Pendidikan Tertinggi Anda">
                    </div>
                    <div class="form-group">
                        <label>Fungsional</label>
                        <input type="text" class="form-control" name="fungsional" id="fungsional" value="{{ auth()->user()->fungsional }}"  placeholder="Masukan Fungsional Anda">
                    </div>
                    <div class="form-group">
                        <label>Ikatan Kerja</label>
                        <input type="text" class="form-control" name="ikatankerja" id="ikatankerja" value="{{ auth()->user()->ikatankerja }}"  placeholder="Masukan Ikatan Kerja Anda">
                    </div>
                    <div class="form-group">
                        <label>Bidang Keahlian</label>
                        <input type="text" class="form-control" name="bidang_keahlian" id="bidang_keahlian" value="{{ auth()->user()->bidang_keahlian }}"  placeholder="Masukan Bidang Keahlian Anda">
                    </div>
                    <div class="form-group">
                        <label>Alamat</label>
                        <textarea name="alamat" id="alamat" class="form-control" rows="10" placeholder="Masukan Alamat Lengkap Anda">{{ auth()->user()->alamat }}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h1 class="box-title">Pusat Data</h1>
                </div>

                <div class="box-body">
                    <div class="form-group">
                        <label>ID Dikti</label>
                        <input type="text" class="form-control" name="id_dikti" id="id_dikti" value="{{ auth()->user()->id_dikti }}"  placeholder="Masukan ID Dikti">
                        <span class="help-block">https://forlap.ristekdikti.go.id/dosen/detail/<b class="text-red">INPUTKODEINI</b></span>
                    </div>
                    <div class="form-group">
                        <label>ID Schollar</label>
                        <input type="text" class="form-control" name="id_schollar" id="id_schollar" value="{{ auth()->user()->id_schollar }}"  placeholder="Masukan ID Schollar">
                        <span class="help-block">https://scholar.google.co.id/citations?hl=id&user=<b class="text-red">INPUTKODEINI</b></span>
                    </div>
                    <div class="form-group">
                        <label>ID Scopus</label>
                        <input type="text" class="form-control" name="id_scopus" id="id_scopus" value="{{ auth()->user()->id_scopus }}"  placeholder="Masukan ID Scopus">
                        <span class="help-block">https://www.scopus.com/authid/detail.uri?authorId=<b class="text-red">INPUTKODEINI</b></span>
                    </div>
                    <div class="form-group">
                        <label>ID Orchid</label>
                        <input type="text" class="form-control" name="id_orchid" id="id_orchid" value="{{ auth()->user()->id_orchid }}"  placeholder="Masukan ID Orcid">
                        <span class="help-block">https://orcid.org/<b class="text-red">INPUTKODEINI</b></span>
                    </div>
                </div>
                <div class="box-footer">
                    <div align="center">
                        <button class="btn btn-success" type="submit"><i class="fa fa-save"></i> {{ cbLang("update") }} {{ cbLang("profile") }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </form>

@endsection