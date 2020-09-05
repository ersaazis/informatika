<?php namespace App\Http\Controllers;

use ersaazis\cb\controllers\CBController;

class AdminSemuaDataPendidikanController extends CBController {


    public function cbInit()
    {
        $this->setTable("data_pendidikan");
        $this->setPermalink("semua_data_pendidikan");
        $this->setPageTitle("All Educational Data");

        $this->addText("Graduation year","thn_lulus")->filterable(true)->strLimit(150)->maxLength(255);
		$this->addText("College","nm_sp_formal")->filterable(true)->strLimit(150)->maxLength(255);
		$this->addText("Level","namajenjang")->filterable(true)->strLimit(150)->maxLength(255);
		$this->addText("Degree","singkat_gelar")->filterable(true)->strLimit(150)->maxLength(255);
		$this->addSelectTable("Lecturer","users_id",["table"=>"users","value_option"=>"id","display_option"=>"name","sql_condition"=>"users.cb_roles_id=2"])->filterable(true);
		

    }
}
