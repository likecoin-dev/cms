<?php

use Pongo\Cms\Models\Product;

class ProductsTableSeeder extends Seeder {

	public function run()
	{
		DB::statement('SET FOREIGN_KEY_CHECKS = 0'); // disable foreign key constraints

		// Reset table
		DB::table('products')->truncate();

		$faker = Faker\Factory::create();

		for ($i = 1; $i <= 30; $i++) { 
			
			$name = $faker->sentence(2);

			$product = array(
				'author_id' => 1,		
				'name' => $name,
				'content' => $faker->text(500),
				'price' => $faker->randomFloat(2, 0, 100),
				'edit_level' => Config::get('cms::system.roles.editor'),
				'is_active' => 1
			);

			$new_product = Product::create($product);

			$new_product->seo()->create(
				array(
					'lang' => $faker->randomElement(array('en','it')),
					'title' => $name,
					'keyw' => implode(',', $faker->words),
					'descr' => $faker->text,
					'slug' => '/' . \Str::slug($name)
				)
			);

		}

		DB::statement('SET FOREIGN_KEY_CHECKS = 1'); // enable foreign key constraints
	}

}