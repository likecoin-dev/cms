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
			$table->integer('block_id')->unsigned()->index();
			$table->integer('page_id')->unsigned()->index();
			$table->string('zone', 10);
			$table->integer('order_id')->defaults(Config::get('cms::system.default_order'));
			$table->boolean('is_active');
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
