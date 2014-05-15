<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTaggables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('taggables', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
			$table->integer('tag_id')->unsigned()->index();
			$table->integer('taggable_id')->unsigned()->index();
			$table->string('taggable_type', 255);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('taggables');
	}

}
