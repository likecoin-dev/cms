<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableBlockPage extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('block_page', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
			$table->integer('block_id');
			$table->integer('page_id');
			$table->integer('order_id')->defaults(Config::get('cms::system.default_order'));
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('block_page');
	}

}
