<?php

use Illuminate\Database\Migrations\Migration;

class CreateBansTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('bans', function($table)
		{
			$table->create();
			$table->integer('user_id')->default(0);
			$table->integer('moderator_id')->default(0);
			$table->enum('unbanned', array('0', '1'))->default(0);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('bans');
	}

}