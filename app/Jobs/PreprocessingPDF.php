<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Sastrawi\Stemmer\StemmerFactory;
use Sastrawi\StopWordRemover\StopWordRemoverFactory;
use Spatie\PdfToImage\Pdf;
use Spatie\PdfToText\Pdf as PdfToText;
use thiagoalessio\TesseractOCR\TesseractOCR;
use Illuminate\Support\Str;

class PreprocessingPDF implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $dokumen;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($id)
    {
        $this->dokumen=$id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $dokumen=DB::table('dokumen')->find($this->dokumen);
        $pdf=new Pdf(public_path($dokumen->file));

        // PDF TO TEXT
        $text = (new PdfToText())->setPdf(public_path($dokumen->file))->setOptions(['layout','r 300'])->text();
        // PDF TO TEXT (OCR)
        if(empty($text)){
            $tmpDir='tmp';
            Storage::makeDirectory($tmpDir);
            // PDF TO IMAGE
            $cek=$pdf->saveAllPagesAsImages(public_path($tmpDir));
            $text="";
            // IMAGE TO TEXT
            foreach ($cek as $item){
                $ocr = new TesseractOCR();
                $ocr->image($item);
                $text.=$ocr->run();
            }
            Storage::deleteDirectory($tmpDir);
        }
        
        $text.=" ".$dokumen->name;

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
        
        DB::table('dokumen')->where('id',$this->dokumen)->update(['string_dokumen'=>$text]);

        // INDEXING
        $text = explode(' ',$text);
        $index=[];
        foreach ($text as $item)
            if(empty($index[$item]))
                $index[$item]=1;
            else
                $index[$item]++;

        // SAVE TO DATABSE
        foreach($index as $key=>$value){
            $id=DB::table('ir_token')->where(['token'=>$key])->first();
            if($id) $id=$id->id;
            else $id=DB::table('ir_token')->insertGetId(['token'=>$key]);

            DB::table('ir_tf')->insert([
                'dokumen_id'=>$this->dokumen,
                'tf'=>$value,
                'ir_token_id'=>$id
            ]);
        }
        DB::table('dokumen')->where('id',$this->dokumen)->update(['preprocess'=>1]);
    }
}
