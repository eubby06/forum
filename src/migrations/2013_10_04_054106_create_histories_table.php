<?php

use Illuminate\Database\Migrations\Migration;

class CreateHistoriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('histories', function($table)
		{
			$table->create();
			$table->increments('id');
			$table->integer('user_id')->default(0);
			$table->string('historable_type');
			$table->integer('historable_id')->default(0);
			$table->string('message');
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
		Schema::drop('histories');
	}

}