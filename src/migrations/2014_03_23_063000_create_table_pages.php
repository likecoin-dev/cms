<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePages extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('pages', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
			$table->integer('author_id')->unsigned()->index();
			$table->integer('parent_id')->defaults(0);
			$table->string('lang', 5);
			$table->string('name', 255);
			$table->string('slug', 255);
			$table->string('title', 255);
			$table->text('keyw');
			$table->text('descr');
			$table->string('template', 100);
			$table->string('header', 100);
			$table->string('layout', 100);
			$table->string('footer', 100);
			$table->integer('edit_level');
			$table->integer('view_access');
			$table->integer('view_level');
			$table->integer('order_id')->defaults(Config::get('cms::system.default_order'));
			$table->boolean('is_home');
			$table->boolean('is_active');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('pages');
	}

}
