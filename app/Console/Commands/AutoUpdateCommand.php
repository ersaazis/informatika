<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;

class AutoUpdateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'autoupdate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Auto Update Profil Dosen';

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
        $dosen=DB::table('users')->where('auto_update',1)->where(function ($query) {
            $query->where('cb_roles_id',2);
        })->get();
        foreach($dosen as $d){
            Artisan::call('search:scholar', ['id' => $d->id]);
            Artisan::call('search:diktiold', ['id' => $d->id]);
        }
    }
}
