<?php

namespace App\Console\Commands;

use App\VSM;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class RekomendasiDokumenCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'search:rekomendasi';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mencari Rekomendasi Dosen';

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
        $generate=DB::table('ir_config')->where(['key'=>'generated'])->first();
        $vsm=new VSM();
        if(!$generate->value){
            DB::table('ir_config')->where(['key'=>'generated'])->update(['value'=>1]);
            $vsm->vsm();
        }
        $dosen=DB::table('users')->where('cb_roles_id',2)->get();
        foreach($dosen as $item){
            $dokumen=$vsm->search($item->name);
            if(count($dokumen)){
                $notif=false;
                foreach($dokumen as $id=>$num){
                    $cek=DB::table('ir_dokumen_rekomendasi')->where('dokumen_id',$id)->count();
                    if(!$cek){
                        DB::table('ir_dokumen_rekomendasi')->insert([
                            'dokumen_id'=>$id,
                            'users_id'=>$item->id
                        ]);
                        $notif=true;
                    }
                }
                if($notif)
                    cb()->addNotification([
                        'users_id'=>$item->id,
                        'content'=>'Apakah dokumen ini milik anda?',
                        'url'=>cb()->getAdminUrl('rekomendasi_dokumen')
                    ]);
            }
        }
    }
}
