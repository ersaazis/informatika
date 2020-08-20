<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Sastrawi\Stemmer\StemmerFactory;
use Sastrawi\StopWordRemover\StopWordRemoverFactory;
use Illuminate\Support\Str;

class VSMSearch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vsm:search';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $text="Information Retrieval";

        // TOKENIZER
        $text=Str::lower($text);
        $text=str_replace('-',' ',$text);
        $text=preg_replace("/[^a-zA-Z]/", " ", $text);

        // STOP WORD REMOVER
        $stopWordRemoverFactory = new StopWordRemoverFactory();
        $stopword  = $stopWordRemoverFactory->createStopWordRemover();
        $text = $stopword->remove($text);

        // STEMMER
        $stemmerFactory = new StemmerFactory();
        $stemmer  = $stemmerFactory->createStemmer();
        $text = $stemmer->stem($text);

        // INDEXING
        $text = explode(' ',$text);
        $index=[];
        foreach ($text as $item)
            if(empty($index[$item]))
                $index[$item]=1;
            else
                $index[$item]++;
        
        $query=[];
        $queryDokumen=[];
        $sqrtQ=0;
        foreach ($index as $k=>$v){
            $cek=DB::table('ir_token')->where('token',$k)->first();
            if(!$cek)
                continue;

            $query[$k]['w']=$v*$cek->idf;
            $query[$k]['w2']=pow($v*$cek->idf,2);
            $sqrtQ+=$query[$k]['w2'];

            $dokumen=DB::table('ir_tf')
                ->where('ir_token_id',$cek->id)
                ->get();
            // print_r($dokumen);
            foreach($dokumen as $item){
                $queryDokumen[$item->dokumen_id][$k]=$item->w2*$query[$k]['w2'];
                if(empty($queryDokumen[$item->dokumen_id]['sum']))
                    $queryDokumen[$item->dokumen_id]['sum']=$queryDokumen[$item->dokumen_id][$k];
                else
                    $queryDokumen[$item->dokumen_id]['sum']+=$queryDokumen[$item->dokumen_id][$k];
            }
        }
        $rank=[];
        foreach($queryDokumen as $k=>$v){
            $dokumen=DB::table('dokumen')->find($k);
            $rank[$k]=$v['sum']/($dokumen->sqrt*$sqrtQ);
            // $rank[$k]=number_format($rank[$k],8);
        }
        arsort($rank);
        // RETURN
        print_r($rank);
        // print_r($query);        
    }
}
