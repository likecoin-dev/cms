<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePosts extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('posts', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
			$table->integer('author_id')->unsigned()->index();
			$table->string('lang', 5);

			foreach (Pongo::forms('posts') as $name => $config)
			{
				$options = array($name);

				if(is_numeric($config['len'])) array_push($options, $config['len']); 

				call_user_func_array(array($table, $config['type']), $options);
			}

			$table->integer('edit_level');
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
		Schema::drop('posts');
	}

}
