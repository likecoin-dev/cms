<?php

class BlockPageTableSeeder extends Seeder {

	public function run()
	{
		// Reset table
		DB::table('block_page')->truncate();

		$order_id = Pongo::system('default_order');

		DB::table('block_page')->insert(array(

			// En

			array('page_id' => 1, 'block_id' => 1, 'zone' => 'ZONE1', 'order_id' => $order_id, 'is_active' => 1),
			array('page_id' => 1, 'block_id' => 2, 'zone' => 'ZONE1', 'order_id' => $order_id, 'is_active' => 1),
			array('page_id' => 1, 'block_id' => 3, 'zone' => 'ZONE1', 'order_id' => $order_id, 'is_active' => 1),
			array('page_id' => 2, 'block_id' => 1, 'zone' => 'ZONE1', 'order_id' => $order_id, 'is_active' => 1),
			array('page_id' => 2, 'block_id' => 2, 'zone' => 'ZONE1', 'order_id' => $order_id, 'is_active' => 1),
			array('page_id' => 2, 'block_id' => 3, 'zone' => 'ZONE1', 'order_id' => $order_id, 'is_active' => 1),
			array('page_id' => 3, 'block_id' => 1, 'zone' => 'ZONE1', 'order_id' => $order_id, 'is_active' => 1),
			array('page_id' => 3, 'block_id' => 3, 'zone' => 'ZONE1', 'order_id' => $order_id, 'is_active' => 1),
			array('page_id' => 4, 'block_id' => 2, 'zone' => 'ZONE1', 'order_id' => $order_id, 'is_active' => 1),

			// It

			array('page_id' => 5, 'block_id' => 4, 'zone' => 'ZONE1', 'order_id' => $order_id, 'is_active' => 1),
			array('page_id' => 5, 'block_id' => 5, 'zone' => 'ZONE1', 'order_id' => $order_id, 'is_active' => 1),
			array('page_id' => 5, 'block_id' => 6, 'zone' => 'ZONE1', 'order_id' => $order_id, 'is_active' => 1),
			array('page_id' => 6, 'block_id' => 4, 'zone' => 'ZONE1', 'order_id' => $order_id, 'is_active' => 1),
			array('page_id' => 6, 'block_id' => 5, 'zone' => 'ZONE1', 'order_id' => $order_id, 'is_active' => 1),
			array('page_id' => 6, 'block_id' => 6, 'zone' => 'ZONE1', 'order_id' => $order_id, 'is_active' => 1),
			array('page_id' => 7, 'block_id' => 4, 'zone' => 'ZONE1', 'order_id' => $order_id, 'is_active' => 1),
			array('page_id' => 7, 'block_id' => 6, 'zone' => 'ZONE1', 'order_id' => $order_id, 'is_active' => 1),
			array('page_id' => 8, 'block_id' => 5, 'zone' => 'ZONE1', 'order_id' => $order_id, 'is_active' => 1),

		));

	}

}
