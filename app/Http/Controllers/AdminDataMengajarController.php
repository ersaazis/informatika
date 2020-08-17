<?php namespace App\Http\Controllers;

use ersaazis\cb\controllers\CBController;
use Illuminate\Support\Facades\DB;

class AdminDataMengajarController extends CBController {

    public function cbInit()
    {
        $this->setTable("data_mengajar");
        $this->setPermalink("data_mengajar");
        $this->setPageTitle("Data Mengajar");

        $this->addText("Semester","id_smt")->filterable(true)->strLimit(150)->maxLength(255);
		$this->addText("Nama Kelas","nm_kls")->filterable(true)->strLimit(150)->maxLength(255);
		$this->addText("Kode Matkul","kode_mk")->filterable(true)->strLimit(150)->maxLength(255);
		$this->addText("Nama Matkul","nm_mk")->filterable(true)->strLimit(150)->maxLength(255);
        $this->addText("Nama Perguruan Tinggi","namapt")->filterable(true)->strLimit(150)->maxLength(255);
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
