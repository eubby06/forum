<?php

use Illuminate\Database\Migrations\Migration;

class CreateNotificationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('notifications', function($table)
		{
			$table->create();
			$table->increments('id');
			$table->integer('user_id')->default(0);
			$table->text('message')->nullable();
			$table->string('sender_id')->default(0);
			$table->timestamp('created_at');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('notifications');
	}

}