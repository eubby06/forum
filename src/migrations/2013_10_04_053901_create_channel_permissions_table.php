<?php

use Illuminate\Database\Migrations\Migration;

class CreateChannelPermissionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('channel_permissions', function($table)
		{
			$table->create();
			$table->integer('group_id')->default(0);
			$table->integer('channel_id')->default(0);
			$table->enum('can_view', array('0', '1'))->default(0);
			$table->enum('can_reply', array('0', '1'))->default(0);
			$table->enum('can_start', array('0', '1'))->default(0);
			$table->enum('can_moderate', array('0', '1'))->default(0);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('channel_permissions');
	}

}