<?php namespace App\Http\Controllers;

use App\VSM;
use ersaazis\cb\controllers\CBController;
use ersaazis\cb\exceptions\CBValidationException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminDokumenSayaController extends CBController {


    public function cbInit()
    {
        $this->setTable("dokumen");
        $this->setPermalink("dokumen_saya");
        $this->setPageTitle("My Documents");

        $this->setButtonDelete(false);
        $this->setButtonEdit(false);
        $this->setButtonDetail(false);

        $this->addText("My Documents","name")->required(false)->showAdd(false)->showEdit(false)->strLimit(150)->maxLength(255);
		$this->addFile("File","file")->showIndex(false)->encrypt(true);
		$this->addSelectTable("Document Category","kategori_dokumen_id",["table"=>"kategori_dokumen","value_option"=>"id","display_option"=>"name","sql_condition"=>""])->filterable(true);
        $this->addText("Upload by","upload_by")->required(false)->showAdd(false)->showEdit(false)->strLimit(150)->maxLength(255);
        $this->addSelectOption("Private","private",[0,1])->showIndex(false);
        $this->addNumber('Private','id')->required(false)->showAdd(false)->showEdit(false)->indexDisplayTransform(function($row) {
            $cek=DB::table('dokumen')->where([
                'users_id'=>cb()->session()->id(),
                'id'=>$row
            ])->first();
            if($cek){
                $checked="";
                if($cek->private == 1)
                    $checked='checked';
                return '<center><input type="checkbox" data-toggle="toggle" value="'.$row.'" '.$checked.' class="private" /></center>';
            }
        }); 
        $this->setHeadScript('<link rel="stylesheet" href="'.url('/cb_asset/js/bootstrap-toggle/bootstrap-toggle.min.css').'">');
        
        $this->hookIndexQuery(function($query) {
            $query->join('dokumen_dosen', 'dokumen.id', '=', 'dokumen_dosen.dokumen_id');
            $query->where("dokumen_dosen.users_id", cb()->session()->id() );
            return $query;
        });

        $this->hookSearchQuery(function($query, $keyword) {
            $vsm=new VSM();
            $dokumen=$vsm->search($keyword);
            $query->where(function($q) use ($dokumen){
                foreach($dokumen as $id=>$val){
                    $q->orWhere('dokumen.id',$id);
                }
            });
            // dd($query->toSql());
            return $query;
        });

        $this->addActionButton(null, function($row) {
		    return url($row->file); 
        }, true, "fa fa-eye", 'primary preview', false);
        $this->setBottomView('dokumen.preview');

        $this->addActionButton(null, function($row) {
		    return cb()->getAdminUrl('/dokumen_saya/hapus/'.$row->primary_key); 
        }, true, "fa fa-trash", 'danger', true);
    }
    public function getAdd()
    {
        if(!module()->canCreate()) return cb()->redirect(cb()->getAdminUrl(),cbLang("you_dont_have_privilege_to_this_area"));

        $data = [];
        $data['page_title'] = $this->__call('getData',['page_title']).' : '.cbLang('add');
        $data['action_url'] = module()->addSaveURL();
        return view('dokumen.upload',$data);
    }

    public function postAddSave()
    {
        if(!module()->canCreate()) return cb()->redirect(cb()->getAdminUrl(),cbLang("you_dont_have_privilege_to_this_area"));

        try {
            if(Schema::hasColumn($this->__call('getData',['table']), 'created_at')) {
                $data['created_at'] = date('Y-m-d H:i:s');
            }
            if(Schema::hasColumn($this->__call('getData',['table']), 'updated_at')) {
                $data['updated_at'] = date('Y-m-d H:i:s');
            }
            $data['kategori_dokumen_id']=request('kategori_dokumen_id');

            foreach(request()->file('file') as $file){
                $filename = $file->getClientOriginalName();
                $ext = strtolower($file->getClientOriginalExtension());
                if($filename && $ext) {
                    $data['users_id']=cb()->session()->id();
                    $data['private']=request('private');
                    $data['upload_by']=cb()->session()->name();
                    $data['name']=$filename;
                    $data['file']=cb()->uploadFileProcess($filename, $ext, $file, true, null, null);
                    $id = DB::table($this->__call('getData',['table']))->insertGetId($data);
                    DB::table('dokumen_dosen')->insert(['users_id'=>cb()->session()->id(),'dokumen_id'=>$id]);
                }
            }
            DB::table('ir_config')->where(['key'=>'generated'])->update(['value'=>0]);
            
        } catch (CBValidationException $e) {
            Log::debug($e);
            return cb()->redirectBack($e->getMessage(),'info');
        } catch (\Exception $e) {
            Log::error($e);
            return cb()->redirectBack(cbLang("something_went_wrong"),'warning');
        }

        if (Str::contains(request("submit"),cbLang("more"))) {
            return cb()->redirectBack(cbLang("the_data_has_been_added"), 'success');
        } else {
            if(verifyReferalUrl()) {
                return cb()->redirect(getReferalUrl("url"), cbLang("the_data_has_been_added"), 'success');
            } else {
                return cb()->redirect(module()->url(), cbLang("the_data_has_been_added"), 'success');
            }
        }
    }

    public function hapusDokumen($id_dokumen){
        if(!module()->canCreate()) return cb()->redirect(cb()->getAdminUrl(),cbLang("you_dont_have_privilege_to_this_area"));
        $data=[
            'users_id'=>cb()->session()->id(),
            'dokumen_id'=>$id_dokumen
        ];
        DB::table('dokumen_dosen')->where($data)->delete();
        return cb()->redirectBack( cbLang("the_data_has_been_deleted"), 'success');
    }
    public function status($id,$jenis){
        if(!module()->canCreate()) return cb()->redirect(cb()->getAdminUrl(),cbLang("you_dont_have_privilege_to_this_area"));
        if($jenis == 'true'){
            $jenis=1;
        } else $jenis=0;
        DB::table('dokumen')->where(['id'=>$id,'users_id'=>cb()->session()->id()])->update(['private'=>$jenis]);
        return cb()->redirectBack( cbLang("the_data_has_been_updated"), 'success');
    }
}
