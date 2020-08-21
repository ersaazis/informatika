<?php namespace App\Http\Controllers;

use ersaazis\cb\controllers\CBController;
use Illuminate\Support\Facades\DB;

class AdminRekomendasiDokumenController extends CBController {


    public function cbInit()
    {
        $this->setTable("dokumen");
        $this->setPermalink("rekomendasi_dokumen");
        $this->setPageTitle("Rekomendasi Dokumen");

        $this->setButtonAdd(false);
        $this->setButtonDelete(false);
        $this->setButtonEdit(false);
        $this->setButtonDetail(false);

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

        $this->addIndexActionButton("Reset Data",cb()->getAdminUrl('rekomendasi_dokumen').'/reset','fa fa-refresh','danger');

        $this->hookIndexQuery(function($query) {
            $query->join('ir_dokumen_rekomendasi', 'dokumen.id', '=', 'ir_dokumen_rekomendasi.dokumen_id');
            $query->where("ir_dokumen_rekomendasi.users_id", cb()->session()->id() );
            $query->where("ir_dokumen_rekomendasi.remove", 0 );
            return $query;
        });

        $this->setHeadScript('<link rel="stylesheet" href="http://localhost:8000/cb_asset/js/bootstrap-toggle/bootstrap-toggle.min.css">');
        $this->setBottomView('dokumen.preview');

        $this->addActionButton(null, function($row) {
		    return url($row->file); 
        }, true, "fa fa-eye", 'primary preview', false);
        $this->addActionButton(null, function($row) {
		    return cb()->getAdminUrl('/rekomendasi_dokumen/hapus/'.$row->primary_key); 
        }, true, "fa fa-trash", 'danger', true);
    }
    public function hapusDokumen($id_dokumen){
        if(!module()->canCreate()) return cb()->redirect(cb()->getAdminUrl(),cbLang("you_dont_have_privilege_to_this_area"));
        $data=[
            'users_id'=>cb()->session()->id(),
            'dokumen_id'=>$id_dokumen
        ];
        DB::table('ir_dokumen_rekomendasi')->where($data)->update(['remove'=>1]);
        return cb()->redirectBack( cbLang("the_data_has_been_deleted"), 'success');
    }
    public function resetDokumen(){
        if(!module()->canCreate()) return cb()->redirect(cb()->getAdminUrl(),cbLang("you_dont_have_privilege_to_this_area"));
        $data=[
            'users_id'=>cb()->session()->id(),
        ];
        DB::table('ir_dokumen_rekomendasi')->where($data)->update(['remove'=>1]);
        return cb()->redirectBack( cbLang("the_data_has_been_deleted"), 'success');
    }
}
