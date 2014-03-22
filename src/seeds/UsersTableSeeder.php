<?php

use Pongo\Cms\Models\User;
use Pongo\Cms\Models\UserDetail;

class UsersTableSeeder extends Seeder {

	public function run()
	{
		// Reset table
		DB::table('users')->truncate();
		// Reset table
		DB::table('user_details')->truncate();

		$admin_account = Config::get('cms::settings.admin_account');

		$admin_settings = 	array(
								'role_id' 	=> 1,
								'lang' 		=> Config::get('cms::settings.language'),
								'editor'	=> 0,
								'is_valid' 	=> 1
							);

		$admin_user = array_merge($admin_account, $admin_settings);
		
		$admin_user['password'] = Hash::make($admin_user['password']);
		
		$admin = User::create($admin_user);

		UserDetail::create(array('user_id' => $admin->id));

		// RANDOM 50 USERS

		$user_account = Config::get('cms::settings.user_account');

		for($i=1; $i<=50; $i++) {

			$random = Str::random();

			$user_settings = 	array(
									'username'	=> $random,
									'lang' 		=> Config::get('cms::settings.language'),
									'editor'	=> 0,
									'is_valid' 	=> 1
								);

			$user_user = array_merge($user_account, $user_settings);

			$user_user['password'] = Hash::make($random);

			$user = User::create($user_user);

			UserDetail::create(array('user_id' => $user->id));

		}

	}

}
