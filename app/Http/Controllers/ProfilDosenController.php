<?php

namespace App\Http\Controllers;

use App\Jobs\SearchDosen;
use ersaazis\cb\helpers\CurlHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProfilDosenController extends Controller
{
    private $showData=8;
    public function index(){
        $data = [];
        $data['page_title'] = "Informatics Engineering Department Profile - ".cb()->getAppName();
        $data['dosen']=DB::table('users')->where(function($q){
            $q->where('cb_roles_id',2)->orWhere('cb_roles_id',3)->orWhere('cb_roles_id',4);
        })->inRandomOrder()->limit($this->showData)->get();
        return view('profil.index', $data);
    }
    public function semuaDosen(){
        $data = [];
        $data['page_title'] = "Informatics Engineering Department Profile - ".cb()->getAppName();
        $data['header'] = "All Lecturers";
        $data['subheader'] = "Informatics Engineering Department";
        $data['dosen']=DB::table('users')->where(function($q){
            $q->where('cb_roles_id',2)->orWhere('cb_roles_id',3)->orWhere('cb_roles_id',4);
        })->paginate($this->showData);
        return view('profil.semuadosen', $data);
    }
    public function cariDosen(){
        $cari="%".str_replace(' ','%',request('cari'))."%";
        $data = [];
        $data['page_title'] = "Search Results for ".request('cari')." - ".cb()->getAppName();
        $data['header'] = "Find a Lecturer";
        $data['subheader'] = "Search Results for \"".request('cari').'"';
        $data['dosen']=DB::table('users')->where(function($q){
            $q->where('cb_roles_id',2)->orWhere('cb_roles_id',3)->orWhere('cb_roles_id',4);
        })->where(function ($query) use ($cari) {
            $query->orWhere('name','like',$cari);
            $query->orWhere('nip','like',$cari);
            $query->orWhere('nidn','like',$cari);
        })->paginate($this->showData);
        return view('profil.cari', $data);
    }
    public function profilDosen($id){
        $data = [];
        $data['page_title'] = "Profil - ".cb()->getAppName();
        $data['dosen']=DB::table('users')->find($id);
        $data['riwayat_pendidikan']=DB::table('data_pendidikan')->where('users_id',$id)->get();
        $data['riwayat_penelitian']=DB::table('data_penelitian')->where('users_id',$id)->get();
        $data['riwayat_mengajar']=DB::table('data_mengajar')->where('users_id',$id)->get();
        $data['header'] = $data['dosen']->name;
        $data['subheader'] = DB::table('cb_roles')->find($data['dosen']->cb_roles_id)->name;
        return view('profil.profil', $data);
    }
    public function resetDataDosen(){
        if(cb()->session()->id()){
            $id=cb()->session()->id();
            SearchDosen::dispatch($id,$id)->onConnection('database')->onQueue('dataDosen');
        }
        return cb()->redirect(cb()->getAdminUrl('profile'),'Your Data Reset Process is In Queue','success');
    }
    public function getTitasi($id){
        $data=DB::table('data_penelitian')->find($id);
        if($data){
            $url = $data->url;
            $request = new CurlHelper($url, "GET");
            $request->headers(["Content-Type"=>"application/json"]);
            $body = $request->send();
            return $body;   
        }
        return false;
    }
}
