<?php

use Pongo\Cms\Models\Seo;

class SeoTableSeeder extends Seeder {

	public function run()
	{
		DB::statement('SET FOREIGN_KEY_CHECKS = 0'); // disable foreign key constraints

		// Reset table
		DB::table('seo')->truncate();

		$seos = array(

			// EN pages

			array(
				'lang'	=> 'en',
				'title' => 'Title for home page',
				'slug' => '/home-page',				
				'seoable_id' => 1,
				'seoable_type' => 'Pongo\Cms\Models\Page'
			),

			array(
				'lang'	=> 'en',
				'title' => 'Title for test page 1',
				'slug' => '/test-page-1',
				'seoable_id' => 2,
				'seoable_type' => 'Pongo\Cms\Models\Page'
			),

			array(
				'lang'	=> 'en',
				'title' => 'Title for test page 2',
				'slug' => '/test-page-2',
				'seoable_id' => 3,
				'seoable_type' => 'Pongo\Cms\Models\Page'
			),

			array(
				'lang'	=> 'en',
				'title' => 'Title for test page 3',
				'slug' => '/test-page-1/a-custom-slug',				
				'seoable_id' => 4,
				'seoable_type' => 'Pongo\Cms\Models\Page'
			),

			// IT pages
			
			array(
				'lang'	=> 'it',
				'title' => 'Titolo per home page',
				'slug' => '/home-page',
				'seoable_id' => 5,
				'seoable_type' => 'Pongo\Cms\Models\Page'
			),

			array(
				'lang'	=> 'it',
				'title' => 'Titolo per pagina test 1',
				'slug' => '/pagina-test-1',
				'seoable_id' => 6,
				'seoable_type' => 'Pongo\Cms\Models\Page'
			),

			array(
				'lang'	=> 'it',
				'title' => 'Titolo per pagina test 2',
				'slug' => '/pagina-test-1/pagina-test-2',				
				'seoable_id' => 7,
				'seoable_type' => 'Pongo\Cms\Models\Page'
			),

			array(
				'lang'	=> 'it',
				'title' => 'Titolo per pagina test 3',
				'slug' => '/pagina-test-1/pagina-test-3',
				'seoable_id' => 8,
				'seoable_type' => 'Pongo\Cms\Models\Page'
			),

		);
		
		foreach ($seos as $seo) {

			Seo::create($seo);

		}

		DB::statement('SET FOREIGN_KEY_CHECKS = 1'); // enable foreign key constraints
	}

}
