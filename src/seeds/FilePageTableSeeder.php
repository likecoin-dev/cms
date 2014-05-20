<?php

class FilePageTableSeeder extends Seeder {

	public function run()
	{
		// Reset table
		DB::table('file_page')->truncate();

		/*for ($i = 1; $i <= 100; $i++) {

			DB::table('file_page')->insert(

				array(
					'file_id' => $i,
					'page_id' => rand(1, 8),
					'is_active'	=> 1
				)

			);

		}*/

	}

}
