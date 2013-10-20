<?php

use Illuminate\Database\Migrations\Migration;

class CreateChannelSubscriptionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('channel_subscriptions', function($table)
		{
			$table->create();
			$table->integer('conversation_id')->default(0);
			$table->integer('user_id')->default(0);
			$table->timestamps();
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
		Schema::drop('channel_subscriptions');
	}

}