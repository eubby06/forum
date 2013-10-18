<?php

use Illuminate\Database\Migrations\Migration;

class CreateConversationsSubscribersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('conversations_subscribers', function($table)
		{
			$table->create();
			$table->integer('conversation_id')->default(0);
			$table->integer('user_id')->default(0);
			$table->enum('type', array('follow','private'));
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('conversations_subscribers');
	}

}