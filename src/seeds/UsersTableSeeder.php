<?php

use Pongo\Cms\Models\User;
use Pongo\Cms\Models\UserDetail;

class UsersTableSeeder extends Seeder {

	public function run()
	{
		DB::statement('SET FOREIGN_KEY_CHECKS = 0'); // disable foreign key constraints

		// Reset table
		DB::table('users')->truncate();
		// Reset table
		DB::table('user_details')->truncate();

		$admin_account = Config::get('cms::settings.admin_account');

		$admin_settings = 	array(
								'role_id' 	=> 1,
								'lang' 		=> Config::get('cms::settings.language'),
								'editor'	=> 0,
								'is_active' => 1
							);

		$admin_user = array_merge($admin_account, $admin_settings);		
		$admin_user['password'] = Hash::make($admin_user['password']);
		
		$admin = User::create($admin_user);
		UserDetail::create(array('user_id' => $admin->id));

		// RANDOM 50 USERS

		// Faker data
		$faker = Faker\Factory::create();

		for($i=1; $i<=50; $i++) {

			$user_settings = 	array(
									'role_id'	=> 4,
									'username'	=> $faker->username,
									'email'		=> $faker->email,
									'password'	=> Hash::make($faker->word),
									'lang' 		=> Config::get('cms::settings.language'),
									'editor'	=> 0,
									'is_active' => 1
								);

			$user = User::create($user_settings);

			$details = array(
				'user_id' 		=> $user->id,
				'firstname'		=> $faker->firstname,
				'lastname'		=> $faker->lastname,
				'gender'		=> $faker->randomElement(array('m','f')),
				'city'			=> $faker->city,
				'bio'			=> $faker->text,
				'birth_date' 	=> $faker->date('Y-m-d', '-18 years')
			);

			UserDetail::create($details);
		}

		DB::statement('SET FOREIGN_KEY_CHECKS = 1'); // enable foreign key constraints
	}

}
