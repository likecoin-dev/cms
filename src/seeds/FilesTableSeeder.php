<?php

use Pongo\Cms\Models\File;

class FilesTableSeeder extends Seeder {

	public function run()
	{
		DB::statement('SET FOREIGN_KEY_CHECKS = 0'); // disable foreign key constraints

		// Reset table
		DB::table('files')->truncate();

		// Faker data
		$faker = Faker\Factory::create();

		for($i=1; $i<=50; $i++) {

			$image = array(
				'name' => $faker->imageUrl($width = 640, $height = 480),
				'original'	=> $faker->imageUrl($width = 640, $height = 480),
				'ext' => 'jpg',
				'size' => 125000,
				'w' => 640,
				'h' => 480,
				'path' => $faker->imageUrl($width = 640, $height = 480),
				'is_image' => 1,
				'is_active' => 1
			);

			File::create($image);

		}

		for($i=1; $i<=50; $i++) {

			$ext = $faker->fileExtension;
			$filename = $faker->word.'.'.$ext;

			$file = array(
				'name' => $filename,
				'original'	=> $filename,
				'ext' => $ext,
				'size' => 125000,
				'w' => '',
				'h' => '',
				'path' => '/tmp/'.$filename,
				'is_image' => 0,
				'is_active' => 1
			);

			File::create($file);

		}

		DB::statement('SET FOREIGN_KEY_CHECKS = 1'); // enable foreign key constraints
	}

}
