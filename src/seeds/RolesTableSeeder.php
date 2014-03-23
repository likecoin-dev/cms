<?php

class RolesTableSeeder extends Seeder {

	public function run()
	{
		DB::statement('SET FOREIGN_KEY_CHECKS = 0'); // disable foreign key constraints

		// Reset table
		DB::table('roles')->truncate();

		$roles = Pongo::system('roles');

		foreach ($roles as $name => $level) {

			$role = array(
						'name' => $name,
						'level' => $level
					);

			DB::table('roles')->insert($role);

		}
		
		DB::statement('SET FOREIGN_KEY_CHECKS = 1'); // enable foreign key constraints
	}

}
