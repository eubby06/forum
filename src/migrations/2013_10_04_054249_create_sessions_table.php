<?php

use Illuminate\Database\Migrations\Migration;

class CreateSessionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('sessions', function($table)
		{
			$table->create();
			$table->integer('user_id')->default(0);
			$table->string('active')->default(0);
			$table->string('ip_address')->default(0);
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
		Schema::drop('sessions');
	}

}