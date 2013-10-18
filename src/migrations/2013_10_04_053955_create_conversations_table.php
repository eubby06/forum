<?php

use Illuminate\Database\Migrations\Migration;

class CreateConversationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('conversations', function($table)
		{
			$table->create();
			$table->increments('id');
			$table->integer('user_id')->default(0);
			$table->integer('channel_id')->default(0);
			$table->string('title');
			$table->string('slug');
			$table->integer('posts_count')->default(0);
			$table->integer('views_count')->default(0);
			$table->integer('first_post_id')->default(0);
			$table->integer('last_post_id')->default(0);
			$table->integer('answer_post_id')->default(0);
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
		Schema::drop('conversations');
	}

}