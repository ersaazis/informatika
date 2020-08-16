<?php namespace App\Http\Controllers\Crud;

use Illuminate\Support\Facades\DB;

class AdminProfileController extends \ersaazis\cb\controllers\AdminProfileController {
    public function getIndex() {
        $data = [];
        $data['page_title'] = cbLang("profile");
        if(cb()->session()->roleId() == 2)
            return view('dosen/profile',$data);
        else
            return view(getThemePath('profile'),$data);
    }
    
    public function postUpdate() {
        validator(request()->all(),[
            'name'=>'required|max:255|min:3',
            'email'=>'required|email',
            'photo'=>'image',
            'password'=>'confirmed'
        ]);

        try {
            $data = [];
            $data['name'] = request('name');
            $data['email'] = request('email');
            if(request('password')) {
                $data['password'] = Hash::make(request('password'));
            }
            if(request()->hasFile('photo')) {
                $data['photo'] = cb()->uploadFile('photo', true, 200, 200);
            }
            if(cb()->session()->roleId() == 2){
                $data['nip']=request('nip');
                $data['nidn']=request('nidn');
                $data['jenis_kelamin']=request('jenis_kelamin');
                $data['tanggal_lahir']=request('tanggal_lahir');
                $data['tmpt_lahir']=request('tmpt_lahir');
                $data['namapt']=request('namapt');
                $data['namaprodi']=request('namaprodi');
                $data['statuskeaktifan']=request('statuskeaktifan');
                $data['pend_tinggi']=request('pend_tinggi');
                $data['fungsional']=request('fungsional');
                $data['ikatankerja']=request('ikatankerja');
                $data['bidang_keahlian']=request('bidang_keahlian');
                $data['alamat']=request('alamat');
                $data['id_dikti']=request('id_dikti');
                $data['id_schollar']=request('id_schollar');
                $data['id_scopus']=request('id_scopus');
                $data['id_orchid']=request('id_orchid');
                $data['url_schollar']="https://scholar.google.co.id/citations?hl=id&user=".$data['id_schollar'];
                $data['url_dikti']="https://forlap.ristekdikti.go.id/dosen/detail/".$data['id_dikti'];
            }

            DB::table("users")->where("id", auth()->id())->update($data);
        }catch (\Exception $e) {
            Log::error($e);
            return cb()->redirectBack(cbLang("something_went_wrong"),"warning");
        }

        return cb()->redirectBack("The profile data has been updated!","success");
    }
}
