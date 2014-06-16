<?php

use Pongo\Cms\Models\Page;

class PagesTableSeeder extends Seeder {

	public function run()
	{
		DB::statement('SET FOREIGN_KEY_CHECKS = 0'); // disable foreign key constraints

		// Reset table
		DB::table('pages')->truncate();

		$pages = array(

			// EN pages

			array(
				'id' => 1,
				'parent_id' => 0,
				'lang' => 'en',
				'name' => 'Home page',
				'template' => 'default',
				'header' => 'default',
				'layout' => 'default',
				'footer' => 'default',
				'author_id' => 1,
				'edit_level' => Config::get('cms::system.roles.editor'),
				'view_access' => 0,
				'view_level' => 0,
				'order_id' => Config::get('cms::system.default_order'),
				'is_home' => 1,
				'is_active' => 1
			),

			array(
				'id' => 2,
				'parent_id' => 0,
				'lang' => 'en',
				'name' => 'Test page 1',
				'template' => 'default',
				'header' => 'default',
				'layout' => 'default',
				'footer' => 'default',
				'author_id' => 1,
				'edit_level' => Config::get('cms::system.roles.editor'),
				'view_access' => 0,
				'view_level' => 0,
				'order_id' => Config::get('cms::system.default_order'),
				'is_home' => 0,
				'is_active' => 1
			),

			array(
				'id' => 3,
				'parent_id' => 0,
				'lang' => 'en',
				'name' => 'Test page 2',
				'template' => 'default',
				'header' => 'default',
				'layout' => 'default',
				'footer' => 'default',
				'author_id' => 1,
				'edit_level' => Config::get('cms::system.roles.editor'),
				'view_access' => 1,
				'view_level' => 0,
				'order_id' => Config::get('cms::system.default_order'),
				'is_home' => 0,
				'is_active' => 1
			),

			array(
				'id' => 4,
				'parent_id' => 2,
				'lang' => 'en',
				'name' => 'Test page 3',
				'template' => 'default',
				'header' => 'default',
				'layout' => 'default',
				'footer' => 'default',
				'author_id' => 1,
				'edit_level' => Config::get('cms::system.roles.editor'),
				'view_access' => 0,
				'view_level' => 0,
				'order_id' => Config::get('cms::system.default_order'),
				'is_home' => 0,
				'is_active' => 1
			),

			// IT pages
			
			array(
				'id' => 5,
				'parent_id' => 0,
				'lang' => 'it',
				'name' => 'Home page',
				'template' => 'default',
				'header' => 'default',
				'layout' => 'default',
				'footer' => 'default',
				'author_id' => 1,
				'edit_level' => Config::get('cms::system.roles.editor'),
				'view_access' => 0,
				'view_level' => 0,
				'order_id' => Config::get('cms::system.default_order'),
				'is_home' => 1,
				'is_active' => 1
			),

			array(
				'id' => 6,
				'parent_id' => 0,
				'lang' => 'it',
				'name' => 'Pagina test 1',
				'template' => 'default',
				'header' => 'default',
				'layout' => 'default',
				'footer' => 'default',
				'author_id' => 1,
				'edit_level' => Config::get('cms::system.roles.editor'),
				'view_access' => 1,
				'view_level' => 0,
				'order_id' => Config::get('cms::system.default_order'),
				'is_home' => 0,
				'is_active' => 1
			),

			array(
				'id' => 7,
				'parent_id' => 6,
				'lang' => 'it',
				'name' => 'Pagina test 2',
				'template' => 'default',
				'header' => 'default',
				'layout' => 'default',
				'footer' => 'default',
				'author_id' => 1,
				'edit_level' => Config::get('cms::system.roles.editor'),
				'view_access' => 0,
				'view_level' => 0,
				'order_id' => Config::get('cms::system.default_order'),
				'is_home' => 0,
				'is_active' => 1
			),

			array(
				'id' => 8,
				'parent_id' => 6,
				'lang' => 'it',
				'name' => 'Pagina test 3',
				'template' => 'default',
				'header' => 'default',
				'layout' => 'default',
				'footer' => 'default',
				'author_id' => 1,
				'edit_level' => Config::get('cms::system.roles.editor'),
				'view_access' => 0,
				'view_level' => 0,
				'order_id' => Config::get('cms::system.default_order'),
				'is_home' => 0,
				'is_active' => 1
			),

		);
		
		foreach ($pages as $page) {

		// 	// Create single pages
			Page::create($page);

		}

		DB::statement('SET FOREIGN_KEY_CHECKS = 1'); // enable foreign key constraints
	}

}
