<?php

use Pongo\Cms\Models\Tag;

class TagsTableSeeder extends Seeder {

	public function run()
	{
		DB::statement('SET FOREIGN_KEY_CHECKS = 0'); // disable foreign key constraints

		// Reset table
		DB::table('tags')->truncate();

		$faker = Faker\Factory::create();

		for ($i = 1; $i <= 50; $i++) { 
			
			$lang = ($i <= 25) ? 'en' : 'it';
			$tag = array('lang' => $lang, 'name' => $faker->word);
			Tag::create($tag);

		}

		DB::statement('SET FOREIGN_KEY_CHECKS = 1'); // enable foreign key constraints
	}

}