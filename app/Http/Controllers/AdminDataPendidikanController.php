<?php namespace App\Http\Controllers;

use ersaazis\cb\controllers\CBController;
use Illuminate\Support\Facades\DB;

class AdminDataPendidikanController extends CBController {


    public function cbInit()
    {
        $this->setTable("data_pendidikan");
        $this->setPermalink("data_pendidikan");
        $this->setPageTitle("Education Data");

        $this->addText("Graduation year","thn_lulus")->filterable(true)->strLimit(150)->maxLength(255);
		$this->addText("College","nm_sp_formal")->filterable(true)->strLimit(150)->maxLength(255);
		$this->addText("Educational Stage","namajenjang")->filterable(true)->strLimit(150)->maxLength(255);
        $this->addText("Degree","singkat_gelar")->filterable(true)->strLimit(150)->maxLength(255);
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
