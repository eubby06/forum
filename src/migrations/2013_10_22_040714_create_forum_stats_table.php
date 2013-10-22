<?php

use Illuminate\Database\Migrations\Migration;

class CreateForumStatsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('forum_stats', function($table)
		{
			$table->create();
			$table->increments('id');
			$table->integer('count_members');
			$table->integer('count_posts');
			$table->integer('count_conversations');
			$table->integer('count_channels');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('forum_stats');
	}

}