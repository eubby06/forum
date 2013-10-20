<?php

use Illuminate\Database\Migrations\Migration;

class CreateModeratorsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('moderators', function($table)
		{
			$table->create();
			$table->increments('id');
			$table->integer('user_id')->default(0);
			$table->integer('channel_id')->default(0);
			$table->enum('active', array('0', '1'))->default(1);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('moderators');
	}

}