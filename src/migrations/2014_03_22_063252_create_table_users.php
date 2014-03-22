<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableUsers extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
			$table->integer('role_id')->unsigned();
			$table->string('username', 20);
			$table->string('email', 100);
			$table->string('password', 64);			
			$table->string('lang', 5);
			$table->string('editor', 20);
			$table->boolean('is_valid');
			$table->timestamps();
			$table->foreign('role_id')->references('id')->on('roles')->onDelete('CASCADE')->onUpdate('CASCADE');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');
	}

}