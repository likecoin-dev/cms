<?php

use Pongo\Cms\Models\File;
use Illuminate\Support\Facades\File as FileSystem;

class FilesTableSeeder extends Seeder {

	public function run()
	{
		DB::statement('SET FOREIGN_KEY_CHECKS = 0'); // disable foreign key constraints

		// Reset table
		DB::table('files')->truncate();

		// Delete /public/upload
		FileSystem::deleteDirectory(public_path('upload'));

		// Delete /app/storage/views/*.*
		foreach (FileSystem::files(storage_path().'/views') as $file)
		{
			if( $file != '.gitignore')
			{
				FileSystem::delete($file);
			}
		}

		// Faker data
		$faker = Faker\Factory::create();

		DB::statement('SET FOREIGN_KEY_CHECKS = 1'); // enable foreign key constraints
	}

}
