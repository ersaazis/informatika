<?php namespace App\Http\Controllers;

use ersaazis\cb\controllers\CBController;

class AdminSemuaDataPendidikanController extends CBController {


    public function cbInit()
    {
        $this->setTable("data_pendidikan");
        $this->setPermalink("semua_data_pendidikan");
        $this->setPageTitle("Semua Data Pendidikan");

        $this->addText("Tahun Lulus","thn_lulus")->filterable(true)->strLimit(150)->maxLength(255);
		$this->addText("Perguruan Tinggi","nm_sp_formal")->filterable(true)->strLimit(150)->maxLength(255);
		$this->addText("Jenjang","namajenjang")->filterable(true)->strLimit(150)->maxLength(255);
		$this->addText("Gelar","singkat_gelar")->filterable(true)->strLimit(150)->maxLength(255);
		$this->addSelectTable("Dosen","users_id",["table"=>"users","value_option"=>"id","display_option"=>"name","sql_condition"=>"users.cb_roles_id=2"])->filterable(true);
		

    }
}
