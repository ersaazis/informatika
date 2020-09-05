<?php namespace App\Http\Controllers;

use ersaazis\cb\controllers\CBController;

class AdminSemuaDataMengajarController extends CBController {


    public function cbInit()
    {
        $this->setTable("data_mengajar");
        $this->setPermalink("semua_data_mengajar");
        $this->setPageTitle("All Teaching Data");

        $this->addText("Semester","id_smt")->filterable(true)->strLimit(150)->maxLength(255);
		$this->addText("Class name","nm_kls")->filterable(true)->strLimit(150)->maxLength(255);
		$this->addText("Course Code","kode_mk")->filterable(true)->strLimit(150)->maxLength(255);
		$this->addText("Course Name","nm_mk")->filterable(true)->strLimit(150)->maxLength(255);
		$this->addText("Name of College","namapt")->filterable(true)->strLimit(150)->maxLength(255);
		$this->addSelectTable("Lecturer","users_id",["table"=>"users","value_option"=>"id","display_option"=>"name","sql_condition"=>"users.cb_roles_id=2"])->filterable(true);
		

    }
}
