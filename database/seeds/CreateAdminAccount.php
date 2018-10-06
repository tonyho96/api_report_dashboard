<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CreateAdminAccount extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
	public function run() {
		try {
			DB::beginTransaction();
			$defaultUser = User::where( 'name', '=', 'admin' )->first();
			if ( $defaultUser ) {
				$defaultUser->delete();
			}
			$defaultUserData = [
				'name'              => 'admin',
				'email'             => 'admin@admin.com',
				'password'          => bcrypt( '123456' ),
				'role'              => config( 'user.role.Admin' ),
				'time_zone'          => 'Asia/Ho_Chi_Minh',
				'mailchimp_api_key' => '',
                'last_sync' => date('Y-m-d H:i:s')
			];
			User::create( $defaultUserData );
			DB::commit();
			echo "Seeding user data has done.\n";
		} catch ( Exception $e ) {
			echo $e->getMessage();
			DB::rollback();
		}
	}
}
