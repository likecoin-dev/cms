<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableProducts extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('products', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
			$table->integer('author_id')->unsigned()->index();

			foreach (Pongo::forms('products') as $name => $config)
			{

				$options = array($name);
				
				if(is_numeric($config['len'])) array_push($options, $config['len']);
				
				if(is_array($config['len']))
				{
					foreach ($config['len'] as $value)
					{
						array_push($options, $value);
					}
				}

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
		Schema::drop('products');
	}

}
