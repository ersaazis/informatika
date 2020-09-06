<?php namespace App\Http\Controllers;

use ersaazis\cb\controllers\CBController;

class AdminSemuaDataPenelitianController extends CBController {


    public function cbInit()
    {
        $this->setTable("data_penelitian");
        $this->setPermalink("semua_data_penelitian");
        $this->setPageTitle("All Research Data");

        $this->addText("Title","judul")->filterable(true)->strLimit(150)->maxLength(255);
		$this->addText("Author","penulis")->filterable(true)->strLimit(150)->maxLength(255);
		$this->addText("Publish","publis")->filterable(true)->strLimit(150)->maxLength(255);
		$this->addText("Year","tahun")->filterable(true)->strLimit(150)->maxLength(255);
		$this->addText("Citation","titasi")->filterable(true)->strLimit(150)->maxLength(255);
		$this->addSelectTable("Lecturer","users_id",["table"=>"users","value_option"=>"id","display_option"=>"name","sql_condition"=>"users.cb_roles_id=2"])->filterable(true);
        $this->hookIndexQuery(function($query) {
            $query->orderBy('tahun', 'desc');
            return $query;
        });

    }
}
