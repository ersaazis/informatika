<?php namespace App\Http\Controllers;

use ersaazis\cb\controllers\CBController;
use Illuminate\Support\Facades\DB;

class AdminCariDokumenController extends CBController {


    public function cbInit()
    {
        $this->setTable("dokumen");
        $this->setPermalink("cari_dokumen");
        $this->setPageTitle("Cari Dokumen");

        $this->setButtonDelete(false);
        $this->setButtonEdit(false);
        $this->setButtonDetail(false);
        $this->setButtonAdd(false);

        $this->addText("Nama Dokumen","name")->required(false)->showAdd(false)->showEdit(false)->strLimit(150)->maxLength(255);
		$this->addFile("File","file")->showIndex(false)->encrypt(true);
		$this->addSelectTable("Kategori Dokumen","kategori_dokumen_id",["table"=>"kategori_dokumen","value_option"=>"id","display_option"=>"name","sql_condition"=>""])->filterable(true);
        $this->addNumber('Dokumen Saya','id')->required(false)->showAdd(false)->showEdit(false)->indexDisplayTransform(function($row) {
            $data=[
                'users_id'=>cb()->session()->id(),
                'dokumen_id'=>$row
            ];
            $checked="";
            if((DB::table('dokumen_dosen')->where($data)->count()))
                $checked='checked';
            return '<center><input type="checkbox" data-toggle="toggle" value="'.$row.'" '.$checked.' class="dokumensaya" /></center>';
        }); 
        $this->addActionButton(null, function($row) {
		    return url($row->file); 
        }, true, "fa fa-eye", 'primary preview', false);
        $this->setHeadScript('<link rel="stylesheet" href="http://localhost:8000/cb_asset/js/bootstrap-toggle/bootstrap-toggle.min.css">');
        $this->setBottomView('dokumen.preview');
    }
    public function simpanDokumen($id_dokumen,$simpan){
        if(!module()->canCreate()) return cb()->redirect(cb()->getAdminUrl(),cbLang("you_dont_have_privilege_to_this_area"));
        $data=[
            'users_id'=>cb()->session()->id(),
            'dokumen_id'=>$id_dokumen
        ];
        if($simpan == 'true'){
            if(!(DB::table('dokumen_dosen')->where($data)->count()))
                DB::table('dokumen_dosen')->insert($data);
        }
        else
            DB::table('dokumen_dosen')->where($data)->delete();
    }
}
