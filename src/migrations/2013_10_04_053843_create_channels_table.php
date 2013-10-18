<?php

use Illuminate\Database\Migrations\Migration;

class CreateChannelsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('channels', function($table)
		{
			$table->create();
			$table->increments('id');
			$table->string('name');
			$table->string('slug');
			$table->text('description');
			$table->integer('posts_count')->default(0);
			$table->integer('conversations_count')->default(0);
			$table->integer('last_post_id')->default(0);
			$table->integer('display_position')->default(0);
			$table->enum('active', array('0', '1'))->default(1);
			$table->enum('subscribe_new_user', array('0', '1'))->default(0);
			$table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('channels');
	}

}