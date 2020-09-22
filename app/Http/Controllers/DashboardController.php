<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use SixtyNine\Cloud\Builder\CloudBuilder;
use SixtyNine\Cloud\Builder\FiltersBuilder;
use SixtyNine\Cloud\Builder\WordsListBuilder;
use SixtyNine\Cloud\Factory\FontsFactory;
use SixtyNine\Cloud\Factory\PlacerFactory;
use SixtyNine\Cloud\Renderer\CloudRenderer;
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
    public function getWordCloud(){
        $filters = FiltersBuilder::create()
        ->setCase('lowercase')
        ->setRemoveNumbers(true)
        ->setRemoveTrailing(true)
        ->setRemoveUnwanted(true)
        ->setMinLength(5)
        ->setMaxLength(20)
        ->build();
        $words=DB::table('data_penelitian')->first(DB::raw('GROUP_CONCAT(judul SEPARATOR " ") as judul'))->judul;
        $list = WordsListBuilder::create()
        ->setFilters($filters)
        ->setMaxWords(100)
        ->importWords($words)
        ->build('Research');
        $factory = FontsFactory::create(public_path('assets/fonts/'));
        $fontSizeGenerator = new \SixtyNine\Cloud\FontSize\DimFontSizeGenerator();
        $cloud = CloudBuilder::create($factory)
        ->setBackgroundColor('#ffffff')
        ->setDimension(1024, 768)
        ->setFont('Ubuntu-Light.ttf')
        ->setSizeGenerator($fontSizeGenerator)
        ->setFontSizes(14, 64)
        ->setPlacer(PlacerFactory::PLACER_CIRCULAR)
        ->useList($list)
        ->build();
        $renderer = new CloudRenderer($cloud, $factory);
        $renderer->renderCloud();
        header("Content-Type: image/png");
        return response($renderer->getImage())->header('Content-type','image/png');
    }
}
