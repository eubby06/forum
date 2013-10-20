<?php

use Illuminate\Database\Migrations\Migration;

class CreateReadPostsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('read_posts', function($table)
		{
			$table->create();
			$table->integer('user_id')->default(0);
			$table->string('post_id')->default(0);
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
		Schema::drop('read_posts');
	}

}