<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfilDosenController extends Controller
{
    public function index(){
        $data = [];
        $data['page_title'] = "Profil Dosen Informatika - ".cb()->getAppName();
        return view('profil.index', $data);
    }
    public function cariDosen(){
        $cari=request('cari');
        $data = [];
        $data['page_title'] = "Hasil Pencarian untuk $cari - ".cb()->getAppName();
        return view('profil.cari', $data);
    }
    public function profilDosen(){
        $data = [];
        $data['page_title'] = "Profil - ".cb()->getAppName();
        return view('profil.profil', $data);
    }
}
