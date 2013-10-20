<?php

use Illuminate\Database\Migrations\Migration;

class CreateProfilesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('profiles', function($table)
		{
			$table->create();
			$table->increments('id');
			$table->integer('user_id')->default(0);
			$table->string('location')->nullable();
			$table->text('about')->nullable();
			$table->string('avatar')->nullable();
			$table->string('notifications')->nullable();
			$table->enum('privacy', array('0', '1'))->default(1);
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
		Schema::drop('profiles');
	}

}