<?php namespace App\Http\Controllers;

use ersaazis\cb\controllers\CBController;
use Illuminate\Support\Facades\DB;

class AdminDataPenelitianController extends CBController {


    public function cbInit()
    {
        $this->setTable("data_penelitian");
        $this->setPermalink("data_penelitian");
        $this->setPageTitle("Research data");

        $this->addText("Title","judul")->filterable(true)->strLimit(150)->maxLength(255);
		$this->addText("Author","penulis")->filterable(true)->strLimit(150)->maxLength(255);
		$this->addText("Publish","publis")->filterable(true)->strLimit(150)->maxLength(255);
		$this->addText("Year","tahun")->filterable(true)->strLimit(150)->maxLength(255);
		$this->addText("Url","url")->showIndex(false)->strLimit(150)->maxLength(255);
		$this->addText("Citation","titasi")->strLimit(150)->maxLength(255);
        $this->addText("Citation Url","url_titasi")->showIndex(false)->strLimit(150)->maxLength(255);
        $this->hookIndexQuery(function($query) {
            $query->where("users_id", cb()->session()->id());
            return $query;
        });
        $this->hookBeforeInsert(function($data) {
            $data['users_id'] = cb()->session()->id();
            $data['signature'] = md5(json_encode($data));
            return $data;
        });
        $this->hookBeforeUpdate(function($data, $id) {
            $validation=DB::table($this->__call('getData',['table']))->find($id);
            if($validation->users_id != cb()->session()->id()){
                header("location: ".cb()->getAdminUrl($this->__call('getData',['permalink'])));
                exit();
            }
            $data['users_id'] = cb()->session()->id();
            return $data;
        });
        $this->hookBeforeDelete(function($id) {
            $validation=DB::table($this->__call('getData',['table']))->find($id);
            if($validation->users_id != cb()->session()->id()){
                header("location: ".cb()->getAdminUrl($this->__call('getData',['permalink'])));
                exit();
            }
            return true;
        });
    }
}
