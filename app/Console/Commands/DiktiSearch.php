<?php

namespace App\Console\Commands;

use ersaazis\cb\helpers\CurlHelper;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DiktiSearch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'search:dikti {id} {id_user=0}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cari Profil Dosen';

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
        $pt="Universitas Islam Negeri Sunan Gunung Djati";
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
            $myBody['nama'] = $name;
            $myBody['nip'] = "";
            $myBody['pt'] = $pt;
            $myBody['prodi'] = "";
            $url = "https://api-frontend.kemdikbud.go.id/search_dosen";
            $request = new CurlHelper($url, "POST");
            $request->headers(["Content-Type"=>"application/json"]);
            $request->data(json_encode($myBody));
            $body = $request->send();
            $content = json_decode($body, true)['dosen'];

            if(count($content) > 0){
                $id_dikti=$content[0]['id'];
                $url = "https://api-frontend.kemdikbud.go.id/detail_dosen/".$id_dikti;
                scrapdata:
                $request = new CurlHelper($url, "GET");
                $request->headers(["Content-Type"=>"application/json"]);
                $body = $request->send();
                $content = json_decode($body, true);
                unset($content['dataumum']['foto']);
                $this->info('Data Ditemukan !');
    
                foreach ($content['datamengajar'] as $value) {
                    $signature=md5(json_encode($value));
                    $check=DB::table('data_mengajar')->where(['users_id'=>$id,'signature'=>$signature])->count();
                    if($check > 0)
                        continue;
                    DB::table('data_mengajar')->insert([
                        "id_smt"=>$value['id_smt'],
                        "nm_kls"=>$value['nm_kls'],
                        "kode_mk"=>$value['kode_mk'],
                        "nm_mk"=>$value['nm_mk'],
                        "namapt"=>$value['namapt'],
                        "signature"=>$signature,
                        "users_id"=>$id
                    ]);
                }
                foreach ($content['datapendidikan'] as $value) {
                    $signature=md5(json_encode($value));
                    $check=DB::table('data_pendidikan')->where(['users_id'=>$id,'signature'=>$signature])->count();
                    if($check > 0)
                        continue;
                    DB::table('data_pendidikan')->insert([
                        "thn_lulus"=>$value['thn_lulus'],
                        "nm_sp_formal"=>$value['nm_sp_formal'],
                        "namajenjang"=>$value['namajenjang'],
                        "singkat_gelar"=>$value['singkat_gelar'],
                        "signature"=>$signature,
                        "users_id"=>$id,
                    ]);
                }
                if($id_user != 0)
                    $query->update([
                        "name"=>$content['dataumum']['nm_sdm'],
                        "jenis_kelamin"=>($content['dataumum']['jk'] == "L")?"Laki-Laki":"Perempuan",
                        "tmpt_lahir"=>$content['dataumum']['tmpt_lahir'],
                        "namapt"=>$content['dataumum']['namapt'],
                        "namaprodi"=>$content['dataumum']['namaprodi'],
                        "statuskeaktifan"=>$content['dataumum']['statuskeaktifan'],
                        "pend_tinggi"=>$content['dataumum']['pend_tinggi'],
                        "fungsional"=>$content['dataumum']['fungsional'],
                        "ikatankerja"=>$content['dataumum']['ikatankerja'],
                        "id_dikti"=>$id_dikti,
                        "url_dikti"=>$url,
                    ]);
                $config['content'] = "(V) Berhasil Mendownload Data Forlap (".$content['dataumum']['nm_sdm'].')';
                $config['url'] = cb()->getAdminUrl('notification');
            }
            else{
                $this->error('Data Tidak Ditemukan !');
                $config['content'] = "(X) Mendownload Data Forlap Untuk ID $id Gagal (silakan input id forlap secara manual)";
                $config['url'] = cb()->getAdminUrl('notification');
            }
            if($id_user != 0){
                $config['users_id']=$id_user;
                cb()->addNotification($config);
            }

        }
    }
}
