<?php

namespace App\Console\Commands;

use ersaazis\cb\helpers\CurlHelper;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Storage;

class SchollarSearch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'search:scholar {id} {id_user=0}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cari Penelitian Dosen';

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
            if($data->url_schollar && $data->id_schollar){
                $id_schollar=$data->id_schollar;
                $url=$data->url_schollar;
                goto scrapdata;
            }

            $url = "https://scholar.google.co.id/citations?view_op=search_authors&hl=id&mauthors=".urlencode($name);
            $request = new CurlHelper($url, "GET");
            $request->headers([
                "Accept"=>" */*",
                "Content-Type"=>" application/json",
                "Host"=>" scholar.google.co.id",
            ]);
            $body = $request->send();
            $cekUser=preg_match_all("/<div class=\"gsc_1usr\">(.*)<\/div>/U", $body, $user);
            if($cekUser){
                $cekId=preg_match("/;user=(.*)\"/U",$user[0][0],$cariId);
                if($cekId){
                    $id_schollar=$cariId[1];
                    $url = "https://scholar.google.co.id/citations?hl=id&user=".$id_schollar."&cstart=0&pagesize=999999999";
                    scrapdata:
                    $request = new CurlHelper($url, "GET");
                    $request->headers([
                        "Accept"=>" */*",
                        "Content-Type"=>" application/json",
                        "Host"=>" scholar.google.co.id",
                    ]);
                    $body = $request->send();
                    preg_match_all("/data-href=\"(.*)\" class=\"gsc_a_at\">(.*)<\/a><div class=\"gs_gray\">(.*)<\/div><div class=\"gs_gray\">(.*)<\/div><\/td><td class=\"gsc_a_c\"><a href=\"(.*)\" class=\"gsc_a_ac gs_ibl\">(.*)<\/a><\/td><td class=\"gsc_a_y\"><span class=\"gsc_a_h gsc_a_hc gs_ibl\">(.*)<\/span><\/td><\/tr>/U", $body, $karyaIlmiah);
                    // preg_match_all("/data-href=\"(.*)\" class=\"gsc_a_at\">(.*)<\/a><div class=\"gs_gray\">(.*)<\/div><div class=\"gs_gray\">(.*)<\/div>.*<span class=\"gsc_a_h gsc_a_hc gs_ibl\">(.*)<\/span>/U", $content, $karyaIlmiah);
                    // print_r($karyaIlmiah);
        
                    $this->info('Data Ditemukan !');
                    $i=0;
                    if($id_user != 0){
                        $urlFoto="https://scholar.google.com/citations?view_op=medium_photo&user=".$id_schollar;
                        $contents = file_get_contents($urlFoto);
                        Storage::disk('public')->put($id_schollar.".jpg", $contents);
                        $query->update([
                            'photo'=>'storage/'.$id_schollar.".jpg",
                            'url_schollar'=>$url,
                            'id_schollar'=>$id_schollar
                        ]);
                    }
                    while ($i < count($karyaIlmiah[1])) {
                        $signature=md5(json_encode([
                            $karyaIlmiah[1][$i],
                            $karyaIlmiah[2][$i],$karyaIlmiah[3][$i],
                            $karyaIlmiah[4][$i],$karyaIlmiah[5][$i],
                            $karyaIlmiah[6][$i],$karyaIlmiah[7][$i],
                        ]));
                        $check=DB::table('data_penelitian')->where('signature',$signature)->count();
                        if($check > 0){
                            $i++;
                            continue;
                        }
                        DB::table('data_penelitian')->insert([
                            'url'=>str_replace("&amp;", "&","https://scholar.google.co.id".$karyaIlmiah[1][$i]),
                            'judul'=>htmlspecialchars($karyaIlmiah[2][$i]),
                            'penulis'=>htmlspecialchars($karyaIlmiah[3][$i]),
                            'publis'=>htmlspecialchars(strip_tags($karyaIlmiah[4][$i])),
                            'url_titasi'=>$karyaIlmiah[5][$i],
                            'titasi'=>(int) $karyaIlmiah[6][$i],
                            'tahun'=>$karyaIlmiah[7][$i],
                            "signature"=>$signature,
                            "users_id"=>$id,
                        ]);
                        $i++;
                    }
                }
                $query->update(['proses_update'=>0]);
                $config['content'] = "(V) Berhasil Mendownload Data Schollar (".$name.')';
                $config['url'] = cb()->getAdminUrl('notification');
            }
            else {
                $this->error('Data Tidak Ditemukan !');
                $config['content'] = "(X) Mendownload Data Schollar Untuk ID $id Gagal (silakan input id schollar secara manual)";
                $config['url'] = cb()->getAdminUrl('notification');
            }
            if($id_user != 0){
                $config['users_id']=$id_user;
                cb()->addNotification($config);
            }
        }
    }
}
