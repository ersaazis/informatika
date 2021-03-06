<?php

namespace App\Console\Commands;

use ersaazis\cb\helpers\CurlHelper;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DiktiSearchOldCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'search:diktiold {id} {id_user=0}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mencari Data Dikti Yang lama';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    private function getDosen($url,$id){
		$hasil=array(
			"profil"=>array(),
			"foto"=>"",
			"riwayat_pendidikan"=>array(),
			"riwayat_mengajar"=>array()
		);
        $request = new CurlHelper($url, "GET");
        $request->headers(["Accept"=>"application/json"]);
        $data=$request->send(0);
		//profil
        preg_match("/<table class='table1'>(.*?)<\/table>/si", $data, $profilALL);
		preg_match_all("/<td>(.*)<\/td>/U", $profilALL[1], $profil);
        
		//foto
		preg_match("/<img class='img-polaroid' src='(.*?)' \/>/si", $data, $foto);
		//pendidikan
		preg_match("/<div class='tab-pane' id='riwayatpendidikan'>.*?<table class='table table-bordered'>(.*?)<\/table>.*?<\/div>/si", $data, $riwayat_pendidikan);
		preg_match_all("/<tr class='tmiddle'>.*?<td class='tcenter'>.*?<\/td>.*?<td>(.*?)<\/td>.*?<td>(.*?)<\/td>.*?<td>(.*?)<\/td>.*?<td class='tcenter'>(.*?)<\/td>.*?<\/tr>/si", $riwayat_pendidikan[1], $riwayat_pendidikan);
		//mengajar
		preg_match("/<div class='tab-pane' id='riwayatmengajar'>.*?<table class=\"table table-bordered\">(.*?)<\/table>.*?<\/div>/si", $data, $riwayat_mengajar);
		preg_match_all('/<tr class="tmiddle">.*?<td class="tcenter">.*?<\/td>.*?<td>(.*?)<\/td>.*?<td>(.*?)<\/td>.*?<td>(.*?)<\/td>.*?<td>(.*?)<\/td>.*?<td>(.*?)<\/td>.*?<\/tr>/si', $riwayat_mengajar[1], $riwayat_mengajar);
		$hasil["profil"]=$profil[1];
		$hasil["foto"]=$foto[1];
		for($i=0;$i<count($riwayat_pendidikan[1]);$i++){
			$hasil["riwayat_pendidikan"][]=array(
				'dosen_id'=>$id,
				'perguruan_tinggi'=>$riwayat_pendidikan[1][$i],
				'gelar'=>$riwayat_pendidikan[2][$i],
				'tgl_ijazah'=>is_numeric($riwayat_pendidikan[3][$i])?$riwayat_pendidikan[3][$i]:0,
				'jenjang'=>$riwayat_pendidikan[4][$i]
			);
		}
		for($i=0;$i<count($riwayat_mengajar[1]);$i++){
			$hasil["riwayat_mengajar"][]=array(
				'dosen_id'=>$id,
				'semester'=>$riwayat_mengajar[1][$i],
				'kd_matkul'=>$riwayat_mengajar[2][$i],
				'nm_matkul'=>htmlspecialchars($riwayat_mengajar[3][$i]),
				'kd_kelas'=>$riwayat_mengajar[4][$i],
				'perguruan_tinggi'=>$riwayat_mengajar[5][$i]
			);
		}
		return $hasil;
    }
    public function handle()
    {
        $id = $this->argument('id');
        $id_user = $this->argument('id_user');
        $query=DB::table('users')->where('id',$id)->where(function ($query) {
            $query->where('cb_roles_id',2);
        });
        $data=$query->first();
        if(empty($data)){
            $this->error('User Tidak Ditemukan !');
            $config['content'] = "(X) Tidak dapat menemukan data user";
            $config['url'] = cb()->getAdminUrl('notification');
        }
        else {
            $name=$data->name;
            if($data->url_dikti && $data->id_dikti){
                $id_dikti=$data->id_dikti;
                $url=$data->url_dikti;
                goto scrapdata;
            }

            $url = "https://forlap.ristekdikti.go.id/dosen/search";
            $request = new CurlHelper($url, "POST");
            $request->headers(["Accept"=>"application/json"]);
            $request->cookie(true);
            $request->data([
                "captcha_value_1"=>"1",
                "captcha_value_2"=>"2",
                "dummy"=>"201004   Universitas Islam Negeri Sunan Gunung Djati",
                "id_sp"=>"1A7732DB-E0B5-47C9-AA8A-CDC9A392BF49",
                "keyword"=>$name,
                "kode_pengaman"=>"3"
            ]);
            $body = $request->send(0);
            $cekUser=preg_match_all("/<a href=\"https:\/\/forlap.ristekdikti.go.id\/dosen\/detail\/(.*)\">(.*)<\/a>/U", $body, $user);
            if($cekUser){
                $id_dikti=$user[1][0];
                $url="https://forlap.ristekdikti.go.id/dosen/detail/".$id_dikti;    
                scrapdata:
                $dataDosen=$this->getDosen($url,$id);
                foreach ($dataDosen['riwayat_mengajar'] as $value) {
                    $signature=md5(json_encode($value));
                    $check=DB::table('data_mengajar')->where(['users_id'=>$id,'signature'=>$signature])->count();
                    if($check > 0)
                        continue;
                    DB::table('data_mengajar')->insert([
                        "id_smt"=>$value['semester'],
                        "nm_kls"=>$value['kd_kelas'],
                        "kode_mk"=>$value['kd_matkul'],
                        "nm_mk"=>$value['nm_matkul'],
                        "namapt"=>$value['perguruan_tinggi'],
                        "signature"=>$signature,
                        "users_id"=>$id
                    ]);
                }
                foreach ($dataDosen['riwayat_pendidikan'] as $value) {
                    $signature=md5(json_encode($value));
                    $check=DB::table('data_pendidikan')->where(['users_id'=>$id,'signature'=>$signature])->count();
                    if($check > 0)
                        continue;
                    DB::table('data_pendidikan')->insert([
                        "thn_lulus"=>$value['tgl_ijazah'],
                        "nm_sp_formal"=>$value['perguruan_tinggi'],
                        "namajenjang"=>$value['jenjang'],
                        "singkat_gelar"=>$value['gelar'],
                        "signature"=>$signature,
                        "users_id"=>$id,
                    ]);
                }
                if($id_user != 0)
                    $query->update([
                        "name"=>ucwords( strtolower($dataDosen['profil'][0]) ),
                        "jenis_kelamin"=>$dataDosen['profil'][3],
                        "tmpt_lahir"=>NULL,
                        "namapt"=>$dataDosen['profil'][1],
                        "namaprodi"=>$dataDosen['profil'][2],
                        "statuskeaktifan"=>$dataDosen['profil'][7],
                        "pend_tinggi"=>$dataDosen['profil'][5],
                        "fungsional"=>$dataDosen['profil'][4],
                        "ikatankerja"=>$dataDosen['profil'][6],
                        "id_dikti"=>$id_dikti,
                        "url_dikti"=>$url
                    ]);
                $this->info('Data Ditemukan !');
                $config['content'] = "(V) Successfully Downloading Forlap Data (".$dataDosen['profil'][0].')';
                $config['url'] = cb()->getAdminUrl('notification');    
            }
            else {
                $this->error('Data Tidak Ditemukan !');
                $config['content'] = "(X) Downloading Forlap Data For ID $id Failed (please input forlap id manually)";
                $config['url'] = cb()->getAdminUrl('users/edit/'.$id);
            }
            if($id_user != 0){
                $config['users_id']=$id_user;
                cb()->addNotification($config);
            }
        }
    }
}