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
                <input type="password" placeholder="Empty if not replaced" name="password" class="form-control">
            </div>
            <div id="informasi_dosen"
            @if ($row->cb_roles_id != 2)
                style="display:none"
            @endif
            >
                <hr>
                <div class="form-group">
                    <label>NIP</label>
                    <input type="text" class="form-control" name="nip" id="nip" value="{{ $row->nip }}">
                </div>
                <div class="form-group">
                    <label>NIDN</label>
                    <input type="text" class="form-control" name="nidn" id="nidn" value="{{ $row->nidn }}">
                </div>
                <div class="form-group">
                    <label>Gender</label>
                    <select name="jenis_kelamin" id="jenis_kelamin" class="form-control">
                        <option value="Laki-Laki"
                        @if ($row->jenis_kelamin == "Laki-Laki")
                            selected=""
                        @endif
                        >Male</option>
                        <option value="Perempuan"
                        @if ($row->jenis_kelamin == "Perempuan")
                            selected=""
                        @endif
                        >Female</option>
                    </select>
                </div>
                {{-- <div class="form-group">
                    <label>Date of birth</label>
                    <input type="date" class="form-control" name="tanggal_lahir" id="tanggal_lahir" value="{{ $row->tanggal_lahir }}">
                </div> --}}
                <div class="form-group">
                    <label>Place of birth</label>
                    <input type="text" class="form-control" name="tmpt_lahir" id="tmpt_lahir" value="{{ $row->tmpt_lahir }}">
                </div>
                {{-- <div class="form-group">
                    <label>Nama Perguruan Tinggi</label>
                    <input type="text" class="form-control" name="namapt" id="namapt" value="{{ $row->namapt }}">
                </div>
                <div class="form-group">
                    <label>Nama Program Studi</label>
                    <input type="text" class="form-control" name="namaprodi" id="namaprodi" value="{{ $row->namaprodi }}">
                </div> --}}
                <div class="form-group">
                    <label>Active Status</label>
                    <select name="statuskeaktifan" id="statuskeaktifan" class="form-control">
                        <option value="Tidak Aktif"
                        @if ($row->statuskeaktifan != "Aktif")
                            selected=""
                        @endif
                        >Not Active</option>
                        <option value="Aktif"
                        @if ($row->statuskeaktifan == "Aktif")
                            selected=""
                        @endif
                        >Active</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Highest Education</label>
                    <input type="text" class="form-control" name="pend_tinggi" id="pend_tinggi" value="{{ $row->pend_tinggi }}">
                </div>
                <div class="form-group">
                    <label>Functional</label>
                    <input type="text" class="form-control" name="fungsional" id="fungsional" value="{{ $row->fungsional }}">
                </div>
                <div class="form-group">
                    <label>Work Bonds</label>
                    <input type="text" class="form-control" name="ikatankerja" id="ikatankerja" value="{{ $row->ikatankerja }}" >
                </div>
                <div class="form-group">
                    <label>Areas of expertise</label>
                    <input type="text" class="form-control" name="bidang_keahlian" id="bidang_keahlian" value="{{ $row->bidang_keahlian }}" >
                </div>
                <div class="form-group">
                    <label>Address</label>
                    <textarea name="alamat" id="alamat" class="form-control" rows="10"> </textarea>
                </div>
                <hr>
                <div class="form-group">
                    <label>ID Dikti</label>
                    <input type="text" class="form-control" name="id_dikti" id="id_dikti" value="{{ $row->id_dikti }}">
                    <span class="help-block">https://forlap.ristekdikti.go.id/dosen/detail/<b class="text-red">INPUT-THIS-CODE</b></span>
                </div>
                <div class="form-group">
                    <label>ID Scholar</label>
                    <input type="text" class="form-control" name="id_schollar" id="id_schollar" value="{{ $row->id_schollar }}">
                    <span class="help-block">https://scholar.google.co.id/citations?hl=id&user=<b class="text-red">INPUT-THIS-CODE</b></span>
                </div>
                <div class="form-group">
                    <label>ID Scopus</label>
                    <input type="text" class="form-control" name="id_scopus" id="id_scopus" value="{{ $row->id_scopus }}">
                    <span class="help-block">https://www.scopus.com/authid/detail.uri?authorId=<b class="text-red">INPUT-THIS-CODE</b></span>
                </div>
                <div class="form-group">
                    <label>ID Orchid</label>
                    <input type="text" class="form-control" name="id_orchid" id="id_orchid" value="{{ $row->id_orchid }}">
                    <span class="help-block">https://orcid.org/<b class="text-red">INPUT-THIS-CODE</b></span>
                </div>
            </div>
        </div>
        <div class="box-footer">
            <input type="submit" class="btn btn-success" value="Save User">
        </div>
        </form>
    </div>


@endsection