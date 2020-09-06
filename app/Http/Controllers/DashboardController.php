<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Event\ViewEvent;

class DashboardController extends Controller
{
    public function getIndex(){
        $data = [];
        $data['page_title'] = "Dashboard - ".cb()->getAppName();
        $data['tahun_awal_jurusan'] = $data['tahun_awal_dosen'] = date('Y')-5;
        $data['tahun_akhir_jurusan'] = $data['tahun_akhir_dosen'] = date('Y');
        return view('dashboard.main',$data);
    }
    public function getChartJurusan($tipe,$tahun_awal,$tahun_akhir){
        if($tahun_akhir == 0 && $tahun_awal == 0){
            $tahun_awal=DB::table('data_penelitian')->select(DB::raw('min(tahun) as tahun'))->where('tahun','!=','')->first()->tahun;
            $tahun_akhir=DB::table('data_penelitian')->select(DB::raw('max(tahun) as tahun'))->where('tahun','!=','')->first()->tahun;
        }
        $data=array();
        $data['labels']=range($tahun_awal,$tahun_akhir);
        foreach ($data['labels'] as $tahun){
            $cek=DB::table('data_penelitian')->select(DB::raw('sum(titasi) as kutipan,count(*) as dokumen'))->groupBy('tahun')->where('tahun',$tahun)->first();
            if(!$cek){
                $data['data']['quantity'][]=0;
            }
            else{
                if($tipe == "kutipan")
                    $data['data']['quantity'][]=(int) $cek->kutipan;
                else
                    $data['data']['quantity'][]=(int) $cek->dokumen;
            }
        }
        return json_encode($data);
    }
    public function getChartDosen($tipe,$tahun_awal,$tahun_akhir){
        if($tahun_akhir == 0 && $tahun_awal == 0){
            $tahun_awal=DB::table('data_penelitian')->select(DB::raw('min(tahun) as tahun'))->where('tahun','!=','')->where('users_id',cb()->session()->id())->first()->tahun;
            $tahun_akhir=DB::table('data_penelitian')->select(DB::raw('max(tahun) as tahun'))->where('tahun','!=','')->where('users_id',cb()->session()->id())->first()->tahun;
        }
        $data=array();
        $data['labels']=range($tahun_awal,$tahun_akhir);
        foreach ($data['labels'] as $tahun){
            $cek=DB::table('data_penelitian')->select(DB::raw('sum(titasi) as kutipan,count(*) as dokumen'))->groupBy('tahun')->where('tahun',$tahun)->where('users_id',cb()->session()->id())->first();
            if(!$cek){
                $data['data']['quantity'][]=0;
            }
            else{
                if($tipe == "kutipan")
                    $data['data']['quantity'][]=(int) $cek->kutipan;
                else
                    $data['data']['quantity'][]=(int) $cek->dokumen;
            }
        }
        return json_encode($data);
    }
}
