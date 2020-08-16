<?php
$head_script='<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">';
$bottom_view='dosen/usermanBottom';
?>
@extends(getThemePath("layout.layout"))
@section("content")


    <p>
        <a href="{{ route('UserManagementControllerGetIndex') }}"><i class="fa fa-arrow-left"></i> Back To List</a>
    </p>

    <div class="box box-default">
        <div class="box-header">
            <h1 class="box-title">Edit User</h1>
        </div>
        <form method="post" action="{{ cb()->getAdminUrl("users/edit-save/".$row->id) }}">
            {!! csrf_field() !!}
        <div class="box-body">
            <div class="form-group">
                <label for="">Name *</label>
                <input required type="text" value="{{ $row->name }}" placeholder="E.g : John Doe" name="name" class="form-control">
            </div>
            <div class="form-group">
                <label for="">Role *</label>
                <select name="cb_roles_id" id="cb_roles_id" required class="form-control">
                    <option value="">** Select a Role</option>
                    @foreach($roles as $role)
                        <option {{ ($row->cb_roles_id==$role->id)?"selected":"" }} value="{{ $role->id }}">{{ $role->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="">E-mail *</label>
                <input required type="email" value="{{ $row->email }}" placeholder="E.g : john@email.com" name="email" class="form-control">
            </div>
            <div class="form-group">
                <label for="">Password</label>
                <input type="password" placeholder="Kosongkan jika tidak diganti" name="password" class="form-control">
            </div>
            <div id="informasi_dosen"
            @if ($row->cb_roles_id != 2)
                style="display:none"
            @endif
            >
                <hr>
                <div class="form-group">
                        <label>Nip</label>
                        <input type="text" class="form-control" name="nip" id="nip" value="{{ $row->nip }}"  placeholder="Masukan Nip Anda">
                    </div>
                    <div class="form-group">
                        <label>Nidn</label>
                        <input type="text" class="form-control" name="nidn" id="nidn" value="{{ $row->nidn }}"  placeholder="Masukan Nidn Anda">
                    </div>
                    <div class="form-group">
                        <label>Jenis Kelamin</label>
                        <select name="jenis_kelamin" id="jenis_kelamin" class="form-control">
                            <option value="Laki-Laki"
                            @if ($row->jenis_kelamin == "Laki-Laki")
                                selected=""
                            @endif
                            >Laki-Laki</option>
                            <option value="Perempuan"
                            @if ($row->jenis_kelamin == "Perempuan")
                                selected=""
                            @endif
                            >Perempuan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Tanggal Lahir</label>
                        <input type="date" class="form-control" name="tanggal_lahir" id="tanggal_lahir" value="{{ $row->tanggal_lahir }}"  placeholder="Masukan Tanggal Lahir Anda">
                    </div>
                    <div class="form-group">
                        <label>Tempat Lahir</label>
                        <input type="text" class="form-control" name="tmpt_lahir" id="tmpt_lahir" value="{{ $row->tmpt_lahir }}"  placeholder="Masukan Tempat Lahir Anda">
                    </div>
                    <div class="form-group">
                        <label>Nama Perguruan Tinggi</label>
                        <input type="text" class="form-control" name="namapt" id="namapt" value="{{ $row->namapt }}"  placeholder="Masukan Nama Perguruan Tinggi Anda">
                    </div>
                    <div class="form-group">
                        <label>Nama Program Studi</label>
                        <input type="text" class="form-control" name="namaprodi" id="namaprodi" value="{{ $row->namaprodi }}"  placeholder="Masukan Nama Program Studi Anda">
                    </div>
                    <div class="form-group">
                        <label>Status Keaktifan</label>
                        <select name="statuskeaktifan" id="statuskeaktifan" class="form-control">
                            <option value="Tidak Aktif"
                            @if ($row->statuskeaktifan != "Aktif")
                                selected=""
                            @endif
                            >Tidak Aktif</option>
                            <option value="Aktif"
                            @if ($row->statuskeaktifan == "Aktif")
                                selected=""
                            @endif
                            >Aktif</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Pendidikan Tertinggi</label>
                        <input type="text" class="form-control" name="pend_tinggi" id="pend_tinggi" value="{{ $row->pend_tinggi }}"  placeholder="Masukan Pendidikan Tertinggi Anda">
                    </div>
                    <div class="form-group">
                        <label>Fungsional</label>
                        <input type="text" class="form-control" name="fungsional" id="fungsional" value="{{ $row->fungsional }}"  placeholder="Masukan Fungsional Anda">
                    </div>
                    <div class="form-group">
                        <label>Ikatan Kerja</label>
                        <input type="text" class="form-control" name="ikatankerja" id="ikatankerja" value="{{ $row->ikatankerja }}"  placeholder="Masukan Ikatan Kerja Anda">
                    </div>
                    <div class="form-group">
                        <label>Bidang Keahlian</label>
                        <input type="text" class="form-control" name="bidang_keahlian" id="bidang_keahlian" value="{{ $row->bidang_keahlian }}"  placeholder="Masukan Bidang Keahlian Anda">
                    </div>
                    <div class="form-group">
                        <label>Alamat</label>
                        <textarea name="alamat" id="alamat" class="form-control" rows="10" placeholder="Masukan Alamat Lengkap Anda">{{ $row->alamat }}</textarea>
                    </div>
                    <hr>
                    <div class="form-group">
                        <label>ID Dikti</label>
                        <input type="text" class="form-control" name="id_dikti" id="id_dikti" value="{{ $row->id_dikti }}"  placeholder="Masukan ID Dikti">
                        <span class="help-block">https://forlap.ristekdikti.go.id/dosen/detail/<b class="text-red">INPUTKODEINI</b></span>
                    </div>
                    <div class="form-group">
                        <label>ID Schollar</label>
                        <input type="text" class="form-control" name="id_schollar" id="id_schollar" value="{{ $row->id_schollar }}"  placeholder="Masukan ID Schollar">
                        <span class="help-block">https://scholar.google.co.id/citations?hl=id&user=<b class="text-red">INPUTKODEINI</b></span>
                    </div>
                    <div class="form-group">
                        <label>ID Scopus</label>
                        <input type="text" class="form-control" name="id_scopus" id="id_scopus" value="{{ $row->id_scopus }}"  placeholder="Masukan ID Scopus">
                        <span class="help-block">https://www.scopus.com/authid/detail.uri?authorId=<b class="text-red">INPUTKODEINI</b></span>
                    </div>
                    <div class="form-group">
                        <label>ID Orchid</label>
                        <input type="text" class="form-control" name="id_orchid" id="id_orchid" value="{{ $row->id_orchid }}"  placeholder="Masukan ID Orcid">
                        <span class="help-block">https://orcid.org/<b class="text-red">INPUTKODEINI</b></span>
                    </div>
            </div>
        </div>
        <div class="box-footer">
            <input type="submit" class="btn btn-success" value="Save User">
        </div>
        </form>
    </div>


@endsection