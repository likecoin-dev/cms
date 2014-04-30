<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableFiles extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('files', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
			$table->string('name', 100);
			$table->string('original', 100);
			$table->string('ext', 10);
			$table->integer('size');
			$table->integer('w');
			$table->integer('h');
			$table->string('path', 100);
			$table->boolean('is_image');
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
		Schema::drop('files');
	}

}