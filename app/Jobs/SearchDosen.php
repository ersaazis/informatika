<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Artisan;

class SearchDosen implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $id_user;
    protected $id_admin;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($id_user,$id_admin)
    {
        $this->id_user = $id_user;
        $this->id_admin = $id_admin;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Artisan::call('search:scholar', ['id' => $this->id_user,'id_user'=>$this->id_admin]);
        Artisan::call('search:diktiold', ['id' => $this->id_user,'id_user'=>$this->id_admin]);
    }
}
