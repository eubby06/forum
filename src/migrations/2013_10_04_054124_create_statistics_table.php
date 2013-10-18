<?php

use Illuminate\Database\Migrations\Migration;

class CreateStatisticsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('statistics', function($table)
		{
			$table->create();
			$table->increments('id');
			$table->integer('user_id')->default(0);
			$table->integer('posts_count')->default(0);
			$table->integer('conversations_started_count')->default(0);
			$table->integer('conversations_participated_count')->default(0);
			$table->integer('first_post_id')->default(0);
			$table->timestamp('joined');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('statistics');
	}

}