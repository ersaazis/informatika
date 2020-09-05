<?php namespace App\Http\Controllers;

use ersaazis\cb\controllers\CBController;

class AdminKategoriDokumenController extends CBController {


    public function cbInit()
    {
        $this->setTable("kategori_dokumen");
        $this->setPermalink("kategori_dokumen");
        $this->setPageTitle("Document Category");

        $this->addText("Name","name")->strLimit(150)->maxLength(255);
		

    }
}
