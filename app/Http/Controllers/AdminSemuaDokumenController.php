<?php namespace App\Http\Controllers;

use App\Jobs\PreprocessingPDF;
use App\VSM;
use ersaazis\cb\controllers\CBController;
use ersaazis\cb\exceptions\CBValidationException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminSemuaDokumenController extends CBController {


    public function cbInit()
    {
        $this->setTable("dokumen");
        $this->setPermalink("semua_dokumen");
        $this->setPageTitle("All Documents");

        $this->setButtonDetail(false);
        $this->setButtonEdit(false);

        $this->addText("My Documents","name")->required(false)->showAdd(false)->showEdit(false)->strLimit(150)->maxLength(255);
		$this->addFile("File","file")->showIndex(false)->encrypt(true);
        $this->addSelectTable("Document Category","kategori_dokumen_id",["table"=>"kategori_dokumen","value_option"=>"id","display_option"=>"name","sql_condition"=>""])->filterable(true);
        $this->addText("Upload by","upload_by")->required(false)->showAdd(false)->showEdit(false)->strLimit(150)->maxLength(255);
        $this->hookBeforeDelete(function($id) {
            $dokumen=DB::table('dokumen')->find($id);
            Storage::delete($dokumen->file);
        });
        $this->hookIndexQuery(function($query) {
            $query->where("dokumen.private", 0 );
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
                    $data['users_id']=cb()->session()->id();
                    $data['upload_by']=cb()->session()->name();
                    $data['name']=$filename;
                    $data['file']=cb()->uploadFileProcess($filename, $ext, $file, true, null, null);
                    $id = DB::table($this->__call('getData',['table']))->insertGetId($data);
                    PreprocessingPDF::dispatch($id)->onConnection('database')->onQueue('dataDokumen');
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
}
