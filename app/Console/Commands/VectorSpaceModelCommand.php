<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class VectorSpaceModelCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vsm';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Vector Space Model';

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
        $dokumen=DB::table('dokumen')->where('preprocess',1)->get();
        $d=count($dokumen);
        $table=DB::table('ir_tf')->select(['*',DB::raw('sum(ir_tf.tf) as df')])->groupBy('ir_token_id')->get();
        foreach($table as $item){
            DB::table('ir_token')->where('id',$item->ir_token_id)->update([
                'df'=>$item->df,
                'd_df'=>$d/$item->df,
                'idf'=>log10($d/$item->df),
            ]);
        }
        $table=DB::table('ir_tf')->get();
        foreach($table as $item){
            $idf=DB::table('ir_token')->find($item->ir_token_id)->idf;
            DB::table('ir_tf')->where('id',$item->id)->update([
                'w'=>$idf*$item->tf,
                'w2'=>pow($idf*$item->tf,2),
            ]);
        }
        $table=DB::table('ir_tf')->select(['*',DB::raw('sum(w2) as sqrt')])->groupBy('dokumen_id')->get();
        foreach($table as $item){
            DB::table('dokumen')->where('id',$item->dokumen_id)->update([
                'sqrt'=>sqrt($item->sqrt)
            ]);
        }
    }
}
