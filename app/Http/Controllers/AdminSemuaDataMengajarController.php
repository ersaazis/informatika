<?php namespace App\Http\Controllers;

use ersaazis\cb\controllers\CBController;

class AdminSemuaDataMengajarController extends CBController {


    public function cbInit()
    {
        $this->setTable("data_mengajar");
        $this->setPermalink("semua_data_mengajar");
        $this->setPageTitle("Semua Data Mengajar");

        $this->addText("Semester","id_smt")->filterable(true)->strLimit(150)->maxLength(255);
		$this->addText("Nama Kelas","nm_kls")->filterable(true)->strLimit(150)->maxLength(255);
		$this->addText("Kode Matkul","kode_mk")->filterable(true)->strLimit(150)->maxLength(255);
		$this->addText("Nama Matkul","nm_mk")->filterable(true)->strLimit(150)->maxLength(255);
		$this->addText("Nama Perguruan Tinggi","namapt")->filterable(true)->strLimit(150)->maxLength(255);
		$this->addSelectTable("Dosen","users_id",["table"=>"users","value_option"=>"id","display_option"=>"name","sql_condition"=>"users.cb_roles_id=2"])->filterable(true);
		

    }
}
