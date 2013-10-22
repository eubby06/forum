<?php

use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('settings', function($table)
		{
			$table->create();
			$table->increments('id');
			$table->string('title');
			$table->string('language')->default('en');
			$table->enum('home_page', array('show_conversation_list','show_channel_list'))->default('show_conversation_list');
			$table->enum('registration', array('close','open'))->default('open');
			$table->enum('member_privacy', array('members','everyone'))->default('everyone');
			$table->enum('editing_permission', array('forever','until_someone_reply'))->default('forever');
			$table->string('theme')->default('default');
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
		Schema::drop('settings');
	}

}