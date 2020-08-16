
<?php
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class CbMigrationSeeder extends Seeder
{
    public function run()
    {
        $this->command->info('Please wait updating the data...');                
        $this->call('CbMigrationData');        
        $this->command->info('Updating the data completed !');
    }
}
class CbMigrationData extends Seeder {
    public function run() {        
    	DB::table('cb_menus')->delete();
		DB::table('cb_menus')->insert([0=>['id'=>1,'name'=>'User Manajement','icon'=>'fa fa-users','path'=>'users','type'=>'path','sort_number'=>0,'cb_modules_id'=>NULL,'parent_cb_menus_id'=>NULL,'editable'=>0]]);
		DB::table('cb_role_privileges')->delete();
		DB::table('cb_role_privileges')->insert([0=>['id'=>1,'cb_roles_id'=>1,'cb_menus_id'=>1,'can_browse'=>1,'can_create'=>1,'can_read'=>1,'can_update'=>1,'can_delete'=>1],1=>['id'=>2,'cb_roles_id'=>2,'cb_menus_id'=>1,'can_browse'=>0,'can_create'=>0,'can_read'=>0,'can_update'=>0,'can_delete'=>0]]);
		DB::table('cb_roles')->delete();
		DB::table('cb_roles')->insert([0=>['id'=>1,'name'=>'Administrator'],1=>['id'=>2,'name'=>'Dosen']]);
		DB::table('migrations')->delete();
		DB::table('migrations')->insert([0=>['id'=>1,'migration'=>'2014_10_12_000000_create_users_table','batch'=>1],1=>['id'=>2,'migration'=>'2014_10_12_100000_create_password_resets_table','batch'=>1],2=>['id'=>3,'migration'=>'2016_08_07_152420_table_modules','batch'=>1],3=>['id'=>4,'migration'=>'2016_08_07_152420_table_roles','batch'=>1],4=>['id'=>5,'migration'=>'2016_08_07_152421_modify_users','batch'=>1],5=>['id'=>6,'migration'=>'2016_08_07_152421_table_menus','batch'=>1],6=>['id'=>7,'migration'=>'2016_08_07_152421_table_role_privileges','batch'=>1],7=>['id'=>8,'migration'=>'2019_10_06_182816_profil_dosen','batch'=>1],8=>['id'=>9,'migration'=>'2019_10_06_182950_data_mengajar','batch'=>1],9=>['id'=>10,'migration'=>'2019_10_06_183005_data_pendidikan','batch'=>1],10=>['id'=>12,'migration'=>'2019_10_07_074101_create_jobs_table','batch'=>1],11=>['id'=>13,'migration'=>'2019_10_07_074625_create_failed_jobs_table','batch'=>1],12=>['id'=>14,'migration'=>'2019_11_24_134333_programstudi','batch'=>1],13=>['id'=>15,'migration'=>'2020_02_17_130521_add_column_cb_menus','batch'=>1],14=>['id'=>17,'migration'=>'2016_08_07_152420_create_notifications','batch'=>2],15=>['id'=>18,'migration'=>'2019_10_06_183200_data_penelitian','batch'=>3]]);
		DB::table('users')->delete();
		DB::table('users')->insert([0=>['id'=>1,'name'=>'Ersa Azis Mansyur','email'=>'eam24maret@gmail.com','email_verified_at'=>NULL,'password'=>'$2y$10$kkcXzHFAiE6qJGjydLZfJuC4mKPOALtO38TAG/IC3aHaJvcq5c7Iq','remember_token'=>'FehUIcvu9cdwUu6tbwTlz04Y5DpGmKWGAlNqowGM5SOIpjtyflxsB7ap5Rs9','created_at'=>NULL,'updated_at'=>NULL,'photo'=>NULL,'cb_roles_id'=>1,'ip_address'=>'127.0.0.1','user_agent'=>'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.138 Safari/537.36','login_at'=>'2020-08-16 02:05:41','nip'=>NULL,'nidn'=>NULL,'jenis_kelamin'=>NULL,'tanggal_lahir'=>NULL,'tmpt_lahir'=>NULL,'namapt'=>NULL,'namaprodi'=>NULL,'statuskeaktifan'=>NULL,'pend_tinggi'=>NULL,'fungsional'=>NULL,'ikatankerja'=>NULL,'alamat'=>NULL,'bidang_keahlian'=>NULL,'url_schollar'=>NULL,'url_dikti'=>NULL,'id_dikti'=>NULL,'id_schollar'=>NULL,'id_scopus'=>NULL,'id_orchid'=>NULL,'programstudi_id'=>NULL,'proses_update'=>1,'auto_update'=>0]]);
    }
}
	