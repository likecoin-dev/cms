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
		
		$this->call('FilesTableSeeder');
		$this->call('FilePageTableSeeder');
		$this->call('RolesTableSeeder');
		$this->call('UsersTableSeeder');
		$this->call('SeoTableSeeder');
		$this->call('PagesTableSeeder');
		$this->call('BlocksTableSeeder');
		$this->call('BlockPageTableSeeder');
		$this->call('TagsTableSeeder');
		$this->call('TaggablesTableSeeder');
		$this->call('PostsTableSeeder');
		$this->call('ProductsTableSeeder');

		$this->command->info('PongoCMS seeded!');
	}

}