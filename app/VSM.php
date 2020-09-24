<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Sastrawi\Stemmer\StemmerFactory;
use Sastrawi\StopWordRemover\StopWordRemoverFactory;
use Illuminate\Support\Str;

class VSM extends Model
{
    public function vsm(){
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
    public function search($text){
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
            if ($sqrtQ <= 0){
                $rank[$k]=0;
                continue;
            }
            $dokumen=DB::table('dokumen')->find($k);
            $rank[$k]=$v['sum']/($dokumen->sqrt*$sqrtQ);
            // echo $v['sum']." \n";
        }
        arsort($rank);
        return $rank;
    }
}
