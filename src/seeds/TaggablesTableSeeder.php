<?php

class TaggablesTableSeeder extends Seeder {

	public function run()
	{
		DB::statement('SET FOREIGN_KEY_CHECKS = 0'); // disable foreign key constraints

		// Reset table
		DB::table('taggables')->truncate();

		for ($i = 1; $i <= 50; $i++) { 
			
			$rand = ($i <= 25) ? rand(1, 4) : rand(5, 8);

			DB::table('taggables')->insert(

				array(
					'tag_id' => rand(1, 50),
					'taggable_id' => $rand,
					'taggable_type' => 'Pongo\Cms\Models\Page'
				)

			);

		}

		DB::statement('SET FOREIGN_KEY_CHECKS = 1'); // enable foreign key constraints
	}

}