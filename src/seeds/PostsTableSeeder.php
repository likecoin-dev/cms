<?php

use Pongo\Cms\Models\Post;

class PostsTableSeeder extends Seeder {

	public function run()
	{
		DB::statement('SET FOREIGN_KEY_CHECKS = 0'); // disable foreign key constraints

		// Reset table
		DB::table('posts')->truncate();

		$faker = Faker\Factory::create();

		for ($i = 1; $i <= 30; $i++) { 
			
			$lang = ($i <= 15) ? 'en' : 'it';
			$title = $faker->sentence(7);

			$post = array(
				'author_id' => 1,
				'lang' => $lang,
				'datetime_on' => $faker->datetime(),
				'datetime_off' => $faker->datetime(),
				'title' => $title,
				'content' => $faker->text(500),
				'edit_level' => Config::get('cms::system.roles.editor'),
				'is_active' => 1
			);

			$new_post = Post::create($post);

			$new_post->seo()->create(
				array(
					'lang' => $faker->randomElement(array('en','it')),
					'title' => $title,
					'keyw' => implode(',', $faker->words),
					'descr' => $faker->text,
					'slug' => '/' . \Str::slug($title)
				)
			);

		}

		DB::statement('SET FOREIGN_KEY_CHECKS = 1'); // enable foreign key constraints
	}

}