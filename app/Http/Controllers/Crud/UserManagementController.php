<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 4/25/2019
 * Time: 9:28 PM
 */

namespace App\Http\Controllers\Crud;

use App\Jobs\SearchDosen;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use File;
use Illuminate\Support\Str;

class UserManagementController extends \ersaazis\usermanagement\controllers\UserManagementController
{
    public function getIndex() {
        if(!$this->myPrivileges()->can_browse) return cb()->redirect(cb()->getAdminUrl(),cbLang("you_dont_have_privilege_to_this_area"));
        $data = [];
        $data['result'] = DB::table("users")
            ->join("cb_roles","cb_roles.id","=","cb_roles_id")
            ->select("users.*","cb_roles.name as cb_roles_name")
            ->get();
        return view('dosen.usermanindex',$data);
    }

    public function postAddSave() {
        if(!$this->myPrivileges()->can_create) return cb()->redirect(cb()->getAdminUrl(),cbLang("you_dont_have_privilege_to_this_area"));
        try {
            cb()->validation(['name', 'email','password','cb_roles_id']);

            $user = [];
            $user['name'] = request('name');
            $user['email'] = request('email');
            $user['password'] = Hash::make(request('password'));
            $user['cb_roles_id'] = request('cb_roles_id');
            $id=DB::table('users')->insertGetId($user);
            if($user['cb_roles_id'] == 2)
                SearchDosen::dispatch($id,cb()->session()->id())->onConnection('database')->onQueue('dataDosen');
            return cb()->redirect(route("UserManagementControllerGetIndex"),"New user has been created!","success");

        } catch (CBValidationException $e) {
            return cb()->redirectBack($e->getMessage());
        }
    }

    public function getEdit($id) {
        if(!$this->myPrivileges()->can_update) return cb()->redirect(cb()->getAdminUrl(),cbLang("you_dont_have_privilege_to_this_area"));
        $data = [];
        $data['row'] = cb()->find("users", $id);
        $data['roles'] = DB::table("cb_roles")->get();
        return view("dosen.usermanedit", $data);
    }

    public function postEditSave($id) {
        if(!$this->myPrivileges()->can_update) return cb()->redirect(cb()->getAdminUrl(),cbLang("you_dont_have_privilege_to_this_area"));
        try {
            cb()->validation(['name', 'email','cb_roles_id']);

            $user = [];
            $user['name'] = request('name');
            $user['email'] = request('email');
            if(request('password')) $user['password'] = Hash::make(request('password'));
            $user['cb_roles_id'] = request('cb_roles_id');

            if($user['cb_roles_id'] == 2){
                $user['nip']=request('nip');
                $user['nidn']=request('nidn');
                $user['jenis_kelamin']=request('jenis_kelamin');
                $user['tanggal_lahir']=request('tanggal_lahir');
                $user['tmpt_lahir']=request('tmpt_lahir');
                $user['namapt']=request('namapt');
                $user['namaprodi']=request('namaprodi');
                $user['statuskeaktifan']=request('statuskeaktifan');
                $user['pend_tinggi']=request('pend_tinggi');
                $user['fungsional']=request('fungsional');
                $user['ikatankerja']=request('ikatankerja');
                $user['bidang_keahlian']=request('bidang_keahlian');
                $user['alamat']=request('alamat');
                $user['id_dikti']=request('id_dikti');
                $user['id_schollar']=request('id_schollar');
                $user['id_scopus']=request('id_scopus');
                $user['id_orchid']=request('id_orchid');
                $user['url_schollar']="https://scholar.google.co.id/citations?hl=id&user=".$user['id_schollar'];
                $user['url_dikti']="https://forlap.ristekdikti.go.id/dosen.detail/".$user['id_dikti'];
            }

            DB::table('users')->where('id',$id)->update($user);

            return cb()->redirect(route("UserManagementControllerGetIndex"),"The user has been updated!","success");

        } catch (CBValidationException $e) {
            return cb()->redirectBack($e->getMessage());
        }
    }
    public function import() {
        if(!$this->myPrivileges()->can_create) return cb()->redirect(cb()->getAdminUrl(),cbLang("you_dont_have_privilege_to_this_area"));
        return view('dosen.usermanimport');
    }
    public function importSave() {
        try {
            if(!$this->myPrivileges()->can_create) return cb()->redirect(cb()->getAdminUrl(),cbLang("you_dont_have_privilege_to_this_area"));
            if(!request('import')) return cb()->redirect(cb()->getAdminUrl(),cbLang("you_dont_have_privilege_to_this_area"));

            $import=request('import')->store('tmp');

            $dataRaw=file_get_contents($import);

            foreach(explode("\r\n",$dataRaw) as $key=>$item){
                if($key == 0)
                    continue;
                $dosen=explode(';',$item);
                if(!empty($dosen[0]) && !empty($dosen[1]) && !empty($dosen[2])){
                    if(DB::table('users')->where('email',$dosen[1])->count())
                        continue;
                        
                    $user=[];
                    $user['name']=mb_convert_encoding($dosen[0],'utf-8');
                    $user['email']=$dosen[1];
                    $user['password']=Hash::make($dosen[2]);
                    $user['cb_roles_id']=2;
                    $id=DB::table('users')->insertGetId($user);
                    if($id)
                        SearchDosen::dispatch($id,cb()->session()->id())->onConnection('database')->onQueue('dataDosen');
                }
            }
            File::deleteDirectory(public_path('tmp'));
            return cb()->redirect(route("UserManagementControllerGetIndex"),"Data berhasil di import !","success");
        } catch (CBValidationException $e) {
            return cb()->redirectBack($e->getMessage());
        }
    }
}