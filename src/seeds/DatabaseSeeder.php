<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		// Disable mass-assignment protection
		Eloquent::unguard();
		
		// $this->call('ElementsTableSeeder');
		// $this->call('ElementPageTableSeeder');
		// $this->call('FilesTableSeeder');
		// $this->call('FilePageTableSeeder');
		$this->call('RolesTableSeeder');
		$this->call('UsersTableSeeder');
		$this->call('PagesTableSeeder');	

		$this->command->info('PongoCMS seeded!');
	}

}