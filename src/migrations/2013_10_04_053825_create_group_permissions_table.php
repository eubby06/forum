<?php

use Illuminate\Database\Migrations\Migration;

class CreateGroupPermissionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('group_permissions', function($table)
		{
			$table->create();
			$table->increments('id');
			$table->string('name');
			$table->string('value');
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
		Schema::drop('group_permissions');
	}

}