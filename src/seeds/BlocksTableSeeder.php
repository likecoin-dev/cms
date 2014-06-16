<?php

use Pongo\Cms\Models\Block;

class BlocksTableSeeder extends Seeder {

	public function run()
	{
		// Reset table
		DB::table('blocks')->truncate();

		$blocks = array(

			array(
				'id' => 1,
				'attrib' => 'element_1',
				'name' => 'Element name 1',
				'content' => 'Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Cras mattis consectetur purus sit amet fermentum. Donec sed odio dui. Maecenas faucibus mollis interdum.',
				// 'zone' => 'ZONE1',
				'author_id' => 1
			),

			array(
				'id' => 2,
				'attrib' => 'element_2',
				'name' => 'Element name 2',
				'content' => 'Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Cras mattis consectetur purus sit amet fermentum. Donec sed odio dui. Maecenas faucibus mollis interdum.',
				// 'zone' => 'ZONE1',
				'author_id' => 1
			),

			array(
				'id' => 3,
				'attrib' => 'element_3',
				'name' => 'Element name 3',
				'content' => 'Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Cras mattis consectetur purus sit amet fermentum. Donec sed odio dui. Maecenas faucibus mollis interdum.',
				// 'zone' => 'ZONE1',
				'author_id' => 1
			),

			array(
				'id' => 4,
				'attrib' => 'element_1_it',
				'name' => 'Nome elemento 1',
				'content' => 'Cras mattis consectetur purus sit amet fermentum. Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Curabitur blandit tempus porttitor. Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Nullam id dolor id nibh ultricies vehicula ut id elit. Nulla vitae elit libero, a pharetra augue.',
				// 'zone' => 'ZONE1',
				'author_id' => 1
			),

			array(
				'id' => 5,
				'attrib' => 'element_2_it',
				'name' => 'Nome elemento 2',
				'content' => 'Cras mattis consectetur purus sit amet fermentum. Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Curabitur blandit tempus porttitor. Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Nullam id dolor id nibh ultricies vehicula ut id elit. Nulla vitae elit libero, a pharetra augue.',
				// 'zone' => 'ZONE1',
				'author_id' => 1
			),

			array(
				'id' => 6,
				'attrib' => 'element_3_it',
				'name' => 'Nome elemento 3',
				'content' => 'Cras mattis consectetur purus sit amet fermentum. Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Curabitur blandit tempus porttitor. Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Nullam id dolor id nibh ultricies vehicula ut id elit. Nulla vitae elit libero, a pharetra augue.',
				// 'zone' => 'ZONE1',
				'author_id' => 1
			)

		);
		
		foreach ($blocks as $block) {

			// Create single pages
			Block::create($block);

		}

	}

}
